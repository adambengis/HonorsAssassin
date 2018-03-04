<?php session_start(); ?>
<!DOCTYPE html>
<html>
<?php include "head.php" ?>
<body>
	<?php include "header.php"; ?>
	<div id="verify-box" class="content-box horz-center">
		<div class="box-title">Stick Verification</div>
		&emsp;&emsp;Hi <?php echo $_SESSION['first'] ?>! Please fill out this form so a game moderator may process your submission.
		<div id="verify-grid">
			<span class="inprompt right-align">Target Name:</span>
			<input type="text" name="target" onkeypress="checksubmit(event)" class="input" disabled="disabled" value=<?php echo "'" . $_SESSION['target'] . "'" ?>>
			<span class="inprompt right-align">Stick Location:</span>
			<input type="text" name="target" maxlength="64" onkeypress="checksubmit(event)" class="input">
			<span class="inprompt right-align">Stick Time:</span>
			<div id="datetime">
				<input id="date" type="date" name="target" onkeypress="checksubmit(event)" class="input">
				<input id="time" type="time" name="target" onkeypress="checksubmit(event)" class="input"> 
			</div>
			<span class="inprompt right-align">Photo Upload:</span>
			<input id="fileup" type="file" name="img" onkeypress="checksubmit(event)" onchange="loadfile(event)" class="input">
			<img id="stickphoto" class="horz-center" alttext="Stick Photo">
			<button id="sticksend" type="button" onclick="stickprepsend()" class="goldhover subbox">Submit</button>
			<script type="text/javascript">
				var regDate = /2018-\d{2}-\d{2}/;
				var regLoc = /[^\w ]/;

				var oldload = window.onload;
				window.onload = new function(){
					oldload();
					var date = new Date();
					document.getElementById('date').valueAsDate = date; 
					document.getElementById('time').defaultValue = 	 	
						("00" + date.getHours()).substr(-2,2) 
						+ ":" + ("00" + date.getMinutes()).substr(-2,2);
				};
 			 	function loadfile(event)
 			 	{
				    var output = document.getElementById('stickphoto');
				    var files = event.target.files;
				    var ext = files[0].name.split(".").pop().toLowerCase();
				    if(files.length == 0)
				    	return;
				    else if(!(ext == "png"
				    	|| ext == "jpg" || ext == "jpeg" || ext == "gif"))
				    {
				    	alert("File is not a valid type! Images must be a png, jpeg, or gif.");
				    	event.target.value = '';
				    	return;
				   	}
				    else if(files[0].size / 1048576 > 4)
				    {
				    	alert("File Size is too big! Images must be less than 4MB.");
				    	event.target.value = '';
				    	return;
				   	}
				    else
				    	output.src = URL.createObjectURL(files[0]);
				}
				function checksubmit(event)
				{
					if(isEnterKey(event.key))
					{
						stickprepsend();
					}
				}
				function stickval(loc, date)
				{
					return regDate.test(date) && !regLoc.test(loc);
				}
				function stickprepsend()
				{
					var ins = document.getElementsByClassName('input');
					var loc = ins[1].value;
					var date = ins[2].value;
					if(stickval(loc, date))
					{
						var time = ins[3].value;
						var fread = new FileReader();
						fread.readAsDataURL(ins[4].files[0]);
						fread.onload = function(event){
							var ext = ins[4].value.split('.').pop();
							var bin = encodeURIComponent(event.target.result);
							console.log(bin.length);
							console.log(ins[4].files[0].size);
							postData('stickup.php', ['loc', loc, 'dt', date, 'tm', time, 'bin', bin, 
								'ext', ext], readresult);
						};
					}
				}
				function readresult(xhttp)
				{
					var resp = xhttp.response;
					console.log('Server Returned -> ' + resp);
					if(resp.trim().startsWith('alert'))
					{
						alert(resp.split(' -> ')[1]);
					}
					else if(resp.trim() == "upload success")
					{
						alert("Upload Success!");
						window.location = "assassin.php";
					}
				}

			</script>
		</div>
	</div>
</body>
</html>