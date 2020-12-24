<?php

// Create connection
$mysql = new mysqli("localhost", "root", "", "inventory");

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
} else {
	echo "Connected successfully";
}

$sql = "CREATE DATABASE IF NOT EXISTS inventory";

if (mysqli_query($mysql, $sql)) {
    echo "Database created successfully <br>";
} else {
    echo "Error creating database: " . mysqli_error($mysql);
}

$sqltable = "CREATE TABLE IF NOT EXISTS items (
		ID int AUTO_INCREMENT, 
		item varchar(150) NOT NULL,
		Brand varchar(15) NOT NULL,
		Quantity int(100) NOT NULL,
		Price varchar(20) NOT NULL,
		Category varchar(25) NOT NULL,
		Description varchar(20) NOT NULL,
		Photoid varchar(255) NOT NULL,
		PRIMARY KEY(ID) 
		)";
		
if ($mysql->query($sqltable) === TRUE) {
    echo "Table items created successfully <br>";
} else {
    echo "Error creating table: " . $mysql->error;
}

$result = $mysql->query("SELECT * FROM items");

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["ID"]. " - Name: " . $row["item"]. " " . $row["Brand"]. "<br>";
    }
} else {
    echo "0 results";
}



$mysql->close();
?>