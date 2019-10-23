<?php
	if (isset($_POST['update'])) {
		require 'connect.php';
        $conn    = Connect();
		
		
		$page = $conn->real_escape_string($_POST['page']);
		if($page == 0 || $page == 2 || $page == 7 || $page == 8){
			$sql = $conn->query("SELECT ID, cat_id, date, topic, image FROM anon_post ORDER BY ID desc LIMIT 0, 5");
			$file = "category";
			$file2 = "post";
		}else{
			$sql = $conn->query("SELECT ID, cat_id, mod_name, date, topic, image FROM post WHERE cat_id != -1 ORDER BY ID desc LIMIT 0, 5");
			$file = "pub_cat";
			$file2 = "pub_post";
		}
				
		
		if ($sql->num_rows > 0) {
			$response = "";
		
			while($data = $sql->fetch_array()) {
				$pg_title = "SELECT Topic FROM categories WHERE ID = ".$data['cat_id'];
				$title = $conn->query($pg_title);
				$value = $title->fetch_assoc()['Topic'];
				$response .= "<div class='card' style='word-warp:break-word;'><p>".
				"<b>".$value."</b><br>";
				if($file == "pub_cat"){
				$response .= "<a class='prolink' href='profile.php?id=".$data['mod_name']."'>".$data['mod_name']."</a><br>";
				}
				$response .= date('Y-m-d', $data['date'])."<br>".
				$data['topic']."<br>";
				if ($data["image"] != ""){ 
				$response .= "<img class='fakeimg' src='" . $data["image"]. "' id='post_image'></p>";
				}
				$response .= "<a class='button' id='textedit' href='".$file.".php?id=".$data['cat_id']."'>forum</a>".
							"<a class='button' id='textedit' href='".$file2.".php?id=".$data['ID']."'>comment</a>";
				$response .= "</div>";
			}
			exit($response);
		}else
			exit("no new posts");
	}
?>