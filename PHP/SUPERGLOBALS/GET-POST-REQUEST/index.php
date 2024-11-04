<?php
$myGlobals =4;
//phpinfo();
/**
 * $_GET, $_POST, $_COOKIE, $_REQUEST
 */
//setcookie('username','hidran',  time() + 3600,'/');
//setcookie('USERID','1',  time() + 3600,'/');
ini_set('display_errors', 1);
error_reporting(E_ALL);
function test(){
    echo '$_GET<br>';
    var_dump($_GET);
    echo '$_POST<br>';
    var_dump($_POST);
    echo '$_COOKIE<br>';
    var_dump($_COOKIE);
    echo '$_REQUEST<br>';
    var_dump($_REQUEST);
    
}
test();
?>
<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <title>SUPERGLOBALS $_GET, $_POST, $_REQUEST</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>


</head>
<body>
    <div class="container">
        <form action="index.php?username=Jane&lastname=Smithé" method="POST">
        <div class="form-group">
            <label for="username">Name</label>
            <input type="text" name="username" id="username" class="form-control">
        </div>
       <div class="form-group">
           <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname" class="form-control">
        </div>
        <div class="form-group">
            <button class="btn btn-success">SAVE</button>
            <input type="reset" onclick="location.href='index.php'" class="btn btn-success" value="RESET"/>
            <a class="btn btn-danger" href="index.php?username=Test&lastname=Testlastname">Invia test</a>
        </div>
     </form>
    </div>
</body>
</html>