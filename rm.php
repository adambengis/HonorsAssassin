<?php
	session_start();

	include 'dbconnect.php';

	if (mysqli_connect_errno())
	{
		login_failed();
		die(mysqli_connect_error());
	}
	$status = 1;

	if('"' . $_POST['conf'] . '"' == $_SESSION['del'])
	{
		$query = "UPDATE player SET hash = '' WHERE uid = '" . $_SESSION['uid'] . "';";

		mysqli_query($sql, $query);

	}else
		$status = 0;

	$ip = $_SERVER['REMOTE_ADDR'] ?: ($_SERVER['HTTP_X_FORWARDED_FOR'] ?: $_SERVER['HTTP_CLIENT_IP']);

	mysqli_query($sql, "INSERT INTO passdel (uid, ip, status) VALUES ('" . $_SESSION['uid'] 
		. "', INET6_ATON('" . $ip . "'), " . $status . ");");

	if($status)
	{
	 	echo "success";
	 	session_destroy();
	}
	else echo "ERROR";

	mysqli_close($sql);
?>