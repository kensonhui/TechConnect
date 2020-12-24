
<html>
	<style>
		.button {
		background:url(refund.png) no-repeat;
		cursor:pointer;
		width: 25px;
		height: 25px;
		border: none;
}
	</style>
</html>


<?php 
	include("html.php");

	$mysql = new mysqli("localhost", "root", "", "inventory");


	$findorder = "SELECT * FROM record WHERE Ordernumber = " . $_POST["ordernumber"] . " LIMIT 1";
	
	$ordernumbertonextphp = $_POST["ordernumber"];
	
	$check = $mysql->query($findorder); //find customer record from order number and compare
	
		if ($order = $check->fetch_assoc()) {
			if ($_POST["fullname"] == $order["Name"] && $_POST["ordernumber"] == $order["Ordernumber"]) {
				echo "<p>Welcome " . $_POST["fullname"] . ". Your ordernumber is: " . $_POST["ordernumber"] . "</p>";
				$showitems = "SELECT * FROM sold WHERE Ordernumber = " . $_POST["ordernumber"];
				$items = $mysql->query($showitems);
				//setcookie("ordernumber", $_POST["ordernumber"]);
				if ($items->num_rows > 0) {
					echo ' <div class="confirmation-box"> <table>
							<tr>
								<th> Item </th>
								<th> Quantity </th>
								<th> Total Cost </th>
								<th> Amount </th>
								<th> Refund </th>
							</tr>';
					while ($displaysold = $items->fetch_assoc()) { //get all items associated with order number
						$itemdetail = "SELECT * FROM items WHERE ID = " . $displaysold["ID"] . " LIMIT 1";
						echo '<form action="refundconfirmation.php" method="post">';
						if ($details = ($mysql->query($itemdetail))->fetch_assoc()) { //get the name of the item
		
							echo '<tr> <td>' . $details["item"] . " </td><td>" . $displaysold["Quantity"] ."</td><td>" . 
								(double)str_replace("," , "" , str_replace("$", "", $details["Price"])) * (integer)$displaysold["Quantity"] . 
								'</td><td> <input type ="number" name="quantity" id ="quantity" min ="1" max="' . $displaysold["Quantity"] . '" value ="1"></td>
								 <td><input type="image" src="refund.png" class="button" name="source" id="source"></button></td></tr>
								 <input type="hidden" name="ordernumber" value="' . $_POST["ordernumber"] . '">
								 <input type="hidden" name="source" value="' . $displaysold["ID"] . '">';
							echo "</form>";
						}
					}
				echo "</table></div>";
				} else {
					echo "You have no items to refund.";
				}
			} else {
			echo "PLease recheck the name used in the purchase as well as the ordernumber";
			}
		}
	
		 echo $mysql->error;
	
	

?>