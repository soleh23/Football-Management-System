<?php
include('config.php');
session_start();

	if ($_SESSION['loggedIn'] != true){
		header("Location: login.php");
		exit();
	}
	if (isset($_POST['logout'])){
		$_SESSION['loggedIn'] = false;
		header("Location: login.php");
		exit();
	}

/*****This section is for fetching league and club names for filling html***/
$sql = "SELECT name FROM League" ;

$sql2 = "SELECT name FROM Club";

$result = mysqli_query($conn,$sql);

$result2 = mysqli_query($conn,$sql2);

$result3 = mysqli_query($conn,$sql2);



 if(isset($_POST['search'])){
    $searchtext = $_POST['searchtext'];
    $_SESSION['searchtext'] = $searchtext;
    header("Location: Search.php");
}



if($_SERVER["REQUEST_METHOD"] == "POST") 
{
   if (isset($_COOKIE["count"])) 
     $cookie_size = $_COOKIE["count"];
   else 
     echo "Cookie Not Set";



   $home_club =  mysqli_real_escape_string($conn,$_POST['home_club']);

   $away_club =  mysqli_real_escape_string($conn,$_POST['away_club']);

   $start_time = mysqli_real_escape_string($conn,$_POST['starttime']);
 
   $end_time = mysqli_real_escape_string($conn,$_POST['endtime']);

   $stadium = mysqli_real_escape_string($conn,$_POST['stadium']);

   $date = mysqli_real_escape_string($conn,$_POST['date']);

   $league = mysqli_real_escape_string($conn,$_POST['league']);

  // if ( !empty($home_club) && !empty($away_club) && !empty($starttime) &&  )

   if ( $home_club == $away_club )
   {
        ?>

       <script> alert("Please choose different home and away team for creating game ") </script> 

        <?php

   }

   else

   {

       //get home club id 
       $sql = "SELECT ID From Club WHERE name = '$home_club'";

       $result4 = mysqli_query($conn,$sql);

       $row = mysqli_fetch_array($result4,MYSQLI_ASSOC);

       $home_ID = $row['ID'];



       //get away club id

       $sql = "SELECT ID From Club WHERE name = '$away_club'";

       $result4 = mysqli_query($conn,$sql);

       $row = mysqli_fetch_array($result4,MYSQLI_ASSOC);

       $away_ID = $row['ID'];

      
       //insert into game table
       $sql = "INSERT INTO Game (start_time,end_time,stadium,game_date, home_teamID, away_teamID ) 
                           VALUES ('$start_time','$end_time', '$stadium', '$date', '$home_ID', '$away_ID') ";


       mysqli_query($conn,$sql);


       $sql = "SELECT ID FROM Game WHERE game_date = '$date'";
       
       $result4 = mysqli_query($conn,$sql);

       $row = mysqli_fetch_array($result4,MYSQLI_ASSOC);

       $game_ID = $row['ID'];

       //echo $game_ID;


       //get league ID
       $sql = "SELECT ID FROM League WHERE name = '$league'";

       $result4 = mysqli_query($conn,$sql);

       $row = mysqli_fetch_array($result4,MYSQLI_ASSOC);

       $league_ID = $row['ID'];

       //echo $league_ID;



       //add league club
       //add home

       $sql = "INSERT INTO League_Club (leagueID,clubID) VALUES ('$league_ID','$home_ID')";
       mysqli_query($conn,$sql);

       //add away
       $sql = "INSERT INTO League_Club (leagueID,clubID) VALUES ('$league_ID','$away_ID')";
       mysqli_query($conn,$sql);



       for ($x = 1; $x <= $cookie_size; $x++) 
       {
          $stat_values_time = mysqli_real_escape_string($conn,$_POST['time'.$x]);
          $stat_values_action = mysqli_real_escape_string($conn,$_POST['action'.$x]);
          $stat_values_type = mysqli_real_escape_string($conn,$_POST['type'.$x]);
          $stat_values_player = mysqli_real_escape_string($conn,$_POST['player'.$x]);

          if(empty($stat_values_player) && empty($stat_values_type) && empty($stat_values_action) && empty($stat_values_time))
          {
              ?>

              <script> alert("Please fill blank stats ") </script> 

             <?php

          }
          else
          {
           $sql = "SELECT ID FROM Player WHERE name = '$stat_values_player' ";

           $result4 = mysqli_query($conn,$sql);

           $row = mysqli_fetch_array($result4,MYSQLI_ASSOC);

           $player_ID = $row['ID'];

          
           $sql = "INSERT INTO Stats(time,action,type,gameID,playerID) 
                                  VALUES ('$stat_values_time','$stat_values_action', '$stat_values_type', '$game_ID' ,'$player_ID')";

           mysqli_query($conn,$sql);
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

.btn-group .button1 
{
  background-color: #008CBA;
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
/* Add a background color on hover */
.btn-group button:hover {
    background-color: #7e4e41;
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
    display: panel-default;
    clear: both;
}

#sideBarStyle ul {
    
    margin: 0;
    padding: 0;
    width: 200px;
    background-color: #f1f1f1;
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
  <a href="AdminCreateLeague.php">Home </a>
  
  <form action = "#" method = "POST">
        <input type = "submit" class="logoutbutton" value = "Logout" name = "logout" />
  </form>
  
 <form action = "#" method = "POST">
        <input type="submit" style="float:right" name="search" value="Search" class = "searchbutton">
        <input type ="text" name = "searchtext" placeholder="Search..." style ="float:right; width: 260px; height:30px; margin-top:8px; margin-right: 1px">
  </form>
  


</div>

<div class="row">
  <div class ="rightcolumn">
  <h2>Admin Page</h2>

        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="btn-group">
              <a href="AdminCreateLeague.php" target="_self">
              <button>Create League</button>
              </a>
              <a href="AdminCreateClub.php" target="_self">
              <button>Create Club</button>
              </a>
              <a href="AdminCreateAccount.php" target="_self">
              <button>Create Account</button>
              </a>
              <a href="AdminCreateGame.php" target="_self">
              <button class ="button1">Create Game</button>
              </a>
          </div>
          </div>
          <div class="panel-body">
            <form role="form" action="#" method="POST">
              <fieldset>
                <div class="row">
                  
                </div>
                <div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                    <strong>  Leagues:     </strong>
                  
                    <select name= "league">

                        <?php 

                                 while( $row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
                                 {
                                   echo "<option value='".htmlspecialchars($row['name'])."''>".htmlspecialchars($row['name'])."</option>";
                                 }

                        ?>

                    </select>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <strong>  Start Time:     </strong>
                        <input class="form-control" placeholder="Start Time" name="starttime" type="text" autofocus>
                    </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <strong>  End Time:     </strong>
                        <input class="form-control" placeholder="End Time" name="endtime" type="text" autofocus>
                    </div>
                    </div>
                    <endtime class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <strong>  Stadium:     </strong>
                        <input class="form-control" placeholder="Stadium" name="stadium" type="text" value="">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <strong>  Date:     </strong>
                        <form action="/action_page.php">
                        <input type="date" name="date">           
                     </form>
                    </div>
                    </div>
                   <strong>  Home Club:     </strong>
                  
                    <select name= "home_club">

                        <?php 

                                 while( $row = mysqli_fetch_array($result2,MYSQLI_ASSOC)) 
                                 {
                                   echo "<option value='".htmlspecialchars($row['name'])."''>".htmlspecialchars($row['name'])."</option>";
                                 }

                        ?>

                    </select>

                    <strong>  Away Club:     </strong>
                  
                    <select name= "away_club">

                        <?php 

                                 while( $row = mysqli_fetch_array($result3,MYSQLI_ASSOC)) 
                                 {
                                   echo "<option value='".htmlspecialchars($row['name'])."''>".htmlspecialchars($row['name'])."</option>";
                                 }

                        ?>

                    </select>

                    
                    <div class="form-group" id ="stats">
                     <div class="checkbox" >
                       <strong>  Stats: <br>    </strong>
                        

                        

                        <input type="button" id = "addButton" value="Add Stats" >

                
                     </div>

                      
                    </div>
                    
                    <div class="form-group">
                      <input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign Up">
                    </div>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
                </div>
      </div>
  
</div>
 
  <div class="leftcolumn">
	<!--<div class="card">
      <h2>About Me</h2>
      <div class="fakeimg" style="height:100px;">Image</div>
      <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
    </div>-->
    

    	<ul id="sideBarStyle">
		 <li><a class="active" href="CountriesPage.php">Countries</a></li>
		 <li><a href="Leagues.php">Leagues</a></li>
		 <li><a href="Clubs.php">Clubs</a></li>
		 <li><a href="TransferNewsPage.php">Transfer News</a></li>
		 <li><a href="Matches.php">Matches</a></li>
		 <li><a href="playersPage.php">Players</a></li>
		</ul>


  </div>

   
   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script text ="text/javascript">
      
      $(document).ready(function() 
      {

              var count = 0;         
              $("#addButton").click(function() 
              {
                           
        
                         count = count + 1;
                      
                         $('#stats').append ( '<div class = "checkbox" > <input class="form-control" placeholder="time" name="time'+count+'"'+'type="text" autofocus> <input class="form-control" placeholder="action" name="action'+count+'"'+'type="text" autofocus> <input class="form-control" placeholder="type" name="type'+count+'"'+'type="text" autofocus><input class="form-control" placeholder="player" name="player'+count+'"'+'type="text" autofocus> </div>');

            

                 document.cookie='count='+count;        
             
            });
        });

                        
    </script>

</body>








</html>
