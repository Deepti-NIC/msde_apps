<?php


	if (isset($_POST['id'])) {


	include "../../__config.php";

    $data_id = $_POST['id'];

    $UserID = $_SESSION['UserID'];
    
    
    
    $stmt = $conn->prepare("SELECT Domain_Name, Public_IP, Status FROM domain_data WHERE id = ? AND UserID = ? ORDER BY Domain_Name ASC");
    $stmt->bind_param("ss", $data_id, $UserID);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($vn_domain_name, $vn_public_ip, $vn_status);

        
        while ($stmt->fetch()) {
    ?>


        <div class="row">
      <div class="col-12 mb-3 mb-4">
            <label for="domainName" class="form-label">Domain Name</label>
  <input class="form-control" id="domainName" data-id="<?php echo $data_id; ?>" type="text" value="<?php echo $vn_domain_name; ?>" readonly disabled>
    </div>


    

    <div class="col-6 mb-3 mb-4">
            <label for="pri_ip" class="form-label">Private IP</label>
  <input class="form-control" id="pri_ip" type="text" value="" readonly disabled>
    </div>

        <div class="col-6 mb-3 mb-4">
            <label for="pub_ip" class="form-label">Public IP</label>
  <input class="form-control" id="pub_ip" type="text" value="<?php echo $vn_public_ip; ?>" readonly disabled>
    </div>

    

    <div class="col-6 mb-3 mb-4">
            <label for="valid_till" class="form-label">Audit Valid Till</label>
  <input class="form-control" id="valid_till" type="date">
    </div>



    <div class="col-6 mb-3 mb-4">
        <label for="sa_report" class="form-label mb-1 text-dark">Security Audit Report <span class="text-danger">*</span></label>
            <input type="file" class="form-control" id="sa_report" accept=".pdf" onchange="ch_pdf()" />
    </div>

    
    </div>
    


<button class="btn btn-primary" onclick="uploadPDF()">Update Details</button>
 


 
<?php
        }


} else {
?>


       No data found


<?php
}
$stmt->close();
    }
?>