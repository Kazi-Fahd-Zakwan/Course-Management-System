<?php 
	
require("connection.php");

	class Course
	{		
		static function createCourse($name) 
		{
			$conn = new Connection();
			$conn->createConnection();

			$result = $conn->executeQuery("INSERT INTO courses (name) VALUES ('$name')");
			$lastId = -1;

			if ($result) {
				$lastId = $conn->getLastInsertedId();	
			}
			$conn->closeConnection();

			return $lastId;

		}

		static function getAllCourses() 
		{
			$conn = new Connection();
			$conn->createConnection();

			$result = $conn->executeQuery("SELECT * FROM courses");

			$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
			return $courses;

		}

		static function getCoursesByTeacher($teacherId) 
		{
			$conn = new Connection();
			$conn->createConnection();

			$result = $conn->executeQuery("SELECT * FROM courses WHERE teacher_id = $teacherId");

			$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
			return $courses;			
		}

		static function getStudentsInCourse($courseId) 
		{
			$conn = new Connection();
			$conn->createConnection();

			$result = $conn->executeQuery("SELECT * FROM users INNER JOIN student_course ON users.id = student_id WHERE course_id = $courseId");

			$students = mysqli_fetch_all($result, MYSQLI_ASSOC);
			return $students;						
		}
	}


?>