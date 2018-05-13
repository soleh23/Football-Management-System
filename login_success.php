<?php
/*	if(!isset($_COOKIE['loggedin'])){
		header("location:index.php");
	}

        //echo $res;*/
?>

<html>
	<body>
		<h1>Welcome!</h1>
                <a href="index.php">Logout</a>
	</body>
<head>

<style type="text/css">
 li { list-style-type: none; display: inline; padding: 10px; text-align: center;}
</style>

</head>

<ul>
    
<?php
            
$hostname = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/ibrahimovsh95";
$username = "ibrahimovsh95";
$password = "imrj4nbhv";

$con = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");

$db_selected = mysqli_select_db($con, 'test1');

session_start();

$mypassword = $_SESSION['myP'];


$_SESSION['myP1']=$mypassword;
$_SESSION['myP2']=$mypassword;

$result = mysqli_query($con, "SELECT account.aid, branch, balance, openDate FROM account, owns WHERE '$mypassword' = owns.cid AND owns.aid = account.aid");

if (!$result) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}
while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
            echo "<li>$row[aid]. <li>$row[branch]</li>. <li>$row[balance]</li>. <li>$row[openDate]</li> 
                <li><a href='delete.php?del=$row[aid]'>delete</a></li><br />";
            
}

mysqli_free_result($result);

?>
</ul>
</body>
	<body>
		<a href="transfer.php">Money Transfer</a>
	</body>
</html>