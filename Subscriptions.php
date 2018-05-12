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
	$fanID = $_SESSION['id'];
	$clubsQuery = "SELECT DISTINCT Club.name as name FROM Subscribe, Club WHERE Subscribe.fanID = '".$fanID."' AND Subscribe.clubID = Club.ID";
	$clubs = mysqli_query($connection, $clubsQuery);
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
  <a href="FanHomePage.php">Home       </a>
  <a href="EditProfile.php">Settings</a>


  <a href="#" style="float:right">Search</a>

  <input type ="text" placeholder="Search..." style ="float:right">

</div>
  <div class="leftcolumn">
    	 <ul id="sideBarStyle">
         <li><a class="active" href="CountriesPage.php">Countries</a></li>
         <li><a href="Leagues.php">Leagues</a></li>
         <li><a href="Clubs.php">Clubs</a></li>
         <li><a href="TransferNewsPage.php">Transfer News</a></li>
         <li><a href="Matches.php">Matches</a></li>
         <li><a href="playersPage.php">Players</a></li>
         <li><a href="Subscriptions.php">Subscriptions</a></li>
    	 </ul>
  </div>
  <div class="rightcolumn">
	<div class="row">
	  
	  <h2>Subscriptions</h2>


	<table>
	  <tr>
		<th>Club Name</th>
	  </tr>
		<?php while ($row = mysqli_fetch_assoc($clubs)){ ?>
			<tr>
				<td><?php echo $row['name']; ?></td>
			</tr>
		<?php } ?>

	</table>
	</div>
   </div>
</body>
</html>
