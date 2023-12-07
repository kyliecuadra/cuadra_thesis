<?php
require("../config/db_connection.php");

if(isset($_POST['updateAMFNew'])){
	$data = '';
	$sql = mysqli_query($con, "SELECT newAMF, dateNewAMF FROM contributionfee WHERE newAMF != 0.00 ORDER BY id DESC LIMIT 1");
	if(mysqli_num_rows($sql) > 0){
		while($row = mysqli_fetch_assoc($sql)){
			$newAMF = $row['newAMF'];

			$data = '<div class="row">
			<div class="col-md-12">
			<label style="font-weight: bold;">Current Amount</label>
			<input type="text" class="form-control" value="'.$newAMF.'" readonly>
			</div>
			<div class="col-md-12">
			<label style="font-weight: bold;">New Amount<span id="required">*</span></label>
			<input type="number" pattern="[0-9]*" class="form-control" placeholder="0.00" id="newAmountAMFNEW"">
			</div>
			</div>';
		}
	}
	else{
		$data = '<div class="row">
		<div class="col-md-12">
		<label style="font-weight: bold;">Enter Amount<span id="required">*</span></label>
		<input type="number" pattern="[0-9]*" class="form-control" placeholder="0.00" id="newAmountAMFNEW"">
		</div>
		</div>';
	}

	echo $data;
}

if(isset($_POST['newAmount'])){
	$newAmount = $_POST['newAmount'];
	date_default_timezone_set('Asia/Manila'); 
	$date = date('Y-m-d h:i:s');

	mysqli_query($con, "INSERT INTO contributionfee (newAMF, dateNewAMF) VALUES ($newAmount, '$date')");
}

if(isset($_POST['newAMF'])){
	$data = '<table class="table datatable table-responsive-md table-bordered bg-white rounded shadow-sm  table-striped text-center">
	<thead class="thead-color">
	<tr>
	<th scope="col">Amount</th>
	<th scope="col">Date</th>
	</tr>
	</thead>
	<tbody>';

	$displayQuery = mysqli_query($con, 'SELECT newAMF, dateNewAMF FROM contributionfee WHERE newAMF != 0.00 ORDER BY dateNewAMF DESC');
	if(mysqli_num_rows($displayQuery) > 0){
		$uid = 0;
		while ($row = mysqli_fetch_assoc($displayQuery)) {
			$amount = $row['newAMF'];
			$date = $row['dateNewAMF'];
			$fdate = date('F d, Y h:i:s A', strtotime($date));

			$data .= '<tr>
			<td>'.$amount.'</td>
			<td>'.$fdate.'</td>
			</tr>';
		}
	}
	$data .= '</tbody></table>';
	echo $data;
}
?>