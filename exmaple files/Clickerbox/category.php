<?php
require 'connect.php';
$conn    = Connect();
include('session.php');
$foo = (int)$_GET['id'];
$msg = "";
$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
$pagenum = 0;
$mobile = 0;

$sql = "SELECT MAX(ID) FROM categories";
$highest_id = $conn->query($sql);
$new_id = mysqli_fetch_array($highest_id);

if($foo===NULL){
	header('Location: /clickerbox/index.php');
}

if($foo == -1 || $foo > $new_id[0]){
	header('Location: /clickerbox/index.php');
}

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
	$mobile=1;
}

$target_dir = "user_images/anon_topics/";

if (isset($_POST['submit'])) {
    include('googleapi.php');
    $res = post_captcha($_POST['g-recaptcha-response']);

    if (!$res['success']) {
        // What happens when the CAPTCHA wasn't checked
        $msg = '<p>Please make sure you check the security CAPTCHA box.</p><br>';
    } else {
        
        $ip = getenv('HTTP_CLIENT_IP')?:
                getenv('HTTP_X_FORWARDED_FOR')?:
                getenv('HTTP_X_FORWARDED')?:
                getenv('HTTP_FORWARDED_FOR')?:
                getenv('HTTP_FORWARDED')?:
                getenv('REMOTE_ADDR');
        $id = $foo;
        $name    = $login_session;
        $topic   = htmlentities($conn->real_escape_string($_POST['topic']));
		$text = $topic;
		if(preg_match($reg_exUrl, $text, $url)) {
       // make the urls hyper links
			$topic = preg_replace($reg_exUrl, "<a href='".$url[0]."'>".$url[0]."</a> ", $text);
		} else {
       // if no urls in the text just return the text
		$topic = $text;
		}
        $date = time();
        if(file_exists($_FILES['attachment']['tmp_name']) || is_uploaded_file($_FILES['attachment']['tmp_name'])){
            $uniquesavename=time().uniqid(rand());
            $destFile = $target_dir . "Clickerbox_" . $uniquesavename . '.jpg';
        
            $extension = pathinfo($destFile, PATHINFO_EXTENSION);
            if ($_FILES['attachment']['size'] > 50000000)
                $msg = "Your file is too big!";
            else if ($extension != "png" && $extension != "jpg" && $extension != "jpeg" && $extension != "gif")
                $msg = "Only the image files are allowed!";
            else if (file_exists($destFile))
                $msg = "File with this name already exists!";
            else if(move_uploaded_file($_FILES["attachment"]["tmp_name"],  $destFile));
                $msg = "File Uploaded!";
                $query   = "INSERT into anon_post (cat_id,Mod_name,Date,topic,image,ip) VALUES('" . $id . "','" . $name . "','" . $date . "','" . $topic . "','" . $destFile . "','" . $ip . "')";
        } else {
            $query   = "INSERT into anon_post (cat_id,Mod_name,Date,topic,ip) VALUES('" . $id . "','" . $name . "','" . $date . "','" . $topic . "','" . $ip . "')";
        }
        
        
        $success = $conn->query($query);
        if (!$success) {
            die("Couldn't enter data: ".$conn->error);
        }
    }
}
$pg_title = "SELECT Topic FROM categories WHERE ID = '$foo'";
$title = $conn->query($pg_title);
$value = $title->fetch_assoc()['Topic'];
?>

<!DOCTYPE html>
<html lang="en" style = 'padding-right: 0px;'>
    <head>
		<?php
			include("analytics.php");
		?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $value; ?></title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/homepage.css"> 
		<link rel="stylesheet" href="css/postspage.css">	
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
                <div class="col-md-6 col-md-offset-0 results" style = 'padding-right: 0px;padding-left:0px'>
				<?php
				if(isset($login_session)){
				?>   

					<form id="chardiv" action="" method="post" enctype="multipart/form-data">
					Message:<br>

					  <textarea class='autoExpand' rows='3' data-min-rows='3' placeholder='Post <?php echo $value; ?> topics here' name="topic" required></textarea>
					  <input type="file" name="attachment" accept="image/*">
					  <div class="g-recaptcha" data-sitekey="6LcMb0IUAAAAAFo3Fy2UVgmEtKh1vq51P5w22bWo"></div>
					  <input type="submit" name="submit" value="Submit">
					<br>
					</form>
				<?php
				}else{
				?>
				<br><div class='warncard'><p>You must be <a href='login.php'>Logged in</a> to make a post!<p></div>
				<?php
				}
				?>
                </div>
				<?php
				if ($mobile == 0){
				?>
				<div class="col-md-3 col-md-offset">
					<?php
						include('sidebar_right.php');
					?>
				</div>
				</div>
				<?php
				}
				?>
            
			<br>
			<?php
			include('footer.php')
			?>
			</div>

        <script type="text/javascript">
            var start = 0;
            var limit = 10;
            var reachedMax = false;
			var id = <?php echo $foo ?>;
			var table_a = 1;
			var com_table_a = 1;

            $(window).scroll(function () {
                if ($(window).scrollTop() == $(document).height() - $(window).height())
                    getData();
            });

            $(document).ready(function () {
               getData();
            });

            function getData() {
                if (reachedMax)
                    return;

                $.ajax({
                   url: 'ajax/datatopics.php',
                   method: 'POST',
                   dataType: 'text',
                   data: {
                       getData: 1,
                       start: start,
                       limit: limit,
					   id: id,
					   table_a: table_a,
					   com_table_a: com_table_a
                   },
                   success: function(response) {
                        if (response == "reached Max")
                            reachedMax = true;
                        else {
                            start += limit;
                            $(".results").append(response);
                        }
                    }
                });
            }
        </script>
    </body>
</html>