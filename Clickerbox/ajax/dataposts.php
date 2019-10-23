<?php
	if (isset($_POST['getData'])) {
		require 'connect.php';
        $conn    = Connect();
		include('session.php');

		$start = $conn->real_escape_string($_POST['start']);
		$limit = $conn->real_escape_string($_POST['limit']);
        $id = $conn->real_escape_string($_POST['id']);
		$table_a = intval($conn->real_escape_string($_POST['table_a']));
		if(intval($table_a)==1){
			$table = 'anon_comments';			
		}else if(intval($table_a)==2){
			$table = 'comments';
		}
	
		if(isset($login_session)){
			$rank_check = "SELECT Rank FROM users WHERE Username = '$login_session'";
			$cur = $conn->query($rank_check);
			$curr = $cur->fetch_assoc()['Rank'];
		}

		$sql = $conn->query("SELECT * FROM $table WHERE Post_ID = $id and active = 0 LIMIT $start, $limit ");
		if ($sql->num_rows > 0) {
			$response = "";

			while($data = $sql->fetch_array()) {
				if($data['active'] == 0){
					$response .= "<div class='card' style='word-warp:break-word;'>";
							if(intval($table_a)==2){
								$response .= "<h4><a class='prolink' href='profile.php?id=".$data['name']."'><b>".$data['name']."</b></a></h4>";
							}
							$response .= "<p>".date('Y-m-d', $data['Date'])."</p>
							<p>".date('H:i:s', $data['Date'])."</p>
							<p>" . nl2br($data["comment"]) . "</p>";
							if ($data["image"] != ""){ 
							$response .= "<img class='fakeimg' src='" . $data["image"]. "' id='post_image'>";
							}
						if(isset($login_session)){
							if($curr >= 1){
								if(intval($table_a)==1){
									$response .= " <a class='button' id='textedit' href='postdisplay.php?id=".$data['ID']."&t=7' style='background-color: orange;'>Hide post</a>";
								}else if(intval($table_a)==2){
									$response .= " <a class='button' id='textedit' href='postdisplay.php?id=".$data['ID']."&t=8' style='background-color: orange;'>Hide post</a>";
								}
							}
						}
						$response .= "</div>";
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