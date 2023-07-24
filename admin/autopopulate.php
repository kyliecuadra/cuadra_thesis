<?php 
require("../config/db_connection.php");
session_start();

$amfNew = 0;
$amfOld = 0;
$mcf = 0;

$newAMF = mysqli_query($con, "SELECT newAMF, dateNewAMF FROM contributionfee WHERE newAMF != 0.00 ORDER BY id DESC LIMIT 1");
$latestNewAMF=mysqli_fetch_array($newAMF);
$amfNew = $latestNewAMF[0];

$oldAMF = mysqli_query($con, "SELECT oldAMF, dateOldAMF FROM contributionfee WHERE oldAMF != 0.00 ORDER BY  id DESC LIMIT 1");
$latestOldAMF=mysqli_fetch_array($oldAMF);
$amfOld = $latestOldAMF[0];

$mcff = mysqli_query($con, "SELECT MCF, dateMCF FROM contributionfee WHERE MCF != 0.00 ORDER BY id DESC LIMIT 1");
$latestMCF=mysqli_fetch_array($mcff);
$mcf = $latestMCF[0];


$data = '';

if(isset($_POST['name'])){

	$result = mysqli_query($con, "SELECT * FROM users WHERE status = '1' AND id != '".$_SESSION["id"]."' ORDER BY fname ASC");
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

	$sql = mysqli_query($con, "SELECT * FROM users WHERE CONCAT(fname,' ', mname,' ', lname,' ', suffix) = '$name' LIMIT 1");
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