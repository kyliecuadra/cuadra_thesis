<?php 
require("../config/db_connection.php");
session_start();
if(isset($_POST['displayExpenses'])){
	$data = '<table class="table datatable table-responsive-md table-bordered bg-white rounded shadow-sm  table-striped text-center">
	<thead class="thead-color">
	<tr>
	<th class="text-white" scope="col" width="50">#</th>
	<th scope="col">Employee Number</th>
	<th scope="col">Name</th>
	<th scope="col">Reason</th>
	<th scope="col">Amount</th>
	<th scope="col">Date</th>
	</tr>
	</thead>
	<tbody>';

	$displayQuery = mysqli_query($con, 'SELECT expenses.*, users.staffLvl FROM expenses JOIN users ON expenses.empNo = users.empNo  WHERE users.staffLvl = "'.$_SESSION['staffLvl'].'"');
	if(mysqli_num_rows($displayQuery) > 0){
		$uid = 0;
		while ($row = mysqli_fetch_assoc($displayQuery)) {
			$id = $row['id'];
			$empNo = $row['empNo'];
			$name = $row['name'];
			$reason = $row['reason'];
			$amount = $row['amount'];
			$date = $row['date'];
			$fdate = date('F d, Y' , strtotime($date));

			$uid++;
			$data .= '<tr>
			<td>'.$uid.'</td>
			<td>'.$empNo.'</td>
			<td>'.$name.'</td>
			<td>'.$reason.'</td>
			<td>'.$amount.'</td>
			<td>'.$fdate.'</td>
			</tr>';
		}
	}
	else {
		$data .= '<tr><td colspan="7">No Expenses Record</td></tr>';
	}
	$data .= '</tbody></table>';
	echo $data;
}

?>