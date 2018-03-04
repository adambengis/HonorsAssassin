<?php
if(session_status() == PHP_SESSION_ACTIVE) 
{
    session_destroy();
}

session_start();

include 'randStr.php';

$_SESSION['salt'] = randStr(16);
	/*if($_SESSION['type'] == "assassin")
		header("Location: assassin.php");
	else if($_SESSION['type'] == "mod")
		header("Location: mod.php");*/
?>
<!DOCTYPE html>
<html>
<?php include "head.php" ?>
<body>
	<?php include "header.php"; ?>
	<div id="body">
		<div class="main-panel">
			<?php
			 	//Portal Buttons
				include "portal.html";
				//Assassin Login
				include "alogin.php";
				//Mod Login
				include "mlogin.php";
			?>
			<input id="salt" type="hidden" value=<?php echo '"' . $_SESSION['salt'] . '"'; ?>>
		</div>
	</div>
</body>
</html>