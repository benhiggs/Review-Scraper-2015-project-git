<?php
include'constants.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



if (isset($_POST['login'])) {
	if($_POST['email']!='' and $_POST['password']!=''){
		$email=$_POST["email"];	$password=$_POST["password"];
		
		if (mysqli_fetch_assoc(mysqli_query($con,"SELECT passwordHash FROM owner WHERE email=$email"))['passwordHash'] == pwcheck($password)){
			$_SESSION["error"]="none";
			$que=mysqli_fetch_assoc(mysqli_query($con,"SELECT ownerid FROM owner WHERE email='$email'"));
			$userid=$que['ownerid'];
			$_SESSION["userid"]=$userid;
			header('Location:home.php');
		}
		else if ($_POST['email']=='' or $_POST['password']==''){
			$_SESSION["error"]="fieldcheck";
			header("Location:login.php");
		}
		else{
			$_SESSION["error"]="nomatch";
			header("Location:login.php");
		}
	}
}




//redirects users to the registry page
if (isset($_POST['registryform'])) {header("Location:registry.php");}


//registers the users on the DB, does all the appropriate checks.
if (isset($_POST['register'])) {
	if($_POST['email']!='' and $_POST['password']!=''){
		$email=$_POST["email"];		$password=$_POST["password"];

		$query=mysqli_num_rows(mysqli_query($con,"SELECT email FROM owner WHERE email='$email'"));		

		if ($query==0){$password=pwhash($password);	mysqli_query($con,"INSERT INTO owner (email,passwordHash) VALUES ('$email','$password' )");
			$_SESSION["error"]="none";
			$_SESSION["userid"]=mysqli_fetch_assoc(mysqli_query($con,"SELECT ownerid FROM owner WHERE email=$email"))['ownerid'];
			header('Location:index.php');
		}
		else if($query!=0){$_SESSION["error"]="emailexist";	header('Location:registry.php');}
	}
	else{$_SESSION["error"]="fieldcheck";	header('Location:registry.php');}
}


?>