<?php

	include("html.php");

	$mysql = new mysqli("localhost", "root", "", "inventory");

	$addtocart = "INSERT INTO cart (ID, Quantity) VALUES (" . $_POST["ItemID"] . ", " . $_POST["quantity"] . ")";
	if ($mysql->query($addtocart)) {
	$finditemname = "SELECT * FROM items WHERE ID = " . $_POST["ItemID"] . " LIMIT 1";
		$item = $mysql->query($finditemname);
		$mysql->error;
		while ($name = $item->fetch_assoc())
		echo "Added " . $name["item"] . " successfully to cart!";
	} else {
		echo "Error adding to cart" . $mysql->error;
	}
?>