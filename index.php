<?php
require_once 'core/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?= env("TITLE") ?> | Home</title>
      <?php include_once 'includes/external_css.php'; ?>
</head>

<body id="home">
      <?php include_once 'includes/header.php'; ?>
      <main></main>
      <?php include_once 'includes/footer.php'; ?>
      <?php include_once 'includes/external_js.php'; ?>
      <script>
            $(document).ready(function() {});
      </script>
</body>

</html>