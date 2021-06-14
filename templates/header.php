<?php 

session_start();

require("./config/db_connect.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./templates/styles.css">
	<title>Employee Information System</title>
</head>
<body>
	<header>
		<nav class="navbar">
			<div class="brand-title nav-link"><a href="index.php">Employee Info</a></div>
			<a href="#" class="toggle-btn">
				<span class="bar"></span>
				<span class="bar"></span>
				<span class="bar"></span>
			</a>
			<div class="navbar-links">
				<ul>
					<!-- display email if logged in -->
					<?php echo isset($_SESSION['user']) ? '<li id="nav-email" class="nav-link">'.$_SESSION['user'].'</li>' : ''; ?>
					
					<?php	 
						// show add/view details link to logged in users who are not already in add page
						if(isset($_SESSION['user']) && !preg_match('/add\.php/', $_SERVER['PHP_SELF']))
						{
							echo "<li><a href='add.php'>Add</a></li>";
						}
						if(isset($_SESSION['user']) && !preg_match('/view\.php/', $_SERVER['PHP_SELF']))
						{
							echo "<li><a href='view.php'>View</a></li>";
						}
					?>

					<!-- login/logout -->
					<li class="nav-link"><?php echo isset($_SESSION['user']) ? "<a href='./logout.php'>Logout</a>" : "<a href='./login.php'>Login</a>"; ?></li>
				</ul>
			</div>
		</nav>
	</header>