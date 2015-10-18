<?php

ini_set('max_execution_time', 300);

$con=mysqli_connect("localhost","root","","reviews");

if (mysqli_connect_errno($con))
 {
  echo "Failed to connect: " . mysqli_connect_error();
 }

function pwhash($password){
	$hash=password_hash($password,PASSWORD_DEFAULT);
	return $hash;
}

function pwcheck($password,$hashed){
	$hashcheck=password_verify($password,$hashed);
	return $hashcheck;
}

function checklogin(){
	if($_SESSION["userid"]==null){
		header('Location:login.php');
	}
}
?>