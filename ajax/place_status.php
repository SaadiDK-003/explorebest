<?php

require_once "../core/database.php";

if (isset($_POST["status"])):
    $placeID = $_POST['place_id'];
    $status = $_POST["status"];
    $msg = $_POST["msg"];


    try {
        $updPlaceStatus = $db->query("UPDATE `places` SET `status`='$status' WHERE `id`='$placeID'");
        if ($updPlaceStatus) {
            echo json_encode(["status" => "success", "msg" => $msg . " Updated Successfully."]);
        }
    } catch (\Throwable $th) {
        echo json_encode(["status" => "error", "msg" => $th->getMessage()]);
    }

endif;