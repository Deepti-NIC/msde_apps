<?php       include "__header.php";      ?>


<div class="row bg-white m-n4">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="p-3 d-lg-flex justify-content-between align-items-center">
                            <div><h1 class="mb-0 h2 fw-bold">View Nodal</h1></div>
                        </div>
                    </div>
                </div>



                


    <div class="row mt-8">
                <div class="col-lg-12 col-md-12 col-12">
            <div class="card rounded-3">
                <div class="table-responsive border-0 overflow-y-hidden">
                                        <table class="table mb-0 text-nowrap table-centered table-hover">
                                                <thead class="table-light bg-white">
                            <tr>
                                <th>#</th>
                                <th>DEPARTMENT</th>
                                <th>DOMAIN COUNT</th>
                                <th>NODAL OFFICER</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                                $query = "SELECT A.UserID, A.UserName, COUNT(B.Domain_Name), A.NodalOfficer FROM users A INNER JOIN domain_data B ON A.UserID = B.UserID GROUP BY A.UserID, A.UserName, A.NodalOfficer ORDER BY A.UserName;";
                                if($stmt = mysqli_prepare($conn, $query)) {
                                    if(mysqli_stmt_execute($stmt)) {
                                        mysqli_stmt_bind_result($stmt, $id, $e_userName, $e_domainCount, $e_nodalOfficer);
                                        $counting = 0;
                                        while (mysqli_stmt_fetch($stmt)) {
                                            $counting++;
                            ?>
                            <tr>
                                <td class='small mb-0'><?php echo $counting; ?></td>
                                <td class='small mb-0'><?php echo $e_userName; ?></td>
                                <td class='h6'><?php echo $e_domainCount; ?></td>
                                <td class='small mb-0'><?php echo $e_nodalOfficer; ?></td>
                                <td class='small mb-0'>
                                <button type="button" class="btn btn-sm btn-info mb-2">Nodal Details</button>
                                <button type="button" class="btn btn-sm btn-success mb-2 ms-1 view-data" data-id="<?php echo $id; ?>">View Websites</button>
                            </tr>

<?php
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Statement execution failed: " . mysqli_error($conn);
}
} else {
echo "Prepared statement creation failed: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="data-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">View</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="data-details">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

    
<script>
$(document).ready(function () {
 $(".view-data").click(function () {
 var data_id = $(this).data('id');
 
 $.ajax({
 url: 'pager/users-list.php',
 type: 'POST',
 data: {id: data_id},
 success: function (response) {
 $('#data-details').html(response);
 console.log(data_id);
 console.log(response);
 $('#data-modal').modal('show');
 }
 });
 });
});
</script>



<?php       include "__footer.php";     ?>





