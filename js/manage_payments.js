function formValidator(){
	// Make quick references to our fields
	
	var client = document.getElementById('client');
	var description = document.getElementById('description');
	var amount = document.getElementById('amount');
	var paymentdate = document.getElementById('paymentdate');
	
	// Check each input in the order that it appears in the form!
	if(madeSelection(client, "Please choose client")){
		if(isAlphanumeric(description, "Please enter a valid description")){
			if(isNumeric(amount, "Please enter a valid amount")){
				if(checkRadio("PAYMENTFORM","MODE","Please select payment mode")){
					if(notEmpty(paymentdate, "Please enter a valid paymentdate")){
							return true;
					
				}
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

function checkRadio (frmName, rbGroupName,helperMsg) {
 var radios = document[frmName].elements[rbGroupName];
 for (var i=0; i <radios.length; i++) {
  if (radios[i].checked) {
   return true;
 
  }
 }
 	alert(helperMsg);
 return false;
} 

function uncheckradio()
{
	for (var i=0; i<document.PAYMENTFORM.MODE.length; i++)
		document.PAYMENTFORM.MODE[i].checked = false;
		return true;
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
	var numericExpression = /^[0-9\.]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function isAlphabet(elem, helperMsg){
	var alphaExp = /^[a-zA-Z]+$/;
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
		alert("Please enter minimum "+min+" numbers");
		elem.focus();
		return false;
	}
}

 function madeSelection(elem, helperMsg) {
			if (elem.value == "") {
                alert(helperMsg);
                elem.focus();
                return false;
            } else {
                return true;
            }
        }
