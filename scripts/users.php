<?php 
	require("../models/user.php");
	session_start();

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$json = file_get_contents("php://input");

		$data = json_decode($json);

		if ($data->query == "signup") {
			$newId = User::signup($data->name, $data->username, $data->password, $data->type);
			if ($newId != -1) {
				echo json_encode(["status"=> "success", "newId" => $newId]);
			}
			else
			{
				echo json_encode(["status"=> "failure"]);
			}		
		}
		else if ($data->query == "signin") {
			$user = User::signin($data->username, $data->password);
			if ($user != null) {
				$_SESSION['id'] = $user->id;
				$_SESSION['type'] = $user->type;
				echo json_encode(["status"=> "success", "user" => $user]);	
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
		if ($_GET['query'] == "addCourse") {
			if(User::addCourse($_GET['studentId'], $_GET['courseId'])) {
				echo json_encode(["status"=> "success"]);
			}
			else
			{
				echo json_encode(["status"=> "failure"]);
			}
		}
		elseif ($_GET['query'] == "dropCourse") {
			if(User::dropCourse($_GET['studentId'], $_GET['courseId'])) {
				echo json_encode(["status"=> "success"]);
			}
			else
			{
				echo json_encode(["status"=> "failure"]);
			}	
		}
		elseif ($_GET['query'] == "getAddedCourses") {
			
			$courses = User::getAddedCourses($_GET['studentId']);
			if($courses) {
				echo json_encode(["status"=> "success", "courses"=> $courses]);
			}
			else
			{
				echo json_encode(["status"=> "failure"]);
			}	
		}
		elseif ($_GET['query'] == "teachCourse") {
			$t = User::teachCourse($_GET['teacherId'], $_GET['courseId']);
			if($t) {
				echo json_encode(["status"=> "success"]);
			}
			else
			{
				echo json_encode(["status"=> "failure"]);
			}	
		}
		elseif ($_GET['query'] == "getAllTeachers") {
			
			$teachers = User::getAllTeachers();
			if($teachers) {
				echo json_encode(["status"=> "success", "teachers"=> $teachers]);
			}
			else
			{
				echo json_encode(["status"=> "failure"]);
			}	
		}
		elseif ($_GET['query'] == "getAllStudents") {
			
			$students = User::getAllStudents();
			if($students) {
				echo json_encode(["status"=> "success", "students"=> $students]);
			}
			else
			{
				echo json_encode(["status"=> "failure"]);
			}	
		}

	}

?>