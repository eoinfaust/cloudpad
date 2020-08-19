<?php 
	include('server.php');
  	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: index.php');
  	}
  	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: index.php");
  	}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<html>
	<head>
		<title>eirpad | My Account</title>
		<link rel="stylesheet" href="eirpad.css?version=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">
		<link rel="manifest" href="/icon/site.webmanifest">
		<link rel="mask-icon" href="/icon/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</head>
	<body>
		<div class="head">
			<div class="clearfix">
				<a href="index.php" ><img class="img" src="icon/eirpadtext.svg" alt="eirpad"></a>
				<div class="headertext">
					<?php  if (isset($_SESSION['username'])) : ?>
						<a><?=$_SESSION['username']?>&ensp;</a>
						<a class="link" href="account.php">my account&ensp;</a>
						<a class="linkbad" href="account.php?logout='1'">logout</a>
					<?php endif ?>
					<?php  if (!isset($_SESSION['username'])) : ?>
						<a class="link" href="signin.php">sign in</a>
						<a class="link" href="register.php">register</a>
					<?php endif ?>
				</div>
			</div>
		</div>
		<div id="deviceaddModal" class="modal">
			<div class="popup">
				<span class="close"><i class="fa fa-times"></i></span>
				<div class="logo"><a>Add a device to your account</a></div>
				<form method="post" id="deviceaddform" align="center">
					<p id=error101 class="reportb">Device ID required</p>
					<p id=error105 class="reportb">Device already registered</p>
					<p id=error106 class="reportb">That device ID doesn't exist</p>
					<div class="input-field">
						<input class="formfill" type="text" name="deviceid" id="deviceid" required>
						<label for="deviceid">Device ID</label>
					</div>
					<p id=error102 class="reportb">Device name required</p>
					<p id=error103 class="reportb">Max device name length is 10</p>
					<p id=error104 class="reportb">Device name already exists</p>
					<div class="input-field">
						<input class="formfill" type="text" name="devicename" id="devicename" required>
						<label for="devicename">Device name</label>
					</div>
					<input type="submit" class="button" name="add_device" id="add_device" value="Add device">
				</form>
			</div>
		</div>
		<div class="mainpage">
			<form method="post" class="custom-select">
				<?php
				$db = mysqli_connect('localhost', 'root', '', 'eirpad');
				$stmt = $db->prepare("SELECT devicename FROM devices WHERE username=? ORDER BY devicename");
				$stmt->bind_param("s", $_SESSION['username']);
				$stmt->execute();
				$result = $stmt -> get_result();
				$stmt->close();
				$init = '0';
				$defaultselect = 'my devices';
				echo "<select id='devicechosen' onselect='getdevname()'>";
				echo "<option value='".$init."'> ".$defaultselect." </option>"; 
				while ($row = mysqli_fetch_array($result)) {
					echo "<option value='" .$row['devicename']."'> ".$row['devicename'] . "&nbsp;</option>"; 
				}
				echo "</select>";
				?>
			</form>
			<a id="deviceaddBtn" class="devicechange">add device&ensp;<i class="fa fa-plus"></i></a>
			<div id="status" class="deviceinfo">
				<a class="devicechange">&ensp;settings&nbsp;<i class="fa fa-cog" aria-hidden="true"></i>&ensp;</a>
				<a class="devicechange">rename&nbsp;<i class="fa fa-edit" aria-hidden="true"></i>&ensp;</a>
				<a class="devicedelete">delete&nbsp;<i class="fa fa-ban" aria-hidden="true"></i></a>
			</div>
			<p class="footer" align="center">
			<?php  if (!isset($_SESSION['username'])) : ?>
				<a class="small link" href="signin.php"><i class="fa fa-sign-in"></i> sign in</a>
				<a>&nbsp;|&nbsp;</a>
				<a class="small link" href="register.php"><i class="fa fa-file-signature"></i> register&ensp;</a>
			<?php endif ?>
			<a class="small link" href="index.php"><i class="fa fa-home"></i> home&ensp;</a>
			<a class="small link" href="support.php"><i class="fa fa-question"></i> support&ensp;</a>
			<?php  if (isset($_SESSION['username'])) : ?>
				<a class="small linkbad" href="account.php?logout='1'"><i class="fa fa-sign-out"></i> logout&ensp;</a>
			<?php endif ?>
			<a class="small">&ensp;&copy; 2020 eirpad</a></p>
		</div>
		<script src="js/dropdown.js"></script>
		<script src="js/deviceadd.js"></script>
	</body>
</html>