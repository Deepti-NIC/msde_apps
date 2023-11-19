<?php	
include "__header.php";		?>

<?php


if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['usertype'])) {

	$usertype = filter_var($_POST['usertype'], FILTER_SANITIZE_NUMBER_INT);

/*
$allowedUserTypes = [101, 102];
if (!in_array($usertype, $allowedUserTypes)) {
    echo 'Invalid user';
exit();
}
*/


	$username = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['username']);
	$password = $_POST['password'];


if($usertype == 101){
	$checkLockoutQuery = $conn->prepare("SELECT COUNT(*) AS login_att FROM login_attempts_admin A INNER JOIN admin B ON A.AdminID = B.AdminID WHERE B.Username = ? AND A.Status = 0 AND A.AttemptTime >= NOW() - INTERVAL 10 MINUTE;");
	$checkLockoutQuery->bind_param("s", $username);
	$checkLockoutQuery->execute();
	$checkLockoutQuery->bind_result($failedLogin);
	$checkLockoutQuery->fetch();
	$checkLockoutQuery->close();

	if ($failedLogin >= 3) {
        	echo "Account locked due to too many failed attempts. Please try again later.";
	        exit;
	}

	$stmt = $conn->prepare("SELECT AdminID, AdminName, AdminEmail, Password FROM admin WHERE Username = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$stmt->bind_result($AdminID, $AdminName, $AdminEmail, $storedPassword);
	$stmt->fetch();
	$stmt->close();

	if ($storedPassword) {
        	$salt = substr($storedPassword, 0, 64);
	        $storedHash = substr($storedPassword, 64);
	        $hashedPassword = hash('sha512', $salt . $password);

		$status = ($hashedPassword === $storedHash) ? 1 : 0;
		$logAttemptQuery = $conn->prepare("INSERT INTO login_attempts_admin(AdminID, Status) VALUES (?, ?)");
		$logAttemptQuery->bind_param("ii", $AdminID, $status);
		$logAttemptQuery->execute();
		$logAttemptQuery->close();

		if ($hashedPassword === $storedHash) {
			echo "Login successful. Welcome, $username!";
			$_SESSION['AdminID'] = $AdminID;
			$_SESSION['AdminName'] = $AdminName;
			$_SESSION['AdminEmail'] = $AdminEmail;
			header("Location: admin");
	        } else {
			echo "Login failed. Incorrect username or password.";
		}
	} else {
		echo "Login failed. User does not exist.";
	}

}

elseif($usertype == 102){			//=====		FOR NODAL LOGIN
	$checkLockoutQuery = $conn->prepare("SELECT COUNT(*) AS login_att FROM login_attempts_user A INNER JOIN users B ON A.UserID = B.UserID WHERE B.Username = ? AND A.Status = 0 AND A.AttemptTime >= NOW() - INTERVAL 10 MINUTE;");
	$checkLockoutQuery->bind_param("s", $username);
	$checkLockoutQuery->execute();
	$checkLockoutQuery->bind_result($failedLogin);
	$checkLockoutQuery->fetch();
	$checkLockoutQuery->close();

	if ($failedLogin >= 3) {
        	echo "Account locked due to too many failed attempts. Please try again later.";
	        exit;
	}

	$stmt = $conn->prepare("SELECT UserID, NodalOfficer, NodalEmail, Password FROM users WHERE Username = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$stmt->bind_result($UserID, $NodalOfficer, $NodalEmail, $storedPassword);
	$stmt->fetch();
	$stmt->close();

	if ($storedPassword) {
        	$salt = substr($storedPassword, 0, 64);
	        $storedHash = substr($storedPassword, 64);
	        $hashedPassword = hash('sha512', $salt . $password);

		$status = ($hashedPassword === $storedHash) ? 1 : 0;
		$logAttemptQuery = $conn->prepare("INSERT INTO login_attempts_user(UserID, Status) VALUES (?, ?)");
		$logAttemptQuery->bind_param("ii", $UserID, $status);
		$logAttemptQuery->execute();
		$logAttemptQuery->close();

		if ($hashedPassword === $storedHash) {
			echo "Login successful. Welcome, $username!";
			$_SESSION['UserID'] = $UserID;
			$_SESSION['NodalOfficer'] = $NodalOfficer;
			$_SESSION['NodalEmail'] = $NodalEmail;
			header("Location: nodal");
	        } else {
			echo "Login failed. Incorrect username or password.";
		}
	} else {
		echo "Login failed. User does not exist.";
	}
}
else{
	echo "Invalid login.";		//=====		IF NOT MATCH ADMIN OR NODAL
}

}		//=====		END OF SUBMIT
?>



    <section class="py-4">

	<section class="container d-flex flex-column">
		<div class="row align-items-center justify-content-center g-0 py-8">
			<div class="col-lg-5 col-md-8">
				<div class="card shadow ">
					<div class="card-body p-6">
						<div class="mb-4"><h1 class="mb-1 fw-bold">Sign in</h1></div>
						<form method="post" autocomplete="off">
							<div class="mb-3">
								<label for="usertype" class="form-label">User Type</label>
								<select id="usertype" class="form-control form-select" name="usertype" required>
									<option value="" hidden>-- Select User --</option>
									<option value="101">Admin</option>
									<option value="102">Nodal</option>
								</select>
							</div>

							<div class="mb-3">
								<label for="username" class="form-label">Username</label>
								<input type="text" id="username" class="form-control" name="username" placeholder="Username" oninput="userUpper(this)" required>
							</div>
							<div class="mb-3">
								<label for="password" class="form-label">Password</label>
								<input type="password" id="password" class="form-control" name="password" placeholder="**************" required />
							</div>
							<div>
								<div class="d-grid">
									<button type="submit" class="btn btn-primary ">Sign in</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

</section>



<script>
  function userUpper(input) {
    input.value = input.value.toUpperCase();
  }
</script>


<?php	include "__footer.php";		?>
