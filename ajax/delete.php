<?php

require_once "../core/database.php";

if (isset($_POST['del_id']) && isset($_POST['del_table'])):
    $id = $_POST['del_id'];
    $table = $_POST['del_table'];
    $msg = $_POST['msg'];

    $del = $db->query(query: "DELETE FROM `$table` WHERE `id`='$id'");
    if ($del) {
        echo json_encode(value: ["status" => "success", "msg" => $msg . " has been deleted."]);
    }
endif;