<?php
	if (isset($_POST['getData'])) {
		require 'connect.php';
        $conn    = Connect();
		include('session.php');

		$start = $conn->real_escape_string($_POST['start']);
		$limit = $conn->real_escape_string($_POST['limit']);
        $id = $conn->real_escape_string($_POST['id']);
		$table_a = $conn->real_escape_string($_POST['table_a']);
		if($table_a==1){
			$table = 'anon_post';			
		}else if($table_a==2){
			$table = 'post';
		}
		
		$com_table_a = $conn->real_escape_string($_POST['com_table_a']);
		if($com_table_a==1){
			$com_table = 'anon_comments';
		}else if($com_table_a==2){
			$com_table = 'comments';
		}
		
		if(isset($login_session)){
			$rank_check = "SELECT Rank FROM users WHERE Username = '$login_session'";
			$cur = $conn->query($rank_check);
			$curr = $cur->fetch_assoc()['Rank'];
		}

		$sql = $conn->query("SELECT id, mod_name, date, topic, image, active FROM $table WHERE cat_id = $id and active = 0 ORDER BY id desc LIMIT $start, $limit ");
		if ($sql->num_rows > 0) {
			$response = "";

			while($data = $sql->fetch_array()) {
				if($data['active'] == 0){
					$topics = $conn->query("SELECT COUNT(id) FROM $com_table WHERE Post_ID = ".$data['id']." and active = 0");
					$topic_result = mysqli_fetch_array($topics);
					$response .= "
						<div class='card' style='word-warp:break-word;'>
							";
							if($table_a == 2){
								$response .= "<h4><a class='prolink' href='profile.php?id=".$data['mod_name']."'>".$data['mod_name']."</a></h4>";
							}
							$response .= "<p>".date('Y-m-d', $data['date'])."</p>
							<p>".date('H:i:s', $data['date'])."</p>
							<p>" . nl2br($data["topic"]) . "</p>";
							if ($data["image"] != ""){ 
							$response .= "<img class='fakeimg' src='" . $data["image"]. "' id='post_image'>";
							}
							if($table_a==1){
								$response .= "<a class='button' id='textedit' href='post.php?id=".$data['id']."'>Click here to comment (". $topic_result[0] .") </a>";
							}else if($table_a==2){
								$response .= "<a class='button' id='textedit' href='pub_post.php?id=".$data['id']."'>Click here to comment (". $topic_result[0] .") </a>";
							}
							if(isset($login_session)){
								if($curr >= 1){
									if(intval($table_a)==1){
										$response .= " <a class='button' id='textedit' href='postdisplay.php?id=".$data['id']."&t=5' style='background-color: orange;'>Hide post</a>";
									}else if(intval($table_a)==2){
										$response .= " <a class='button' id='textedit' href='postdisplay.php?id=".$data['id']."&t=6' style='background-color: orange;'>Hide post</a>";
									}
							}
						}
						$response .= "<br><br></div>";
				}	
			}
			$response .= '<div class="card">
							<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
								 style="display:block"
								 data-ad-format="fluid"
								 data-ad-layout-key="-fb+5w+4e-db+86"
								 data-ad-client="ca-pub-9006258879887861"
								 data-ad-slot="9097532416"></ins>
							<script>
								 (adsbygoogle = window.adsbygoogle || []).push({});
							</script>
							</div>';
			exit($response);
		} else
			exit("reached Max");
	}
?>