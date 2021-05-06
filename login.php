<?php
session_start();

if(isset($_SESSION['userID'])){
	header("Location: quizzes.php");
}else{
	
}

if(isset($_POST['submit'])){
	//Gets Database Access
	require 'config.php';
	
	//Gets the username submited to the login form
	$username = $_POST['username'];
	//Gets the password submited to the login form
	$password =$_POST['password'];
	
	$sql = "SELECT * FROM users WHERE user_name=?;";
	$stmt = mysqli_stmt_init($connect_db);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("location: index.php?error=sqlerror");
		exit();	
	}else{
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if($row = mysqli_fetch_assoc($result)){
			$pwdCheck = password_verify($password, $row['password']);
			if ($pwdCheck == false){
				header("Location: index.php?error=Wrong Password");
				exit();
			}else if($pwdCheck == true){
				session_start();
				$_SESSION['userID']= $row['user_ID'];
				$_SESSION['userName']= $row['user_name'];
				$_SESSION['permissions'] = $row['permission_level'];
				header("Location: quizzes.php");
				exit();
			}else{
				header("Location: index.php?error=Wrong Password");
				exit();
			}
		}else{
			header("Location: index.php?error=No User");
			exit();
		}
	}
	
}else{
	//Redirects User To The Login Page If They Have'nt Came To This Page From Submiting The Login Form
	header("location: index.php");
}

?>