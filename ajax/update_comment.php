<?php

require_once '../core/database.php';

if (isset($_POST['upd_rating']) && isset($_POST['upd_comment'])):
    $rating = $_POST['upd_rating'];
    $comment = $_POST['upd_comment'];
    $current_date = date('Y-m-d');
    $msg = '';

    $upd_comment = $db->query("UPDATE `comments` SET `comment`='$comment', `rating`='$rating', `comment_date`='$current_date' WHERE `tourist_id`='$userid'");

    if ($upd_comment):
        $msg = json_encode(["status" => "success", "msg" => "Comment Updated Successfully."]);
    else:
        $msg = json_encode(["status" => "error", "msg" => "Something went wrong."]);
    endif;

    echo $msg;
endif;
