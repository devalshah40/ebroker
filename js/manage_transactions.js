function formValidator(){
	// Make quick references to our fields
	
	var transaction_date = document.getElementById('transaction_date');
	var client = document.getElementById('client');
	var vendor = document.getElementById('vendor');
	var description = document.getElementById('description');
	var billingamount = document.getElementById('billingamount');
	var payableamount = document.getElementById('payableamount');
	var payabledate = document.getElementById('payabledate');
	var brokerage = document.getElementById('brokerage');
	
	// Check each input in the order that it appears in the form!
	if(notEmpty(transaction_date, "Please enter a valid transaction date")){
		if(madeSelection(client, "Please choose client")){
			if(madeSelection(vendor, "Please choose vendor")){
				if(isAlphanumeric(description, "Please enter a valid description")){
					if(isNumeric(billingamount, "Please enter a valid billing amount")){
						if(isNumeric(payableamount, "Please enter a valid payment amount")){
							if(checkamount(billingamount,payableamount,"Payment amount must be less than Billing Amount")){
								if(notEmpty(payabledate, "Please enter a valid payment date") && comparedates(transaction_date,payabledate,"Payment date must be greater than Transaction date")){
									if(checkRadio("TRANSCATIONFORM","PAYABLE_STATUS","Please enter a valid payment status")){
										if(isNumeric(brokerage, "Please enter only numbers for brokerage")){
											return true;
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	return false;
}

function formValidator1(){
	var transaction_date = document.getElementById('day1');
	var payabledate = document.getElementById('day2');
	
	if(notEmpty(transaction_date, "Please select a valid day1"))
	{
		if(notEmpty(payabledate, "Please select a valid day1"))
		{
				return true;
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

function notEmpty(elem, helperMsg){
	if(elem.value.length == 0){
		alert(helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	return true;
}

function checkamount(billingamount ,paybaleamount ,helperMsg){

var x=billingamount.value;
var y=paybaleamount.value;
		if(parseInt(y)<= parseInt(x))
		{
			return true;
		}
		else
		{
			alert(helperMsg);
			paybaleamount.focus(); // set the focus to this input
			return false;
		}
}

function isNumeric(elem, helperMsg){
	var numericExpression = /^[0-9\s.]+$/;
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
		alert("Please enter 4 digits for year");
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
function comparedates(year1,year2,helperMsg) 
{ 
   var date1 = new Date(year1.value); 
   var date2 = new Date(year2.value); 
   if(date2 < date1){
		alert(helperMsg);
        year2.focus();
        return false;
   } 
   else { 
        return true;
   } 
 } 