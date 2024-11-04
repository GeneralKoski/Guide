<?php
//$_SESSION
session_start();
$_SESSION['userid'] = 4;
$_SESSION['islogged'] = 1;
session_write_close();