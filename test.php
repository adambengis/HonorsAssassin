<?php
	session_start();

	include 'randStr.php';

	$fileloc = "stickpics/" . randStr(16) . ".jpg";
	while(file_exists($fileloc))
	{
		$fileloc = randStr(16) . ".jpg";
	}
	$file = fopen($fileloc, "w");
	$imgbin = base64_decode($_POST['bin']);
	//$img = imagecreatefromstring($imgbin);
	fwrite($file, $imgbin);

	$query = "INSERT INTO pending (uid, loc, date, file)
				VALUES ('" . $_SESSION['uid'] . "', '" 
				. $_POST['loc'] . "', '"
				. $_POST['dt'] . " " . $_POST['tm'] . "', '"
				. $fileloc . "');";
	$result = mysqli_query($sql, $query);

	mysqli_close($sql);
?>