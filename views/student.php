<?php 
	if(!($_SESSION['type'] == "student")){
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
	<title>Student Page</title>
</head>
<body>
	<br><br>
	<form action="" method="post"><input type="submit"  name="poweroff" style="margin-bottom: 10px" value="Logout">                
            </form><br>

	<h1>My Courses</h1>

	<table id="myCourses">
		<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Actions</td>
		</tr>		
	</table>

	<hr>

	<h1>Other Courses</h1>

	<table id="otherCourses">
		<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Actions</td>
		</tr>		
	</table>

</body>
	<script>

		let myCourseMap = new Map();
		let otherCoursesMap = new Map();

		function addRowToMyCoursesTable(course) 
		{
			document.getElementById("myCourses").innerHTML += `<tr id='${course.id}-myCourses'>
			<td>${course.id}</td>
			<td>${course.name}</td>
			<td><button onclick="drop(${course.id})">Drop</button></td>
			</tr> `
		}	

		function addRowToOtherCoursesTable(course) 
		{
			if (myCourseMap.get(parseInt(course.id)) == null) 	 
			{
				document.getElementById("otherCourses").innerHTML += `<tr id='${course.id}-otherCourses'>
				<td>${course.id}</td>
				<td>${course.name}</td>
				<td><button onclick="add(${course.id})">Add</button></td>
				</tr>`	
			}						
		}

		function getMyCourses()
		{
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {							
					let response = JSON.parse(this.responseText);
					
					if (response.status == "success") {						
						for (let i = 0; i < response.courses.length; i++) {
							myCourseMap.set(parseInt(response.courses[i].id), response.courses[i]);
							addRowToMyCoursesTable(response.courses[i]);	
						}
						getOtherCourses(); 
					}
				}
			};
		
			xhttp.open("GET", "http://localhost/CSE391_Project/scripts/users.php?query=getAddedCourses&studentId=<?php echo $_SESSION['id']; ?>", true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send();
		}

		function getOtherCourses()
		{
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {							
					let response = JSON.parse(this.responseText);					
					if (response.status == "success") {						
						for (let i = 0; i < response.courses.length; i++) {
							otherCoursesMap.set(parseInt(response.courses[i].id), response.courses[i]);
							addRowToOtherCoursesTable(response.courses[i]);	
						}
					}
				}
			};
		
			xhttp.open("GET", "http://localhost/CSE391_Project/scripts/courses.php?query=getAllCourses", true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send();
		}
 
		function add(courseId) 
		{
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {							
					let response = JSON.parse(this.responseText);
					console.log(response);
					if (response.status == "success") {						
						alert("Course added!");
						document.getElementById(courseId + "-otherCourses").remove();
						let course = otherCoursesMap.get(parseInt(courseId));
						otherCoursesMap.delete(parseInt(courseId));
						myCourseMap.set(parseInt(course.id), course);
						addRowToMyCoursesTable(course);						
					}
					else
					{
						alert("Failed to add the course.");
					}
				}
			};
		
			xhttp.open("GET", "http://localhost/CSE391_Project/scripts/users.php?query=addCourse&courseId=" + courseId + "&studentId=<?php echo $_SESSION['id'] ?>", true);
			xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send();
		}

		function drop(courseId)
		{
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {							
					let response = JSON.parse(this.responseText);
					console.log(response);
					if (response.status == "success") {						
						alert("Course dropped!");
						document.getElementById(courseId + "-myCourses").remove();
						let course = myCourseMap.get(parseInt(courseId));
						myCourseMap.delete(parseInt(courseId));
						otherCoursesMap.set(parseInt(course.id), course);
						addRowToOtherCoursesTable(course);						
					}
					else
					{
						alert("Failed to drop the course.");
					}
				}
			};
		
			xhttp.open("GET", "http://localhost/CSE391_Project/scripts/users.php?query=dropCourse&courseId=" + courseId + "&studentId=<?php echo $_SESSION['id'] ?>", true);
			 	xhttp.setRequestHeader("Content-Type", "application/json");
			xhttp.send();
		}

		//Executing the code after the page loads
		getMyCourses();
		
	</script>
</html>
