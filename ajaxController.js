/*global $*/

$(document).ready(function() {
//AJAX open JSON file and initialise loadCars function when this script is called. Call is located on carView.php
var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var getCarJSON = JSON.parse(this.responseText);
            loadCars(getCarJSON);
        }
    };
    xmlhttp.open("GET", "/Warehouse API/getCars.json", true);
    xmlhttp.send();
});

//create an array to store the list of available cars - this will be used to generate the alert when reserving a car
var carsInWarehouse = new Array();


// loop through JSON and add cars to grid on carView.php
function loadCars(carJSON) {
    for (var index = 0; index < carJSON.carDetails.length; index++) {
        var car = "#car" + index;
        var carimg;
        var carname = carJSON.carDetails[index].Modelyear + " " + carJSON.carDetails[index].Brand + " " + carJSON.carDetails[index].Model;
        var availability = carJSON.carDetails[index].Availability;
        var dailyprice = carJSON.carDetails[index].Priceperday;
        
        //shove the car id and its availability into an array for later use
        carsInWarehouse.push([index,availability,carname,dailyprice]);
        
    //get the image associated with the car. This accounts for the 3 JPG filetypes used for the Golf, GLC, and Cherokee
        if (carJSON.carDetails[index].Model == "Golf") {
            carimg = "Images/Golf.png";
        } else if (carJSON.carDetails[index].Model == "GLC") { 
            carimg = "Images/GLC.png";
        } else if (carJSON.carDetails[index].Model == "Cherokee") {   
            carimg = "Images/Cherokee.png";
        } else {
            carimg = "Images/" + carJSON.carDetails[index].Model + ".jpg";
        }
        
        //pass HTML block to carView.php to replace div. This should be responsive enough to allow for any number of cars to be added, though the grid-container css class would need to have additional positions added if there's more than 11 cars
        $(car).html("<div class='card' style='grid area:" + index + "'>" +
        "<h3>" + carname + "</h3>" +
        "<img src=" + carimg + ">" +
          "<p class='price'>$" +  dailyprice + " per day</p>" +
          "<p style=padding: 5px>" + carJSON.carDetails[index].Description + "</p>" +
          "<table class='card'>" +
               "<tr>" +
               "<td><b>Car Type:</b></td>" +
               "<td>" + carJSON.carDetails[index].Category + "</td>" +
                "</tr>" +
                "<tr>" +
               "<td><b>Seats:</b></td>" +
               "<td>" + carJSON.carDetails[index].Seats + "</td>" +
                "</tr>" +
                "<tr>" +
                    "<td><b>Fuel Type:</b></td>" +
                    "<td>" + carJSON.carDetails[index].Fueltype + "</td>" +
                "</tr>" +
                "<tr>" +
                    "<td><b>Current Mileage:</b></td>" +
                     "<td>" + carJSON.carDetails[index].Mileage + " kilometres</td>" +
                "</tr>" +
                "<tr>" +
                    "<td><b>Available to Rent:</b></td>" +
                    "<td>" + availability + "</td>" +
                "</tr>" +
           "</table>" +
          "<p><button onclick='addToCart(" + index + ")'>Reserve</button></p>");

    }
}

function addToCart(index) {
    $(document).ready(function() {
        // Check car availability before add into the car cart
        if (carsInWarehouse[index][1] == "Yes") {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Alert user if selected car added to car cart successfully
                    alert("Added to cart successfully.");
                }
            };
            xmlhttp.open("POST", "cart.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("carId=" + index.toString());
        } else {
            // Alert user if selected car is not available
            alert("Sorry, that car is not available now. Please try other cars.");
        }
    });
}

// Check if any cars have 0 rental days
function validateCart(carName){
    
//    var carName = carName;

   const carDaysSelected = []; 
        $('input[name="daysNeeded"]').each(function() {
        carDaysSelected.push($(this).val());
        });
    
    //all car values are pushed into an array, then checked to see if any are =0. Note assignment originally calls for a check of (integer, >0), but I feel this is a cleaner way to manage it and is readable.
    //value is also managed by HTML form
    if (carDaysSelected.includes("0")){
        
        alert("Cannot checkout. Rental days must be greater than 0, check your cart and try again.");
        
        //alert with dynamic carname
       // alert("Cannot checkout. Rental days must be greater than 0 for " + carName + ".");
        
    } else {
        window.location.href = "checkout.php";
    }

}

function goBack(){
    
   alert("Nothing in cart. Click OK to return to vehicle selection.");
    
    window.location.href = "carView.php"
}
