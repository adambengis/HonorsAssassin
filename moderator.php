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
			0 PENDING
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
		<div id="modverify" class="box-option content-box menu-box gold-border" onclick="menuClick.call(this)">
			<div class="box-title">Verify Sticks</div>
			<div class="box-content">
				<div class="box-desc">
					Check uploaded sticks against reference photos.
				</div>
			</div> 
		</div>
		<div id="RAWRRRRR" class="box-option content-box menu-box gold-border" onclick="menuClick.call(this)">
			<div class="box-title">Something Else</div>
			<div class="box-content">
				<div class="box-desc">
					I will eventually put something here.
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
	</div>
</body>
</html>