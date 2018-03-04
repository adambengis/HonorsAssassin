<?php session_start(); ?>
<!DOCTYPE html>
<html>
<?php include "head.php" ?>
<body>
	<?php include "header.php"; ?>
	<div id="body">
		<div id="opt-panel" class="panelcontent content-box horz-center">
			<div id="login-title" class="box-title horz-center">Dishonorable Discharge</div>
			<div>
				<div id="discharge-text" class="horz-center">
					<i>Please acknowledge the following:</i> <br /><br />
					blah blah blah blah blah, you won't ever be allowed back due to reasons, we will continue to store your information for a few days, yadda yadda yadda, any questions email drexelauto. This will remove all access to account <?php echo $_SESSION['uid']; ?>.
					<br /><br />
					<div id="optoutcheck">
						<input id="check" type="checkbox" class="horz-center subbox goldhover input">
						<div style="width:1em;"></div>
						<label>I confirm that I have read and understand the terms above.</label>
					</div>
				</div>
				<div id="confirm">
					<script type="text/javascript">
						function cancel()
						{
							window.location = "assassin.php";
						}
						function finish(xhttp)
						{
							console.log(xhttp.response);
							if(xhttp.response == "success")
								window.location = "home.php";
							else
								cancel();
						}
						function optout()
						{
							var box = document.getElementById('check');
							if(box.checked)
							{
								var del = document.getElementById('del');
								postData("rm.php", ["conf", del.value], finish);
							}
							else
								document.getElementById('optoutcheck').style.color = "red";
						}
					</script>
					<input type="button" value="Cancel" class="horz-center subbox goldhover input conf-button" onclick="cancel()">
					<input type="button" value="I Want Out" class="horz-center subbox goldhover input conf-button" onclick="optout()">
					<input type="hidden" id="del" value=<?php echo $_SESSION['del']; ?>>
				</div>
			</div>
		</div>
	</div>
</body>
</html>