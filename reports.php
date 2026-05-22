<?php
require 'db_connect.php';

/* TOTAL REVENUE */

$revenue_query = $conn->query("
    SELECT SUM(revenue) AS total_revenue
    FROM reservations
");

$revenue_data = $revenue_query->fetch_assoc();
$total_revenue = $revenue_data['total_revenue'] ?? 0;

/* DAILY REVENUE */

$daily_query = $conn->query("
    SELECT 
        date,
        SUM(revenue) AS daily_total
    FROM reservations
    GROUP BY date
    ORDER BY date DESC
    LIMIT 7
");

$daily_revenues = [];

while($row = $daily_query->fetch_assoc()){

    $daily_revenues[] = $row;

}

/* TOTAL DEBTS */

$debt_query = $conn->query("
    SELECT SUM(amount) AS total_debt
    FROM debts
");

$debt_data = $debt_query->fetch_assoc();
$total_debt = $debt_data['total_debt'] ?? 0;

/* USER DEBTS */

$user_debts = $conn->query("
    SELECT *
    FROM debts
    ORDER BY debt_date DESC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">

	<meta name="viewport"
		  content="width=device-width, initial-scale=1.0">

	<title>Reports</title>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<style>

		*{
			margin:0;
			padding:0;
			box-sizing:border-box;
			font-family:Arial, sans-serif;
		}

		body{
			background:#f4f6f9;
		}

		/* HEADER */

		.header{
			width:100%;
			background:white;
			padding:15px 30px;
			display:flex;
			justify-content:space-between;
			align-items:center;
			box-shadow:0 2px 10px rgba(0,0,0,0.08);
			position:sticky;
			top:0;
			z-index:1000;
		}

		.title{
			font-size:24px;
			font-weight:bold;
			color:#222;
		}

		.navbar{
			display:flex;
			gap:15px;
			flex-wrap:wrap;
		}

		.nav-link{
			text-decoration:none;
			color:#444;
			padding:10px 15px;
			border-radius:8px;
			transition:0.3s;
			font-size:14px;
		}

		.nav-link:hover{
			background:#111;
			color:white;
		}

		.active{
			background:#111;
			color:white;
		}

		/* MAIN */

		.container{
			padding:30px;
		}

		.page-title{
			font-size:32px;
			margin-bottom:25px;
			color:#222;
		}

		/* CARDS */

		.summary-grid{
			display:grid;
			grid-template-columns:
			repeat(auto-fit,minmax(250px,1fr));
			gap:20px;
			margin-bottom:30px;
		}

		.card{
			background:white;
			padding:25px;
			border-radius:15px;
			box-shadow:0 4px 15px rgba(0,0,0,0.08);
		}

		.card-title{
			font-size:16px;
			color:#777;
			margin-bottom:10px;
		}

		.card-value{
			font-size:32px;
			font-weight:bold;
			color:#111;
		}

		.revenue{
			color:#28a745;
		}

		.debt{
			color:#f44336;
		}

		/* CHART */

		.chart-container{
			margin-top:20px;
		}

		canvas{
			width:100% !important;
			max-height:400px;
		}

		/* TABLE */

		.table-container{
			overflow-x:auto;
			margin-top:30px;
		}

		table{
			width:100%;
			border-collapse:collapse;
		}

		thead{
			background:#111;
			color:white;
		}

		th,
		td{
			padding:15px;
			text-align:left;
			border-bottom:1px solid #eee;
		}

		tbody tr:hover{
			background:#f9f9f9;
		}

		.amount{
			color:#f44336;
			font-weight:bold;
		}

		/* MOBILE */

		@media(max-width:768px){

			.header{
				flex-direction:column;
				align-items:flex-start;
				gap:15px;
			}

			.navbar{
				width:100%;
			}

			.page-title{
				font-size:24px;
			}

		}

	</style>

</head>

<body>


	<div class="header">

		<div class="title">
			Court 7 ADMIN
		</div>

		<nav class="navbar">

			<a href="index.php"
			   class="nav-link">
				Dashboard
			</a>

			<a href="manage_reservation.php"
			   class="nav-link">
				Manage Reservation
			</a>

			<a href="supplies.php"
			   class="nav-link">
				Supplies
			</a>

			<a href="debts.php"
			   class="nav-link">
				Debts
			</a>

			<a href="reports.php"
			   class="nav-link active">
				Reports
			</a>

			<a href="logout.php"
			   class="nav-link">
				Logout
			</a>

		</nav>

	</div>


	<div class="container">

		<h1 class="page-title">
			Reports Dashboard
		</h1>


		<div class="summary-grid">

			<div class="card">

				<div class="card-title">
					Total Revenue
				</div>

				<div class="card-value revenue">
					₱<?php echo number_format($total_revenue,2); ?>
				</div>

			</div>

			<div class="card">

				<div class="card-title">
					Total User Debts
				</div>

				<div class="card-value debt">
					₱<?php echo number_format($total_debt,2); ?>
				</div>

			</div>

		</div>

		<!-- DAILY REVENUE CHART -->

		<div class="card">

			<h2>
				Daily Revenue
			</h2>

			<div class="chart-container">

				<canvas id="reportChart"></canvas>

			</div>

		</div>

		<!-- USER DEBTS -->

		<div class="card table-container">

			<h2 style="margin-bottom:20px;">
				User Debts
			</h2>

			<table>

				<thead>

					<tr>

						<th>Customer Name</th>
						<th>Amount</th>
						<th>Date</th>
						<th>Description</th>

					</tr>

				</thead>

				<tbody>

					<?php while($row = $user_debts->fetch_assoc()) { ?>

					<tr>

						<td>
							<?php echo $row['customer_name']; ?>
						</td>

						<td class="amount">

							₱<?php
							echo number_format(
								$row['amount'],
								2
							);
							?>

						</td>

						<td>
							<?php echo $row['debt_date']; ?>
						</td>

						<td>
							<?php echo $row['description']; ?>
						</td>

					</tr>

					<?php } ?>

				</tbody>

			</table>

		</div>

	</div>

	<script>

		const ctx =
		document.getElementById('reportChart');

		const reportChart =
		new Chart(ctx, {

			type: 'bar',

			data: {

				labels: [

					<?php
					foreach($daily_revenues as $day){

						echo "'" .
						$day['date'] .
						"',";

					}
					?>

				],

				datasets: [{

					label: 'Daily Revenue',

					data: [

						<?php
						foreach($daily_revenues as $day){

							echo $day['daily_total']
							. ",";

						}
						?>

					],

					borderWidth: 1

				}]

			},

			options: {

				responsive: true,

				scales: {

					y: {

						beginAtZero: true

					}

				}

			}

		});

	</script>

</body>
</html>