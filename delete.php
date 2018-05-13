<?php
$hostname = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/ibrahimovsh95";
$username = "ibrahimovsh95";
$password = "imrj4nbhv";


$con = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");

$db_selected = mysqli_select_db($con, 'test1');

        session_start();
        $mypasswordd = $_SESSION['myP1'];
        
        //$_SESSION['myP2']=$mypasswordd;

	if( isset($_GET['del']) )
	{
		$aid = $_GET['del'];
                $result = "DELETE FROM owns WHERE owns.aid='$aid' AND '$mypasswordd' = owns.cid";
		$res= mysqli_query($con,$result) or die("Failed".mysqli_error($con));
		echo "<meta http-equiv='refresh' content='0;url=login_success.php'>";
	}
?>