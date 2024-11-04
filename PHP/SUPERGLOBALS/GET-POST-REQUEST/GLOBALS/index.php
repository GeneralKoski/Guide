<?php
//$GLOBALS
$testGlobal ='Questa è una variabile globale';
function test(){
    $testGlobal ='Test funzione';
         echo   $testGlobal.'<br>';
    //  echo '$GLOBALS<br>';
    print_r( $_POST);
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