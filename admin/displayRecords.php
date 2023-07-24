<?php 
require ("../config/db_connection.php");
// DISPLAY CONTRIBUTION RECORDS START
if(isset($_POST['displayRecords'])){
	$data = '<table class="table datatable table-responsive-md table-bordered bg-white rounded shadow-sm table-striped text-center">
	<thead class="thead-color">
	<tr>
	<th scope="col">Employee No.</th>
	<th scope="col">Name</th>
	<th scope="col">Date Joined</th>
	<th scope="col">Employee Status</th>
	<th scope="col">Staff Level</th>
	<th scope="col">User Role</th>
	<th scope="col" style="pointer-events: none;">Status</th>
	<th scope="col" style="pointer-events: none;">Action</th>
	</tr>
	</thead>';

	$displayQuery = mysqli_query($con, "SELECT * FROM users ORDER BY id DESC");
	if(mysqli_num_rows($displayQuery) > 0){
		while ($row = mysqli_fetch_assoc($displayQuery)) {
			$id = $row["id"];
			$empNo = $row["empNo"];
			$fname = $row["fname"];
			$mname = $row["mname"];
			$lname = $row["lname"];
			$suffix = $row["suffix"];
			$name = $fname. " " . $mname. " " . $lname. " " . $suffix;
			$name = trim($name);

			$dateJoined = $row["dateJoined"];
			$fdate = date('F d, Y' , strtotime($dateJoined));

			$empStats = $row["empStats"];
			$staffLvl = $row["staffLvl"];
			$userLvl = $row["userLvl"];
			$status = $row["status"];

			$data .= '<tr>
			<td>'.$empNo.'</td>
			<td>'.$name.'</td>
			<td>'.$fdate.'</td>
			<td>'.$empStats.'</td>
			<td>'.$staffLvl.'</td>
			<td>'.$userLvl.'</td>';
			if($status == 1){
				$data .='<td><button class="btn btn-success" onclick="statusModal('.$id.')">Active</button></td>';
			}
			else{
				$data .='<td><button class="btn btn-danger" onclick="statusModal('.$id.')">Inactive</button></td>';
			}
			$data .='
			<td><button class="btn btn-success" onclick="updateUser('.$id.')">Update</button></td>
			</tr>';
		}
	}
	$data .= '</table>';
	echo $data;
}
// DISPLAY CONTRIBUTION RECORDS END

// DISPLAY TOTAL USERS START
if(isset($_POST['totalUsers'])){
	$countUsersQuery = mysqli_query($con, "SELECT * FROM users");
	$totalUsers=mysqli_num_rows($countUsersQuery);
	$data = $totalUsers;
	echo $data;
}

if(isset($_POST['totalContribution'])){
	$totalContribution = mysqli_query($con, "SELECT SUM(Annual_Membership_Fee+Monthly_Contribution+Voluntary_Contribution+Special_Contribution - contributionOut) FROM contribution_summary");
	$totalCollection=mysqli_fetch_array($totalContribution);
	$data = $totalCollection[0];
	$data = floatval($data);
	$data = number_format($data, 2);
	echo $data;
	
}
// DISPLAY TOTAL USERS END
?>

<!-- DATATABLE -->
<script type="text/javascript" src="js/datatable/simple-datatables.js"></script>
<script type="text/javascript" src="js/datatable/tinymce.min.js"></script>
<script type="text/javascript" src="js/datatable/datatable.js"></script>