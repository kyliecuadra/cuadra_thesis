<?php 
require("../config/db_connection.php");

if(isset($_POST['name'])){
	$empNo = 0;
	$grandCollection = 0;
	$name = $_POST['name'];
	$reason = $_POST['reason'];
	$amount = $_POST['amount'];
	$date = date('Y-m-d');

	// GETTING EMPLOYEE NUMBER
	$getEmpNo = mysqli_query($con, "SELECT * from users WHERE CONCAT(fname,' ', mname,' ', lname,' ', suffix) = '$name'");
	while($row = mysqli_fetch_assoc($getEmpNo)){
		$empNo = $row['empNo'];
	}

	$get_grandCollection = mysqli_query($con, "SELECT SUM(Annual_Membership_Fee + Monthly_Contribution + Voluntary_Contribution + Special_Contribution - contributionOut) as grandCollection FROM contribution_summary");
	$grandCollection = mysqli_fetch_array($get_grandCollection);

	// INSERTING DATA INTO THE DATABASE
	if($grandCollection[0] >= $amount){
		$sql = mysqli_query($con, "INSERT INTO expenses VALUES ('', '$empNo', '$name', '$reason', '$amount', '$date')");
		if($sql){
			mysqli_query($con, "INSERT INTO contribution_summary (contributionOut) VALUES ($amount)");
			echo '1';
		}
		else {
			echo '0';
		}
	}
	else {
		echo '2';
	}
	
}

?>