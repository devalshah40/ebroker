function formValidator() {
            // Make quick references to our fields
            var username = document.getElementById('username');
            var password = document.getElementById('password');
			
			
			if (isAlphanumeric(username, "Please enter a valid username")) {
                if (notEmpty(password, "Please enter a valid password")) {
								return true;
                }
            }
            return false;
        }   
		
        function notEmpty(elem, helperMsg) {
            if (elem.value.length == 0) {
                alert(helperMsg);
                elem.focus(); // set the focus to this input
                return false;
            }
            return true;
        }
		
        function isAlphanumeric(elem, helperMsg) {
            var alphaExp = /^[0-9a-zA-Z]+$/;
            if (elem.value.match(alphaExp)) {
                return true;
            } else {
                alert(helperMsg);
                elem.focus();
                return false;
            }
        }

      