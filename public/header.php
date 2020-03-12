<?php
//include 'includes/class-autoload.php';
require_once 'core/init.php';
require 'config.php';
$user = new User();

?>

<!DOCTYPE html>
<html>
	<head>
		<title>ibuy Auctions</title>
		 <meta charset="UTF-8" />
		<link rel="stylesheet" href="ibuy.css" />
		<!-- <link rel="stylesheet" href="form.css" /> -->
	</head>

	<body>
		<header>
		<a href="home.php"><h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1></a>
		<div class="header-form">
			<form class= "searchform" action="search.php" method="GET">
				<div class="searchAndSubmit">
					<input type="text" name="search" placeholder="Search for anything" />
					<input type="submit" name="submit" value="Search" />
				</div>
				<div id="nav-login">
					<?php 
						if($user->isLoggedin()){
							?>
					<a href="administration.php">Admin Panel</a> 
					<a href="signout.php">Logout</a> <!--change 'login' text to logout when user's logged in -->
							<?php
						} else {
							?>
					<a href="signin.php">Login</a> <!--change 'login' text to logout when user's logged in -->
					<a href="signup.php">Sign up</a> <!--hide when users logged in -->
							<?php
						}
					?>

				</div>
			</form>
		</div>
		</header>

		<img src="images/randombanner.php" alt="Banner" />

<nav>

		<ul>	<?php

					$results = $pdo->query('SELECT * FROM categories ');
				foreach ($results as $row) {
					$category_name = $row['category_name'];
					?>
					
						<li><a href="product.php?page=<?php echo $category_name; ?>&categoryID=<?php echo $row['category_id'];?>"><?php echo $category_name; ?>  </a></li>
					
			<?php
				}

			?></ul>

</nav>