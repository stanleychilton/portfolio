<?php
$id = $_GET['id'];

require 'connect.php';
$conn    = Connect();
include('session.php');

if(!isset($login_session)){
    header('Location: /clickerbox/login.php');
}else{
    $rank_check = "SELECT Rank FROM users WHERE Username = '$login_session'";
    $cur = $conn->query($rank_check);
    $curr = $cur->fetch_assoc()['Rank'];
    if($curr <= 1){
        echo $curr;
        header('Location: /index.php');
    }else{
        if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }

    // sql to delete a record
    $sql = "DELETE FROM categories WHERE ID = $id"; 

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header('Location: /clickerbox/adder.php'); //If book.php is your main page where you list your all records
        exit;
    } else {
        echo "Error deleting record";
    }
    $conn->close();
    }
}


?>