<?php
require 'connect.php';
$conn    = Connect();
include('session.php');
$mobile=0;
$pagenum = 10;
$foo = $login_session;
$msg = "";

$target_dir = "user_images/profile/";

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
	$mobile=1;
}

$sql = "SELECT Firstname, Lastname, Username, DOB, Email, Creation_time, Gender, Image, Password FROM users WHERE username = '$login_session'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$count = mysqli_num_rows($result);

if($count != 1) {
	header("location: 404.php");
	}

$Firstname = $row['Firstname'];
$Lastname = $row['Lastname'];
$Username = $row['Username'];
$newEmail = $row['Email'];
$newDate = $row['DOB'];
$newGender = $row['Gender'];
$password = $row['Password'];

/*if(isset($login_session)){
    echo "you logged in as: </br>", $login_session;
    $rank_check = "SELECT Rank FROM users WHERE Username = '$login_session'";
    $cur = $conn->query($rank_check);
    $curr = $cur->fetch_assoc()['Rank'];
    if($curr >= 2){
        $accounts = $conn->query("SELECT COUNT(id) FROM users");
        $results = mysqli_fetch_array($accounts);
        echo "<div id='chardiv'>Current registered accounts: " . $results[0] . "</div>";
    }
}*/
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['picture_update'])) {
	if(file_exists($_FILES['attachment']['tmp_name']) || is_uploaded_file($_FILES['attachment']['tmp_name'])){
				$uniquesavename=time().uniqid(rand());
				$destFile = $target_dir . "Clickerbox_" . $uniquesavename . "." . pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
			
				$extension = pathinfo($destFile, PATHINFO_EXTENSION);
				if ($_FILES['attachment']['size'] > 50000000){
					$msg = "Your file is too big!";
				}else if ($extension != "png" && $extension != "jpg" && $extension != "jpeg" && $extension != "gif"){
					$msg = "Only the image files are allowed!";
				}else if (file_exists($destFile)){
					$msg = "File with this name already exists!";
				}else if(move_uploaded_file($_FILES["attachment"]["tmp_name"],  $destFile)){
					$msg = "File Uploaded!";
					$query   = "UPDATE users SET image = '$destFile' WHERE Username = '$login_session'";
					$success = $conn->query($query);
					if (!$success) {
						die("Couldn't enter data: ".$conn->error);
					}
					$ip = getenv('HTTP_CLIENT_IP')?:
					getenv('HTTP_X_FORWARDED_FOR')?:
					getenv('HTTP_X_FORWARDED')?:
					getenv('HTTP_FORWARDED_FOR')?:
					getenv('HTTP_FORWARDED')?:
					getenv('REMOTE_ADDR');
					$name    = $login_session;
					$date    = time();
					$query1   = "INSERT into post (cat_id,Mod_name,Date,image,ip) VALUES('-1','" . $name . "','" . $date . "','" . $destFile . "','" . $ip . "')";
					$success1 = $conn->query($query1);
				if (!$success1) {
					die("Couldn't enter data: ".$conn->error);
				}
					header("location: settings.php");
				}
				

	}
}

if (isset($_POST['update_details'])) {
        $f_name    = htmlentities($conn->real_escape_string($_POST['f_name']));
        $l_name   = htmlentities($conn->real_escape_string($_POST['l_name']));
        $u_name   = htmlentities($conn->real_escape_string($_POST['u_name']));
        $email   = $conn->real_escape_string($_POST['email']);
        $dateofbirth   = $conn->real_escape_string($_POST['DOB']);
        $gender   = $conn->real_escape_string($_POST['gender']);
        $pass   = crypt($conn->real_escape_string($_POST['pass']), '$6$rounds=5000$brownfoxesgalore$');
		$pass = crypt($pass, '$6$rounds=5000$lEJdJd1W1eqVrLU6$');
        $full_name = $f_name." ".$l_name;
		$hash = md5( rand(0,1000) );
		if($pass == $password){

			if($email != $newEmail){
				try {
					$mail = new PHPMailer();
					$mail->setFrom("hello@clickerbox.com", "Clickerbox email verification");
					$mail->addAddress($email, ucfirst($full_name));
					$mail->addReplyTo('support@clickerbox.com', 'Support');
					$mail->isHTML(true);
					$mail->Subject = "Please verify email!";
					$mail->Body    = "Please click on the link below:<br><br><a href='http://www.clicker-box.com/clickerbox/confirmupdate.php?email=$email&hash=$hash'>Click Here</a>";
					if ($mail->send()){
						$msg = "You have been registered! Please verify your email!";
					}else{
						$msg = "Something wrong happened! Please try again!";
					}
				}
			
            catch (phpmailerException $e) {
                echo $e->errorMessage(); //error messages from PHPMailer
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }
			}
			$query   = "UPDATE users SET firstname='$f_name',lastname='$l_name',username='$u_name',email='$email',DOB='$dateofbirth',Gender='$gender',new_email_hash='$hash' WHERE username = '$login_session' and password = '$pass'";
            $success = $conn->query($query);
            if (!$success) {
                die("Couldn't enter data: ".$conn->error);  
            }
		}else{
			$msg = "Please input the correct password";
		}
		header("location: settings.php");
}


if (isset($_POST['delete_account'])) {
	$pass   = crypt($conn->real_escape_string($_POST['pass']), '$6$rounds=5000$brownfoxesgalore$');
	$pass = crypt($pass, '$6$rounds=5000$lEJdJd1W1eqVrLU6$');
	$sql = "DELETE FROM users WHERE Username='$login_session' AND Password = '$pass'";
	$success = $conn->query($sql);
	header("location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en" style = 'padding-right: 0px;'>
    <head>
		<?php
			include("analytics.php");
		?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $foo . " - settings"; ?></title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
		<link rel="stylesheet" href="css/index.css"> 
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/homepage.css"> 
		<link rel="stylesheet" href="css/profile.css"> 
		
		<script  src="javascript/scripts.js"></script>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
		<script  src="javascript/scripts.js"></script>
    </head>
    <body style = 'padding-right: 0px;'>
		
        <div id="mainfield">
			<div id='nav_bar'>
				<?php
				include('menu.php');
				?>
			</div>
			<?php
			if ($mobile == 0){
			?>
			
            <div class="row" style="margin-right:0px;margin-left:0px">
			
				<div class="col-md-3">
					<?php
						include('sidebar_left.php');
					?>
				</div>
				<?php
				}
				?>
                <div class="col-md-6 col-md-offset-0" style = 'padding-right: 0px;padding-left: 0px;'>
				<button class='button1' onclick="window.location.href = 'profile.php?id=<?php echo $login_session ?>';">
				<div class="row">
					<div class="col-md-12">
						<h5>Back to profile</h5>
					</div>
				</div>
				</button>
				<br>
				<h3 style="padding:10px;">Update settings</h3>
				<h4 style="padding:10px;">Profile picture</h4>
						<form id='chardiv' action="" method="post" enctype="multipart/form-data">
							<input type="file" name="attachment" accept="image/*"><br><br>
							<input type="submit" name="picture_update" value="update profile picture">
						</form>
					
				<hr class="new5"><h4 style="padding:10px;">Details</h4>
						<form id='chardiv' action="" method="post">
						Firstname: <input type="text" name="f_name" value="<?php echo $Firstname; ?>" required><br><br>
						Lastname: <input type="text" name="l_name" value="<?php echo $Lastname; ?>" required><br><br>
						Username: <input type="text" name="u_name" value="<?php echo $Username; ?>" required><br><br>
						Email: <input type="email" name="email" value="<?php echo $newEmail; ?>" required><br><br>


						<p>Date of birth: <input type="date" name="DOB" value="<?php echo $newDate; ?>" required></p>
						
						<br><br>

						<p>Gender</p>
						<input type="radio" name="gender" value="male" <?php if($newGender == 'male'){echo "checked";} ?>> Male<br>
						<input type="radio" name="gender" value="female" <?php if($newGender == 'female'){echo "checked";} ?>> Female<br>
						<input type="radio" name="gender" value="other" <?php if($newGender == 'other'){echo "checked";} ?> required> Other  

						<br><br>
						Password: <input type="password" name="pass" required><br><br>
						<input type="submit" name="update_details" value="Save settings">
						</form>
					
				<hr class="new5">
					<h4 style="padding:10px;">Privacy settings</h4>
						<h6 id="chardiv">Coming soon</h6>
					
				<hr class="new5">
				
					<h4 style="padding:10px;">Delete profile</h4>
						<form id='chardiv' action="" method="post">
							Password: <input type="password" name="pass" required><br><br>
							<input type="submit" name="delete_account" value="Delete">
						</form>
				<br><br>
                </div>
				<?php
				if ($mobile == 0){
				?>
				<div class="col-md-3 col-md-offset" style="overflow:hidden;">
					<?php
					
					$conn->close();

					include('sidebar_right.php');
					?>
				</div>
				</div>
            
			
			
			<?php
			}
			include('footer.php');
			?>
			</div>

    </body>
</html>