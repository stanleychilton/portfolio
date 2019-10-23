<?php
require 'connect.php';
$conn    = Connect();

$url = htmlspecialchars($_GET["url"]);
$id = htmlspecialchars($_GET["id"]);


$sql = "INSERT INTO instances (instance_id, instance_url)
VALUES ('$id', '$url')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>