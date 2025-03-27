<?php

require_once '../core/database.php';

if (isset($_POST['place_id'])):
    $placeID = $_POST['place_id'];

    $getQ = $db->query("CALL `get_places_by_id`($placeID)");
    $data = mysqli_fetch_object($getQ);
    $result = json_encode($data);
    echo $result;
endif;

if (isset($_POST["upd_place_id"])):
    $placeID = $_POST["upd_place_id"];
    $keys = '';
    $values = '';
    foreach ($_POST as $key => $value) {
        if ($key != 'upd_place_id') {
            $keys .= $key . "='" . $value . "',";
        }
    }
    $keys = substr($keys, 0, -1);

    $updPlaceQ = $db->query("UPDATE `places` SET $keys WHERE `id`='$placeID'");
    if ($updPlaceQ) {
        echo json_encode(["status" => "success", "msg" => "Place Updated Successfully."]);
    } else {
        echo json_encode(["status" => "error", "msg" => "Something went wrong!"]);
    }
endif;