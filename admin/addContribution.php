<?php
require("../config/db_connection.php");
session_start();

if (isset($_POST["name"])) {
	$recordExist = false;
	$empNo = [];
	$dataCount = count($_POST["name"]);

	for ($i = 0; $i < $dataCount; $i++) {
		$name = $_POST["name"][$i];
		$sql = mysqli_query($con, "SELECT * FROM users WHERE CONCAT(fname,' ', mname,' ', lname,' ', suffix) LIKE '%$name%'");
		while ($row = mysqli_fetch_assoc($sql)) {
			$empNoData = $row['empNo'];
			array_push($empNo, $empNoData);
		}
	}

	// Loop through each submitted row
	for ($i = 0; $i < $dataCount; $i++) {
        $name = $_POST["name"][$i];
        $contribution = $_POST["contribution"][$i];
        $amount = $_POST["amount"][$i];
        $month = $_POST["month"][$i];
        $year = $_POST["year"][$i];

        // Combine the values into a single string
        $combinedValues = $name . $contribution . $amount . $month . $year;

        // Check if the combined values already exist in the previous rows
        for ($j = 0; $j < $i; $j++) {
            $prevName = $_POST["name"][$j];
            $prevContribution = $_POST["contribution"][$j];
            $prevAmount = $_POST["amount"][$j];
            $prevMonth = $_POST["month"][$j];
            $prevYear = $_POST["year"][$j];

            $prevCombinedValues = $prevName . $prevContribution . $prevAmount . $prevMonth . $prevYear;

            if ($combinedValues === $prevCombinedValues) {
                echo "duplicate";
                $recordExist = true;
                break; // Exit both loops
            }
        }

		// Check if the name already exists in the database
		if ($contribution == "Annual Membership Fee") {
			$sql = "SELECT * FROM contribution_records WHERE empNo='$empNo[$i]' AND contributionType='$contribution' AND year='$year'";
			$result = mysqli_query($con, $sql);
			if (mysqli_num_rows($result) > 0) {
				echo '0';
				$recordExist = true;
				break;
			}
		} if ($contribution == "Monthly Contribution") {
			$sql = "SELECT * FROM contribution_records WHERE empNo='$empNo[$i]' AND contributionType='$contribution' AND month = '$month' AND year='$year'";
			$result = mysqli_query($con, $sql);
			if (mysqli_num_rows($result) > 0) {
				echo '0';
				$recordExist = true;
				break;
			}
		} 
	}

	// If data does not exist in the database and there are no duplicates, insert new data
	if (!$recordExist) {
		for ($i = 0; $i < $dataCount; $i++) {
			$name = $_POST["name"][$i];
			$contribution = $_POST["contribution"][$i];
			$amount = $_POST["amount"][$i];
			$month = $_POST["month"][$i];
			$year = $_POST["year"][$i];
			$date = date('Y-m-d');
			$collected_by = $_SESSION['name'];
			$contributionList = array('name' => $name, 'contribution' => $contribution, 'month' => $month, 'year' => $year);

			if (empty($name) || empty($contribution) || empty($amount) || empty($month) || empty($year)) {
				echo "Empty";
				break;
			}

			if ($contribution == "Annual Membership Fee") {
				mysqli_query($con, "INSERT INTO contribution_summary VALUES ('', '$empNo[$i]', '$name', '$amount', '', '', '', '', '$month', '$year', '$date')");
				mysqli_query($con, "INSERT INTO contribution_records VALUES ('', '$empNo[$i]', '$name', '$contribution', '$amount', '$month', '$year', '$date', '$collected_by')");
				echo '1';
			}
			if ($contribution == "Monthly Contribution") {
				mysqli_query($con, "INSERT INTO contribution_summary VALUES ('', '$empNo[$i]', '$name', '', '$amount', '', '', '', '$month','$year', '$date')");
				mysqli_query($con, "INSERT INTO contribution_records VALUES ('', '$empNo[$i]', '$name', '$contribution', '$amount', '$month', '$year', '$date', '$collected_by')");
				echo '1';
			}
			if ($contribution == "Voluntary Contribution") {
				mysqli_query($con, "INSERT INTO contribution_summary VALUES ('', '$empNo[$i]', '$name', '', '', '$amount', '', '', '$month','$year', '$date')");
				mysqli_query($con, "INSERT INTO contribution_records VALUES ('', '$empNo[$i]', '$name', '$contribution', '$amount', '$month', '$year', '$date', '$collected_by')");
				echo '1';
			}
			if ($contribution == "Special Contribution") {
				mysqli_query($con, "INSERT INTO contribution_summary VALUES ('', '$empNo[$i]', '$name', '', '', '', '$amount', '', '$month','$year', '$date')");
				mysqli_query($con, "INSERT INTO contribution_records VALUES ('', '$empNo[$i]', '$name', '$contribution', '$amount', '$month', '$year', '$date', '$collected_by')");
				echo '1';
			}
		}
	}
}
