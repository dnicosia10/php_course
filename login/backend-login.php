<?php
require("../connect.php");
session_start();
//login backend
$table = "user_table";
$alert = "";
$login_email = "";
$login_pass = "";
$login_email_status = "false";
$login_pass_status = "false";
$login_pass_matched_status = "false";

// password query
function tbl_pass_matched($email, $pass, $table, $db){
    
}
if (isset($_POST['login_bttn'])) {
    if (!isset($_POST['login_email']) || $_POST['login_email'] === "") {
        debug_to_console("set the email first.");
        $login_email = $_POST['login_email'];
        $alert = "warning";
    } else {
        $login_email_status = "true";
        debug_to_console("Email successfully entered.");
    }

    if (!isset($_POST['login_pass']) || $_POST['login_pass'] === "") {
        $login_pass = $_POST['login_pass'];
        $alert = "warning";
        debug_to_console("set the password first.");
    } else {
        $login_pass_status = "true";
        debug_to_console("password successfully entered.");
    }
    
    if (($login_email_status === "true") && ($login_pass_status === "true")) {
        $login_email = $_POST['login_email'];
        $login_pass =  $_POST['login_pass'];
        $mysql = sprintf(
            "SELECT * FROM $table WHERE user_email = '%s'",
            $login_email);
        $result = $db->query($mysql);
        $row = $result->fetch_object();
        if($row != null){
            $hashed = $row->user_password;
            echo $hashed;
            if(password_verify($login_pass, $hashed)){
                $alert = "login";
                $_SESSION['email'] = $row->user_email;
                $_SESSION['admin'] = $row->user_admin;
                header("Location:../index.php");
                debug_to_console("success login...");
            }else{
                $alert = "pass";
                debug_to_console("password not matched");
                
            }
        }else{
            $alert = "email";
            debug_to_console("the user are not existed $login_email");
            
        }
        //tbl_pass_matched($login_email, $login_pass, $table, $db);
        debug_to_console("the validation passed!");
    }
}
if (isset($_POST['update_bttn'])) {
    header("Location: register.php");
    die();
}
// register backend
$reg_email = "";
$reg_pass = "";
$re_reg_pass = "";
$reg_email_status = "false";
$reg_pass_status = "false";
$reg_re_pass_status = "false";
if (isset($_POST['reg_bttn'])) {
    if (!isset($_POST['reg_email']) || $_POST['reg_email'] === "") {
        debug_to_console("set the email first.");
        $login_email = $_POST['reg_email'];
        
    } else {
        debug_to_console("Email successfully entered.");
        $reg_email_status = "true";
    }

    if (!isset($_POST['reg_pass']) || $_POST['reg_pass'] === "") {
        debug_to_console("set the password first.");
        
    } else {
        debug_to_console("password successfully entered.");
        $reg_pass_status = "true";
    }

    if (!isset($_POST['rereg_pass']) || $_POST['rereg_pass'] === "") {
        debug_to_console("set the re-type password first.");
    } else{
        if($_POST['reg_pass'] === $_POST['rereg_pass'] ){
            $reg_re_pass_status = "true";
            debug_to_console("password are matched.");
        }else{
            debug_to_console("not matched");
        }
        debug_to_console("password successfully entered.");
        
    }
    if (($reg_email_status === "true") && ($reg_pass_status === "true") && ($reg_re_pass_status === "true")) {
        $reg_email = $_POST['reg_email'];
        $reg_pass = password_hash($_POST['reg_pass'], PASSWORD_DEFAULT);
        tbl_user_write($reg_email, $reg_pass, $table, $db);
        debug_to_console("the login passed!");
        
    }else{
        debug_to_console("not all true");
    }
}

