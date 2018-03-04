<?php session_start(); ?>
<html>
<?php include "head.php" ?>
<body>
	<?php include "header.php" ?>
	<div class="menu-panel horz-center">
		<h2>
			<span class="goldtext">::</span> 
			<?php echo strtoupper($_SESSION['res']); ?>
			<span class="goldtext">//</span> 
			<?php echo strtoupper($_SESSION['first'] . " " . $_SESSION['last']); ?>
			<span class="goldtext">//</span> 
			0 STICKS
			<span class="goldtext">::</span> 
		</h2>
		<script type="text/javascript">
			function menuClick()
			{
				var btns = document.getElementsByClassName('menu-box');
				for(var i = 0; i < btns.length; i++)
				{
					btns[i].onclick = false;
				}

				var body = document.getElementsByClassName('menu-panel')[0];
				var text = document.getElementsByTagName('h2')[0];
				fade(this, -1);
				setTimeout(function(){
					fade(body, -1);
					fade(text, -1);
				}, 500);
				setTimeout(function(id){
					window.location = id + ".php";
				}, 1000, this.id);
			}
		</script>
		<div id="verify" class="box-option content-box menu-box gold-border" onclick="menuClick.call(this)">
			<div class="box-title">Request Stick Verification</div>
			<div class="box-content">
				<div class="box-desc">
					Upload a photo of your target to HQ for processing.  
				</div>
			</div> 
		</div>
		<div id="stats" class="box-option content-box menu-box gold-border" onclick="menuClick.call(this)">
			<div class="box-title">View Player Stats</div>
			<div class="box-content">
				<div class="box-desc">
					Check out your playercard or search for others!
				</div>
			</div> 
		</div>
		<div id="optout" class="box-option content-box menu-box gold-border" onclick="menuClick.call(this)">
			<div class="box-title">Dishonorable Discharge</div>
			<div class="box-content">
				<div class="box-desc">
					Request to be terminated early from the program.
				</div>
			</div> 
		</div>
	</div>
</body>
</html>