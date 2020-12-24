<!DOCTYPE html>
<html>
<head>
<style>
body {
  background-color: #064789;
  font-family: Century Gothic;
  color: #D0DCE8;
  font-size: 17px;
  padding: 8px;
}

* {
  box-sizing: border-box;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

a, b {
  text-decoration: none;
  color: #D0DCE8;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25, .col-50, .col-75 {
  padding: 0 16px;
}

.container {
  background-color: #365D83;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #064789;
  color: #D0DCE8;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: darkblue;
}

a {
  color: #D0DCE8;
}

hr {
  border: 1px solid #D0DCE8;
}

span.price {
  float: right;
  color: #D0DCE8;
}

@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>
</head>
<body>

<div class="row">
  <div class="col-75">
    <div class="container">
      <form action="confirmation.php" method="post">
        <div class="row">
          <div class="col-50">
            <h3>Billing Address</h3>
            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
            <input type="text" id="fname" name="fullname" placeholder="Omar Qayum">
            <label for="email"><i class="fa fa-envelope"></i> Email</label>
            <input type="text" id="email" name="email" placeholder="john@example.com">
            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
            <input type="text" id="adr" name="address" placeholder="542 W. 15th Street">
            <label for="city"><i class="fa fa-institution"></i> City</label>
            <input type="text" id="city" name="city" placeholder="New York">

            <div class="row">
              <div class="col-50">
                <label for="state">Province</label>
                <input type="text" id="province" name="province" placeholder="ON">
              </div>
              <div class="col-50">
                <label for="zip">Postal Code</label>
                <input type="text" id="zip" name="zip" placeholder="X1X1X1" maxlength="6">
              </div>
            </div>
          </div>

          <div class="col-50">
            <h3>Payment</h3>
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="Omar Qayum">
            <label for="ccnum">Credit card number</label>
            <input type="tel" id="ccnum" name="cardnumber" placeholder="1111222233334444" pattern="[0-9]{16}" required maxlength="16">
            <label for="expmonth">Exp Month</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="September">
            <div class="row">
              <div class="col-50">
                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" placeholder="2018" maxlength="4">
              </div>
              <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="352" maxlength="3";>
              </div>
            </div>
          </div>
          
        </div>
        <input type="submit" value="Continue to checkout" class="btn">
      </form>
    </div>
  </div>
  <div class="col-25">
    <div class="container">
      <h4>Cart <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i></span></h4>
	  <?php
		
		$mysql = new mysqli("localhost", "root", "", "inventory");
	  
		$showcart = "SELECT * FROM cart";
		$result = $mysql->query($showcart);
		$grandtotal = 0;
		
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$getinfo = "SELECT * FROM items WHERE ID = " . $row["ID"];
				$info = $mysql->query($getinfo);
				while ($value = $info->fetch_assoc()) {
					echo '<p><a href="itemdetail.php?Itemid=' . $row["ID"] . '"> ' . $value["item"] . " x " . $row["Quantity"] . '</a> <span class="price">' . str_replace("," , "" , str_replace("$", "", $value["Price"])) * (integer)$row["Quantity"] . '</span></p>';
					$grandtotal += (double)str_replace("," , "" , str_replace("$", "", $value["Price"])) * (integer)$row["Quantity"];
				}
			}
		}
		echo '<hr><p>Total <span class="price" style="color:black"><b>' . $grandtotal . '</b></span></p>';
		
		
	?>
      
    </div>
  </div>
</div>

</body>
</html>



<?php 
	

?>