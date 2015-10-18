<?php
include'constants.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//insert test code here

$emails = mysqli_fetch_all(mysqli_query($con,"SELECT email FROM owner "));
foreach($emails as $row){ echo $row[0]; }

?>
