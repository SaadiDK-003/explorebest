<?php
session_start();
function env($value)
{
      $env = dirname(__DIR__, 1) . '/.env';
      $core = parse_ini_file($env);
      return $core[$value];
}
$db = mysqli_connect(env("HOST"), env("USER"), env("PWD"), env("DB"));
error_reporting((int) env("ERROR_REPORT"));
$tailwind = env("TAILWIND");
$alpineJs = env("ALPINE_JS");

$userName = '';
$userEmail = '';
$userPwd = '';
$userRole = '';
$userStatus = '';

if (isset($_SESSION['user'])) {
      $userid = $_SESSION['user'];
      $user_Q = $db->query("SELECT * FROM `users` WHERE `id`='$userid'");
      $user = $user_Q->fetch_object();
      $userName = $user->username;
      $userEmail = $user->email;
      $userPwd = $user->password;
      $userRole = $user->role;
      $userStatus = $user->status;
}

require_once 'functions.php';


