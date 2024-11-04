<?php
 $dir = realpath(dirname(__FILE__).'/images/').'\\';
   
if(!empty($_FILES)){
  var_dump( $_FILES );
    foreach ($_FILES as $file){
        
        $fileName = basename($file['name']);
        if(is_uploaded_file($file['tmp_name']) && $file['error'] === UPLOAD_ERR_OK){
            $res = move_uploaded_file($file['tmp_name'], $dir.$fileName);
            if($res){
                echo "file $fileName caricato correttamente<br>";
            } else {
                   echo "file $fileName non è caricato correttamente<br>";
            }
        }
    }
}
?>

<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <title>SUPERGLOBALS $_FILES</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">


</head>
<body>
  
    <div class="container">
          <h3> Registrati</h3>
        <form enctype="multipart/form-data" action="index.php?username=Jane&lastname=Smithé" method="POST">
        <div class="form-group">
            <label for="username">Name</label>
            <input type="text" name="username" required id="username" class="form-control">
        </div>
       <div class="form-group">
           <label for="lastname">Last Name</label>
           <input type="text" name="lastname" required id="lastname" class="form-control">
        </div>
              <div class="form-group">
           <label for="lastname">Avatar</label>
           <input type="file" name="avatar" id="avatar" class="form-control" onchange="document.getElementById('imgavatar').src=window.URL.createObjectURL(this.files[0])">
           <input type="file" name="avatar2" id="avatar2" class="form-control" onchange="document.getElementById('imgavatar').src=window.URL.createObjectURL(this.files[0])">
           <img src="" id="imgavatar" width="120">
        </div>
        <div class="form-group col-md-6">
            <button class="btn btn-primary">SAVE</button>
            <input type="reset" onclick="location.href='index.php'" class=" btn btn-success" value="RESET"/>
        </div>
     </form>
    </div>
</body>
</html>