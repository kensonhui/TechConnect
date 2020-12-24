<html>
	<style>
		.confirmation-box {
			background-color: #4171A0;
			border: 3px solid #68f442;
		}
		.image {
			width:150px;
			height:150px;
		}
	</style>
	</html>

<?php

include("html.php");
$mysql = new mysqli("localhost", "root", "", "inventory");

$newrecord = "INSERT INTO record(Name, Email, Address, City, Province, Zip, Cardname, Creditcard, Cvv, Expirymonth, Expiryyear)
			VALUES('" . $_POST["fullname"] . "', '" . $_POST["email"] . "', '" . $_POST["address"] . "', '" . $_POST["city"] . "', '" . $_POST["province"] . "', '" . $_POST["zip"] . "', '" . $_POST["cardname"] . "', " . $_POST["cardnumber"] . ", " . $_POST["cvv"] . ", '" . $_POST["expmonth"] . "', " . $_POST["expyear"] . ")";

if ($mysql->query($newrecord)) {
	
	echo '<div class="confirmation-box">';
	$userinfo = $mysql->query("SELECT * FROM record ORDER BY Ordernumber DESC LIMIT 1"); //find recently added record
	while ($row = $userinfo->fetch_assoc()) {
		echo "<p> Your order has been confirmed <br> Your refund number is: #" . $row["Ordernumber"] . "</p>";
		
		$mysql->error;
	}
	
	
	$userinfo = $mysql->query("SELECT * FROM record ORDER BY Ordernumber DESC LIMIT 1");
	$getorder = $mysql->query("SELECT * FROM cart"); //find recently added record
	 
	while ($row = $userinfo->fetch_assoc()) {
		while ($value = $getorder->fetch_assoc()) {
			$sold = "INSERT INTO sold(Ordernumber, ID, Quantity) VALUES(" . $row["Ordernumber"] . ", " . $value["ID"] . ", " . $value["Quantity"] . ")";
			$mysql->query($sold);
			$findstockquantity = $mysql->query("SELECT * FROM items WHERE ID = " . $value["ID"]);
			while ($stock = $findstockquantity->fetch_assoc()) {
				if (!$mysql->query("UPDATE items SET Quantity =" . ((int)$stock["Quantity"] - (int)$value["Quantity"]) . " WHERE ID = " . $value["ID"])) {
					echo $mysql->error . "UPDATE items SET Quantity = " . (int)$stock["Quantity"] - (int)$value["Quantity"] . " WHERE ID = " . $value["ID"];
				} else {
					echo '<p>Ordered ' . $value["Quantity"] .'</p><img class="image" src="' . $stock["Photoid"] .'"></img>';
				}
				$mysql->error;
			}
		}
	}
	echo "</div>";
	$mysql->query("TRUNCATE TABLE cart");
	
} else {
	echo "Order was not successful" , $mysql->error;
}

			
//echo $_POST["fullname"] . $_POST["email"] . $_POST["address"] . $_POST["city"] . $_POST["province"] . $_POST["zip"] . $_POST["cardname"] . $_POST["cardnumber"] . $_POST["expmonth"] . $_POST["expyear"] . $_POST["cvv"];
?>