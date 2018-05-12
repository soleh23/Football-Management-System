<?php
	session_start();
	$host = "dijkstra.ug.bcc.bilkent.edu.tr";
	$myUser = "mehmet.turanboy";
	$myPassword = "1ky0yl0r";
	$myDB = "mehmet_turanboy";
	
	$connection = mysqli_connect($host, $myUser, $myPassword, $myDB);
	$_SESSION['loggedIn'] = false;
	
	if (isset($_POST['login'])){
		if (empty($_POST['loginname']) || empty ($_POST['password'])){
			?>
			<script>alert("Please fill out the username and password");</script>
			<?php
		}
		else{
			$username = $_POST['loginname'];
			$password = $_POST['password'];
			
			$sql = "SELECT * FROM Player WHERE username = '".$username."' AND password = '".$password."' LIMIT 1";
			$query = mysqli_query($connection, $sql);
			if (mysqli_num_rows($query) == 1){
				$value = mysqli_fetch_object($query);
				$_SESSION['id'] = $value->ID;
				$_SESSION['username'] = $value->username;
				$_SESSION['type'] = "player";
				$_SESSION['loggedIn'] = true;
				header("Location: PlayersHomePage.php");
			}
			
			$sql = "SELECT * FROM Coach WHERE username = '".$username."' AND password = '".$password."' LIMIT 1";
			$query = mysqli_query($connection, $sql);
			if (mysqli_num_rows($query) == 1){
				$value = mysqli_fetch_object($query);
				$_SESSION['id'] = $value->ID;
				$_SESSION['username'] = $value->username;
				$_SESSION['type'] = "coach";
				$_SESSION['loggedIn'] = true;
				header("Location: CoachHomePage.php");
			}
			
			$sql = "SELECT * FROM Agent WHERE username = '".$username."' AND password = '".$password."' LIMIT 1";
			$query = mysqli_query($connection, $sql);
			if (mysqli_num_rows($query) == 1){
				$value = mysqli_fetch_object($query);
				$_SESSION['id'] = $value->ID;
				$_SESSION['username'] = $value->username;
				$_SESSION['type'] = "agent";
				$_SESSION['loggedIn'] = true;
				header("Location: PlayersHomePage.php");
			}
			
			$sql = "SELECT * FROM Fan WHERE username = '".$username."' AND password = '".$password."' LIMIT 1";
			$query = mysqli_query($connection, $sql);
			if (mysqli_num_rows($query) == 1){
				$value = mysqli_fetch_object($query);
				$_SESSION['id'] = $value->ID;
				$_SESSION['username'] = $value->username;
				$_SESSION['type'] = "fan";
				$_SESSION['favTeamID'] = $value->favTeamID;
				$_SESSION['loggedIn'] = true;
				header("Location: FanHomePage.php");
			}
			
			$sql = "SELECT * FROM Director WHERE username = '".$username."' AND password = '".$password."' LIMIT 1";
			$query = mysqli_query($connection, $sql);
			if (mysqli_num_rows($query) == 1){
				$value = mysqli_fetch_object($query);
				$_SESSION['id'] = $value->ID;
				$_SESSION['username'] = $value->username;
				$_SESSION['type'] = "director";
				$_SESSION['loggedIn'] = true;
				header("Location: DirectorHomePage.php");
			}
			
			$sql = "SELECT * FROM Admin WHERE username = '".$username."' AND password = '".$password."' LIMIT 1";
			$query = mysqli_query($connection, $sql);
			if (mysqli_num_rows($query) == 1){
				$value = mysqli_fetch_object($query);
				$_SESSION['id'] = $value->ID;
				$_SESSION['username'] = $value->username;
				$_SESSION['type'] = "admin";
				$_SESSION['loggedIn'] = true;
				header("Location: AdminCreateLeague.php");
			}
			
			else{
				?>
				<script>alert("ERROR: The username or password is invalid");</script>
				<?php
			}
		}
	}
	else if (isset($_POST['signup'])){
		header("Location: SignUp.php");
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
            <strong>  Please Log in</strong>
          </div>
          <div class="panel-body">
            <form role="form" action="#" method="POST">
              <fieldset>
                <div class="row">
                  <div class="center-block">
                    <img class="profile-img"
                      src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120" alt="">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                        </span> 
                        <input class="form-control" placeholder="Username" name="loginname" type="text" autofocus>
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
                      <input type="submit" class="btn btn-lg btn-primary btn-block" value="Log In" name="login">
					  <input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign Up" name="signup">
                    </div>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
          <div class="panel-footer ">
             <a href="#" onClick=""> Forgot your password? </a>
          </div>
          <div class="panel-footer ">
             <a href="#" onClick=""> Continue as a guesst. </a>
          </div>
                </div>
      </div>
    </div>
  </div>
<script type="text/javascript">

</script>
</body>
</html>
