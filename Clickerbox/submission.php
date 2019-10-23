<?php
require 'connect.php';
$conn    = Connect();
include('session.php');
include('googleapi.php');
$res = post_captcha($_POST['g-recaptcha-response']);

if (!$res['success']) {
	
	// What happens when the CAPTCHA wasn't checked
	echo '<p>Please go back and make sure you check the security CAPTCHA box.</p><br>';
} else {
	$ip = getenv('HTTP_CLIENT_IP')?:
			getenv('HTTP_X_FORWARDED_FOR')?:
			getenv('HTTP_X_FORWARDED')?:
			getenv('HTTP_FORWARDED_FOR')?:
			getenv('HTTP_FORWARDED')?:
			getenv('REMOTE_ADDR');
            
    $email_check = "SELECT Email FROM users WHERE Username = '$login_session'";
    $cur = $conn->query($email_check);
    $email = $cur->fetch_assoc()['Email'];
	$name = $login_session;
	$time = time();
    
	$suggestion   = htmlentities($conn->real_escape_string($_POST['suggestion']));
	$query   = "INSERT into suggestions (name,time,suggestion,email,ip) VALUES('" . $name . "','" . $time . "','" . $suggestion . "','" . $email . "','" . $ip . "')";
	$success = $conn->query($query);
	if (!$success) {
		die("Couldn't enter data: ".$conn->error);
	}
	$conn->close();
	header('Location: /index.php');
}
?>