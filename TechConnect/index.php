<html>
	<style>
		<?php include "stylesheet.css" ?>
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
	
	$result = $mysql->query("SELECT * FROM items ORDER BY item");
	$count = 0;
	if ($result->num_rows > 0) {
		// output data of each row
		echo '<div class="grid-container">';
		while($row = $result->fetch_assoc()) {
			
			echo '<a href="itemdetail.php?ItemID=' . $row["ID"] . '"><div class="grid-item">' ;
			echo '<img class="photo" src="' . $row["Photoid"] . '"></img>';
			echo "<p>" . $row["item"]. " " . $row["Brand"] . "</p>";
			
			echo '</div></a>';
			
			
		}
		echo "</div>";
	} else {
		echo "0 results";
	}

?>