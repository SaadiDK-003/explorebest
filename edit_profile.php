<?php
require_once 'core/database.php';
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env("TITLE") ?> | Edit Profile</title>
    <?php include_once "includes/external_css.php"; ?>
</head>

<body id="localDashboard">
    <?php include_once "includes/header.php"; ?>
    <main>
        <div class="container my-5">
            <form action="" method="post">
                <div class="row">
                    <div class="col-12 col-md-4 mx-auto">
                        <h5 class="text-center">Edit Profile</h5>
                        <?php if (isset($_POST['submit'])):
                            editProfile($_POST, $userid);
                        endif
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-3 mx-auto">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="username" class="form-label">Name</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                        value="<?= $userName ?>" required>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        value="<?= $userEmail ?>" required>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" name="password" id="password" class="form-control">
                                    <code>Leave blank, if you don't wanna change.</code>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group d-flex justify-content-end">
                                    <input type="hidden" name="old_password" value="<?= $userPwd ?>">
                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <?php include_once "includes/footer.php"; ?>
    <?php include_once "includes/external_js.php"; ?>

    <script>
        $(document).ready(function () {
            new DataTable("#cities", {
                info: false,
                ordering: false,
                pageLength: 5,
                layout: {
                    topStart: null
                }
            });
            // Add City
            $("#add_city_form").on("submit", function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "ajax/city.php",
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


            $(document).on("click", ".btn-upd-city", function (e) {
                e.preventDefault();
                let id = $(this).data("id");
                let city = $(this).data("city");
                $(".city_form").attr("id", "upd_city_form");
                $(".city_form").find("#city_name").attr("name", "city_update").val(city);
                $("input[name='city_id']").val(id);
                $(".city_form").find("button").text("Update");
            });

            // Update City
            $("#upd_city_form").on("submit", function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "ajax/city.php",
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