<?php 
require ("../config/db_connection.php");
session_start();

if(isset($_POST['year'])){
	$year = $_POST['year'];
	$data = '<table class="table datatable table-responsive-md table-bordered bg-white rounded shadow-sm  table-striped text-center" id="summaryTbl">
	<thead class="thead-color">
	<tr>
	<th class="text-white" scope="col" width="50">#</th>
	<th scope="col">Contribution</th>
	<th scope="col">Amount</th>
	<th scope="col">Month</th>
	<th scope="col">Date</th>
	<th scope="col">Collected By</th>
	</tr>
	</thead>
	<tbody>';
	$displayQuery = mysqli_query($con, "SELECT * FROM `contribution_records` WHERE year = $year and empNo = ".$_SESSION['empNo']." ORDER BY date DESC");
	$uid = 0;
		while ($row = mysqli_fetch_assoc($displayQuery)) {
			$id = $row['id'];
			$empNo = $row['empNo'];
			$contribution = $row['contributionType'];
			$amount = $row['amount'];
			$month = $row['month'];
			$date = $row['date'];
			$fdate = date('F d, Y' , strtotime($date));
			$collected_by = $row['collected_by'];


			$uid++;
			$data .= '<tr>
			<td>'.$uid.'</td>
			<td>'.$contribution.'</td>
			<td>'.$amount.'</td>
			<td>'.$month.'</td>
			<td>'.$fdate.'</td>
			<td>'.$collected_by.'</td>
			</tr>';
		}
	$data .= '</tbody>
	</table>';

	echo $data;
}
?>
<!-- DATATABLE -->
<script type="text/javascript" src="js/datatable/simple-datatables.js"></script>
<script type="text/javascript" src="js/datatable/tinymce.min.js"></script>
<script type="text/javascript" src="js/datatable/datatable.js"></script>

