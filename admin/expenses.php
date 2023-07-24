<?php 
require("../config/db_connection.php");

if(isset($_POST['name'])){
	$empNo = 0;
	$name = $_POST['name'];
	$reason = $_POST['reason'];
	$amount = $_POST['amount'];
	$date = date('Y-m-d');

	// GETTING EMPLOYEE NUMBER
	$getEmpNo = mysqli_query($con, "SELECT * from users WHERE CONCAT(fname,' ', mname,' ', lname,' ', suffix) = '$name'");
	while($row = mysqli_fetch_assoc($getEmpNo)){
		$empNo = $row['empNo'];
	}

	// INSERTING DATA INTO THE DATABASE
	$sql = mysqli_query($con, "INSERT INTO expenses VALUES ('', '$empNo', '$name', '$reason', '$amount', '$date')");
	if($sql){
		mysqli_query($con, "INSERT INTO contribution_summary (contributionOut) VALUES ($amount)");
		echo '1';
	}
	else {
		echo '0';
	}
}

?>