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

function pwcheck($password){
	$hashcheck=password_verify($password,mysqli_fetch_assoc(mysqli_query($con,"SELECT password FROM owner WHERE email='$email'"))['ownerid']);
	return $hashckeck;
}


?>