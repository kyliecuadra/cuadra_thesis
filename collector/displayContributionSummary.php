<?php 
require ("../config/db_connection.php");
session_start();

if(isset($_POST['year'])){
	$year = $_POST['year'];
	$data = '<table class="table datatable table-responsive-md table-bordered bg-white rounded shadow-sm  table-striped text-center" id="summaryTbl">
	<thead class="thead-color">
	<tr>
	<th scope="col">Name</th>
	<th></th>
	<th></th>
	<th></th>
	<th></th>
	<th scope="col">Year</th>
	</tr>
	</thead>
	<tbody>';
	$displayQuery = mysqli_query($con, "SELECT CONCAT(users.fname,' ', users.mname,' ', users.lname,' ', users.suffix) as Name, users.status, users.staffLvl, contribution_records.empNo, contribution_records.name, contribution_records.contributionType, contribution_records.amount, contribution_records.month, contribution_records.year, contribution_records.date, contribution_records.collected_by FROM users JOIN contribution_records ON contribution_records.empNo = users.empNo WHERE contribution_records.year = $year AND users.staffLvl = '".$_SESSION['staffLvl']."' ORDER BY users.fname ASC, contribution_records.date DESC");
	$i=0;
	$prevName='';
	while($row = mysqli_fetch_assoc($displayQuery)){
		$name = $row['Name'];
		$year = $_POST['year'];

		$contribution = $row['contributionType'];
		$amount = $row['amount'];
		$month = $row['month'];
		$date = $row['date'];
		$fdate = date('F d, Y', strtotime($date));
		$collected_by = $row['collected_by'];

		$i++;
		

		if ($name != $prevName) {
			  if ($prevName != '') {
      $data .= '</td></tr>';
    }
			$data .= '
			<tr class="text-justify bg-light" style="cursor: pointer;" data-toggle="collapse" data-target="#'.$name.'" aria-expanded="false" aria-controls="contribution'.$i.'">
			<td colspan="6" style="font-weight:bold;">'.$name.'<span class="text-center" style="float: right; font-weight:bold;">'.$year.'</span></td>
			</tr>
			<tr class="panel-collapse collapse" id="'.$name.'">
			<th scope="col" class="text-center">Contribution Type</th>
			<th scope="col" class="text-center">Amount</th>
			<th scope="col" class="text-center">Month</th>
			<th scope="col" class="text-center">Year</th>
			<th scope="col" class="text-center">Date</th>
			<th scope="col" class="text-center">Collected By</th>
			</tr>
			';
			$prevName = $name;
			
		}
		$data .= '<tr class="collapse panel-collapse" id="'.$name.'">
		<td>'.$contribution.'</td>
		<td>'.$amount.'</td>
		<td>'.$month.'</td>
		<td>'.$year.'</td>
		<td>'.$fdate.'</td>
		<td>'.$collected_by.'</td>
		</tr>';
	}
	  if ($prevName != '') {
      $data .= '</td></tr>';
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

