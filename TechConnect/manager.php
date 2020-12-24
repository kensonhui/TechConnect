<?php 


$mysql = new mysqli("localhost", "root", "");
$db = "CREATE DATABASE IF NOT EXISTS inventory";
$mysql->query($db);
$mysql = new mysqli("localhost", "root", "", "inventory");

if (!mysqli_query($mysql, $db)) {
    echo mysqli_error($mysql);
}
if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
} 






$sqltable = "CREATE TABLE IF NOT EXISTS items (
		ID int AUTO_INCREMENT, 
		item varchar(150) NOT NULL,
		Brand varchar(15) NOT NULL,
		Quantity int(100) NOT NULL,
		Price varchar(20) NOT NULL,
		Category varchar(25) NOT NULL,
		Description text(1000) NOT NULL,
		Photoid varchar(255) NOT NULL,
		PRIMARY KEY(ID) 
		)";
		
$cart = "CREATE TABLE IF NOT EXISTS cart (
		ID int NOT NULL,
		Quantity int(100) NOT NULL
		)";
		
$record = "CREATE TABLE IF NOT EXISTS record (
		Ordernumber int AUTO_INCREMENT,
		Name varchar(150) NOT NULL,
		Email varchar(150) NOT NULL,
		Address varchar(150) NOT NULL,
		City varchar(30) NOT NULL,
		Province varchar(30) NOT NULL,
		Zip varchar(7) NOT NULL,
		Cardname varchar(50) NOT NULL,
		Creditcard int(16) NOT NULL,
		Cvv int(3) NOT NULL,
		Expirymonth varchar(20) NOT NULL,
		Expiryyear int(4) NOT NULL,
		PRIMARY KEY(Ordernumber)
		)";
		
$sold = "CREATE TABLE IF NOT EXISTS sold (
		Ordernumber int(10) NOT NULL,
		ID int(6) NOT NULL,
		Quantity int(3) NOT NULL
		)";
		
$refund = "CREATE TABLE IF NOT EXISTS refund (
			Ordernumber int(10) NOT NULL,
			ID int NOT NULL,
			Quantity int(3) NOT NULL
			)";
		
$mysql->query($sqltable);
$mysql->query($cart);	
$mysql->query($sold);
$mysql->query($record);
$mysql->query($refund);

$checkempty = $mysql->query("SELECT * FROM items");

if ($checkempty->num_rows == 0) {
		$csvFile = file("data.csv"); //import csv
		$data = [];
		$count = 0;
    foreach ($csvFile as $line) {
		if ($line[0] == "ID") { //skip the first line of csv
			continue;
		} else {
			$data[] = str_getcsv($line);
		}
    }
	
	foreach ($data as $line) {
		list($id, $item, $brand, $quantity, $price, $category, $desc, $photo) = $line;
		if ($id == "ID") 
		{
			continue;
		}
		$item = str_replace('"', '\"', str_replace("'", "''", $item)); //escape apostrophes and double quotation marks
		$desc = str_replace('"', '\\\\"', str_replace("'", "''", $desc));
		
		$insert = "INSERT INTO items (ID, item, Brand, Quantity, Price, Category, Description, Photoid)
		VALUES ('" . $id . "', '" . $item . "', '" . $brand . "', '" . $quantity . "', '" . $price . "', '" . $category . "', '" . $desc . "', 'Pictures/" . $photo . "')";
		if (!$mysql->query($insert)) {
			echo "Error importing data " . $mysql->error;
		} else {
			echo "Successfully imported row: " . $id . "<br>";
		}
	}
	echo "Ready to go <br> Redirecting you to index.php";
	
	
	mysqli_close($mysql);

} else {
	echo "File is already filled, you're ready to go! <br> Redirecting you to index.php";
}
//header("Refresh:5; url=index.php");
?>