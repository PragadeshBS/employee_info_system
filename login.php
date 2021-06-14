<?php

require('./templates/header.php');

// redirect to page as per request
if (isset($_REQUEST['redirect'])) {
	switch ($_REQUEST['redirect']) {
		case "add":
			$redirect_page = 'add.php';
			break;
		case "view":
			$redirect_page = 'view.php';
			break;
		default:
			$redirect_page = 'index.php';
			break;
	}
} else {
	//default to index page
	$redirect_page = 'index.php';
}

//redirect once logged in
if (isset($_SESSION['user'])) {
	header("location: $redirect_page");
}

$email = $password = '';

// store errors to display in doc
$error_string = '';

if (isset($_POST['submit'])) {
	// get form field values 
	$email = $_POST['email'];
	$password = $_POST['password'];

	// escape sql chars
	$email = mysqli_real_escape_string($conn, $email);
	$password = mysqli_real_escape_string($conn, $password);

	// create sql
	$sql = "SELECT password FROM accounts WHERE email='$email'";

	$result = mysqli_query($conn, $sql);

	//verify password
	if (!mysqli_num_rows($result)) {
		//no rows -> username not in db
		$error_string =  "Email not found<br />Sign Up or use a registered email";
	} else if (password_verify($password, mysqli_fetch_assoc($result)['password'])) {
		//success
		$_SESSION['user'] = $email;
		header("Location: $redirect_page");
	} else {
		//incorrect password
		$error_string = 'Incorrect password, try again';
	}

	// end of post check
}

?>
<link rel="stylesheet" href="./templates/form_styles.css">
<div class="wrapper">
	<h1>Login</h1>
	<hr>
	<div class="info">
		<?php if ($redirect_page != 'index.php') {
			echo "Sign in to continue...";
		}
		?>
	</div>
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
		Don't have an account yet? <span><a href="signup.php">Sign Up</a></span>
	</div>
</div>
<?php
require('./templates/footer.php');
?>