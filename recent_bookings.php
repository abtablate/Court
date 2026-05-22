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
	<title>Recent Bookings</title>
</head>
<body>

<h1>RECENT BOOKINGS PAGE</h1>

<a href="index.php">BACK TO HOME PAGE</a>

</body>
</html>