<?php
session_start();

//debugging only
//session_destroy();
//var_dump($_SESSION);
//var_dump($_SESSION['subTotal']);
//echo(array_sum($_SESSION['subTotal']));

//take the index from carView onsubmit (sent via ajax), then load the JSON getCars.json and grab the details of that car using the index supplied.
//Push those details into a session array then render on page in cart table

//open the JSON to get details
    $carJSON = file_get_contents("Warehouse API/getCars.json");
    $carList = json_decode($carJSON, true);
    
    //start cart session
    if (isset($_POST["carId"])) {

        $carId = $_POST["carId"];
        $carName = ($carList["carDetails"][$carId]["Modelyear"] . " " . $carList["carDetails"][$carId]["Brand"] . " " . $carList["carDetails"][$carId]["Model"]);
        $carPrice = $carList["carDetails"][$carId]["Priceperday"];

        
        //set the image for each car - this is required to account for the different filetypes..
        $carModel = $carList["carDetails"][$carId]["Model"];
        if ($carModel == "Golf") {
            $carImage = "<img src='Images/Golf.png'></img>";
        } else if ($carModel == "GLC") {
            $carImage = "<img src='Images/GLC.png'></img>";
        } else if ($carModel == "Cherokee") {
            $carImage = "<img src='Images/Cherokee.png'></img>";
        } else {
            $carImage = "<img src='Images/" . $carModel . ".jpg'></img>";
        }
        
        
        //need to add logic in here to stop rental days being set to 0 when adding a car again, or logic to not add if already in session
        if (!isset($_SESSION['cart'])) {
                //add first item to array
                 $_SESSION['cart'][$carId] = array("carName" => $carName, "carPrice" => $carPrice, "carImage" => $carImage, "rentalDays" => 0);
            } else {
                // Car is not in cart so add it
                 $_SESSION['cart'][$carId] = array("carName" => $carName, "carPrice" => $carPrice, "carImage" => $carImage, "rentalDays" => 0);
            }
        } 
        




    //get total of car session days and store as an array
    $_SESSION['subTotal'] = array();
    
    foreach($_SESSION['cart'] as $name => $array){ 
        $rentalDays = $array['rentalDays'];
        $carPrice = $array['carPrice'];
        
        $lineTotal = $rentalDays * $carPrice;
        
        
        /* if (array_key_exists($name, $_SESSION['subTotal'])){
                unset($_SESSION['subTotal'][$name]);
        } */
        
        
        $_SESSION['subTotal'][$name] = $lineTotal;
              /*
                if (!isset($_SESSION['totalPrice'])) {
                    $_SESSION['totalPrice'] = $lineTotal;
                } else {
                    $_SESSION['totalPrice'] += $lineTotal;
                }    */
     } 
        
        
    //update rentalDays value in session
        if (isset($_POST["daysNeeded"])) {
            $daysNeeded = $_POST["daysNeeded"];
            $cartIndex = $_POST["cartIndex"];
            settype($daysNeeded, "integer");
             $_SESSION['cart'][$cartIndex]['rentalDays'] = $daysNeeded;
             
               /*     $carPrice = $_SESSION['cart'][$cartIndex]['carPrice'];
                    
                    $lineTotal = $daysNeeded * $carPrice;
             
             $_SESSION['subTotal'][$cartindex] =  $lineTotal; */
             
        }
        
        
        //remove item from cart
         if (isset($_POST["removeCar"])) {
             $carToRemove = $_POST["removeCar"];
             settype($carToRemove, "string");
            // Remove the deleted car from $_SESSION["carCart"]
            unset($_SESSION['cart'][$carToRemove]);

            //unset from subtotal session tooWW
            unset($_SESSION['subTotal'][$carToRemove]);
            
            }


?>

<!DOCTYPE html>
<html>
  <head>
    <title>Hertz-UTS | Online Car Rental</title>
    <link rel="icon" href=Images\favicon.ico>
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="ajaxController.js"></script>
  </head>
<body>

<div class="header-logo-container">
<!--anchor link to homepage-->
<a href="index.php"><img id="hertzlogo" style="height:80px; padding:10px" src=Images\HertzLogo.png alt="Hertz Logo">
<img id="unilogo" style="height:80px; padding:10px" src=Images\utsLogo.png alt="UTS Logo"></a>

<div class="spacer"><br></div>
<div class="content">

<br>
<!--Cart icon from favicon, used under licence-->
<h3 style="font-size: 30px"><img src="Images\Cart-icon.png" style="height:30px; position:relative; top:2px">&nbsp; &nbsp;My Cart</h3>



<?php

if (!isset($_SESSION['cart'])) {
    echo ("<br><h3 style='font-weight:normal'>Your cart is empty</h3><br>");
    
    ?>
    
    <!-- adding this in to meet the requirements, though I would prefer just to show the cart empty message. delete this div to go back to the msg only laout-->
    <div class="checkout-fail">
    <a href="carView.php"><button onclick=goBack()>Try to checkout</button></a>  
    </div>
    
    <?php
    
} else {


if (sizeof($_SESSION['cart']) !== 0) {

?>


<!--show reserved cars and set quantity-->
<table class="reservation-table">
  <th>Vehicle</th>
  <th></th>
  <th>Price Per Day</th>
  <th>Rental Days</th>
  <th></th>
  
  
<?php
                    
    //iterates through each cart item and displays in table
        foreach($_SESSION['cart'] as $name => $array){ 
?>
        <tr>
          <td><?php echo $array['carName']; ?></td>
          <td><?php echo $array['carImage']; ?></td>
          <td>$<?php echo $array['carPrice']; ?></td>
          
          <td>
          <form id="rentalDaysValue" method='post' action="cart.php">
          <input type="hidden" name="cartIndex" value=<?php echo $name; ?>>
          <input type="number" min="1" name="daysNeeded" value=<?php echo $array['rentalDays']; ?>> <!--post this value and insert into array using cart index-->
          
          <input type="submit" value="Update">
          </form>
          </td>
          
          <td><form id="remove" method='post' action="cart.php">
          <input type="hidden" name="removeCar" value=<?php echo $name; ?>>
          <a class="removebutton"><input type="submit" value="&nbsp;Delete"></input></form></a>
          <!-- delete button, if inclined to add: <img src="Images\Bin.png" style="height:15px;"> -->
          </td>
          </tr>
          
<?php               
                } 


?>
 
 <!--                   
  <tr>

 final row contains total
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><p style="font-size:20px; padding:30px"><b>Total:&nbsp;</b>$<?php  //echo(array_sum($subTotal))?><p></td>
  </tr>  
    -->

</table>


<!--checkout button-->
    <div class="checkout">
      <button onclick=validateCart()>Checkout</button>
    </div>

<?php

} else {
    echo ("<br><h3 style='font-weight:normal'>Your cart is empty</h3><br>");
    
    ?>
    
    <!-- adding this in to meet the requirements, though I would prefer just to show the cart empty message. delete this div to go back to the msg only laout-->
    <div class="checkout-fail">
    <a href="carView.php"><button onclick=goBack()>Try to checkout</button></a>  
    </div>
    
    <?php
    
}
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