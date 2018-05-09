<?php
   include('config.php');
   session_start();

   echo "Outside";
   
   if($_SERVER["REQUEST_METHOD"] == "POST") 
   {

      $myusername = mysqli_real_escape_string($conn,$_POST['username']);
      $mypassword = mysqli_real_escape_string($conn,$_POST['password']);
      $mytype = mysqli_real_escape_string($conn,$_POST['type']);

      $sql = "INSERT INTO User(username,password,type) VALUES ('$myusername','$mypassword','$mytype');";


      echo "We are here";

      mysqli_query($conn,$sql);
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
            <strong>  Sign up </strong>
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
                        
                        <input class="form-control" placeholder="Favorite Team" name="favoriteTeam" type="text" autofocus>
                      </div>
                    </div>
                   <div class="form-group">
                       <select name = "type">
                        <option value="Player">Player</option>
                        <option value="Coach">Coach</option>
                        <option value="Fan">Fan</option>
                        <option value="Director">Director</option>
                       </select>  
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
  </div>
<script type="text/javascript">

</script>
</body>
</html>
