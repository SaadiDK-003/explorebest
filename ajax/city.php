<?php

require_once "../core/database.php";

if (isset($_POST["city_name"])):

    $msg = "";
    $city = $_POST["city_name"];

    try {
        if (!checkCityExist($city)):
            $add_city = $db->query("INSERT INTO `cities` (city_name) VALUES('$city')");
            $msg = json_encode(["status" => "success", "msg" => $city . " has been added."]);
        else:
            $msg = json_encode(["status" => "error", "msg" => $city . " already exist."]);
        endif;
    } catch (\Throwable $th) {
        $msg = json_encode(["status" => "error", "msg" => $th->getMessage()]);
    }


    echo $msg;

endif;


if (isset($_POST["city_update"]) && isset($_POST["city_id"])):
    $msg = "";
    $id = $_POST["city_id"];
    $city = $_POST["city_update"];

    try {
        if (!checkCityExist($city)):
            $upd_city = $db->query("UPDATE `cities` SET `city_name`='$city' WHERE `id`='$id'");
            $msg = json_encode(["status" => "success", "msg" => "City has been updated"]);
        else:
            $msg = json_encode(["status" => "error", "msg" => $city . " already exist."]);
        endif;
    } catch (\Throwable $th) {
        $msg = json_encode(["status" => "error", "msg" => $th->getMessage()]);
    }
    echo $msg;
endif;