<?php
function isLoggedIn()
{
      return isset($_SESSION['user']) ? true : false;
}

function login($POST)
{
      global $db;
      $msg = '';
      $email = $POST['email'];
      $pwd = md5($POST['password']);

      $checkUser = $db->query("SELECT * FROM `users` WHERE `email`='$email' AND `password`='$pwd'");

      if (mysqli_num_rows($checkUser) > 0) {
            $user = mysqli_fetch_object($checkUser);
            $_SESSION['user'] = $user->id;
            echo '<h5 class="text-center alert alert-success">Success, Redirecting...</h5> <script>setTimeout(function(){window.location.href = "index.php"},1800)</script>';
      } else {
            echo '<h5 class="text-center alert alert-danger">Please check your credentials.</h5>';
      }

      return $msg;
}
function register($POST)
{
      global $db;
      $msg = '';
      $username = $POST['username'];
      $email = $POST['email'];
      $role = $POST['role'];
      $pwd = $POST['password'];

      if (checkEmailExists($email)) {
            $msg = '<h5 class="text-center alert alert-danger">Email already exists.</h5>';
      } else if (strlen($pwd) < 6) {
            $msg = '<h5 class="text-center alert alert-danger">Password must be greater than 6 characters.</h5>';
      } else {
            $pwd = md5($pwd);
            $db->query("INSERT INTO `users` (username,email,password,role) VALUES('$username','$email','$pwd','$role')");
            $msg = '<h5 class="text-center alert alert-success">Successfully Registered.</h5>
            <script>
                  setTimeout(function(){
                    window.location.href = "./login.php";
                  },1800);
            </script>
            ';
      }

      echo $msg;
}

function checkEmailExists($email)
{
      global $db;
      $checkEmailExist = $db->query("SELECT * FROM `users` WHERE `email`='$email'");
      if (mysqli_num_rows($checkEmailExist) > 0) {
            return true;
      } else {
            return false;
      }
}


function checkCityExist($city)
{
      global $db;
      $checkCityExist = $db->query("SELECT `city_name` FROM `cities` WHERE `city_name`='$city'");
      if (mysqli_num_rows($checkCityExist) > 0) {
            return true;
      } else {
            return false;
      }
}

function cityList()
{
      global $db;
      $cityQ = $db->query("CALL `get_cities`()");
      while ($city = mysqli_fetch_object($cityQ)) {
            ?>
            <option value="<?= $city->id ?>"><?= $city->city_name ?></option>
            <?php
      }
      $cityQ->close();
      $db->next_result();
}

function placeTypes()
{
      global $db;
      $placeT_Q = $db->query("CALL `get_place_types`()");
      while ($placeT = mysqli_fetch_object($placeT_Q)) {
            ?>
            <option value="<?= $placeT->types ?>"><?= $placeT->types ?></option>
            <?php
      }
      $placeT_Q->close();
      $db->next_result();
}

function AccommodationTypes()
{
      global $db;
      $accT_Q = $db->query("CALL `get_acc_types`()");
      while ($accT = mysqli_fetch_object($accT_Q)) {
            ?>
            <option value="<?= $accT->types ?>"><?= $accT->types ?></option>
            <?php
      }
      $accT_Q->close();
      $db->next_result();
}

function addPlace($POST, $FILES, $userid)
{
      global $db;
      $targetDir = './img/place/';
      $msg = '';

      try {
            // Check if multiple images are provided
            if (!empty($FILES["place_image"]["name"][0])) {

                  $uploadedImages = [];

                  // Loop through all uploaded images
                  foreach ($FILES["place_image"]["name"] as $index => $fileName) {
                        $fileTmpPath = $FILES["place_image"]["tmp_name"][$index];
                        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                        $allowTypes = array('jpg', 'png', 'jpeg', 'webp');

                        if (in_array(strtolower($fileType), $allowTypes)) {
                              $uniqueName = time() . '_' . rand(1000, 9999) . '.' . $fileType;
                              $targetFilePath = $targetDir . $uniqueName;

                              if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                                    $uploadedImages[] = $targetFilePath;
                              }
                        }
                  }

                  if (!empty($uploadedImages)) {
                        $keys = '';
                        $values = '';

                        foreach ($POST as $key => $value) {
                              $keys .= $key . ',';
                              $values .= "'" . mysqli_real_escape_string($db, $value) . "',";
                        }

                        // Join all image paths as comma-separated string
                        $imagePaths = implode(',', $uploadedImages);
                        $keys .= 'place_img,u_id';
                        $values .= "'" . $imagePaths . "','" . $userid . "'";

                        $placesQ = $db->query("INSERT INTO `places` ($keys) VALUES($values)");
                        if ($placesQ) {
                              $msg = '<h5 class="alert alert-success text-center">Place Added Successfully with multiple images.</h5>';
                        } else {
                              $msg = '<h5 class="alert alert-danger text-center">Database insert failed.</h5>';
                        }
                  } else {
                        $msg = '<h5 class="alert alert-danger text-center">Only jpg, png, jpeg and webp are allowed.</h5>';
                  }
            } else {
                  $msg = '<h5 class="alert alert-warning text-center">Please select at least one image to upload.</h5>';
            }

      } catch (\Throwable $th) {
            $msg = '<h5 class="alert alert-danger text-center">Something went wrong, check functions file line number ' . __LINE__ . '.</h5>';
      }

      echo $msg;
}


function addAccommodation($POST, $FILES, $userid)
{
      global $db;
      $targetDir = './img/accommodation/';
      $msg = '';

      try {
            if (!empty($FILES["acc_image"]["name"][0])) {

                  $uploadedImages = [];
                  $allowTypes = array('jpg', 'png', 'jpeg', 'webp');

                  foreach ($FILES["acc_image"]["name"] as $index => $fileName) {
                        $fileTmpPath = $FILES["acc_image"]["tmp_name"][$index];
                        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                        if (in_array(strtolower($fileType), $allowTypes)) {
                              $uniqueName = time() . '_' . rand(1000, 9999) . '.' . $fileType;
                              $targetFilePath = $targetDir . $uniqueName;

                              if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                                    $uploadedImages[] = $targetFilePath;
                              }
                        }
                  }

                  if (!empty($uploadedImages)) {
                        $keys = '';
                        $values = '';

                        foreach ($POST as $key => $value) {
                              $keys .= $key . ',';
                              $values .= "'" . mysqli_real_escape_string($db, $value) . "',";
                        }

                        // Join image paths with commas
                        $imagePaths = implode(',', $uploadedImages);
                        $keys .= 'accommodation_image,u_id';
                        $values .= "'" . $imagePaths . "','" . $userid . "'";

                        $insertQ = $db->query("INSERT INTO `accommodation` ($keys) VALUES($values)");

                        if ($insertQ) {
                              $msg = '<h5 class="alert alert-success text-center">Accommodation Added Successfully with multiple images.</h5>';
                        } else {
                              $msg = '<h5 class="alert alert-danger text-center">Database insert failed.</h5>';
                        }

                  } else {
                        $msg = '<h5 class="alert alert-danger text-center">Only jpg, png, jpeg and webp are allowed.</h5>';
                  }

            } else {
                  $msg = '<h5 class="alert alert-warning text-center">Please select at least one image to upload.</h5>';
            }

      } catch (\Throwable $th) {
            $msg = '<h5 class="alert alert-danger text-center">Something went wrong, check functions file line number ' . __LINE__ . '.</h5>';
      }

      echo $msg;
}


function addEvent($POST, $FILES, $userid)
{
      global $db;
      $targetDir = './img/event_/';
      $msg = '';

      try {
            if (!empty($FILES["event_image"]["name"][0])) {

                  $uploadedImages = [];
                  $allowTypes = array('jpg', 'png', 'jpeg', 'webp');

                  foreach ($FILES["event_image"]["name"] as $index => $fileName) {
                        $fileTmpPath = $FILES["event_image"]["tmp_name"][$index];
                        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                        if (in_array(strtolower($fileType), $allowTypes)) {
                              $uniqueName = time() . '_' . rand(1000, 9999) . '.' . $fileType;
                              $targetFilePath = $targetDir . $uniqueName;

                              if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                                    $uploadedImages[] = $targetFilePath;
                              }
                        }
                  }

                  if (!empty($uploadedImages)) {
                        $keys = '';
                        $values = '';

                        foreach ($POST as $key => $value) {
                              $keys .= $key . ',';
                              $values .= "'" . mysqli_real_escape_string($db, $value) . "',";
                        }

                        $imagePaths = implode(',', $uploadedImages);
                        $keys .= 'event_img,u_id';
                        $values .= "'" . $imagePaths . "','" . $userid . "'";

                        $insertQ = $db->query("INSERT INTO `events` ($keys) VALUES($values)");

                        if ($insertQ) {
                              $msg = '<h5 class="alert alert-success text-center">Event Added Successfully with multiple images.</h5>';
                        } else {
                              $msg = '<h5 class="alert alert-danger text-center">Database insert failed.</h5>';
                        }

                  } else {
                        $msg = '<h5 class="alert alert-danger text-center">Only jpg, png, jpeg and webp are allowed.</h5>';
                  }

            } else {
                  $msg = '<h5 class="alert alert-warning text-center">Please select at least one image to upload.</h5>';
            }

      } catch (\Throwable $th) {
            $msg = '<h5 class="alert alert-danger text-center">Something went wrong, check functions file line number ' . __LINE__ . '.</h5>';
      }

      echo $msg;
}


function checkPlaceTypeExist($type, $table)
{
      global $db;
      $checkTypeExist = $db->query("SELECT `types` FROM `$table` WHERE `types`='$type'");
      if (mysqli_num_rows($checkTypeExist) > 0) {
            return true;
      } else {
            return false;
      }
}

function checkCommentExist($tourist_id, $place_id)
{
      global $db;
      $checkCommentExist = $db->query("SELECT * FROM `comments` WHERE `tourist_id`='$tourist_id' AND `place_id`='$place_id'");
      if (mysqli_num_rows($checkCommentExist) > 0) {
            return true;
      } else {
            return false;
      }
}

function checkEmail($email, $id)
{
      global $db;
      $checkEmailExist = $db->query("SELECT * FROM `users` WHERE `email`='$email' AND `id`!='$id'");
      if (mysqli_num_rows($checkEmailExist) > 0) {
            return true;
      } else {
            return false;
      }
}
function checkUsername($username, $id)
{
      global $db;
      $checkUsernameExist = $db->query("SELECT * FROM `users` WHERE `username`='$username' AND `id`!='$id'");
      if (mysqli_num_rows($checkUsernameExist) > 0) {
            return true;
      } else {
            return false;
      }
}

function checkValueExists($column, $value, $id)
{
      global $db;
      $stmt = $db->prepare("SELECT COUNT(*) FROM `users` WHERE `$column` = ? AND `id` != ?");
      $stmt->bind_param("si", $value, $id);
      $stmt->execute();
      $stmt->bind_result($count);
      $stmt->fetch();
      $stmt->close();

      return $count > 0;
}

function editProfile($POST, $userid)
{
      global $db;
      $id = $userid;
      $username = $POST['username'];
      $email = $POST['email'];
      $pwd = $POST['password'];
      $old_pwd = $POST['old_password'];
      $new_pwd = '';
      $msg = '';

      $checkEmail = checkValueExists('email', $email, $id);

      if ($checkEmail) {
            $msg = '<h6 class="alert alert-danger text-center">Email already used.</h6>';
      }
      if (!$checkEmail) {

            if ($pwd == '') {
                  $new_pwd = $old_pwd;
            } else {
                  $new_pwd = md5($pwd);
            }

            $updUser = $db->query("UPDATE `users` SET `username`='$username', `email`='$email', `password`='$new_pwd' WHERE `id`='$id'");
            if ($updUser) {
                  $msg = '<h6 class="alert alert-success text-center">Updated Successfully.</h6>
                  <script>
                        setTimeout(function(){
                              window.location.href = "./edit_profile.php";
                        },1500);
                  </script>
                  ';
            }
      }

      echo $msg;
}

function forgetPassword($email)
{
      global $db;
      $msg = '';
      $checkQ = $db->query("SELECT * FROM `users` WHERE `email`='$email'");
      if (mysqli_num_rows($checkQ) > 0) {
            $bytes = bin2hex(random_bytes(4));
            $newPwdMD5 = md5($bytes);
            $db->query("UPDATE `users` SET `password`='$newPwdMD5' WHERE `email`='$email'");
            $msg = '<h6 class="text-center alert alert-success">Your New Password is: <span class="d-block">' . $bytes . '<span></h6>
        <script>
            setTimeout(function(){
                window.location.href = "./login.php";
            },10000);
        </script>
        ';
      } else {
            $msg = '<h6 class="text-center alert alert-danger">Invalid Credentials.</h6>';
      }
      return $msg;
}