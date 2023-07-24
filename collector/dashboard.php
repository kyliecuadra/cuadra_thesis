<?php 
require("../config/db_connection.php");
session_start();
require ("../config/session_timeout.php");
if(!isset($_SESSION['id'])){
	header("location: ../config/not_login-error.html");
}
else{
	if($_SESSION['status'] == 0){
		session_destroy();
		header("location: ../index.php");
	}
	if($_SESSION['userLvl'] == "System Admin"){
		header("location: ../config/user_level-error.html");
	}
	if($_SESSION['userLvl'] == "Admin"){
		header("location: ../config/user_level-error.html");
	}
	if($_SESSION['userLvl'] == "Contributor"){
		header("location: ../config/user_level-error.html");
	}
}

$old_password = $_SESSION["fname"][0].$_SESSION["lname"];
$old_password = str_replace(' ', '', $old_password);
$old_password = mb_strtoupper($old_password);

if($old_password == $_SESSION['password']){
	header("location: ../registerPassword.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dashboard</title>
	<link rel="icon" href="../assets/img/html_icon.png">
	<meta name="viewport" content="width=device-witdth, initial-scale=1.0">
	<!-- BOOTSTRAP 4 CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- LOCAL CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- TOASTR CONFIGS -->
	<script src="js/jquery-1.9.1.min.js"></script>
	<link  rel="stylesheet" href="css/toastr.css"/>
	<script src="js/toastr.js"></script>
	<script type="text/javascript" src="../config/toastr_config.js"></script>
	<!-- JQUERY CDN -->
	<script src="js/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">
</head>
<body>
	<div class="sidebar" style="border-right: 1px solid #003860;">
		<div class="menu-details">
			<i class='sidebarBtn'><img src="../assets/icons/menu.png" style="filter: invert(1);"></i>
			<span class="menu-name">Menu</span>
		</div>
		<ul class="nav-links">
			<li>
				<a href="#">
					<i><img src="../assets/icons/grid-alt.png" style="filter: invert(92%) sepia(19%) saturate(4902%) hue-rotate(106deg) brightness(106%) contrast(105%);"></i>
					<span class="link-name" style="color: #00FFF3;">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="contributionSummary.php">
					<i><img src="../assets/icons/clipboard-solid.svg" style="height: 24px; filter: invert(1);"></i>
					<span class="link-name">The Contribution</span>	
				</a>
			</li>
			<li>
				<a href="../logout.php">
					<i><img src="../assets/icons/right-from-bracket-solid.svg" style="height: 24px; filter: invert(1);"></i>
					<span class="link-name">Logout</span>
				</a>
			</li>
		</ul>
	</div>
	<!-- Main Content -->
	<section class="home-section">
		<nav class="">
			<div class="sidebar-button">
				<span class="dashboard">DASHBOARD</span>
			</div>
			<div class="btn-group">
				<span class="name d-flex flex-column"><?php echo $_SESSION['fname']; ?><span style="font-size: 15px;">Collector</span></span>
				<button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span><img src="../assets/icons/user-solid.svg" style="height: 24px; filter: invert(1);"></span>
				</button>
				<div class="dropdown-menu dropdown-menu-right" style="cursor: pointer;">
					<a class="dropdown-item" onclick="edit_userProfile()">User Profile</a>
					<a class="dropdown-item" href="../logout.php">Logout</a>
				</div>
			</div>
		</nav>
		<!-- MAIN CONTENT -->
		<div class="container-fluid px-4">
			<div class="row g3 my-3">
				<div class="col-md-6 overview">
					<div class="p-3 bg-light shadow-sm d-flex justify-content-around align-items-center rounded">
						<div>
							<h3 class="fs-2"><?php echo $_SESSION['name']; ?></h3>
							<p class="fs-3"><i class="fa-solid fa-at"></i>Employee Number: <?php echo $_SESSION['empNo']; ?></p>
						</div>
						<i><img src="../assets/icons/user-solid.svg" style="height: 30px; filter: invert(14%) sepia(14%) saturate(5931%) hue-rotate(171deg) brightness(92%) contrast(98%);"></i>
					</div>
				</div>
				<div class="col-md-6 overview">
					<div class="p-3 bg-light shadow-sm d-flex justify-content-around align-items-center rounded">
						<div>
							<h3 class="fs-2" id="total-contribution"></h3>
							<p class="fs-3">TOTAL CONTRIBUTION</p>
						</div>
						<i><img src="../assets/icons/peso.svg" style="height: 30px; filter: invert(14%) sepia(14%) saturate(5931%) hue-rotate(171deg) brightness(92%) contrast(98%);"></i>
					</div>
				</div>
			</div>
		</div>
		<!-- CONTRIBUTION RECORDS -->
		<div class="col member-table">
			<div class="d-flex justify-content-between">
				<strong>Recent Added Contributions</strong>
				<a class="btn addContribution-btn" href="inputContribution.php">Add Contribution</a>
			</div>

			<!-- EDIT USER PROFILE MODAL START -->
			<div class="modal fade" id="userProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header text-white" style="background-color: #023047;">
							<h5 class="modal-title">EDIT USER PROFILE</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="POST" action="userProfile.php">
							<div class="modal-body" id="edit-userProfile">
								...
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary" name="update" onclick="updateProfile()">Update Profile</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- EDIT USER PROFILE MODAL END -->
			<div id="contribution-records">
				<script>
					// RUN FUNCTION WHEN PAGE IS LOADED
					$(document).ready(function(){
							displayRecords();
					});


					// DISPLAY TOTAL CONTRIBUTION AMOUNT START
					setInterval( function totalContribution(){
						var totalContribution = "totalContribution";
						$.ajax({
							url: "displayRecords.php",
							type: "POST",
							data: {totalContribution:totalContribution},
							success:function(data,status){
								$('#total-contribution').html(data);
							}
						});
					}
					, 0);
					// DISPLAY TOTAL CONTRIBUTION AMOUNT END

					// DISPLAY CONTRIBUTION RECORDS START
					function displayRecords(){
						var displayRecords = "displayRecords";
						$.ajax({
							url: "displayRecords.php",
							type: "POST",
							data: {displayRecords:displayRecords},
							success:function(data,status){
								$('#contribution-records').html(data);
							}
						});
					}
					// DISPLAY CONTRIBUTION RECORDS END


					// DISPLAY EDIT USER PROFILE MODAL START
					function edit_userProfile(){
						var userProfile = "userProfile";

						$.ajax({
							url: "userProfile.php",
							type: "POST",
							data: {userProfile:userProfile},
							success:function(data,status){
								$('#userProfile').modal('show');
								$('#edit-userProfile').html(data);
							}
						});
					}

					function updateProfile(){
						$('#userProfile').modal('hide');
						toastr.success("Profile Updated!");
					}
					// DISPLAY EDIT USER PROFILE MODAL END
				</script>
			</div>
		</div>
	</div>
</section>
<!-- BOOTSTRAP JS -->
<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/bootstrap.bundle.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- DATATABLE -->
<script type="text/javascript" src="js/datatable/simple-datatables.js"></script>
<script type="text/javascript" src="js/datatable/tinymce.min.js"></script>
<script type="text/javascript" src="js/datatable/datatable.js"></script>
<!-- LOCAL JS -->
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>