<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsuid']==0)) {
  header('location:logout.php');
  } else{





if (isset($_POST['update_paid_status'])) {
    $invoice_id = $_POST['invoice_id']; // Get the invoice ID from the form

    // Update the "Paid" status to "Yes" in the table
    $query = "UPDATE tblinvoice SET Paid = 'Yes' WHERE BillingId = '$invoice_id'";
    $result = mysqli_query($con, $query); // Execute the update query

    if ($result) {
        // Update successful
        echo "Paid status updated successfully!";
    } else {
        // Update failed
        echo "Error updating paid status: " . mysqli_error($con);
    }
}
?>



<!doctype html>
<html lang="en">
  <head>
 

    <title>Love Yourself | Booking History</title>

    <!-- CSS -->
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

<!-- disable body scroll which navbar is in active -->

<!-- breadcrumbs -->
<section class="w3l-inner-banner-main">
    <div class="about-inner contact ">
        <div class="container">   
            <div class="main-titles-head text-center">
            <h3 class="header-name ">
                
 Invoice History
            </h3>
            <p class="tiltle-para ">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic fuga sit illo modi aut aspernatur tempore laboriosam saepe dolores eveniet.</p>
        </div>
</div>
</div>
<div class="breadcrumbs-sub">
<div class="container">   
<ul class="breadcrumbs-custom-path">
    <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
    <li class="active ">
        Invoice History</li>
</ul>
</div>
</div>
    </div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec	">
        <div class="container">

            <div>
                <div class="cont-details">
                   <div class="table-content table-responsive cart-table-content m-t-30">
                    <h3 class="title1">Invoice Details</h3>
                    
    <?php
    $invid=intval($_GET['invoiceid']);
$ret=mysqli_query($con,"select DISTINCT  date(tblinvoice.PostingDate) as invoicedate,tbluser.FirstName,tbluser.LastName,tbluser.Email,tbluser.MobileNumber,tbluser.RegDate
    from  tblinvoice 
    join tbluser on tbluser.ID=tblinvoice.Userid 
    where tblinvoice.BillingId='$invid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>              
                
                    <div class="table-responsive bs-example widget-shadow">
                        <h4>Invoice #<?php echo $invid;?></h4>
                        <table class="table table-bordered" width="100%" border="1"> 
<tr>
<th colspan="6">Customer Details</th>   
</tr>
                             <tr> 
                                <th>Name</th> 
                                <td><?php echo $row['FirstName']?> <?php echo $row['LastName']?></td> 
                                <th>Contact no.</th> 
                                <td><?php echo $row['MobileNumber']?></td>
                                <th>Email </th> 
                                <td><?php echo $row['Email']?></td>
                            </tr> 
                             <tr> 
                                <th>Registration Date</th> 
                                <td><?php echo $row['RegDate']?></td> 
                                <th>Invoice Date</th> 
                                <td colspan="3"><?php echo $row['invoicedate']?></td> 
                            </tr> 
<?php }?>
</table> 
<table class="table table-bordered" width="100%" border="1"> 
<tr>
<th colspan="3">Services Details</th>   
</tr>
<tr>
<th>#</th>  
<th>Service</th>
<th>Cost</th>
</tr>

<?php
$ret=mysqli_query($con,"select tblservices.ServiceName,tblservices.Cost  
    from  tblinvoice 
    join tblservices on tblservices.ID=tblinvoice.ServiceId 
    where tblinvoice.BillingId='$invid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {
    ?>

<tr>
<th><?php echo $cnt;?></th>
<td><?php echo $row['ServiceName']?></td>   
<td>R<?php echo $subtotal=$row['Cost']?></td>
</tr>
<?php 
$cnt=$cnt+1;
$gtotal+=$subtotal;
} ?>

<tr>
<th colspan="2" style="text-align:center">Grand Total</th>
<th>R<?php echo $gtotal?></th>   


</tr>
</table>
<form method="post">
  <p style="margin-top:1%"  align="center" >
  Make Payment</br>

  <i class="fa fa-credit-card fa-2x" id="checkout-button" style="cursor: pointer;"  OnClick="CallPrint(this.value)" > </i>
  <input type="hidden" name="invoice_id" value="<?php echo $invid; ?>">

  </p>
  </form>

      </div> 
    </div>
                
    </div>
   
    </div></div>
</section>
<?php include_once('includes/footer.php');?>
<!-- move top -->
<button onclick="topFunction()" id="movetop" title="Go to top">
	<span class="fa fa-long-arrow-up"></span>
</button>



<!-- Include the Yoco SDK in your web page -->
<script src="https://js.yoco.com/sdk/v1/yoco-sdk-web.js"></script>

<!-- Create a pay button that will open the popup-->


<form method="post">
<input type="hidden" name="invoice_id" value="<?php echo $invid; ?>">
<button type="submit" name="update_paid_status" id="checkout-button">Pay</button>
</form>

<script>
  var yoco = new window.YocoSDK({
    publicKey: 'pk_test_ed3c54a6gOol69qa7f45',
  });
  var checkoutButton = document.querySelector('#checkout-button');
  checkoutButton.addEventListener('click', function () {
    yoco.showPopup({
      amountInCents: <?php echo $gtotal*100?>,
      currency: 'ZAR',
      name: 'INV #<?php echo $invid;?>',
      description: 'Awesome description',
      callback: function (result) {
        // This function returns a token that your server can use to capture a payment
        if (result.error) {
          const errorMessage = result.error.message;
          alert("error occured: " + errorMessage);
        } else {
          alert("Payment successfull: " + result.id);

          
        }
        // In a real integration - you would now pass this chargeToken back to your
        // server along with the order/basket that the customer has purchased.
      }
    })
  });
</script>

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

</html><?php } ?>