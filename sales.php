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
	<title>Sales</title>
</head>
<body>

<h1>SALES PAGE</h1>

<a href="index.php">BACK TO HOME PAGE</a>

</body>
</html>