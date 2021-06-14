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

<?php

//redirect signed out users to login page
if (!isset($_SESSION['user'])){
	header("Location: login.php?redirect=view");
}


$sql = "SELECT * FROM employees";

$result = mysqli_query($conn, $sql);

// get associative array from results
$employees = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result and close connection
mysqli_free_result($result);

mysqli_close($conn);
if ($employees){
	$keys = array_keys($employees[0]);
} else {
	$keys = false;
}

?>
<style>
	td:nth-last-child(1){
		padding: 15px !important;
	}
</style>
<link rel="stylesheet" href="./templates/table_styles.css"><div class="wrapper">
	<h1>Employees Data</h1><hr>
	<div style="overflow-x:visible;" id="table-container">
		<table>
			<tr>
				<thead>
				<?php
					if ($keys){
						foreach($keys as $key){
							switch ($key){
								case 'name':
									echo "<th>Name</th>";
									break;
								case 'emp_id':
									echo "<th>Employee Id</th>";
									break;
								case 'dob':
									echo "<th>Date of Birth</th>";
									break;
								case 'gender':
									echo "<th>Gender</th>";
									break;
								case 'salary':
									echo "<th>Salary</th>";
									break;
								case 'designation':
									echo "<th>Designation</th>";
									break;
								case 'email':
									echo "<th>Email</th>";
									break;
								case 'mobile':
									echo "<th>Mobile</th>";
									break;					
							}
						}						
					} else {
						echo "<div class='no-data'>No data to show<br>
							<a href='add.php'>Add data</a></div>
							";
					}
				?>
				</thead>
			</tr>
			<?php
				foreach($employees as $employee){
					$emp_id = $employee['emp_id'];
					echo "				
						<tr>
							<td><a href='update.php?emp_id=$emp_id'>".htmlspecialchars($emp_id)."</a></td>
							<td>".htmlspecialchars($employee['name'])."</td>
							<td>".htmlspecialchars($employee['designation'])."</td>
							<td>".htmlspecialchars($employee['dob'])."</td>
							<td>".htmlspecialchars($employee['gender'])."</td>
							<td>".htmlspecialchars($employee['salary'])."</td>
							<td>".htmlspecialchars($employee['email'])."</td>
							<td>".htmlspecialchars($employee['mobile'])."</td>							
						</tr>
					";
				}
			?>
		</table>
	</div>
</div>