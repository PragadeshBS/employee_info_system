<?php

	$hostname = "localhost";
	$username = "root";
	$password = "";

	$conn = mysqli_connect($hostname, $username, $password);

	if(!$conn){
		die('Connection error: '. mysqli_connect_error());
	}

	$db_selected = mysqli_select_db($conn, 'employees_info');

	// create db if not exists
	if (!$db_selected){

		echo 'Could not find database "employees_info", creating one...<br>';
		$sql = "CREATE DATABASE employees_info";

		if (mysqli_query($conn, $sql)){
			echo '"employees_info" database created<br>';
			$conn = mysqli_connect($hostname, $username, $password, 'employees_info');

			echo "creating tables...<br>";
			// create accounts table for users
			$table1_sql = 'CREATE TABLE accounts(id int AUTO_INCREMENT, email varchar(255) UNIQUE, password varchar(255), PRIMARY KEY(id))';
			mysqli_query($conn, $table1_sql);

			// create employees table for data
			$table2_sql = "CREATE TABLE employees(id int AUTO_INCREMENT, emp_id varchar(255) UNIQUE, name varchar(255), designation varchar(255), dob varchar(255), gender varchar(255), salary int, email varchar(255) UNIQUE, mobile varchar(255) UNIQUE, PRIMARY KEY(id))";
			mysqli_query($conn, $table2_sql);

			// insert dummy data
			$dummy_data_sql = "INSERT INTO employees(emp_id, name, designation, dob, gender, salary, email, mobile) 
			VALUES('h001', 'Jack', 'Clerk', '1975-05-05', 'male', '30000', 'jack@mail.com', '9958845623')";
			mysqli_query($conn, $dummy_data_sql);

			$dummy_data2_sql = "INSERT INTO employees(emp_id, name, designation, dob, gender, salary, email, mobile) 
			VALUES('h005', 'Mary', 'Manager', '1972-09-23', 'female', '70000', 'mary@mail.com', '9786141624')";
			mysqli_query($conn, $dummy_data2_sql);
			echo "created required tables and filled in dummy data<br>";

		}
		else
		{
			die('Could not create db: '.mysqli_error($conn));
		}
	}
	
?>