<?php
//RewriteCond %{REQUEST_METHOD} !POST [NC];

$hostname = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/ibrahimovsh95";
$username = "ibrahimovsh95";
$password = "imrj4nbhv";

$con = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");

$db_selected = mysqli_select_db($con, 'test1');

//$myusername = isset($_POST['user']) ? $_POST['user'] : '';
//$mypassword = isset($_POST['pass']) ? $_POST['pass'] : '';
$myusername = $_POST['user'];
$mypassword = $_POST['pass'];


//$myusername = stripslashes($myusername);
//$mypassword = stripslashes($mypassword);


session_start();
$_SESSION['myP']=$mypassword;

$result = mysqli_query($con, "SELECT * FROM customer WHERE name='$myusername' and cid='$mypassword'");
$count = mysqli_num_rows($result);


if ($count == 1) {
    $seconds = 5 + time();
    setcookie(loggedin, date("F jS - g:i a"), $seconds);
    header("location:login_success.php");
} else {
    echo 'Incorrect Username or Password';
}
?>