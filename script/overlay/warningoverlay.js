
//Event.observe(window, 'load', showNewPlayerLightbox, false);

function showNewPlayerLightbox(note){
	//debugger;
	//alert(note);
      
      link = document.createElement('a');
	link.href = currentBaseUrl + 'warningoverlay.php?note=' + note;
	link.className = "lbOn";
	var valid = new lightbox(link);
	valid.activate();
	
}

//used for the new user lightbox OnKeyPress event

function newUserIEKeyPress()
{
	if (window.event.keyCode == 13)
	{
		newUserValidateAndRedirect();
	}
}
function newUserNSKeyPress(e)
{
	if (e.which == 13)
	{
		newUserValidateAndRedirect();
	}
}
function newUserValidateAndRedirect()
{
	var inputBox = $('newPlayerTicker');
		
	if (inputBox.value.length == 0 || inputBox.value == 'Enter Ticker Symbol')
	{
		var error = $('newUserRatingError');
		error.style.display = 'block';
	}
	else
	{
		window.location = 'Ticker.aspx?ticker=' + inputBox.value; 
	}
}

//Display A Compnay LookUp Popup 
  function popWin(textBoxClientSideID)
  {
	var popUpFormURL = "PopUpCompanyPicker.aspx?openwithoutdisplayingerrormessage=true&ws=a&TextBoxClientSideID=" + textBoxClientSideID;
	window.open(popUpFormURL,"","width=425,height=705");
	return false;
  }
  
//This Function Will Update the Ticker Selection Box With
//With the value of the selected ticker.	
function UpdateTicker(selectedTicker)
{
   var tickerTextBox = GetElementByTagNameAndId('newPlayerTicker', 'INPUT');
   tickerTextBox.value = selectedTicker;
}


