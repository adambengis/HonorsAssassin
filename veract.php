<?php
	session_start();

	function fail()
	{
		die('Unable to load stick pics file.');
	}

	include 'dbconnect.php';

	if (mysqli_connect_errno())
	{
		die("alert -> " . mysqli_connect_error());
	}

	$query = "SELECT uid, file 
				FROM submit 
				WHERE status = 0 
				ORDER BY uptime ASC 
				LIMIT 1;"

	$result = mysqli_query($sql, $query);

	$return = "";

	if(mysqli_num_rows($result) > 0)
	{
		$rowset = mysqli_fetch_assoc($result);
		$userpic = load('userpics/' . $rowset['uid'] . ".png");
		$stickpic = load('stickpics/' . $rowset['file']);
	}else
		fail();

	if(strlen($return) == 0)
		fail();



?>