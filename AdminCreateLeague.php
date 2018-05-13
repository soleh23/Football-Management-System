
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
   
   $sql = "SELECT * FROM Country";
   $result = mysqli_query($conn,$sql);

    if(isset($_POST['search'])){
    $searchtext = $_POST['searchtext'];
    $_SESSION['searchtext'] = $searchtext;
    header("Location: Search.php");
}
   if( $_SERVER["REQUEST_METHOD"] == "POST" ) 
   {
      $name = mysqli_real_escape_string($conn,$_POST['name']);
      $start_date = mysqli_real_escape_string($conn,$_POST['start_date']);
      $end_date = mysqli_real_escape_string($conn,$_POST['end_date']);
      $country = mysqli_real_escape_string($conn,$_POST['country']);

      $sql = "SELECT name FROM League WHERE name = '$name'";

      $result1 = mysqli_query($conn,$sql);

      

      if( !empty($name) && !empty($start_date) && !empty($end_date) && !empty($country) )
      {     

           if( mysqli_num_rows($result1) == 1 )
           {
             ?>

             <script> alert("Please choose unique league name ") </script> 

              <?php
           }

           else
           {

             $sql = "INSERT INTO League(name,start_date,end_date,countryName )
                               VALUES('$name', '$start_date' , '$end_date' , '$country' ) ";

             mysqli_query($conn,$sql);
          }
      }
      else
      {
           ?>

           <script> alert("Please choose different home and away team for creating game ") </script> 

           <?php
      }

   }
?>


<!DOCTYPE html>
<html>
<head>
<style>

* 
{
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

.btn-group .button1 
{
  background-color: #008CBA;
}

.btn-group button:not(:last-child) 
{

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
                  <button class ="button1">Create League</button>
                  </a>
                  <a href="AdminCreateClub.php" target="_self">
                  <button>Create Club</button>
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
                           <strong>  Start Date:     </strong>

                           <input type="date" name="start_date">           

                     
                           </div>
                      </div>

                    <div class="form-group">
                      <div class="input-group">
                        <strong> End Date:</strong>

                        <input type="date" name="end_date">           

                 
                      </div>
                    </div>
                    

                    <select name ="country">
                        <?php 

                              while( $row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
                              {
                                  echo "<option value='".htmlspecialchars($row['name'])."''>".htmlspecialchars($row['name'])."</option>";
                              }

                        ?>
                    </select>
                    

                   
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
		 <li><a class="active" href="CountriesPage.php">Countries</a></li>
		 <li><a href="Leagues.php">Leagues</a></li>
		 <li><a href="Clubs.php">Clubs</a></li>
		 <li><a href="TransferNewsPage.php">Transfer News</a></li>
		 <li><a href="Matches.php">Matches</a></li>
		 <li><a href="playersPage.php">Players</a></li>
		</ul>
  </div>



 

</body>
</html>
