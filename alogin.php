<div id="assassin-login" class="inv panelcontent content-box horz-center login">
	<div id="login-title" class="box-title">Assassin Login</div>
	<span id="form-error">***One or more inputs are incorrect.***</span>
	<div class="login-grid">
		<span class="inprompt">User ID:</span>
		<input type="text" name="UID" maxlength="7" onkeypress="seeksubmit(event, 'player')" class="input"> 
		<span class="inprompt">Last Name:</span>
		<input type="text" name="lastname" onkeypress="seeksubmit(event, 'player')" class="input">
		<span class="inprompt">Residence Hall:</span>
		<select name="res" onkeypress="seeksubmit(event, 'player')" class="input">
			<option>Caneris</option>
			<option>Kelly</option>
			<option selected="true">Millennium</option>
			<option>Myers</option>
			<option>North</option>
			<option>Race</option>
			<option>Stiles</option>
			<option>Van R</option>
		</select> 
		<span class="inprompt">Secret Pin:</span>
		<input type="password" name="pin" maxlength="4" onkeypress="seeksubmit(event, 'player')" class="input">
		<input type="button" value="Submit" class="horz-center subbox goldhover" onclick="safesubmit('player')">
	</div>
</div>