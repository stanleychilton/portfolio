<html>
<?php
session_start();
if(!isset($login_session)){
	include("login.php");
}
include("session.php");
?>
	<body>
		
		<table class="Navbar">
			<tr>
				<td id="HomeTD"><a id="Home" href="index.php">Home</a></td>
				<?php 
				if(isset($login_session)){
				?>
				
				<td><?php echo "you logged in as: </br>", $login_session; ?></td>
				
				<?php
				}
				?>
				<td><form id="Search">Search:<input type="text" placeholder="Enter search keywords..."><input type="submit"></form></td>
				<?php 
					if(isset($login_session)){
						echo "<td><a href=''>Profile</a></td>";
						echo "<td><a href='logout.php'>Logout</a></td>";
					}else{
						echo "<td><form id='LoginSignup' action='' method='POST'>UserName:<input type='text' name='username' placeholder='Enter UserName'>Password:<input type='password' name='password' placeholder='Enter Password'><input type='submit'/></form></td>";
					}
					
				?>
				<td>
					<!-- Trigger/Open The Modal -->
					<button id="myBtn">Signup</button>					
				</td>
			</tr>
		</table>
		<div id="SignupPopup" class="Popup">		
		  <!-- Modal content -->
			<div class="popup-content">
			    <span class="close">&times;</span>
			    <p>Some text in the Modal..</p>
	  		</div>
		</div>
		
		<script>
			// Get the popup
			var popup = document.getElementById('SignupPopup');
			
			// Get the button that opens the modal
			var btn = document.getElementById("myBtn");
			
			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			
			// When the user clicks the button, open the modal 
			btn.onclick = function() {
			    popup.style.display = "block";
			}
			
			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
			    popup.style.display = "none";
			}
			
			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
			    if (event.target == popup) {
			        popup.style.display = "none";
			    }
			}
		</script>
	</body>
</html>