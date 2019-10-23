<?php
   session_start();
   
   if(isset($_SESSION['login_user'])){
       $user_check = $_SESSION['login_user'];
       
       $sql = "select username from users where username = '$user_check' ";
       $result = mysqli_query($conn,$sql);
       $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
       
       $login_session = $row['username'];
   }

?>