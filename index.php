<?php 
require ("config/db_connection.php");
session_start(); 

if (isset($_SESSION['id']))
{ 
	if($old_password == $_SESSION['password']){
		header("location: registerPassword.php");
	}
	else{
		if ($_SESSION['userLvl'] == "Admin") {
			header("location: admin/dashboard.php");
		}
		elseif($_SESSION['userLvl'] == "Collector"){
			header("location: collector/dashboard.php");
		}
		else{
			header("location: Contributor/dashboard.php");
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="icon" href="assets/img/html_icon.png">
	<!-- BOOTSTRAP 4 CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- LOCAL CSS -->
	<link rel="stylesheet" href="assets/css/login.css">
	<!-- TOASTR CONFIGS -->
	<script src="assets/js/jquery-1.9.1.min.js"></script>
	<link href="assets/css/toastr.css" rel="stylesheet"/>
	<script src="assets/js/toastr.js"></script>
	<script type="text/javascript" src="config/toastr_config.js"></script>
</head>
<body>
	<nav class="container-fluid navbar navbar-dark">
		<a class="navbar-brand"><img id="title_logo" src="assets/img/logo.png" alt="logo" style="width:75px;"></a>
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="school">AMADEO NATIONAL HIGH SCHOOL</a>
				<a class="nav-link active" id="loc">AMADEO, CAVITE</a>
			</li>
		</ul>
	</nav>

	<div class="container">
		<div class="d-flex justify-content-center align-items-center">
			<div class="card border-dark shadow-lg p-3 mb-5 bg-white mt-5">
				<div class="text-center">
					<div>
						<img id="logo" src="assets/img/logo_tec.png" alt="logo">
					</div>
				</div>
				<div class="container form">
					<div class="login-form">
						<form method="POST" action="index.php" autocomplete="off">
							<div class="form-group">
								<label>Username</label>
								<input type="text" name="username" id="empNumber" class="form-control" placeholder="Username" required autofocus>
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" name="password" id="pw" class="form-control" placeholder="Password" required>
							</div>
							<button type="submit" name="login" class="btn btn-color btn-block my-3">Login</button>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- LOGIN VALIDATION START-->
	<?php
	if(isset($_POST["login"])){
		$username = mysqli_real_escape_string($con,$_POST['username']);
		$password = mysqli_real_escape_string($con,$_POST['password']);

		if ($username != "" && $password != ""){
			$check_user = mysqli_query($con, "SELECT * FROM users WHERE username='".$username."' AND password='".$password."'");
			$check_user_row = mysqli_num_rows($check_user);
			if ($check_user_row > 0) { 
				while($row = mysqli_fetch_assoc($check_user)){
					$id = $row["id"];
					$empNo = $row["empNo"];
					$fname = $row["fname"];
					$mname = $row["mname"];
					$lname = $row["lname"];
					$suffix = $row["suffix"];
					$name = $fname. " " . $mname. " " . $lname. " " . $suffix;
					$username = $row['username'];
					$password = $row["password"];
					$dateHired = $row["dateHired"];
					$empStats = $row["empStats"];
					$staffLvl = $row["staffLvl"];
					$userLvl = $row["userLvl"];
					$status = $row["status"];

					$_SESSION["id"] = $id;
					$_SESSION["empNo"] = $empNo;
					$_SESSION["fname"] = $fname;
					$_SESSION["mname"] = $mname;
					$_SESSION["lname"] = $lname;
					$_SESSION["suffix"] = $suffix;
					$_SESSION["name"] = trim($name);
					$_SESSION["username"] = $username;
					$_SESSION["password"] = $password;
					$_SESSION["dateHired"] = $dateHired;
					$_SESSION["empStats"] = $empStats;
					$_SESSION["staffLvl"] = $staffLvl;
					$_SESSION["userLvl"] = $userLvl;
					$_SESSION["status"] = $status;

					
					$old_password = $_SESSION["fname"][0].$_SESSION["lname"];
					$old_password = str_replace(' ', '', $old_password);
					$old_password = mb_strtoupper($old_password);
					
					if($old_password == $password AND $status == 1){
						header("location: registerPassword.php");
					}
					else{
						if ($userLvl == "Admin" AND $status == 1) {
							header("location: admin/dashboard.php");
						}
						elseif($userLvl == "Collector" AND $status == 1){
							header("location: collector/dashboard.php");
						}
						elseif($userLvl == "Contributor" AND $status == 1){
							header("location: contributor/dashboard.php");
						}
						elseif($userLvl == "System Admin" AND $status == 1){
							header("location: sysAdmin/dashboard.php");
						}
						else{
							echo '<script type="text/javascript">toastr.error("Account Deactivated!")</script>';
						}
					}
				}
			}
			else{
				echo '<script type="text/javascript">toastr.error("Incorrect username or password!")</script>';
			}
		}
	}
	?>
	<!-- LOGIN VALIDATION END -->
	<script>
		window.onload = function(){
			document.getElementById("empNumber").value = '';
			document.getElementById("pw").value = '';
		}
	</script>
	<!-- BOOTSTRAP 4 JS -->
	<script src="assets/js/jquery-3.6.0.min.js"></script>
	<script src="assets/js/bootstrap.bundle.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>