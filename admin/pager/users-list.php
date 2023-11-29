<?php

	if (isset($_POST['id'])) {
 $data_id = $_POST['id'];


	include "../../__config.php";

    
    $stmt = $conn->prepare("SELECT Domain_Name, Public_IP, Status FROM domain_data WHERE UserID = ? ORDER BY Domain_Name ASC");
    $stmt->bind_param("s", $data_id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($vn_domain_name, $vn_public_ip, $vn_status);
    ?>
                                    <table id="dataTableBasic" class="table table-hover" style="width:100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Domain Name</th>
                                            <th>Public IP</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        
<?php
$vn_count = 0;
        while ($stmt->fetch()) {
            $vn_count++;
            echo "<tr>";
            echo "<td>$vn_count </td>";
            echo "<td>$vn_domain_name </td>";
            echo "<td>$vn_public_ip</td>";
            echo "<td>";
            if($vn_status == 1){
                echo "<span class='btn btn-sm btn-success mb-2'>Active</span>";
            }
            else{
                echo "<span class='btn btn-sm btn-danger mb-2'>Inactive</span>";

            }

            echo "<a href ='http://$vn_domain_name' class='btn btn-sm btn-info mb-2 ms-2' target='_blank'>Visit Website</a>";
            echo "</tr>";
        }

        ?>
                                    </tbody>
    </table>

<?php

} else {
?>


 <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
   <div class="d-flex">
     <div class="toast-body">
       No data found
     </div>
     <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
   </div>
 </div>



<?php
}
$stmt->close();
    }
?>