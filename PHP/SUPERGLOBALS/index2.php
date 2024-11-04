
<?php
 $_SESSION;
 session_start();
 echo '<pre>';
  var_dump($_SESSION);
 echo '</pre>';
 
 if(!empty($_FILES)){
 echo '<pre>';
 var_dump($_FILES);
 echo '</pre>';
 }
 ?>
 <html>
    <head>
        <title>yofod</title>
        <meta charset="utf-8">
        <meta name="author" content="Nicola" >
        <meta name="description" content="corso html5">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
 <script
  src="https://code.jquery.com/jquery-3.1.1.js"
  integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
  crossorigin="anonymous"></script>
  
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
<div class="container">
 <form enctype="multipart/form-data" action="index3.php" method="POST">
 
 
  <div class="form-group">
    <label for="username">Name</label>
    <input type="text" class="form-control" id="username"  name="username" placeholder="Enter username">
  </div>
  
  <div class="form-group">
    <label for="lastname">Last Name</label>
    <input type="text" class="form-control" id="lastname" placeholder="lastname" name="lastname">
  </div>
 
 
  <div class="form-group">
    <label for="lastname">File Avatar</label>
    <input type="file" class="form-control" id="avatar"  name="avatar" onchange="document.getElementById('imgavatar').src=window.URL.createObjectURL(this.files[0])"/>
    <img src="" id="imgavatar" width="120"/>
  </div>
<div class="form-group col-md-6">
  <button class="btn btn-primary">SAVE</button>
  <input type="reset" onclick="location" href="index3.php" class="btn btn-success" value="RESET"/>
</div>
  </form>
</div>
 </body>
 </html>
