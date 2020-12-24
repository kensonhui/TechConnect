<html>
	<style>
	<?php include "stylesheet.css" ?>
	</style>
	
</html>
<?php 

include("html.php");

	
$mysql = new mysqli("localhost", "root", "", "inventory");

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
} else {
	echo "<p>Your Shopping Cart Items</p>";
}

$showcart = "SELECT * FROM cart";

$result = $mysql->query($showcart);

if ($result->num_rows > 0) {
	echo "<table> 
		<tr>
			<th> Item Name </th>
			<th> Description </th>
			<th> Brand </th>
			<th> Price </th>
			<th> Quantity </th>
			<th> Total Cost</th>
		</tr>";
		$grandtotal = 0.0;
		settype($grandtotal, "double");
	while ($row = $result->fetch_assoc()) {
		$getinfo = "SELECT * FROM items WHERE ID = " . $row["ID"];
		$info = $mysql->query($getinfo);
		while ($value = $info->fetch_assoc()) {
			echo "<tr>
					<td>" . $value["item"] . "</td><td> " . $value["Description"] . "</td><td> " . $value["Brand"] . "</td><td>" . $value["Price"] . "</td><td>" . $row["Quantity"] . "</td><td>$" . ((double)str_replace("," , "" , str_replace("$", "", $value["Price"])) * (integer)$row["Quantity"]) . "</td></tr>";
			$grandtotal += (double)str_replace("," , "" , str_replace("$", "", $value["Price"])) * (integer)$row["Quantity"]; //removes commas, dollarsigns and casts to double and int
		}
	}
	echo "<tr><td></td><td></td><td></td><td></td><td>Grand Total</td><td>$" . ($grandtotal) . "</td></tr></table>";
	echo '<form method ="checkout.php">
			<input type="button" onclick=window.location.href="checkout.php" value="Check Out"></input>
		</form>
		<form method ="get">
			<input type="submit" name="delete" value="Remove All items"></input>
		</form>';
		
	if (isset($_GET['delete'])) { //if button is pushed
		$deletecart = "TRUNCATE TABLE cart";
		
		if($mysql->query($deletecart)) {
			echo "<br><p>Successfully cleared cart <br> Refreshing page in 5 seconds</p>";
			header("Refresh: 0");
			
		} else {
			echo "Error" . $mysql->error;
		}
	}
} else {
	echo "<p><br> You have no items in your cart. Shop now!</p>";
}


?>