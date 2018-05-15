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
        
        if(isset($_POST['search'])){
            $searchtext = $_POST['searchtext'];
            $_SESSION['searchtext'] = $searchtext;
            header("Location: Search.php");
        }
	$curAgentID = $_SESSION['id'];
	if (isset($_POST['accept'])){
		$playerID = $_POST['id1'];
		$updateQuery = "UPDATE Contract SET status = '2' WHERE playerID = '".$playerID."' AND agentID = '".$curAgentID."'";
		mysqli_query($connection, $updateQuery);
	}
	
	if (isset($_POST['cancel'])){
		$playerID = $_POST['id1'];
		$updateQuery = "DELETE FROM Contract WHERE playerID = '".$playerID."' AND agentID = '".$curAgentID."' AND status <> '2'";
		mysqli_query($connection, $updateQuery);
	}
	
	if (isset($_POST['reject'])){
		$playerID = $_POST['id1'];
		$updateQuery = "DELETE FROM Contract WHERE playerID = '".$playerID."' AND agentID = '".$curAgentID."' AND status <> '2'";
		mysqli_query($connection, $updateQuery);
	}
	
	
	
	$contractsQuery = "SELECT playerID, expirationDate, bonus, status, playerID FROM Contract WHERE agentID = '".$curAgentID."'";
	$contracts = mysqli_query($connection, $contractsQuery);
	
	$names = array();
	$expirationDates = array();
	$bonuses = array();
	$statuses = array();
	$playerIDs = array();
	$elementsNo = 0;
	while ($row = mysqli_fetch_assoc($contracts)){ 
		$curPlayerNameQuery = "SELECT name, surname FROM Player WHERE ID = '".$row['playerID']."'";
		$curPlayerName = mysqli_query($connection, $curPlayerNameQuery)->fetch_object();
		array_push($names, $curPlayerName->name." ".$curPlayerName->surname);
		
		array_push($expirationDates, $row['expirationDate']);
		array_push($playerIDs, $row['playerID']);
		array_push($bonuses, $row['bonus']);
		
		if ($row['status'] == '0'){
			$curStatus = "Waiting for Response";
		}
		else if ($row['status'] == '1'){
			$curStatus = "Director Requested";
		}	
		else {
			$curStatus = "Extended";
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

.searchbutton {
    background-color: #4CAF50; /* Red */
    border: none;
    color: white;
    padding: 14px 31px;
    text-align: center;
    text-decoration: none;
    margin-right: 20px;
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
.searchbutton {
    background-color: #4CAF50; /* Red */
    border: none;
    color: white;
    padding: 14px 31px;
    text-align: center;
    text-decoration: none;
    margin-right: 20px;
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
    <a href="AgentHomePage.php">Home </a>
	<form action = "#" method = "POST">
		<input type = "submit" class="logoutbutton" value = "Logout" name = "logout" />
  </form>

 <form action = "#" method = "POST">
        <input type="submit" style="float:right" name="search" value="Search" class = "searchbutton">
        <input type ="text" name = "searchtext" placeholder="Search..." style ="float:right; width: 260px; height:30px; margin-top:8px; margin-right: 1px">
  </form>

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
				<li><a href="TransferOffersPage.php">Manage Transfers</a></li>
				<li><a href="DirectorContracts.php">Manage Contracts</a></li>
		 <?php } ?>
		 <?php if ($_SESSION['type'] == 'agent') {?>
				<li><a href="AgentTransfers.php">Manage Transfers</a></li>
				<li><a href="AgentContracts.php">Manage Contracts</a></li>
		 <?php } ?>
		 </ul>


  </div>
  <div class="rightcolumn">

		<div class="btn-group">
			<a href="AgentExtendContractRequest.php" target="_self">
				<button style="margin-top: 10px">Extend Contract</button>
			</a>
		</div>
        <h2>Contract Information Table</h2>
		<table>
		<tr>
		  <th>Name</th>
		  <th>New Expiration Date</th>
		  <th>Bonus</th>
		  <th>Status</th>
		  <th>Action</th>
		</tr>
		    <?php 
			  $cnt = 0;
			  while ($cnt < $elementsNo){ ?>
						<tr>
							<td><?php echo $names[$cnt]; ?></td>
							<td><?php echo $expirationDates[$cnt]; ?></td>
							<td><?php echo $bonuses[$cnt]; ?>$</td>
							<td><?php echo $statuses[$cnt]; ?></td>
							<td>
								<?php
									$curPlayerID = $playerIDs[$cnt];
									if ($statuses[$cnt] == 'Director Requested') { ?>
										<form action = "#" method = "POST">
											<input type = "hidden" name = "id1" value = "<?=$curPlayerID?>">
											<input type = "submit" value = "Accept" name = "accept"/>
											<input type = "submit" value = "Reject" name = "reject"/>
										</form
									<?php } ?>
									<?php if ($statuses[$cnt] == 'Waiting for Response') { ?>
										<form action = "#" method = "POST">
											<input type = "hidden" name = "id1" value = "<?=$curPlayerID?>">
											<input type = "submit" value = "Cancel" name = "cancel"/>
										</form
									<?php } ?>
									<?php if ($statuses[$cnt] == 'Extended') { 
											echo "N/A";
									 } ?>
							</td>
						</tr>
					<?php $cnt = $cnt + 1;} ?>
		</table>
            
  </div>
</div>
</body>
</html>
