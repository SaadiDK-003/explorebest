<?php

require_once '../core/database.php';

if (isset($_POST["comments"]) && isset($_POST["checked_count"])):

    $tourist_id = $_POST["tourist_id"];
    $place_id = $_POST["place_id"];
    $comment = $_POST["comments"];
    $count_ = $_POST["checked_count"];
    $current_date = date('Y-m-d');
    $msg = '';
    if (checkCommentExist($tourist_id, $place_id) === false):
        $addComment = $db->query("INSERT INTO `comments` (comment,rating,tourist_id,place_id,comment_date) VALUES('$comment','$count_','$tourist_id','$place_id','$current_date')");
        if ($addComment):
            $msg = json_encode(["status" => "success", "msg" => "Comment Added Successfully."]);
        endif;
    else:
        $msg = json_encode(["status" => "error", "msg" => "You have already commented on this."]);
    endif;

    echo $msg;
endif;