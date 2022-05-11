<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Hertz-UTS | Online Car Rental</title>
    
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="ajaxController.js"></script>
  </head>
<body>

<div class="header-logo-container">
<!--anchor link to homepage-->
<a href="index.php"><img id="hertzlogo" style="height:80px" src=Images\HertzLogo.png alt="Hertz Logo">
<!--uni logo-->
<img id="unilogo" style="height:80px" src=Images\utsLogo.png alt="UTS Logo"></a>

<!-- view reservations-->
  <div class="reservations">
    <!--Cart icon from favicon, used under licence-->
  <a href="cart.php"><button><img src="Images\Cart-icon.png" style="height:18px; position:relative; top:2px">&nbsp; &nbsp;View Cart</button></a>
  </div>
</div>


<!--filter box-->
<div class="filter">
  <h1 style="text-align: center">Filter Results</h1>

  <br>

  <label for="cartype">Type of Car</label>
    <select id="cartype" name="cartype">
    <option value="any">Any</option>
     <option value="SUV">SUV</option>
     <option value="Sedan">Sedan</option>
      <option value="Hatchback">Hatchback</option>
    </select> 

    <br>    <br>

  <label for="manufacturer">Make</label>
    <select id="manufacturer" name="manufacturer" multiple style="height:200px">
    <option value="any">Any</option>
     <option value="BMW">BMW</option>
     <option value="Honda">Honda</option>
     <option value="Hyundai">Hyundai</option>
     <option value="Jeep">Jeep</option>
     <option value="Mercedes">Mercedes</option>
     <option value="Nissan">Nissan</option>
     <option value="Suzuki">Suzuki</option>
     <option value="Toyota">Toyota</option>
      <option value="Volkswagen">Volkswagen</option>
   </select> 

   <br>    <br>

   <label for="availability">Availability</label>
    <select id="availability" name="availability">
    <option value="any">Any</option>
     <option value="Yes">Yes</option>
     <option value="No">No</option>
    </select> 
    
</div>

<!--display all cars on page-->
<!--note to marker - I'm super excited over how streamlined this is - the whole thing is fed by my JS script! Should be super easy to maintain-->
<div class="grid-container">
      <div id="car0"></div>
      <div id="car1"></div>
      <div id="car2"></div>
      <div id="car3"></div>
      <div id="car4"></div>
      <div id="car5"></div>
      <div id="car6"></div>
      <div id="car7"></div>
      <div id="car8"></div>
      <div id="car9"></div>
      <div id="car10"></div>
      <div id="car11"></div>
 </div>   

<br>
<div class="footer">
  Produced for 32516 Internet Programming by <a href="http:\\www.github.com\OliverCalman">Oliver Calman</a>, 2022. <br>
  Distribution under MIT licence. All copyrighted material is the property of its respective owners. <br>
  Version 0.0.7
</div>

</body>

</html>