<?php 
require ("../config/db_connection.php");
session_start();
// DISPLAY ALL CONTRIBUTION RECORDS START
if(isset($_POST['displayContribution'])){
	$data = '<table class="table datatable table-responsive-md table-bordered bg-white rounded shadow-sm  table-striped text-center">
	<thead class="thead-color">
	<tr>
	<th class="text-white" scope="col" width="50">#</th>
	<th scope="col">Contribution</th>
	<th scope="col">Amount</th>
	<th scope="col">Month</th>
	<th scope="col">Year</th>
	<th scope="col">Date</th>
	</tr>
	</thead>
	<tbody>';

	$displayQuery = mysqli_query($con, 'SELECT * FROM contribution_records WHERE name = "'.$_SESSION['name'].'" ORDER BY id DESC');
	if(mysqli_num_rows($displayQuery) > 0){
		$uid = 0;
		while ($row = mysqli_fetch_assoc($displayQuery)) {
			$id = $row['id'];
			$empNo = $row['empNo'];
			$name = $row['name'];
			$contribution = $row['contributionType'];
			$amount = $row['amount'];
			$month = $row['month'];
			$year = $row['year'];
			$date = $row['date'];
			$fdate = date('F d, Y' , strtotime($date));


			$uid++;
			$data .= '<tr>
			<td>'.$uid.'</td>
			<td>'.$contribution.'</td>
			<td>'.$amount.'</td>
			<td>'.$month.'</td>
			<td>'.$year.'</td>
			<td>'.$fdate.'</td>
			</tr>';
		}
	}
	$data .= '</tbody></table>';
	echo $data;

}
// DISPLAY ALL CONTRIBUTION RECORDS END

// DISPLAY TOTAL CONTRIBUTION AMOUNT START
if(isset($_POST['totalContribution'])){
	$countContributionsQuery = mysqli_query($con, 'SELECT SUM(monthlyContribution+voluntaryContribution+specialContribution) FROM contribution_records WHERE name = "'.$_SESSION['name'].'"');
	$totalContribution=mysqli_fetch_array($countContributionsQuery);
	if ($totalContribution[0] < 1) {
		$data = '&#8369; 0';
	}
	else{
		$data = '&#8369; '. $totalContribution[0].'';
	}
	echo $data;
}
// DISPLAY TOTAL CONTRIBUTION AMOUNT END

?>

<!-- DATATABLE -->
<script type="text/javascript" src="js/datatable/simple-datatables.js"></script>
<script type="text/javascript" src="js/datatable/tinymce.min.js"></script>
<script type="text/javascript" src="js/datatable/datatable.js"></script>
