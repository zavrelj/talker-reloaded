function submitIt() {
	document.logout.submit();
}



function submitKlub(name) {
	eval('document.'+name+'.submit()');
}



function onIco(name) {
	eval('document.postform.formReceiverName.value="'+name+'"');
	eval('document.images.messagetoico.src="ico/'+name+'.gif"');
}



function changeIt() {
	name=document.postform.selectfriend.options[document.postform.selectfriend.selectedIndex].value;
	if (name == "x") {
		eval('document.postform.formReceiverName.value=""');
	}else{
		eval('document.postform.formReceiverName.value="'+name+'"');
	}
	eval('document.images.messagetoico.src="ico/'+name+'.gif"');
}



function findUser() {
	val=document.postform.formReceiverName.value;
	eval('document.images.messagetoico.src="ico/'+val+'.gif"');
}



function changeItSkin(form, skinselect, skininput) {
	colorcode=eval('document.'+form+'.'+skinselect+'.options[document.'+form+'.'+skinselect+'.selectedIndex].value');
	eval('document.'+form+'.'+skininput+'.value="'+colorcode+'"');
}



function showHelp(filename) {
	eval('window.open("'+filename+'", "", "left=140,top=40,width=300,height=400")');
}

function showNet(url) {
	eval('window.open("'+url+'", "", "")');
}

function checkAutoLgtValue() {
	var autoLgtValue=document.autologoutform.autologout.value;
	if (autoLgtValue >=300 && autoLgtValue <=1200) {
		document.autologoutform.submit();
	}else{
		alert('Pozor, zadaná hodnota neodpovídá požadovanému rozsahu !');
		document.autologoutform.autologout.value="";
	}
}

function checkRowNumValue() {
	var rowNumValue=document.rownumform.rownum.value;
	if (rowNumValue >= 1) {
		document.rownumform.submit();
	}else{
		alert('Pozor, zadaná hodnota je neplatná, poèet øádkù musí být kladný !');
		document.rownumform.rownum.value="";
	}
}


function reply(user, timetext) {
	document.postform.messagetext.focus();
	document.postform.messagetext.value=document.postform.messagetext.value + user + ' ' + timetext + ' ';  
}





//DEPRECATED

function msgMailbox(url) {
	 eval('window.location.href="' + url + '"');
}

function msgUserInfo(url) {
	 eval('window.location.href="' + url + '"');
}

function msgFriends(url) {
	 eval('window.location.href="' + url + '"');
}

//DEPRECATED







function selectAll(item) {
	eval(+ item +'.focus()');
	eval(+ item +'.select()');
}


function msgReplyPlainText(user, timetext) {
	document.postform.formMessageContent.focus();
	document.postform.formMessageContent.value=document.postform.formMessageContent.value + user + ' ' + timetext + ' ';
}

function msgReplyTinyMCE(user, timetext) {
	tinyMCE.execCommand('mceInsertContent', false, ' ' + user + ' ' + timetext + '');
      document.postform.formMessageContent.focus();
	document.postform.formMessageContent.value=document.postform.formMessageContent.value + user + ' ' + timetext + ' ';
}

function msgReplyWYSIWYG(user, timetext) { 
	var html;
 
	html = user + ' ' + timetext + ' ';
	self.insertHTML(html);
}


function selectInvertMsg(formName, elementName) { //vyber doplnek

	formElement = document.getElementById(formName);
	if (formElement == null) return false;

	for (var i = 0; i <= formElement.length-1; i++) 	{
		if (formElement.elements[i].name == elementName) {
			formElement.elements[i].checked = !formElement.elements[i].checked;
		}
        }

	return false;
}

function selectRangeMsg(formName, elementName) {
	formElement = document.getElementById(formName);
	if (formElement == null) return false;

	for (var i = 0; i <= formElement.length; i++) {
		if (formElement.elements[i].name == elementName) {

			if (formElement.elements[i].checked) {
				while (formElement.elements[i].name == elementName) {
					formElement.elements[i].checked = !formElement.elements[i].checked;
				
					if (formElement.elements[++i].checked) {
						formElement.elements[i].checked = !formElement.elements[i].checked;
						return false;
					}	
				}
			}
		}	
    }
    
    return false;
}

function selectAllMsg(formName, elementName) {//vyber vse

	formElement = document.getElementById(formName);
	if (formElement == null) return false;
	
	for (var i = 0; i <= formElement.length-1; i++)
 	{
		if (formElement.elements[i].name == elementName) {
			formElement.elements[i].checked = true;
		}	
        }

	return false;
}

function unselectAllMsg(formName, elementName) {//odznac vse

	formElement = document.getElementById(formName);
	if (formElement == null) return false;
	
	for (var i = 0; i <= formElement.length-1; i++)
 	{
		if (formElement.elements[i].name == elementName) {
			formElement.elements[i].checked = false;
		}	
        }

	return false;
}


function delOneMsg(formName, elementName, dateValue) {//automaticky oznaci a smaze jeden prispevek
	//vytahneme si typ formularoveho prvku podle jeho id
	formElement = document.getElementById(formName);
	//pokud je typ prazdny, ukonci beh
	if (formElement == null) return false;
	
	//provede cyklus pro vsechny prvky v elementu s vyjimkou tech, ktery se jmeuji jinak, nez
	//pozadovany element
	for (var i = 0; i <= formElement.length-1; i++) {
		if (formElement.elements[i].name == elementName) {
			if (formElement.elements[i].value == dateValue) {
				formElement.elements[i].checked = true;
			}else{
				formElement.elements[i].checked = false;
			}
		}
        }
	
	//odesle formular
	eval('document.'+formName+'.submit()');
}




