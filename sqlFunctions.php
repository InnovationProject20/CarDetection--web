<?php
	session_start();
	
	function dbConnection() {
		$servername = "localhost";
		$username = "DBinnovation";
		$password = "DBinnovation123";
		$dbname = "licenseDB";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		else{
			print("Connection successful\n\r");
			return $conn;
		}
	}
	
	function returnLatestLicensePlate($conn) {
		
	}

	//$licenseTest = "IVY-457";
	$licenseTest = $_SESSION['licensePlate'];


	$sqlSearch = "SELECT fuelType FROM cars WHERE licensePlate='$licenseTest'";
	$result = mysqli_query($conn,$sqlSearch);

	$data = array();
	
	foreach ($result as $row) {
		$data[] = $row;
	}
	//print "<pre>"; print_r($data); print "</pre>";


	if(!(empty($data))) {
		echo "found";
	}
	else {
		echo "not found";
	}




	return

	mysqli_close($conn);
?>
