<?php
	if (isset($_POST['getData'])) {
		require 'connect.php';
        $conn    = Connect();

		$start = $conn->real_escape_string($_POST['start']);
		$limit = $conn->real_escape_string($_POST['limit']);
		$table_a = $conn->real_escape_string($_POST['table_a']);
		if($table_a==3){
			$table = 'updates';			
		}
		

		$sql = $conn->query("SELECT id, name, time, message FROM $table ORDER BY id DESC LIMIT $start, $limit ");
		if ($sql->num_rows > 0) {
			$response = "";

			while($data = $sql->fetch_array()) {
				$response .= "
					<div class='card' style='word-warp:break-word;'>".
					" <h5>" . date('Y-m-d', $data["time"]) . "<br> " . date('H:i:s', $data["time"]) . "</h5>" .
					" <p>" . nl2br($data["message"]) . "</p>".
					" <h4><b>" . $data["name"]. "</b></h4></div>";
					
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
			exit('reachedMax');
	}
?>