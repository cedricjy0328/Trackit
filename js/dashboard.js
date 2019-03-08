
function isEmpty(str){
	return str == "";
}

var projectForm = document.getElementById("projectForm")

projectForm.onsubmit = function(e){
	var joinCode = document.getElementById("code");
	var projectTitle = document.getElementById("title");
	var alertMessage1 = document.getElementById("alertMessage1");
	var alertMessage2 = document.getElementById("alertMessage2");

	if (isEmpty(joinCode.value) && isEmpty(projectTitle.value)){
		e.preventDefault();
		alertMessage2.classList.remove("valid");
		alertMessage2.classList.add("invalid");
		joinCode.focus();
		return;
	}
	else{
		alertMessage2.classList.remove("invalid");
		alertMessage2.classList.add("valid");
	}

	if (!isEmpty(joinCode.value) && !isEmpty(projectTitle.value)) {
		e.preventDefault();
		alertMessage1.classList.remove("valid");
		alertMessage1.classList.add("invalid");
		joinCode.focus();
		return;
	}
	else{
		alertMessage1.classList.remove("invalid");
		alertMessage1.classList.add("valid");
	}
}