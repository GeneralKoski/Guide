<?php
session_start();
session_unset();
session_destroy();
echo "<script>alert('Logout avvenuto con successo!'); window.location.href = '/Login/loginPage.html';</script>";