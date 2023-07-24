<?php 
require ("config/db_connection.php");
session_start();
if($_SESSION['status'] == 0){
	session_destroy();
	header("location: index.php");
}

$old_password = $_SESSION['fname'].$_SESSION['lname'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Change Password</title>
	<link rel="icon" href="assets/img/html_icon.png">
	<!-- BOOTSTRAP 4 CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- LOCAL CSS -->
	<link rel="stylesheet" href="assets/css/register-password.css">
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
						<form method="POST">
							<input type="number" name="uid" value="<?php echo $_SESSION['id'] ?>" hidden>
							<label for="password">New Password</label>
							<input id="password" type="password" class="form-control" name="password" placeholder="New Password" required>
							<label for="cpassword">Confirm Password</label>
							<input id="cpassword" type="password" class="form-control mb-3" name="cpassword" placeholder="Confirm Password" required>
							<label class="switch">
								<input type="checkbox" onclick="show_hide_password()">
								<span class="slider round"></span>
							</label>
							<span>Show Password</span>
							<button type="submit" name="register-password" class="btn btn-block btn-color">Register Password</button>
						</form>
						<script>
							function show_hide_password() {
								var p = document.getElementById("password");
								var cp = document.getElementById("cpassword");
								if (p.type === "password") {
									p.type = "text";
								} else {
									p.type = "password";
								}
								if (cp.type === "password") {
									cp.type = "text";
								} else {
									cp.type = "password";
								}
							}
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- LOGIN VALIDATION START-->
	<?php
	if(isset($_POST['register-password'])){
		$id = $_POST['uid'];
		$password = $_POST['password'];
		$cpassword = $_POST['cpassword'];
		$verify = $password = $cpassword;

		if($_POST['password'] != $_POST['cpassword']){
			echo '<script>toastr.error("Password mismatch!")</script>';
		}
		else{
			if($verify !== $_SESSION['password']){
                
				$query = mysqli_query($con, "UPDATE users SET password = '".$password."' WHERE id = $id");
				
				$_SESSION['password'] = $verify;
				if($query){
					if ($_SESSION['userLvl'] == "Admin") {
						echo '<script>toastr.success("Password changed successfully!");
						setTimeout(function() {
							window.location.href = "admin/dashboard.php?id='.$_SESSION['id'].'";
						}, 500);</script>';
					}
					elseif($_SESSION['userLvl'] == "Collector"){
						echo '<script>toastr.success("Password changed successfully!");
						setTimeout(function() {
							window.location.href = "collector/dashboard.php?id='.$_SESSION['id'].'";
						}, 500);</script>';
					}
					else{
						echo '<script>toastr.success("Password changed successfully!");
						setTimeout(function() {
							window.location.href = "contributor/dashboard.php?id='.$_SESSION['id'].'";
						}, 500);</script>';
					}
				}
			}
			else{	
				echo '<script>toastr.error("This password is default! Use another password.")</script>';
			}
		}
	}

	?>
	<!-- LOGIN VALIDATION END -->

	<!-- BOOTSTRAP 4 JS -->
	<script src="assets/js/jquery-3.6.0.min.js"></script>
	<script src="assets/js/bootstrap.bundle.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>