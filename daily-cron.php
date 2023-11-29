<?php
	include "__config.php";

	function fetchCertificateInfo($domain){
		$ch = curl_init("https://$domain");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CERTINFO, true);
		$result = curl_exec($ch);
		if ($result === false) {
			return false;
		}
		$certInfo = curl_getinfo($ch, CURLINFO_CERTINFO);
		curl_close($ch);
		return $certInfo;
	}

	$query = "SELECT id, domain_name FROM domain_data WHERE status = ?";
	$param = "1";

	$stmt = $conn->prepare($query);
	if(!$stmt) {
		die("Error preparing SQL statement for fetching data: " . $conn->error);
	}

	$stmt->bind_param("s", $param);
	$stmt->execute();

	$stmt->bind_result($id, $domain);

	$dataToInsert = [];
	while ($stmt->fetch()) {
		$sslInfo = fetchCertificateInfo($domain);
		if($sslInfo) {
			$expiryTimestamp = strtotime($sslInfo[0]['Expire date']);
			$SSL_Expiry_Date = date("Y-m-d", $expiryTimestamp);
			$SSL_Days_Left = ceil(($expiryTimestamp - time()) / (60 * 60 * 24));
			$SSL_Last_Renewed = strtotime($sslInfo[0]['Start date']);
			$SSL_Last_Renewed = date("Y-m-d", $SSL_Last_Renewed);

			$dataToInsert[] = [
				'id' => $id,
				'SSL_Expiry_Date' => $SSL_Expiry_Date,
				'SSL_Days_Left' => $SSL_Days_Left,
				'SSL_Last_Renewed' => $SSL_Last_Renewed,
			];
		}
	}

	$stmt->close();

	$insertQuery = "INSERT INTO daily_cron (fk_id, SSL_Expiry_Date, SSL_Days_Left, SSL_Last_Renewed) VALUES (?, ?, ?, ?)";
	$insertStmt = $conn->prepare($insertQuery);

	if(!$insertStmt) {
		die("Error preparing SQL statement for insertion: " . $conn->error);
	}
    else{
        echo "Data inserted successfully.";
    }

	foreach ($dataToInsert as $data) {
		if(!$insertStmt->bind_param("ssss", $data['id'], $data['SSL_Expiry_Date'], $data['SSL_Days_Left'], $data['SSL_Last_Renewed'])) {
			die("Error binding parameters for insertion: " . $insertStmt->error);
		}

		if (!$insertStmt->execute()) {
			die("Error executing SQL statement for insertion: " . $insertStmt->error);
		}
	}


	$insertStmt->close();




	$conn->close();

?>