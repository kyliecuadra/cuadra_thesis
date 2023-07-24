<?php 
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
	<title>Input Contribution</title>
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
	<script src="js/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">
</head>
<body>
	<style>
		table {
			counter-reset: rowNumber;
		}

		table tr:nth-child(n+2)::before {
			display: table-cell;
			counter-increment: rowNumber;
			content: counter(rowNumber);
			text-align: center;
			padding: 12px;
			font-weight: bold;
			font-size: 18px;
		}
	</style>
	<section class="home-section" style="left: 0 !important; width: 100% !important;">
		<nav class="" style="left: 0 !important; width: 100% !important;">
			<div class="sidebar-button">
				<span class="dashboard">ADD CONTRIBUTION</span>
			</div>
		</nav>

		<!-- ADD CONTRIBUTION TABLE (LIST STYLE) START -->
		<div class="container-fluid">
			<form id="inputContributionForm">
				<table class="table text-center table-bordered table-striped mt-4" id="inputContributionTable">
					<tr style="position: sticky; top: 78px; background-color: #cecece;">
						<th>#</th>
						<th>Name<span id="required">*</span></th>
						<th>Contribution Type<span id="required">*</span></th>
						<th>Amount<span id="required">*</span></th>
						<th>Month<span id="required">*</span></th>
						<th>Year<span id="required">*</span></th>
						<th><button type="button" class="btn btn-success" id="addRow">+</button></th>
					</tr>
					<tr>
						<td>
							<select class="form-control name" name="name[]" id="name"></select>
						</td>
						<td>
							<select class="form-control" name="contribution[]" id="contribution" required>
								<option></option>
								<option value="Annual Membership Fee">Annual Membership Fee</option>
								<option value="Monthly Contribution">Monthly Contribution</option>
								<option value="Voluntary Contribution">Voluntary Contribution</option>
								<option value="Special Contribution">Special Contribution</option>
							</select>
						</td>
						<td>
							<input type="number" class="form-control" name="amount[]" required placeholder="Amount"  id="amount" autocomplete="off">
						</td>
						<td>
							<select name="month[]" class="form-control" id="month">
								<option value="-"></option>
								<option value="January">January</option>
								<option value="February">February</option>
								<option value="March">March</option>
								<option value="April">April</option>
								<option value="May">May</option>
								<option value="June">June</option>
								<option value="July">July</option>
								<option value="August">August</option>
								<option value="September">September</option>
								<option value="October">October</option>
								<option value="November">November</option>
								<option value="December">December</option>
							</select>
						</td>
						<td>
							<select id="year" name="year[]" class="form-control" required>
							</select>
						</td>
						<td>
							<button type='button' name='remove' data-row='row1' class='btn btn-danger btn-xs' onclick="removeRow(this)">-</button>
						</td>
					</tr>
				</table>
			</form>
			<div class="d-flex justify-content-end">
				<button type="button" name="contribution_check"  onclick="contribution_check()" class="btn btn-primary mr-4 px-4">Add Contribution</button>
				<button type="button" class="btn btn-secondary px-4" onclick="history.back();">Close</button>
			</div>
		</div>
		<!-- ADD CONTRIBUTION TABLE (LIST STYLE) END -->

		<!-- DOUBLE CHECK ALERT START -->
		<div class="modal fade" id="contribution_check" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-white" style="background-color: #023047;">
						<h5 class="modal-title">ADD CONTRIBUTION CHECK</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Please double check all the input contributions.</p>
						<span style="color: red;">*After adding the contribution(s), it cannot be removed or updated.</span>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" name="addContribution" id="addContribution">Add Contribution</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- DOUBLE CHECK ALERT END -->
	</section>


	<script>

		// DROPDOWN NAMES START
		$(document).ready(function(){
			year();
			amount();
			restrictNegative();
			var name = "name";
			
			$.ajax({
				url: "autopopulate.php",
				type: "POST",
				data: {name:name},
				success:function(data,status){
					$("#name").html(data);	
		
				}
			});
		});

		// ADDING ROWS START
		var count = 0;
		$('#addRow').click(function(){
			count++;
			console.log(count);
			name(count);
			addRow(count);
			yearRow(count);
			amountRow(count);
			restrictNegativeRows(count);
		});
		// ADDING ROWS END
		
		function name(i){
			var name = "name";
			
			$.ajax({
				url: "autopopulate.php",
				type: "POST",
				data: {name:name},
				success:function(data,status){
					$("#name"+i).html(data);			
				}
			});
		}
		// DROPDOWN NAMES END

		// AUTOPOPULATE YEAR START
		function year(){
			var elements = document.getElementById("year"); 
			let currentYear = new Date().getFullYear();    
			let earliestYear = 2022;     
			while (currentYear >= earliestYear) {  
				let dateOption = document.createElement('option');        
				dateOption.textContent = currentYear;   
				dateOption.value = currentYear; 
				elements.append(dateOption);
				currentYear --;

			}
		}

		function yearRow(i){
			var elements = document.getElementById("year"+i); 

			let currentYear = new Date().getFullYear();    
			let earliestYear = 2022;     
			while (currentYear >= earliestYear) {  
				let dateOption = document.createElement('option');        
				dateOption.textContent = currentYear;   
				dateOption.value = currentYear; 
				elements.append(dateOption);
				currentYear --;
			}
		}

		// AUTOPOPULATE YEAR END

		// ADDING AND DELETING ROWS START
		function addRow(i) {
			var table = document.getElementById("inputContributionTable");
			var row = table.insertRow(-1);
			var nameCell = row.insertCell(0);
			var contributionTypeCell = row.insertCell(1);
			var amountCell = row.insertCell(2);
			var monthCell = row.insertCell(3);
			var yearCell = row.insertCell(4);
			var actionCell = row.insertCell(5);
			nameCell.innerHTML = '<select class="form-control name" name="name[]" id="name'+i+'"></select>';
			contributionTypeCell.innerHTML = '<select class="form-control" name="contribution[]" id="contribution'+i+'" required><option></option><option value="Annual Membership Fee">Annual Membership Fee</option><option value="Monthly Contribution">Monthly Contribution</option><option value="Voluntary Contribution">Voluntary Contribution</option><option value="Special Contribution">Special Contribution</option></select>';
			amountCell.innerHTML = '<input type="number" class="form-control" name="amount[]" required placeholder="Amount" id="amount'+i+'" autocomplete="off">';
			monthCell.innerHTML = '<select name="month[]" class="form-control" id="month'+i+'"><option value="-"></option><option>January</option><option>February</option><option>March</option><option>April</option><option>May</option><option>June</option><option>July</option><option>August</option><option>September</option><option>October</option><option>November</option><option>December</option></select>'; 
			yearCell.innerHTML = '<select id="year'+i+'" name="year[]" class="form-control" required></select>';
			actionCell.innerHTML = '<input type="button" class="btn btn-danger" value="-" onclick="removeRow(this)">';

			
		}

		function removeRow(button) {
			var table = document.getElementById("inputContributionTable");
			var rowCount = table.rows.length;
			if(rowCount > 2){
				var row = button.parentNode.parentNode;
				row.parentNode.removeChild(row);
			}
		}
		// ADDING AND DELETING ROWS END

		// AUTOPOPULATE AMOUNT START
		function amount(){
			$("tr").find("#contribution, #name").change(function(){
				var name = $("#name").val();
				var contribution = $("#contribution").val();
				// DISABLING INPUT BASE ON THE CONTRIBUTION TYPE
				if (contribution == "Annual Membership Fee") {
					$( "#amount").prop( "readonly", true );
					$( "#month").hide();
					$('#month').val('-');
				}
				else if (contribution == "Monthly Contribution") {
					$( "#amount").prop( "readonly", true );
					$( "#month").show();
				}
				else{
					$( "#amount").prop( "readonly", false );
					$( "#month").show();
				}

				// AUTOPOPULATING THE AMOUNT BASE ON THE CONTRIBUTION TYPE AND DATE THE USER JOINED IN THE ORGANIZATION
				$.ajax({
					url: "autopopulate.php",
					type: "POST",
					data: {contribution:contribution,
						names:name},
						success:function(data,status){
							$("#amount").val(data);
						}
					});
			});
		}

		function amountRow(i){
			$("tr").find("#contribution"+i+", #name"+i).change(function(){
				var name = $("#name"+i).val();
				var contribution = $("#contribution"+i).val();
				// DISABLING INPUT BASE ON THE CONTRIBUTION TYPE
				if (contribution == "Annual Membership Fee") {
					$( "#amount"+i).prop( "readonly", true );
					$( "#month"+i).hide();
				}
				else if (contribution == "Monthly Contribution") {
					$( "#amount"+i).prop( "readonly", true );
					$( "#month"+i).show();
				}
				else{
					$( "#amount"+i).prop( "readonly", false );
					$( "#month"+i).show();
				}

				// AUTOPOPULATING THE AMOUNT BASE ON THE CONTRIBUTION TYPE AND DATE THE USER JOINED IN THE ORGANIZATION
				$.ajax({
					url: "autopopulate.php",
					type: "POST",
					data: {contribution:contribution,
						names:name},
						success:function(data,status){
							$("#amount"+i).val(data);
						}
					});
			});
		}

		// AUTOPOPULATE AMOUNT END

		// ADD CONTRIBUTION CHECK MODAL START
		function contribution_check(){
			$("#contribution_check").modal('show');
		}

		document.getElementById("addContribution").onclick = function(){
			var amount = $("#amount").val();
			console.log(amount);
			$('#inputContributionForm').submit(function(event){
				event.preventDefault();
				});
			var formData = $('#inputContributionForm').serialize();

			$.ajax({
				url: 'addContribution.php',
				type: 'POST',
				data: formData,
				success: function(data) {
					if(data.includes("0")){
						toastr.error("A contribution is already existed!");
					}
					if(data.includes("1")){
						console.log(data);
						toastr.success("Contrbution has been added!");
						setTimeout(function() {
							history.back();
						}, 1000);
						$("#contribution_check").modal('hide');
					}
					if(data.includes("Empty")){
						console.log(data);
						toastr.error("Please fill up the fields!");
					}
					if(data.includes("duplicate")){
						console.log(data);
						toastr.error("Duplicate Value");
					}
					else {
						console.log(data);
					}
				}
			});
		}
		// ADD CONTRIBUTION CHECK MODAL END

		// RESTRICT NEGATIVE NUMBER START
		function restrictNegative(){
			$("#amount").on('keydown', function(event){
				if(event.keyCode === 189 || event.keyCode === 109){
					event.preventDefault();
				}
			})
		}

		function restrictNegativeRows(i){
			$("#amount"+i).on('keydown', function(event){
				if(event.keyCode === 189 || event.keyCode === 109){
					event.preventDefault();
				}
			})
		}
		// RESTRICT NEGATIVE NUMBER END
	</script>

	<!-- BOOTSTRAP JS -->
	<script src="js/bootstrap.bundle.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<!-- DATATABLE -->
	<script type="text/javascript" src="js/datatable/simple-datatables.js"></script>
	<script type="text/javascript" src="js/datatable/tinymce.min.js"></script>
	<script type="text/javascript" src="js/datatable/datatable.js"></script>
</body>
</html>