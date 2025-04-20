<?php

require_once '../core/database.php';

// For Place
if (isset($_POST['place_img_upd_id'])):
    $place_id = $_POST['place_img_upd_id'];


    $targetDir = '../img/place/';
    $filePath = './img/place/';
    $msg = '';

    try {
        if (!empty($_FILES["place_image"]["name"][0])) {

            $uploadedPaths = [];
            $allowTypes = array('jpg', 'png', 'jpeg', 'webp');

            foreach ($_FILES["place_image"]["name"] as $index => $fileName) {
                $fileTmpPath = $_FILES["place_image"]["tmp_name"][$index];
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                if (in_array(strtolower($fileType), $allowTypes)) {
                    $uniqueName = time() . '_' . rand(1000, 9999) . '.' . $fileType;
                    $targetFilePath = $targetDir . $uniqueName;
                    $targetDisplayPath = $filePath . $uniqueName;

                    if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                        $uploadedPaths[] = $targetDisplayPath;
                    }
                }
            }

            if (!empty($uploadedPaths)) {
                $finalImageString = implode(',', $uploadedPaths);

                $placesQ = $db->query("UPDATE `places` SET `place_img`='$finalImageString' WHERE `id`='$place_id'");
                if ($placesQ) {
                    $msg = json_encode(["status" => "success", "msg" => "Place Images Uploaded Successfully"]);
                } else {
                    $msg = json_encode(["status" => "error", "msg" => "Failed to update the database."]);
                }
            } else {
                $msg = json_encode(["status" => "error", "msg" => "Only jpg, png, jpeg and webp are allowed."]);
            }
        } else {
            $msg = json_encode(["status" => "error", "msg" => "No image selected."]);
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

        if (!empty($_FILES["accommodation_image"]["name"][0])) {

            $uploadedPaths = [];
            $allowTypes = array('jpg', 'png', 'jpeg', 'webp');

            foreach ($_FILES["accommodation_image"]["name"] as $index => $fileName) {
                $fileTmpPath = $_FILES["accommodation_image"]["tmp_name"][$index];
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                if (in_array(strtolower($fileType), $allowTypes)) {
                    $uniqueName = time() . '_' . rand(1000, 9999) . '.' . $fileType;
                    $targetFilePath = $targetDir . $uniqueName;
                    $targetDisplayPath = $filePath . $uniqueName;

                    if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                        $uploadedPaths[] = $targetDisplayPath;
                    }
                }
            }

            if (!empty($uploadedPaths)) {
                $finalImageString = implode(',', $uploadedPaths);
                $accQ = $db->query("UPDATE `accommodation` SET `accommodation_image`='$finalImageString' WHERE `id`='$acc_id'");
                if ($accQ) {
                    $msg = json_encode(["status" => "success", "msg" => "Accommodation Image uploaded Successfully"]);
                } else {
                    $msg = json_encode(["status" => "error", "msg" => "Something wrong while uploading file."]);
                }
            } else {
                $msg = json_encode(["status" => "error", "msg" => "Only jpg, png, jpeg and webp are allowed."]);
            }
        } else {
            $msg = json_encode(["status" => "error", "msg" => "No image selected."]);
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

        if (!empty($_FILES["event_img"]["name"][0])) {

            $uploadedPaths = [];
            $allowTypes = array('jpg', 'png', 'jpeg', 'webp');

            foreach ($_FILES["event_img"]["name"] as $index => $fileName) {
                $fileTmpPath = $_FILES["event_img"]["tmp_name"][$index];
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                if (in_array(strtolower($fileType), $allowTypes)) {
                    $uniqueName = time() . '_' . rand(1000, 9999) . '.' . $fileType;
                    $targetFilePath = $targetDir . $uniqueName;
                    $targetDisplayPath = $filePath . $uniqueName;

                    if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                        $uploadedPaths[] = $targetDisplayPath;
                    }
                }
            }

            if (!empty($uploadedPaths)) {
                $finalImageString = implode(',', $uploadedPaths);
                $eventQ = $db->query("UPDATE `events` SET `event_img`='$finalImageString' WHERE `id`='$event_id'");
                if ($eventQ) {
                    $msg = json_encode(["status" => "success", "msg" => "Event Image Uploaded Successfully"]);
                } else {
                    $msg = json_encode(["status" => "error", "msg" => "Something wrong while uploading file."]);
                }
            } else {
                $msg = json_encode(["status" => "error", "msg" => "Only jpg, png, jpeg and webp are allowed."]);
            }

        } else {
            $msg = json_encode(["status" => "error", "msg" => "No image selected."]);
        }

    } catch (\Throwable $th) {
        $msg = json_encode(["status" => "error", "msg" => "Something went wrong."]);
    }

    echo $msg;

endif;