<?php
require("connect.php");
$fname = "";
$lname = "";
$fullname = "";
$bttn_name = "add_bttn";
$bttn_label = "Add";
$bttn_class = "btn btn-success";
$conf_status_fname = "false";
$conf_status_lname = "false";
$alert = "";
if (isset($_POST['add_bttn'])) {
    if (!isset($_POST['fname']) || $_POST['fname'] === "") {
        debug_to_console("Fname was not valid!");
        $bttn = "btn btn-danger";
        $conf_status_fname = "false";
    } else {
        $fname = htmlspecialchars($_POST['fname']);
        $bttn = "btn btn-success";
        $conf_status_fname = "true";
    }
    if (!isset($_POST['lname']) || $_POST['lname'] === "") {
        debug_to_console("Lname was not valid!");
        $bttn = "btn btn-danger";
        $conf_status_lname = "false";
    } else {
        $lname = htmlspecialchars($_POST['lname']);
        $bttn = "btn btn-success";
        $conf_status_lname = "true";
    }
    if (($conf_status_fname === "true") && ($conf_status_lname === "true")) {
        $alert = "success";
        $fullname = "Full name: $fname, $lname";
        tbl_user_write($fname, $lname, $db);
        // $mysql = $db->prepare(
        //     "INSERT INTO test_mysql (name_test, link_test) VALUES (?, ?)");
        //     $stmt->bind_param('ss', $fname, $lname);
        // $stmt->execute();
        debug_to_console("Insert success $fullname ...");
        $fname = "";
        $lname = "";
    }else{
        $alert = "warning";
    };
} else {
    debug_to_console("Welcomee User...");
}
if (isset($_POST['delete_bttn'])) {
    debug_to_console($_POST['id']);
    $id_number_delete = $_POST['id'];
    $alert = "deleted";
    tbl_user_delete($id_number_delete, $db);
}
//calling update function
if (isset($_POST['update_bttn'])) {
    $fname = $_POST['fname_update'];
    $lname = $_POST['lname_update'];
    $bttn_name = "update_bttn_push";
    $bttn_label = "Update";
    $bttn_class = "btn btn-warning";
    debug_to_console($_POST['id']);
    $id_update = $_POST['id'];
}
if (isset($_POST['update_bttn_push'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $id = $_POST['id_update'];
    $alert = "updated";
    debug_to_console($_POST['id_update']);
    tbl_user_update($fname, $lname, $id, $db);
}
