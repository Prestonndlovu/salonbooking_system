<?php
    session_start();
    error_reporting(0);
    include('includes/dbconnection.php'); //Database Connection


        if (isset($_POST['email']) && isset($_POST['contact_no'])) {
            $email=$_POST['email'];
            $contno=$_POST['contact_no'];
            $fname=$_POST['firstname'];
            $lname=$_POST['lastname'];
            $password=md5($_POST['password']);
    
            // Check if the username already exists
            $query = "SELECT * FROM clients WHERE email='$email'";

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                echo "<script>alert('User Already Exists ');</script>";
            } else {
                // Insert the new user into the database
                $query = "INSERT INTO clients (name,email,password,last_name,contact_no) VALUES ('$fname','$email','$password','$lname','$contno')";
                if ($conn->query($query) === TRUE) {
                    echo "<script>alert('Registration successful!');</script>";
                } else {
                    echo "Error: " . $query . "<br>" . $conn->error;
                }
            }
        }
   // }



       /* $fname=$_POST['firstname'];
        $lname=$_POST['lastname'];
        $contno=$_POST['mobilenumber'];
        $email=$_POST['email'];
        $password=md5($_POST['password']);
        

        $query = "select email from clients where email='$email' || contact_no='$contno'";
        $results= $conn->query($query);
        //$result=mysqli_fetch_array($ret);
        if($results->num_rows >0){
            echo "<script>alert('This email or Contact Number already associated with another account!.');</script>";
        }
        else{
            $query=mysqli_query($con, "insert into tbluser(FirstName, LastName, MobileNumber, Email, Password) value('$fname', '$lname','$contno', '$email', '$password' )");
        if ($query) {
            echo "<script>alert('You have successfully registered.');</script>";
        }
        else{
            echo "<script>alert('Something Went Wrong. Please try again.');</script>";
            }
        }
    }
    */

    
    $conn->close();
    
?>

<!DOCTYPE HTML>
<html lang="en">
  <head>
 
    <title>Love Yourself | Signup Page</title>

    <!--CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

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

<script type="text/javascript">
    function checkpass(){
        if(document.signup.password.value!=document.signup.repeatpassword.value)
        {
        alert('Password and Repeat Password field does not match');
        document.signup.repeatpassword.focus();
        return false;
        }
        return true;
    } 
</script>
<!-- disable body scroll which navbar is in active -->

<!-- breadcrumbs -->
<section class="w3l-inner-banner-main">
    <div class="about-inner contact ">
        <div class="container">   
            <div class="main-titles-head text-center">
            <h3 class="header-name ">Signup</h3>
            </div>
        </div>
    </div>

    <div class="breadcrumbs-sub">
        <div class="container">   
            <ul class="breadcrumbs-custom-path">
                <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
                <li class="active ">Signup</li>
            </ul>
        </div>
    </div>
    </div>
</section>

<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec	">
        <div class="container">
            <div class="d-grid contact-view">
                <div class="cont-details">
                    <?php
                  $ret=mysqli_query($conn,"select * from tblpage where PageType='contactus' ");
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
               <?php } ?> </div>
                <div class="map-content-9 mt-lg-0 mt-4">
                    <h3>Register with us!!</h3>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="signup">

                        <div style="padding-top: 30px;">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" required=""></div>
                           <div style="padding-top: 30px;">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" required="">
                        </div>
                        <div style="padding-top: 30px;">
                            <label>Mobile Number</label>
                           <input type="text" class="form-control" placeholder="Mobile Number" required="" name="contact_no" pattern="[0-9]+" maxlength="10"></div>
                           <div style="padding-top: 30px;">
                            <label>Email address</label>
                            <input type="email" class="form-control" class="form-control" placeholder="Email address" required="" name="email">
                        </div>
                         <div style="padding-top: 30px;">
                            <label>Password</label>
                           <input type="password" class="form-control" name="password" placeholder="Password" required="true">
                       </div>
                       <div style="padding-top: 30px;">
                        <label>Repeat password</label>
                            <input type="password" class="form-control" name="repeatpassword" placeholder="Repeat password" required="true">
                        </div>
                      
                        <button type="submit" class="btn btn-contact" name="submit">Signup</button>
                    </form>
                </div>
            </div>   
        </div>
    </div>
</section>

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
</script>
<!-- /move top -->
</body>

</html>