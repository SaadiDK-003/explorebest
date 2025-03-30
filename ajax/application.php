<?php

require_once '../core/database.php';

if (isset($_POST['title']) && isset($_POST['link'])):

    $targetDir = '../img/app/';
    $imgPath = './img/app/';
    $keys = '';
    $values = '';
    $msg = '';

    try {

        if (!empty($_FILES["image"]["name"])) {

            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $imgPath = $imgPath . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
            if (in_array($fileType, $allowTypes)) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    foreach ($_POST as $key => $value) {
                        if ($key != 'app_id') {
                            $keys .= $key . ',';
                            $values .= "'" . $value . "',";
                        }
                    }

                    $keys .= 'image';
                    $values .= "'" . $imgPath . "'";

                    $placesQ = $db->query("INSERT INTO `applications` ($keys) VALUES($values)");
                    if ($placesQ) {
                        $msg = json_encode(["status" => "success", "msg" => "Application Added Successfully."]);
                    }
                } else {
                    $msg = json_encode(["status" => "error", "msg" => "Something wrong while uploading file."]);
                }
            } else {
                $msg = json_encode(["status" => "error", "msg" => "Only jpg, png, jpeg and webp are allowed."]);
            }
        }

    } catch (\Throwable $th) {
        $msg = json_encode(["status" => "error", "msg" => $th->getMessage()]);
    }

    echo $msg;

endif;

if (isset($_POST['title_update']) && isset($_POST['link_update'])):

    $id = $_POST['app_id'];
    $title = $_POST['title_update'];
    $link = $_POST['link_update'];

    $upd_app = $db->query("UPDATE `applications` SET `title`='$title', `link`='$link' WHERE `id`='$id'");

    if ($upd_app) {
        echo json_encode(["status" => "success", "msg" => "Updated Successfully."]);
    }
endif;