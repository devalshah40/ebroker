function formValidator(){
	// Make quick references to our fields
	var name = document.getElementById('name');
	var address = document.getElementById('address');
	var year = document.getElementById('year');
	var contactno = document.getElementById('contactno');
	
	// Check each input in the order that it appears in the form!
	if(isAlphabet(name, "Please enter only letters for your name")){
		if(isNumeric1(contactno, "Please enter only numbers for contact number")){
			if(isAlphanumeric(address, "Please enter a valid address")){
				if(isNumeric(year, "Please enter a valid year") && lengthRestriction1(year,4)){
							return true;
						
				}
			}
		}
	}
	return false;
}

var checked=false;
function checkAll()
{
var field=document.getElementsByName("details[]");
	 if (checked == false)
          {
           checked = true;
          }
        else
          {
          checked = false;
          }
	for (var i =0; i < field.length; i++) 
	{
	field[i].checked = checked;
	}
}

function notEmpty(elem, helperMsg){
	if(elem.value.length == 0){
		alert(helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	return true;
}

function isNumeric(elem, helperMsg){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function isNumeric1(elem, helperMsg){
	var numericExpression = /^[0-9\+-]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function isAlphabet(elem, helperMsg){
	var alphaExp = /^[a-zA-Z\s']+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function isAlphanumeric(elem, helperMsg){
	var alphaExp = /^[0-9a-zA-Z\s\.,;-]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function lengthRestriction1(elem, min){
	var uInput = elem.value;
	if(uInput.length == min){
		return true;
	}else{
		alert("Please enter 4 digits for year");
		elem.focus();
		return false;
	}
}
