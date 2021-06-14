<?php

require('./templates/header.php');

$logged_in = false;

if (isset($_SESSION['user']))
{
	$logged_in = true;
}
else

?>
<style>
	.login-info{
		margin: 0 auto;
		color: #333;
		padding: 20vh 0;
		text-align: center;
	}
	.login-info h1{
		color: purple !important;
		padding: 30px 0;
	}
	.cards{
		display: flex;
		flex-direction: column;
		margin: 0 auto;
		padding: 30px 0;
		justify-content: space-between;
		align-items: center;
	}
	.card{
		min-width: 200px;
		max-width: 380px;
		border: 1px solid grey;
		border-radius: 12px;
		padding: 30px;
		margin: 0 50px 30px;
		text-align: center;
	background: linear-gradient(90deg, #eb554d, #eb4b47, #eb4243, #eb3c42, #eb3742, #ec3142, #ec2b42, #ec2643, #ec2044, #ed1a45, #ed1447, #eb114a);
	}
	.cards a{
		color: #fff;
	}
	.user-info{
		color: grey;
		padding: 30px;
		text-align: center;
	}
	.email{
		color: steelblue;
	}
</style>

<div class="wrapper">
	<?php
	if (!$logged_in){
		echo "<div class='login-info'>
		<a href='./login.php'><h1>Login</h1></a><h3>To view or add employee information</h3>
		</div>";
	} else {
		echo "
		<div class='user-info'>Logged in as <h2 class='email'>".$_SESSION['user']."</h2></div>
		<div class='cards'>
			<div class='card'><a href='add.php'><h2>Add employee information</h2><a/></div>
			<div class='card'><a href='view.php'><h2>View employee information</h2></a></div>
		<div>";
	}
	?>
</div>
<?php
require('./templates/footer.php');
?>