<?php
$hostname = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/ibrahimovsh95";
$username = "ibrahimovsh95";
$password = "imrj4nbhv";


$con = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");

$db_selected = mysqli_select_db($con, 'test1');

$from = isset($_POST['fromA']) ? $_POST['fromA'] : '';
$to = isset($_POST['toA']) ? $_POST['toA'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';


$from = stripslashes($from);
$to = stripslashes($to);
$amount = stripslashes($amount);

session_start();
$mypasswordd = $_SESSION['myP1'];


 $sql2 = mysqli_query($con,"SELECT owns.aid FROM owns WHERE cid = '$mypasswordd'");
 $sql3 = mysqli_query($con,"SELECT balance FROM account a WHERE '$from' = a.aid");
 //$sql4 = mysqli_query($con,"SELECT owns.aid FROM owns WHERE cid = '$mypasswordd'");
 
 $accRow = mysqli_fetch_array($sql3, MYSQL_ASSOC);
 
 $accRow["balance"];
 
 //echo "$sql3";
 
 // check variables here *******************************************
 $belongCheck = false;
 $amountCheck = false;
 $hisAccCheck = false;
 
 while ($row = mysqli_fetch_array($sql2, MYSQL_ASSOC)) {
     
            $ala = $row["aid"];
            $hisAcc = $row["aid"];
            
            if ($ala == $from)
            {
                $belongCheck = true;
            }
            
            if($hisAcc == $to )
            {
                $hisAccCheck = true;
            }

}

if($amount <= $accRow["balance"])
{
    $amountCheck = true;
}


if ($belongCheck == true && $amountCheck == true && $hisAccCheck == true)
{
    $sql = mysqli_query($con,"UPDATE account SET balance = balance + '$amount' WHERE aid = '$to'");
    $sql1 = mysqli_query($con,"UPDATE account SET balance = balance - '$amount' WHERE aid = '$from'");
 
    if (!$sql) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
    }
    else{ printf("Succesfully tranfed!");}

mysqli_free_result($sql2);
}
else if ($belongCheck == false){
    echo "You can only send money from your accounts!";
}
else if ($amountCheck == false){
    echo "Amount you are trying to transfer exeecds your account balance!";
}
else if ($hisAccCheck == false){
    echo "You can only send money to your accounts!";
}
 
?>

<html>
	<body>
            <a href="transfer.php">Go back to Transfer Page!</a>
	</body>
</html>