<?php
require_once 'core/database.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}
if ($userRole != 'tourist') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env("TITLE") ?> | Tourist Dashboard</title>
    <?php include_once "includes/external_css.php"; ?>
</head>

<body id="touristDashboard">
    <?php include_once "includes/header.php"; ?>
    <main>
        <div class="container my-5">
            <div class="row">
                <div class="col-12">
                    <div class="btn_wrapper d-flex justify-content-center gap-2">
                        <a href="./touristDashboard.php" class="btn btn-primary">Go Back</a>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-md-10 mx-auto">
                    <table id="comments-table"
                        class="table table-bordered table-striped table-responsive text-center align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">Comment</th>
                                <th class="text-center">Rating</th>
                                <th class="text-center">Comment Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $comment_Q = $db->query("CALL `get_comments_by_user_id`($userid)");
                            if ($comment_Q->num_rows > 0):
                                while ($comment = $comment_Q->fetch_object()): ?>

                                    <tr>
                                        <td class="text-center"><?= $comment->comment ?></td>
                                        <td class="text-center"><?= $comment->rating ?></td>
                                        <td class="text-center"><?= $comment->comment_date ?></td>
                                        <td>
                                            <a href="#!" data-id="<?= $comment->comment_id ?>"
                                                data-rating="<?= $comment->rating ?>" data-comment="<?= $comment->comment ?>"
                                                data-bs-toggle="modal" data-bs-target="#commentModal"
                                                class="btn btn-sm btn-primary btn-upd-comment"><i class="fas fa-pencil"></i></a>
                                            <a href="#!" data-id="<?= $comment->comment_id ?>" data-table="comments"
                                                data-msg="Comment" class="btn btn-sm btn-danger btn-del"><i
                                                    class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>

                                    <?php
                                endwhile;
                            endif;
                            $comment_Q->close();
                            $db->next_result();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Image -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="updateCommentForm">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="commentModalLabel">Update Comment</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="upd_rating" class="form-label">Rating</label>
                                    <select name="upd_rating" id="upd_rating" class="form-control" required>
                                        <option value="" selected hidden></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="upd_comment" class="form-label">Comment</label>
                                    <textarea type="text" rows="4" name="upd_comment" id="upd_comment"
                                        class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="acc_img_upd_id" name="acc_img_upd_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once "includes/footer.php"; ?>
    <?php include_once "includes/external_js.php"; ?>

    <script>
        $(document).ready(function () {
            new DataTable("#comments-table", {
                info: false,
                ordering: false,
                pageLength: 5,
                layout: {
                    topStart: null
                }
            });

            $(document).on("click", ".btn-upd-comment", function (e) {
                e.preventDefault();
                let comment = $(this).data('comment');
                let rating = $(this).data('rating');
                $("#upd_comment").val(comment);
                $(`#upd_rating option[value="${rating}"]`).attr("selected", true);
            });

            // Update Comment
            $("#updateCommentForm").on("submit", function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "ajax/update_comment.php",
                    method: "post",
                    data: formData,
                    success: function (response) {
                        let res = JSON.parse(response);
                        if (res.status == "success") {
                            $("#ToastSuccess").addClass("fade show");
                            $("#ToastSuccess .toast-body").html(res.msg);
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            $("#ToastDanger").addClass("fade show");
                            $("#ToastDanger .toast-body").html(res.msg);
                        }
                    }
                });
            });

            // Delete
            $(document).on("click", ".btn-del", function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                let table = $(this).data('table');
                let msg = $(this).data('msg');

                $.ajax({
                    url: "ajax/delete.php",
                    method: "post",
                    data: {
                        del_id: id,
                        del_table: table,
                        msg: msg
                    },
                    success: function (response) {
                        console.log(response);

                        let res = JSON.parse(response);
                        $('#ToastDanger').addClass('fade show');
                        $("#ToastDanger .toast-body").html(res.msg);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1800);
                    }
                });
            });

        });
    </script>
</body>

</html>