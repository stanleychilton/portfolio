<?php
require 'connect.php';
$conn    = Connect();
include('session.php');
$pagenum = 9;
$mobile = 0;

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
	$mobile=1;
}

if(!isset($login_session)){
    header('Location: /clickerbox/login.php');
}
if (isset($_POST['submit'])) {
    $name    = $login_session;
    $message   = htmlentities($conn->real_escape_string($_POST['message']));
    $query   = "INSERT into application (username,message) VALUES('" . $name . "','" . $message . "')";
    $success = $conn->query($query);

    if (!$success) {
        die("Couldn't enter data: ".$conn->error);
    }
}


?>
<!DOCTYPE html>
<html lang="en" style = 'padding-right: 0px;'>
    <head>
		<?php
			include("analytics.php");
		?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/homepage.css"> 
		<link rel="stylesheet" href="css/postspage.css">	
		<link rel="stylesheet" href="css/index.css"> 
		<script  src="javascript/scripts.js"></script>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
		<script  src="javascript/scripts.js"></script>
    </head>
    <body style = 'padding-right: 0px;'>
		
        <div id="mainfield">
			<div id='nav_bar'>
				<?php
				include('menu.php')
				?>
			</div>
			<?php
			if ($mobile == 0){
			?>
            <div class="row" style="margin-right:0px;margin-left:0px">
			
				<div class="col-md-3">
					<?php
						include('sidebar_left.php');
					?>
				</div>
				<?php
				}
				?>
                <div class="col-md-6 col-md-offset-0" style = 'padding-right: 0px;'>
					<?php
					if(isset($login_session)){
						$app_check = "SELECT id FROM application WHERE Username = '$login_session'";
						$result = $conn->query($app_check);
						if ($result->num_rows > 0) {
							echo "<div id='chardiv'>You have applied please wait for a response via email</div>";
						}else{
					?>
					<form action="" method="post">
					what do you offer as a moderator?:<br>

					<textarea class='autoExpand' rows='3' data-min-rows='3' placeholder='Write your answer here' name="message" required></textarea>
					<input type="submit" name="submit" value="Submit">
					</form>
					<!--<div style = "chardiv"><?php echo $msg; ?></div>-->
					<?php
						}
					}
					?>
					</div>
				<?php
				if ($mobile == 0){
				?>
				<div class="col-md-3 col-md-offset" style="overflow:hidden;">
					
					
					<?php
						include('sidebar_right.php');
					?>
				</div>
				</div>
				<?php
				}
				?>
            
			
			<?php
			include('footer.php')
			?>
			</div>
	<?php
	$conn->close();
	?>
	</body>
</html>