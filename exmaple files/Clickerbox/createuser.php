<?php

function post_captcha($user_response) {
	$fields_string = '';
	$fields = array(
		'secret' => '6LcMb0IUAAAAACd6ijPTbOAUR3m1fZEujAfsR8lA',
		'response' => $user_response
	);
	foreach($fields as $key=>$value)
	$fields_string .= $key . '=' . $value . '&';
	$fields_string = rtrim($fields_string, '&');

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
	curl_setopt($ch, CURLOPT_POST, count($fields));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

	$result = curl_exec($ch);
	curl_close($ch);

	return json_decode($result, true);
}

// Call the function post_captcha
$res = post_captcha($_POST['g-recaptcha-response']);

if (!$res['success']) {
	// What happens when the CAPTCHA wasn't checked
	echo '<p>Please go back and make sure you check the security CAPTCHA box.</p><br>';
} else {
	require 'connect.php';
	$conn    = Connect();
	$ip = getenv('HTTP_CLIENT_IP')?:
			getenv('HTTP_X_FORWARDED_FOR')?:
			getenv('HTTP_X_FORWARDED')?:
			getenv('HTTP_FORWARDED_FOR')?:
			getenv('HTTP_FORWARDED')?:
			getenv('REMOTE_ADDR');
	$id = (int)$_POST['id']; 
	$f_name    = $conn->real_escape_string($_POST['f_name']);
	$l_name   = $conn->real_escape_string($_POST['l_name']);
	$u_name   = $conn->real_escape_string($_POST['u_name']);
	$email   = $conn->real_escape_string($_POST['email']);
	$pass   = $conn->real_escape_string($_POST['pass']);
	$c_pass   = $conn->real_escape_string($_POST['con_pass']);
	$date    = time();
	$query   = "INSERT into users (firstname,lastname,username,email,home_ip,creation_time,pass) VALUES('" . $f_name . "','" . $l_name . "','" . $u_name . "','" . $email . "','" . $ip . "','" . $date . "','" . $pass . "')";
	$success = $conn->query($query);
	if (!$success) {
		die("Couldn't enter data: ".$conn->error);
	}
	$conn->close();
	header('Location: /clickerbox/category.php?id='.$id);
}
?>