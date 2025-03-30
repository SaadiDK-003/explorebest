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
            <form id="add_place_type_form" class="type_form my-4">
                <div class="row">
                    <div class="col-12 col-md-3 mx-auto">
                        <div class="row">
                            <div class="col-12 mx-auto mb-3">
                                <div class="form-group">
                                    <label for="type" class="form-label">Accommodation Type</label>
                                    <input type="text" name="type" id="type" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group d-flex justify-content-end">
                                    <input type="hidden" name="old_type">
                                    <input type="hidden" name="acc_type_id">
                                    <button type="submit" class="btn btn-success">Add Type</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-12 col-md-5 mx-auto">
                    <table id="type-table"
                        class="table table-bordered table-striped table-responsive text-center align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">Accommodation Name</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $accT_Q = $db->query("CALL `get_acc_types`()");
                            if ($accT_Q->num_rows > 0):
                                while ($type = $accT_Q->fetch_object()): ?>

                                    <tr>
                                        <td><?= $type->types ?></td>
                                        <td>
                                            <a href="#!" data-id="<?= $type->id ?>" data-type="<?= $type->types ?>"
                                                class="btn btn-sm btn-primary btn-upd-type"><i class="fas fa-pencil"></i></a>
                                            <a href="#!" data-id="<?= $type->id ?>" data-table="accommodation_types"
                                                data-msg="Type" class="btn btn-sm btn-danger btn-del"><i
                                                    class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>

                                    <?php
                                endwhile;
                            endif;
                            $accT_Q->close();
                            $db->next_result();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="#!" class="btn btn-secondary btn-sm">Accommodation Types</a>
                </div>
            </div>
        </div>
    </main>
    <?php include_once "includes/footer.php"; ?>
    <?php include_once "includes/external_js.php"; ?>

    <script>
        $(document).ready(function () {
            new DataTable("#type-table", {
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
                    url: "admin/update_acc_type.php",
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
                $("input[name='acc_type_id']").val(id);
                $("input[name='old_type']").val(type);
                $(".type_form").find("button").text("Update");
            });

            // Update Type
            $("#upd_type_form").on("submit", function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "admin/update_acc_type.php",
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