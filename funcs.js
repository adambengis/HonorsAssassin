function fade(element, inc)
{
	var pos = inc > 0;
	element.style.visibility = "visible";
	for(var i = 100; i >= 0; i -= Math.abs(inc))
	{
		setTimeout(function(t){
			element.style.opacity = pos ? 1 - (t / 100) : (t / 100);
		}, (100 - i)*5, i);
	}
	if(!pos)
	{
		setTimeout(function(){
			element.style.visibility = "hidden";
		}, 500);
	}
}

function isEnterKey(key)
{
	return key == "Enter";
}

function remove(element)
{
	element.parentNode.removeChild(element);
}

function keyvalString(data)
{
	var out = "";
	for(var i = 0; i < data.length; i += 2)
	{
		var key = data[i];
		var val = data[i+1];
		out += key + "=" + val + "&";
	}
	return out.substr(0, out.length - 1);
}

function postData(page, data, func)
{
	var payload = keyvalString(data);
	var xhttp = new XMLHttpRequest();
	var out = "";
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4) 
			func(xhttp);
	};
	xhttp.open("POST", page, true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(payload);
}