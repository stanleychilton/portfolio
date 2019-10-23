<?php
function Connect()
{
    $servername = "localhost";
    $username = "Techpalmy";
    $password = "eJgWk0xez4PONbGM";
    $dbname = "techpalmy";


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname) or die($conn->connect_error);
 
    return $conn;
}
?>