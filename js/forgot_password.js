function formValidator() {
            // Make quick references to our fields
            var email_id = document.getElementById('email_id');
			if (emailValidator(email_id, "Please enter a valid email id")) {
								return true;
				}
            return false;
}   

function emailValidator(elem, helperMsg){
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.value.match(emailExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}