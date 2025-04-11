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

<body id="localDashboard">
    <?php include_once "includes/header.php"; ?>
    <main>
        <div class="container my-5">
            <div class="row">
                <div class="col-12">
                    <div class="buttons_wrapper position-relative text-center">
                        <a href="./my_comments.php" class="btn btn-secondary">My Comments</a>
                        <a href="./edit_profile.php" class="btn btn-primary profile-btn position-absolute">Edit
                            Profile</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Places -->
        <section class="places">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="bg-primary-custom text-white rounded ps-2 mb-3">Favorite Places</h1>
                    </div>
                    <?php
                    $places_Q = $db->query("CALL `get_fav_places_by_user_id`($userid)");
                    if (mysqli_num_rows($places_Q) > 0) {
                        while ($place_ = $places_Q->fetch_object()):
                            ?>
                            <div class="col-12 col-md-3 mb-3">
                                <div class="content position-relative bg-white p-2 rounded">
                                    <div class="img">
                                        <a href="./viewComments.php?place_id=<?= $place_->place_id ?>"
                                            class="btn btn-sm btn-primary btn-view-rating position-absolute">
                                            <span>View Comments</span>
                                        </a>
                                        <a href="#!" data-id="<?= $place_->fp_id ?>" data-table="fav_places"
                                            data-msg="Favorite Place"
                                            class="btn btn-sm btn-danger btn-add-fav btn-del position-absolute">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                        <img src="<?= $place_->place_img ?>" alt="restaurant">
                                    </div>
                                    <hr>
                                    <a href="#!" data-id="<?= $place_->place_id ?>"
                                        class="btn btn-sm btn-success btn-rating position-absolute" data-bs-toggle="modal"
                                        data-bs-target="#addComment">
                                        <span>Give Comments</span>
                                    </a>
                                    <div class="info d-flex align-items-center justify-content-between mt-5">
                                        <h3><?= $place_->city_name ?></h3>
                                        <h5 class="btn btn-sm btn-secondary"><?= $place_->type ?></h5>
                                    </div>
                                    <p>
                                        <?= $place_->description ?>
                                    </p>
                                    <a href="<?= $place_->location ?>" target="_blank"
                                        class="btn btn-primary w-100">Location</a>
                                </div>
                            </div>
                        <?php endwhile;
                    } else { ?>
                        <div class="col-12">
                            <h1 class="text-center alert alert-info">No Record Found</h1>
                        </div>
                    <?php }
                    $places_Q->close();
                    $db->next_result(); ?>
                </div>
            </div>
        </section>

        <!-- Accommodations -->
        <section class="accommodations">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="bg-primary-custom text-white rounded ps-2 mb-3">Favorite Accommodations</h1>
                    </div>
                    <?php
                    $acc_Q = $db->query("CALL `get_fav_acc_by_user_id`($userid)");
                    if (mysqli_num_rows($acc_Q) > 0) {
                        while ($acc_ = $acc_Q->fetch_object()):
                            $services = explode(",", $acc_->services);
                            ?>
                            <div class="col-12 col-md-3 mb-3">
                                <div class="content bg-white p-2 rounded">
                                    <div class="img position-relative">
                                        <a href="#!" data-id="<?= $acc_->fav_acc_id ?>" data-table="fav_accommodation"
                                            data-msg="Favorite Accommodation"
                                            class="btn btn-sm btn-danger btn-add-fav btn-del position-absolute">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <img src="<?= $acc_->acc_img ?>" alt="restaurant">
                                    </div>
                                    <hr>
                                    <div class="info d-flex align-items-center justify-content-between">
                                        <h3><?= $acc_->city_name ?></h3>
                                        <h5 class="btn btn-sm btn-secondary"><?= $acc_->type ?></h5>
                                    </div>
                                    <ul>
                                        <?php foreach ($services as $service) {
                                            echo '<li>' . $service . '</li>';
                                        } ?>
                                    </ul>
                                    <a href="<?= $acc_->location ?>" target="_blank" class="btn btn-primary w-100">Location</a>
                                </div>
                            </div>
                        <?php endwhile;
                    } else { ?>
                        <div class="col-12">
                            <h1 class="text-center alert alert-info">No Record Found</h1>
                        </div>
                    <?php }
                    $acc_Q->close();
                    $db->next_result(); ?>
                </div>
            </div>
        </section>

        <!-- Events -->
        <section class="events">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="bg-primary-custom text-white rounded ps-2 mb-3">Favorite Events</h1>
                    </div>
                    <?php
                    $event_Q = $db->query("CALL `get_fav_event_by_user_id`($userid)");
                    if (mysqli_num_rows($event_Q) > 0) {
                        while ($event_ = $event_Q->fetch_object()):
                            ?>
                            <div class="col-12 col-md-3 mb-3">
                                <div class="content bg-white p-2 rounded">
                                    <div class="img position-relative">
                                        <a href="#!" data-id="<?= $event_->fe_id ?>" data-table="fav_events"
                                            data-msg="Favorite Event"
                                            class="btn btn-sm btn-danger btn-add-fav btn-del position-absolute">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <img src="<?= $event_->event_img ?>" alt="restaurant">
                                    </div>
                                    <hr>
                                    <div class="info d-flex align-items-center justify-content-between">
                                        <h3><?= $event_->event_name ?></h3>
                                        <h5 class="btn btn-sm btn-secondary"><?= $event_->city_name ?></h5>
                                    </div>
                                    <p>
                                        <strong>Event Date: </strong>
                                        <?= date('d-M-Y', strtotime($event_->date)) ?>
                                    </p>
                                    <a href="<?= $event_->booking_link ?>" target="_blank" class="btn btn-primary w-100">Booking
                                        Link</a>
                                </div>
                            </div>
                        <?php endwhile;
                    } else { ?>
                        <div class="col-12">
                            <h1 class="text-center alert alert-info">No Record Found</h1>
                        </div>
                    <?php }
                    $event_Q->close();
                    $db->next_result(); ?>
                </div>
            </div>
        </section>
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