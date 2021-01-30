<?php 

require("connection.php");

class User {

	static function signup($name, $username, $password, $type) {
		$conn = new Connection();
		$conn->createConnection();

		$result = $conn->executeQuery("INSERT INTO users (name, username, password, type) VALUES ('$name', '$username', '$password', '$type')");
		$lastId = -1;

		if ($result) {
			$lastId = $conn->getLastInsertedId();	
		}
		$conn->closeConnection();

		return $lastId;
	}

	static function signin($username, $password) {
		$conn = new Connection();
		$conn->createConnection();

		$result = $conn->executeQuery("SELECT * FROM users WHERE username = '$username'");
		$conn->closeConnection();
		$user = mysqli_fetch_object($result);

		if ($user) {
			if ($password == $user->password) {
			return $user;
			}		
		}		
		return null;
	}

	static function addCourse($studentId, $courseId) {
		$conn = new Connection();
		$conn->createConnection();		

		return $conn->executeQuery("INSERT INTO student_course (student_id, course_id) VALUES ($studentId, $courseId)");
	}

	static function dropCourse($studentId, $courseId) {
		$conn = new Connection();
		$conn->createConnection();

		return $conn->executeQuery("DELETE FROM student_course WHERE student_id = '$studentId' AND course_id = '$courseId'");		
	}

	static function getAddedCourses($studentId) {
		$conn = new Connection();
		$conn->createConnection();

		$result = $conn->executeQuery("SELECT * FROM users INNER JOIN student_course ON users.id = student_course.student_id INNER JOIN courses ON student_course.course_id = courses.id WHERE users.id = $studentId");

		$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $courses;
	}

	static function teachCourse($teacherId, $courseId) {
		$conn = new Connection();
		$conn->createConnection();		

		return $conn->executeQuery("UPDATE courses SET teacher_id = '$teacherId' WHERE id = '$courseId'"); 
	}

	static function getAllTeachers() {
		$conn = new Connection();
		$conn->createConnection();

		$result = $conn->executeQuery("SELECT * FROM users WHERE type = 'teacher'");

		$teachers = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $teachers;
	}

	static function getAllStudents() {
		$conn = new Connection();
		$conn->createConnection();

		$result = $conn->executeQuery("SELECT * FROM users WHERE type = 'student'");

		$students = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $students;
	}
}

?>



















