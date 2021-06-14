<?php

require('./templates/header.php');

// redirect to homepage if logged in
if (isset($_SESSION['user'])) {
	header("location: ./index.php");
}

$email = $password = '';

// store errors to display in doc
$error_string = '';


if (isset($_POST['submit'])) {
	// get form field values 
	$email = $_POST['email'];
	$password = $_POST['password'];

	// validate password
	if (strlen($_POST['password']) < 7) {
		$error_string = 'password must contain atleast 7 characters';
	} else {
		// escape sql chars
		$email = mysqli_real_escape_string($conn, $email);
		$password = mysqli_real_escape_string($conn, $password);

		// hash password
		$password = password_hash($password, PASSWORD_DEFAULT);

		// create sql
		$sql = "insert into accounts(email, password) values ('$email', '$password')";

		// save to db and check
		if (mysqli_query($conn, $sql)) {
			//success
			$_SESSION['user'] = $email;
			header('location: index.php');
		} else {
			if (mysqli_errno($conn) == 1062) {
				$error_string = "Email already exists, login or use a different email";
				$password = $email = "";
			}
		}
	}
	// end of post check
}

?>
<link rel="stylesheet" href="./templates/form_styles.css">
<div class="wrapper">
	<h1>Sign Up</h1>
	<hr>
	<form method="post">
		<div class="errors"><?php echo $error_string; ?></div>
		<div class="form-row">
			<label for="email">Email:</label>
			<input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required />
		</div>
		<div class="form-row">
			<label for="password">Password:</label>
			<input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required />
		</div>
		<div class="form-row">
			<button name="submit">Done</button>
		</div>
	</form>
	<div class="small-snippet">
		Already have an account? <span><a href="login.php">Login</a></span>
	</div>
</div>
<?php
require('./templates/footer.php');
?>