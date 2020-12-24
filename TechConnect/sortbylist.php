<html>
	<style>
		.grid-container {  
			display: grid; 
			grid-template-columns: auto auto auto auto auto;
			grid-column-gap: 25px;
			grid-row-gap: 25px;
			height: 200px;
			width: 300px;
            }  
		.grid-item {
		  background-color: rgba(255, 255, 255, 0.8);
		  border: 1px solid rgba(0, 0, 0, 0.8);
		  padding: 20px;
		  font-size: 20px;
		  text-align: left;
		}
		.photo {
			height: 200px;
			width: 200px;
			overflow: hidden;
		}	
			
	</style>
	
	
</html>
	

<?php
include("html.php");	
	
$mysql = new mysqli("localhost", "root", "", "inventory");

echo $_GET["Division"] . ": " . $_GET["List"] . "<br>";


$items = $mysql->query("SELECT * FROM items WHERE " . $_GET["Division"] . " = '" . $_GET["List"] . "' ORDER BY item" ); //finds all items of each category alphabetically
echo '<div class="grid-container">';
while($select = $items->fetch_assoc()) {
		echo "<a href = itemdetail.php?ItemID=" . $select["ID"] . '><div class="grid-item"><img class="photo" src="' . $select["Photoid"] . '"></img><p>' . $select["item"] . '</p></div></a>';
		
	}
	echo '</div>';
echo $mysql->error;
?>