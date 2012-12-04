<?php
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");;
//Get username
$username = $_GET("username");

//View Personal Information
$sql_query = "SELECT Name, DOB, Gender, Address, Permanent_Address, Contact_Number, Email_Id FROM Regular_User WHERE Username = $username";
$result = mysql_query ($sql_query) or die (mysql_error());
while($row = mysql_fetch_array($result)){
$name = $row["Name"];
$dob = $row["DOB"];
$gender = $row["gender"];
$address = $row["Address"];
$permenant_address = $row["Permanent_Address"];
$contact_number = $row["Contact_Number"];
$email = $row["Email_Id"];
}

//View Available Tutor Course
//Populate Drop Down for tutor course
$sql_quer1 = "SELECT Code, Title FROM (Student_Section NATURAL JOIN Section) NATURAL JOIN Course_Code WHERE Grade_Mode = 'R' AND (Grade = 'A' OR Grade = 'B') AND Student_Username = $username";
$result1 = $mysql_query ($sql_query1) or die (mysql_error());
echo "$result1"

 //After Entering Information new information
 $name = $_Get["name"];
 $dob =  $_Get["dob"];
 $gender = $_Get["gender"];
 $address = $_Get["address"];
 $permenant_address = $_Get["permenant_address"];
 $contact_number = $_Get["number"];
 $email =$_Get["email"];

 
 //Update Personal Information
 $sql_query4 = "UPDATE Regular_User	Name = $name, Gender = $gender, DOB = $dob, Email_ID = $email, Contact_Number = $contact_number, Address = $address, Permanent_Address=$permanent_address WHERE Username = $username"
 mysql_query($sql_query4)or die (mysql_error());
 
 //Update Department Information
 $sql_query5 = "SELECT	DeptId FROM Department WHERE Department.Name = $department";
 $sql_query6 = "UPDATE Faculty SET Position = $position, Dept_Id = $Dept_Id WHERE Instructor_Username = $username";
 mysql_query ($sql_query5) or die (mysql_error());
 mysql_query ($sql_query6) or die (mysql_error());
 
 //Apply for Tutor Course
 $sql_query7 = "INSERT INTO APPLY_Tutor (Student_Username, Title) VALUES ($username, $Title)";
 mysql_query ($sql_query7) or die (mysql_error());
 
 //Get History Information from Input
 $name_of_school = $_Get["name_of_school"];
 $Year_Of_Grade = $_Get["Year_Of_Grade"];
 $Degree = $_Get["Degree"];
 $major = $_Get["major"];
 $GPA = $_Get["GPA"];
 //Add Previous Education
 $sql_query8 = "INSERT INTO Education_History (Student_Username, Name_of_School, Year_Of_Grad, Degree, Major, GPA) VALUES ($username, $name_of_school, $Year_Of_Grade, $Degree, $Major, $GPA)";
 mysql_query ($sql_query8) or die (mysql_error());
 
 ?>