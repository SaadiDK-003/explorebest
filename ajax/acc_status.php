<?php

require_once "../core/database.php";

if (isset($_POST["status"])):
    $accID = $_POST['acc_id'];
    $status = $_POST["status"];
    $msg = $_POST["msg"];


    try {
        $updPlaceStatus = $db->query("UPDATE `accommodation` SET `status`='$status' WHERE `id`='$accID'");
        if ($updPlaceStatus) {
            echo json_encode(["status" => "success", "msg" => $msg . " Updated Successfully."]);
        }
    } catch (\Throwable $th) {
        echo json_encode(["status" => "error", "msg" => $th->getMessage()]);
    }

endif;