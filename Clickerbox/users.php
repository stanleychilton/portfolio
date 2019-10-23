<!--SELECT COUNT(post_id) FROM anon_comments WHERE post_id = 22 -->
<?php
$pagenum = 2;
?>
<html>
<head>
<script src='https://www.google.com/recaptcha/api.js'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/homepage.css"> 
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script  src="javascript/scripts.js"></script>
</head>


<body>
<div id="contains">
<div class="header">
<?php
require 'connect.php';
$conn    = Connect();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT count FROM counter";
$result = $conn->query($sql);

echo "<div id='chardiv'>page view count: " . ($result->fetch_assoc()['count']+1) . "</div>";

$update = "UPDATE counter 
  SET count = count + 1 
  WHERE id = 1";
$conn->query($update)
?>
</div>

<div id='nav_bar'>
<?php
include('menu.php')
?>
</div>

<div id='mainfield'>



<form action="createuser.php" method="post">
firstname: <input type="text" name="f_name"><br><br>
lastname: <input type="text" name="l_name"><br><br>
username: <input type="text" name="u_name"><br><br>
Email: <input type="text" name="email"><br><br>
password: <input type="text" name="pass"><br><br>
confirm password: <input type="text" name="con_pass"><br><br>
<div class="g-recaptcha" data-sitekey="6LcMb0IUAAAAAFo3Fy2UVgmEtKh1vq51P5w22bWo"></div>
<input type="submit" name="submit" value="Submit">
</form>


</div>
<?php
include('footer.php');
?>
</div>
<?php
include('infolinks.php');
?>
</body>

</html>