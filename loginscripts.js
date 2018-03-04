var regLn = null;
var regUid = null;
var regPin = null;
var regPass = null;
var debug = true;
var error = null;

window.onload = function(){
	regLn = /[^a-z\-']|\-\'|\-{2}|\'{2}|\-$|(.*\-.*){3}|(.*\'.*){4}/i;
	regUid = /[a-z]{2,4}\d{2,4}/i;
	regPin = /\d{4}/;
	regPass = /[^\w!@#$%^&*,\.?]/;
};

function seeksubmit(e, type)
{
	if(isEnterKey(e.key))
	{
		safesubmit(type);
	}
}

function safesubmit(type)
{
	var fields = document.getElementsByClassName('input');
	var uid = fields[0].value.toLowerCase();
	var lname = fields[1].value.toLowerCase();
	var salt = document.getElementById('salt').value;
	var valSuccess;
	error = document.getElementById('form-error');
	if(fields.length == 4)
	{
		var res = fields[2].value;
		var pin = fields[3].value;
		if((valSuccess = localValidateAssassin(uid, lname, res, pin)))
		{
			var hash = md5(salt + md5(lname + ":" + res + ":" + uid + "(" + pin + ")"));
			if(debug) console.log("POSTing -->  " + uid + " (" + lname + "): " + hash);
			postData("loginval.php", ["uid", uid, "type", type, "dt", hash], loginResult);
		}
	}
	else if(fields.length == 3)
	{
		var pass = fields[2].value;
		if((valSuccess = localValidateMod(uid, lname, pass)))
		{
			var hash = md5(salt + md5(lname + ":" + uid + "(" + pass + ")"));
			console.log("POSTing -->  " + uid + " (" + lname + "): " + hash);
			postData("loginval.php", ["uid", uid, "type", type, "dt", hash], loginResult);
		}
	}
	if(!valSuccess)
	{
		if(debug) console.log(error.style.visibility + " " + error.style.opacity);
		if(error.style.visibility == "hidden" || error.style.opacity <= 0.1)
			fade(error, 1);
	}
}

function loginResult(xhttp)
{
	if(debug) console.log(xhttp.response);
	if(xhttp.response.trim().startsWith("login success -> "))
	{
		if(error.style.visibility == "visible" && error.style.opacity >= 0.9)
			fade(error, -1);

		setTimeout(function(){
			window.location = xhttp.response.split(" -> ")[1];
		}, 500);
	}
	else if(xhttp.response == "login failed")
	{
		if(error.style.visibility == "hidden" || error.style.opacity == 0)
			fade(error, 1);
	}
}

function localValidateMod(uid, lname, pass)
{
	var fail = pass.length < 8
		|| regPass.test(pass)
		|| !localValidateAssassin(uid, lname, "", "0000");
	
	return !fail;
}

function localValidateAssassin(uid, lname, res, pin)
{
	var fail = uid.length < 4 
		|| lname.length < 2
		|| regLn.test(lname)
		|| !regUid.test(uid)
		|| !regPin.test(pin);

	return !fail;
}