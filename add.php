<?php

require('./templates/header.php');

//redirect signed out users to login page
if (!isset($_SESSION['user'])){
	header("Location: login.php?redirect=add");
}

$name = $emp_id = $dob = $gender = $salary = $designation = $email = $mobile = '';

// to keep track of data submisson
$success = false;

// store errors to display in doc
$error_msg = '';

if(isset($_POST['submit'])){
	// get data from submitted form
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$emp_id = mysqli_real_escape_string($conn, $_POST['emp_id']);
	$dob = mysqli_real_escape_string($conn, $_POST['dob']);
	$gender = mysqli_real_escape_string($conn, $_POST['gender']);
	$salary = mysqli_real_escape_string($conn, $_POST['salary']);
	$designation = mysqli_real_escape_string($conn, $_POST['designation']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

	$sql = "INSERT INTO employees(name, emp_id, dob, gender, salary, designation, email, mobile) 
	VALUES ('$name', '$emp_id','$dob', '$gender', '$salary', '$designation', '$email', '$mobile')";

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
<link rel="stylesheet" href="./templates/form_styles.css">
<div class="wrapper">
	<h1>Add Employee Details</h1><hr>
	<div class="info">
		<?php 
			if($success)
			{
				echo "Employee data added successfully!<br>
				<a href='view.php'>View all data</a>";
			} 
		?>
	</div>
	<div class="errors">
		<?php echo $error_msg; ?>
	</div>
	<form action="" method="POST">
		<div class="form-row">
			<label for="name">Name: </label>
			<input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>
		</div>
		<div class="form-row">
			<label for="emp_id">Employee Id: </label>
			<input type="text" name="emp_id" id="emp_id" value="<?php echo htmlspecialchars($emp_id); ?>" required>
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
			<button name="submit">Add</button>
		</div>
	</form>
</div>
<?php
require('./templates/footer.php');
?>