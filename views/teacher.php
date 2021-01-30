<?php 
	if(!($_SESSION['type'] == "teacher")){
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
	<title>Faculty Page</title>
</head>
<body>
	<br><br>
	<form action="" method="post"><input type="submit"  name="poweroff" style="margin-bottom: 10px" value="Logout">                
            </form><br>

	<h1>My Courses</h1>

	<table id="coursesTable">
		<tr>
			<td>ID</td>
			<td>Name</td>
		</tr>		
	</table>

	<hr>

	<h1>Students List</h1>
	<ol id="studentsList">		
	</ol>

</body>

	<script>

		function addRowToCoursesTable(course)
		{
			document.getElementById("coursesTable").innerHTML += `<tr onclick="getStudents(${course.id})"> 
			<td>${course.id}</td>
			<td>${course.name}</td>
			</tr>`
		}

		function addListItem(name)
		{
			document.getElementById("studentsList").innerHTML += `<li>${name}</li>`;
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
		
			xhttp.open("GET", "http://localhost/CSE391_Project/scripts/courses.php?query=getCoursesByTeacher&teacherId=<?php echo $_SESSION['id']; ?>", true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send();
		}

		function getStudents(courseId)
		{
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {							
					let response = JSON.parse(this.responseText);						
					if (response.status == "success") {
						document.getElementById("studentsList").innerHTML = "";
						for (let i = 0; i < response.students.length; i++) {
							addListItem(response.students[i].name);	
						}
					}
				}
			};
		
			xhttp.open("GET", "http://localhost/CSE391_Project/scripts/courses.php?query=getStudentsInCourse&courseId=" + courseId, true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send();
		}

		//Executing the code after the page loads
		getCourses(); 

	</script>
</html>		