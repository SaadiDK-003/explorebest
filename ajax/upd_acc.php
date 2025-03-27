<?php

require_once '../core/database.php';

if (isset($_POST['acc_id'])):
    $acc_id = $_POST['acc_id'];

    $getQ = $db->query("CALL `get_acc_by_id`($acc_id)");
    $data = mysqli_fetch_object($getQ);
    $result = json_encode($data);
    echo $result;
endif;

if (isset($_POST["upd_acc_id"])):
    $accID = $_POST["upd_acc_id"];
    $keys = '';
    $values = '';
    foreach ($_POST as $key => $value) {
        if ($key != 'upd_acc_id') {
            $keys .= $key . "='" . $value . "',";
        }
    }
    $keys = substr($keys, 0, -1);

    $updAccQ = $db->query("UPDATE `accommodation` SET $keys WHERE `id`='$accID'");
    if ($updAccQ) {
        echo json_encode(["status" => "success", "msg" => "Accommodation Updated Successfully."]);
    } else {
        echo json_encode(["status" => "error", "msg" => "Something went wrong!"]);
    }
endif;