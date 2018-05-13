<html>
	<body>
            
                <h1>Welcome!</h1>
                
                <a href="index.php">Logout</a>
                <h1>----------</h1>
                <a href="login_success.php">Go back to Wellcome Page</a>
                
                <form action="transfer2.php" method="POST" onsubmit="return checkforBlank()">
			<p>From Account ID:</p><input type="text" id = "fromA" name="fromA" />
			<p>To Account ID:</p><input type="text"  id = "toA" name="toA" />
                        <p>Amount:</p><input type="text" id = "amount" name="amount" />
			<br />
			<input type="submit" value="Transfer" />
                        
                        <style type="text/css">
 li { list-style-type: none; display: inline; padding: 10px; text-align: center;}
</style>

		</form>
	</body>
</html>

        <script>
            function checkforBlank()
            {
                if(document.getElementById('fromA').value == "" || document.getElementById('toA').value == "" || document.getElementById('amount').value == "")
                {
                    alert('Cannot be left blank');
                    return false;
                }
            }
        </script>


<?php

$hostname = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/ibrahimovsh95";
$username = "ibrahimovsh95";
$password = "imrj4nbhv";


$con = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");

$db_selected = mysqli_select_db($con, 'test1');

        session_start();
        $mypasswordd = $_SESSION['myP1'];
//header('Content-type: text/plain');

$result = mysqli_query($con, "SELECT account.aid, branch, balance, openDate FROM account");

if (!$result) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
           echo "<li>$row[aid]. <li>$row[branch]</li>. <li>$row[balance]</li>. <li>$row[openDate]</li><br>";
}
mysqli_free_result($result);
?>

