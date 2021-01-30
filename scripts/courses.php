<?php 

require("../models/course.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$json = file_get_contents("php://input");

		$data = json_decode($json);

		if ($data->query == "createCourse") {
			$lastId = Course::createCourse($data->name);
			if ($lastId != -1) {
				echo json_encode(["status"=> "success", "newId"=> $lastId]);		
			}
			else
			{
				echo json_encode(["status"=> "failure"]);
			}
		}
		else
		{
			echo json_encode(["status"=> "failure", "message"=> "Can't find query!"]);
		}
	}
	else
	{
		if ($_GET['query'] == "getAllCourses") {
			$courses = Course::getAllCourses();
			if ($courses) {
				echo json_encode(["status"=> "success", "courses"=> $courses]);			
			}
			else
			{
				echo json_encode(["status"=> "failure"]);
			}
		}

		else if ($_GET['query'] == "getCoursesByTeacher") {
			$c = Course::getCoursesByTeacher($_GET["teacherId"]);
			if ($c) {
				echo json_encode(["status"=> "success", "courses"=> $c]);	
			}
			else
			{
				echo json_encode(["status"=> "failure"]);
			}
		}

		else if ($_GET['query'] == "getStudentsInCourse") {
			$students = Course::getStudentsInCourse($_GET['courseId']);
			if ($students) {
				echo json_encode(["status"=> "success", "students"=> $students]);		
			}
			else
			{
				echo json_encode(["status"=> "failure"]);
			}

		}

	}

?>
