<?php

require_once '../core/database.php';

if (isset($_POST['event_id'])):
    $eventID = $_POST['event_id'];

    $getQ = $db->query("CALL `get_event_by_id`($eventID)");
    $data = mysqli_fetch_object($getQ);
    $result = json_encode($data);
    echo $result;
endif;

if (isset($_POST["upd_event_id"])):
    $eventID = $_POST["upd_event_id"];
    $keys = '';
    $values = '';
    foreach ($_POST as $key => $value) {
        if ($key != 'upd_event_id') {
            $keys .= $key . "='" . $value . "',";
        }
    }
    $keys = substr($keys, 0, -1);

    $updPlaceQ = $db->query("UPDATE `events` SET $keys WHERE `id`='$eventID'");
    if ($updPlaceQ) {
        echo json_encode(["status" => "success", "msg" => "Event Updated Successfully."]);
    } else {
        echo json_encode(["status" => "error", "msg" => "Something went wrong!"]);
    }
endif;