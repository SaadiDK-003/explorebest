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
                    <?php if (isset($_POST['city_id']) && isset($_POST['event_name'])) {
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
                                    <label for="event_name" class="form-label">Event Name</label>
                                    <input type="text" name="event_name" id="event_name" class="form-control" required>
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
                                    <label for="event_image" class="form-label">Event Image</label>
                                    <input type="file" multiple name="event_image[]" id="event_image"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="booking_link" class="form-label">Booking Link</label>
                                    <input type="text" name="booking_link" id="booking_link" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
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
            <div class="row mt-5">
                <div class="col-12">
                    <table id="event-table"
                        class="table table-bordered table-striped table-responsive text-center align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">City Name</th>
                                <th class="text-center">Event Name</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Booking Link</th>
                                <th class="text-center">Event Img</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $events_Q = $db->query("CALL `get_events_user`($userid)");
                            if ($events_Q->num_rows > 0):
                                while ($event = $events_Q->fetch_object()):
                                    $status = $event->status;
                                    $images = explode(',', $event->event_img);
                                    $imagesCount = count($images);
                                    ?>

                                    <tr>
                                        <td class="text-center"><?= $event->city_name ?></td>
                                        <td class="text-center"><?= $event->event_name ?></td>
                                        <td class="text-center"><?= $event->date ?></td>
                                        <td class="text-center">
                                            <span><?= $event->booking_link ?></span>
                                        </td>

                                        <?php if ($imagesCount == 1): ?>
                                            <td class="text-center">
                                                <img src="<?= env("SITE_URL") ?><?= $images[0] ?>" width="80" height="80"
                                                    class="d-block mx-auto rounded" alt="place_<?= $event->event_id ?>">
                                            </td>
                                        <?php else: ?>
                                            <td class="img text-center">
                                                <?php foreach ($images as $image): ?>
                                                    <img src="<?= env("SITE_URL") ?><?= $image ?>" width="80" height="80"
                                                        class="d-block mx-auto rounded" alt="place_<?= $event->event_id ?>">
                                                <?php endforeach; ?>
                                            </td>
                                        <?php endif; ?>

                                        <td class="text-center">
                                            <?= $status == '0' ? '<span class="btn btn-sm btn-warning">Pending</span>' : '<span class="btn btn-sm btn-success">Active</span>' ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="#!" data-id="<?= $event->event_id ?>" data-bs-toggle="modal"
                                                data-bs-target="#updEventImgModal" data-msg="Place"
                                                class="btn btn-sm btn-warning btn-upd-event-img"><i
                                                    class="fas fa-image"></i></a>
                                            <a href="#!" data-id="<?= $event->event_id ?>" data-bs-toggle="modal"
                                                data-bs-target="#updEventModal" data-table="events"
                                                class="btn btn-sm btn-primary btn-upd-event"><i class="fas fa-edit"></i></a>
                                            <a href="#!" data-id="<?= $event->event_id ?>" data-table="events" data-msg="Event"
                                                class="btn btn-sm btn-danger btn-del"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>

                                    <?php
                                endwhile;
                            endif;
                            $events_Q->close();
                            $db->next_result();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="updEventModal" tabindex="-1" aria-labelledby="updEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="updateEventContent">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updEventModalLabel">Update Event</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="upd_city" class="form-label">City</label>
                                    <select name="city_id" id="upd_city" class="form-select" required>
                                        <option value="" selected hidden>Select City</option>
                                        <?= cityList() ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="upd_event_name" class="form-label">Event Name</label>
                                    <input type="text" name="event_name" id="upd_event_name" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="upd_date" class="form-label">Event Date</label>
                                    <input type="date" name="date" id="upd_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="upd_booking_link" class="form-label">Booking Link</label>
                                    <input type="text" name="booking_link" id="upd_booking_link" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="upd_event_id" name="upd_event_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Image -->
    <div class="modal fade" id="updEventImgModal" tabindex="-1" aria-labelledby="updEventImgModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="updateEventImg" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updEventImgModalLabel">Update Event Image</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="upd_event_img" class="form-label">Event Image</label>
                                    <input type="file" multiple name="event_img[]" id="upd_event_img"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="event_img_upd_id" name="event_img_upd_id">
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
            new DataTable("#event-table", {
                info: false,
                ordering: false,
                pageLength: 5,
                layout: {
                    topStart: null
                }
            });

            // Fetch Content
            $(document).on("click", ".btn-upd-event", function (e) {
                e.preventDefault();
                let id = $(this).data("id");

                $.ajax({
                    url: "ajax/upd_event.php",
                    method: "POST",
                    data: {
                        event_id: id
                    },
                    success: function (response) {
                        let res = JSON.parse(response);
                        console.log(res);
                        $("#upd_event_id").val(res.event_id);
                        $("#upd_city").children('option[selected]').val(res.city_id).text(res.city_name);
                        $("#upd_event_name").val(res.event_name);
                        $("#upd_date").val(res.date);
                        $("#upd_booking_link").val(res.booking_link);
                    }
                });

            });

            // Update Event
            $("#updateEventContent").on("submit", function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "ajax/upd_event.php",
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

            // set ID for Image Upload
            $(document).on("click", ".btn-upd-event-img", function (e) {
                e.preventDefault();
                let id = $(this).data("id");
                $("#event_img_upd_id").val(id);
            });

            // Update Image
            $("#updateEventImg").on("submit", function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "ajax/upload.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
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