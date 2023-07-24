<?php 
require ("../config/db_connection.php");
session_start();
require ("../config/session_timeout.php");

if(!isset($_SESSION['id'])){
	header("location: ../config/not_login-error.html");
}
else{
	if($_SESSION['userLvl'] == "Admin"){
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
					<span class="link-name" style="color: #00FFF3;">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="">
					<i><img src="../assets/icons/clipboard-solid.svg" style="height: 24px; filter: invert(92%) sepia(19%) saturate(4902%) hue-rotate(106deg) brightness(106%) contrast(105%);"></i>
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
				<span class="dashboard">THE CONTRIBUTIONS</span>
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
		<!-- CONTRIBUTION ACTION BUTTONS START -->
		<div class="mr-auto mt-1 d-flex justify-content-between contribution-actions">
			<button class="btn btn-primary ml-4" onclick="expensesModal()">Expenses Log</button>
			<button class="btn btn-primary mr-4" data-toggle="modal" data-target="#generateReport">Generate Report</button>
		</div>
		<div class="form-group col-md-3" style="margin: 15px 0 0 30px;">
			<label for="year">Year</label>
			<select class="form-control-lg w-50" type="year" name="year" id="year"></select>
		</div>
		<!-- CONTRIBUTION ACTION BUTTONS START -->
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
							<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="expensesDropdown">Expenses</button>
							<div class="dropdown-menu" style="cursor: pointer;" aria-labelledby="expensesDropdown">
								<a class="dropdown-item" onclick="yearExpenses()">By Year</a>
								<a class="dropdown-item" onclick="monthExpenses()">By Month</a>
								<a class="dropdown-item" onclick="dateExpenses()">By Date</a>
							</div>
						</div>
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="contributionDropdown">Contribution Summary</button>
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
									<label for="year" style="font-weight: bold;">Year: </label>
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
									<label for="month" style="font-weight: bold;">Month/Year: </label>
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
									<label for="Date" style="font-weight: bold;">From: </label>
									<input class="form-control" type="date" id="date" name="from">
								</div>
								<div class="col-md-12">
									<label for="Date" style="font-weight: bold;">To: </label>
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
									<label for="year" style="font-weight: bold;">Year: </label>
									<select id="year" name="year">
									</select>
								</div>
								<div class="col-md-12 d-flex">
									<div class="row">
										<label class="container-fluid" style="font-weight: bold;">Select Contribution Type:</label>
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
									<label for="month" style="font-weight: bold;">Month/Year: </label>
									<input type="month" name="month" id="month">
								</div>
								<div class="col-md-12 d-flex">
									<div class="row">
										<label class="container-fluid" style="font-weight: bold;">Select Contribution Type:</label>
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
									<label for="Date" style="font-weight: bold;">From: </label>
									<input class="form-control" type="date" id="date" name="from">
								</div>
								<div class="col-md-12">
									<label for="Date" style="font-weight: bold;">To: </label>
									<input class="form-control" type="date" id="date" name="to">
								</div>
								<div class="col-md-12 d-flex">
									<div class="row">
										<label class="container-fluid" style="font-weight: bold;">Select Contribution Type:</label>
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

		<!-- GENERATING REPORT FOR EXPENSES AND CONTRIBUTION SUMMARY END -->

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
		var today = new Date();
		today.setDate(today.getDate());
		$('input[type="date"]').attr('max', today.toISOString().split("T")[0]);
		$('input[type="month"]').attr('max', new Date().toISOString().slice(0,7));

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