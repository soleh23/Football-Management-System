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
	$homeLink = "#";
	if ($_SESSION['type'] == 'fan')
  {
		$homeLink = "FanHomePage.php";
		
		$fanID = $_SESSION['id'];
		$favTeamID = $_SESSION['favTeamID'];
		
		$playersQuery = "SELECT DISTINCT name, surname, nationality, position, age FROM Player, Plays WHERE Player.ID = Plays.playerID AND Plays.clubID IN (SELECT clubID FROM Subscribe WHERE Subscribe.fanID = '".$fanID."')";
		$players = mysqli_query($connection, $playersQuery);
	}
        
        else if ($_SESSION['type'] == 'guest'){
		$homeLink = "Matches.php";
		
		$playersQuery = "SELECT DISTINCT name, surname, nationality, position, age FROM Player, Plays WHERE Player.ID = Plays.playerID AND Plays.clubID";
		$players = mysqli_query($connection, $playersQuery);
	}

	else if ($_SESSION['type'] == 'director'){
		$homeLink = "DirectorHomePage.php";
		
		$playersQuery = "SELECT DISTINCT name, surname, nationality, position, age FROM Player ORDER BY position, age ASC";
		$players = mysqli_query($connection, $playersQuery);
	}
	else if ($_SESSION['type'] == 'admin'){
		$homeLink = "AdminCreateLeague.php";
		
		$playersQuery = "SELECT DISTINCT name, surname, nationality, position, age FROM Player ORDER BY position, age ASC";
		$players = mysqli_query($connection, $playersQuery);
	}
	else if ($_SESSION['type'] == 'agent'){
		$homeLink = "AgentHomePage.php";
		
		$playersQuery = "SELECT DISTINCT name, surname, nationality, position, age FROM Player ORDER BY position, age ASC";
		$players = mysqli_query($connection, $playersQuery);
	}

  else if ($_SESSION['type'] == 'coach'  )
  {
     $homeLink = "CoachHomePage.php";
   
     $sql = "SELECT DISTINCT name, surname, nationality, position, age FROM Player";

     $players = mysqli_query($connection, $sql);
  }
  else if ( $_SESSION['type'] == 'player' )
  {
     $homeLink = "PlayersHomePage.php";

     $player_id = $_SESSION['id'];

     $sql = "SELECT DISTINCT name, surname, nationality, position, age FROM Player WHERE ID != '$player_id' ";

     $players = mysqli_query($connection, $sql);
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
  <a href=<?php echo $homeLink; ?> >Home       </a>
  <?php if ($_SESSION['type'] == 'fan') { ?>
  <a href="EditProfile.php">Settings</a>
  <?php } ?>

	<form action = "#" method = "POST">
		<input type = "submit" class="logoutbutton" value = "Logout" name = "logout" />
  </form>
  <a href="#" style="float:right">Search</a>

  <input type ="text" placeholder="Search..." style ="float:right; height:30px; margin-top:8px">

</div>

<div class="row">
  <div class ="rightcolumn">
  <h2>Players</h2>

<table>
<tr>
	<th>Name</th>
    <th>Age</th>
    <th>Position</th>
	<th>Nationality</th>
</tr>
  <?php while ($row = mysqli_fetch_assoc($players)){ ?>
			<tr>
				<td><?php echo $row['name'].' '.$row['surname']; ?></td>
				<td><?php echo $row['age']; ?></td>
				<td><?php echo $row['position']; ?></td>
				<td><?php echo $row['nationality']; ?></td>
			</tr>
		<?php } ?>
</table>
  
</div>
 
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
				<li><a href="TransferOffersPage.php">Manage Transfers</a></li>
				<li><a href="DirectorContracts.php">Manage Contracts</a></li>
		 <?php } ?>
		 <?php if ($_SESSION['type'] == 'agent') {?>
				<li><a href="AgentTransfers.php">Manage Transfers</a></li>
				<li><a href="AgentContracts.php">Manage Contracts</a></li>
		 <?php } ?>


     <?php if ($_SESSION['type'] == 'coach' || $_SESSION['type'] == 'player' ) { ?>
        <li><a href="playersTransfer.php"> Players Transfer</a></li>
     
     <?php } ?>

		 </ul>

    


  </div>



 

</body>
</html>
