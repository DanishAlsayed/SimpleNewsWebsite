<html>
<body>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"> </script>
<script>
	function login(){
		var username = document.getElementById("username").value;
		var password = document.getElementById("password").value;
		var xmlhttp;
		if(username=="" || password==""){
			alert("Please enter username and password");
			return;
		}
		else{
			if(window.XMLHttpRequest){
				xmlhttp = new XMLHttpRequest();
			}
			else{
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					if(xmlhttp.responseText=="login success"){
						document.getElementById("title").innerHTML="<h3>You have sucessfully logged in</h3>";
						document.getElementById("nameInput").style.visibility="hidden";
						document.getElementById("passwordInput").style.visibility="hidden";
						document.getElementById("loginButton").style.visibility="hidden";
					}
					else{
						document.getElementById("title").innerHTML="<h3>"+xmlhttp.responseText+"</h3>";
						if(xmlhttp.responseText=="Password is incorrect")
								document.getElementById("password").value="";
						else if(xmlhttp.responseText=="Username is incorrect"){
							document.getElementById("username").value="";
							document.getElementById("password").value="";
						}
					}
				}
			}
			var url = "handleLogin.php?username="+username+"&password="+password;
			xmlhttp.open("GET",url,true);
			xmlhttp.send();
		}
	}
	$(document).ready(function(){
		$("#loginButton").click(function(){
			login();
		});
	});
</script>
<?php
	print "<div class='form' id ='login'>";
	print "<ul id='inputs' style='list-style: none;'>";
	print "<ul style='list-style: none;'><li id='title'><h3>You can log in here</h3></li></ul>";
	print "<ul id='nameInput'><li><p>User Name</p></li>";
	print "<li><input id ='username' type='text'class='submit'></li></ul>";
	print "<ul id='passwordInput'><li><p>Password</p></li>";
	print "<li><input id ='password' type='password' class='submit'></li></ul>";
	print "<ul><li><input  class='submit' id='loginButton' type='submit' value='Submit'></li></ul>";
	print "</ul>";
	print "</div>";
	if($_GET["newsID"]==0)
		print "<a href='index.html' id='goBack'>Go back</a>";
	else
		print "<a href='displayNewsEntry.php?newsID=".$_GET["newsID"]."' id='goBack'>Go back</a>";
?>
</body>
</html>
