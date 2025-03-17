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

function addPlace($POST, $FILE)
{
      global $db;
      $targetDir = '../img/';
      $keys = '';
      $values = '';
      $msg = '';

      foreach ($POST as $key => $value) {
            $keys .= $key . ',';
            $values .= "'" . $value . "',";
      }

      $keys = substr($keys, 0, -1);
      $values = substr($values, 0, -1);

      try {
            $placesQ = $db->query("INSERT INTO `places` ($keys) VALUES($values)");
            if ($placesQ) {
                  $msg = '<h5 class="alert alert-success text-center">Place Added Successfully.</h5>';
            }
      } catch (\Throwable $th) {
            $msg = '<h5 class="alert alert-danger text-center">Something went wrong, check functions file line number 106.</h5>';
      }

      echo $msg;
}