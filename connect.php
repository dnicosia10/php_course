<?php
require("db_cridential.php");
$table = "test_mysql";
$db = new mysqli(HOST, USER, PASSWORD, DB);
//db testing
if ($db) {
    debug_to_console('the database has been running..');
} else {
    debug_to_console("Database is not running...");
}
//console log function
function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
//add function
function tbl_user_write($a, $b, $db)
{
    $mysql = sprintf(
        "INSERT INTO test_mysql (name_test, link_test) VALUES ('%s','%s')",
        $db->real_escape_string($a),
        $db->real_escape_string($b)
    );
    $db->query($mysql);
} //delete function
function tbl_user_delete($a, $db)
{
    $mysql = sprintf(
        "DELETE FROM test_mysql WHERE id_test='%s' ",
        $db->real_escape_string($a)
    );
    $db->query($mysql);
} //update function
function tbl_user_update($a, $b, $c, $db)
{
    $mysql = sprintf(
        "UPDATE test_mysql SET name_test='%s', link_test='%s' WHERE id_test='%s' ",
        $db->real_escape_string($a),
        $db->real_escape_string($b),
        $db->real_escape_string($c)
    );
    $db->query($mysql);
}
//display function
function tbl_user_display($table, $db)
{
    $result = $db->query("SELECT * FROM $table");
    $number = 0;
    foreach ($result as $row) {
        $number++;
        printf(
            "
            <tr>
            <th scope='row'>$number</th>
            <td>%s</td>
            <td>%s</td>
            <td>
            <div class='d-grid gap-2 d-md-flex justify-content-md-end'>
            <input type='hidden' value='%s' name='id'>
            <input type='hidden' value='%s' name='fname_update'>
            <input type='hidden' value='%s' name='lname_update'>
            <button type='submit' class='btn btn-outline-warning btn-sm' name='update_bttn'>Update</button>
            
            <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#exampleModalCenter'>Delete</button>
            </div
            </td>
            </tr>
            <div class='modal fade' id='exampleModalCenter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLongTitle'>Modal title</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    ...
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-outline-danger btn-sm' name='delete_bttn'>Delete</button>
                </div>
                </div>
            </div>
            </div>
            ",
            htmlspecialchars($row['name_test'], ENT_QUOTES),
            htmlspecialchars($row['link_test'], ENT_QUOTES),
            htmlspecialchars($row['id_test'], ENT_QUOTES),
            htmlspecialchars($row['name_test'], ENT_QUOTES),
            htmlspecialchars($row['link_test'], ENT_QUOTES)
        );
    }
    $db->close();
}
function display_alert($alert_status)
{
    switch ($alert_status) {
        case "success":
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Holy Crap!</strong> The user information has been successfully added.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
            break;
        case "warning":
            echo "
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
            break;
        case "deleted":
            echo "
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Holy Crap!</strong> The selected user information has been successfully deleted.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
            break;
        case "updated":
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Holy Crap!</strong> The user information has been successfully Updated.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
            break;
        default:
            echo "
        <div class='alert alert-primary alert-dismissible fade show' role='alert'>
            <strong>Holy guacamole!</strong> Welcome to my Experimental Page in PHP.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        ";
    }
}
