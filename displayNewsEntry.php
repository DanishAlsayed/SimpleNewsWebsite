<html>
<head>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'> </script>
<script>
	var LAST =-1;
	function postComment(lastCommentID, newsID){
		var xmlhttp;
		var comment = document.getElementById("commentBox").value;
		if(comment == ""){
			alert("No comment has been entered");
			return;
		}
		else{
			if(window.XMLHttpRequest){
				xmlhttp = new XMLHttpRequest();
			}
			else{
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			//var lastID;
			var json;
			//last=lastCommentID;
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					json = JSON.parse(xmlhttp.responseText);
					//lastID = json[0]["commentID"];
					LAST = json[0]["commentID"];
					//alert(LAST);
					//alert(json[0]["commentID"]);
					for(i=0;i<json.length;i++){
						var str="<ul>";
						str+="<li><img src='"+json[i]['icon']+"'height='40'></li>";
						str+="<li><p class='text'>"+json[i]['name']+"</p></li>";
						str+="<li><p class='text'>"+json[i]['time']+"<br>"+json[i]['content']+"</p></li>";
						str+="</ul>";
						var innerHTML = document.getElementById("comments").innerHTML;
						innerHTML=str+innerHTML;
						document.getElementById("comments").innerHTML=innerHTML;
						str='';
					}
						
				}
			}
			if(LAST < lastCommentID){
				LAST = lastCommentID;
			}
			//alert(LAST);
			var dateObj = new Date();
			var month = dateObj.getMonth();
			var day = dateObj.getDate();
			var year = dateObj.getFullYear();
			var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
			
			var url = "handlePostComment.php?comment="+comment+"&newsID="+newsID+"&lastCommentID="+LAST+"&time="+monthNames[month]+" "+day+" "+year;
			xmlhttp.open("GET",url,true);
			xmlhttp.send();
			document.getElementById("commentBox").value="";
		}
	}
			
</script>
</head>
<body>
<?php
	$conn=mysqli_connect('sophia.cs.hku.hk','danish','HKUmysql123') or die ('Failed to Connect '.mysqli_error($conn));
	mysqli_select_db($conn,'danish') or die ('Failed to Access DB'.mysqli_error($conn));
	$lastCommentID = 0;
	$counter = 0;
	$query = "SELECT * FROM news WHERE newsID=".$_GET['newsID'];
	$result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
	$news = mysqli_fetch_assoc($result);
	$query = "SELECT * FROM comments WHERE newsID='".$_GET['newsID']."'ORDER BY commentID DESC";
	$comments = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
	print "<head>";
	print "<link rel='stylesheet' type='text/css' href='style.css'>";
	print "</head>";
	print "<div id='newsDisplay' class='newsDisplay'>";
	print "<h3>".$news['headline']."</h3>";
	print "<li><a href='index.html'><img href='index.html' src='back-icon.png'style='position: absolute;left:10px;top:10px' width='42' alt='Back'></a></li>";
	//<button type='submit' name='back_button' value='someValue' style='position: absolute;left:10px;top:10px' onclick='window.history.back()'><img src='back-icon.png' width='42' alt='Back'></button>
	print "<p>".$news['time']."</p> <br>";
	print "</div>";
	print "<p>".$news['content']."</p> <br>";
	print "<div id='comments'>";
	while($comment = mysqli_fetch_assoc($comments)){
		if ($counter==0){
			$lastCommentID = $comment['commentID'];
			$counter++;
		}
		$query = "SELECT * FROM users WHERE userID=".$comment['userID'];
		$user = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
		$userRow = mysqli_fetch_assoc($user);
		print "<ul>";
		print "<li><img src='".$userRow['icon']."'height='40'></li>";
		print "<li><p class='text'>".$userRow['name']."</p></li>";
		print "<li><p class='text'>".$comment['time']."<br>".$comment['content']."</p></li>";
		print "</ul>";
	}
	print "</div>";
	print "<div class='newCommentsDiv'>";
	if(isset($_COOKIE["userID"])){
		print "<input id='commentBox' type='text' style='width: 300px;'>";
		print "<button id='newComment' class='submit' onclick='postComment(".$lastCommentID.",".$_GET['newsID'].")'>post comment</button>";
	}
	else{
		print "<input id='commentBox' type='text' style='width: 300px;'disabled>";
		print "<a href='login.php?newsID=".$_GET['newsID']."'><button class='submit'>login to comment</button>";
	}
	print "</div>"
?>
</body>
</html>