<?php
$id = $_GET['id'];
$t_check = intval($_GET['t']);

if($t_check==1 || $t_check==5){
	$table = 'anon_post';
}else if($t_check==2 || $t_check==6){
	$table = 'post';
}else if($t_check==3 || $t_check==7){
	$table = 'anon_comments';
}else if($t_check==4 || $t_check==8){
	$table = 'comments';
}

require 'connect.php';
$conn    = Connect();
include('session.php');

if(!isset($login_session)){
    header('Location: /clickerbox/login.php');
}else{
    $rank_check = "SELECT Rank FROM users WHERE Username = '$login_session'";
    $cur = $conn->query($rank_check);
    $curr = $cur->fetch_assoc()['Rank'];
    if($curr < 1){
        echo $curr;
        header('Location: /index.php');
    }else{
        if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
	
	$active_check = "SELECT active FROM $table WHERE id = '$id'";
    $cur_active = $conn->query($active_check);
    $curr_active = $cur_active->fetch_assoc()['active'];
	if($curr_active==0){
		$query   = "UPDATE $table SET active=1 WHERE id = '$id'";
	}else if($curr_active==1){
		$query   = "UPDATE $table SET active=0 WHERE id = '$id'";
	}
	$success = $conn->query($query);
    if (!$success) {
        die("Couldn't enter data: ".$conn->error);  
        }
    
	
	if($t_check==5 || $t_check==6){
		$id_check = "SELECT cat_id FROM $table WHERE ID = $id";
		$cur_id = $conn->query($id_check);
		$p_id = $cur_id->fetch_assoc()['cat_id'];
	}else if($t_check==7 || $t_check==8){
		$id_check = "SELECT Post_ID FROM $table WHERE ID = $id";
		$cur_id = $conn->query($id_check);
		$p_id = $cur_id->fetch_assoc()['Post_ID'];
	}
	
	$conn->close();
	
	if($t_check==1){
		header('Location: /clickerbox/monitoranoncat.php');
	}else if($t_check==2){
		header('Location: /clickerbox/monitorcat.php');
	}else if($t_check==3){
		header('Location: /clickerbox/monitoranoncom.php');
	}else if($t_check==4){
		header('Location: /clickerbox/monitorcom.php');
	}else if($t_check==5){
		header('Location: /clickerbox/category.php?id='.$p_id);
	}else if($t_check==6){
		header('Location: /clickerbox/pub_cat.php?id='.$p_id);
	}else if($t_check==7){
		header('Location: /clickerbox/post.php?id='.$p_id);
	}else if($t_check==8){
		header('Location: /clickerbox/pub_post.php?id='.$p_id);
	}
    }
}
?>