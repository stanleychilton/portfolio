<?php
require 'connect.php';
$conn    = Connect();

$sid = $_GET['sid'];
$id = $_GET['id'];


echo $sid . $id;

$sql = "UPDATE students SET selected=1 WHERE student_id='$sid'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$sql = "SELECT first_name, last_name FROM students WHERE student_id='$sid'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$name = $row['first_name'] . " " . $row['last_name'];

$sql = "UPDATE instances SET active=1, selected_by='$name' WHERE id=$id";


if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

header('Location: /selectionsite/select.php?sid='.$sid);
?>