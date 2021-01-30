<?php 

	session_start();
	
	if ($_SESSION['type'] == "student") {
		require("student.php");
	}

	else if ($_SESSION['type'] == "teacher") {
		require("teacher.php");
	}

	else if ($_SESSION['type'] == "admin") {
		require("admin.php");
	}

	else if(!($_SESSION['type'] == "student")){
        header("Location:../index.php");
    }

    else if(!($_SESSION['type'] == "teacher")){
        header("Location:../index.php");
    }

    else if(!($_SESSION['type'] == "admin")){
        header("Location:../index.php");
    }
?>