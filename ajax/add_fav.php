<?php

require_once '../core/database.php';

if (isset($_POST['fav_place_id'])):
    $placeID = $_POST['fav_place_id'];
    $msg = '';

    $checkExists = $db->query("SELECT * FROM `fav_places` WHERE `place_id`='$placeID' AND `user_id`='$userid'");
    if (mysqli_num_rows($checkExists) > 0):
        $msg = json_encode(["status" => "error", "msg" => "Already Added in Favorite."]);
    else:
        $add_fav_Q = $db->query("INSERT INTO `fav_places` (place_id,user_id) VALUES('$placeID','$userid')");
        if ($add_fav_Q):
            $msg = json_encode(["status" => "success", "msg" => "Added to Favorite Successfully."]);
        endif;
    endif;
    echo $msg;
endif;


if (isset($_POST['fav_acc_id'])):
    $accID = $_POST['fav_acc_id'];
    $msg = '';

    $checkExists = $db->query("SELECT * FROM `fav_accommodation` WHERE `acc_id`='$accID' AND `user_id`='$userid'");
    if (mysqli_num_rows($checkExists) > 0):
        $msg = json_encode(["status" => "error", "msg" => "Already Added in Favorite."]);
    else:
        $add_fav_Q = $db->query("INSERT INTO `fav_accommodation` (acc_id,user_id) VALUES('$accID','$userid')");
        if ($add_fav_Q):
            $msg = json_encode(["status" => "success", "msg" => "Added to Favorite Successfully."]);
        endif;
    endif;
    echo $msg;
endif;

if (isset($_POST['fav_event_id'])):
    $eventID = $_POST['fav_event_id'];
    $msg = '';

    $checkExists = $db->query("SELECT * FROM `fav_events` WHERE `event_id`='$eventID' AND `user_id`='$userid'");
    if (mysqli_num_rows($checkExists) > 0):
        $msg = json_encode(["status" => "error", "msg" => "Already Added in Favorite."]);
    else:
        $add_fav_Q = $db->query("INSERT INTO `fav_events` (event_id,user_id) VALUES('$eventID','$userid')");
        if ($add_fav_Q):
            $msg = json_encode(["status" => "success", "msg" => "Added to Favorite Successfully."]);
        endif;
    endif;
    echo $msg;
endif;