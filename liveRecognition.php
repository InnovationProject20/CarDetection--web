<!DOCTYPE html>
<html lang="en">
<head>
	<title>License Plate Recognition</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
	<link rel = "stylesheet" type = "text/css" href = "webStyle.css" />
<?php
	//session_start();
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
		//print("Connection successful\n\r");
	}
	$recordSearch = "SELECT records.licensePlate, records.timeStamp, records.accuracy, piInfo.piLocation FROM records JOIN piInfo ON records.piID = piInfo.piID WHERE timeStamp >= now() - interval 2 minute ORDER BY timeStamp DESC";
	$recordResult = mysqli_query($conn,$recordSearch);

	$recordData = array();
	
	foreach ($recordResult as $row) {
		$recordData[] = $row;
	}
	//print "<pre>"; print_r($recordData); print "</pre>";

	if(!(empty($recordData))) {
		$licensePlate = $recordData[0]['licensePlate'];
		$timeStamp = $recordData[0]['timeStamp'];
		$accuracy = $recordData[0]['accuracy'];
		$location = $recordData[0]['piLocation'];
		
		$trafiSearch = "SELECT * FROM trafi WHERE licensePLate = '$licensePlate'";
		$trafiResult = mysqli_query($conn,$trafiSearch);

		$trafiData = array();
	
		foreach ($trafiResult as $row) {
			$trafiData[] = $row;
		}
		
		//print "<pre>"; print_r($trafiData); print "</pre>";
		
		$brand = $trafiData[0]['brand'];
		$model = $trafiData[0]['model'];
		$fuelType = $trafiData[0]['fuelType'];
	}
	else {
		$licensePlate = "";
		$timeStamp = "";
		$accuracy = "";
		
		echo "NO PLATE SEEN";
	}
	
	mysqli_close($conn); 
?>

</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>                        
				</button>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php">HOME</a></li>
					<li><a href="liveRecognition.php">LIVE RECOGNITION</a></li>
					<li><a href="dataTables.php">DATA</a></li>
					<li><a href="about.php">ABOUT PROJECT</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="jumbotron text-center">
		<h1>Live License Plate Recognition</h1> 
		<p>The table below returns the current license plate being seen by the Raspberry Pi camera. It only shows entries made within the last 2 minutes.</p>
	</div>

	<div class="container-fluid bg-grey">
		<div class="row-md-12">
			<table class="table" id="resultTable">
				<thead>
					<tr>
						<th>License Plate Number</th>
						<th>Brand</th>
						<th>Model</th>
						<th>Fuel Type</th>
						<th>Accuracy</th>
						<th>Location</th>
						<th>Time</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php
						echo '
						<td>' . $licensePlate . '</td>
						<td>' . $brand . '</td>
						<td>' . $model . '</td>
						<td>' . $fuelType . '</td>
						<td>' . $accuracy . '</td>
						<td>' . $location . '</td>
						<td>' . $timeStamp . '</td>';
						?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
<script>
	//reload page every 60 seconds
	setTimeout(function () { 
		location.reload();
    },  * 1000);
	$('#resultTable').dataTable( {
		"searching": false,
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bInfo": false,
		"bAutoWidth": false,
	} );
</script>
</body>
</html>
