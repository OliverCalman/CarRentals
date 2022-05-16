<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Hertz-UTS | Online Car Rental</title>
        <link rel="icon" href=Images\favicon.ico>
  </head>
<body>

<div class="header-logo-container">
<!--anchor link to homepage-->
<a href="index.php"><img id="hertzlogo" style="height:80px; padding:10px" src=Images\HertzLogo.png alt="Hertz Logo">
<!--uni logo-->
<img id="unilogo" style="height:80px; padding:10px" src=Images\utsLogo.png alt="UTS Logo"></a>

<div class="spacer"><br></div>
<div class="content" style="height:600px">

<?php

//calculate the cart total on the fly - 'faster' than using the session, though more overhead
if (isset($_SESSION['cart'])) {
  
  
   $cartTotal = array();
                    
    //iterates through each cart item and displays in table
        foreach($_SESSION['cart'] as $name => $array){ 
            
        $rentalDays = $array['rentalDays'];
        $carPrice = $array['carPrice'];
        
        $subtotal = $rentalDays * $carPrice;
            
        $cartTotal[] = $subtotal;
        }
        
        
?>


<br>
<h1 style="font-size:30px; font-weight:normal">Thanks for booking with us <?php echo($_POST["fn"])?>, your reservation has been created!</h1>
<br>

<h3>Delivery Details</h3>

<!--iframe from maps.google.com-->
<div class="map">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3312.235901226483!2d151.198770616035!3d-33.88357788065212!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12ae265c3ffbc1%3A0x535ecb4ef5a198d2!2sUniversity%20of%20Technology%20Sydney%20Building%201%2C%2015%20Broadway%2C%20Ultimo%20NSW%202007!5e0!3m2!1sen!2sau!4v1652093643787!5m2!1sen!2sau" width="500" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>

<div class="deliverydetails">
<h3>Total Price:&nbsp;$<?php echo(array_sum($cartTotal));?></h3>

<p>Vehicle pickup is available during open hours from Building 11, UTS.</p>
<p style="font-weight:bold; color:red">Please bring a valid drivers licence when picking up your vehicle.</p>
<br>
<p style="font-weight:bold; font-size:smaller">Open Hours:</p>
<p style="font-size:smaller">Monday 9am - 5pm</p>
<p style="font-size:smaller">Tuesday 9am - 5pm</p>
<p style="font-size:smaller">Wednesday CLOSED</p>
<p style="font-size:smaller">Thursday 9am - 5pm</p>
<p style="font-size:smaller">Friday 9am - 12pm</p>
<p style="font-size:smaller">Sunday CLOSED</p>
</div>


<?php

session_destroy();

} else {
    echo ("<br><h3 style='font-weight:normal'>Your cart is empty :/</h3><br>");
}

?>


</div>

<div class="footer">
  Produced for 32516 Internet Programming by <a href="http:\\www.github.com\OliverCalman">Oliver Calman</a>, 2022. <br>
  Distribution under MIT licence. All copyrighted material is the property of its respective owners. <br>
  Version 1.0.1
</div>

</body>

</html>