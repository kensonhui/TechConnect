<?php
include("html.php");

$mysql = new mysqli("localhost", "root", "", "inventory");

$selectitem = "SELECT * FROM items WHERE ID = " . $_GET["ItemID"];

$query = $mysql->query($selectitem); 
while ($row = $query->fetch_assoc()) {
	echo "<h2>" . $row["item"] . "<br></h2>";
	echo "<img style = width:500px;height:500px; src = " . $row["Photoid"] . "></img><br>";
	echo "<p>Price: " . $row["Price"] . "<br> Quantity Remaining: " . $row["Quantity"] . "<br></p>" . $row["Description"];
	echo '<form method ="post" action="addtocart.php?">';
	echo '<input type = "submit" name="cart" value="Add to Cart"></input>';
	echo '<input type ="number" name="quantity" id ="quantity" min ="1" max="' . $row["Quantity"] . '" value ="1"></input>';
	echo '<input type ="hidden" name="ItemID" value="' . $_GET["ItemID"] . '">';
	echo '</form>';
}




?>