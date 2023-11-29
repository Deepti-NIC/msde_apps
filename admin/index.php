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

             
				<?php
					$query = "SELECT COUNT(VC.Domain_Name), SUM(CASE WHEN VC.SSL_Days_Left < 0 THEN 1 ELSE 0 END) FROM view_cron VC INNER JOIN domain_data DD ON DD.Domain_Name = VC.Domain_Name;";
					$stmt = mysqli_prepare($conn, $query);
					if (!$stmt) {
						die("Error: " . mysqli_error($conn));
					}
                    
					if (mysqli_stmt_execute($stmt)) {
						mysqli_stmt_bind_result($stmt, $domainName_count, $sslDaysLeft_count);
						while (mysqli_stmt_fetch($stmt)) {
?>


                <section class="mt-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-12">
                    <div class="row g-4">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-body border-bottom border-primary border-4 shadow p-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-xl fs-2 bg-info bg-opacity-10 rounded-3 text-white text-center">
                                        <span class="material-symbols-outlined">captive_portal</span>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="mb-0"><?php echo $domainName_count; ?></h3>
                                        <h6 class="mb-0">Websites</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-body border-bottom border-danger border-4 shadow p-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-xl fs-2 bg-danger bg-opacity-10 rounded-3 text-white text-center">
                                        <span class="material-symbols-outlined">lock</span>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="mb-0"><?php echo $sslDaysLeft_count; ?></h3>
                                        <h6 class="mb-0">SSL Expired</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-body border-bottom border-warning border-4 shadow p-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-xl fs-2 bg-warning bg-opacity-10 rounded-3 text-white text-center">
                                        <span class="material-symbols-outlined">pending_actions</span>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="mb-0">21</h3>
                                        <h6 class="mb-0">VA Pending</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-body border-bottom border-success border-4 shadow p-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-xl fs-2 bg-success bg-opacity-10 rounded-3 text-white text-center">
                                        <span class="material-symbols-outlined">assignment_turned_in</span>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="mb-0">8</h3>
                                        <h6 class="mb-0">VA Completed</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
	</div>
	</div>
</section>


<?php
					}
					mysqli_stmt_close($stmt);
					} else {
						die("Error: " . mysqli_error($conn));
					}
				?>
                



<section class="py-4">
	<div class="container">
        <div class="row g-4">
            <div class="col-xl-8">
                <div class="card border h-100">
                    <div class="card-body">
                        <div id="container1"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card border h-100">
                    <div class="card-header border-bottom p-3">
                        <h5 class="card-header-title mb-0">SSL Expiry</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-12">
				<?php
					$status = 1;
					$query = "SELECT x.Domain_Name, y.SSL_Expiry_Date, y.SSL_Days_Left, y.SSL_Last_Renewed, y.Timestamp FROM (SELECT id, domain_name, status FROM domain_data WHERE status = ? ORDER BY domain_name) x INNER JOIN daily_cron y ON x.id = y.fk_id WHERE y.Timestamp = (SELECT MAX(Timestamp) FROM daily_cron) ORDER BY y.SSL_Days_Left LIMIT 4";
					$stmt = mysqli_prepare($conn, $query);
					if (!$stmt) {
						die("Error: " . mysqli_error($conn));
					}
					mysqli_stmt_bind_param($stmt, "i", $status);
					if (mysqli_stmt_execute($stmt)) {
						mysqli_stmt_bind_result($stmt, $domainName, $sslExpiryDate, $sslDaysLeft, $sslLastRenewed, $timestamp);
						while (mysqli_stmt_fetch($stmt)) {
							$sslExpiryDateFormatted = date("d-m-Y", strtotime($sslExpiryDate));
							$sslLastRenewedFormatted = date("d-m-Y", strtotime($sslLastRenewed));
							$websiteColor = ($sslDaysLeft <= 30) ? ' text-danger' : '';
							echo "<span class='h6 $websiteColor'>$domainName</span>";
							echo "<p class='small mb-0'>SSL Certificate Expiry Date: $sslExpiryDateFormatted</p>";
							echo "<p class='small mb-0'>Days to Expiry: $sslDaysLeft days</p>";
							echo "<p class='small mb-0'>Last Renewed: $sslLastRenewedFormatted</p>";
							echo "<hr>";
					}
					mysqli_stmt_close($stmt);
					} else {
						die("Error: " . mysqli_error($conn));
					}
				?>



							 	<span data-bs-toggle="modal" data-bs-target="#listDomain">View All</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</section>

<span data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="show-m" class="d-none"></span>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-scrollable">
    	<div class="modal-content">
      		<div class="modal-header" id="pieTable_header">
        		<h1 class="modal-title fs-5" id="staticBackdropLabel">SSL Expiration Info</h1>
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<div class="modal-body pie-c" id="modalContent"></div>
    	</div>
  	</div>
</div>

<div class="modal fade" id="listDomain" data-bs-backdrop="listDomain" data-bs-keyboard="false" tabindex="-1" aria-labelledby="listDomainLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-scrollable">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h1 class="modal-title fs-5" id="listDomainLabel">SSL Expiration Info</h1>
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<div class="modal-body">
				<table id="dataTableBasic" class="table table-hover" style="width:100%">
					<thead class="table-light">
						<tr>
                  			<th>Domain Name</th>
                  			<th>SSL Expiry Date</th>
                  			<th>SSL Days Left</th>
                  			<th>SSL Last Renewed</th>
              			</tr>
              		</thead>
              		<tbody>
				<?php
					$status = 1;
					$query = "SELECT x.Domain_Name, y.SSL_Expiry_Date, y.SSL_Days_Left, y.SSL_Last_Renewed, y.Timestamp FROM (SELECT id, domain_name, status FROM domain_data WHERE status = ? ORDER BY domain_name) x INNER JOIN daily_cron y ON x.id = y.fk_id WHERE y.Timestamp = (SELECT MAX(Timestamp) FROM daily_cron) ORDER BY y.SSL_Days_Left";
					$stmt = mysqli_prepare($conn, $query);
					if (!$stmt) {
						die("Error: " . mysqli_error($conn));
					}
					mysqli_stmt_bind_param($stmt, "i", $status);
					if (mysqli_stmt_execute($stmt)) {
						mysqli_stmt_bind_result($stmt, $domainName, $sslExpiryDate, $sslDaysLeft, $sslLastRenewed, $timestamp);
						while (mysqli_stmt_fetch($stmt)) {
							$sslExpiryDateFormatted = date("d-m-Y", strtotime($sslExpiryDate));
							$sslLastRenewedFormatted = date("d-m-Y", strtotime($sslLastRenewed));
							$websiteColor = ($sslDaysLeft <= 30) ? ' text-danger' : '';
							echo "<tr>";
							echo "<td class='h6 $websiteColor'>$domainName</td>";
							echo "<td class='small mb-0'>$sslExpiryDateFormatted</td>";
							echo "<td class='small mb-0'>$sslDaysLeft</td>";
							echo "<td class='small mb-0'>$sslLastRenewedFormatted</td>";
							echo "</tr>";
						}
					mysqli_stmt_close($stmt);
					} else {
						die("Error: " . mysqli_error($conn));
					}
?>


	              </tbody>
          		</table>
			</div>
    	</div>
  	</div>
</div>

<table class="table table-bordered dataTable d-none" id="myTable">
	<thead>
		<tr>
    		<th>Domain Name</th>
    		<th>SSL Expiry Date</th>
    		<th>SSL Days Left</th>
    		<th>SSL Last Renewed</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$status = 1;
			$query = "SELECT x.Domain_Name, y.SSL_Expiry_Date, y.SSL_Days_Left, y.SSL_Last_Renewed, y.Timestamp FROM (SELECT id, domain_name, status FROM domain_data WHERE status = ? ORDER BY domain_name) x INNER JOIN daily_cron y ON x.id = y.fk_id WHERE y.Timestamp = (SELECT MAX(Timestamp) FROM daily_cron) ORDER BY y.SSL_Days_Left";
			$stmt = mysqli_prepare($conn, $query);
			if (!$stmt) {
				die("Error: " . mysqli_error($conn));
			}
			mysqli_stmt_bind_param($stmt, "i", $status);
			if (mysqli_stmt_execute($stmt)) {
				mysqli_stmt_bind_result($stmt, $domainName, $sslExpiryDate, $sslDaysLeft, $sslLastRenewed, $timestamp);
				while (mysqli_stmt_fetch($stmt)) {
					$websiteColor = ($sslDaysLeft <= 30) ? ' text-danger' : '';
					echo "<tr>";
					echo "<td class='h6 $websiteColor'>$domainName</td>";
					echo "<td class='small mb-0'>$sslExpiryDate</td>";
					echo "<td class='small mb-0'>$sslDaysLeft days</td>";
					echo "<td class='small mb-0'>$sslLastRenewed</td>";
					echo "</tr>";
				}
				mysqli_stmt_close($stmt);
			} else {
				die("Error: " . mysqli_error($conn));
			}
		?>
	</tbody>
</table>

<script>
    var expiredData = [];
    var days0to7Data = [];
    var days7to15Data = [];
    var days15to30Data = [];
    var moreThan30Data = [];

    $('#myTable tbody tr').each(function() {
        var domainName = $(this).find('td:nth-child(1)').text();
        var sslExpiryDate = $(this).find('td:nth-child(2)').text();
        var sslDaysLeft = parseInt($(this).find('td:nth-child(3)').text());
        var sslLastRenewed = $(this).find('td:nth-child(4)').text();
        var domainData = {
            domainName: domainName,
            sslExpiryDate: sslExpiryDate,
            sslDaysLeft: sslDaysLeft,
            sslLastRenewed: sslLastRenewed,
        };
        if (sslDaysLeft < 0) {
        	expiredData.push(domainData);
        } else if (sslDaysLeft >= 0 && sslDaysLeft <= 7) {
        	days0to7Data.push(domainData);
        } else if (sslDaysLeft > 7 && sslDaysLeft <= 15) {
            days7to15Data.push(domainData);
        } else if (sslDaysLeft > 15 && sslDaysLeft <= 30) {
            days15to30Data.push(domainData);
        } else {
            moreThan30Data.push(domainData);
        } 
    });

	function openModal(category, pieColor) {
        var modal = document.getElementById("staticBackdrop");
        var modalContent = document.getElementById("modalContent");
        var categoryData = getDataForCategory(category);
	document.getElementById('pieTable_header').style.backgroundColor = pieColor + '26';
//	document.getElementById('pieTable_header').style.border = '2px solid ' + pieColor + 'FC';
	document.querySelector('#staticBackdrop .modal-content').style.border = '0';

        document.getElementById("staticBackdropLabel").innerHTML = "<span class='text-danger fw-normal'>SSL Expiration Category:</span> " + category;
    var modalHtml = "<table class='table mb-0 table-center table-bordered w-100'>";
        modalHtml += "<thead id='pieTable'>";
        modalHtml += "<tr>";
        modalHtml += "<th>#</th>";
        modalHtml += "<th>Domain Name</th>";
        modalHtml += "<th>SSL Expiry Date</th>";
        modalHtml += "<th>SSL Days Left</th>";
        modalHtml += "<th>SSL Last Renewed</th>";
        modalHtml += "</tr>";
        modalHtml += "</thead>";
	domainCount = 0;
        categoryData.forEach(function(domainData) { 
	domainCount++;
            modalHtml += "<tr>";
            modalHtml += "<td>" + domainCount + "</td>";
            modalHtml += "<td>" + domainData.domainName + "</td>";
            modalHtml += "<td>" + domainData.sslExpiryDate + "</td>";
            modalHtml += "<td>" + domainData.sslDaysLeft + "</td>";
            modalHtml += "<td> " + domainData.sslLastRenewed + "</td>";
            modalHtml += "</tr>";
        });
        modalHtml += "</table>";
        modalContent.innerHTML = modalHtml;
	if(pieColor != '#F59E0B'){
		pieTable = document.getElementById('pieTable');
		pieTable_th = pieTable.getElementsByTagName('th');
			for (var i = 0; i < pieTable_th.length; i++) {
				pieTable_th[i].style.color = '#FFF';
			}
		document.getElementById('pieTable').style.backgroundColor = pieColor;
		}
		else {
		pieTable = document.getElementById('pieTable');
		pieTable_th = pieTable.getElementsByTagName('th');
			for (var i = 0; i < pieTable_th.length; i++) {
				pieTable_th[i].style.color = '#000';
			}
		document.getElementById('pieTable').style.backgroundColor = pieColor;
	}
        document.getElementById('show-m').click();
    }
    function getDataForCategory(category) {
        switch (category) {
            case 'Expired':
                return expiredData;
            case '0-7 days':
                return days0to7Data;
            case '7-15 days':
                return days7to15Data;
            case '15-30 days':
                return days15to30Data;
            case 'More than 30 days':
                return moreThan30Data;
            default:
                return [];
        }
    }
    Highcharts.chart('container1', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'SSL Expiry'
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}'
                },
                point: { 
                    events: {
                        click: function() { 

//                        var clickedSliceColor = this.color;
//                        alert("Color: " + clickedSliceColor);
                            openModal(this.name, this.color);
                        }
                    }
                }
            },
        },
/*
        series: [{
            name: 'SSL Expiration',
            data: [
                ['Expired', expiredData.length],
                ['0-7 days', days0to7Data.length],
                ['7-15 days', days7to15Data.length],
                ['15-30 days', days15to30Data.length],
                ['More than 30 days', moreThan30Data.length]
            ]
        }]
    });
*/



            series: [{
                name: 'SSL Count',
                data: [
                    {
                        name: 'Expired',
                        y: expiredData.length,
                        color: '#ff0000'
                    },
                    {
                        name: '0-7 days',
                        y: days0to7Data.length,
                        color: '#DC2626' 
                    },
                    {
                        name: '7-15 days',
                        y: days7to15Data.length,
                        color: '#F59E0B' 
                    },
                    {
                        name: '15-30 days',
                        y: days15to30Data.length,
                        color: '#0ea5e9'
                    },
                    {
                        name: 'More than 30 days',
                        y: moreThan30Data.length,
                        color: '#38A169'
                    }
                ]
            }],
        });

</script>



            <?php
                
                
    include "__footer.php";


    ?>





