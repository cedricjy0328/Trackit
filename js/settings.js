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
	var changeEmailForm = document.getElementById("changeEmailForm");
	var changePassForm = document.getElementById("changePassForm");

	changeEmailForm.onsubmit = function(e){
		var email = document.getElementById("newEmail");
		var emailEmpty1 = document.getElementById("emailEmpty1");
		var emailWrongFormat1 = document.getElementById("emailWrongFormat1");

		//check if email field is empty
		if (isEmpty(email.value)) {
			e.preventDefault();
			emailEmpty1.classList.remove("valid");
			emailEmpty1.classList.add("invalid");
			email.focus();
			return;
		}
		else{
			emailEmpty1.classList.remove("invalid");
			emailEmpty1.classList.add("valid");
		}

		//check the email format
		if (validEmailFormat(email.value)) {
			emailWrongFormat1.classList.remove("invalid");
			emailWrongFormat1.classList.add("valid");
		}
		else{
			e.preventDefault();
			emailWrongFormat1.classList.remove("valid");
			emailWrongFormat1.classList.add("invalid");
			email.focus();
			return;
		}

		var confEmail = document.getElementById("confirmEmail");
		var emailEmpty2 = document.getElementById("emailEmpty2");
		var emailWrongFormat2 = document.getElementById("emailWrongFormat2");
		var emailNotMatch = document.getElementById("emailNotMatch");

		//check if email field is empty
		if (isEmpty(confEmail.value)) {
			e.preventDefault();
			emailEmpty2.classList.remove("valid");
			emailEmpty2.classList.add("invalid");
			confEmail.focus();
			return;
		}
		else{
			emailEmpty2.classList.remove("invalid");
			emailEmpty2.classList.add("valid");
		}

		//check the email format
		if (validEmailFormat(confEmail.value)) {
			emailWrongFormat2.classList.remove("invalid");
			emailWrongFormat2.classList.add("valid");
		}
		else{
			e.preventDefault();
			emailWrongFormat2.classList.remove("valid");
			emailWrongFormat2.classList.add("invalid");
			confEmail.focus();
			return;
		}

		//check if the confirm email matches the above email
		if(matches(email.value,confEmail.value)){
			emailNotMatch.classList.remove("invalid");
			emailNotMatch.classList.add("valid");
		}
		else{
			e.preventDefault();
			emailNotMatch.classList.remove("valid");
			emailNotMatch.classList.add("invalid");
			confEmail.focus();
			return;
		}
	}

	changePassForm.onsubmit = function(e){
		var oldPass = document.getElementById("oldPassw");
		var oldPwdEmpty = document.getElementById("oldPwdEmpty");

		//check if the old password field is empty
		if (isEmpty(oldPass.value)) {
			e.preventDefault();
			oldPwdEmpty.classList.remove("valid");
			oldPwdEmpty.classList.add("invalid");
			oldPass.focus();
			return;
		}
		else{
			oldPwdEmpty.classList.remove("invalid");
			oldPwdEmpty.classList.add("valid");
		}

		var newPass = document.getElementById("newPassw");
		var newPwdEmpty = document.getElementById("newPwdEmpty");
		var invalidPassword = document.getElementById("invalidPassword");

		//check if the password field is empty
		if (isEmpty(newPass.value)) {
			e.preventDefault();
			newPwdEmpty.classList.remove("valid");
			newPwdEmpty.classList.add("invalid");
			newPass.focus();
			return;
		}
		else{
			newPwdEmpty.classList.remove("invalid");
			newPwdEmpty.classList.add("valid");
		}

		//check if the password have minimum 6 characters with at least 1 lowercase, 1 uppercase and 1 number including underscore
		if (validPassword(newPass.value)) {
			invalidPassword.classList.remove("invalid");
			invalidPassword.classList.add("valid");
		}
		else{
			e.preventDefault();
			invalidPassword.classList.remove("valid");
			invalidPassword.classList.add("invalid");
			newPass.focus();
			return;
		}

		var conf_pwd = document.getElementById("confirmPassw");
		var cpwdNotMatch = document.getElementById("cpwdNotMatch");

		//check if the confirm password field matches the password
		if (matches(newPass.value,conf_pwd.value)) {
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