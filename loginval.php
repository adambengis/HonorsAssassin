<?php
	session_start();

	include 'randStr.php';
	include 'dbconnect.php';

	$login_status = 1;

	if (mysqli_connect_errno())
	{
		login_failed();
		die(mysqli_connect_error());
	}

	function login_failed()
	{
		global $login_status;
		$login_status = 0;
		echo "login failed";
	}

	$query = "";
	if($_POST['type'] == "player") 
		$query = "SELECT lcase(hex(player.hash)) AS hash, 
					player.first, 
					player.last, 
					player.res, 
					player.floor,
					concat(target.first, ' ', target.last) AS target,
					player.reg
					FROM player 
					LEFT JOIN player AS target
					ON player.target = target.uid 
					WHERE player.uid = '" .  $_POST['uid'] . "';";
	else if($_POST['type'] == "_mod") 
		$query = "SELECT lcase(hex(hash)) AS hash, first, last, res, floor, reg FROM _mod WHERE uid = '" .  $_POST['uid'] . "';";

	$result = mysqli_query($sql, $query);

	if(!$result)
	{
		login_failed();
		die(mysqli_error($sql));
	}

	$rowset = mysqli_fetch_assoc($result);

	$hash = $rowset['hash'];

	if($_POST['dt'] == md5($_SESSION['salt'] . $hash))
	{
		unset($_SESSION['salt']);
		$_SESSION['uid'] = $_POST['uid'];
		$_SESSION['table'] = $_POST['type'];
		$_SESSION['first'] = $rowset['first'];
		$_SESSION['last'] = $rowset['last'];
		$_SESSION['res'] = $rowset['res'];
		$_SESSION['floor'] = $rowset['floor'];
		$_SESSION['reg'] = $rowset['reg'];
		$_SESSION['del'] = '"' . randStr(20) . '"';

		if($_SESSION['table'] == "player")
		{
			$_SESSION['type'] = "Assassin";
			$_SESSION['target'] = $rowset['target'];
		}
		else if($_SESSION['table'] == "_mod")  $_SESSION['type'] = "Moderator";
		else $_SESSION['type'] == "ERROR";

		echo "login success -> " . strtolower($_SESSION['type']) . ".php";
	}
	else
		login_failed();

	$ip = $_SERVER['REMOTE_ADDR'] ?: ($_SERVER['HTTP_X_FORWARDED_FOR'] ?: $_SERVER['HTTP_CLIENT_IP']);

	mysqli_query($sql, "INSERT INTO login (uid, ip, status) VALUES ('" . $_POST['uid'] 
		. "', INET6_ATON('" . $ip . "'), " . $login_status . ");");

	mysqli_close($sql);
?>