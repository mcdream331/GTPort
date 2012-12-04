function login() {
	var un = document.getElementById("username").value;
	var pw = document.getElementById("password").value;
	//Ajax
	var xmlhttp = new XMLHttpRequest();
	//
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			console.log("un:"+xmlhttp.responseText);
			if (xmlhttp.responseText != un) {
				alert("Username or Password is wrong. Please try again!");
			} else {
				location.href='homepage.html';
			}
		}
	}
	xmlhttp.open("GET", "http://localhost/login_1.php?un=" + un + "&pw=" + pw, false);
	xmlhttp.send();

}

function userTypeIdentify() {
	var xmlhttp = new XMLHttpRequest();
	//
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			console.log("username:" + xmlhttp.responseText);
			if(xmlhttp.responseText=="admin"){
				document.getElementById("personal_information").style.display = "none";
				document.getElementById("faculty_service").style.display = "none";
				document.getElementById("student_service").style.display = "none";
			}
			else if(xmlhttp.responseText=="student"){
				document.getElementById("faculty_service").style.display = "none";
				document.getElementById("admin_report").style.display = "none";
				document.getElementById("add_course").style.display = "none";
			}
			else{
				document.getElementById("student_service").style.display = "none";
				document.getElementById("admin_report").style.display = "none";
				document.getElementById("add_course").style.display = "none";
			}
		}
	}
	xmlhttp.open("GET", "http://localhost/login_2.php" , false);
	xmlhttp.send();
}