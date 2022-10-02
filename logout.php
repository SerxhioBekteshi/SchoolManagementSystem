<?php 

    //kur clogohem destroy session dhe header tek log in 
    require_once 'header.php';
    require_once 'functions.php';

    destroySession();
    header("location:login.php ")
?>
