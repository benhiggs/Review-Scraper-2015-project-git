<?php
include'constants.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//used to check if session has been setup by user before hand
function checksession($userid,$con){
	$site = mysqli_fetch_assoc(mysqli_query($con,"SELECT website FROM project WHERE owner_project='$userid'")) ['website'];
	if($site!=null){
		$_SESSION["ScrapeURL"] = $site;
		header('Location:home.php');		
	}
	else{
		header('Location:createsession.php');		
	}
}


function checkurl($url){
	if (strpos($url,'http://www.tripadvisor.co.uk/Hotel_Review-') !== false) {
    	return true;
	} else {
    	return false;
	}
}

function checkadmin($userid,$con){
	$admin = mysqli_fetch_assoc(mysqli_query($con,"SELECT admin_id FROM globalsettings WHERE setup_id=1")) ['admin_id'];
	if ($userid == $admin){return true;}
	else{return false;}
	echo($admin);
}







//checks users login and verifys the PW hash
if (isset($_POST['login'])) {
	if($_POST['email']!='' and $_POST['password']!=''){
		$email=$_POST["email"];	$password=$_POST["password"];
		
		if (pwcheck($password,mysqli_fetch_assoc(mysqli_query($con,"SELECT passwordHash FROM owner WHERE email='$email'")) ['passwordHash'])==1){
			$_SESSION["error"]="none";
			$que=mysqli_fetch_assoc(mysqli_query($con,"SELECT ownerId FROM owner WHERE email='$email'"));
			$userid=$que['ownerId'];
			$_SESSION["userid"]=$userid;
			$_SESSION["email"]=$email;
			if (checkadmin($userid,$con)){
				$_SESSION["admin"]=true;
				header('Location:home.php');
			}
			else{
				$_SESSION["admin"]=false;
				checksession($userid,$con);
			}
		}
		else{
			$_SESSION["error"]="nomatch";
			header("Location:login.php");
		}
	}
	else{$_SESSION["error"]="fieldcheck";header("Location:login.php");}
}




//redirects users to the registry page
if (isset($_POST['registryform'])) {header("Location:registry.php");}


//registers the users on the DB, does all the appropriate checks.
if (isset($_POST['register'])) {
	if($_POST['email']!='' and $_POST['password']!=''){
		$email=$_POST["email"];		$password=$_POST["password"];

		$query=mysqli_num_rows(mysqli_query($con,"SELECT email FROM owner WHERE email='$email'"));		

		if ($query==0){$password=pwhash($password);	mysqli_query($con,"INSERT INTO owner (email,passwordHash) VALUES ('$email','$password' )");
			$_SESSION["userid"]=mysqli_fetch_assoc(mysqli_query($con,"SELECT ownerId FROM owner WHERE email=$email"))['ownerId'];
			$_SESSION["error"]="new";
			header('Location:login.php');
		}
		else if($query!=0){$_SESSION["error"]="emailexist";	header('Location:registry.php');}
	}
	else{$_SESSION["error"]="fieldcheck";header('Location:registry.php');}
}



//changes password
if (isset($_POST['changepw'])) {
	if($_POST['password1']!='' and $_POST['password2']!='' and $_POST['password3']!=''){
		$password1=$_POST["password1"]; $password2=$_POST["password2"]; $password3=$_POST["password3"]; $email=$_SESSION["email"];
		
		if ($password2 != $password3){$_SESSION["error"]="newpwmatch"; header("Location:settings.php"); }

		else if (pwcheck($password1,mysqli_fetch_assoc(mysqli_query($con,"SELECT passwordHash FROM owner WHERE email='$email'")) ['passwordHash'])!=1){
			$_SESSION["error"]="oldpwmatch";
			header('Location:settings.php');			
		}
		else{$hash=pwhash($password2);
			mysqli_query($con,"UPDATE owner SET passwordHash='$hash' WHERE email='$email'");
			$_SESSION["error"]="pwupdated";
			header("Location:settings.php");			
		}
	}
	else{$_SESSION["error"]="pwsnotthere";header("Location:settings.php");}
}

if (isset($_POST['addurl'])) {
	echo(checkadmin($_SESSION["userid"],$con));
	if(checkadmin($_SESSION["userid"],$con)==true){
		header('Location:home.php');
	}
	else{
		$URL=$_POST["URL"];
		if ($URL!=''){
			if (checkurl($URL)==true){
				$id=$_SESSION["userid"];
				mysqli_query($con,"INSERT INTO project (website,owner_project) VALUES ('$URL','$id')");
				checksession($id,$con);
			}
			else{$_SESSION["error"]="invalidurlformat";
			header('Location:createsession.php');}
		}
		else{
			$_SESSION["error"]="invalidurl";
			header('Location:createsession.php');	
		}
	}
}



if (isset($_POST['changeurl'])) {
	$URL=$_POST["newurl"];
	$id=$_SESSION["userid"];
	if ($URL == mysqli_fetch_assoc(mysqli_query($con,"SELECT website FROM project WHERE owner_project='$id'")) ['website']){
		$_SESSION["error"]="sameurl";
		header('Location:settings.php');
	}
	else if (checkurl($URL) == false){
		$_SESSION["error"]="invalidurl1";
		header('Location:settings.php');
		
	}
	else if ($URL!=''){
		mysqli_query($con,"UPDATE project SET website='$URL' WHERE owner_project='$id'");
		$_SESSION["error"]="updatedurl";
		$_SESSION["ScrapeURL"] = $URL;
		header('Location:settings.php');
	}
}


if (isset($_POST['changeuserurl'])) {
	$URL=$_POST["newurl1"];
	$id=$_POST["emailchoice"];
	$id=mysqli_fetch_assoc(mysqli_query($con,"SELECT ownerId FROM owner WHERE email='$id'")) ['ownerId'];

	if ($id=='na'){
		$_SESSION["error"]="emailselect";
		header('Location:settings.php');
	}
	else if ($URL == mysqli_fetch_assoc(mysqli_query($con,"SELECT website FROM project WHERE owner_project='$id'")) ['website']){
		$_SESSION["error"]="sameurl1";
		header('Location:settings.php');
	}
	else if (checkurl($URL) == false){
		$_SESSION["error"]="invalidurl1";
		header('Location:settings.php');
		
	}
	else if($URL!=''){
		mysqli_query($con,"UPDATE project SET website='$URL' WHERE owner_project='$id'");
		$_SESSION["error"]="updatedurl1";
		header('Location:settings.php');
	}
}


if (isset($_POST['changeadminsettings'])) {
	
	if (isset($_POST['reset'])){
		mysqli_query($con,"UPDATE globalsettings SET loop_timeout=600,sleep_time=5,database_write_quota=5 ");
		$_SESSION["error"]="resetDBsettings";
		header('Location:settings.php');
	}
	else{
		if($_POST['looptimeout']!=''){
			$q = $_POST['looptimeout'];
			mysqli_query($con,"UPDATE globalsettings SET loop_timeout=$q ");
			$_SESSION["error"]="looptime";
			
		}
		if($_POST['sleeptime']!=''){
			$q = $_POST['sleeptime'];
			mysqli_query($con,"UPDATE globalsettings SET sleep_time=$q ");
			if($_SESSION["error"]=="looptime"){
				$_SESSION["error"].="sleeptime";
			}
			else{
				$_SESSION["error"]="sleeptime";
			}
		}
		if($_POST['writequota']!=''){
			$q = $_POST['writequota'];
			mysqli_query($con,"UPDATE globalsettings SET database_write_quota=$q");
			if(strpos($_SESSION["error"],"looptime") !== false || strpos($_SESSION["error"],"sleeptime") !== false){
				$_SESSION["error"].="writequota";
			}
			else{
				$_SESSION["error"]="writequota";
			}
		}
		header('Location:settings.php');
	}

}












if (isset($_POST['old'])){
	echo('tables n shit');
}


if (isset($_POST['new'])){
	echo('inititate python');
}












?>