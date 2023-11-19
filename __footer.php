
</main>

<div class="four-line">
        <span class="span1">&nbsp;</span><span class="span2">&nbsp;</span><span class="span3">&nbsp;</span><span class="span4">&nbsp;</span>
        <div class="clear"></div>
</div>



    <footer class="pt-5 footer bg-white">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-12">
            <div class="mb-4">
              <img src="../assets/images/NIC_Logo1-01.svg" alt="" class="logo-inverse ">
            </div>
          </div>
          <div class="offset-lg-1 col-lg-2 col-md-3 col-6">
            <div class="mb-4">
            </div>
          </div>
          <div class="col-lg-2 col-md-3 col-6">
            <div class="mb-4">
            </div>
          </div>
          <div class="col-lg-3 col-md-12">
            <div class="mb-4">

            </div>
          </div>
        </div>
        <div class="row align-items-center g-0 border-top py-2 mt-6">
          <div class="col-lg-10 col-12">
            <div class="d-lg-flex align-items-center">

              <div>

              </div>
            </div>
          </div>


        </div>
      </div>
    </footer>






<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/theme.min.js"></script>
<script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<?php
function getIPAddress() {  
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$ip = getIPAddress();

$isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));
if ($isMob) {
    $device = "Mobile";
} else {
    $device = "Desktop";
}
$__dev = $_SERVER['HTTP_USER_AGENT'];


$stmt = mysqli_prepare($conn, "INSERT INTO hit_counter (IP, Device, Client) VALUES (?, ?, ?)");

mysqli_stmt_bind_param($stmt, "sss", $ip, $device, $__dev);

if (mysqli_stmt_execute($stmt)) {
    $stmt->close();
}

if ($conn->ping()) {
	$conn->close();
}

?>
</body>
</html>