<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsuid'])==0) {
  header('location:logout.php');
} else{

if(isset($_POST['submit']))
{
    $uid=$_SESSION['bpmsuid'];
    $adate=$_POST['adate'];
    $atime=$_POST['atime'];
    $msg=$_POST['message'];
    $addressInput=$_POST['addressInput'];
    $appType=$_POST['appType'];
    $service=$_POST['service'];
    $aptnumber = mt_rand(100000000, 999999999);
  
    $query=mysqli_query($con,"insert into tblbook(UserID,AptNumber,AptDate,AptTime,Message,AppType,AddressInput,Service) value('$uid','$aptnumber','$adate','$atime','$msg','$appType','$addressInput','service')");

    if ($query) {
        $ret=mysqli_query($con,"select AptNumber from tblbook where tblbook.UserID='$uid' order by ID desc limit 1;");
        $result=mysqli_fetch_array($ret);
        $_SESSION['aptno']=$result['AptNumber'];
        echo "<script>window.location.href='thank-you.php'</script>";  
    }
    else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Love Yourself | Appointment Page</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCowKnkcevVPT5m1nwcisOJQ7Mo3gPGGUQ&libraries=places"></script>

</head>
  <body id="home">

    <?php include_once('includes/header.php');?>

    <script src="assets/js/jquery-3.3.1.min.js"></script> <!-- Common jquery plugin -->
    <!--bootstrap working-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- //bootstrap working-->
    <!-- disable body scroll which navbar is in active -->
    <script>
    $(function () {
      $('.navbar-toggler').click(function () {
        $('body').toggleClass('noscroll');
      })
    });
    </script>
    <!-- disable body scroll which navbar is in active -->

    <!-- breadcrumbs -->
    <section class="w3l-inner-banner-main">
        <div class="about-inner contact ">
            <div class="container">   
                <div class="main-titles-head text-center">
                    <h3 class="header-name">Book Appointment</h3>
                </div>
            </div>
        </div>

        <div class="breadcrumbs-sub">
            <div class="container">   
                <ul class="breadcrumbs-custom-path">
                    <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a></li>
                    <li class="active">Book Appointment</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- breadcrumbs //-->

    <section class="w3l-contact-info-main" id="contact">
        <div class="contact-sec">
            <div class="container">
                <div class="d-grid contact-view">
                    <div class="cont-details">
                        <?php
                        $ret=mysqli_query($con,"select * from tblpage where PageType='contactus' ");
                        $cnt=1;
                        while ($row=mysqli_fetch_array($ret)) {
                        ?>
                        <div class="cont-top">
                            <div class="cont-left text-center">
                                <span class="fa fa-phone text-primary"></span>
                            </div>
                            <div class="cont-right">
                                <h6>Call Us</h6>
                                <p class="para"><a href="tel:+44 99 555 42">+<?php  echo $row['MobileNumber'];?></a></p>
                            </div>
                        </div>
                        <div class="cont-top margin-up">
                            <div class="cont-left text-center">
                                <span class="fa fa-envelope-o text-primary"></span>
                            </div>
                            <div class="cont-right">
                                <h6>Email Us</h6>
                                <p class="para"><a href="mailto:example@mail.com" class="mail"><?php  echo $row['Email'];?></a></p>
                            </div>
                        </div>
                        <div class="cont-top margin-up">
                            <div class="cont-left text-center">
                                <span class="fa fa-map-marker text-primary"></span>
                            </div>
                            <div class="cont-right">
                                <h6>Address</h6>
                                <p class="para"> <?php  echo $row['PageDescription'];?></p>
                            </div>
                        </div>
                        <div class="cont-top margin-up">
                            <div class="cont-left text-center">
                                <span class="fa fa-map-marker text-primary"></span>
                            </div>
                            <div class="cont-right">
                                <h6>Time</h6>
                                <p class="para"> <?php  echo $row['Timing'];?></p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="map-content-9 mt-lg-0 mt-4">
                        <form method="post">
                        <div style="padding-top: 30px;">
                                <label>Appointment Type</label>
                                <select class="form-control" name="appType" id="appType" required>
                                    <option value="">Select Appointment Type</option>
                                    <option value="Home" >Home Appointment</option>
                                    <option value="In-Store" >Store Appointment</option>
                                </select>
                            </div>


                            <div style="padding-top: 30px;">
                                <label>Appointment Date</label>
                                <input type="date" class="form-control appointment_date" placeholder="Date" name="adate" id='adate' required="true">
                            </div>

                            <div style="padding-top: 30px;">
                                <label>Appointment Time</label>
                                <input type="time" class="form-control appointment_time" placeholder="Time" name="atime" id='atime' required="true">
                            </div>

                            <div style="padding-top: 30px; display: none;" id="address-field" >
                                <label>Enter Address</label>
                                <input  class="form-control" type="text" name="addressInput" id="addressInput" placeholder="Enter address">

                            </div>

                            
                            <div style="padding-top: 30px;">
                             <label>Select Service</label>
                                <select class="form-control" name="service" id="service" required>
                                <option value="">Select Service</option>
                                <?php
                                    $query = mysqli_query($con, "SELECT * FROM tblservices");
                                while ($row = mysqli_fetch_assoc($query)) {
                                echo '<option value="' . $row['ServiceID'] . '">' . $row['ServiceName'] . ' (R' . $row['Cost'] . ')</option>';
                                }
                                ?>
                            </select>
                            </div>
                                

                            <div style="padding-top: 30px;">
                                <label>Message</label>
                                <textarea class="form-control" id="message" name="message" placeholder="List the services you would like..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-contact" name="submit">Make An Appointment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
                            function initialize() {
                            var input = document.getElementById('addressInput');
                            var autocomplete = new google.maps.places.Autocomplete(input);
                            }
                          google.maps.event.addDomListener(window, 'load', initialize);
                  </script>
    </section>
    <!-- //contact -->

    

    <script>
       $(document).ready(function(){
   $('#appType').change(function(){
      var selectedOption = $(this).children("option:selected").val();
      if(selectedOption == 'Home'){
         $('#address-field').show();
      } else {
         $('#address-field').hide();
      }
   });
    });
    </script>


<?php include_once('includes/footer.php');?>

<!-- move top -->
<button onclick="topFunction()" id="movetop" title="Go to top">
	<span class="fa fa-long-arrow-up"></span>
</button>



<script>
	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function () {
		scrollFunction()
	};

	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			document.getElementById("movetop").style.display = "block";
		} else {
			document.getElementById("movetop").style.display = "none";
		}
	}

	// When the user clicks on the button, scroll to the top of the document
	function topFunction() {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	}
$(function(){
    var dtToday = new Date();
    
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();
    
    var maxDate = year + '-' + month + '-' + day;
    $('#adate').attr('min', maxDate);
});</script>
<!-- /move top -->
</body>

</html><?php } ?>