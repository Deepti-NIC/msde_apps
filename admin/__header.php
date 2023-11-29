<?php	include "../__config.php";	

//	var_dump($_SESSION);


if (!isset($_SESSION['AdminID']) && !isset($_SESSION['AdminName']) && !isset($_SESSION['AdminEmail'])) {
        header("Location: ../login");
    }


?>



<!DOCTYPE html>
<html lang="en">
<head>


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>NIC Projects</title>


<link rel="stylesheet" href="../assets/css/theme.min.css">
<link rel="stylesheet" href="../assets/css/custom.css">  
<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
</head>

<body>

<div id="db-wrapper">
	<nav class="navbar-vertical navbar">
    	<div class="vh-100" data-simplebar>
         	<span class="navbar-brand"><a href="../"><img src="../assets/images/logo.svg" alt="NIC Logo" /></a></span>
         	<ul class="navbar-nav flex-column" id="sideNavbar">
            	<li class="nav-item">
            		<a class="nav-link text-white" href="../nodal"><i class="nav-icon fe fe-message-square me-2"></i> Dashboard</a>
            		<a class="nav-link text-white" href="../admin/view-nodal.php"><i class="nav-icon fe fe-message-square me-2"></i> View Nodal</a>
             	</li>         
         	</ul>
    	</div>
 	</nav>
	

	<main id="page-content">
		<div class="header">
		    <nav class="navbar-default navbar navbar-expand-lg">
		        <a id="nav-toggle" href="#"><i class="fe fe-menu"></i></a>
		        <div class="ms-auto d-flex">
        		    <ul class="navbar-nav navbar-right-wrap ms-2 d-flex nav-top-wrap">
                		<li class="dropdown ms-2">
                			<a class="rounded-circle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    			<div class="avatar avatar-md avatar-indicators avatar-online">
                        			<img src="../assets/images/user.jpg" class="rounded-circle" />
                    			</div>
                			</a>
                			<div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    			<div class="dropdown-item">
                        			<div class="d-flex">
                            			<div class="avatar avatar-md">
                                			<img alt="avatar" src="../assets/images/user.jpg" class="rounded-circle" >
                            			</div>
                            			<div class="ms-3 lh-1">
                                			<h5 class="mb-1"><?php echo $_SESSION['AdminName']; ?></h5>
                                			<p class="mb-0 text-muted"><?php echo $_SESSION['AdminEmail']; ?></p>
                            			</div>
                        			</div>
                    			</div>
                    			<div class="dropdown-divider"></div>
                    			<ul class="list-unstyled">
                        			<li><a class="dropdown-item" href="../logout"><i class="fe fe-power me-2"></i> Sign Out</a></li>
                    			</ul>
                			</div>
            			</li>
        			</ul>
        		</div>
    		</nav>
		</div>

            <div class="container-fluid p-4">
