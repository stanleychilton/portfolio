<?php
require 'connect.php';
$conn    = Connect();
include('session.php');
$msg = "";
$par = "";
$par2 = "";
   
   if(!isset($login_session)){
	   header("location: login.php");
   }
   
   if (isset($_POST['get_details'])) {
		if($_POST['start'] != null){
			$par = $_POST['start'];
		}
		if($_POST['end'] != null){
			$par2 = $_POST['end'];
		}
		$msg = exec("python costlist.py $par $par2");
	}
?>
<?php
	if (isset($_POST['update']))
{	
    $msg = exec('python prediction.py ');
}
?>
<?php
	if (isset($_POST['update1']))
{	
    $msg = exec('python state.py ');
}
?>
<html>
	<head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
		<link rel="stylesheet" href="css/index.css"> 
    </head>
	<body style = 'padding-right: 0px;'>
			
		<div id="mainfield">
		
		
		
		<ul>
		  <li><a href="monitoring.php">Monitoring</a></li>
		  <li><a href="register.php">Chat</a></li>
		  <li style="float:right"><a class="active" href="logout1.php">logout</a></li>
		</ul>
		
		
		
			<div class="row" style="margin-right:0px;margin-left:0px">
			
				<div id='sides' class="col-md-3">
				
				</div>
				<div id='main' class="col-md-6 col-md-offset-0" style = 'padding-right: 0px;padding-left: 0px;'>
					<div class="contain">
						<form id='chardiv' action="" method="post" enctype="multipart/form-data">
							<input type="date" id="start" name="start">
							<input type="date" id="end" name="end">
							<input type="submit" name="get_details" value="get costs">
						</form>
						<form name="update" method="post" >
							<button name = "update" type="submit"> Predict Cost next month </button>
						</form>
						<form name="update" method="post" >
							<button name = "update1" type="submit"> Status Update </button>
						</form>
						<?php
							echo '<p>' . $msg . '</p>';
						?>
					</div>
				
				
				</div>
				
				<div id='sides' class="col-md-3 col-md-offset" style="overflow:hidden;">
				
				
				</div>
			</div>


		</div>
	</body>
</html>
