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
</head>

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
		print("Connection successful\n\r");
	}
	
	$recordSearch = "SELECT * FROM records";
	$recordResult = mysqli_query($conn,$recordSearch);

	$recordData = array();
	
	foreach ($recordResult as $row) {
		$recordData[] = $row;
	}
	//echo "RECORDS:", "<br>";
	//print "<pre>"; print_r($recordData); print "</pre>";
	
	$trafiSearch = "SELECT * FROM trafi";
	$trafiResult = mysqli_query($conn,$trafiSearch);

	$trafiData = array();

	foreach ($trafiResult as $row) {
		$trafiData[] = $row;
	}
	
	echo "TRAFI:", "<br>";
	//print "<pre>"; print_r($trafiData); print "</pre>";
	
	$piSearch = "SELECT * FROM piInfo";
	$piResult = mysqli_query($conn,$piSearch);

	$piData = array();

	foreach ($piResult as $row) {
		$piData[] = $row;
	}
	
	//echo "PI:", "<br>";
	//print "<pre>"; print_r($piData); print "</pre>";
	
	mysqli_close($conn); 
?>

<body data-spy="scroll" data-target=".navbar" data-offset="60">
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
		<h1>License Plate recognition</h1> 
		<div>
			<p>WELCOME to the Helsinki Metropolia University of Helsinki and Nokia collaboration for Spring 2020 Innovation Project</p>
		</div>
	</div>
	
	<div class="container-fluid bg-grey">
		<div class="row-md-12">
			<table class="table" id="trafiTable">
				<caption>
					<span><strong>Trafi Database</strong></span>
				</caption>
				<thead>
					<tr>
						<th>License Plate Number</th>
						<th>Brand</th>
						<th>Model</th>
						<th>Fuel Type</th>
					</tr>
				</thead>
			<tbody>
				<?php
					foreach($trafiData as $row) {
						echo '<tr>';
						echo '<td>'.$row['licensePlate'].'</td>';
						echo '<td>'.$row['brand'].'</td>';
						echo '<td>'.$row['model'].'</td>';
						echo '<td>'.$row['fuelType'].'</td>';
						echo '</tr>';
					}
				?>
			</tbody>
			</table>
		</div>
	</div>
	
	<div class="container-fluid bg-grey">
		<div class="row-md-12">
			<table class="table" id="recordTable">
				<caption>
					<span><strong>Records Database</strong></span>
				</caption>
				<thead>
					<tr>
						<th>License Plate Number</th>
						<th>Accuracy</th>
						<th>Time</th>
					</tr>
				</thead>
			<tbody>
				<?php
					foreach($recordData as $row) {
						echo '<tr>';
						echo '<td>'.$row['licensePlate'].'</td>';
						echo '<td>'.$row['accuracy'].'</td>';
						echo '<td>'.$row['timeStamp'].'</td>';
						echo '</tr>';
					}
				?>
			</tbody>
			</table>
		</div>
	</div>
	
	<div class="container-fluid bg-grey">
		<div class="row-md-12">
			<table class="table" id="piTable">
				<caption>
					<span><strong>Raspberry Pi Database</strong></span>
				</caption>
				<thead>
					<tr>
						<th>IDr</th>
						<th>Location</th>
					</tr>
				</thead>
			<tbody>
				<?php
					foreach($piData as $row) {
						echo '<tr>';
						echo '<td>'.$row['piID'].'</td>';
						echo '<td>'.$row['piLocation'].'</td>';
						echo '</tr>';
					}
				?>
			</tbody>
			</table>
		</div>
	</div>
	<script>
		$('#trafiTable').dataTable( {} );
		$('#recordTable').dataTable( {} );
		$('#pi').dataTable( {} );
	</script>
</body>
</html>

