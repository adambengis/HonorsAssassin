<?php session_start(); ?>
<!DOCTYPE html>
<html>
<?php include "head.php" ?>
<body>
	<?php include "header.php" ?>
	<div id="psearch" class="horz-center content-box">
		<input type="text" id="pcard-stext" name="stext" onkeypress="checkSearch(event)" placeholder="Name or ID (abc123)" class="input">
		<input type="button" value="Search" class="subbox goldhover button" onclick="searchCard()">
	</div>
	<div id="playercard" class="content-box gold-border horz-center">
		<div>
			<div class="box-title pcard-title">
				<span id="pcard-name" class="ellipsis"></span>
				<div class="pcard-rank"><span></span></div>
			</div>
			<div class="hr"></div>
		</div>
		<div id="pcard-body">
			<div>Status: 
				<span style="color:lightgreen;">
				</span>
			</div>
			<div>Assignment: 
				<span style="color:red;">
				</span>
			</div>
			<div>Last Seen: 
				<span style="color:gold;">
				</span>
			</div>
			<div>Known Ally: 
				<span style="color:gold;">
				</span>
			</div>
			<br />
			<span class="horz-center"><u>History</u></span>
			<div id="pcard-history">
				<span></span>
			</div>
		</div> 
		<script type="text/javascript">
			var oldload = window.onload;
			window.onload = function()
			{
				oldload();
				<?php
					if($_SESSION['type'] == "Assassin")
					{
						echo "postData('cardsearch.php', ['uid', '" . $_SESSION['uid'] . "'], popCard);";
					}
				?>
				
			}
			function inputInvalid()
			{
				var sbox = document.getElementById("pcard-stext");
				sbox.style.borderColor = "red";
			}
			function resetBorder()
			{
				var sbox = document.getElementById("pcard-stext");
				sbox.style.borderColor = "#fc6";
			}
			function checkSearch(e)
			{
				if(isEnterKey(e.key))
					searchCard();
			}
			function searchCard()
			{
				var sbox = document.getElementById("pcard-stext");
				var term = sbox.value.trim();
				if(regUid.test(term) && term.length >= 5)
					postData("cardsearch.php", ["uid", term.toLowerCase(), 'fn', '', 'ln', ''], popCard);
				else if(!regLn.test(term.replace(" ", "")) && term.length > 5)
				{
					term = term.split(" ");
					postData("cardsearch.php", ['uid', '', "fn", term[0], "ln", term[1]], popCard);
				}
				else inputInvalid();
			}
			function popCard(xhttp)
			{
				var data = xhttp.response.split("::");
				if(data[0] == "Unknown Player") inputInvalid();
				else resetBorder();
				var spans = document.getElementsByTagName('span');
				spans[2].innerText = data[0];
				spans[3].innerText = data[1];
				if(parseInt(data[2]))
				{
					spans[4].style.color = "lightgreen";
					spans[4].innerText = "Active";			
				} 
				else{
					spans[4].style.color = "red";
					spans[4].innerText = "Terminated";
				}
				spans[5].innerText = data[3];
				spans[6].innerText = data[4];
				spans[7].innerText = data[5];
				spans[9].innerHTML = data[6];
			}
		</script>
	</div>
</body>
</html>