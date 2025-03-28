<?php

require_once "../core/database.php";

if (isset($_POST["type"])):

    $msg = "";
    $type = $_POST["type"];

    try {
        if (!checkPlaceTypeExist($type, 'accommodation_types')):
            $add_type = $db->query("INSERT INTO `accommodation_types` (types) VALUES('$type')");
            $msg = json_encode(["status" => "success", "msg" => $type . " has been added."]);
        else:
            $msg = json_encode(["status" => "error", "msg" => $type . " already exist."]);
        endif;
    } catch (\Throwable $th) {
        $msg = json_encode(["status" => "error", "msg" => $th->getMessage()]);
    }


    echo $msg;

endif;


if (isset($_POST["type_update"]) && isset($_POST["acc_type_id"])):
    $msg = "";
    $id = $_POST["acc_type_id"];
    $type = $_POST["type_update"];
    $old_type = $_POST["old_type"];

    try {
        if (!checkPlaceTypeExist($type, 'accommodation_types')):
            $upd_type = $db->query("UPDATE `accommodation_types` SET `types`='$type' WHERE `id`='$id'");

            $upd_place_table = $db->query("UPDATE `accommodation` SET `type`='$type' WHERE `type`='$old_type'");

            $msg = json_encode(["status" => "success", "msg" => $type . " has been updated"]);
        else:
            $msg = json_encode(["status" => "error", "msg" => $type . " already exist."]);
        endif;
    } catch (\Throwable $th) {
        $msg = json_encode(["status" => "error", "msg" => $th->getMessage()]);
    }
    echo $msg;
endif;