<?php

require_once '../core/database.php';

// For Place
if (isset($_POST['place_img_upd_id'])):
    $place_id = $_POST['place_img_upd_id'];


    $targetDir = '../img/place/';
    $filePath = './img/place/';
    $msg = '';

    try {

        if (!empty($_FILES["place_image"]["name"])) {

            $fileName = basename($_FILES["place_image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $targetDisplayPath = $filePath . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
            if (in_array($fileType, $allowTypes)) {
                if (move_uploaded_file($_FILES["place_image"]["tmp_name"], $targetFilePath)) {

                    $placesQ = $db->query("UPDATE `places` SET `place_img`='$targetDisplayPath' WHERE `id`='$place_id'");
                    if ($placesQ) {
                        $msg = json_encode(["status" => "success", "msg" => "Place Image Uploaded Successfully"]);
                    }
                } else {
                    $msg = json_encode(["status" => "error", "msg" => "Something wrong while uploading file."]);
                }
            } else {
                $msg = json_encode(["status" => "error", "msg" => "Only jpg, png, jpeg and webp are allowed."]);
            }
        }

    } catch (\Throwable $th) {
        $msg = json_encode(["status" => "error", "msg" => "Something went wrong."]);
    }

    echo $msg;

endif;

// For Accommodation
if (isset($_POST['acc_img_upd_id'])):
    $acc_id = $_POST['acc_img_upd_id'];


    $targetDir = '../img/accommodation/';
    $filePath = './img/accommodation/';
    $msg = '';

    try {

        if (!empty($_FILES["accommodation_image"]["name"])) {

            $fileName = basename($_FILES["accommodation_image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $targetDisplayPath = $filePath . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
            if (in_array($fileType, $allowTypes)) {
                if (move_uploaded_file($_FILES["accommodation_image"]["tmp_name"], $targetFilePath)) {

                    $accQ = $db->query("UPDATE `accommodation` SET `accommodation_image`='$targetDisplayPath' WHERE `id`='$acc_id'");
                    if ($accQ) {
                        $msg = json_encode(["status" => "success", "msg" => "Accommodation Image uploaded Successfully"]);
                    }
                } else {
                    $msg = json_encode(["status" => "error", "msg" => "Something wrong while uploading file."]);
                }
            } else {
                $msg = json_encode(["status" => "error", "msg" => "Only jpg, png, jpeg and webp are allowed."]);
            }
        }

    } catch (\Throwable $th) {
        $msg = json_encode(["status" => "error", "msg" => "Something went wrong."]);
    }

    echo $msg;

endif;

// For Event
if (isset($_POST['event_img_upd_id'])):
    $event_id = $_POST['event_img_upd_id'];


    $targetDir = '../img/event_/';
    $filePath = './img/event_/';
    $msg = '';

    try {

        if (!empty($_FILES["event_img"]["name"])) {

            $fileName = basename($_FILES["event_img"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $targetDisplayPath = $filePath . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
            if (in_array($fileType, $allowTypes)) {
                if (move_uploaded_file($_FILES["event_img"]["tmp_name"], $targetFilePath)) {

                    $eventQ = $db->query("UPDATE `events` SET `event_img`='$targetDisplayPath' WHERE `id`='$event_id'");
                    if ($eventQ) {
                        $msg = json_encode(["status" => "success", "msg" => "Event Image Uploaded Successfully"]);
                    }
                } else {
                    $msg = json_encode(["status" => "error", "msg" => "Something wrong while uploading file."]);
                }
            } else {
                $msg = json_encode(["status" => "error", "msg" => "Only jpg, png, jpeg and webp are allowed."]);
            }
        }

    } catch (\Throwable $th) {
        $msg = json_encode(["status" => "error", "msg" => "Something went wrong."]);
    }

    echo $msg;

endif;