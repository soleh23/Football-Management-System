<?php
 include('config.php');
 session_start();
 
 //fetching league names
 $sql = "SELECT name FROM League" ;
 $result = mysqli_query($conn,$sql);

 if($_SERVER["REQUEST_METHOD"] == "POST") 
 {
     $name = mysqli_real_escape_string($conn,$_POST['name']);
     $transfer_budget = mysqli_real_escape_string($conn,$_POST['transferbudget']);
     $annualwagebudget = mysqli_real_escape_string($conn,$_POST['annualwagebudget']);
     $stadium = mysqli_real_escape_string($conn,$_POST['stadium']);
     $value = mysqli_real_escape_string($conn,$_POST['value']);
     $league = mysqli_real_escape_string($conn,$_POST['league']);
     $city = mysqli_real_escape_string($conn,$_POST['city']);
     $date = mysqli_real_escape_string($conn,$_POST['date']);


     $sql = "SELECT name FROM Club WHERE name = '$name'";

     $result2 = mysqli_query($conn,$sql);

     

       if( !empty($name) && !empty($transfer_budget) && !empty($annualwagebudget) && !empty($stadium) 
           && !empty($value) && !empty($league) && !empty($city) && !empty($date) )
       {

          if( mysqli_num_rows($result2) == 1 )
          {
            ?>

              <script> alert("Please choose unique club name") </script>

             <?php

          }
          else
          {
              // insert specified club into club table
              $sql = "INSERT INTO Club(name,transfer_budget,annual_wage_budget,city,establishment_date,value,stadium) 
                      VALUES( '$name', '$transfer_budget', '$annualwagebudget', '$city', '$date',  '$value', '$stadium' )";
              mysqli_query($conn,$sql);


              //get ID of added club
              $sql = "SELECT ID FROM Club WHERE name = '$name'";
              $result2 = mysqli_query($conn,$sql);
              $row = mysqli_fetch_array($result2,MYSQLI_ASSOC);
              $clubID = $row['ID'];

              //get ID of league 
              $sql = "SELECT ID FROM League WHERE name = '$league'";
              $result2 = mysqli_query($conn,$sql);
              $row = mysqli_fetch_array($result2,MYSQLI_ASSOC);
              $leagueID = $row['ID'];

            
              //insert club into that league
              $sql = "INSERT INTO League_Club(leagueID,clubID) VALUES( '$leagueID', '$clubID' )";  
              mysqli_query($conn,$sql);  

          }   
       }
       else
       {
          ?>

          <script> alert("Please fill out blank places") </script>

          <?php
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


}
</style>
</head>
<body>

 


<div class="header">
  <h1>Football Management System</h1>
</div>

<div class="topnav">
  <a href="AdminCreateLeague.php">Home </a>
  

  <a href="#" style="float:right">Search</a>

  <input type ="text" placeholder="Search..." style ="float:right">

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
              <button class="button1">Create Club</button>
              </a>
              <a href="AdminCreateAccount.php" target="_self">
              <button>Create Account</button>
              </a>
              <a href="AdminCreateGame.php" target="_self">
              <button>Create Game</button>
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
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span>
                         <strong>  Name:     </strong>
                        <input class="form-control" placeholder="Name" name="name" type="text" autofocus>
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <strong>  Transfer Budget:     </strong>
                        <input class="form-control" placeholder="Transfer Budget" name="transferbudget" type="text" autofocus>
                    </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <strong>  Annual Wage Budget:     </strong>
                        <input class="form-control" placeholder="Annual Wage Budget" name="annualwagebudget" type="text" autofocus>
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
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <strong>  Value:     </strong>
                        <input class="form-control" placeholder="Value" name="value" type="text" autofocus>
                    </div>
                    </div>
                   
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
                        <strong>  City:     </strong>
                        <input class="form-control" placeholder="City" name="city" type="text" autofocus>
                    </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <strong> Establishment Date:     </strong>
                        <form action="/action_page.php">
                        <input type="date" name="date">           
                     </form>
                    </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <input type="submit" class="btn btn-lg btn-primary btn-block" value="Done">
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
        <li><a class="active" href="CountriesPage.html">Countries</a></li>
         <li><a href="LeagueTablePage.html">League</a></li>
         <li><a href="ClubsPage.html">Clubs</a></li>
         <li><a href="TransferNewsPage.html">Transfer News</a></li>
         <li><a href="GuestPage.html">Matches</a></li>
         <li><a href="playersPage.html">Players</a></li>
       </ul>


  </div>



 

</body>
</html>
