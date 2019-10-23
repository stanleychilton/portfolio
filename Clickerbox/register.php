<?php
//<!--SELECT COUNT(post_id) FROM anon_comments WHERE post_id = 22 -->
require 'connect.php';
$conn    = Connect();
include('session.php');
$msg = "";
$pagenum = 2;
$mobile = 0;
use PHPMailer\PHPMailer\PHPMailer;
require "PHPMailer/PHPMailer.php";
require "PHPMailer/Exception.php";

if(isset($login_session)){
    header('Location: /index.php');
}

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
	$mobile=1;
}

if (isset($_POST['submit'])) {
// Call the function post_captcha
	include('googleapi.php');
	$res = post_captcha($_POST['g-recaptcha-response']);

    if (!$res['success']) {
        // What happens when the CAPTCHA wasn't checked
        $msg = '<p>Please make sure you check the security CAPTCHA box.</p><br>';
    } else {
        $ip = getenv('HTTP_CLIENT_IP')?:
                getenv('HTTP_X_FORWARDED_FOR')?:
                getenv('HTTP_X_FORWARDED')?:
                getenv('HTTP_FORWARDED_FOR')?:
                getenv('HTTP_FORWARDED')?:
                getenv('REMOTE_ADDR');
        $f_name    = ucfirst(htmlentities($conn->real_escape_string($_POST['f_name'])));
        $l_name   = ucfirst(htmlentities($conn->real_escape_string($_POST['l_name'])));
        $u_name   = ucfirst(htmlentities($conn->real_escape_string($_POST['u_name'])));
        $email   = $conn->real_escape_string($_POST['email']);
        $month   = $conn->real_escape_string($_POST['month']);
        $day   = $conn->real_escape_string($_POST['day']);
        $year   = $conn->real_escape_string($_POST['year']);
        $gender   = $conn->real_escape_string($_POST['gender']);
        $pass   = crypt($conn->real_escape_string($_POST['pass']), '$6$rounds=5000$_______$');
		$pass = crypt($pass, '$6$rounds=5000$______$');
        $c_pass   = crypt($conn->real_escape_string($_POST['con_pass']), '$6$rounds=5000$_______$');
		$c_pass = crypt($c_pass, '$6$rounds=5000$______$');
        $hash = md5( rand(0,1000) );
        $creation    = time();
        $birthdaystr = $year . "-" . $month . "-" . $day;
        $full_name = $f_name." ".$l_name;
        if ($f_name == "" || $email == "" || $pass != $c_pass)    // needs to have other fields added
            $msg = "Please check your inputs!";
        else {
        if(mysqli_num_rows($conn->query("SELECT Email FROM users WHERE Email = '$email' OR Username = '$u_name'")) == 0 && $pass == $c_pass){
            if(mysqli_num_rows($conn->query("SELECT Email FROM users_unverified WHERE Email = '$email' OR Username = '$u_name'")) == 0){
            $query   = "INSERT into users_unverified (firstname,lastname,username,email,DOB,home_ip,creation_time,Gender,password, hash) VALUES(
            '" . $f_name . "',
            '" . $l_name . "',
            '" . $u_name . "',
            '" . $email . "',
            '" . $birthdaystr ."',
            '" . $ip . "',
            '" . $creation . "',
            '" . $gender . "',
            '" . $pass . "',
            '" . $hash . "')";
            $success = $conn->query($query);
            if (!$success) {
                die("Couldn't enter data: ".$conn->error);
                
            }
            try {
                $mail = new PHPMailer();
                $mail->setFrom("hello@clickerbox.com", "Clickerbox Subscription");
                $mail->addAddress($email, ucfirst($full_name));
                $mail->addReplyTo('support@clickerbox.com', 'Support');
                $mail->isHTML(true);
                $mail->Subject = "Please verify email!";
                $mail->Body    = "Please click on the link below:<br><br><a href='http://www.clicker-box.com/clickerbox/confirm.php?email=$email&hash=$hash'>Click Here</a>";
                if ($mail->send())
                    $msg = "You have been registered! Please verify your email!";
                else
                    $msg = "Something wrong happened! Please try again!";
            }
            catch (phpmailerException $e) {
                echo $e->errorMessage(); //error messages from PHPMailer
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }
        }else{
            $msg = "error";
        }
        }else{
            echo "error";
        }
        
        }
    }
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
        <title>Register</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!--<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-grid.css">
		<link rel="stylesheet" href="css/bootstrap-grid.min.css">
		<link rel="stylesheet" href="css/bootstrap-reboot.css">
		<link rel="stylesheet" href="css/bootstrap-reboot.min.css">-->
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/homepage.css"> 
		<link rel="stylesheet" href="css/postspage.css"> 
		<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
		<script  src="javascript/scripts.js"></script>
		<script type="text/javascript">
		  function call(){
		 var kcyear = document.getElementsByName("year")[0],
		  kcmonth = document.getElementsByName("month")[0],
		  kcday = document.getElementsByName("day")[0];
			   
		 var d = new Date();
		 var n = d.getFullYear();
		 for (var i = n; i >= 1950; i--) {
		  var opt = new Option();
		  opt.value = opt.text = i;
		  kcyear.add(opt);
			}
		 kcyear.addEventListener("change", validate_date);
		 kcmonth.addEventListener("change", validate_date);

		 function validate_date() {
		 var y = +kcyear.value, m = kcmonth.value, d = kcday.value;
		 if (m === "2")
			 var mlength = 28 + (!(y & 3) && ((y % 100) !== 0 || !(y & 15)));
		 else var mlength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m - 1];
		 kcday.length = 0;
		 for (var i = 1; i <= mlength; i++) {
			 var opt = new Option();
			 opt.value = opt.text = i;
			 if (i == d) opt.selected = true;
			 kcday.add(opt);
		 }
			 }
			validate_date();
		  }
		 </script>
    </head>
    <body style = 'padding-right: 0px;'>
		
        <div id="mainfield">
			<div id='nav_bar'>
				<?php
				include('menu.php')
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
                <div class="col-md-6 col-md-offset-0 results" style = 'padding-right: 0px;'>
					<br>
					<form id='chardiv' action="" method="post">
					Firstname: <input type="text" name="f_name" required><br><br>
					Lastname: <input type="text" name="l_name" required><br><br>
					Username: <input type="text" name="u_name" required><br><br>
					Email: <input type="email" name="email" required><br><br>


					<p>Date of birth:</p>
					Month <select name="month" onchange="call()" required>
					<option value="na">Month</option>
					<option value="01">January</option>
					<option value="02">February</option>
					<option value="03">March</option>
					<option value="04">April</option>
					<option value="05">May</option>
					<option value="06">June</option>
					<option value="07">July</option>
					<option value="08">August</option>
					<option value="09">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">December</option>
					</select>
								
					Day <select name="day" required>
							   <option value="">select</option>
							  </select>
							  
					Year <select name="year" onchange="call()" required>
							   <option value="">select</option>
							  </select>
					<br><br>

					<p>Gender</p>
					<input type="radio" name="gender" value="male" > Male<br>
					<input type="radio" name="gender" value="female"> Female<br>
					<input type="radio" name="gender" value="other" required> Other  

					<br><br>
					Password: <input type="password" name="pass" required><br><br>
					Confirm password: <input type="password" name="con_pass" required><br><br>
					 I accept the <a href='/clickerbox/privacypolicy.php' target="_blank">terms and conditions</a>: <input type="checkbox" name="terms" value="terms" required><br><br>
					<div class="g-recaptcha" name="g-recaptcha" data-sitekey="6LcMb0IUAAAAAFo3Fy2UVgmEtKh1vq51P5w22bWo"></div><br>
					<input type="submit" name="submit" value="Submit">
					</form>
					<div style = "chardiv"><?php echo $msg; ?></div>


                </div>
				<?php
				if ($mobile == 0){
				?>
				<div class="col-md-3 col-md-offset">
					<?php
						include('sidebar_right.php');
					?>
				</div>
				</div>
				<?php
				}
				?>
            
			<br>
			<?php
			include('footer.php')
			?>
			</div>
    </body>
</html>