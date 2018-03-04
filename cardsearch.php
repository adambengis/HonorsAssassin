<?php
	session_start();

	function buildHist($stat, $names)
	{
		if(count($names) == 0)
		{
			return "<ul><li>No history to display.</li></ul>";
		}
		$html = "<ul>";
		$first = 1;
		foreach ($names as $name) 
		{
			$html .= "<li>";
			$pre = "STUCK - ";
			if(!$stat && $first) 
			{
				$pre = "TERM. - "; 
				$first = 0;
			}
			$html .= $pre . $name . "</li>";
		}
		$html .= "</ul>";
		return $html;
	}

	function getHistory($sql, $uid, $stat)
	{
		$query = "SET @uid := '" . $uid . "';
					SELECT 
						IF(history.vuid = @uid, 
							concat(killer.first, ' ', killer.last), 
							concat(player.first, ' ', player.last))
						AS name
					FROM history 
						LEFT JOIN player 
							ON history.vuid = player.uid
						LEFT JOIN player as killer
							ON history.uid = killer.uid
					WHERE history.uid = @uid
						OR history.vuid = @uid
					ORDER BY time DESC;";

		$results = mysqli_multi_query($sql, $query);
		mysqli_next_result($sql);

		$result = mysqli_store_result($sql);
		$names = array();
		for($i = 0; $i < mysqli_num_rows($result); $i++)
		{
			$rowset = mysqli_fetch_assoc($result);
			array_push($names, $rowset['name']);
		}

		return buildHist($stat, $names);
	}

	function getStatus($sql)
	{
		$query = "SELECT * FROM history
		LEFT JOIN player
		ON history.vuid = player.uid 
		WHERE history.vuid = '" . $_POST['uid'] . "' 
		OR (player.first = '" . $_POST['fn'] . "' 
		AND player.last = '" . $_POST['ln'] . "');";
		$result = mysqli_query($sql, $query);
		if($result && mysqli_num_rows($result) > 0) 
			return 0;
		else
			return 1;
	}

	function getTargetStr($name)
	{
		if($_SESSION['type'] == "Moderator"
			|| strcasecmp($_POST['uid'], $_SESSION['uid']) == 0 
			|| (strcasecmp($_POST['fn'], $_SESSION['first']) == 0
				&& strcasecmp($_POST['ln'], $_SESSION['last']) == 0))
			return $name;
		else
		{
			$parts = explode(" ", $name, 2);
			return strtoupper($parts[0][0] . ". " . $parts[1][0] . ".");
		}
	}

	function createUnknownStr()
	{
		return "Unknown Player:: ::0::N/A::The Great Beyond::M. C. Escher::"
			. buildHist(0, array("The Honors Program"));
	}

	include 'dbconnect.php';

	$search_status = 1;

	if (mysqli_connect_errno())
	{
		not_found();
		die(mysqli_connect_error());
	}

	function not_found()
	{
		global $search_status;
		$search_status = 0;
		echo createUnknownStr();
		die();
	}

	$card = array();

	$query = "";
	if(isset($_POST['uid']) || isset($_POST['fn']) && isset($_POST['ln']))
		$query = "SELECT player.uid, 
			concat(player.first, ' ', player.last) as name, 
			player.res, concat(_mod.first, ' ',  _mod.last) as mentor,
	 		concat(t.first, ' ', t.last) as target
	 		FROM player
	 		LEFT JOIN _mod
	 		ON player.mentor = _mod.uid 
	 		LEFT JOIN player AS t
	 		ON player.target = t.uid
			WHERE player.uid = '" . $_POST['uid'] . "' 
			OR (player.first = '" . $_POST['fn'] . " '
			AND player.last = '" . $_POST['ln'] . "');";
	else $search_status = 0;

	$result = mysqli_query($sql, $query);
	if($result && mysqli_num_rows($result) > 0)
	{
		$rowset = mysqli_fetch_assoc($result);
		$card['uid'] = $rowset['uid'];
		$card['name'] = $rowset['name'];
		$card['res'] = $rowset['res'];
		$card['mentor'] = $rowset['mentor'];
		$card['target'] = getTargetStr($rowset['target']);
	}else
	{
		not_found();
	}

	$card['status'] = getStatus($sql);

	echo $card['name'] . ":: ::" #TODO INTRODUCE RANK
	. $card['status'] . "::" 
	. ($card['status'] == "1" ? $card['target'] : "N/A") . "::" 
	. $card['res'] . " Hall::" 
	. $card['mentor'] . "::" 
	. getHistory($sql, $card['uid'], $card['status']);

	mysqli_close($sql);
?>