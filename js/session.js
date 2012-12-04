var username;

function login() {
	var un = document.getElementById("username").value;
	var pw = document.getElementById("password").value;
	//Ajax
	var xmlhttp = new XMLHttpRequest();
	//
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			//console.log("password:"+xmlhttp.responseText);
			if (xmlhttp.responseText != 'true') {
				alert("Username or Password is wrong. Please try again!");
			} else {
				userTypeIdentify(un);
			}
		}
	}
	xmlhttp.open("GET", "http://localhost/login_1.php?un=" + un + "&pw=" + pw, true);
	xmlhttp.send();

}

function userTypeIdentify(un) {
	var xmlhttp = new XMLHttpRequest();
	//
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			username = un;
			//console.log("usertype:" + xmlhttp.responseText);
			if(xmlhttp.responseText=="admin"){
				location.href='admin_report.html';
				console.log(username);
			}
			else if(xmlhttp.responseText=="student"){
				location.href='student_service.html';
			}
			else{
				location.href='faculty_service.html';
			}
		}
	}
	xmlhttp.open("GET", "http://localhost/login_2.php?un=" + un , true);
	xmlhttp.send();
}