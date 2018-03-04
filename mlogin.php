<div id="mod-login" class="inv panelcontent content-box horz-center login">
	<div id="login-title" class="box-title">Mod Login</div>
	<span id="form-error">***One or more inputs are incorrect.***</span>
	<div class="login-grid">
		<span class="inprompt">User ID:</span>
		<input type="text" name="UID" maxlength="7" onkeypress="seeksubmit(event, '_mod')" class="input"> 
		<span class="inprompt">Last Name:</span>
		<input type="text" name="lastname" onkeypress="seeksubmit(event, '_mod')" class="input">
		<span class="inprompt">Password:</span>
		<input type="password" name="password" maxlength="24" onkeypress="seeksubmit(event, '_mod')" class="input">
		<input type="button" value="Submit" class="horz-center subbox goldhover" onclick="safesubmit('_mod')">
	</div>
</div>