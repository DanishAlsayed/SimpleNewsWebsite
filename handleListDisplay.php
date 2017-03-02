<?php
	function getSimplifiedContent($content,$words_number)
	{
		$simplifiedContent=$content;
		$strArr=explode(" ",$content);
		$temp=array();
		if(count($strArr)>$words_number) 
		{
			foreach ($strArr as $key=> $value) {
				$temp[]=$value; 
				if($key==$words_number-1)
				{
					$simplifiedContent=implode(" ",$temp);
				}
			}   
		}
		return $simplifiedContent;
	}
	$pageIndex = $_GET["pageIndex"];
	$loginStatus = '0';
	if(isset($_COOKIE["userID"]))
		$loginStatus = '1';
	$conn=mysqli_connect('sophia.cs.hku.hk','danish','HKUmysql123') or die ('Failed to Connect '.mysqli_error($conn));
	mysqli_select_db($conn,'danish') or die ('Failed to Access DB'.mysqli_error($conn));
	$query = "SELECT * FROM news WHERE headline LIKE '%${_GET['searchString']}%' ORDER BY newsID DESC";
	$result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
	$resultCount = mysqli_num_rows($result);
	$json_array = array();
	$json_array [] = array("loginStatus" =>$loginStatus, "resultCount" => $resultCount);
	$start = ($pageIndex -1)*5;
	$counter = 0;
	while($row = mysqli_fetch_assoc($result)){
		$counter++;
		if($counter > $start){
			$row['content'] = getSimplifiedContent($row['content'], 10);
			$json_array[] = array("newsID" => $row['newsID'],
									"headline" => $row['headline'],
									"content" => $row['content'],
									"time" => $row['time']);
		}
		if($counter > ($start + 4))
			break;
	}
	echo json_encode($json_array);
?>