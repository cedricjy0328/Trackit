
function validEmailFormat(str) {
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(str))
		return true;

	return false;
}

function isEmpty(str){
	return str == "";
}

window.onload = function(){
	var loginform = document.getElementById("loginform")
	
	loginform.onsubmit = function(e){
		var email = document.getElementById("email");
		var password = document.getElementById("pwd");
		var emailEmpty = document.getElementById("emailEmpty")
		var emailWrongFormat = document.getElementById("emailWrongFormat");
		var pwdEmpty = document.getElementById("pwdEmpty");

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

		//check if the password field is empty
		if (isEmpty(password.value)) {
			e.preventDefault();
			pwdEmpty.classList.remove("valid");
			pwdEmpty.classList.add("invalid");
			password.focus();
			return;
		}
		else{
			pwdEmpty.classList.remove("invalid");
			pwdEmpty.classList.add("valid");
		}
	}
}