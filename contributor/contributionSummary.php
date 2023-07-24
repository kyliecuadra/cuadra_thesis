<?php 
require ("../config/db_connection.php");
session_start();
require ("../config/session_timeout.php");

if(!isset($_SESSION['id'])){
	header("location: ../config/not_login-error.html");
}
else{
	if($_SESSION['userLvl'] == "Collector"){
		header("location: ../config/user_level-error.html");
	}
	if($_SESSION['userLvl'] == "Admin"){
		header("location: ../config/user_level-error.html");
	}
	if($_SESSION['userLvl'] == "System Admin"){
		header("location: ../config/user_level-error.html");
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Contribution Summary</title>
	<link rel="icon" href="../assets/img/html_icon.png">
	<meta name="viewport" content="width=device-witdth, initial-scale=1.0">
	<!-- BOOTSTRAP 4 CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- LOCAL CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- TOASTR CONFIGS -->
	<script src="js/jquery-1.9.1.min.js"></script>
	<link href="css/toastr.css" rel="stylesheet"/>
	<script src="js/toastr.js"></script>
	<script type="text/javascript" src="../config/toastr_config.js"></script>
	<!-- JQUERY CDN -->
	<script src="js/jquery-3.6.0.min.js"></script>
</head>
<body>
	<style>
		.panel-collapse {
			transition: height 0.5s ease-in-out;
		}
	</style>
	<div class="sidebar" style="border-right: 1px solid #003860;">
		<div class="menu-details">
			<i class='sidebarBtn'><img src="../assets/icons/menu.png" style="filter: invert(1);"></i>
			<span class="menu-name">Menu</span>
		</div>
		<ul class="nav-links">
			<li>
				<a href="dashboard.php">
					<i><img src="../assets/icons/grid-alt.png" style="filter: invert(1);"></i>
					<span class="link-name"  style="color:#00FFF3;">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="contributionSummary.php">
					<i class="fa-solid fa-clipboard" style="color:#00FFF3;"><img src="../assets/icons/clipboard-solid.svg" style="height: 24px; filter: invert(92%) sepia(19%) saturate(4902%) hue-rotate(106deg) brightness(106%) contrast(105%);;"></i>
					<span class="link-name">Summary</span>	
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
		<nav>
			<div class="sidebar-button">
				<span class="dashboard">CONTRIBUTION SUMMARY</span>
			</div>
			<div class="btn-group">
				<span class="name d-flex flex-column"><?php echo $_SESSION['fname']; ?><span style="font-size: 15px;">Contributor</span></span>
				<button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span><img src="../assets/icons/user-solid.svg" style="height: 24px; filter: invert(1);"></span>
				</button>
				<div class="dropdown-menu dropdown-menu-right" style="cursor: pointer;">
					<a class="dropdown-item" onclick="edit_userProfile()">User Profile</a>
					<a class="dropdown-item" href="../logout.php">Logout</a>
				</div>
			</div>
		</nav>
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
		<!-- CONTRIBUTION ACTION BUTTONS START -->
		<div class="form-group col-md-3" style="margin: 30px 0 0 30px;">
			<label for="year">Year</label>
			<select class="form-control-lg w-50" type="year" name="year" id="year"></select>
		</div>
		<!-- CONTRIBUTION ACTION BUTTONS START -->
		<!-- CONTRIBUTION SUMMARY START -->
		<div class="container-fluid" id="contributionSummary"></div>
		<!-- CONTRIBUTION SUMMARY END -->

	</section>

	<script>
	// AUTOPOPULATE YEAR START
	var elements = document.querySelectorAll('#year');
	for(let i = 0; i < elements.length; i++){
		let currentYear = new Date().getFullYear();    
		let earliestYear = 2022;     
		while (currentYear >= earliestYear) {  
			let dateOption = document.createElement('option');        
			dateOption.textContent = currentYear;   
			dateOption.value = currentYear; 
			elements[i].append(dateOption);
			currentYear --;
		}
	}
	// AUTOPOPULATE YEAR END

	// CONTRIBUTION SUMMARY START
	$(document).ready(function(){
		var selectValue = $("#year").val();
			console.log(selectValue);
			$.ajax({
				url: "displayContributionSummary.php",
				type: "POST",
				data: {year:selectValue},
				success:function(data,status){
					$('#contributionSummary').html(data);
					console.log(data);
				}
			});
		});


	$("#year").change(function(){
			var selectValue = $(this).val();
			console.log(selectValue);
			$.ajax({
				url: "displayContributionSummary.php",
				type: "POST",
				data: {year:selectValue},
				success:function(data,status){
					$('#contributionSummary').html(data);
					console.log(data);
				}
			});
		});

	// CONTRIBUTION SUMMARY END

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