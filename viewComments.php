<?php
require_once 'core/database.php';
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET["place_id"])) {
    header("Location: index.php");
    exit();
}

$place_id = $_GET["place_id"] ?? '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env("TITLE") ?> | Comments</title>
    <?php include_once "includes/external_css.php"; ?>
</head>

<body id="comments">
    <?php include_once "includes/header.php"; ?>
    <main>
        <div class="container my-5">
            <div class="row">
                <?php $comment_Q = $db->query("CALL `get_comments_by_place`($place_id)");
                if (mysqli_num_rows($comment_Q) > 0):
                    while ($comment = $comment_Q->fetch_object()):
                        ?>
                        <div class="col-12 col-md-8 mx-auto mb-3">
                            <div class="comment-wrapper position-relative rounded p-2">
                                <h3><?= $comment->username ?> <span class="ms-3 h6">Date: <span
                                            class="text-secondary"><?= date('d-M-Y', strtotime($comment->comment_date)) ?></span></span>
                                </h3>
                                <p><?= $comment->comment ?></p>
                                <div class="ratings position-absolute rate-<?= $comment->rating ?>">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    echo '<div class="col-12 text-center mx-auto"><a href=./index.php class="btn btn-primary">Go Back</a></div>';
                else: ?>
                    <h1 class="text-center alert alert-info">No Comment Found!</h1>
                <?php endif;
                $comment_Q->close();
                $db->next_result(); ?>
            </div>
        </div>
    </main>
    <?php include_once "includes/footer.php"; ?>
    <?php include_once "includes/external_js.php"; ?>

    <script>
        $(document).ready(function () { });
    </script>
</body>

</html>