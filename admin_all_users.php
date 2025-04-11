<?php
require_once 'core/database.php';
if ($userRole != 'admin') {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env("TITLE") ?> | Admin Dashboard</title>
    <?php include_once "includes/external_css.php"; ?>
</head>

<body id="adminDashboard">
    <?php include_once "includes/header.php"; ?>
    <main>
        <div class="container my-5">
            <div class="row">
                <div class="col-12">
                    <div class="btn_wrapper d-flex justify-content-center gap-2">
                        <a href="./adminDashboard.php" class="btn btn-primary">Go Back</a>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-md-5 mx-auto">
                    <table id="users-table"
                        class="table table-bordered table-striped table-responsive text-center align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $users__Q = $db->query("CALL `get_all_users`()");
                            if ($users__Q->num_rows > 0):
                                while ($type = $users__Q->fetch_object()): ?>

                                    <tr>
                                        <td><?= $type->username ?></td>
                                        <td><?= $type->email ?></td>
                                        <td><?= $type->role ?></td>
                                    </tr>

                                    <?php
                                endwhile;
                            endif;
                            $users__Q->close();
                            $db->next_result();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <?php include_once "includes/footer.php"; ?>
    <?php include_once "includes/external_js.php"; ?>

    <script>
        $(document).ready(function () {
            new DataTable("#users-table", {
                info: false,
                ordering: false,
                pageLength: 5,
                layout: {
                    topStart: null
                }
            });

            // Add Type
            $("#add_place_type_form").on("submit", function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "admin/update_place_type.php",
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


            $(document).on("click", ".btn-upd-type", function (e) {
                e.preventDefault();
                let id = $(this).data("id");
                let type = $(this).data("type");
                $(".type_form").attr("id", "upd_type_form");
                $(".type_form").find("#type").attr("name", "type_update").val(type);
                $("input[name='place_type_id']").val(id);
                $("input[name='old_type']").val(type);
                $(".type_form").find("button").text("Update");
            });

            // Update Type
            $("#upd_type_form").on("submit", function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "admin/update_place_type.php",
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