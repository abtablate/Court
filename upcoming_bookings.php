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
	<title>Upcoming Bookings</title>
</head>
<body>

<h1>UPCOMING BOOKINGS PAGE</h1>

<a href="index.php">BACK TO DASHBOARD</a>

</body>
</html>