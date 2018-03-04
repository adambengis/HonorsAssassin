<?php
	session_start();

	include 'randStr.php';

	if(strlen($_POST['bin']) > 5750000)
	{
		//echo "File Size is too big! Images must be less than 4MB.";
		die("alert -> File Size is too big! Images must be less than 4MB.");
	}

	$data = explode(';base64,', $_POST['bin'])[1];
	$file_data = base64_decode($data);

	$finfo = finfo_open();
	$file_mime_type = finfo_buffer($finfo, $file_data, FILEINFO_MIME_TYPE);

	if($file_mime_type == 'image/jpeg' || $file_mime_type == 'image/jpg')
		$file_type = 'jpeg';
	else if($file_mime_type == 'image/png')
		$file_type = 'png';
	else if($file_mime_type == 'image/gif')
		$file_type = 'gif';
	else 
		$file_type = 'other';
	if(!in_array($file_type, [ 'jpeg', 'png', 'gif' ])) 
	{
		die("alert -> File is not a valid type! Images must be a png, jpeg, or gif.");
	}

	include 'dbconnect.php';

	if (mysqli_connect_errno())
	{
		die("alert -> " . mysqli_connect_error());
	}

	while(strlen($fileloc) == 0 || file_exists("stickpics/" . $fileloc))
	{
		$fileloc = randStr(32) . "." . $file_type;
	}
	
	file_put_contents("origpics/" . $fileloc, $file_data);

	include "imgresize.php";
	imgresize("origpics/" . $fileloc, "stickpics/" . $fileloc, 1500);

	$query = "INSERT INTO submit (uid, loc, date, file)
			VALUES ('" . $_SESSION['uid'] . "', '" 
			. $_POST['loc'] . "', '"
			. $_POST['dt'] . " " . $_POST['tm'] . "', '"
			. $fileloc . "');";
	$result = mysqli_query($sql, $query);
	echo mysql_error();
	echo "upload success";
	mysqli_close($sql);
?>