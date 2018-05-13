<?php
	session_start();
	$host = "dijkstra.ug.bcc.bilkent.edu.tr";
	$myUser = "mehmet.turanboy";
	$myPassword = "1ky0yl0r";
	$myDB = "mehmet_turanboy";
	
	$connection = mysqli_connect($host, $myUser, $myPassword, $myDB);
	
	$fanID = $_SESSION['id'];
	
	if (isset($_POST['cancel'])){
		header("Location: FanHomePage.php");
	}
        
	if(isset($_POST['search'])){
        $searchtext = $_POST['searchtext'];
        $_SESSION['searchtext'] = $searchtext;
        header("Location: Search.php");
        }
        
        

	if (isset($_POST['save'])){
		if (empty($_POST['name']) || empty ($_POST['surname']) || empty ($_POST['username']) || empty ($_POST['password']) || empty ($_POST['favoriteteam'])){
			?>
			<script>alert("Please fill out all the fields");</script>
			<?php
		}
		else{
			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$favoriteteam = $_POST['favoriteteam'];
			$favTeamQuery = "SELECT Club.ID FROM Club WHERE Club.name = '".$favoriteteam."'";
			$favTeamID = mysqli_query($connection, $favTeamQuery);
			if (mysqli_num_rows($favTeamID) == 0){
				?>
				<script>alert("Please choose a valid club");</script>
				<?php
			}
			else{
				$favTeamID = $favTeamID->fetch_object();
				$updateFanQuery = "UPDATE Fan SET username = '".$username."', password = '".$password."', name = '".$name."', surname = '".$surname."', favTeamID = '".$favTeamID->ID."' WHERE ID = '".$fanID."'";
				mysqli_query($connection, $updateFanQuery);
				?>
				<script>alert("Update Successful");</script>
				<?php
				header("Location: login.php");
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Sign in Panel - Bootsnipp.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        .panel-heading {
    padding: 5px 15px;
}

.panel-footer {
  padding: 1px 15px;
  color: #A0A0A0;
}

.profile-img {
  width: 96px;
  height: 96px;
  margin: 0 auto 10px;
  display: block;
  -moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  border-radius: 50%;
}
    </style>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container" style="margin-top:40px">
       <font size="6">Football Manager System <br></font> 
    <div class="row">
      <div class="col-sm-6 col-md-4 col-md-offset-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <strong>  Edit Profile Page </strong>
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
                        <input class="form-control" placeholder="Name" name="name" type="text" autofocus>
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <input class="form-control" placeholder="Surname" name="surname" type="text" autofocus>
                    </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                    </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        
                        <input class="form-control" placeholder="Favorite Team" name="favoriteteam" type="text" autofocus>
                    </div>
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-lg btn-primary btn-block" value="Save" name = "save">
                      <input type="submit" class="btn btn-lg btn-primary btn-block" value="Cancel" name = "cancel">
                    </div>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
                </div>
      </div>
    </div>
  </div>
<script type="text/javascript">

</script>
</body>
</html>
