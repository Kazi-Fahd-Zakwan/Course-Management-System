<?php 
	if(!($_SESSION['type'] == "admin")){
        header("Location:../index.php");
    }

    if(isset($_POST['poweroff'])){
        session_unset();
        session_destroy();
        session_write_close();
        header("Location:../index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="shortcut icon" type="image/png" href="../images/logo.png"/>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./styles.css">
	<title>Admin Page</title>
</head>
<body>

	<h1 align="center">Admin Panel</h1><br><br>
	<form action="" method="post"><input type="submit"  name="poweroff" value="Logout">                
            </form><br>

	<hr>

	<br>

	<h1 align="center">All Courses</h1>

	<table id="coursesTable">
		<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Faculty Name</td>
		</tr>
		
	</table>
	<br>

	<h2>Create a course</h2>
	<input id="name" placeholder="Course Name">
	<button onclick="createCourse()">Press</button><br><br>

	<h2>Assign a faculty to any course</h2>
	<input id="courseId" placeholder="Course ID">
	<input id="teacherId" placeholder="Teacher ID">
	<button onclick="assignTeacher()">Press</button><br><br>


	<hr><br>

	<h1 align="center">All Teachers</h1>

	<table id="teachersTable">
		<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Username</td>			
		</tr>
		
	</table>
	<br>
	<h2>Create a faculty account</h2>

		<input id="signup-name" placeholder="Name" type="" name="">
		<input id="signup-username" placeholder="Username" type="" name="">
		<input id="signup-password" type="password" placeholder="Password" type="" name="">
		<button onclick="createTeacher()">Press</button>
		<br><br>
		<hr><br>

	<h1 align="center">All Students</h1>

	<table id="studentsTable">
		<tr>
			<td>ID</td>
			<td>Name</td>			
		</tr>	
	</table>
	<br><br><br>

</body>

	<script>

		let teachersMap = new Map();

		function addRowToCoursesTable(course)
		{
		 	document.getElementById("coursesTable").innerHTML += `
		 	<tr>
		 	<td>${course.id}</td>
		 	<td>${course.name}</td>
		 	<td id = '${course.id}-teacher'>${teachersMap.get(parseInt(course.teacher_id)) == null? "TBA" : teachersMap.get(parseInt(course.teacher_id))}</td>
		 	</tr>`
		}

		function addRowToTeachersTable(teacher)
		{
		 	document.getElementById("teachersTable").innerHTML += `
		 	<tr>
			<td>${teacher.id}</td>
			<td>${teacher.name}</td>
			<td>${teacher.username}</td>
			</tr>`
		}

		function addRowToStudentsTable(student)
		{
		 	document.getElementById("studentsTable").innerHTML += `
		 	<tr>
		 	<td>${student.id}</td>
		 	<td>${student.name}</td>
		 	</tr>`
		}

		function getCourses() 
		{		
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {							
					let response = JSON.parse(this.responseText);						
					if (response.status == "success") {
						for (let i = 0; i < response.courses.length; i++) {
							addRowToCoursesTable(response.courses[i]);	
						}
					}
				}
			};
		
			xhttp.open("GET", "http://localhost/CSE391_Project/scripts/courses.php?query=getAllCourses", true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send();
		}

		function getTeachers() 
		{		
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {							
					let response = JSON.parse(this.responseText);						
					if (response.status == "success") {
						for (let i = 0; i < response.teachers.length; i++) {
							teachersMap.set(parseInt(response.teachers[i].id), response.teachers[i].name);
							addRowToTeachersTable(response.teachers[i]);	
						}
						getCourses();
						console.log(teachersMap);
					}
				}
			};
		
			xhttp.open("GET", "http://localhost/CSE391_Project/scripts/users.php?query=getAllTeachers", true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send();
		}

		function getStudents() 
		{		
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {							
					let response = JSON.parse(this.responseText);						
					if (response.status == "success") {
						for (let i = 0; i < response.students.length; i++) {
							addRowToStudentsTable(response.students[i]);	
						}	
					}
				}
			};
		
			xhttp.open("GET", "http://localhost/CSE391_Project/scripts/users.php?query=getAllStudents", true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send();
		}

		function createCourse()
		{
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {					
					console.log(this.responseText);
					let response = JSON.parse(this.responseText);					
					console.log(response);
					if (response.status == "success") {
						addRowToCoursesTable({
							id: response.newId,
							name: document.getElementById("name").value,
							teacher_id: "TBA"
						});
						alert("Course Created!");
					}
					else
					{
						alert("Error");
					}
				}
			};
		
			xhttp.open("POST", "http://localhost/CSE391_Project/scripts/courses.php", true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send(JSON.stringify({
				query: "createCourse",
				name: document.getElementById("name").value
			}));

		}

		function createTeacher()
		{
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.responseText);					
					let response = JSON.parse(this.responseText);					
					console.log(response);
					if (response.status == "success") {						
						addRowToTeachersTable({
							id: response.newId,							
							username: document.getElementById("signup-username").value,
							password: document.getElementById("signup-password").value,
							name: document.getElementById("signup-name").value
						});
						alert("Faculty Account Created!");
					}
					else
					{
						alert("Error");
					}
				}
			};			
			xhttp.open("POST", "http://localhost/CSE391_Project/scripts/users.php", true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send(JSON.stringify({
				query: "signup",				
				username: document.getElementById("signup-username").value,
				password: document.getElementById("signup-password").value,				
				name: document.getElementById("signup-name").value,
				type: "teacher"
			}));
		}

		function assignTeacher()
		{
			let teacherId = document.getElementById("teacherId").value;
			let courseId = document.getElementById("courseId").value;
			var xhttp = new XMLHttpRequest();

			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {							
					let response = JSON.parse(this.responseText);
					console.log(response);						
					if (response.status == "success") {
						document.getElementById(courseId + "-teacher").innerHTML = teachersMap.get(parseInt(teacherId));
						alert("Faculty Assigned!");
					}
					else
					{
						alert("Error");
					}
				}
			};
		
			xhttp.open("GET", "http://localhost/CSE391_Project/scripts/users.php?query=teachCourse&teacherId=" + teacherId + "&courseId=" + courseId, true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send();
		}

		
		//Executing the code after the page loads		
		getTeachers();
		getStudents();
	</script>
</html>