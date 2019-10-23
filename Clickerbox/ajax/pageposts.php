<?php
	if (isset($_POST['getData'])) {
		require 'connect.php';
        $conn    = Connect();

		$start = $conn->real_escape_string($_POST['start']);
		$limit = $conn->real_escape_string($_POST['limit']);
        $id = $conn->real_escape_string($_POST['username']);			
		$table = 'post';	
		$com_table = 'comments';

		

		$sql = $conn->query("SELECT id, cat_id, mod_name, date, topic, image, active FROM $table WHERE mod_name = '" . $id . "' ORDER BY id desc LIMIT $start, $limit ");
		if ($sql->num_rows > 0) {
			$response = "";
		
			while($data = $sql->fetch_array()) {
				if($data['active'] == 0){
					if($data['cat_id'] == -1){
						$value = "Updated profile picture";
					}else{
						$pg_title = "SELECT Topic FROM categories WHERE ID = ".$data['cat_id'];
						$title = $conn->query($pg_title);
						$value = $title->fetch_assoc()['Topic'];
					}
					$topics = $conn->query("SELECT COUNT(id) FROM $com_table WHERE Post_ID = ".$data['id']);
					$topic_result = mysqli_fetch_array($topics);
					$response .= "
						<div class='card' style='word-warp:break-word;'>
							";
							
							$response .= "<h4>". $value ."</h4>";
							$response .= "<p>".date('Y-m-d', $data['date'])."</p>
							<p>".date('H:i:s', $data['date'])."</p>
							<p>" . nl2br($data["topic"]) . "</p>";
							if ($data["image"] != ""){ 
							$response .= "<img class='fakeimg' src='" . $data["image"]. "' id='post_image'>";
							}
							$response .= "<a class='button' id='textedit' href='pub_post.php?id=".$data['id']."'>Click here to comment (". $topic_result[0] .") </a><br><br></div>";

				}
			}
			$response .= '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
								 style="display:block"
								 data-ad-format="fluid"
								 data-ad-layout-key="-fb+5w+4e-db+86"
								 data-ad-client="ca-pub-9006258879887861"
								 data-ad-slot="9097532416"></ins>
							<script>
								 (adsbygoogle = window.adsbygoogle || []).push({});
							</script>';
			exit($response);
		} else
			exit("reached Max");
	}
?>