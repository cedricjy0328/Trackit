function isEmpty(str){
	return str == "";
}

window.onload = function(){
	var reminderform = document.getElementById("reminderform");
	
	reminderform.onsubmit = function(e){
		var desc = document.getElementById("reminder-description");
		var descEmpty = document.getElementById("descEmpty")
		
		//check if description field is empty
		if (isEmpty(desc.value)) {
			e.preventDefault();
			descEmpty.classList.remove("valid");
			descEmpty.classList.add("invalid");
			desc.focus();
			return;
		}
		else{
			descEmpty.classList.remove("invalid");
			descEmpty.classList.add("valid");
		}

		var date = document.getElementById("due-date");
		var dateEmpty = document.getElementById("dateEmpty");

		//check if date field is empty
		if (isEmpty(date.value)) {
			e.preventDefault();
			dateEmpty.classList.remove("valid");
			dateEmpty.classList.add("invalid");
			date.focus();
			return;
		}
		else{
			dateEmpty.classList.remove("invalid");
			dateEmpty.classList.add("valid");
		}

		var time = document.getElementById("due-time");
		var timeEmpty = document.getElementById("timeEmpty");

		//check if the time field is empty
		if (isEmpty(time.value)) {
			e.preventDefault();
			timeEmpty.classList.remove("valid");
			timeEmpty.classList.add("invalid");
			time.focus();
			return;
		}
		else{
			timeEmpty.classList.remove("invalid");
			timeEmpty.classList.add("valid");
		}
	}
}