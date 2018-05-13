<?php 
	session_start();
	$host = "dijkstra.ug.bcc.bilkent.edu.tr";
	$myUser = "mehmet.turanboy";
	$myPassword = "1ky0yl0r";
	$myDB = "mehmet_turanboy";
	$connection = mysqli_connect($host, $myUser, $myPassword, $myDB);
	if ($_SESSION['loggedIn'] != true){
		header("Location: login.php");
		exit();
	}
	if (isset($_POST['logout'])){
		$_SESSION['loggedIn'] = false;
		header("Location: login.php");
		exit();
	}
	if (isset($_POST['request'])){
		if (empty($_POST['name']) || empty ($_POST['surname']) || empty ($_POST['bonus']) || empty ($_POST['date'])){
			?>
			<script>alert("Please fill out all the fields"); </script>
			<?php
		}
		else{
			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$bonus = $_POST['bonus'];
			$date = $_POST['date'];
			$getPlayerIDQuery = "SELECT ID, agent_ID FROM Player WHERE name = '".$name."' AND surname = '".$surname."'";
			$getPlayerID = mysqli_query($connection, $getPlayerIDQuery);
			if (mysqli_num_rows($getPlayerID) == 0){
				?>
				<script>alert("No Such Player"); </script>
				<?php
			}
			else {
				$curPlayerID = $getPlayerID->fetch_object();
				$checkNameQuery = "SELECT clubID FROM Plays WHERE Plays.playerID = '".$curPlayerID->ID."'";
				$checkName = mysqli_query($connection, $checkNameQuery)->fetch_object();
				if ($checkName->clubID != $_SESSION['myClubID']){
					?>
					<script>alert("Choose players from YOUR club"); </script>
					<?php
				}
				else{
					if (!is_numeric($bonus)){
						?>
						<script>alert("Enter Numeric Value in Bonus"); </script>
						<?php
					}
					else{
						$existQuery = "SELECT * FROM Contract WHERE playerID = '".$curPlayerID->ID."' AND agentID = '".$curPlayerID->agent_ID."'";
						$exist = mysqli_query($connection, $existQuery);
						if (mysqli_num_rows($exist) > 0){
							?>
							<script>alert("Player already has a contract extension request"); </script>
							<?php
						}
						else{
							$updateQuery = "INSERT INTO Contract(playerID, directorID, agentID, bonus, expirationDate, status) 
											VALUES('".$curPlayerID->ID."', '".$_SESSION['id']."', '".$curPlayerID->agent_ID."', '".$bonus."', '".$date."', '1')";
							mysqli_query($connection, $updateQuery);
							?>
							<script>alert("Contract Extension Request Successful"); </script>
							<?php
						}
					}
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<style>
* {
    box-sizing: border-box;
}
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}
td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}

body {
    font-family: Arial;
    padding: 10px;
    background: #f1f1f1;
}

/* Header/Blog Title */
.header {
    padding: 30px;
    text-align: center;
    background: white;
}

.header h1 {
    font-size: 50px;
}

/* Style the top navigation bar */
.topnav {
    overflow: hidden;
    background-color: #333;
}

/* Style the topnav links */
.topnav a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
    background-color: #ddd;
    color: black;
}

/* Create two unequal columns that floats next to each other */
/* Left column */
.leftcolumn {   
    float: left;
    width: 25%;
}

/* Right column */
.rightcolumn {
    float: right;
    width: 75%;
    background-color: #f1f1f1;
    padding-left: 20px;
}

.logoutbutton {
    background-color: #f44336; /* Red */
    border: none;
    color: white;
    padding: 14px 31px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
	float: right;
}

/* Add a card effect for articles */
.card {
    background-color: white;
    padding: 20px;
    margin-top: 20px;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

#sideBarStyle ul {
    
    margin: 0;
    padding: 0;
    width: 200px;
    background-color: #f1f1f1;
}

#sideBarStyle li a {
    
    display: block;
    color: #000;
    padding: 8px 16px;
    text-decoration: none;
}

ul, li 
{
    list-style-type: none;
    margin: 0;
    padding: 0;
}

ul#sideBarStyle li a:hover,ul#sideBarStyle li.active a
{
   background-color: #4CAF50;
   color: white;

}
.btn-group button {
    background-color: #4CAF50; /* Green background */
    border: 1px solid green; /* Green border */
    color: white; /* White text */
    padding: 10px 24px; /* Some padding */
    cursor: pointer; /* Pointer/hand icon */
    float: left; /* Float the buttons side by side */
}

.btn-group button:not(:last-child) {
    border-right: none; /* Prevent double borders */
}

/* Clear floats (clearfix hack) */
.btn-group:after {
    content: "";
    clear: both;
    display: table;
}

/* Add a background color on hover */
.btn-group button:hover {
    background-color: #7e4e41;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 800px) {
    .leftcolumn, .rightcolumn {   
        width: 100%;
        padding: 0;
    }
}

/* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
@media screen and (max-width: 400px) {
.topnav a {
    float: none;
    width: 100%;
}


/*<li>
          <section class="box search">
            <form method="post" action="#">
              <input type="text" class="text" name="search" placeholder="Search" />
            </form>
          </section>
        </li>*/


}
</style>
</head>
<body>

 


<div class="header">
  <h1>Football Management System</h1>
</div>

<div class="topnav">
<a href="DirectorHomePage.php">Home </a>
    <form action = "#" method = "POST">
		<input type = "submit" class="logoutbutton" value = "Logout" name = "logout" />
  </form>

  <a href="#" style="float:right">Search</a>

  <input type ="text" placeholder="Search..." style ="float:right; height:30px; margin-top:8px">

</div>

<div class="row">
    <div class="leftcolumn">
    <!--<div class="card">
      <h2>About Me</h2>
      <div class="fakeimg" style="height:100px;">Image</div>
      <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
    </div>-->
    

         <ul id="sideBarStyle">
		 <?php if ($_SESSION['type'] == 'fan' || $_SESSION['type'] == 'admin') {?>
			 <li><a class="active" href="CountriesPage.php">Countries</a></li>
			 <li><a href="Leagues.php">Leagues</a></li>
		 <?php } ?>
		 <li><a href="Clubs.php">Clubs</a></li>
		 <li><a href="TransferNewsPage.php">Transfer News</a></li>
		 <li><a href="Matches.php">Matches</a></li>
		 <li><a href="playersPage.php">Players</a></li>
		 <?php if ($_SESSION['type'] == 'fan') {?>
				<li><a href="Subscriptions.php"><?php echo "Subscriptions"; ?></a></li>
		 <?php } ?>
		 <?php if ($_SESSION['type'] == 'director') {?>
				<li><a href="DirectorTransfers.php">Manage Transfers</a></li>
				<li><a href="DirectorContracts.php">Manage Contracts</a></li>
		 <?php } ?>
		 </ul>


  </div>
  <div class="rightcolumn">
  
 

           
            

	<form action="#" method="POST">
	        <strong>  Player     </strong>

			<div class="form-group">
			<div class="input-group">
					<span class="input-group-addon">
						<i class="glyphicon glyphicon-user"></i>
					</span> 
			<input class="form-control" placeholder="Name" name="name" type="text" autofocus>
			</div>
			</div>

			<div class="form-group">
			<div class="input-group">
					<span class="input-group-addon">
						<i class="glyphicon glyphicon-user"></i>
					</span> 
			<input class="form-control" placeholder="Surname" name="surname" type="text" autofocus>
			</div>
			</div>


			<div class="form-group">
			<div class="input-group">
					<span class="input-group-addon">
						<i class="glyphicon glyphicon-user"></i>
					</span> 
			<input class="form-control" placeholder="Bonus" name="bonus" type="text" autofocus>
			</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<strong> Expiration Date:     </strong>
				   <input type="date" name="date">           
				</div>
			</div>

			<div class="form-group">
				<input type="submit" class="btn btn-lg btn-primary btn-block" value="Request" name = "request">
			</div>
	</form>
  </div>
</div>
</body>
</html>
