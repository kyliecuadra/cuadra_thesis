<?php 
require("../config/db_connection.php");
session_start();

$amfNew = 0;
$amfOld = 0;
$mcf = 0;

$sql = mysqli_query($con, "SELECT * FROM contributionfee LIMIT 1");
while($row = mysqli_fetch_assoc($sql)){
	$amfNew = $row['newAMF'];
	$amfOld = $row['oldAMF'];
	$mcf = $row['MCF'];
}

$data = '';

if(isset($_POST['name'])){

	$result = mysqli_query($con, "SELECT * FROM users WHERE status = '1' AND (staffLvl = '".$_SESSION['staffLvl']."' AND userLvl != 'Admin') ORDER BY fname ASC");
	while($row = mysqli_fetch_assoc($result)){
		$fname = $row['fname'];
		$mname = $row['mname'];
		$lname = $row['lname'];
		$suffix = $row['suffix'];
		$fullName = $fname." ".$mname." ".$lname;
		$data .= '<option value="'.trim($fullName).'">'.trim($fullName).'</options>';
	}
	echo $data;
}

if(isset($_POST["contribution"])){
	$name = $_POST['names'];
	$contribution = $_POST['contribution'];

	$sql = mysqli_query($con, "SELECT * FROM users WHERE CONCAT(fname,' ', mname,' ', lname,' ', suffix) = '$name'");
	while ($row = mysqli_fetch_assoc($sql)){
		$dateJoined = $row['dateJoined'];
		$dateJoined = date('Y', strtotime($dateJoined));
		$currYear = date('Y');
		$yearsSinceJoined = $currYear - $dateJoined;
		if($contribution == "Annual Membership Fee"){
			if($yearsSinceJoined >=1){
				echo $amfOld;
			}
			else{
				echo $amfNew;
			}
		}
		if($contribution == "Monthly Contribution"){
			echo $mcf;
		}
	}
}
?>