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
                            <!-- Card -->
                            <div class="card mb-4">

                                <div class="table-responsive border-0 overflow-y-hidden">
                                    <table class="table mb-0 text-nowrap table-centered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Website</th>
                                                <th>Audit Valid Till</th>
                                                <th>Audit Doc</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="accordion-toggle collapsed" id="accordion1" data-bs-toggle="collapse" data-bs-parent="#accordion1" data-bs-target="#collapseOne">
                                                <td>1</td>
                                                <td>indiaskills.org</td>
                                                <td>Nov 07, 2023</td>
                                                <td><span class="badge bg-primary">pdf</span></td>
                                                <td><span class="btn-icon btn btn-ghost btn-sm rounded-circle"><span class="material-symbols-outlined">more_vert</span></span></td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
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
                                <td class='small mb-0'><span class="badge bg-primary">pdf</span></td>
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



            <?php
    include "__footer.php";


    ?>





