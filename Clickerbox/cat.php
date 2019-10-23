<!--SELECT COUNT(post_id) FROM anon_comments WHERE post_id = 22 -->
<?php
$pagenum = 0;
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

<?php
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, topic FROM categories ORDER BY topic";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div id='chardiv'>id: " . $row["id"]. 
        " <br><a href='index.php?id=".$row['id']."'>".$row["topic"]."</a><br><br></div>";
        
    }
} else {
    echo "0 results";
}

$conn->close();
?>

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