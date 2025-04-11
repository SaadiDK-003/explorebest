<?php
require_once 'core/database.php';
if (isLoggedIn()) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env("TITLE") ?> | Register</title>
    <?php include_once 'includes/external_css.php'; ?>
</head>

<body id="login">
    <div class="container mx-auto vh-100 d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 text-center mb-3">
                <h1><span class="text-primary"><?= env("TITLE") ?></span> <span class="text-secondary">|</span> Register
                </h1>
            </div>
            <div class="col-12 col-md-3 mx-auto">
                <?php if (isset($_POST['submit'])):
                    register($_POST);
                endif; ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-12 col-md-12 mb-3">
                            <div class="form-group">
                                <label for="username" class="form-label">Name</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 mb-3">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 mb-3">
                            <div class="form-group">
                                <label for="role" class="form-label">Select Role</label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="" selected hidden>Select Option</option>
                                    <option value="local">Local Guide</option>
                                    <option value="tourist">Tourist</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 mb-3">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group d-flex justify-content-between">
                                <a href="./login.php" class="btn btn-primary">Login</a>
                                <button type="submit" name="submit" class="btn btn-success">REGISTER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once 'includes/external_js.php'; ?>

    <script>
        $(document).ready(function () {

            $(document).on('change', 'select[id="role"]', function (e) {
                e.preventDefault();
                let val = $(this).val();
                $('.patient, .pharmacist').addClass('d-none');
                $(`#${val}`).removeClass('d-none');

            });

            $(document).on('click', 'input[type=radio]', function (e) {
                let val = $(this).val();
                if (val == 'yes') {
                    $("#disease_wrapper").removeClass('d-none');
                } else {
                    $("#disease_wrapper").addClass('d-none');
                }
            });
        });
    </script>

</body>

</html>