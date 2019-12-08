
<?php
error_reporting(0);
//Accessable From Everywhere
header("Access-Control-Allow-Origin: *");

//Establish Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airbus";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$requestType = $_SERVER["REQUEST_METHOD"];

//Create
if($requestType == "POST" AND !isset($_POST['pp'])){
	extract($_POST);
	$insertQuery = "INSERT INTO flights (origin, destination, departure_date, departure_time, arrival_date, arrival_time, economy_fare, premium_economy_fare, business_fare) VALUES ('$origin', '$destination', '$departure_date', '$departure_time', '$arrival_date', '$arrival_time', '$economy_fare', '$premium_economy_fare', '$business_fare');";
	if ($conn->query($insertQuery) === TRUE) echo "New Record Added Successfully.";
	else echo "Error: " . $insertQuery . "<br>" . $conn->error;
}

//Create
if($requestType == "POST" AND isset($_POST['pp'])){
	extract($_POST);
	$passengers = "Mr. Gurmeet Singh";
	$insertQuery = "INSERT INTO transactions (flight_id, passengers, price, email, phone) VALUES ('$flight_id', '$passengers', '$pp', '$email', '$phone');";
	if ($conn->query($insertQuery) === TRUE) echo "New Record Added Successfully.";
	else echo "Error: " . $insertQuery . "<br>" . $conn->error;
}

//Read
if($requestType == "GET" AND !isset($_GET["id"]) AND !isset($_GET["flight_search"])){
	$selectQuery = "SELECT * FROM flights";
	$result = $conn->query($selectQuery);
	$rows = array();
	while($row = $result->fetch_assoc())
		$rows[] = $row;
	header("Content-Type: application/json");
	echo json_encode($rows);
}

//Read ORIGN DESTINATION
if($requestType == "GET" AND isset($_GET["flight_search"]) AND !isset($_GET["id"])){
	$origin = $_GET['origin'];
	$destination = $_GET['destination'];
	if(strlen($_GET['date']) > 1) $date = $_GET['date'];
	else $date = date('Y-m-d');
	$selectQuery = "SELECT * FROM flights WHERE origin = '$origin' AND destination = '$destination' AND departure_date = '$date'";
	$result = $conn->query($selectQuery);
	$rows = array();
	while($row = $result->fetch_assoc())
		$rows[] = $row;
	header("Content-Type: application/json");
	echo json_encode($rows);
}

//Read Only One
if($requestType == "GET" AND isset($_GET["id"])){
	$id = $_GET["id"];
	$selectQuery = "SELECT * FROM flights WHERE ID = $id";
	$result = $conn->query($selectQuery);
	$rows = array();
	if ($result->num_rows > 0){
		while($row = $result->fetch_assoc())
			$rows[] = $row;
		header("Content-Type: application/json");
		echo json_encode($rows);
	}
	else echo "Not Found.";
}

//Update
if($requestType == "PUT"){
	$str = file_get_contents("php://input");
	$_PUT = array();
	parse_str($str, $_PUT);
	extract($_PUT);
	$updateQuery = "UPDATE flights SET origin = '$origin', destination = '$destination', departure_date = '$departure_date', departure_time = '$departure_time', arrival_date = '$arrival_date', arrival_time = '$arrival_time', economy_fare = '$economy_fare', economy_fare = '$premium_economy_fare', business_fare = '$business_fare' WHERE id = $id;";
	if ($conn->query($updateQuery) === TRUE) echo "Record Updated Successfully.";
	else echo "Error: " . $updateQuery . "<br>" . $conn->error;
}

//Delete
if($requestType == "DELETE"){
	$str = file_get_contents("php://input");
	$_DELETE = array();
	parse_str($str, $_DELETE);
	extract($_DELETE);
	$deleteQuery = "DELETE FROM flights WHERE id = $id";
	if ($conn->query($deleteQuery) === TRUE) echo "Record Deleted Successfully.";
	else echo "Error: " . $deleteQuery . "<br>" . $conn->error;
}
?>
