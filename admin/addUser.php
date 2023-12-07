<?php 
require ("../config/db_connection.php");

extract($_POST);

if(isset($_POST['empNo']) && isset($_POST['fname']) && isset($_POST['mname']) && isset($_POST['lname']) && isset($_POST['username']) && isset($_POST['dateJoined']) && isset($_POST['empStats']) && isset($_POST['staffLvl']) && isset($_POST['userLvl']) || isset($_POST['suffix'])){

	$password = $fname[0].$lname;
	$password = str_replace(' ', '', $password);
	$password = mb_strtoupper($password);

	$check = mysqli_query($con, "SELECT * FROM users WHERE empNo = '$empNo'");
	$checkAdmins = mysqli_query($con, "SELECT * FROM users WHERE userLvl = '$userLvl' AND status = 1");
	$checkCollector = mysqli_query($con, "SELECT * FROM users WHERE userLvl = '$userLvl' AND staffLvl = '$staffLvl' AND status = 1");
		if (mysqli_num_rows($check) > 0){
			echo '0';
		}
		elseif (($userLvl == 'Admin') AND mysqli_num_rows($checkAdmins) > 1) {
			echo '1';
		}
		elseif ($userLvl == 'Collector' AND mysqli_num_rows($checkCollector) > 0) {
			echo '2';
		}
		else{
			echo '3';
			mysqli_query($con, "INSERT INTO users (empNo, fname, mname, lname, suffix, username, password, dateJoined, empStats, staffLvl, userLvl) VALUES ('$empNo','$fname', '$mname', '$lname', '$suffix', '$username', '$password', '$dateJoined', '$empStats', '$staffLvl', '$userLvl')");
		}
}
?>
