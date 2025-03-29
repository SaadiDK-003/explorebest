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
      $pwd = $POST['password'];

      if (checkEmailExists($email)) {
            $msg = '<h5 class="text-center alert alert-danger">Email already exists.</h5>';
      } else if (strlen($pwd) < 6) {
            $msg = '<h5 class="text-center alert alert-danger">Password must be greater than 6 characters.</h5>';
      } else {
            $pwd = md5($pwd);
            $db->query("INSERT INTO `users` (username,email,password) VALUES('$username','$email','$pwd')");
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

function addPlace($POST, $FILE, $userid)
{
      global $db;
      $targetDir = './img/place/';
      $keys = '';
      $values = '';
      $msg = '';

      try {

            if (!empty($FILE["place_image"]["name"])) {

                  $fileName = basename($FILE["place_image"]["name"]);
                  $targetFilePath = $targetDir . $fileName;
                  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                  $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
                  if (in_array($fileType, $allowTypes)) {
                        if (move_uploaded_file($FILE["place_image"]["tmp_name"], $targetFilePath)) {
                              foreach ($POST as $key => $value) {
                                    $keys .= $key . ',';
                                    $values .= "'" . $value . "',";
                              }

                              // $keys = substr($keys, 0, -1);
                              // $values = substr($values, 0, -1);
                              $keys .= 'place_img,u_id';
                              $values .= "'" . $targetFilePath . "','" . $userid . "'";

                              $placesQ = $db->query("INSERT INTO `places` ($keys) VALUES($values)");
                              if ($placesQ) {
                                    $msg = '<h5 class="alert alert-success text-center">Place Added Successfully.</h5>';
                              }
                        } else {
                              $msg = '<h5 class="alert alert-danger text-center">Something wrong while uploading file.</h5>';
                        }
                  } else {
                        $msg = '<h5 class="alert alert-danger text-center">Only jpg, png, jpeg and webp are allowed.</h5>';
                  }
            }

      } catch (\Throwable $th) {
            $msg = '<h5 class="alert alert-danger text-center">Something went wrong, check functions file line number 115.</h5>';
      }

      echo $msg;
}

function addAccommodation($POST, $FILE, $userid)
{
      global $db;
      $targetDir = './img/accommodation/';
      $keys = '';
      $values = '';
      $msg = '';

      try {

            if (!empty($FILE["acc_image"]["name"])) {

                  $fileName = basename($FILE["acc_image"]["name"]);
                  $targetFilePath = $targetDir . $fileName;
                  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                  $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
                  if (in_array($fileType, $allowTypes)) {
                        if (move_uploaded_file($FILE["acc_image"]["tmp_name"], $targetFilePath)) {
                              foreach ($POST as $key => $value) {
                                    $keys .= $key . ',';
                                    $values .= "'" . $value . "',";
                              }

                              $keys .= 'accommodation_image,u_id';
                              $values .= "'" . $targetFilePath . "','" . $userid . "'";

                              $placesQ = $db->query("INSERT INTO `accommodation` ($keys) VALUES($values)");
                              if ($placesQ) {
                                    $msg = '<h5 class="alert alert-success text-center">Place Added Successfully.</h5>';
                              }
                        } else {
                              $msg = '<h5 class="alert alert-danger text-center">Something wrong while uploading file.</h5>';
                        }
                  } else {
                        $msg = '<h5 class="alert alert-danger text-center">Only jpg, png, jpeg and webp are allowed.</h5>';
                  }
            }

      } catch (\Throwable $th) {
            $msg = '<h5 class="alert alert-danger text-center">Something went wrong, check functions file line number 163.</h5>';
      }

      echo $msg;
}

function addEvent($POST, $FILE, $userid)
{
      global $db;
      $targetDir = './img/event_/';
      $keys = '';
      $values = '';
      $msg = '';

      try {

            if (!empty($FILE["event_image"]["name"])) {

                  $fileName = basename($FILE["event_image"]["name"]);
                  $targetFilePath = $targetDir . $fileName;
                  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                  $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
                  if (in_array($fileType, $allowTypes)) {
                        if (move_uploaded_file($FILE["event_image"]["tmp_name"], $targetFilePath)) {
                              foreach ($POST as $key => $value) {
                                    $keys .= $key . ',';
                                    $values .= "'" . $value . "',";
                              }

                              $keys .= 'event_img,u_id';
                              $values .= "'" . $targetFilePath . "','" . $userid . "'";

                              $placesQ = $db->query("INSERT INTO `events` ($keys) VALUES($values)");
                              if ($placesQ) {
                                    $msg = '<h5 class="alert alert-success text-center">Event Added Successfully.</h5>';
                              }
                        } else {
                              $msg = '<h5 class="alert alert-danger text-center">Something wrong while uploading file.</h5>';
                        }
                  } else {
                        $msg = '<h5 class="alert alert-danger text-center">Only jpg, png, jpeg and webp are allowed.</h5>';
                  }
            }

      } catch (\Throwable $th) {
            $msg = '<h5 class="alert alert-danger text-center">Something went wrong, check functions file line number 209.</h5>';
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