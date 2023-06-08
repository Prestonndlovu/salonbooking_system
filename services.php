
<?php
  session_start();
  error_reporting(0);
  include('includes/dbconnection.php');
?>

<!DOCTYPE HTML>
<html lang="en">

<head>

    <title>Love Yourself | service Page </title>

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
    <div class="about-inner services ">
        <div class="container">   
            <div class="main-titles-head text-center">
            <h3 class="header-name ">Our Service</h3>
        </div>
      </div>
    </div>

  <div class="breadcrumbs-sub">
    <div class="container">   
      <ul class="breadcrumbs-custom-path">
        <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
        <li class="active ">Services</li>
      </ul>
    </div>
  </div>
  </div>


</section>
<!-- breadcrumbs //-->
<section class="w3l-recent-work-hobbies" > 
    <div class="recent-work ">
        <div class="container">
            <div class="row about-about">
              <?php
            // Fetch services from the database
                $query = "SELECT * FROM services ";
                $result = mysqli_query($conn, $query);

                // Check if the query executed successfully
                if ($result) {
                    // Store the fetched services in an array
                    $services = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $services[] = $row;
                    }
                } else {
                    // Handle the database query error
                    die("Database query error: " . mysqli_error($conn));
                }

                // Check if a service is selected
                if (isset($_POST['service'])) {
                    $selectedServiceId = $_POST['service'];

                    // Find the selected service in the array
                    $selectedService = null;
                    foreach ($services as $service) {
                        if ($service['service_id'] == $selectedServiceId) {
                            $selectedService = $service;
                            break;
                        }
                    }
                }
                ?>

    <div class="col-lg-5 col-md-6 col-sm-6 propClone">
    <form>
    <label class="OptionTitle" for="service">Select a service:</label>
    <select name="service" id="service" onchange="updateServiceDetails(this.value)">
        <option value="">Select a service</option>
        <?php foreach ($services as $service): ?>
            <option value="<?php echo $service['service_id']; ?>"><?php echo $service['service_name']; ?></option>
        <?php endforeach; ?>
    </select>
</form>

<div class="card">
    <h2 id="service-name"><?php echo isset($selectedService) ? $selectedService['service_name'] : 'No service selected'; ?></h2>
    <p id="service-description"><?php echo isset($selectedService) ? $selectedService['description'] : 'Select a service to see the description'; ?></p>
    <p id="service-price"><?php echo isset($selectedService) ? 'Price: $' . $selectedService['price'] : ''; ?></p>
    <img id="service-image" src="<?php echo isset($selectedService) ? $selectedService['image'] : ''; ?>" alt="Service Image">
    <button id="addToCartButton" onclick="addToCart()">Add to Cart</button>      
</div>

<script>
    function updateServiceDetails(serviceId) {
        // Find the selected service in the array
        var selectedService = <?php echo json_encode($services); ?>.find(function(service) {
            return service.service_id == serviceId;
        });


        // Update the service picture
        document.getElementById('service-image').src = selectedService ? selectedService.image : '';
        
        // Update the service name and description
        document.getElementById('service-name').textContent = selectedService ? selectedService.service_name : 'No service selected';
        document.getElementById('service-description').textContent = selectedService ? selectedService.description : 'Select a service to see the description';
        document.getElementById('service-price').textContent = selectedService ? 'Price: R' + selectedService.price : '';
      
        
    }

    function addToCart() {
            var selectedValue = document.getElementById('service').value;
            // Implement your own logic to add the selected service to the cart
           
            console.log('Added service ' + selectedValue + ' to cart.');
        }
</script>
   
    <br></br>

        <?php 
      $cnt=$cnt+1;
           ?>
            
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