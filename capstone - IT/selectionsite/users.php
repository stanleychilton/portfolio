<?php
require 'connect.php';
$conn    = Connect();

$student_id = htmlspecialchars($_GET["sid"]);
$firstname = htmlspecialchars($_GET["firstname"]);
$lastname = htmlspecialchars($_GET["lastname"]);
$email = htmlspecialchars($_GET["email"]);

$sql = "INSERT INTO students (student_id, first_name, last_name, email)
VALUES ('$student_id', '$firstname', '$lastname', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>