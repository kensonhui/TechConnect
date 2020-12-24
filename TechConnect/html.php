<html>
	<head>
		<style>
			<?php include "stylesheet.css" ?>
		</style>
	</head>
<body>

<div class="sidenav">
	<div class="dropdown">
	<button class="dropbtn" style="font-family: Century Gothic;">Brands</button>
	<div class="dropdown-content">
	
	<?php 
		$mysql = new mysqli("localhost", "root", "", "inventory");
		
		$result = $mysql->query("SELECT DISTINCT Brand FROM items ORDER BY item");
		$sortby = "Brand";
		$count = 0;
		while($row = $result->fetch_assoc()) {
			$category[$count] = $row[$sortby]; //saves each category into an array
			$link = str_replace(' ', '%20', $category[$count]); //trim spaces between words
			//sends to script that displays a list of chosen category and brand
			echo '<a href = sortbylist.php?Division=' . $sortby . '&List=' . $link . ">" . $row[$sortby] . "s" . "</a><br>";
		}
				
		?>
		<html>
	</div>
	</div>
	<div class="dropdown">
	<button class="dropbtn" style="font-family: Century Gothic;">Categories</button>
	<div class="dropdown-content">
	</html>
	
		<?php 
		$mysql = new mysqli("localhost", "root", "", "inventory");
		
		$result = $mysql->query("SELECT DISTINCT Category FROM items ORDER BY Category");
		$sortby = "Category";
		$count = 0;
		while($row = $result->fetch_assoc()) {
			$category[$count] = $row[$sortby]; //saves each category into an array
			$link = str_replace(' ', '%20', $category[$count]); //trim spaces between words
			//sends to script that displays a list of chosen category and brand
			echo "<a href = sortbylist.php?Division=" . $sortby . "&List=" . $link . ">" . $row[$sortby] . "s" . "</a><br>";
			$count++;
		}
				
		?>
		<html>
	</div>
	</div>
</div>

<div id="banner">
	<marquee> 
		<span>Welcome to our website! </span>
	</marquee>
</div>

<div class="topnav">
	
  <a class="active" href="index.php">Home</a>
  <a href="about.php">About</a>
  <a href="refund.php">Refund</a>
  <a href="cart.php"> Go to Cart </a>
  <div class="search-container">
    <form action="searchbar.php" method="get">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>
</div>




</body>
</html>

<?php
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
		while($row = mysqli_fetch_array($query)) {
			$item = $row["item"];
			$brand = $row["Brand"];
			$id = $row["ID"];
			
			$output .= '<div>' . '<a href = itemdetail.php?ItemID=' . $row["ID"] . ">" . $item . "s" . '</a>' . '</div>';
			
		}
	}
	echo $output;
	
}
?>