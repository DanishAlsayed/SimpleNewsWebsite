<?php
	$conn=mysqli_connect('sophia.cs.hku.hk','danish','HKUmysql123') or die ('Failed to Connect '.mysqli_error($conn));
	mysqli_select_db($conn,'danish') or die ('Failed to Access DB'.mysqli_error($conn));
	$username = $_GET['username'];
	$password = $_GET['password'];
	$query = "select count(userID) from users where name='".$username."'";// AND password='".$password."'";
	$result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
	$row = mysqli_fetch_assoc($result);
	if($row["count(userID)"]>0){
		$query2="select userID from users where name='".$username."'AND password='".$password."'";
		$result = mysqli_query($conn, $query2) or die ('Failed to query '.mysqli_error($conn));
		if($row2 = mysqli_fetch_assoc($result)){
			echo "login success";
			setcookie("userID", $row2['userID'],time()+3600,"/");
		}
		else
			echo "Password is incorrect";
	}
	else
		echo "Username is incorrect";
?>