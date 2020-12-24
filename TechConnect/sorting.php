<?php
	include("html.php");


$mysql = new mysqli("localhost", "root", "", "inventory");

$result = $mysql->query("SELECT DISTINCT Category FROM items ORDER BY Category"); //display all categories in alphabetical order

$category = array();
$count = 0;

echo "Categories <br>";

if ($_GET["Sortby"] == "Category") {
	$result = $mysql->query("SELECT DISTINCT Category FROM items ORDER BY Category"); //display all categories or brands in alphabetical order
	$sortby = "Category";
} else {
	$result = $mysql->query("SELECT DISTINCT Brand FROM items ORDER BY Brand");
	$sortby = "Brand";
}



while($row = $result->fetch_assoc()) {
	$category[$count] = $row[$sortby]; //saves each category into an array
	$link = str_replace(' ', '%20', $category[$count]); //trim spaces between words
	//sends to script that displays a list of chosen category and brand
    echo "<a href = sortbylist.php?Division=" . $sortby . "&List=" . $link . ">" . $row[$sortby] . "s" . "</a><br>";
	$count++;
}



?>