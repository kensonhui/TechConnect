<?php
	include("html.php");

$mysql = new mysqli("localhost", "root", "", "inventory");

$inserttorefund = "INSERT INTO refund SELECT * FROM sold WHERE Ordernumber = " . $_POST["ordernumber"];
$inserttorefund = "INSERT INTO refund SELECT * FROM sold WHERE Ordernumber = " . $_POST["ordernumber"];

if ($refund = $mysql->query($inserttorefund)) { //insert into refund record
} else {
	echo $mysql->error;
}

$display = "SELECT * FROM refund WHERE (Ordernumber = " . $_POST['ordernumber'] . " AND ID = " . $_POST["source"] . ")";

if ($showitems = $mysql->query($display)) { //finds refunded items from refund table
} else {
	echo "fail" . $mysql->error;
}
if ($item = $showitems->fetch_assoc()) {
	
	$quantity = "SELECT * FROM sold WHERE (Ordernumber=" . $_POST['ordernumber'] . " AND ID=" . $_POST["source"] . ")";
	
	if ($findquantity = $mysql->query($quantity)) {
	} else {
		echo "butt" . $mysql->error;
	}
	echo '<div class="confirmation-box">'; 
	if ($show = $findquantity->fetch_assoc()) { //go through each refunded item, remove it from order list and restock inventory
		if ((int)$show["Quantity"] - (int)$_POST["quantity"] == 0) {
			if ($mysql->query("DELETE FROM sold WHERE (Ordernumber = " . $_POST['ordernumber'] . " AND ID = " . $_POST['source'] . ")")) {
			} else {
				echo "error deleting" . $mysql->error;
			}
		} else {
			if ($mysql->query("UPDATE sold SET Quantity = " . ((int)$show["Quantity"] - (int)$_POST["quantity"]) . " WHERE (Ordernumber = " . $_POST['ordernumber'] . " AND ID = " . $_POST['source'] . ")")) {
			} else {
				echo "UPDATE sold SET Quantity = " . ((int)$show["Quantity"] - (int)$_POST["quantity"]) . " WHERE (Ordernumber = " . $_POST['ordernumber'] . " AND ID = " . $_POST['source'] . ")" . $mysql->error ;
			}
		} 
		$findstockquantity = $mysql->query("SELECT * FROM items WHERE ID = " . $_POST['source']);
		if ($stock = $findstockquantity->fetch_assoc()) {
			if ($mysql->query("UPDATE items SET Quantity =" . ((int)$stock["Quantity"] + (int)$_POST["quantity"]) . " WHERE ID = " . $_POST["source"])) {
				echo '<p> Succesfully refunded ' . $_POST["quantity"] . " x " . $stock["item"] . '</p>
					<img src="' . $stock["Photoid"] . '" class="photo"></img>';
						
							
			} else {
				echo $mysql->error;
			}
		}	
		$mysql->error;
	} else {
		echo "Unable to locate order" . $mysql->error;
	}
echo '</div>';
	
}

?>