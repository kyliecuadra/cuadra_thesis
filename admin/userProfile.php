<?php 
require ("../config/db_connection.php");
session_start();

// GETTING USER DATA USING USER ID
if(isset($_POST['id']) && isset($_POST['id']) != ""){
	$id = $_POST['id'];

	$query = "SELECT * FROM users WHERE id = '$id'";
	if(!$result = mysqli_query($con, $query)){
		exit(mysqli_error());
	}
	$response = array();

	if(mysqli_num_rows($result) > 0){
		while ($row = mysqli_fetch_assoc($result)) {
			$response = $row;
		}
	}
	else{
		$response['status'] == 200;
		$response['message'] == "Data not found";
	}
	echo json_encode($response);
}
else{
	$response['status'] == 200;
	$response['message'] == "Invalid request";
}

// UPDATING USER DATA
if(isset($_POST['hidden_userid'])){
	$id = $_POST['hidden_userid'];

	$empNo = $_POST['empNo'];
	$fname = $_POST['fname'];
	$mname = $_POST['mname'];
	$lname = $_POST['lname'];
	$suffix = $_POST['suffix'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$dateJoined = $_POST['dateJoined'];
	$empStats = $_POST['empStats'];
	$staffLvl = $_POST['staffLvl'];
	$usrlvl = $_POST['userLvl'];

	mysqli_query($con, "UPDATE users SET empNo=$empNo, fname='$fname', mname='$mname', lname='$lname', suffix='$suffix', username='$username', password='$password', dateJoined='$dateJoined', empStats='$empStats', staffLvl='$staffLvl', userLvl='$usrlvl' WHERE id=$id");

	$_SESSION["empNo"] = $empNo;
	$_SESSION["fname"] = $fname;
	$_SESSION["mname"] = $mname;
	$_SESSION["lname"] = $lname;
	$_SESSION["suffix"] = $suffix;
	$_SESSION["username"] = $username;
	$_SESSION["password"] = $password;
	$_SESSION["dateJoined"] = $dateJoined;
	$_SESSION["empStats"] = $empStats;
	$_SESSION["staffLvl"] = $staffLvl;
	$_SESSION["userLvl"] = $userLvl;

}
?>