<?php session_start(); ?>
<!DOCTYPE html>
<html>
<?php include "head.php" ?>
<body>
	<?php include "header.php"; ?>
	<div id="modverify-main" class="horz-center">
		<div id="modverify-sidebyside">
			<div class="modverify-imagebox">
				<img class="modverify-image" src="stickpics/test.png">
			</div>
			<div class="modverify-imagebox">
				<img class="modverify-image" src="stickpics/hisan.png">
			</div>
		</div>
		<div class="horz-center content-box">
			<div id="modverify-buttons">
				<span>Are these images of the same person?</span>
				<input type="button" value="Yes" class="subbox goldhover button verbtn" onclick="verify(event)">
				<input type="button" value="Maybe" class="subbox goldhover button verbtn" onclick="verify(event)">
				<input type="button" value="No" class="subbox goldhover button verbtn" onclick="verify(event)">
				<script type="text/javascript">
					var oldload = window.onload;
					window.onload = function(){
						oldload();
						postData('veract.php', ['val', '-1'], next)
					}
					function verify(e)
					{
						if(confirm("You clicked " + e.target.value + ". Are you sure?"))
							postData('veract.php', ['val', e.target.value], next);
					}
					function next(xhttp)
					{
						var resp = xhttp.response.trim();
						if(resp.startsWith('NewData:'))
						{
							var data = resp.split(":")[1].split(">>");
							var imgs = document.getElementsByTagName('img');
							imgs[0].src = data[0];
							imgs[1].src = data[1];
						}
						else if(resp == 'end')
						{
							
						}
						else if(resp.length > 0)
						{
							alert("Error! " + xhttp.response);
							return;
						}


					}
				</script>
			</div>
		</div>
	</div>
</body>
</html>