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
		
		$transfersQuery = "SELECT DISTINCT price, transferDate, playerID, fromDirectorID, toDirectorID
							FROM Transfer_Offer, Director
							WHERE (Transfer_Offer.fromDirectorID = Director.ID OR Transfer_Offer.toDirectorID = Director.ID) AND Transfer_Offer.status = '3' AND Director.club_ID IN (SELECT clubID FROM Subscribe WHERE Subscribe.fanID = '".$fanID."')";
		$transfers = mysqli_query($connection, $transfersQuery);
		
		$fromTeams = array();
		$names = array();
		$toTeams = array();
		$prices = array();
		$transferDates = array();
		$elementsNo = 0;
		while ($row = mysqli_fetch_assoc($transfers)){
			$fromTeamQuery = "SELECT Club.name FROM Club, Director WHERE Director.club_ID = Club.ID AND Director.ID = '".$row['fromDirectorID']."'";
			$fromTeam = mysqli_query($connection, $fromTeamQuery)->fetch_object();
			array_push($fromTeams, $fromTeam->name);
			
			$toTeamQuery = "SELECT Club.name FROM Club, Director WHERE Director.club_ID = Club.ID AND Director.ID = '".$row['toDirectorID']."'";
			$toTeam = mysqli_query($connection, $toTeamQuery)->fetch_object();
			array_push($toTeams, $toTeam->name);
			
			$nameQuery = "SELECT name, surname FROM Player WHERE Player.ID = '".$row['playerID']."'";
			$name = mysqli_query($connection, $nameQuery)->fetch_object();
			array_push($names, $name->name." ".$name->surname);
			
			array_push($prices, $row['price']);
			array_push($transferDates, $row['transferDate']);
			
			$elementsNo = $elementsNo + 1;
		} 
	}

	else if ($_SESSION['type'] == 'director'){
		$homeLink = "DirectorHomePage.php";
		
		$transfersQuery = "SELECT DISTINCT price, transferDate, playerID, fromDirectorID, toDirectorID
							FROM Transfer_Offer
							WHERE Transfer_Offer.status = '3'
							ORDER BY Transfer_Offer.transferDate DESC";
		$transfers = mysqli_query($connection, $transfersQuery);
		
		$fromTeams = array();
		$names = array();
		$toTeams = array();
		$prices = array();
		$transferDates = array();
		$elementsNo = 0;
		while ($row = mysqli_fetch_assoc($transfers)){
			$fromTeamQuery = "SELECT Club.name FROM Club, Director WHERE Director.club_ID = Club.ID AND Director.ID = '".$row['fromDirectorID']."'";
			$fromTeam = mysqli_query($connection, $fromTeamQuery)->fetch_object();
			array_push($fromTeams, $fromTeam->name);
			
			$toTeamQuery = "SELECT Club.name FROM Club, Director WHERE Director.club_ID = Club.ID AND Director.ID = '".$row['toDirectorID']."'";
			$toTeam = mysqli_query($connection, $toTeamQuery)->fetch_object();
			array_push($toTeams, $toTeam->name);
			
			$nameQuery = "SELECT name, surname FROM Player WHERE Player.ID = '".$row['playerID']."'";
			$name = mysqli_query($connection, $nameQuery)->fetch_object();
			array_push($names, $name->name." ".$name->surname);
			
			array_push($prices, $row['price']);
			array_push($transferDates, $row['transferDate']);
			
			$elementsNo = $elementsNo + 1;
		} 
	}
	else if ($_SESSION['type'] == 'admin'){
		$homeLink = "AdminCreateLeague.php";
		
		$transfersQuery = "SELECT DISTINCT price, status, playerID, fromDirectorID, toDirectorID
							FROM Transfer_Offer
							ORDER BY Transfer_Offer.transferDate DESC";
		$transfers = mysqli_query($connection, $transfersQuery);
		
		$fromTeams = array();
		$names = array();
		$toTeams = array();
		$prices = array();
		$statuses = array();
		$elementsNo = 0;
		while ($row = mysqli_fetch_assoc($transfers)){
			$fromTeamQuery = "SELECT Club.name FROM Club, Director WHERE Director.club_ID = Club.ID AND Director.ID = '".$row['fromDirectorID']."'";
			$fromTeam = mysqli_query($connection, $fromTeamQuery)->fetch_object();
			array_push($fromTeams, $fromTeam->name);
			
			$toTeamQuery = "SELECT Club.name FROM Club, Director WHERE Director.club_ID = Club.ID AND Director.ID = '".$row['toDirectorID']."'";
			$toTeam = mysqli_query($connection, $toTeamQuery)->fetch_object();
			array_push($toTeams, $toTeam->name);
			
			$nameQuery = "SELECT name, surname FROM Player WHERE Player.ID = '".$row['playerID']."'";
			$name = mysqli_query($connection, $nameQuery)->fetch_object();
			array_push($names, $name->name." ".$name->surname);
			
			array_push($prices, $row['price']);
			array_push($statuses, $row['status']);
			
			$elementsNo = $elementsNo + 1;
		}
	}
	else if ($_SESSION['type'] == 'agent'){
		$homeLink = "AgentHomePage.php";
		
		$transfersQuery = "SELECT DISTINCT price, status, playerID, fromDirectorID, toDirectorID
							FROM Transfer_Offer
							WHERE Transfer_Offer.status = '3'
							ORDER BY Transfer_Offer.transferDate DESC";
		$transfers = mysqli_query($connection, $transfersQuery);
		
		$fromTeams = array();
		$names = array();
		$toTeams = array();
		$prices = array();
		$statuses = array();
		$elementsNo = 0;
		while ($row = mysqli_fetch_assoc($transfers)){
			$fromTeamQuery = "SELECT Club.name FROM Club, Director WHERE Director.club_ID = Club.ID AND Director.ID = '".$row['fromDirectorID']."'";
			$fromTeam = mysqli_query($connection, $fromTeamQuery)->fetch_object();
			array_push($fromTeams, $fromTeam->name);
			
			$toTeamQuery = "SELECT Club.name FROM Club, Director WHERE Director.club_ID = Club.ID AND Director.ID = '".$row['toDirectorID']."'";
			$toTeam = mysqli_query($connection, $toTeamQuery)->fetch_object();
			array_push($toTeams, $toTeam->name);
			
			$nameQuery = "SELECT name, surname FROM Player WHERE Player.ID = '".$row['playerID']."'";
			$name = mysqli_query($connection, $nameQuery)->fetch_object();
			array_push($names, $name->name." ".$name->surname);
			
			array_push($prices, $row['price']);
			array_push($statuses, $row['status']);
			
			$elementsNo = $elementsNo + 1;
		}
	}

  else if($_SESSION['type'] == 'coach' || $_SESSION['type'] == 'player' )
  {
      if($_SESSION['type'] == 'coach')
      {  
        $homeLink = "CoachHomePage.php";
      }
      else
      {
        $homeLink = "PlayersHomePage.php";
      }

      $transfersQuery = "SELECT DISTINCT price, transferDate, playerID, fromDirectorID, toDirectorID
              FROM Transfer_Offer WHERE status = '3'";

      $transfers = mysqli_query($connection, $transfersQuery);

      $fromTeams = array();
      $names = array();
      $toTeams = array();
      $prices = array();
      $transferDates = array();
      $elementsNo = 0;

      while ($row = mysqli_fetch_assoc($transfers))
      {
        $fromTeamQuery = "SELECT Club.name FROM Club, Director WHERE Director.club_ID = Club.ID AND Director.ID = '".$row['fromDirectorID']."'";
        $fromTeam = mysqli_query($connection, $fromTeamQuery)->fetch_object();
        array_push($fromTeams, $fromTeam->name);
        
        $toTeamQuery = "SELECT Club.name FROM Club, Director WHERE Director.club_ID = Club.ID AND Director.ID = '".$row['toDirectorID']."'";
        $toTeam = mysqli_query($connection, $toTeamQuery)->fetch_object();
        array_push($toTeams, $toTeam->name);
        
        $nameQuery = "SELECT name, surname FROM Player WHERE Player.ID = '".$row['playerID']."'";
        $name = mysqli_query($connection, $nameQuery)->fetch_object();
        array_push($names, $name->name." ".$name->surname);
        
        array_push($prices, $row['price']);
        array_push($transferDates, $row['transferDate']);
        
        $elementsNo = $elementsNo + 1;
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
  <a href=<?php echo $homeLink; ?> >Home</a>
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
  <h2>Transfers</h2>

<table>
<tr>
	<th>Name</th>
    <th>From Club</th>
    <th>To Club</th>
	<th>Price</th>
	<th>Status</th>
</tr>
  <?php 
  $cnt = 0;
  while ($cnt < $elementsNo){ ?>
			<tr>
				<td><?php echo $names[$cnt]; ?></td>
				<td><?php echo $fromTeams[$cnt]; ?></td>
				<td><?php echo $toTeams[$cnt]; ?></td>
				<td><?php echo $prices[$cnt]; ?></td>
				<td>
					<?php 
					if ($statuses[$cnt] == '3'){
						echo "Completed"; 
					}
					else if ($statuses[$cnt] == '4'){
						echo "Failed"; 
					}
					else {
						echo "Pending"; 
					}
					?>
				</td>
			</tr>
		<?php $cnt = $cnt + 1;} ?>
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

     <?php if ($_SESSION['type'] == 'coach' || $_SESSION['type'] == 'player') {?>
        <li><a href="playersTransfer.php">Players Transfer </a></li>
     </ul>
     <?php } ?>

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
		 </ul>
     <?php } ?>

  </div>



 

</body>
</html>
