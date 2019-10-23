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
	$comment   = $conn->real_escape_string($_POST['topic']);
	$date    = time();
	$query   = "INSERT into anon_comments (post_id,Date,comment,ip) VALUES('" . $id . "','" . $date . "','" . $comment . "','" . $ip . "')";
	$success = $conn->query($query);

	if (!$success) {
		die("Couldn't enter data: ".$conn->error);
	}
	$conn->close();
	header('Location: /clickerbox/post.php?id='.$id);
}
?>