<?php 
require ("../config/db_connection.php");
session_start();
require ("../config/session_timeout.php");
if(!isset($_SESSION['id'])){
	header("location: ../config/not_login-error.html");
}
else{
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

if (isset($_POST['yearlyExpenses'])) {
	$year = $_POST['year'];

	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Contribution Report</title>
		<link rel="icon" href="../assets/img/html_icon.png">
		<!-- BOOTSTRAP 4 CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- LOCAL CSS -->
		<link rel="stylesheet" type="text/css" href="css/print.css">
	</head>
	<body>
		<div class="container">
			<button class="btn btn-primary mb-4 w-25 print" onclick="window.print()">Print</button>
			<nav class="d-flex justify-content-center">
				<img src="../assets/img/logo_tec.png" height="100" class="d-inline-block align-top" alt="">
				<div class="navbar-brand d-flex flex-column text-center">
					<span>Amadeo Teachers and Employees Club</span>
					<span>Amadeo National High School</span>
					<span>Amadeo, Cavite</span>
				</div>
			</nav>
			<div class="row mt-4">
				<div class="col h5">EXPENSES (<?php echo $year ?>)</div>
			</div>
			<div class="row pl-2 pr-2">
				<table class="table table-responsive-md table-bordered bg-white rounded shadow-sm  table-striped text-center" id="summaryTbl">
					<thead id="thead-color">
						<tr>
							<th scope="col">Employee Number</th>
							<th scope="col">Name</th>
							<th scope="col">Reason</th>
							<th scope="col">Amount</th>
							<th scope="col">Date</th>
							<th scope="col">Total</th>
						</tr>
						
					</thead>
					<tbody>
						<?php 
						$displayQuery = mysqli_query($con, "SELECT * FROM expenses WHERE YEAR(date) = $year ORDER BY date DESC");
						if(mysqli_num_rows($displayQuery) > 0){
							while ($row = mysqli_fetch_assoc($displayQuery)) {
								$empNo = $row['empNo'];
								$name = $row['name'];
								$reason = $row['reason'];
								$amount = $row['amount'];
								$date = $row['date'];
								$fdate = date('F d, Y' , strtotime($date));

								echo '<tr>
								<td>'.$empNo.'</td>
								<td>'.$name.'</td>
								<td>'.$reason.'</td>
								<td>'.$amount.'</td>
								<td>'.$fdate.'</td>
								<td class="font-weight-bold"></td>';
								echo'</tr>';
							}
							echo '<tr><td><strong>TOTAL</strong></td>
									<td></td>
									<td></td>
									<td class="font-weight-bold"></td>
									<td></td>
									<td class="font-weight-bold"></td></tr>';
						}
						else{
							echo '<tr><td colspan="5">No contributions has been made in this year ('.$year.').</td></tr>';
						}
						?>
					</tbody>
				</table>
				<div class="mt-4 d-flex justify-content-between w-100" style="font-size: 18px;">
					<div style="text-align: center;">
						<span>
							<?php 
							date_default_timezone_set('Asia/Manila'); 
							echo date('F d, Y'); 
							?>
						</span>
						<div style="width: auto; height: 2px; border-radius: 5px; background: #000;"></div>
						<span>Date Generated</span>
					</div>
					<div style="text-align: center;">
						<span><?php echo $_SESSION['name']; ?></span>
						<div style="width: auto; height: 2px; border-radius: 5px; background: #000;"></div>
						<span>Prepared By</span>
					</div>
				</div>
			</div>
		</div>
		<?php 
	}
	?>
	<script>
	// ADD TOTAL FOR ROWS AND COLUMNS
// ADD TOTAL FOR ROWS AND COLUMNS
	// Get the table
	const table = document.getElementById('summaryTbl');

	// Initialize the variables to store the sums
	let columnSums = {};

	// Loop through the rows
	for (let i = 1; i < table.rows.length - 1; i++) {
		const row = table.rows[i];
		const cells = row.cells;

		// Initialize the row sum
		let rowSum = 0;

		// Loop through the cells starting from the third column
		for (let j = 3; j < cells.length - 2; j++) {
			// Parse the cell value as a float
			const cellValue = parseFloat(cells[j].textContent);
			// Add the cell value to the corresponding column sum
			const columnHeader = table.rows[0].cells[j].textContent;
			if (columnSums[columnHeader]) {
				columnSums[columnHeader] += cellValue;
			} else {
				columnSums[columnHeader] = cellValue;
			}

			// Add the cell value to the row sum
			rowSum += cellValue;
		}

		// Set the row sum to the last cell
		cells[cells.length - 1].textContent = rowSum.toFixed(2);
	}

	// Set the column sums to the corresponding cells
	const footerRow = table.rows[table.rows.length - 1];
	for (let j = 3; j < footerRow.cells.length - 2; j++) {
		const columnHeader = table.rows[0].cells[j].textContent;
		footerRow.cells[j].textContent = columnSums[columnHeader].toFixed(2);
	}

	// Calculate and set the total sum for the last column
	let totalSum = 0;
	const columnHeaders = Array.from(table.rows[0].cells).slice(3, -2).map(cell => cell.textContent);
	for (const columnHeader of columnHeaders) {
		const cellIndex = Array.from(table.rows[0].cells).findIndex(cell => cell.textContent === columnHeader);
		const cell = footerRow.cells[cellIndex];
		const columnSum = columnSums[columnHeader];
		
		cell.textContent = columnSum.toFixed(2);
		totalSum += columnSum;

	}

	footerRow.cells[footerRow.cells.length - 1].textContent = totalSum.toFixed(2);
</script>
	<!-- BOOTSTRAP JS -->
	<script src="js/jquery-3.6.0.min.js"></script>
	<script src="js/bootstrap.bundle.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>