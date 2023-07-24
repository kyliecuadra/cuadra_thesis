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
	if($_SESSION['userLvl'] == "Contributor"){
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
					<i class='bx bx-grid-alt'><img src="../assets/icons/grid-alt.png" style="filter: invert(1);"></i>
					<span class="link-name">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="contribution.php">
					<i><img src="../assets/icons/peso.svg" style="height: 24px; filter: invert(1);"></i>
					<span class="link-name" style="color: #00FFF3;">The Contribution</span>
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
				<span class="name d-flex flex-column"><?php echo $_SESSION['fname']; ?><span style="font-size: 15px;">Admin</span></span>
				<button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span><img src="../assets/icons/user-solid.svg" style="height: 24px; filter: invert(1);"></span>
				</button>
				<div class="dropdown-menu dropdown-menu-right" style="cursor: pointer;">
					<a class="dropdown-item" onclick="editUser(<?php echo $_SESSION['id']; ?>)">User Profile</a>
					<a class="dropdown-item" href="../logout.php">Logout</a>
				</div>
			</div>
		</nav>
		<!-- EDIT USER PROFILE MODAL START -->
			<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header" style="background-color: #023047;">
							<h5 class="modal-title text-white">EDIT USER PROFILE</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="container-fluid form-group form">
								<div class="row">
									<div class="col-md-12">
										<label for="user_empNo">Employee Number</label>
										<input type="number" class="form-control" id="user_empNo" placeholder="Employee Number">
									</div>
									<div class="col-md-3">
										<label for="user_fname">First Name</label>
										<input type="text" class="form-control" id="user_fname" placeholder="First Name">
									</div>
									<div class="col-md-3">
										<label for="user_mname">Middle Name</label>
										<input type="text" class="form-control" id="user_mname" placeholder="Middle Name">
									</div>
									<div class="col-md-3">
										<label for="user_lname">Last Name</label>
										<input type="text" class="form-control" id="user_lname" placeholder="Last Name">
									</div>
									<div class="col-md-3">
										<label for="user_suffix">Suffix</label>
										<input type="text" class="form-control" id="user_suffix" placeholder="Suffix">
									</div>
									<div class="col-md-6">
										<label for="user_password">Password</label>
										<input type="text" class="form-control" id="user_password" placeholder="Password">
									</div>

									<div class="col-md-6">
										<label for="user_dateJoined">Date Hired</label>
										<input type="date" class="form-control" id="user_dateJoined" placeholder="Date Hired" required>
									</div>

									<div class="col-md-12">
										<label for="user_empStats">Employee Status</label>
										<select class="form-control" id="user_empStats" required>
											<option value="Permanent">Permanent</option>
											<option value="Temporary">Temporary</option>
										</select>
									</div>
									<div class="col-md-12">
										<label for="user_userlvl">User Role</label>
										<select class="form-control" id="user_userlvl" required>
											<option value="System Admin">System Admin</option>
											<option value="Admin">Admin</option>
											<option value="Collector">Collector</option>
											<option value="Contributor">Contributor</option>
										</select>
									</div>									
									<div class="col-md-12">
										<label for="user_userlvl">Staff Level</label>
										<select class="form-control" id="user_staffLvl" required>
											<option value="Grade 7">Grade 7</option>
											<option value="Grade 8">Grade 8</option>
											<option value="Grade 9">Grade 9</option>
											<option value="Grade 10">Grade 10</option>
											<option value="Grade 11">Grade 11</option>
											<option value="Grade 12">Grade 12</option>
											<option value="Non-Teaching Staff">Non-Teaching Staff</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary addUser-btn" id="addUser" onclick="editUserDetail()">Update User</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<input type="hidden" name="" id="hidden_userid">
						</div>
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
					function editUser(id){
						$('#hidden_userid').val(id);
					
						$.post("userProfile.php",
							{id:id},
							function(data,status){
								var user = JSON.parse(data);
								$('#user_empNo').val(user.empNo);
								$('#user_fname').val(user.fname);
								$('#user_mname').val(user.mname);
								$('#user_lname').val(user.lname);
								$('#user_suffix').val(user.suffix);
								$('#user_password').val(user.password);
								$('#user_dateJoined').val(user.dateJoined);
								$('#user_empStats').val(user.empStats);
								$('#user_staffLvl').val(user.staffLvl);
								$('#user_userlvl').val(user.userLvl);
							});
						$('#editUser').modal("show");
					}

					function editUserDetail(){
						var empNo = $('#user_empNo').val();
						var fname = $('#user_fname').val();
						var mname = $('#user_mname').val();
						var lname = $('#user_lname').val();
						var suffix = $('#user_suffix').val();
						var password = $('#user_password').val();
						var dateJoined = $('#user_dateJoined').val();
						var empStats = $('#user_empStats').val();
						var staffLvl = $('#user_staffLvl').val();
						var userLvl = $('#user_userlvl').val();

						var hidden_userid = $('#hidden_userid').val();

						$.post("userProfile.php",
							{hidden_userid:hidden_userid,
								empNo:empNo,
								fname:fname,
								mname:mname,
								lname:lname,
								suffix:suffix,
								password:password,
								dateJoined:dateJoined,
								empStats:empStats,
								staffLvl:staffLvl,
								userLvl:userLvl},
								function(data,status){
									$('#editUser').modal("hide");
									displayRecords();
									toastr.success("User Updated!");
								});
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