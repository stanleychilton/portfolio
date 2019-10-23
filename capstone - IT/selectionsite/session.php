<?php
   session_start();
   
   if(isset($_SESSION['login_user'])){
       $user_check = $_SESSION['login_user'];
       
       $sql = "select f_name from admin where f_name = '$user_check' ";
       $result = mysqli_query($conn,$sql);
       $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
       
       $login_session = $row['f_name'];
   }

?>