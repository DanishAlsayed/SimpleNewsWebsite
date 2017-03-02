<?php
	$comment = $_GET["comment"];
	$newsID = $_GET["newsID"];
	$lastCommentID = $_GET["lastCommentID"];
	$time = $_GET["time"];
	$userID = $_COOKIE['userID'];
	$maxIDquery="SELECT * FROM comments ORDER BY commentID DESC LIMIT 1";
	$conn=mysqli_connect('sophia.cs.hku.hk','danish','HKUmysql123') or die ('Failed to Connect '.mysqli_error($conn));
	mysqli_select_db($conn,'danish') or die ('Failed to Access DB'.mysqli_error($conn));
	$result = mysqli_query($conn, $maxIDquery) or die ('Failed to query '.mysqli_error($conn));
	$row = mysqli_fetch_assoc($result);
	$maxID = $row['commentID'];
	$maxID++;
	$insertQuery = "INSERT INTO comments(commentID, newsID, userID,content,time) VALUES ('".$maxID."','".$newsID."','".$userID."','".$comment."','".$time."')";
	$result = mysqli_query($conn, $insertQuery) or die ('Failed to query '.mysqli_error($conn));
	if($result){
		$newCommentsQuery = "SELECT * FROM comments WHERE commentID >'".$lastCommentID."'AND newsID ='".$newsID."'ORDER BY commentID DESC";
		$result = mysqli_query($conn, $newCommentsQuery) or die ('Failed to query '.mysqli_error($conn));
		$json_array = array();
		while($row = mysqli_fetch_assoc($result)){
			$userQuery = "SELECT name, icon FROM users WHERE userID=".$row['userID'];
			$userDetails = mysqli_query($conn, $userQuery) or die ('Failed to query '.mysqli_error($conn));
			$userRow = mysqli_fetch_assoc($userDetails);
			$json_array[] = array("newsID" => $row['newsID'],
								"userID" => $row['userID'],
								"content" => $row['content'],
								"time" => $row['time'],
								"commentID"=>$row['commentID'],
								"name"=>$userRow['name'],
								"icon"=>$userRow['icon']);
			}
		echo json_encode($json_array);
	}
?>