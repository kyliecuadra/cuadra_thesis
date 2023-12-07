<?php 
require ("../config/db_connection.php");

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

if(isset($_POST['userid'])){
	$id = $_POST['userid'];

	$query = mysqli_query($con, "SELECT * FROM users WHERE id = $id");
	if(mysqli_num_rows($query) > 0){
		while ($row = mysqli_fetch_assoc($query)) {
			$status = $row["status"];

			if($status == 1){
				mysqli_query($con, "UPDATE users SET status = 0 WHERE id = $id");
			}
			else{
				mysqli_query($con, "UPDATE users SET status = 1 WHERE id = $id");
			}
		}
	}
}

?>