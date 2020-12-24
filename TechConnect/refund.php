<?php

include("html.php");


?>

<html>
	<style>
		<?php include "stylesheet.css" ?>
	</style>
<form action="refundlist.php" method="post">
	<p> Please fill in the following information in order to refund</p>
	<p> Full Name </p>
	<input type="text" name="fullname" required>
	<p> Ordernumber </p>
	<input type="text" name="ordernumber" required>
	<input type="submit">
</form>


</html>