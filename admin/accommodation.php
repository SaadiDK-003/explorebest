<?php
require_once '../core/database.php';
if ($userRole != 'admin') {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env("TITLE") ?> | Admin Places Dashboard</title>
    <?php include_once "../includes/external_css.php"; ?>
</head>

<body id="adminPlacesDashboard">
    <?php include_once "../includes/header.php"; ?>
    <main>
        <div class="container my-5">
            <div class="row">
                <div class="col-12">
                    <div class="btn_wrapper d-flex justify-content-center">
                        <a href="../adminDashboard.php" class="btn btn-primary">Go Back</a>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 mx-auto">
                    <table id="places"
                        class="table table-bordered table-striped table-responsive text-center align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">City Name</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">Services</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $acc_Q = $db->query("CALL `get_acc_admin`()");
                            if ($acc_Q->num_rows > 0):
                                while ($acc = $acc_Q->fetch_object()):
                                    $status = $acc->status;
                                    ?>

                                    <tr>
                                        <td class="text-center"><?= $acc->city_name ?></td>
                                        <td class="text-center"><?= $acc->type ?></td>
                                        <td class="text-center"><?= $acc->location ?></td>
                                        <td class="text-center"><?= $acc->services ?></td>
                                        <td class="text-center">
                                            <img src="<?= env("SITE_URL") ?><?= $acc->accommodation_image ?>" width="80"
                                                height="80" class="d-block mx-auto rounded" alt="acc_<?= $acc->acc_id ?>">
                                        </td>
                                        <td class="text-center">
                                            <?= $status == '0' ? '<span class="btn btn-sm btn-warning">Pending</span>' : '<span class="btn btn-sm btn-success">Active</span>' ?>
                                        </td>
                                        <td class="text-center"><a href="#!" data-id="<?= $acc->acc_id ?>"
                                                data-bs-toggle="modal" data-bs-target="#placeModal" data-msg="Accommodation"
                                                class="btn btn-sm btn-primary btn-get-place"><i class="fas fa-edit"></i></a>
                                            <a href="#!" data-id="<?= $acc->acc_id ?>" data-table="accommodation"
                                                data-msg="Accommodation" class="btn btn-sm btn-danger btn-del"><i
                                                    class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>

                                    <?php
                                endwhile;
                            endif;
                            $acc_Q->close();
                            $db->next_result();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <?php include_once "../includes/footer.php"; ?>
    <?php include_once "../includes/external_js.php"; ?>


    <!-- Modal -->
    <div class="modal fade" id="placeModal" tabindex="-1" aria-labelledby="placeLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="updateAccStatus">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="placeLabel">Upd Accommodation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select type="text" name="status" id="status" class="form-select" required>
                                        <option value="" selected hidden>Select Status</option>
                                        <option value="0">In-Active</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="hidden" name="acc_id">
                        <input type="hidden" name="msg">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            new DataTable("#places", {
                ordering: false,
                pageLength: 5,
                layout: {
                    topStart: null
                }
            });


            $(document).on("click", ".btn-get-place", function (e) {
                e.preventDefault();
                let id = $(this).data("id");
                let msg = $(this).data("msg");
                $("input[name='acc_id']").val(id);
                $("input[name='msg']").val(msg);
            });

            // Update Place Status
            $("#updateAccStatus").on("submit", function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "../ajax/acc_status.php",
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
                    url: "../ajax/delete.php",
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