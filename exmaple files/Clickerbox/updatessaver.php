<?php
require 'connect.php';
$conn    = Connect();
$name    = $conn->real_escape_string($_POST['name']);
$message   = $conn->real_escape_string($_POST['message']);
$time    = time();
$query   = "INSERT into updates (name,time,message) VALUES('" . $name . "','" . $time . "','" . $message . "')";
$success = $conn->query($query);

if (!$success) {
    die("Couldn't enter data: ".$conn->error);
}
$conn->close();
header('Location: /clickerbox/updates.php');
?>