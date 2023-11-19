<?php	include "__config.php";	?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="theme-color" content="#2483c5" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
	<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<link rel="stylesheet" href="../assets/css/theme.min.css">
<link rel="stylesheet" href="../assets/css/custom.css">  
<link href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="../assets/js/vendors/highcharts.js"></script>
    <title>NIC Projects</title>
</head>

<body>

<main>


    <nav class="navbar navbar-expand-lg navbar-default" id="navbar" style="background: #2483c5;">
	<div class="container-fluid px-0">
		<a class="navbar-brand" href="/"><img src="../assets/images/logo.svg" alt="NIC Logo" style="height: 40px;" ></a>

		<ul class="navbar-nav navbar-right-wrap ms-auto d-lg-none d-flex nav-top-wrap">
<?php

if (isset($_SESSION['UserID']) || isset($_SESSION['AdminID'])) {
	if (isset($_SESSION['UserID'])) {

?>
			<li class="dropdown ms-2">
				<a class="rounded-circle" href="#" role="button" data-bs-toggle="dropdown">
					<div class="avatar avatar-md avatar-indicators avatar-online">
						<img alt="avatar" src="../assets/images/user.jpg" class="rounded-circle" >
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-end shadow">
					<div class="dropdown-item">
						<div class="d-flex">
							<div class="avatar avatar-md avatar-indicators avatar-online">
								<img alt="avatar" src="../assets/images/user.jpg" class="rounded-circle" >
							</div>
							<div class="ms-3 lh-1">
								<h5 class="mb-1"><?php echo $_SESSION['NodalOfficer']; ?></h5>
								<p class="mb-0 text-muted"><?php echo $_SESSION['NodalEmail']; ?></p>
							</div>
						</div>
					</div>
					<div class="dropdown-divider"></div>
					<ul class="list-unstyled">
						<li><a class="dropdown-item" href="../nodal/profile"><i class="fe fe-user me-2"></i>Profile</a></li>
					</ul>
					<div class="dropdown-divider"></div>
					<ul class="list-unstyled">
						<li><a class="dropdown-item" href="../logout"><i class="fe fe-power me-2"></i>Logout</a></li>
					</ul>
				</div>
			</li>
?>

<?php
} 
	else {
?>



			<li class="dropdown ms-2">
				<a class="rounded-circle" href="#" role="button" data-bs-toggle="dropdown">
					<div class="avatar avatar-md avatar-indicators avatar-online">
						<img alt="avatar" src="../assets/images/user.jpg" class="rounded-circle" >
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-end shadow">
					<div class="dropdown-item">
						<div class="d-flex">
							<div class="avatar avatar-md avatar-indicators avatar-online">
								<img alt="avatar" src="../assets/images/user.jpg" class="rounded-circle" >
							</div>
							<div class="ms-3 lh-1">
								<h5 class="mb-1"><?php echo $_SESSION['AdminEmail']; ?></h5>
								<p class="mb-0 text-muted"><?php echo $_SESSION['AdminEmail']; ?></p>
							</div>
						</div>
					</div>
					<div class="dropdown-divider"></div>
					<ul class="list-unstyled">
						<li><a class="dropdown-item" href="../admin/profile"><i class="fe fe-user me-2"></i>Profile</a></li>
					</ul>
					<div class="dropdown-divider"></div>
					<ul class="list-unstyled">
						<li><a class="dropdown-item" href="../logout"><i class="fe fe-power me-2"></i>Logout</a></li>
					</ul>
				</div>
			</li>



<?php
}
} else {
    echo '<li><a href="../login" class="btn btn-sm btn-outline-white">Login</a></li>';
}
?>

		</ul>

	        <button class="navbar-toggler collapsed border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
			<span class="icon-bar bg-white top-bar mt-0"></span>
			<span class="icon-bar bg-white middle-bar"></span>
			<span class="icon-bar bg-white bottom-bar"></span>
		</button>


		<div class="collapse navbar-collapse" id="navbar-default">
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link text-white" href="/">Home</a></li>
			</ul>
			<div class="ms-auto d-flex align-items-center">

            
			<ul class="navbar-nav navbar-right-wrap ms-2 d-none d-lg-block">
			
<?php

if (isset($_SESSION['UserID']) || isset($_SESSION['AdminID'])) {
	if (isset($_SESSION['UserID'])) {
?>            

				<li class="dropdown ms-2 d-inline-block">
					<a class="rounded-circle" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
						<div class="avatar avatar-md avatar-indicators avatar-online">
							<img alt="avatar" src="../assets/images/user.jpg" class="rounded-circle" >
						</div>
					</a>
					<div class="dropdown-menu dropdown-menu-end">
						<div class="dropdown-item">
							<div class="d-flex">
								<div class="avatar avatar-md avatar-indicators avatar-online">
									<img alt="avatar" src="../assets/images/user.jpg" class="rounded-circle" >
								</div>
								<div class="ms-3 lh-1">
									<h5 class="mb-1"><?php echo $_SESSION['NodalOfficer']; ?></h5>
									<p class="mb-0 text-muted"><?php echo $_SESSION['NodalEmail']; ?></p>
								</div>
							</div>
						</div>
						<div class="dropdown-divider"></div>
						<ul class="list-unstyled">
							<li><a class="dropdown-item" href="javascript:void(0);"><i class="fe fe-user me-2"></i>Profile</a></li>
						</ul>
						<div class="dropdown-divider"></div>
						<ul class="list-unstyled">
							<li><a class="dropdown-item" href="logout"><i class="fe fe-power me-2"></i>Logout</a></li>
						</ul>
					</div>
				</li>


<?php
}
else {
?>


				<li class="dropdown ms-2 d-inline-block">
					<a class="rounded-circle" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
						<div class="avatar avatar-md avatar-indicators avatar-online">
							<img alt="avatar" src="../assets/images/user.jpg" class="rounded-circle" >
						</div>
					</a>
					<div class="dropdown-menu dropdown-menu-end">
						<div class="dropdown-item">
							<div class="d-flex">
								<div class="avatar avatar-md avatar-indicators avatar-online">
									<img alt="avatar" src="../assets/images/user.jpg" class="rounded-circle" >
								</div>
								<div class="ms-3 lh-1">
									<h5 class="mb-1"><?php echo $_SESSION['AdminEmail']; ?></h5>
									<p class="mb-0 text-muted"><?php echo $_SESSION['AdminEmail']; ?></p>
								</div>
							</div>
						</div>
						<div class="dropdown-divider"></div>
						<ul class="list-unstyled">
							<li><a class="dropdown-item" href="javascript:void(0);"><i class="fe fe-user me-2"></i>Profile</a></li>
						</ul>
						<div class="dropdown-divider"></div>
						<ul class="list-unstyled">
							<li><a class="dropdown-item" href="logout"><i class="fe fe-power me-2"></i>Logout</a></li>
						</ul>
					</div>
				</li>



<?php
}
} else {
    echo '<li><a href="../login" class="btn btn-sm btn-outline-white">Login</a></li>';
}
?>

			</ul>
			</div>
		</div>
	</div>
</nav>
