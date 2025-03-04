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
      <main>
            <section class="hero d-flex align-items-center justify-content-center p-4">
                  <div class="container">
                        <div class="row">
                              <div class="col-12 col-md-6 d-flex align-items-center">
                                    <div class="content text-white">
                                          <h1>Explore Best</h1>
                                          <p>
                                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vitae dolores
                                                blanditiis exercitationem possimus iure consectetur non. Sunt nulla
                                                repellendus velit, aut ex saepe, optio tempora eaque magnam pariatur
                                                amet sit.
                                          </p>
                                          <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, harum!
                                                Qui dolore esse provident harum minus adipisci facilis hic in.
                                          </p>
                                          <div class="btn-wrapper">
                                                <a href="#!" class="btn btn-primary">Explore More</a>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-12 col-md-6">
                                    <div class="bg-img" data-title="<?= env("TITLE") ?>">
                                          <img src="./img/explore_bg.webp" alt="explore_bg">
                                    </div>
                              </div>
                        </div>
                  </div>
            </section>
      </main>
      <?php include_once 'includes/footer.php'; ?>
      <?php include_once 'includes/external_js.php'; ?>
      <script>
            $(document).ready(function () {

            });
      </script>
</body>

</html>