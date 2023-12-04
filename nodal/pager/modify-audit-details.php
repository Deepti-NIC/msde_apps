<?php
	include "../../__config.php";


$user_id = $_SESSION['UserID'];
$uploadFolder = '../uploads/';

if(!is_dir($uploadFolder)){
    mkdir($uploadFolder, 0777, true);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dv = $_POST['dv'];

	$dv_ver = $conn->prepare("SELECT COUNT(*) FROM domain_data WHERE id = ? AND UserID = ?;");
	$dv_ver->bind_param("ii", $dv, $user_id);
	$dv_ver->execute();
	$dv_ver->bind_result($dv_ch);
	$dv_ver->fetch();
	$dv_ver->close();

	if ($dv_ch >= 2) {
        	echo "Invalid request";
	        exit;
	}

    if($_POST['valid_till'] == ''){
        echo "Invalid Date";
        exit();
    }
if(!isset($_FILES['sa_report'])){
    echo "please upload file";
    exit();
}

    
    $valid_till = $_POST['valid_till'];
    $pdfFile = $_FILES['sa_report'];


    $fileType = strtolower(pathinfo($pdfFile['name'], PATHINFO_EXTENSION));
    if ($fileType !== 'pdf') {
        echo 'Error: Only PDF files are allowed.';
        exit;
    }

//    $uploadPath = $uploadFolder . basename($pdfFile['name']);
$file_new = uniqid() . '.pdf';
    $uploadPath = $uploadFolder . $file_new;
    move_uploaded_file($pdfFile['tmp_name'], $uploadPath);


$update_audit_query = "UPDATE domain_data SET Audit_Valid_Till = ?, Security_Audit_Report = ? WHERE id = ? AND UserID = ?;";

$update_audit = $conn->prepare($update_audit_query);

$update_audit->bind_param("ssii", $valid_till, $uploadPath, $dv, $user_id);

$updateResult = $update_audit->execute();

if ($updateResult) {

    $logQuery = "INSERT INTO security_audit_logs(UserID, DomainID, Audit_Valid_Till, Security_Audit_Report) VALUES(?, ?, ?, ?);";
    $logStatement = $conn->prepare($logQuery);

    $logStatement->bind_param("iiss", $dv, $user_id, $valid_till, $uploadPath);

    $logResult = $logStatement->execute();

    if ($logResult) {
        ?>


<script>
    var trElement = document.querySelector('[data-id="<?php echo $dv; ?>"]').closest("tr");
    
    var dateTd = trElement.querySelector('td:nth-child(3)');
    var domainTd = trElement.querySelector('td:nth-child(4)');


    dateTd.textContent = '<?php echo $valid_till; ?>';
    domainTd.innerHTML = '<a href="uploads/<?php echo $file_new; ?>" class="badge bg-primary" target="_blank">pdf</a>';

    document.querySelector('.btn-close').click();
    alert('Data updated successfully');
</script>


        <?php
    } else {
        echo "log error: " . $logStatement->error;
    }
} else {
    echo "data: " . $updateStatement->error;
}

$update_audit->close();
$logStatement->close();

//  $conn->close();



    } else {
    echo 'Something went wrong. Please contact administrator.';
}
?>
