<?php
    session_start();
    if(!isset($_SESSION['email']) || $_SESSION['admin'] !=1){
        header("Location:./login/login.php");
    }else{
        
    }
?>