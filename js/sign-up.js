
function isEmpty(str){
	return str == "";
}

function validEmailFormat(str) {
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(str))
		return true;

	return false;
}

function validPassword(str){
	// at least one number, one lowercase and one uppercase letter
	// at least six characters that are letters, numbers or the underscore
	var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w{6,}$/;
	return re.test(str);
}

function matches(pwd, cpwd){
	return pwd == cpwd;
}

window.onload = function(){
	var signupform = document.getElementById("signupform")
	
	signupform.onsubmit = function(e){
		var name = document.getElementById("name");
		var nameEmpty = document.getElementById("nameEmpty");
		var nameWrongFormat = document.getElementById("nameWrongFormat")
		//check if name field is empty
		if (isEmpty(name.value)) {
			e.preventDefault();
			nameEmpty.classList.remove("valid");
			nameEmpty.classList.add("invalid");
			name.focus();
			return;
		}
		else{
			nameEmpty.classList.remove("invalid");
			nameEmpty.classList.add("valid");
		}

		re = /^[a-zA-Z0-9\s]*$/;
		//check if the name consists of only letters, numbers and underscore
		if(!re.test(name.value)) {
			e.preventDefault();
			nameWrongFormat.classList.remove("valid");
			nameWrongFormat.classList.add("invalid");
			name.focus();
			return;
		}
		else{
			nameWrongFormat.classList.remove("invalid");
			nameWrongFormat.classList.add("valid");
		}

		var email = document.getElementById("email");
		var emailEmpty = document.getElementById("emailEmpty");
		var emailWrongFormat = document.getElementById("emailWrongFormat");

		//check if email field is empty
		if (isEmpty(email.value)) {
			e.preventDefault();
			emailEmpty.classList.remove("valid");
			emailEmpty.classList.add("invalid");
			email.focus();
			return;
		}
		else{
			emailEmpty.classList.remove("invalid");
			emailEmpty.classList.add("valid");
		}

		//check the email format
		if (validEmailFormat(email.value)) {
			emailWrongFormat.classList.remove("invalid");
			emailWrongFormat.classList.add("valid");
		}
		else{
			e.preventDefault();
			emailWrongFormat.classList.remove("valid");
			emailWrongFormat.classList.add("invalid");
			email.focus();
			return;
		}

		var pwd = document.getElementById("pwd");
		var pwdEmpty = document.getElementById("pwdEmpty");
		var invalidPassword = document.getElementById("invalidPassword");
		//check if the password field is empty
		if (isEmpty(pwd.value)) {
			e.preventDefault();
			pwdEmpty.classList.remove("valid");
			pwdEmpty.classList.add("invalid");
			pwd.focus();
			return;
		}
		else{
			pwdEmpty.classList.remove("invalid");
			pwdEmpty.classList.add("valid");
		}

		//check if the password have minimum 6 characters with at least 1 lowercase, 1 uppercase and 1 number including underscore
		if (validPassword(pwd.value)) {
			invalidPassword.classList.remove("invalid");
			invalidPassword.classList.add("valid");
		}
		else{
			e.preventDefault();
			invalidPassword.classList.remove("valid");
			invalidPassword.classList.add("invalid");
			pwd.focus();
			return;
		}

		var conf_pwd = document.getElementById("conf-pwd");
		var cpwdNotMatch = document.getElementById("cpwdNotMatch");

		//check if the confirm password field matches the password
		if (matches(pwd.value,conf_pwd.value)) {
			cpwdNotMatch.classList.remove("invalid");
			cpwdNotMatch.classList.add("valid");
		}
		else{
			e.preventDefault();
			cpwdNotMatch.classList.remove("valid");
			cpwdNotMatch.classList.add("invalid");
			conf_pwd.focus();
			return;
		}
		
	}
}