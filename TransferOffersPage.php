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
	
	if (isset($_POST['acceptOffer'])){
		$playerID = $_POST['id1'];
		$fromDirectorID = $_POST['id2'];
		$toDirectorID = $_POST['id3'];
		$status = $_POST['id4'];
		
		if ($status == '0'){
			$status = '2';
		}
		else if ($status != '3'){
			$sold = true;
			$status = '3';
			$contractDeleteQuery = "DELETE FROM Contract WHERE playerID = '".$playerID."'";
			mysqli_query($connection, $contractDeleteQuery);
			
			$newClubQuery = "SELECT Club.ID FROM Director, Club WHERE Director.club_ID = Club.ID AND Director.ID = '".$fromDirectorID."'";
			$newClub = mysqli_query($connection, $newClubQuery)->fetch_object();
			
			$updatePlaysQuery = "UPDATE Plays SET clubID = '".$newClub->ID."' WHERE playerID = '".$playerID."'";
			mysqli_query($connection, $updatePlaysQuery);
			
			$deleteTransferQuery = "DELETE FROM Transfer_Offer WHERE playerID = '".$playerID."' AND fromDirectorID <> '".$fromDirectorID."'";
			mysqli_query($connection, $deleteTransferQuery);
		}
		
		$updateQuery = "UPDATE Transfer_Offer SET status = '".$status."' WHERE playerID = '".$playerID."' AND fromDirectorID = '".$fromDirectorID."' AND toDirectorID = '".$toDirectorID."' AND status <> '3'";
		mysqli_query($connection, $updateQuery);
	}
	if (isset($_POST['rejectOffer'])){
		$playerID = $_POST['id1'];
		$fromDirectorID = $_POST['id2'];
		$toDirectorID = $_POST['id3'];

		$updateQuery = "DELETE FROM Transfer_Offer WHERE playerID = '".$playerID."' AND fromDirectorID = '".$fromDirectorID."' AND toDirectorID = '".$toDirectorID."'";
		mysqli_query($connection, $updateQuery);
	}
	
	$myClubID = $_SESSION['myClubID'];
	$curDirectorID = $_SESSION['id'];
	
	$transfersQuery = "SELECT fromDirectorID, toDirectorID, price, status, playerID FROM Transfer_Offer WHERE toDirectorID = '".$curDirectorID."'";
	$transfers = mysqli_query($connection, $transfersQuery);
	
	$names = array();
	$prices = array();
	$statuses = array();
	$playerIDs = array();
	$fromDirectorIDs = array();
	$toDirectorIDs = array();
	$elementsNo = 0;
	while ($row = mysqli_fetch_assoc($transfers)){ 
		$curPlayerNameQuery = "SELECT name, surname FROM Player WHERE ID = '".$row['playerID']."'";
		$curPlayerName = mysqli_query($connection, $curPlayerNameQuery)->fetch_object();
		array_push($names, $curPlayerName->name." ".$curPlayerName->surname);
		
		array_push($prices, $row['price']);
		array_push($playerIDs, $row['playerID']);
		array_push($fromDirectorIDs, $row['fromDirectorID']);
		array_push($toDirectorIDs, $row['toDirectorID']);
		
		if ($row['status'] == '0'){
			$curStatus = "Requested";
		}
		else if ($row['status'] == '1'){
			$curStatus = "Agent Accepted";
		}
		else if ($row['status'] == '2'){
			$curStatus = "Director Accepted";
		}
		else {
			$curStatus = "Transfer Completed";
		}
		array_push($statuses, $curStatus);
		
		$elementsNo = $elementsNo + 1;
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

<div class="rightcolumn">
  
  <h2>Transfer Offer Page</h2>
<div class="btn-group">
    <a href="TransferOffersPage.php" target="_self">
        <button>Offers</button>
    </a>
    <a href="TransferRequestsPage.php" target="_self">
        <button>Requests</button>
    </a>
    <a href="MakeTransferRequest.php" target="_self">
        <button>Create Transfer Requests</button>
    </a>
</div>

<table>
<tr>
  <th>Name</th>
    <th>Price</th>
    <th>Status</th>
	<th>Action</th>
</tr>
		    <?php 
			  $cnt = 0;
			  while ($cnt < $elementsNo){ ?>
						<tr>
							<td><?php echo $names[$cnt]; ?></td>
							<td><?php echo $prices[$cnt]; ?>$</td>
							<td><?php echo $statuses[$cnt]; ?></td>
							<td>
								<?php
									$curPlayerID = $playerIDs[$cnt];
									$curFromDirectorID = $fromDirectorIDs[$cnt];
									$curToDirectorID = $toDirectorIDs[$cnt];
									$curStatus = '0';
									if ($statuses[$cnt] == 'Agent Accepted')
										$curStatus = '1'; 
									if ($statuses[$cnt] == 'Requested' || $statuses[$cnt] == 'Agent Accepted') { ?>
										<form action = "#" method = "POST">
											<input type = "hidden" name = "id1" value = "<?=$curPlayerID?>" >
											<input type = "hidden" name = "id2" value = "<?=$curFromDirectorID?>" >
											<input type = "hidden" name = "id3" value = "<?=$curToDirectorID?>">
											<input type = "hidden" name = "id4" value = "<?=$curStatus?>">
											<input type = "submit" value = "Accept" name = "acceptOffer"/>
											<input type = "submit" value = "Reject" name = "rejectOffer"/>
										</form
									<?php } ?>
									<?php if ($statuses[$cnt] == 'Director Accepted' || $statuses[$cnt] == 'Transfer Completed') { 
											echo "N/A";
									} ?>
							</td>
						</tr>
					<?php $cnt = $cnt + 1;} ?>
</table>
</div>
  <div class="leftcolumn">

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
		 </ul>



  </div>
</body>
</html>
