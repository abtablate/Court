<?php
session_start();

if (!isset($_SESSION['admin'])) {
	header("Location: login.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
</head>
<body>

<h1>DASHBOARD PAGE</h1>

<a href="index.php">BACK TO HOME PAGE</a>

</body>
</html>