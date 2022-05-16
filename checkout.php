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

<div class="reservations">
    <!--Cart icon from favicon, used under licence-->
  <a href="cart.php"><button><img src="Images\Cart-icon.png" style="height:18px; position:relative; top:2px">&nbsp; &nbsp;View Cart</button></a>
  </div>

<div class="spacer"><br></div>
<div class="content-checkout">
    
<?php

if (isset($_SESSION['cart'])) {

?>

<br>
<!--Cart icon from favicon, used under licence-->
<h3 style="font-size: 30px"><img src="Images\Checkout-icon.png" style="height:30px; position:relative; top:2px padding:none">&nbsp; &nbsp;Checkout</h3>

<div class="checkout-form">

<form id="checkoutForm" method='post' action="success.php">
        <table>

        <th style="width:20%"></th>
        <th style="width:50%"></th>
        
        <tr>
            <td><label for="eml">Email Address<a style="color:red"> *</a></label></td>
            <td><input type="email" id="eml" required></td>
        </tr>
        <tr>
            <td><label for="fn">First Name<a style="color:red"> *</a></label></td>
            <td><input type="text" name="fn" id="fn" required></td>
        </tr>
        <tr>
            <td><label for="ln">Last Name<a style="color:red"> *</a></label></td>
            <td><input type="text" id="ln" required></td>
        </tr>
        <tr>
            <td><label for="adl1">Address Line 1<a style="color:red"> *</a></label></td>
            <td><input type="text" id="adl1" required></td>
        </tr>
        <tr>
            <td><label for="adl2">Address Line 2</label></td>
            <td><input type="text" id="adl2"></td>
        </tr>
        <tr>
            <td><label for="sub">Suburb<a style="color:red"> *</a></label></td>
            <td><input type="text" id="sub" required></td>
        </tr>
        <tr>
            <td><label for="state">State</label></td>
            <td><select id="state" required>
              <option value="" selected disabled hidden></option>
              <option value="NSW">NSW</option>
              <option value="VIC">VIC</option>
              <option value="WA">WA</option>
              <option value="QLD">QLD</option>
              <option value="NT">NT</option>
              <option value="SA">SA</option>
              <option value="ACT">ACT</option>
            </select>
            </td>
        </tr>
        <tr>
            <td><label for="pc">Postcode<a style="color:red"> *</a></label></td>
            <td><input type="number" id="pc" min="1000" max="9999" required></td>
        </tr>
                <tr>
                    <td colspan="2"><br><br></td>
                </tr>
        <tr>
            <td></td>
            <td><h3 style="text-align:center">Payment Details</h3></td>
        </tr>
        <tr>
            <td></td>
            <td><a class="mastercard"><img src="/Images/Mastercard.png" style="height:20px"></a>&nbsp;&nbsp;&nbsp;<a class="visa"><img src="/Images/Visa.png" style="height:20px"></a></td>
        </tr>
        
        <tr>
            <td><label for="pmt">Payment Type<a style="color:red"> *</a></label></td>
            <td><select id="pmt" required>
              <option value="" selected disabled hidden></option>
              <option value="Mastercard">Mastercard</option>
              <option value="Visa">Visa</option>
            </select>
            </td>
        </tr>
        <tr>
            <td><label for="nmcrd">Name on Card<a style="color:red"> *</a></label></td>
            <td><input type="text" id="nmcrd" required></td>
        </tr>
        <tr>
            <td><label for="crdnmbr">Card Number<a style="color:red"> *</a></label></td>
            <td><input type="number" id="crdnmbr" minlength="12" maxlength="12" required></td>
        </tr>
        <tr>
            <td><label for="cvv">CVV<a style="color:red"> *</a></label></td>
            <td><input type="number" id="cvv" minlength="3" maxlength="3" required></td>
        </tr>
        <tr>
            <td><label for="expiry">Expiry<a style="color:red"> *</a></label></td>
            <td><input type="text" id="expiry" placeholder="MM/YY" required></td>
        </tr>
        <tr>
            <td></td>
            <td>    
                <div class="continue">
                <input type="submit" value="Pay Now"></input>
                </div>
            </td>
        </tr>
        </table>

</form>
</div>


<div class="checkout-cart-summary">
    <h3><img src="Images\Cart-icon.png" style="height:30px; position:relative; top:2px">&nbsp; &nbsp;Cart Summary</h3>
    <table>
        
        <th style="width:80%"></th>
        <th style="width:20%"></th>


<?php

//calculate total for the cart summary
    $cartTotal = array();
                    
    //iterates through each cart item and displays in table
        foreach($_SESSION['cart'] as $name => $array){ 
            
        $rentalDays = $array['rentalDays'];
        $carPrice = $array['carPrice'];
        
        $subtotal = $rentalDays * $carPrice;
            
        $cartTotal[] = $subtotal;
        
        //don't display any of the cars that have 0 days, in case they make it through. Should be checked by JS from the cart.php page anyway
            if($rentalDays == 0){
                
            }
            else {
?>
        <tr>
        <td colspan="2"><br></td>
        </tr>
        <tr>
            <td><b><?php echo $array['carName']; ?></b></td>
            <td><b>$<?php echo($subtotal); ?></b></td>
        </tr>
        <tr>
            <td  colspan="2"><?php echo($array['rentalDays']);?> days rental at $<?php echo $array['carPrice'];?> per day</td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #cccccc"  colspan="2"><br></td>
        </tr>
            
<?php               
            }
                
            }
            
?>  


  <!---final row contains total-->
    <tr>
    <td colspan="2"><p style="font-size:20px; padding-top: 30px; text-align:right"><b>Subtotal:&nbsp;</b>$<?php echo(array_sum($cartTotal));?><p></td>
    </tr>  
    </table>
    
    
</div>

<?php

} else {
    echo ("<br><h3 style='color:red'>Error: no items in cart. Unable to checkout.</h3><br>");
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