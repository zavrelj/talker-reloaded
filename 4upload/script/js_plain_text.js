function smile(id) {
	document.postform.formMessageContent.focus();
	if (id==6) {
		document.postform.formMessageContent.value=document.postform.formMessageContent.value + ' [img=style/' + document.postform.css.value + '/smile/01.png]:-)[/img] ';		
	}
	if (id==7) {
		document.postform.formMessageContent.value=document.postform.formMessageContent.value + ' [img=style/' + document.postform.css.value + '/smile/02.png](vztek)[/img] ';		
	}
	if (id==8) {
		document.postform.formMessageContent.value=document.postform.formMessageContent.value + ' [img=style/' + document.postform.css.value + '/smile/03.png]:-([/img] ';		
	}
	if (id==9) {
		document.postform.formMessageContent.value=document.postform.formMessageContent.value + ' [img=style/' + document.postform.css.value + '/smile/04.png]:-*[/img] ';		
	}
	if (id==10) {
		document.postform.formMessageContent.value=document.postform.formMessageContent.value + ' [img=style/' + document.postform.css.value + '/smile/05.png]:-P[/img] ';		
	}
	if (id==11) {
		document.postform.formMessageContent.value=document.postform.formMessageContent.value + ' [img=style/' + document.postform.css.value + '/smile/06.png]:-O[/img] ';		
	}
	if (id==12) {
		document.postform.formMessageContent.value=document.postform.formMessageContent.value + ' [img=style/' + document.postform.css.value + '/smile/07.png](pl·Ë)[/img] ';		
	}
	if (id==13) {
		document.postform.formMessageContent.value=document.postform.formMessageContent.value + ' [img=style/' + document.postform.css.value + '/smile/08.png](stud)[/img] ';		
	}
	if (id==14) {
		document.postform.formMessageContent.value=document.postform.formMessageContent.value + ' [img=style/' + document.postform.css.value + '/smile/09.png]:-/[/img] ';		
	}
	if (id==15) {
		document.postform.formMessageContent.value=document.postform.formMessageContent.value + ' [img=style/' + document.postform.css.value + '/smile/10.png]:-D[/img] ';		
	}
	if (id==16) {
		document.postform.formMessageContent.value=document.postform.formMessageContent.value + ' [img=style/' + document.postform.css.value + '/smile/11.png];-)[/img] ';		
	}
}

function tag(id) {
	document.postform.formMessageContent.focus();
	if (id==0) {
		if (document.postform.jscript_room_name.value=="") {
			document.postform.formMessageContent.value=document.postform.formMessageContent.value + '[url]room.php?roomid=' + document.postform.jscript_room_id.value + '[/url]';
		}else{	
			document.postform.formMessageContent.value=document.postform.formMessageContent.value + '[url=room.php?roomid=' + document.postform.jscript_room_id.value + ']' + document.postform.jscript_room_name.value + '[/url]';	
		}	
	}
	
	if (id==1) {
		if (document.postform.jscript_name.value=="") {
			document.postform.formMessageContent.value=document.postform.formMessageContent.value + '[url]' + document.postform.jscript_href.value + '[/url]';	
		}else{	
			document.postform.formMessageContent.value=document.postform.formMessageContent.value + '[url=' + document.postform.jscript_href.value + ']' + document.postform.jscript_name.value + '[/url]';	
		}	
	}
	if (id==2) {
		if (document.postform.jscript_alt.value=="") {
			document.postform.formMessageContent.value=document.postform.formMessageContent.value + '[img]' + document.postform.jscript_src.value + '[/img]';
		}else{
			document.postform.formMessageContent.value=document.postform.formMessageContent.value + '[img=' + document.postform.jscript_src.value + ']' + document.postform.jscript_alt.value + '[/img]';
		}	
	}
}
