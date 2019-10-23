<?php
require 'connect.php';
$conn    = Connect();
include('session.php');


if (isset($_POST['sid'])){
	$sid = $_POST['sid'];
}
if(!isset($sid)){
	$sid = $_GET['sid'];
	if(!isset($sid)){
		header("location: index.php");
	}
}

?>
<!DOCTYPE html>
<html lang="en" style = 'padding-right: 0px;'>
    <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
		<link rel="stylesheet" href="css/index.css"> 
    </head>
    <body style = 'padding-right: 0px;'>
		
        <div id="mainfield">
            <div class="row" style="margin-right:0px;margin-left:0px">
			
				<div id='sides' class="col-md-3">
				
				</div>
                <div id='main' class="col-md-6 col-md-offset-0" style = 'padding-right: 0px;padding-left: 0px;'>
				<?php
					$sql = "SELECT student_id, selected FROM students WHERE student_id='$sid'";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
					
					if(isset($row)){
						if($row['selected'] == 0){
				?>
					<div class="contain">
					<p>student ID: <?php echo $sid; ?>
					<br>
						<?php
						$sql = "SELECT id, active FROM instances WHERE active != 1";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								echo"<div class='row round3'><div id='sides' class='col-md-6'>";
								echo"instance-".$row['id']."</div>";
								echo"<div id='sides' class='col-md-6'>";
								echo"<a href='selection.php?id=".$row['id']."&sid=".$sid."' class='button' style='text-decoration:none;'>Select</a>";
								echo"</div></div><br>";
							}
						}

						?>
					</div>
				<?php
						}else{
	
							$sql = "SELECT first_name, last_name FROM students WHERE student_id='$sid'";
							$result = mysqli_query($conn,$sql);
							$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

							$name = $row['first_name'] . " " . $row['last_name'];
							
							$sql = "SELECT instance_url, instance_id FROM instances WHERE selected_by='$name'";
							$result = mysqli_query($conn,$sql);
							$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
							
							echo "<p>".$row['instance_url']."</p>";
						
							$msg = exec("python specificstatus.py ". $row['instance_id']);
							
							echo "<a href = 'register.php'>Chatroom</a>";
							
							echo $msg;
							
						}
					}else{
				?>
				<p>student ID: <?php echo $sid; ?>
				<p>You are not enrolled in this paper<br>
				or this is not the email you enrolled with</p>
					
					
				<?php
					}
				?>
			
				
				
                </div>
				
				<div id='sides' class="col-md-3 col-md-offset" style="overflow:hidden;">
				
				
				</div>
			</div>
    
	
		</div>
    </body>
</html>
