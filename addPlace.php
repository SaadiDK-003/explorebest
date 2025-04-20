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
    <title><?= env("TITLE") ?> | Places Dashboard</title>
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
                        addPlace($_POST, $_FILES, $userid);
                    } ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="text-center">Add A Place</h1>
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
                                    <label for="type" class="form-label">Type</label>
                                    <select name="type" id="type" class="form-select" required>
                                        <option value="" selected hidden>Select Type</option>
                                        <?= placeTypes() ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" name="location" id="location" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="place_image" class="form-label">Place Image</label>
                                    <input type="file" multiple name="place_image[]" id="place_image"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" name="description" id="description" class="form-control"
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
                                    <button type="submit" class="btn btn-success">Add Place</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <table id="places-table"
                        class="table table-bordered table-striped table-responsive text-center align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">City Name</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $places_Q = $db->query("CALL `get_places_user`($userid)");
                            if ($places_Q->num_rows > 0):
                                while ($place = $places_Q->fetch_object()):
                                    $status = $place->status;
                                    $images = explode(',', $place->place_img);
                                    $imagesCount = count($images);
                                    ?>

                                    <tr>
                                        <td class="text-center"><?= $place->city_name ?></td>
                                        <td class="text-center"><?= $place->type ?></td>
                                        <td class="text-center"><?= $place->location ?></td>
                                        <td class="text-center"><?= $place->description ?></td>
                                        <?php if ($imagesCount == 1): ?>
                                            <td class="text-center">
                                                <img src="<?= env("SITE_URL") ?><?= $images[0] ?>" width="80" height="80"
                                                    class="d-block mx-auto rounded" alt="place_<?= $place->place_id ?>">
                                            </td>
                                        <?php else: ?>
                                            <td class="img text-center">
                                                <?php foreach ($images as $image): ?>
                                                    <img src="<?= env("SITE_URL") ?><?= $image ?>" width="80" height="80"
                                                        class="d-block mx-auto rounded" alt="place_<?= $place->place_id ?>">
                                                <?php endforeach; ?>
                                            </td>
                                        <?php endif; ?>
                                        <td class="text-center">
                                            <?= $status == '0' ? '<span class="btn btn-sm btn-warning">Pending</span>' : '<span class="btn btn-sm btn-success">Active</span>' ?>
                                        </td>
                                        <td class="text-center">
                                            <!-- img upd -->
                                            <a href="#!" data-id="<?= $place->place_id ?>" data-bs-toggle="modal"
                                                data-bs-target="#placeImgModal" data-table="places"
                                                class="btn btn-sm btn-warning btn-upd-place-img"><i
                                                    class="fas fa-image"></i></a>
                                            <!-- content upd -->
                                            <a href="#!" data-id="<?= $place->place_id ?>" data-bs-toggle="modal"
                                                data-bs-target="#updPlace" data-table="places"
                                                class="btn btn-sm btn-primary btn-upd-place"><i class="fas fa-edit"></i></a>
                                            <!-- del -->
                                            <a href="#!" data-id="<?= $place->place_id ?>" data-table="places" data-msg="Place"
                                                class="btn btn-sm btn-danger btn-del"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>

                                    <?php
                                endwhile;
                            endif;
                            $places_Q->close();
                            $db->next_result();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="updPlace" tabindex="-1" aria-labelledby="updPlaceLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="updatePlaceContent">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updPlaceLabel">Update Place</h1>
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
                                    <label for="upd_type" class="form-label">Type</label>
                                    <select name="type" id="upd_type" class="form-select" required>
                                        <option value="" selected hidden>Select Type</option>
                                        <?= placeTypes() ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="upd_location" class="form-label">Location</label>
                                    <input type="text" name="location" id="upd_location" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="upd_description" class="form-label">Description</label>
                                    <input type="text" name="description" id="upd_description" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="upd_place_id" name="upd_place_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Image -->
    <div class="modal fade" id="placeImgModal" tabindex="-1" aria-labelledby="placeImgModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="updatePlaceImg" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="placeImgModalLabel">Update Place Image</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="upd_place_img" class="form-label">Place Image</label>
                                    <input type="file" multiple name="place_image[]" id="upd_place_img" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="place_img_upd_id" name="place_img_upd_id">
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
            new DataTable("#places-table", {
                info: false,
                ordering: false,
                pageLength: 5,
                layout: {
                    topStart: null
                }
            });

            // Fetch Content
            $(document).on("click", ".btn-upd-place", function (e) {
                e.preventDefault();
                let id = $(this).data("id");

                $.ajax({
                    url: "ajax/upd_place.php",
                    method: "POST",
                    data: {
                        place_id: id
                    },
                    success: function (response) {
                        let res = JSON.parse(response);
                        $("#upd_place_id").val(res.place_id);
                        $("#upd_city").children('option[selected]').val(res.city_id).text(res.city_name);
                        $("#upd_type").children('option[selected]').val(res.type).text(res.type);
                        $("#upd_location").val(res.location);
                        $("#upd_description").val(res.description);
                    }
                });
            });

            // Update Place
            $("#updatePlaceContent").on("submit", function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "ajax/upd_place.php",
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
            $(document).on("click", ".btn-upd-place-img", function (e) {
                e.preventDefault();
                let id = $(this).data("id");
                $("#place_img_upd_id").val(id);
            });

            // Update Image
            $("#updatePlaceImg").on("submit", function (e) {
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