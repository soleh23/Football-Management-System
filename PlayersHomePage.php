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

	//image holds users's image
	$myImage = '<img src="images/'.$_SESSION['username'].'.jpg"'.'style="height:200px; width: 280px">';
  $sql = "SELECT * FROM Player WHERE ID = '".$_SESSION['id']."'";
  $player  = mysqli_query($connection, $sql)->fetch_object();


  //get player agent
  $sql = "SELECT * FROM Agent WHERE ID = '$player->agent_ID'";
  $agent = mysqli_query($connection, $sql)->fetch_object();

  //get player club
  $sql = "SELECT * FROM Plays,Club WHERE Plays.clubID = Club.ID AND Plays.playerID = '$player->ID'";
  $club = mysqli_query($connection, $sql)->fetch_object();
 
?>
<!DOCTYPE html>
<html>
<head>
<style>
* {
    box-sizing: border-box;
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
    float: left;
    width: 75%;
    background-color: #f1f1f1;
    padding-left: 20px;
}
.rightcolumn2 {
    float: right;
    width: 35%;
    background-color: #f1f1f1;
    padding-left: 50px;
    padding-right: 100px;
}

/* Fake image */
.fakeimg {
    background-color: #aaa;
    width: 100%;
    padding: 20px;
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
  <a href="PlayersHomePage.php">Home       </a>

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
         <ul id="sideBarStyle">
         <li><a href="Clubs.php">Clubs</a></li>
         <li><a href="TransferNewsPage.php">Transfer News</a></li>
         <li><a href="Matches.php">Matches</a></li>
         <li><a href="playersPage.php">Players</a></li>
         <li><a href="playersTransfer.php">Players Transfer</a></li>
    	 </ul>


  </div>


  <div class="rightcolumn">
    
    <div class="card">

      <div class="rightcolumn2">
          <p>Name: <?php   echo $player->name ?>
           <br>Surname: <?php   echo $player->surname ?>
           <br>Age: <?php   echo $player->age ?>
           <br>Salary: <?php   echo $player->salary ?>
           <br>Nationality: <?php   echo $player->nationality ?>
           <br>Position: <?php   echo $player->position ?>
           <br>Agent: <?php   echo $agent->name ?>
           <br>Club: <?php   echo $club->name ?>
           <br> 
          </p>
      </div>
      <div  >
		  <?php
			echo $myImage;
		  ?>
	  </div>
      
  </div>

</div>

 

</body>
</html>
