<?php
 include('config.php');
 session_start();



 $sql = "SELECT name FROM Club" ;
 $result4 = mysqli_query($conn,$sql);

 $sql  = "SELECT name FROM Agent";
 $result5 = mysqli_query($conn,$sql);



 if($_SERVER["REQUEST_METHOD"] == "POST") 
 {
      $myType =  mysqli_real_escape_string($conn,$_POST["type"]);
     
      if (  !empty($_POST["name"]) && !empty($_POST["username"]) && !empty($_POST["salary"]) && !empty($_POST["password"]) &&  !empty($_POST["agent"])   && !empty($_POST["club"]) && !empty($_POST["age"]) && !empty($_POST["surname"])  &&  !empty($_POST["nationality"])  && !empty($_POST["birthdate"]) )
      {
           $name = mysqli_real_escape_string($conn,$_POST['name']);
           
           $username = mysqli_real_escape_string($conn,$_POST['username']); 
           
           $salary = mysqli_real_escape_string($conn,$_POST['salary']);
           
           $password = mysqli_real_escape_string($conn,$_POST['password']);

           $agent_name = mysqli_real_escape_string($conn,$_POST['agent']);

           $club_name = mysqli_real_escape_string($conn,$_POST["club"]);;

           $age = mysqli_real_escape_string($conn,$_POST['age']);
           
           $birthdate = mysqli_real_escape_string($conn,$_POST['birthdate']);

           $nationality = mysqli_real_escape_string($conn,$_POST['nationality']);

           $surname = mysqli_real_escape_string($conn,$_POST['surname']);

           $position = mysqli_real_escape_string($conn,$_POST['position']);

           /***USERNAME CHECK *****/


           $sql = "SELECT username FROM Player WHERE username = '$username'";

           $result = mysqli_query($conn,$sql);

           $sql = "SELECT username FROM Director WHERE username = '$username'";
           
           $result1 = mysqli_query($conn,$sql);

           $sql = "SELECT username FROM Coach WHERE username = '$username'";

           $result2 = mysqli_query($conn,$sql);

           $sql = "SELECT username FROM Agent WHERE username = '$username'";

           $result3 = mysqli_query($conn,$sql);


             if( mysqli_num_rows($result) == 1 || mysqli_num_rows($result1) == 1 || mysqli_num_rows($result2) || mysqli_num_rows($result3))
             {
                ?>

                <script> alert("Please choose unique user name") </script>

                <?php

              
             }


             else 
             {
          
                  /********This parts get agent id from agent table*/////
                     //get agent id sql
                     $sql_agent = "SELECT ID FROM Agent WHERE name = '$agent_name'";

                     //query and get result agent id
                     $result = mysqli_query($conn,$sql_agent);

                     //get row of result
                     $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

                     // put agent id to variable
                     $agent_ID = $row['ID'];

                     echo $agent_ID;

                     //check the agent in table
                     $count = mysqli_num_rows($result);

                   

                   /*****this part fetches club id from club table using club name**********/


                    $sql_club = "SELECT ID FROM Club WHERE name = '$club_name'";

                    $result = mysqli_query($conn,$sql_club);
                   
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

                   
                    $club_ID = $row['ID'];

                   
                    echo $myType;
                    
                    if ( $myType == 'Player')
                     {
                        
                       // insert new player to player table
                       $sql = "INSERT INTO Player( username,password,name,surname,age,salary,nationality,position,birthdate,agent_ID )
                              VALUES ( '$username','$password', '$name', '$surname','$age', '$salary', '$nationality','$position', '$birthdate','$agent_ID' ) ";

           
                       mysqli_query($conn,$sql);

                       
                       //get ID of added player
                       $sql2 = "SELECT ID FROM Player WHERE username = '$username' ";
                       
                       $result = mysqli_query($conn,$sql2);
                        
                       $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

                       $player_ID = $row['ID'];

                       echo $player_ID;

                       //get current date
                       $current_date =  date('Y-m-d');


                       //update plays relation
                       $sql3 = "INSERT INTO Plays ( clubID,playerID,startDate,endDate ) VALUES ( '$club_ID','$player_ID','$current_date', NULL )";


                       mysqli_query($conn,$sql3);

                              
                     }
                     else if ( $myType == 'Director')
                     {
                       // insert new director to director table
                       $sql = "INSERT INTO Director( username,password,name,surname,age,salary,nationality,birthdate,club_ID )
                              VALUES ( '$username','$password', '$name', '$surname','$age', '$salary', '$nationality', '$birthdate',  '$club_ID'  ) ";

                       mysqli_query($conn,$sql);
                     

                     }
                     else if ( $myType == 'Agent' )
                     {

                        $sql = " INSERT INTO Agent( username,password,name,surname,age,salary,nationality,birthdate ) 
                                VALUES ('$username','$password', '$name', '$surname','$age', '$salary', '$nationality', '$birthdate') ";

                        mysqli_query($conn,$sql);


                     }
                     else if ( $myType == 'Coach' )
                     {
                        $sql = "INSERT INTO Coach ( username,password,name,surname,age,salary,nationality,birthdate,AgentID,ClubID ) 
                                VALUES ('$username','$password', '$name', '$surname','$age', '$salary', '$nationality', '$birthdate','$agent_ID','$club_ID') ";

                        mysqli_query($conn,$sql);   

                     }

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

/* Add a background color on hover */
.btn-group button:hover {
    background-color: #7e4e41;
}

.btn-group .button1 
{
  background-color: #008CBA;
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
  


  <a href="#" style="float:right">Search</a>

  <input type ="text" placeholder="Search..." style ="float:right">

</div>

<div class="row">
  <div class ="rightcolumn">
  <h2>Admin Page</h2>

        <div class="panel panel-default">
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
              <button class ="button1">Create Account</button>
              </a>
              <a href="AdminCreateGame.php" target="_self">
              <button>Create Game</button>
              </a>
          </div>
          </div>          <div class="panel-body">
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
                         <strong>  Surname:     </strong>
                        <input class="form-control" placeholder="Surname" name="surname" type="text" autofocus>
                        
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span>
                         <strong>  Age:     </strong>
                        <input class="form-control" placeholder="age" name="age" type="text" autofocus>
                        
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <strong>  User Name:     </strong>
                        <input class="form-control" placeholder="User Name" name="username" type="text" autofocus>
                    </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <strong>  Salary:     </strong>
                        <input class="form-control" placeholder="Salary" name="salary" type="text" autofocus>
                    </div>
                    </div>
                    <endtime class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <strong>  Password:     </strong>
                        <input class="form-control" placeholder="Password" name="password" type="text" value="">
                      </div>
                    </div>

                    <strong>  Clubs:     </strong>
                  
                    <select name= "club">

                        <?php 

                                 while( $row = mysqli_fetch_array($result4,MYSQLI_ASSOC)) 
                                 {
                                   echo "<option value='".htmlspecialchars($row['name'])."''>".htmlspecialchars($row['name'])."</option>";
                                 }

                        ?>

                    </select>


                    <strong>  Agents:     </strong>
                  
                    <?php echo "<select name= 'agent'>" ?>

                        <?php 

                                 while( $row = mysqli_fetch_array($result5)) 
                                 {
                                   echo "<option value='".htmlspecialchars($row['name'])."''>".htmlspecialchars($row['name'])."</option>";
                                 }

                               ?>

                    <?php echo "</select>" ?>

                    

                  
                  

                    <strong>  Nationality:     </strong>
                    <select name = "nationality" >
                         <option value="Azeri">Azeri</option>
                         <option value="Turk">Turk</option>
                         <option value="Tacik">Tacik</option>
                    </select>
                    
                    <strong>  Type:     </strong>
                    <select name="type">
                         <option value="Coach">Coach</option>
                         <option value="Director">Director</option>
                         <option value="Player">Player</option>
                         <option value="Agent">Agent</option>
                    </select>


                    <strong>  Position:     </strong>
                    <select name="position">
                         <option value="Goalkeeper">Goalkeeper</option>
                         <option value="Defance">Defance</option>
                         <option value="Middlefieldplayer">Middle Field Player</option>
                         <option value="Striker">Striker</option>
                    </select>

                    

                    <div class="form-group">
                      <div class="input-group">
                        <strong> Birth Date:     </strong>
                        <form action="/action_page.php">
                        <input type="date" name="birthdate">           
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
