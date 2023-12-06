<?php
    include "__header.php"; 
    ?>

<script src="../assets/js/vendors/highcharts.js"></script>

                <div class="row bg-white m-n4">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="p-3 d-lg-flex justify-content-between align-items-center">
                            <div><h1 class="mb-0 h2 fw-bold">Dashboard</h1></div>
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
                                                <th>Website</th>
                                                <th>Audit Valid Till</th>
                                                <th>Audit Doc</th>
                                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                                $query = "SELECT id, Domain_Name, Audit_Valid_Till, Security_Audit_Report FROM domain_data WHERE UserID = " . $_SESSION['UserID'] . " ORDER BY Domain_Name;";


                                if($stmt = mysqli_prepare($conn, $query)) {
                                    if(mysqli_stmt_execute($stmt)) {
                                        mysqli_stmt_bind_result($stmt, $id, $Domain_Name, $valid_date, $audit_repot);
                                        $counting = 0;
                                        while (mysqli_stmt_fetch($stmt)) {
                                            $counting++;
                            ?>
                            <tr>
                                <td class='small mb-0'><?php echo $counting; ?></td>
                                <td class='small mb-0'><?php echo $Domain_Name; ?></td>
                                <td class='small mb-0'><?php echo $valid_date; ?></td>
                                <td class='small mb-0'><?php if($audit_repot == ''){ ?><a href="javascript:void(0);" class="badge bg-primary">pdf</a> <?php } else { ?><a href="<?php echo $audit_repot; ?>" class="badge bg-primary" target="_blank">pdf</a> <?php } ?></td>
                                <td class='small mb-0'>
                                <button type="button" class="btn btn-sm btn-info mb-2 ms-1 view-data" data-id="<?php echo $id; ?>">Modify Audit Details</button>
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
        <h1 class="modal-title fs-5 data-heading">View</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="data-details">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
    
  <span id="response"></span>
<script>
$(document).ready(function () {
 $(".view-data").click(function () {
 var data_id = $(this).data('id');
 var dprtmnt = $(this).closest('tr').find('td:eq(1)').text();

 $.ajax({
 url: 'pager/get-audit-details.php',
 type: 'POST',
 data: {id: data_id},
 success: function (response) {
 $('#data-details').html(response);
 // console.log(response);
 $('#data-modal').modal('show');
 document.querySelector('.data-heading').innerHTML = dprtmnt;
 }
 });
 });
});


function ch_pdf(){
        var sa_report_pdf = document.getElementById('sa_report');
        var sa_report_file = sa_report_pdf.value;
        var allowedExtensions = /(\.pdf)$/i;

        if (!allowedExtensions.exec(sa_report_file)) {
            alert('Invalid file type. Only PDF files are allowed.');
            sa_report_pdf.value = '';
            return false;
        }
    }




function uploadPDF() {
    var formData = new FormData();
    formData.append('dv', $("#domainName").data("id"));
    formData.append('valid_till', $("#valid_till").val());
    formData.append('sa_report', $('#sa_report')[0].files[0]);
    
    
    $.ajax({
        type: 'POST',
        url: 'pager/modify-audit-details.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#response').html(response);
            console.log(response);
        }
    });
}

</script>



            <?php
    include "__footer.php";


    ?>





