<?php
require_once 'core/database.php';
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($userRole != 'local') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env("TITLE") ?> | Events Dashboard</title>
    <?php include_once "includes/external_css.php"; ?>
</head>

<body id="localDashboard">
    <?php include_once "includes/header.php"; ?>
    <main>
        <div class="container my-5">
            <div class="row">
                <div class="col-12 my-4 text-center">
                    <a href="./localDashboard.php" class="btn btn-primary">Go Back</a>
                </div>
                <div class="col-12 col-md-6 mx-auto">
                    <?php if (isset($_POST['city_id']) && isset($_POST['type'])) {
                        addEvent($_POST, $_FILES, $userid);
                    } ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="text-center">Add An Event</h1>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="city" class="form-label">City</label>
                                    <select name="city_id" id="city" class="form-select" required>
                                        <option value="" selected hidden>Select City</option>
                                        <?= cityList() ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="name" class="form-label">Event Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="date" class="form-label">Event Date</label>
                                    <input type="date" name="date" id="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="place_image" class="form-label">Place Image</label>
                                    <input type="file" name="place_image" id="place_image" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="booking_link" class="form-label">Booking Link</label>
                                    <input type="text" name="booking_link" id="booking_link" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success">Add Event</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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