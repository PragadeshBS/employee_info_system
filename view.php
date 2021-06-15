<?php

require('./templates/header.php');

$info_text = '';

//redirect signed out users to login page
if (!isset($_SESSION['user'])){
	header("Location: login.php?redirect=view");
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
<link rel="stylesheet" href="./templates/table_styles.css">
<style>
	#search-box{
		display: block;
		width: 60%;
		margin: 0 auto;
		padding: 20px;
		border: none;
		border-bottom: 1px solid lightslategray;
	}
	#search-box:focus{
		outline: none;
	}
	#print-btn{
		display: block;
		margin: 10px auto;
		padding: 15px 20px;
		font-size: 1.1rem;
		border: none;
		border-radius: 12px;
		background-color: lightsteelblue;
		color: #333;
		cursor: pointer;
	}
</style>
<div class="wrapper">
	<h1>View Employees Data</h1><hr>
	<div class="on-data">
		<small class="small-snippet">Click on an employee's id to update details</small>
		<form id="search-employees">
			<input type="text" placeholder="Search employees..." id="search-box">
		</form>
	</div>
	<div class="info"><?php echo $info_text; ?></div>
	<div style="overflow-x:auto;" id="table-container">
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
					echo "<th>Delete</th>";
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
						<form method='POST'>
							<input type='hidden' name='emp_id_to_delete' value='".$employee['emp_id']."'>
							<td><button type='submit' name='delete'><span>X</span></button></td>
						</form>
					</tr>
				";
			}
		?>
	</table>
	</div>
	<?php
		if($keys){
			echo "<button id='print-btn'>Print Table</button>";
		}
	?>
</div>
<script>
	const printButton = document.getElementById('print-btn');
	const searchBox = document.getElementById('search-box');
	const tableRows = [...document.getElementsByTagName('tr')].slice(2);
	const onDataElements = document.getElementsByClassName('on-data');
	console.log(tableRows);

	const dataAvailable = <?php echo $keys ? 'true' : 'false'; ?>;
	if (!dataAvailable){
		onDataElements[0].style.display = 'none';
	}

	printButton.addEventListener('click', (e) => {
		// open new page with table and print after page loads
		var newWindow = window.open('print_table.php');
		setTimeout(() => {
			newWindow.print();
			// close page after print
			newWindow.close();
		}, 300)
	});

	//search
	searchBox.addEventListener('keyup', e => {
		const searchTerm = e.target.value.toLowerCase();
		tableRows.forEach(elem => {
			console.log(elem);
			let visible = false;
			const tableCells = [...elem.children].slice(0, 8);
			tableCells.forEach(cell => {
				if(cell.textContent.toLocaleLowerCase().indexOf(searchTerm) != -1){
					visible = true;
				}
			})
			// show/hide rows
			if (!visible){
				elem.style.position = 'absolute';
				elem.style.top = '-99999px';
			} else {
				elem.style.position = 'initial';
			}
		})
	})
</script>

<?php
require('./templates/footer.php');
?>