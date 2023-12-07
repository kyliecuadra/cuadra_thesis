<?php 
require ("../config/db_connection.php");

session_start();
require ("../config/session_timeout.php");

if(!isset($_SESSION['id']) AND $_SESSION['status'] == 0){
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
	if($_SESSION['userLvl'] == "Collector"){
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
	<link href="css/toastr.css" rel="stylesheet"/>
	<script src="js/toastr.js"></script>
	<script type="text/javascript" src="../config/toastr_config.js"></script>
	<!-- JQUERY CDN -->
	<script src="js/jquery-3.6.0.min.js"></script>

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
				<a href="contribution.php">
					<i><img src="../assets/icons/peso.svg" style="height: 24px; filter: invert(1);"></i>
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
		<nav>
			<div class="sidebar-button">
				<span class="dashboard">DASHBOARD</span>
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
		<!-- MAIN CONTENT -->
		<div class="container-fluid px-4">
			<div class="row g3 my-3">
				<div class="col-md-4 overview">
					<div class="p-3 bg-light shadow-sm d-flex justify-content-around align-items-center rounded">
						<div>
							<h3 class="fs-2"><?php echo $_SESSION['name']; ?></h3>
							<p class="fs-3"><i class="fa-solid fa-at"></i>Employee Number: <?php echo $_SESSION['empNo']; ?></p>
						</div>
						<i><img src="../assets/icons/user-solid.svg" style="height: 30px; filter: invert(14%) sepia(14%) saturate(5931%) hue-rotate(171deg) brightness(92%) contrast(98%);"></i>
					</div>
				</div>
				<div class="col-md-4 overview">
					<div class="p-3 bg-light shadow-sm d-flex justify-content-around align-items-center rounded">
						<div>
							<h3 class="fs-2" id="total-users"></h3>
							<p class="fs-3">TOTAL MEMBERS</p>
						</div>
						<i><img src="../assets/icons/users-solid.svg" style="height: 30px; filter: invert(14%) sepia(14%) saturate(5931%) hue-rotate(171deg) brightness(92%) contrast(98%);"></i>
					</div>
				</div>
				<div class="col-md-4 overview">
					<div class="p-3 bg-light shadow-sm d-flex justify-content-around align-items-center rounded">
						<div>
							<h3 class="fs-2" id="total-collection"></h3>
							<p class="fs-3">GRAND COLLECTION</p>
						</div>
						<i><img src="../assets/icons/peso.svg" style="height: 30px; filter: invert(14%) sepia(14%) saturate(5931%) hue-rotate(171deg) brightness(92%) contrast(98%);"></i>
					</div>
				</div>
			</div>
		</div>
		<!-- TOTAL USERS -->
		<div class="col member-table">
			<div class="d-flex justify-content-between">
				<strong>All Users</strong>
				<button class="btn addUser-btn" data-toggle="modal" data-target="#addUser">Add User</button>
			</div>
			<!-- ADD USER MODAL START -->
			<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header" style="background-color: #023047;">
							<h5 class="modal-title text-white">ADD USER</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="container-fluid form-group form">
								<div class="row">
									<div class="col-md-12">
										<label for="empNo">Employee Number<span id="required">*</span></label>
										<input type="number" class="form-control" id="empNo" placeholder="Employee Number" required>
									</div>
									<div class="col-md-3">
										<label for="fname">First Name<span id="required">*</span></label>
										<input type="text" class="form-control" id="fname" placeholder="First Name" required>
									</div>
									<div class="col-md-3">
										<label for="mname">Middle Name<span id="required">*</span></label>
										<input type="text" class="form-control" maxlength="1" id="mname" placeholder="Middle Name" required>
									</div>
									<div class="col-md-3">
										<label for="lname">Last Name<span id="required">*</span></label>
										<input type="text" class="form-control" id="lname" placeholder="Last Name" required>
									</div>
									<div class="col-md-3">
										<label for="suffix">Suffix</label>
										<input type="text" class="form-control" id="suffix" placeholder="Suffix">
									</div>
									<div class="col-md-12">
										<label for="username">Username<span id="required">*</span></label>
										<input type="text" class="form-control" id="username" placeholder="Username" required>
									</div>
									<div class="col-md-6">
										<label for="dateJoined">Date Joined<span id="required">*</span></label>
										<input type="date" class="form-control" id="dateJoined" placeholder="Date Joined" required>
									</div>
									
									<div class="col-md-6">
										<label for="empStats">Employee Status<span id="required">*</span></label>
										<select class="form-control" id="empStats" name="empStats" required>
											<option value="Permanent">Permanent</option>
											<option value="Temporary">Temporary</option>
										</select>
									</div>
									<div class="col-md-12">
										<label for="userlvl">User Role<span id="required">*</span></label>
										<select class="form-control" id="userlvl" name="userLvl" required>
											<option value="Admin">Admin</option>
											<option value="Collector">Collector</option>
											<option value="Contributor">Contributor</option>
										</select>
									</div>
									<div class="col-md-12">
										<label for="new_userlvl">Staff Level<span id="required">*</span></label>
										<select class="form-control" id="staffLvl" required>
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
							<button type="button" class="btn btn-primary addUser-btn" id="addUser" onclick="addUser()">Add User</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!-- ADD USER MODAL END -->

			<!-- UPDATE USER MODAL START -->
			<div class="modal fade" id="updateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header" style="background-color: #023047;">
							<h5 class="modal-title text-white">UPDATE USER</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="container-fluid form-group form">
								<div class="row">
									<div class="col-md-12">
										<label for="new_empNo">Employee Number</label>
										<input type="number" class="form-control" id="new_empNo" placeholder="Employee Number" readonly>
									</div>
									<div class="col-md-3">
										<label for="new_fname">First Name</label>
										<input type="text" class="form-control" id="new_fname" placeholder="First Name" readonly>
									</div>
									<div class="col-md-3">
										<label for="new_mname">Middle Name</label>
										<input type="text" class="form-control" id="new_mname" placeholder="Middle Name" readonly>
									</div>
									<div class="col-md-3">
										<label for="new_lname">Last Name</label>
										<input type="text" class="form-control" id="new_lname" placeholder="Last Name" readonly>
									</div>
									<div class="col-md-3">
										<label for="new_suffix">Suffix</label>
										<input type="text" class="form-control" id="new_suffix" placeholder="Suffix" readonly>
									</div>
									<div class="col-md-6">
										<label for="new_username">Username</label>
										<input type="text" class="form-control" id="new_username" placeholder="Username" readonly>
									</div>
									<div class="col-md-6">
										<label for="new_password">Password</label>
										<input type="text" class="form-control" id="new_password" placeholder="Password" readonly>
									</div>

									<div class="col-md-6">
										<label for="new_dateJoined">Date Joined</label>
										<input type="date" class="form-control" id="new_dateJoined" placeholder="Date Joined" required>
									</div>

									<div class="col-md-6">
										<label for="new_empStats">Employee Status</label>
										<select class="form-control" id="new_empStats" required>
											<option value="Permanent">Permanent</option>
											<option value="Temporary">Temporary</option>
										</select>
									</div>
									<div class="col-md-12">
										<label for="new_userlvl">User Role</label>
										<select class="form-control" id="new_userlvl" required>
											<option value="Admin">Admin</option>
											<option value="Collector">Collector</option>
											<option value="Contributor">Contributor</option>
										</select>
									</div>									
									<div class="col-md-12">
										<label for="new_userlvl">Staff Level</label>
										<select class="form-control" id="new_staffLvl" required>
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
							<button type="button" class="btn btn-primary addUser-btn" id="addUser" onclick="updateUserDetail()">Update User</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<input type="hidden" name="" id="hidden_userid">
						</div>
					</div>
				</div>
			</div>
			<!-- UPDATE USER MODAL END -->

			<!-- UPDATE STATUS MODAL START -->
			<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header text-white" style="background-color: #023047;">
							<h5 class="modal-title text-white" id="exampleModalLongTitle">UPDATE STATUS</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p>Are you sure you want change the status of this user?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary addUser-btn" id="addUser" onclick="updateStatus()">Update Status</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<input type="hidden" name="" id="hidden_userid">
						</div>
					</div>
				</div>
			</div>
			<!-- UPDATE STATUS MODAL END -->

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
										<label for="user_username">Username</label>
										<input type="text" class="form-control" id="user_username" placeholder="Username">
									</div>
									<div class="col-md-6">
										<label for="user_password">Password</label>
										<input type="text" class="form-control" id="user_password" placeholder="Password">
									</div>

									<div class="col-md-6">
										<label for="user_dateJoined">Date Joined</label>
										<input type="date" class="form-control" id="user_dateJoined" placeholder="Date Joined" required>
									</div>

									<div class="col-md-6">
										<label for="user_empStats">Employee Status</label>
										<select class="form-control" id="user_empStats" required>
											<option value="Permanent">Permanent</option>
											<option value="Temporary">Temporary</option>
										</select>
									</div>
									<div class="col-md-12">
										<label for="user_userlvl">User Role</label>
										<select class="form-control" id="user_userlvl" required>
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
			<div id="member-records">
				<!-- DISPLAY RECORDS, UPDATE USERS AND STATUS START-->
				<script>
					// RUN FUNCTION WHEN PAGE IS LOADED
					$(document).ready(function(){
						// RESTRICTING THE FUTURE DATES IN DATEPICKER
						var tomorrow = new Date();
						tomorrow.setDate(tomorrow.getDate());
						$('input[type="date"]').attr('max', tomorrow.toISOString().split("T")[0]);

						displayRecords();
						totalContribution();
						totalUsers();
						
					});


					// DISPLAY TOTAL USERS START
					function totalUsers(){
						var totalUsers = "totalUsers";
						$.ajax({
							url: "displayRecords.php",
							type: "POST",
							data: {totalUsers:totalUsers},
							success:function(data,status){
								$('#total-users').html(data.replace(/\D/g, ""));
							}
						});
					}
					//DISPLAY TOTAL USERS END

					// DISPLAY USERS RECORDS START
					function displayRecords(){
						var displayRecords = "displayRecords";
						$.ajax({
							url: "displayRecords.php",
							type: "POST",
							data: {displayRecords:displayRecords},
							success:function(data,status){
								$('#member-records').html(data);
							}
						});
					}
					// DISPLAY USERS RECORDS END

					// DISPLAY TOTAL CONTRIBUTION START
					function totalContribution(){
						var totalContribution = "totalContribution";
						$.ajax({
							url: "displayRecords.php",
							type: "POST",
							data: {totalContribution:totalContribution},
							success:function(data,status){
								$('#total-collection').html(data);
							}
						});
					}
					// DISPLAY TOTAL CONTRIBUTION END

					// ADD USER START
					function addUser(){
						var empNo = $('#empNo').val();
						var fname = $('#fname').val();
						var mname = $('#mname').val();
						var lname = $('#lname').val();
						var suffix = $('#suffix').val();
						var username = $('#username').val();
						var dateJoined = $('#dateJoined').val();
						var empStats = $('#empStats option:selected').val();
						var staffLvl = $('#staffLvl option:selected').val();
						var userLvl = $('#userlvl option:selected').val();

						if(empNo!="" && fname!="" && mname!="" && lname!="" && username!="" && dateJoined!="" && empStats!="" && userLvl!=""){
							$.ajax({
								url: "addUser.php",
								type: "POST",
								data: {empNo:empNo,
									fname:fname,
									mname:mname,
									lname:lname,
									suffix:suffix,
									username:username,
									dateJoined:dateJoined,
									empStats:empStats,
									staffLvl:staffLvl,
									userLvl:userLvl},
									success:function(data,status){
										if(data==3){
											displayRecords();
											toastr.success("User Added!");
											$("#addUser").modal('hide');
											$('#addUser input').val("");
										}
										else if(data==2){
											toastr.error("There is already a Collector in "+staffLvl+"!");
										}
										else if(data==1){
											toastr.error(userLvl+" is already existed!");
										}
										else{
											toastr.error("User already existed!");
										}
									}
								});
						}
						else{
							toastr.error("Please fill the fields!");
						}
					}
					// ADD USER END

					// UPDATE USER STATUS START
					function statusModal(id){
						$('#hidden_userid').val(id);

						$.post("updateStatus.php",
							{id:id},
							function(data,status){
								var user = JSON.parse(data);
								$('#hidden_userid').val(user.id);
							});
						$('#statusModal').modal("show");
					}

					function updateStatus(){
						var hidden_userid = $('#hidden_userid').val();
						$.ajax({
							url: "updateStatus.php",
							type: "POST",
							data: {userid:hidden_userid},
							success:function(data,status){
								console.log(hidden_userid);
								$('#statusModal').modal("hide");
								displayRecords();
								toastr.success("User Status Updated!");
							}
						});
					}
					// UPDATE USER STATUS END

					// UPDATE USER FUNCTION START
					function updateUser(id){
						$('#hidden_userid').val(id);

						$.post("updateUser.php",
							{id:id},
							function(data,status){
								var user = JSON.parse(data);
								$('#new_empNo').val(user.empNo);
								$('#new_fname').val(user.fname);
								$('#new_mname').val(user.mname);
								$('#new_lname').val(user.lname);
								$('#new_suffix').val(user.suffix);
								$('#new_username').val(user.username);
								$('#new_password').val(user.password);
								$('#new_dateJoined').val(user.dateJoined);
								$('#new_empStats').val(user.empStats);
								$('#new_staffLvl').val(user.staffLvl);
								$('#new_userlvl').val(user.userLvl);
							});
						$('#updateUser').modal("show");
					}

					function updateUserDetail(){
						var empNo = $('#new_empNo').val();
						var fname = $('#new_fname').val();
						var mname = $('#new_mname').val();
						var lname = $('#new_lname').val();
						var suffix = $('#new_suffix').val();
						var username  = $('#new_username').val();
						var password = $('#new_password').val();
						var dateJoined = $('#new_dateJoined').val();
						var empStats = $('#new_empStats').val();
						var staffLvl = $('#new_staffLvl').val();
						var userLvl = $('#new_userlvl').val();

						var hidden_userid = $('#hidden_userid').val();

						$.post("updateUser.php",
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
									$('#updateUser').modal("hide");
									displayRecords();
									toastr.success("User Updated!");
								});
					}
					// UPDATE USER FUNCTION END

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
								$('#user_username').val(user.username);
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
						var username = $('#user_username').val();
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
								username:username,
								password:password,
								dateJoined:dateJoined,
								empStats:empStats,
								staffLvl:staffLvl,
								userLvl:userLvl},
								function(data,status){
									$('#editUser').modal("hide");
									console.log(data);
									toastr.success("User Updated!");
								});
					}
					// DISPLAY EDIT USER PROFILE MODAL END
				</script>
				<!-- DISPLAY, DELETE, AND UPDATE USERS RECORDS EMD-->
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