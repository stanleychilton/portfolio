<?php
$user = $_GET['user'];

require 'connect.php';
$conn    = Connect();
include('session.php');
use PHPMailer\PHPMailer\PHPMailer;
require "PHPMailer/PHPMailer.php";
require "PHPMailer/Exception.php";

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
        $sql = "UPDATE users SET Rank = 1 WHERE Username = '$user'";
        if (mysqli_query($conn, $sql)) {
            $sql = "DELETE FROM application WHERE username = '$user'";
            mysqli_query($conn, $sql);
            $strSQL = "SELECT Firstname, Lastname, email FROM users WHERE Username = '$user' LIMIT 1";
            $result = mysqli_query($conn, $strSQL) or die('SQL Error :: '.mysqli_error($conn));
            $row = mysqli_fetch_assoc($result);
            $full_name = $row['Firstname']." ".$row['Lastname'];
            mysqli_close($conn);
            $mail = new PHPMailer();
            $mail->setFrom("hello@clickerbox.com", "Clickerbox Subscription");
            $mail->addAddress($row['email'], ucfirst($full_name));
            $mail->addReplyTo('support@clickerbox.com', 'Support');
            $mail->isHTML(true);
            $mail->Subject = "Mod application response!";
            $mail->Body    = "<h1>Congratulations!</h1><br>
                              You have been accepted into the user moderator program!<br>
                              Head on over to clicker-box.com to post some new topics!
                              <br><br>Regards
                              <br> Clicker-box.com team<br>";
            if ($mail->send())
                $msg = "You have been registered! Please verify your email!";
            else
                $msg = "Something wrong happened! Please try again!";
            header('Location: /clickerbox/applications.php'); //If book.php is your main page where you list your all records
            exit;
        } else {
            echo "Error deleting record";
        }
        
        $conn->close();
    }
}


?>


