<?php

require('./templates/header.php');

//redirect signed out users to login page
if (!isset($_SESSION['user'])){
	header("Location: login.php");
}

// to store and display misc data
$info_text = '';
$name = $emp_id = $dob = $gender = $salary = $designation = $email = $mobile = '';

//show 404 for invalid employee ids
$page_not_found = true;

// to keep track of data submisson
$success = false;

// store errors to display in doc
$error_msg = '';

if (isset($_REQUEST['emp_id'])){
	$emp_id = $_REQUEST['emp_id'];
	$page_not_found = false;
}

if(isset($_POST['delete'])){	
	$emp_id_to_delete = mysqli_real_escape_string($conn, $_POST['emp_id_to_delete']);
	$sql = "DELETE FROM employees WHERE emp_id='$emp_id_to_delete'";
	if(mysqli_query($conn, $sql)){
		//success
		$info_text = 'Employee data deleted successfully';
	} else {
		echo "Query error: ". mysqli_error($conn);
	}
}

$sql = "SELECT * FROM employees WHERE emp_id='$emp_id'";

$result = mysqli_query($conn, $sql);

if (!mysqli_num_rows($result)){
	$page_not_found = true;
}

$employee = mysqli_fetch_assoc($result);

if(!($page_not_found))
{
	$name = $employee['name'];
	$emp_id = $employee['emp_id'];
	$designation = $employee['designation'];
	$dob = $employee['dob'];
	$gender = $employee['gender'];
	$salary = $employee['salary'];
	$email = $employee['email'];
	$mobile = $employee['mobile'];
}

// post check
if(isset($_POST['submit'])){
	// get data from submitted form
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$dob = mysqli_real_escape_string($conn, $_POST['dob']);
	$gender = mysqli_real_escape_string($conn, $_POST['gender']);
	$salary = mysqli_real_escape_string($conn, $_POST['salary']);
	$designation = mysqli_real_escape_string($conn, $_POST['designation']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

	$sql = "UPDATE employees SET name='$name', dob='$dob', gender='$gender', salary='$salary', 
		designation='$designation', email='$email', mobile='$mobile' WHERE emp_id = '$emp_id'";

	if (mysqli_query($conn, $sql)){
		$success = true;
		//reset form
		$name = $emp_id = $dob = $gender = $salary = $designation = $email = $mobile = '';
	} else {
		if(mysqli_error($conn)){
			// use regex to find duplicate errors
			if (preg_match("/^Duplicate\sentry.*emp_id'$/", mysqli_error($conn))){
				$error_msg = 'Employee id already exists';
			} else if (preg_match("/^Duplicate\sentry.*email'$/", mysqli_error($conn))){
				$error_msg = 'Email id already exists';
			} else if (preg_match("/^Duplicate\sentry.*mobile'$/", mysqli_error($conn))){
				$error_msg = 'Mobile no. already exists';
			} else {
				$error_msg = "Query error: ".mysqli_error($conn);
			}
		}
	}
}

?>
<style>
	.no-user{
		padding: 80px 0 0;
		width: 80%;
		margin: 0 auto;
		text-align: center;
	}
	.no-user h2{
		color: crimson;
	}
</style>
<link rel="stylesheet" href="./templates/form_styles.css">
<div class="wrapper">
	<h1>Update Employee Details</h1><hr>
	<div class="info">
		<?php 
			if($success)
			{
				echo "Employee data updated successfully!<br>
				<a href='view.php'>View all data</a>";
			} 
		?>
	</div>
	<div class="no-user"><?php if ($page_not_found){echo "<h2>No such user exists :/</h2>";}?></div>
	<div class="errors">
		<?php echo $error_msg; ?>
	</div>
	<form method="POST">
		<div class="form-row">
			<label for="name">Name: </label>
			<input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>
		</div>
		<div class="form-row">
			<label for="emp_id">Employee Id: </label>
			<input type="text" name="emp_id" id="emp_id" value="<?php echo htmlspecialchars($emp_id); ?>" required disabled>
		</div>
		<div class="form-row">
			<label for="dob">Date of Birth: </label>
			<input type="date" name="dob" id="dob" value="<?php echo htmlspecialchars($dob); ?>" required>
		</div>
		<div class="form-row">
			<label for="gender">Gender: </label>
			<select name="gender" id="gender" required>
				<option value="male" <?php if($gender == "male"){echo 'selected';}?> >Male</option>
				<option value="female" <?php if($gender == "female"){echo 'selected';}?> >Female</option>
			</select>		
		</div>
		<div class="form-row">
			<label for="salary">Salary: </label>
			<input type="number" name="salary" id="salary" value="<?php echo htmlspecialchars($salary); ?>" required>
		</div>
		<div class="form-row">
			<label for="designation">Designation: </label>
			<input type="text" name="designation" id="designation" value="<?php echo htmlspecialchars($designation); ?>" required>
		</div>
		<div class="form-row">
			<label for="email">Email: </label>
			<input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
		</div>
		<div class="form-row">
			<label for="mobile">Mobile No.: </label>
			<input type="number" name="mobile" id="mobile" value="<?php echo htmlspecialchars($mobile); ?>" required>
		</div>
		<div class="form-row">
			<button name="submit">Update</button>
		</div>
	</form>
</div>

<script>
	const noUserContent = document.getElementsByClassName('no-user')[0].textContent;
	const noUserDiv = document.getElementsByClassName('no-user')[0];
	if(!noUserContent){
		noUserDiv.style.display = 'none';
	}
	const userValid = <?php echo $page_not_found ? 'false' : 'true'; ?>;
	if(!userValid){
		document.forms[0].style.display = 'none';
	}
</script>

<?php
require('./templates/footer.php');
?>