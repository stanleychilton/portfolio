<?php
require 'connect.php';
$conn = Connect();

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT ID, Name, website, discription, phone FROM company WHERE flag = 1 ORDER BY id DESC";
$result = $conn->query($sql);
// $query =  mysql_query("SELECT * FROM company");
?>
<html>
	<head>
		<!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	 	<link rel="stylesheet" type="text/css" href="style.css">

		<!-- <link rel="stylesheet" type="text/css" href="ListingStyleSheet.css"> -->
		<title>Listings</title>
	</head>
	<body>
		<div id="site">
			</section id="nav-bar">
				<?php include ('Navbar.php');?>
			</section>
			
			</section id="side-bar">
				<?php include ('Sidebar.php');?>
			</section>
			
			<section id="page" style="min-height: 10px;">
			  <div id="page-content">
			
			    <section class="companyListing" id="content"><div></div>
			    	<h2 class="companies">Technology in Palmy:  Companies</h2> <!-- #Header -->
			    	<div class='spacer1'></div>
			    	<?php	
						// echo "<table border='1\'><tr><th>Name</th><th>Website</th></tr>";
						while($row = $result->fetch_assoc()) {
							echo "<div class='card'>".
							"<h3>Company Name: " . $row["Name"] . "</h3><br>".
							"<p>Website: " . "<a href=" . $row["website"]. ">" . $row["Name"] . "</a><br>".
							"Description: " . $row["discription"] . "<br>".
							"Phone: " . $row["phone"] . "</p>";

							// echo </div>";
							// echo "<tr><td>";
						    // echo $row["Name"];
						    // echo "</td><td>";
						    // echo $row["website"];
						    // echo "</td></tr>";
						// echo "</table>";
						}
					?>
			    </section>						
			  </div><!-- END OF #PAGE-CONTENT -->			
			</section>
		</div>
 	</body>
</html>


<?php
$conn->close();
?>