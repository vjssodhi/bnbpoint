/* Beauty Contact Popup form */

var http_req = false;
function TagPopupPOSTRequest(url, parameters) 
{
	
  http_req = false;
  if (window.XMLHttpRequest) 
  {
	 http_req = new XMLHttpRequest();
	 if (http_req.overrideMimeType) 
	 {
		http_req.overrideMimeType('text/html');
	 }
  } 
  else if (window.ActiveXObject) 
  {
	 try 
	 {
		http_req = new ActiveXObject("Msxml2.XMLHTTP");
	 } 
	 catch (e) 
	 {
		try 
		{
		   http_req = new ActiveXObject("Microsoft.XMLHTTP");
		} 
		catch (e) {}
	 }
  }
  if (!http_req) 
  {
	 alert('Cannot create XMLHTTP instance');
	 return false;
  }
  http_req.onreadystatechange = TagPopupContents;
  http_req.open('POST', url, true);
  http_req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http_req.setRequestHeader("Content-length", parameters.length);
  http_req.setRequestHeader("Connection", "close");
  http_req.send(parameters);
}

function TagPopupContents() 
{
	//alert("here...");
  //alert(http_req.readyState);
 // alert(http_req.responseText);
  if (http_req.readyState == 4) 
  {
	 if (http_req.status == 200) 
	 {
		result = http_req.responseText;
		
		result = result.trim();
		if(result == "invalid-email")
		{
			//alert("Invalid email address.");
			document.getElementById('TagPopup_alertmessage').innerHTML = "Invalid email address.";   
		}
		else if(result == "there-was-problem")
		{
			//alert("There was a problem with the request.");
			document.getElementById('TagPopup_alertmessage').innerHTML = "There was a problem with the request.";   
		}
		else if(result == "mail-sent-successfully")
		{
			//alert("Mail sent successfully");
			document.getElementById('TagPopup_alertmessage').innerHTML = "Details submitted successfully";   
			document.getElementById("TagPopup_mail").value = "reena.chandel@itfiww.com";
			document.getElementById("TagPopup_name").value = "reena";
			document.getElementById("TagPopup_message").value = "testing";
		}
		else
		{
			//alert("There was a problem with the request.");
			document.getElementById('TagPopup_alertmessage').innerHTML = "There was a problem with the request.";   
		}
	 } 
	 else 
	 {
		//alert('There was a problem with the request.');
		document.getElementById('TagPopup_alertmessage').innerHTML = "There was a problem with the request.";   
	 }
  }
}

function TagPopup_Submit(obj, url) 
{
	_e=document.getElementById("TagPopup_cat");
	_n=document.getElementById("TagPopup_start");
	_m=document.getElementById("TagPopup_end");
	_c=document.getElementById("bday");
	_s=document.getElementById("TagPopup_kids");
	_s1=document.getElementById("TagPopup_year");
	if(_n.value=="")
	{
		alert("Please Enter Your Name.");
		_n.focus();
		return false;    
	}
	else if(_e.value=="")
	{
		alert("Please Enter Your Email.");
		_e.focus();
		return false;    
	}
	
	else if(_m.value=="")
	{
		alert("Please Enter Your Message.");
		_m.focus();
		return false;    
	}
	/*else if(_c.value=="")
	{
		alert("Please Enter the Captcha.");
		_c.focus();
		return false; 
	}*/
		
	
	
	document.getElementById('TagPopup_alertmessage').innerHTML = "Sending..."; 
	var str = "TagPopup_cat=" + encodeURI( document.getElementById("TagPopup_cat").value ) + "&TagPopup_start=" + encodeURI( document.getElementById("TagPopup_start").value ) + "&TagPopup_end=" + encodeURI( document.getElementById("TagPopup_end").value ) + "&bday=" + encodeURI( document.getElementById("bday").value ) + "&TagPopup_kids=" + encodeURI( document.getElementById("TagPopup_kids").value ) + "&TagPopup_year="+ encodeURI( document.getElementById("TagPopup_year").value );
	TagPopupPOSTRequest(url+'/?tagpopup=send-mail', str);
	
}

