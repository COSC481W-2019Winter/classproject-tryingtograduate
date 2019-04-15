function setStorage(){			
			var trUsername = document.querySelector('input[id=username]').value;			
			localStorage.setItem("user", trUsername);		
		}	
	
		function loginCheck(){		
		var trUsername = document.querySelector('input[id=username]').value;
		//var trUsername = localStorage.getItem('user');
		var para = document.createElement("P");		
		var loggedIn = document.createTextNode("Welcome back " + localStorage.getItem("user") + "!");		
		var pleaseLogIn = document.creatTextNode("Please go register for the club!");			
			if(trUsername !== null){			
				para.appendChild(loggedIn);			
				document.getElementById("login").appendChild(para);						
			}			
		para.appendChild(pleaseLogIn);			
		document.getElementbyId("login").appendChild(pleaseLogIn);		
		}		

		function checkUsernameAndPassword(){
		//for the username and password I set conditions that only letters, numbers, "$", "&", and "_"	could be used
		//I limited the length to between 8 and 14 characters
		var unameAndPwdRegex = /^[a-zA-Z0-9$&_]{8,14}$/;			
		var validUsername = document.getElementById('username').value.match(unameAndPwdRegex);			
		var validPwd = document.getElementById('password').value.match(unameAndPwdRegex);				
			if(validUsername === null || validPwd === null ){			
				alert("Your username and/or password are not valid. Only characters A-Z, a-z, 0-9, &, $ and '_' are  acceptable.");				
				return false;				
			}			
		return true;		
		}
		
		function validateFirstAndLastName(){
		//I started with this:		
		//var nameRegex = /^[a-zA-Z\-]+$/;
		//then realized I needed to include "'"," ",","and"." I escaped the "-" because otherwise it means a range
		//oddly I don't have to escape the "."
		//this only works with standard western letters and no international symbols
		//I am not sure how to address those
		//I chose not to include digits
		//Ultimately I am not sure that validating names is the best idea
		//the ^ just means "at the beginning"
		//the $ means at the end 
		// the "+" means one or more of the previous character	
		var nameRegex = /^[a-zA-Z .\-',]+$/;
		var validFirstName = document.getElementById('fname').value.match(nameRegex);			
		var validLastName = document.getElementById('lname').value.match(nameRegex);				
			if(validFirstName === null){				
				alert("Your first name is not valid. Only characters A-Z, a-z and '-' are  acceptable.");				
				return false;				
			}				
			if(validLastName === null){				
				alert("Your last name is not valid. Only characters A-Z, a-z and '-' are  acceptable.");				
				return false;				
			}				
			return true;		
		}
		
		function validateEmail(){
		//email is kind of a nightmare, I tried to generally get most emails 
		//the first section of the email can have between 1-20 characters--letters, numbers, ".","_","%","+" and"-"
		// then an "@"
		//the second section can have between 1-20 characters--letters, numbers, ".",and"-"
		//then a "."
		//then 2-20 letters 			
		var emailRegex = /^[a-zA-Z0-9._%+\-]{1,20}@[a-zA-Z0-9.\-]{1,20}\.[a-zA-Z]{2,20}$/;			
		var validEmail = document.getElementById('email').value.match(emailRegex);				
			if(validEmail === null){				
				alert("Your email address is not valid.");				
				return false;				
			}			
			return true;		
		}
		
		function validateDob(){
		//first group which translates to mm
		//([1][012]{1}|[1-9]{1}|[0][1-9]{1})
		//one of 1 and 1 of 0,1,or2 OR 1 of 1-9 OR 0 and 1 of 1-9
		//then "/"," ", or "-"
		//then (([0][1-9]{1})|([12]{1}[0-9]{1})|([3][01]{1}))
		//0 and one of 1-9 OR one of 1or2 and 1 of 0-9 OR 3 and one of 1 or 0
		//then "/"," ", or "-"
		//then ((19|20)([0-9]{1}[0-9]{1}))
		//19 or 20 AND one 0-9 and one 0-9	
		var dobRegex = /^((?:[1][012]{1}|[1-9]{1}|[0][1-9]{1})[\/ \-](([0][1-9]{1})|(?:[12]{1}[0-9]{1})|([3]{1}[01]{1}))[\/ \-]((19|20)([0-9]{1}[0-9]{1})))$/;			
		var validDob = document.getElementById('dob').value.match(dobRegex);			
		console.log(validDob);				
			if(validDob === null){				
				alert("Your date of birth is not valid or you did not enter it in the correct format.");				
				return false;				
			}			
			return true;	
		}
		
		function validateCreditCardNumber(){
		//Visa cards always start w/ 4, they may have 13, 16 or 19 digits 
		//I used wikipedia to find out about credit card numbers
		//https://en.wikipedia.org/wiki/Payment_card_number#Major_Industry_Identifier_.28MII.29
		//this looks for the 4
		//then 12 digits from 0-9
		//(?:[0-9]{3})? this means match zero or one time 3 numbers from 0-9
		//I put that in 2x to get either specifically 16 or 19 digits
		var ccnVisaRegex =/^4[0-9]{12}(?:[0-9]{3})?(?:[0-9]{3})?$/;
		//Mastercards start with either 51-55 OR 2221 through 2720 and have 16 digits
		//this breaks this into groups 51-55 w/ 2 digits OR 222+[1-9] OR 22[3-9][0-9], etc. to get the range from 2221 to 2720
		//it then adds 12 digits at the end after the groups of 4 digits
		var ccnMasterRegex = /^(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}$/;
		var validVisaCcn = document.getElementById('ccn').value.match(ccnVisaRegex);			
		var validMasterCcn = document.getElementById('ccn').value.match(ccnMasterRegex);			
			if(validVisaCcn=== null || validMasterCcn=== null){				
				alert("Your credit card nummber is not valid or you entered a type of credit card we don't take.");				
				return false;				
			}			
			return true;		
		}
		
		function regComplete() {			
		var validateUnameAndPwd = checkUsernameAndPassword();			
		var validateFnameAndLname = validateFirstAndLastName();
		//this is commented out and set to true because I don't really want to take in credit card info	
		//for same reason I did not validate the CSV -- it would just be /^[0-9]{3}$/
		//expiration for credit card would be--/^(?:[1][012]{1}|[1-9]{1}|[0][1-9]{1})[\/ \-](20)([0-9]{1}[0-9]{1})$/
		var validateCcn = true; //validateCreditCardNumber();			
		var validateDateOfBirth = validateDob();			
		var validateEm = validateEmail();		
			if(validateUnameAndPwd === true && validateFnameAndLname===true && validateCcn===true && validateDateOfBirth ===true && validateEm=== true){		
				alert('Welcome to the club, ' + document.getElementById('fname').value + ". Your registration has been completed successfully!!" );		
			}		
		}
