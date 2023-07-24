<?php 
require ("../config/db_connection.php");
session_start();

if(isset($_POST['userProfile'])){
	$query = mysqli_query($con, "SELECT * FROM users WHERE id = '".$_SESSION['id']."'");

	while($row = mysqli_fetch_assoc($query)){
		$id = $row["id"];
		$empNo = $row["empNo"];
		$fname = $row["fname"];
		$mname = $row["mname"];
		$lname = $row["lname"];
		$suffix = $row["suffix"];
		$username = $row["username"];
		$password = $row["password"];
		$dateJoined = $row["dateJoined"];
		$empStats = $row["empStats"];
		$staffLvl = $row["staffLvl"];
		$userLvl = $row["userLvl"];

		$data = '<div class="row">
		<div class="col-md-12">
		<input type="text" name="id" value="'.$id.'" hidden>
		<label for="empNo">Employee Number</label>
		<input type="number" class="form-control" name="empNo" value="'.$empNo.'" placeholder="Employee Number">
		</div>
		<div class="col-md-3">
		<label for="fname">First Name</label>
		<input type="text" class="form-control" name="fname" value="'.$fname.'" placeholder="First Name">
		</div>
		<div class="col-md-3">
		<label for="mname">Middle Name</label>
		<input type="text" class="form-control" name="mname" value="'.$mname.'" placeholder="Middle Name">
		</div>
		<div class="col-md-3">
		<label for="lname">Last Name</label>
		<input type="text" class="form-control" name="lname" value="'.$lname.'" placeholder="Last Name">
		</div>
		<div class="col-md-3">
		<label for="suffix">Suffix</label>
		<input type="text" class="form-control" name="suffix" value="'.$suffix.'" placeholder="Suffix">
		</div>
		<div class="col-md-6">
		<label for="username">Username</label>
		<input type="text" class="form-control" name="username" value="'.$username.'" placeholder="Username">
		</div>
		<div class="col-md-6">
		<label for="password">Password</label>
		<input type="text" class="form-control" name="password" value="'.$password.'" placeholder="Password">
		</div>

		<div class="col-md-6">
		<label for="dateJoined">Date Hired</label>
		<input type="date" class="form-control" name="dateJoined" value="'.$dateJoined.'" placeholder="Date Hired" disabled="true">
		</div>

		<div class="col-md-6">
		<label for="empStats">Employee Status</label>
		<input type="text" class="form-control"value="'.$empStats.'" placeholder="Date Hired" disabled="true">
		</div>
		<div class="col-md-12">
		<label for="userlvl">User Role</label>
		<input type="text" class="form-control"value="'.$userLvl.'" placeholder="Date Hired" disabled="true">
		</div>
		<div class="col-md-12">
		<label for="new_userlvl">Staff Level</label>
		<input type="text" class="form-control"value="'.$staffLvl.'" placeholder="Date Hired" disabled="true">
		</select>
		</div>
		</div>';
	}

	echo $data;
}

if (isset($_POST['update'])) {
	$id = $_POST['id'];
	$empNo = $_POST["empNo"];
	$fname = $_POST["fname"];
	$mname = $_POST["mname"];
	$lname = $_POST["lname"];
	$suffix = $_POST["suffix"];
	$username = $_POST["username"];
	$password = $_POST["password"];

	$name = $fname. " " . $mname. " " . $lname. " " . $suffix;

	$update = mysqli_query($con, "UPDATE users SET empNo='$empNo', fname='$fname', mname='$mname', lname='$lname', suffix='$suffix', username='$username', password='$password' WHERE id='$id'");

	if($update){
		mysqli_query($con, "UPDATE contribution_records SET empNo='$empNo', name='$name' WHERE empNo='$empNo' OR name='$name'");
		mysqli_query($con, "UPDATE contribution_summary SET empNo='$empNo', name='$name' WHERE empNo='$empNo' OR name='$name'");

		$_SESSION["empNo"] = $empNo;
		$_SESSION["fname"] = $fname;
		$_SESSION["mname"] = $mname;
		$_SESSION["lname"] = $lname;
		$_SESSION["suffix"] = $suffix;
		$_SESSION["name"] = $name;
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;
		header("location:javascript://history.go(-1)");
	}
	
}
?>