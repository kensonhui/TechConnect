<html>
	<style>
		<?php include "stylesheet.css" ?>
	</style>
</html>


<?php
include("html.php");
$mysql = new mysqli("localhost", "root", "", "inventory") or die(mysqli_error());
mysqli_select_db($mysql, "inventory") or die(mysqli_error());

$output = '';

if(isset($_GET['search'])) {
	$searchq = $_GET['search'];
	$searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);
	$query = mysqli_query($mysql, 'SELECT * FROM items WHERE Item LIKE "%' . $searchq . '%" OR Brand LIKE "%' . $searchq . '%"') or die(mysqli_error($mysql));
	$mysql->error;
	$count = mysqli_num_rows($query);
	if($count == 0) {
		$output = 'No results matching your search';
	} else {
		echo '<div class="grid-container">';
		while($row = mysqli_fetch_array($query)) {
			$item = $row["item"];
			$brand = $row["Brand"];
			$id = $row["ID"];
			$photo = $row["Photoid"];
			
			$output .= '<div class="grid-item"> <a href = itemdetail.php?ItemID=' . $row["ID"] . '><img class="photo" src="' . $photo . '"></img><p>' . $item . "s" . '</p></a></div>';
			
		}
	}
	echo $output;
	
}
?>
