<?php
  require_once 'connection.php';


function verifyLogin($email, $password, $token){

require_once 'model/User.php';
    $result = [
        'message' => 'USERD LOGGED IN',
        'success' => true

    ];
   if($token !== $_SESSION['csrf']){
       $result = [
           'message' => 'TOKEN MISMATCH',
           'success' => false

       ];
       return $result;
   }
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if(!$email){
        $result = [
            'message' => 'WRONG EMAIL',
            'success' => false

        ];
        return $result;
    }
     if(strlen($password) < 6){
         $result = [
             'message' => 'PASSWORD TOO SMALL',
             'success' => false

         ];
         return $result;
     }
     $resEmail = getUserByEmail($email);
    if(!$resEmail){
        $result = [
            'message' => 'USER NOT FOUND',
            'success' => false

        ];
        return $result;
    }

    if(!password_verify($password, $resEmail['password'])){
        $result = [
            'message' => 'WRONG PASSWORD',
            'success' => false

        ];
        return $result;
    }
    $result['user'] = $resEmail ;
     return $result;
}




      function getConfig($param, $default = null){

          $config = require 'config.php';

          return array_key_exists($param, $config) ? $config[$param] : $default;
      }

       function getParam($param, $default = null){

         return  !empty($_REQUEST[$param])? $_REQUEST[$param]: $default;

       }
    function getRandName() {
        $names = [
            'ROBERTO','GIOVANNI','GIULIA','MARIO','ALE'
        ];
        $lastnames = [
            'ROSSI','RE','ARIAS','SMITH','MENDOZA','CRUZ','WILDE'

        ];

        $rand1 =  mt_rand(0, count($names) -1) ;
        $rand2 =  mt_rand(0, count($lastnames) -1);

      return  $names[$rand1].' '. $lastnames[$rand2] ;
    }

    //echo getRandName();
    function getRandEmail($name){

        $domains = ['google.com','yahoo.com','hotmail.it', 'libero.it'];

        $rand1 =  mt_rand(0, count($domains) -1) ;

        return  strtolower(str_replace(' ','.',$name ).mt_rand(10,99).'@'.$domains[$rand1]);

    }
    function getRandFiscalCode(){

        $i = 16;
        $res = '';  // ABQZ

        while ( $i > 0){

            $res .= chr(mt_rand(65,90));

            $i--;

        }
        return $res;

    }
    function getRandomAge(){
         return mt_rand(0, 120);
    }

    function insertRandUser($totale, mysqli $conn){

        while ($totale> 0) {

            $username = getRandName();
            $email = getRandEmail($username);
            $fiscalcode = getRandFiscalCode();
            $age = getRandomAge();

            $sql = 'INSERT INTO users (username, email, fiscalcode, age) VALUES ';
            $sql .= " ('$username','$email', '$fiscalcode', $age) ";
          //  echo $totale .' '.$sql.'<br>';
            $res = $conn->query($sql);
            if (!$res) {
                echo $conn->error.'<br>';
            } else {
                $totale--;
            }
        }
    }

    function getUsers( array $params = []){
          //var_dump($params);
            $conn = $GLOBALS['mysqli'];

            $orderBy = array_key_exists('orderBy', $params) ? $params['orderBy'] : 'username';

            $orderDir = array_key_exists('orderDir', $params) ? $params['orderDir'] : 'ASC';

           $limit = (int)array_key_exists('recordsPerPage', $params) ? $params['recordsPerPage'] : 10;

           $page = (int) array_key_exists('page', $params) ? $params['page'] : 0;

            $start = $limit * ($page -1);

            if($start< 0) {
                $start = 0;
            }
            $search = array_key_exists('search', $params) ? $params['search'] : '';

            $search = $conn->escape_string($search);

            if($orderDir !=='ASC' && $orderDir !=='DESC') {
                $orderDir = 'ASC';
            }
           $records = [];




            $sql = 'SELECT * FROM users ';
             if($search){
                 $sql .= "WHERE username LIKE '%$search%' ";
                 $sql .= " OR fiscalcode LIKE '%$search%' ";
                 $sql .= " OR  email LIKE '%$search%' ";
                 $sql .= " OR age LIKE '%$search%' ";
                 $sql .= " OR id LIKE '%$search%' ";
             }
            $sql .= " ORDER BY $orderBy $orderDir LIMIT $start , $limit ";
        //    echo $sql;
            $res = $conn->query($sql);
            if($res) {

             while( $row = $res->fetch_assoc()) {
                 $records[] = $row;
             }

            } else {
                die($conn->error);
            }

        return $records;

    }


function countUsers( array $params = []){

    

    $conn = $GLOBALS['mysqli'];

    $orderBy = array_key_exists('orderBy', $params) ? $params['orderBy'] : 'username';

    $orderDir = array_key_exists('orderDir', $params) ? $params['orderDir'] : 'ASC';

    $limit = (int)array_key_exists('recordsPerPage', $params) ? $params['recordsPerPage'] : 10;

    $search = array_key_exists('search', $params) ? $params['search'] : '';

    $search = $conn->escape_string($search);

    if($orderDir !=='ASC' && $orderDir !=='DESC') {
        $orderDir = 'ASC';
    }
    $total  = 0;




    $sql = 'SELECT COUNT(*) as total FROM users ';
    if($search){
        $sql .= "WHERE username LIKE '%$search%' ";
        $sql .= " OR fiscalcode LIKE '%$search%' ";
        $sql .= " OR  email LIKE '%$search%' ";
        $sql .= " OR age LIKE '%$search%' ";
        $sql .= " OR id LIKE '%$search%' ";
    }

    $res = $conn->query($sql);
    if($res) {

        $row = $res->fetch_assoc();
        $total = $row['total'];

    } else {
        die($conn->error);
    }

    return $total;

}
function copyAvatar(int $userid){

        $result = [
          'success' => false,
          'message' => 'PROBLEM SAVING IMAGE',
            'filename' => ''
        ] ;
        if(empty($_FILES)){
            $result['message'] = 'NO FILE UPLOADED';
            return $result;
        }

        $FILE = $_FILES['avatar'];
        if(!is_uploaded_file($FILE['tmp_name'])){
            $result['success'] = true;
            $result['message'] = '';
            return $result;
        }
         $finfo = finfo_open(FILEINFO_MIME);
        $info =  finfo_file($finfo , $FILE['tmp_name']);

        if(stristr($info ,'image/jpeg') === false){
            $result['message'] = 'THE UPLOADED FILE IS NOT JPEG';
            return $result;
        }
        $maxSize = getConfig('maxFileUpload');
       if($FILE['size'] > $maxSize){

           $result['message'] = 'THE UPLOADED FILE IS TOO BIG.'.$FILE['size'].' MAX SIZE IS '. $maxSize;
           return $result;
       }
       $filename = $userid.'_'.str_replace('.', '',microtime(true)).'.jpg';
       $avatarDir = getConfig('avatarDir');

      if(!move_uploaded_file($FILE['tmp_name'], $avatarDir.$filename)){

          $result['message'] = 'COULD NOT MOVE UPLOADED FILE';
          return $result;
      }

      $newImg = imagecreatefromjpeg( $avatarDir.$filename);
       if(!$newImg) {
           $result['message'] = 'COULD NOT CREATE THUMBNAIL RESOURCE';
           return $result;
       }
      $thumbNailImag = imagescale($newImg, getConfig('thumbnail_width', 120));
       $previewImg = imagescale($newImg, getConfig('previewimg_width', 400));
    if(!$thumbNailImag) {
        $result['message'] = 'COULD NOT SCALE THUMBNAIL RESOURCE';
        return $result;
    }

    imagejpeg($previewImg, $avatarDir.'preview_'.$filename);
    imagejpeg($thumbNailImag, $avatarDir.'thumb_'.$filename);
    $result['success'] = 1;
    $result['message'] = '';
     $result['filename'] = $filename;
      return $result;
}

function removeOldAvatar(int $id, array $userData = null){

          $userData = $userData?:getUser($id);

          if(!$userData || !$userData['avatar']){
              return;
          }

          $avatarFolder = getConfig('avatarDir');

          $filename = $avatarFolder.$userData['avatar'];

          $filenameThumb = $avatarFolder.'thumb_'.$userData['avatar'];

          if(file_exists($filename)){
              unlink($filename);
          }
        if(file_exists($filenameThumb)){
            unlink($filenameThumb);
        }

}

 function isUserLoggedin(){
     return $_SESSION['loggedin'] ?? false;
 }

function getUserLoggedInFullname(){
    return $_SESSION['userData']['username'] ?? '';
}
 function getUserRole(){
     return $_SESSION['userData']['roletype'] ?? '';
 }
function getUserEmail(){
    return $_SESSION['userData']['email'] ?? '';
}
function isUserAdmin(){
    return getUserRole() === 'admin';
}
function userCanUpdate(){
    $role = getUserRole();
    return  $role === 'admin' || $role === 'editor';
}
function userCanDelete(){

    return  isUserAdmin();
}















//insertRandUser(1000, $mysqli);