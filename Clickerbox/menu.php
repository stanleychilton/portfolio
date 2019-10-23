<?php
  echo "<div><ul id='menustyle'>";
  echo "<li id='menulayout'><a";
  if($pagenum == 0){ 
	echo " class='active'";
  } 
  echo " href='index.php' id='textedit'>Home</a></li>";
  
  if(!isset($login_session)){
  echo "<li id='menulayout'><a "; 
  if($pagenum == 2){
      echo " class='active' ";
      }
  echo " href='register.php' id='textedit'>Register</a></li>";
  echo "<li id='menulayout'><a";
  if($pagenum == 7){
      echo " class='active'";
  }
  echo " href='login.php' id='textedit'>Login</a></li>";
}else{
  //<!--<li><a href="schedule.html">Episodes</a></li>
  //<li><a href="snippets.html">Snippets</a></li>>-->
  
  
    echo "<li id='menulayout'><a ";
    if ($pagenum == 1){
        echo "class='active'";
    }
    echo" href='pub_ind.php' id='textedit'>Public Forum</a></li>";
	$menu_image = "SELECT Image FROM users WHERE username = '$login_session'";
	$menu_image_result = mysqli_query($conn,$menu_image);
	$image_row = mysqli_fetch_array($menu_image_result,MYSQLI_ASSOC);	
	echo "<a ";
    if ($pagenum == 10){
        echo "class='active'";
    }
    echo" href='profile.php?id=". $login_session . "' id='textedit'><li id='menulayout'><div id='image_div'>";
	if($image_row['Image'] == NULL){
		echo "<img src='user_images/profile/default.jpg' id='menu_image'>";
	}else{
	echo "<img src='" .$image_row['Image']. "' id='menu_image'>";
	}
	echo"</div>" . $login_session . "</a></li>";
	
    
    
    
}
if(isset($login_session)){
    $rank_check = "SELECT Rank FROM users WHERE Username = '$login_session'";
    $cur = $conn->query($rank_check);
    $curr = $cur->fetch_assoc()['Rank'];
    if($curr <= 0){
        
        
        echo "<li style='float:right'><a";
        if($pagenum == 9){
            echo " class='active'";
        }
        echo " href='application.php' id='textedit'>Mod Application</a></li>";
        
        
    }
    echo "<li style='float:right;' ><a href='logout.php' id='textedit'>Logout</a></li>";
}

  
	echo "<li style='float:right' id='menulayout'><a";
	if($pagenum == 8){ 
		echo " class='active'"; 
	} 
	echo " href='updates.php' id='textedit'>Updates</a></li></ul>";

if(isset($login_session)){  
    if($curr >= 2){
		  echo "<ul id='menustyle'>";
          echo "<li id='menulayout'><a";
		  if($pagenum == 11){
              echo " class = 'active'"; 
          }
		  echo " href='adder.php' id='textedit'>Add Categories</a></li>";
          echo "<li id='menulayout'><a";
		  if($pagenum == 12){
              echo " class = 'active'"; 
          }
		  echo " href='applications.php' id='textedit'>Mod Applicants</a></li>";
          echo "<li id='menulayout'><a";
          if($pagenum == 3){
              echo " class = 'active'"; 
          }
          echo " href='monitoranoncat.php' id='textedit'>Anon Topic</a></li>";
          
          echo "<li id='menulayout'><a";
          if($pagenum == 4){
              echo " class='active'";
          }
          echo " href='monitoranoncom.php' id='textedit'>Anon Comments</a></li>";
         
          echo "<li id='menulayout'><a";
          if($pagenum == 5){
              echo " class='active'";
          }
          echo " href='monitorcat.php' id='textedit'>Public Topic</a></li>";
          echo "<li id='menulayout'><a";
          if($pagenum == 6){
              echo " class='active'";
          }
          echo " href='monitorcom.php' id='textedit'>Public Comments</a></li>";
	}
	if($curr >= 3){
	          echo "<li id='menulayout'><a";
          if($pagenum == 13){
              echo " class = 'active'"; 
          }
          echo " href='CBupdatesform.php' id='textedit'>Updates form</a></li>";
	}
}
?>
</ul></div>