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
	<title>The Contributions</title>
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
				<a href="dashboard.php">
					<i class='bx bx-grid-alt'><img src="../assets/icons/grid-alt.png" style="filter: invert(1);"></i>
					<span class="link-name">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="">
					<i><img src="../assets/icons/peso.svg" style="height: 24px; filter: invert(92%) sepia(19%) saturate(4902%) hue-rotate(106deg) brightness(106%) contrast(105%);"></i>
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
				<span class="dashboard">THE CONTRIBUTIONS</span>
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
		<!-- CONTRIBUTION ACTION BUTTONS START -->
		<div class="container-fluid">
			<div class="contribution-actions d-flex justify-content-between">
				<a href="inputContribution.php" ><button class="btn">Add Contribution</button></a>
				<button class="btn" data-toggle="modal" data-target="#contributionAmount">Update Contribution Amount</button>
				<button class="btn" onclick="expensesModal()">Expenses Log</button>
				<button class="btn" data-toggle="modal" data-target="#generateReport">Generate Report</button>
				<a href="contributionSummary.php" ><button class="btn">Contribution Summary</button></a>
				<button class="btn cutBtn" id="cutBtn" onclick="cutContribution()">Cut Contribution</button>
			</div>
		</div>
		<!-- CONTRIBUTION ACTION BUTTONS END -->
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

		<!-- UPDATE CONTRIBUTION AMOUNT MODAL START -->
		<div class="modal fade" id="contributionAmount" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">UPDATE CONTRIBUTION AMOUNT</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex justify-content-between" id="updateContributionAmount">
						<button class="btn amfbtn dropdown-toggle" data-toggle="dropdown">Annual Membership Fee</button>
						<div class="dropdown-menu" style="cursor: pointer">
							<a class="dropdown-item" onclick="update_AMFNew()">New Member</a>
							<a class="dropdown-item" onclick="update_AMFOld()">Old Member</a>
						</div>
						<button class="btn mcfbtn" onclick="MCF()">Monthly Contribution Fee</button>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- UPDATE CONTRIBUTION AMOUNT MODAL END -->

		<!-- UPDATE ANNUAL MEMBERSHIP FEE FOR NEW MEMBERS START -->
		<div class="modal fade" id="newMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">UPDATE ANNUAL MEMBERSHIP FEE (NEW)</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<button class="btn btn-primary w-50 amfbtn ml-auto mr-2 mt-2" onclick="newAMFLog()">Amount Update Log</button>
					<div class="modal-body d-flex justify-content-between" id="amfNew">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="updateAMFNew()">Update</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="newAMF" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">ANNUAL MEMBERSHIP FEE(NEW) AMOUNT CHANGES LOG</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex justify-content-between" id="updateAMFLogs" style="height: 60vh; overflow-y: scroll;">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- UPDATE ANNUAL MEMBERSHIP FEE FOR NEW MEMBERS END -->

		<!-- UPDATE ANNUAL MEMBERSHIP FEE FOR OLD MEMBERS START -->
		<div class="modal fade" id="oldMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">UPDATE ANNUAL MEMBERSHIP FEE (OLD)</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<button class="btn btn-primary w-50 amfbtn ml-auto mr-2 mt-2" onclick="oldAMFLog()">Amount Update Log</button>
					<div class="modal-body d-flex justify-content-between" id="amfOld">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="updateAMFOld()">Update</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="oldAMF" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">ANNUAL MEMBERSHIP FEE(OLD) AMOUNT CHANGES LOG</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex justify-content-between" id="updateOldAMFLogs" style="height: 60vh; overflow-y: scroll;">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- UPDATE ANNUAL MEMBERSHIP FEE FOR OLD MEMBERS END -->

		<!-- UPDATE MONTHLY CONTRIBUTION FEE START -->
		<div class="modal fade" id="mcf" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">UPDATE MONTHLY CONTRIBUTION FEE</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<button class="btn btn-primary w-50 amfbtn ml-auto mr-2 mt-2" onclick="MCFLogs()">Amount Update Log</button>
					<div class="modal-body d-flex justify-content-between" id="monthlyfee">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="updateMCF()">Update</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="mcfLog" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">MONTHLY CONTRIBUTION AMOUNT CHANGES LOG</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex justify-content-between" id="updateMCFLogs" style="height: 60vh; overflow-y: scroll;">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- UPDATE MONTHLY CONTRIBUTION FEE END -->

		<!-- EXPENSES LOG MODAL START -->
		<div class="modal fade" id="expensesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">EXPENSES LOG</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex justify-content-between" id="expenses" style="height: 60vh; overflow-y: scroll;">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- EXPENSES LOG MODAL END -->

		<!-- GENERATING REPORT FOR EXPENSES AND CONTRIBUTION SUMMARY START -->
		<div class="modal fade" id="generateReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">GENERATE REPORT</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex justify-content-around">
						<div class="dropdown">
							<button class="btn amfbtn dropdown-toggle" data-toggle="dropdown" id="expensesDropdown">Expenses</button>
							<div class="dropdown-menu" style="cursor: pointer;" aria-labelledby="expensesDropdown">
								<a class="dropdown-item" onclick="yearExpenses()">By Year</a>
								<a class="dropdown-item" onclick="monthExpenses()">By Month</a>
								<a class="dropdown-item" onclick="dateExpenses()">By Date</a>
							</div>
						</div>
						<div class="dropdown">
							<button class="btn amfbtn dropdown-toggle" data-toggle="dropdown" id="contributionDropdown">Contribution Summary</button>
							<div class="dropdown-menu" style="cursor: pointer;" aria-labelledby="contributionDropdown">
								<a class="dropdown-item" onclick="yearContribution()">By Year</a>
								<a class="dropdown-item" onclick="monthContribution()">By Month</a>
								<a class="dropdown-item" onclick="dateContribution()">By Date</a>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- GENERATING REPORT FOR EXPENSES START -->
		<!-- BY YEAR START -->
		<div class="modal fade" id="yearExpenses" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">GENERATE EXPENSES REPORT</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex">
						<div class="row">
							<form method="POST" action="yearlyExpenses.php" target="_blank">
								<div class="col-md-12">
									<label for="year" style="font-weight: bold;"><span id="required">*</span>Year: </label>
									<select id="year" name="year">
									</select>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" name="yearlyExpenses">Generate</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- BY YEAR END -->
		<!-- BY MONTH START -->
		<div class="modal fade" id="monthExpenses" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">GENERATE EXPENSES REPORT</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex">
						<div class="row">
							<form method="POST" action="monthlyExpenses.php" target="_blank">
								<div class="col-md-12">
									<label for="month" style="font-weight: bold;"><span id="required">*</span>Month/Year: </label>
									<input type="month" id="month" name="month">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" name="monthlyExpenses">Generate</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- BY MONTH END -->
		<!-- BY DATE START -->
		<div class="modal fade" id="dateExpenses" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">GENERATE EXPENSES REPORT</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex">
						<div class="row">
							<form method="POST" action="dateExpenses.php" target="_blank">
								<div class="col-md-12">
									<label for="Date" style="font-weight: bold;"><span id="required">*</span>From: </label>
									<input class="form-control" type="date" id="date" name="from">
								</div>
								<div class="col-md-12">
									<label for="Date" style="font-weight: bold;"><span id="required">*</span>To: </label>
									<input class="form-control" type="date" id="date" name="to">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" name="dateExpenses">Generate</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- BY DATE END -->
		<!-- GENERATING REPORT FOR EXPENSES END -->

		<!-- GENERATING REPORT FOR CONTRIBUTION SUMMARY START -->
		<!-- BY YEAR START -->
		<div class="modal fade" id="yearContributionSummaryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">GENERATE CONTRIBUTION SUMMARY REPORT</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex">
						<div class="row">
							<form method="POST" action="yearlyContributionSummary.php" target="_blank">
								<div class="col-md-12">
									<label for="year" style="font-weight: bold;"><span id="required">*</span>Year: </label>
									<select id="year" name="year">
									</select>
								</div>
								<div class="col-md-12 d-flex">
									<div class="row">
										<label class="container-fluid" style="font-weight: bold;">Select Contribution Type:<span id="required">*</span></label>
										<div class="col-md-12">
											<input type="checkbox" name="AMF"><label style="font-weight: bold; margin-left: 5px;">Annual Membership Fee</label>
										</div>

										<div class="col-md-12">
											<input type="checkbox" name="MCF"><label style="font-weight: bold; margin-left: 5px;">Monthly Contribution</label>
										</div>

										<div class="col-md-12">
											<input type="checkbox" name="VC"><label style="font-weight: bold; margin-left: 5px;">Voluntary Contribution</label>
										</div>

										<div class="col-md-12">
											<input type="checkbox" name="SC"><label style="font-weight: bold; margin-left: 5px;">Special Contribution</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" name="yearlyContributionSummary">Generate</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- BY YEAR END -->
		<!-- BY MONTH START -->
		<div class="modal fade" id="monthContributionSummaryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">GENERATE CONTRIBUTION SUMMARY REPORT</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex">
						<div class="row">
							<form method="POST" action="monthlyContributionSummary.php" target="_blank">
								<div class="col-md-12">
									<label for="month" style="font-weight: bold;"><span id="required">*</span>Month/Year: </label>
									<input type="month" name="month" id="month">
								</div>
								<div class="col-md-12 d-flex">
									<div class="row">
										<label class="container-fluid" style="font-weight: bold;">Select Contribution Type:<span id="required">*</span></label>
										<div class="col-md-12">
											<input type="checkbox" name="AMF"><label style="font-weight: bold; margin-left: 5px;">Annual Membership Fee</label>
										</div>

										<div class="col-md-12">
											<input type="checkbox" name="MCF"><label style="font-weight: bold; margin-left: 5px;">Monthly Contribution</label>
										</div>

										<div class="col-md-12">
											<input type="checkbox" name="VC"><label style="font-weight: bold; margin-left: 5px;">Voluntary Contribution</label>
										</div>

										<div class="col-md-12">
											<input type="checkbox" name="SC"><label style="font-weight: bold; margin-left: 5px;">Special Contribution</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" name="monthlyContributionSummary">Generate</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- BY MONTH END -->
		<!-- BY DATE START -->
		<div class="modal fade" id="dateContributionSummaryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">GENERATE CONTRIBUTION SUMMARY REPORT</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex">
						<div class="row">
							<form method="POST" action="dateContributionSummary.php" target="_blank">
								<div class="col-md-12">
									<label for="Date" style="font-weight: bold;"><span id="required">*</span>From: </label>
									<input class="form-control" type="date" id="date" name="from">
								</div>
								<div class="col-md-12">
									<label for="Date" style="font-weight: bold;"><span id="required">*</span>To: </label>
									<input class="form-control" type="date" id="date" name="to">
								</div>
								<div class="col-md-12 d-flex">
									<div class="row">
										<label class="container-fluid" style="font-weight: bold;">Select Contribution Type:<span id="required">*</span></label>
										<div class="col-md-12">
											<input type="checkbox" name="AMF"><label style="font-weight: bold; margin-left: 5px;">Annual Membership Fee</label>
										</div>

										<div class="col-md-12">
											<input type="checkbox" name="MCF"><label style="font-weight: bold; margin-left: 5px;">Monthly Contribution</label>
										</div>

										<div class="col-md-12">
											<input type="checkbox" name="VC"><label style="font-weight: bold; margin-left: 5px;">Voluntary Contribution</label>
										</div>

										<div class="col-md-12">
											<input type="checkbox" name="SC"><label style="font-weight: bold; margin-left: 5px;">Special Contribution</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" name="dateContributionSummary">Generate</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- BY DATE END -->
		<!-- GENERATING REPORT FOR CONTRIBUTION SUMMARY END -->

		<!-- GENERATING REPORT FOR EXPENSES AND CONTRIBUTION SUMMARY END -->

		<div class="contribution-header container-fluid px-4 d-flex justify-content-between mt-4">
			<span class="" style="font-size: 18px; font-weight: bold;">Recent Added Contributions</span>		
		</div>

		<!-- CUT CONTRIBUTION MODAL START -->
		<div class="modal fade" id="cutContributionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">EXPENSES</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body d-flex justify-content-between" id="cutContribution">
						<div class="row">
							<div class="col-md-12">
								<label for="name" style="font-weight: bold;">Name<span id="required">*</span></label>
								<select class="form-control" name="name" id="names" required></select>
							</div>
							<div class="col-md-12">
								<label for="reason" style="font-weight: bold;">Reason<span id="required">*</span></label>
								<select class="form-control" name="reason" id="reasons" required>
									<option value="Death Assistance">Death Assistance</option>
									<option value="Medical Assistance">Medical Assistance</option>
									<option value="Wedding Gift">Wedding Gift</option>
									<option value="Voluntary Contribution">Voluntary Contribution</option>
									<option value="Other Reason">Other Reason</option>
								</select>
							</div>
							<div class="col-md-12" id="others" style="display: none;">
								<label for="others" style="font-weight: bold;">Others<span id="required">*</span></label>
								<input type="text" name="others" id="other-reasons" class="form-control" placeholder="Other Reason"  required>
							</div>
							<div class="col-md-12">
								<label for="amount" style="font-weight: bold;">Amount<span id="required">*</span></label>
								<input type="number" pattern="[0-9]*" name="amount" id="amount_expenses" class="form-control" placeholder="0.00"  required>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="submitExpenses();">Done</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		<!-- CUT CONTRIBUTION MODAL END -->
		<div class="container-fluid" id="contribution-records">
			<script>
					// RUN FUNCTION WHEN PAGE IS LOADED
					$(document).ready(function(){
						var today = new Date();
						today.setDate(today.getDate());
						$('input[type="date"]').attr('max', today.toISOString().split("T")[0]);
						$('input[type="month"]').attr('max', new Date().toISOString().slice(0,7));

						displayContribution();
						totalContribution();

						$('#reasons').change(function() {
							var selectedValue = $(this).val();

							if(selectedValue == "Other Reason"){
								$("#others").show();
							}
							else{
								$("#others").hide();
							}

						})
					});

					// DISPLAY CONTRIBUTION RECORDS START
					function displayContribution(){
						var displayContribution = "displayContribution";
						$.ajax({
							url: "displayContribution.php",
							type: "POST",
							data: {displayContribution:displayContribution},
							success:function(data,status){
								$('#contribution-records').html(data);
							}
						});
					}
					// DISPLAY CONTRIBUTION RECORDS END

					// DISPLAY TOTAL CONTRIBUTION AMOUNT START
					function totalContribution(){
						var totalContribution = "totalContribution";
						$.ajax({
							url: "displayContribution.php",
							type: "POST",
							data: {totalContribution:totalContribution},
							success:function(data,status){
								$('#total-contribution').html(data);
							}
						});
					}
					// DISPLAY TOTAL CONTRIBUTION AMOUNT END

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

					// UPDATE ANNUAL MEMBERSHIP FEE FOR NEW MEMBERS START
					function update_AMFNew(){
						var updateAMFNew = "updateAMFNew";

						$.ajax({
							url: "updateAMFNew.php",
							type: "POST",
							data: {updateAMFNew:updateAMFNew},
							success:function(data,status){
								$('#contributionAmount').modal('hide');
								$('#newMember').modal('show');
								$('#amfNew').html(data);
							}
						});
					}

					function updateAMFNew(){
						var newAmount = $('#newAmountAMFNEW').val();
						$.ajax({
							url: "updateAMFNew.php",
							type: "POST",
							data: {newAmount:newAmount},
							success:function(data,status){
								$('#newMember').modal('hide');
								toastr.success("Amount for Annual Membership Fee for new members has been updated!","",{
									timeOut: 2000
								});
							}
						});
					}

					function newAMFLog(){
						$('#newMember').modal('hide');
						$('#newAMF').modal('show');
						var newAMF = 'newAMF';

						$.ajax({
							url: "updateAMFNew.php",
							type: "POST",
							data: {newAMF:newAMF},
							success:function(data,status){
								$('#updateAMFLogs').html(data);
							}
						});
					}

					// UPDATE ANNUAL MEMBERSHIP FEE FOR NEW MEMBERS END

					// UPDATE ANNUAL MEMBERSHIP FEE FOR OLD MEMBERS START
					function update_AMFOld(){
						var updateAMFOld = "updateAMFOld";

						$.ajax({
							url: "updateAMFOld.php",
							type: "POST",
							data: {updateAMFOld:updateAMFOld},
							success:function(data,status){
								$('#contributionAmount').modal('hide');
								$('#oldMember').modal('show');
								$('#amfOld').html(data);
							}
						});
					}

					function updateAMFOld(){
						var newAmount = $('#newAmountAMFOLD').val();
						$.ajax({
							url: "updateAMFOld.php",
							type: "POST",
							data: {newAmount:newAmount},
							success:function(data,status){
								$('#oldMember').modal('hide');
								toastr.success("Amount for Annual Membership Fee for old members has been updated!","",{
									timeOut: 2000
								});
							}
						});
					}

					function oldAMFLog(){
						$('#oldMember').modal('hide');
						$('#oldAMF').modal('show');
						var oldAMF = 'oldAMF';

						$.ajax({
							url: "updateAMFOld.php",
							type: "POST",
							data: {oldAMF:oldAMF},
							success:function(data,status){
								$('#updateOldAMFLogs').html(data);
							}
						});
					}
					// UPDATE ANNUAL MEMBERSHIP FEE FOR OLD MEMBERS END

					// UPDATE MONTHLY CONRTIBUTION FEE START
					function MCF(){
						var MCF = "MCF";

						$.ajax({
							url: "updateMCF.php",
							type: "POST",
							data: {MCF:MCF},
							success:function(data,status){
								$('#contributionAmount').modal('hide');
								$('#mcf').modal('show');
								$('#monthlyfee').html(data);
							}
						});
					}

					function updateMCF(){
						var newAmount = $('#newAmountMCF').val();
						$.ajax({
							url: "updateMCF.php",
							type: "POST",
							data: {newAmount:newAmount},
							success:function(data,status){
								$('#mcf').modal('hide');
								toastr.success("Amount for Monthly Contribution Fee has been updated!","",{
									timeOut: 2000
								});
							}
						});
					}

					function MCFLogs(){
						$('#mcf').modal('hide');
						$('#mcfLog').modal('show');
						var mcfLog = 'mcfLog';

						$.ajax({
							url: "updateMCF.php",
							type: "POST",
							data: {mcfLog:mcfLog},
							success:function(data,status){
								$('#updateMCFLogs').html(data);
							}
						});
					}
					// UPDATE MONTHLY CONTRIBUTION FEE END

					// CUT CONTRIBUTION START
					function cutContribution() {
						$("#cutContributionModal").modal("show");
						var name = "name";
						$.ajax({
							url: "autopopulate.php",
							type: "POST",
							data: {name:name},
							success:function(data,status){
								$("#names").html(data);
								
							}
						});
					}

					function submitExpenses(){
						var name = $('#names').val();
						var reason = $('#reasons').val();
						var amount = $('#amount_expenses').val();

						if(reason == "Other Reason"){
							reason = $("#other-reasons").val();
						}


						if(name != '' && reason != '' && amount != ''){
							$.ajax({
								url: "expenses.php",
								type: "POST",
								data: {name:name, reason:reason, amount:amount},
								success:function(data,status){
									if(data == 1){
										toastr.success("Expenses has been cut to the total contribution!");
										$("#cutContributionModal").modal("hide");
									}
									else if(data == 2) {
										console.log(data);
										toastr.error("Grand collection is short for cutting expenses!");
									}
									else{
										console.log(data);
										toastr.error("Cannot cut the expenses!");
									}
								}
							});
						}
					}
					// CUT CONTRIBUTION END

					// EXPENSES LOG START
					function expensesModal(){
						$("#expensesModal").modal("show");
						var displayExpenses = "displayExpenses";

						$.ajax({
							url: "displayExpenses.php",
							type: "POST",
							data: {displayExpenses:displayExpenses},
							success:function(data,status){
								$('#expenses').html(data);
							}
						});

					}
					// EXPENSES LOG END

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

					// GENERATING EXPENSES REPORT MODAL START
					// BY YEAR START
					function yearExpenses(){
						$('#generateReport').modal('hide');
						$('#yearExpenses').modal('show');

					}
					// BY YEAR END

					// BY MONTH START
					function monthExpenses(){
						$('#generateReport').modal('hide');
						$('#monthExpenses').modal('show');
					}
					// BY MONTH END

					// BY DATE START
					function dateExpenses(){
						$('#generateReport').modal('hide');
						$('#dateExpenses').modal('show');
					}
					// BY DATE END
					// GENERATING EXPENSES REPORT MODAL END

					// GENERATING CONTRIBUTION SUMMARY REPORT MODAL START
					// BY YEAR
					function yearContribution(){
						$('#generateReport').modal('hide');
						$('#yearContributionSummaryModal').modal('show');
					}
					// BY YEAR END

					// BY MONTH START
					function monthContribution(){
						$('#generateReport').modal('hide');
						$('#monthContributionSummaryModal').modal('show');
					}
					// BY MONTH END

					// BY DATE START
					function dateContribution(){
						$('#generateReport').modal('hide');
						$('#dateContributionSummaryModal').modal('show');
					}
					// BY DATE END
					// GENERATING CONTRIBUTION SUMMARY REPORT MODAL END
				</script>
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