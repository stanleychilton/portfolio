<?php
require 'connect.php';
$conn    = Connect();

?>
<!DOCTYPE html>
<html lang="en" style = 'padding-right: 0px;'>
    <head>
	<style>
	table {
	  font-family: arial, sans-serif;
	  border-collapse: collapse;
	  width: 100%;
	}

	td, th {
	  border: 1px solid #dddddd;
	  text-align: left;
	  padding: 8px;
	}

	tr:nth-child(even) {
	  background-color: #dddddd;
	}
	</style>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        <!-- Latest compiled and minified CSS -->
    </head>
    <body style = 'padding-right: 0px;'>
        <div id="mainfield">

					

					<div id="anon" class="tabcontent">
						<table id='maintable'>
							
							<?php
							$sql = "SELECT * FROM current_stocks ORDER BY Price";
							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
								
									echo "<div id='chardiv' id='texteditb'><h3>Current stock market Data:</h3></div>";
									$topics = $conn->query("SELECT COUNT(id) FROM all_stocks");
									$topic_result = mysqli_fetch_array($topics);
									echo "" . $topic_result[0] . "<br> <br>";
									$topics = $conn->query("SELECT COUNT(id) FROM current_stocks");
									$topic_result = mysqli_fetch_array($topics);
									echo "" . $topic_result[0] . "<br> <br><table>";
									// output data of each row
									echo "  <tr><th>ID</th><th>Symbol</th><th>Date</th><th>Time</th><th>Price</th><th>Ask</th><th>Range Value</th><th>Volume</th><th>Volume Average</th><th>Previous Close</th><th>High</th><th>Low</th></tr>";
									while($row = $result->fetch_assoc()) {
											$topics = $conn->query("SELECT COUNT(id) FROM all_stocks");
											$topic_result = mysqli_fetch_array($topics);
											echo "<tr><td>".$row['ID']."</td><td>" . $row['symbol'] . "</td><td>" . $row['date'] . "</td><td>" . $row['time'] . "</td><td>" . $row['price'] . "</td><td>" . $row['ask'] . "</td><td>" . $row['range_val'] . "</td><td>" . $row['vol'] . "</td><td>" . $row['vol_avg'] . "</td><td>";
											echo "" . $row['previous_close'] . "</td><td>" . $row['high'] . "</td><td>" . $row['low'] . "</td></tr>";
							}
							echo "</table>";
							}
						?>
					</div>

    </body>
</html>