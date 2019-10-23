<?php
$error = "<br>";
   

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = $conn->real_escape_string($_POST['username']);
      $mypassword = $conn->real_escape_string($_POST['password']);
      
      $sql = "SELECT id FROM users WHERE Username = '$myusername' and Password = '$mypassword'";
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
        $_SESSION['login_user'] = $myusername;
         
         header("location: index.php");
      }else {
         echo $count;
         $error = "Your Login Name or Password is invalid";
      }
   }
?>