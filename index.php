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
            <div class="container my-3">
                  <div class="row">
                        <div class="col-12 text-center">
                              <h1>Places To Visit in Saudia Arabia</h1>
                              <p>We welcome you to visit our country and see the Word Most Beautiful Places
                                    <strong>Makkah</strong> & <strong>Madina</strong>
                              </p>
                        </div>
                  </div>
            </div>
            <!-- Places -->
            <section class="places">
                  <div class="container">
                        <div class="row">
                              <div class="col-12">
                                    <h1 class="bg-primary-custom text-white rounded ps-2 mb-3">Places</h1>
                              </div>
                              <?php
                              $places_Q = $db->query("CALL `get_places`()");
                              if (mysqli_num_rows($places_Q) > 0) {
                                    while ($place_ = $places_Q->fetch_object()):
                                          ?>
                                          <div class="col-12 col-md-3 mb-3">
                                                <div class="content bg-white p-2 rounded">
                                                      <div class="img">
                                                            <img src="<?= $place_->place_img ?>" alt="restaurant">
                                                      </div>
                                                      <hr>
                                                      <div class="info d-flex align-items-center justify-content-between">
                                                            <h3><?= $place_->city_name ?></h3>
                                                            <h5 class="btn btn-sm btn-secondary"><?= $place_->type ?></h5>
                                                      </div>
                                                      <p>
                                                            <?= $place_->description ?>
                                                      </p>
                                                      <a href="<?= $place_->location ?>" target="_blank"
                                                            class="btn btn-primary w-100">Location</a>
                                                </div>
                                          </div>
                                    <?php endwhile;
                              } else { ?>
                                    <div class="col-12">
                                          <h1 class="text-center alert alert-info">No Record Found</h1>
                                    </div>
                              <?php }
                              $places_Q->close();
                              $db->next_result(); ?>
                        </div>
                  </div>
            </section>
            <!-- Accommodations -->
            <section class="accommodations">
                  <div class="container">
                        <div class="row">
                              <div class="col-12">
                                    <h1 class="bg-primary-custom text-white rounded ps-2 mb-3">Accommodations</h1>
                              </div>
                              <?php
                              $acc_Q = $db->query("CALL `get_acc`()");
                              if (mysqli_num_rows($acc_Q) > 0) {
                                    while ($acc_ = $acc_Q->fetch_object()):
                                          $services = explode(",", $acc_->services);
                                          ?>
                                          <div class="col-12 col-md-3 mb-3">
                                                <div class="content bg-white p-2 rounded">
                                                      <div class="img">
                                                            <img src="<?= $acc_->acc_img ?>" alt="restaurant">
                                                      </div>
                                                      <hr>
                                                      <div class="info d-flex align-items-center justify-content-between">
                                                            <h3><?= $acc_->city_name ?></h3>
                                                            <h5 class="btn btn-sm btn-secondary"><?= $acc_->type ?></h5>
                                                      </div>
                                                      <ul>
                                                            <?php foreach ($services as $service) {
                                                                  echo '<li>' . $service . '</li>';
                                                            } ?>
                                                      </ul>
                                                      <a href="<?= $acc_->location ?>" target="_blank"
                                                            class="btn btn-primary w-100">Location</a>
                                                </div>
                                          </div>
                                    <?php endwhile;
                              } else { ?>
                                    <div class="col-12">
                                          <h1 class="text-center alert alert-info">No Record Found</h1>
                                    </div>
                              <?php }
                              $acc_Q->close();
                              $db->next_result(); ?>
                        </div>
                  </div>
            </section>
            <!-- Events -->
            <section class="events">
                  <div class="container">
                        <div class="row">
                              <div class="col-12">
                                    <h1 class="bg-primary-custom text-white rounded ps-2 mb-3">Events</h1>
                              </div>
                              <?php
                              $event_Q = $db->query("CALL `get_events`()");
                              if (mysqli_num_rows($event_Q) > 0) {
                                    while ($event_ = $event_Q->fetch_object()):
                                          ?>
                                          <div class="col-12 col-md-3 mb-3">
                                                <div class="content bg-white p-2 rounded">
                                                      <div class="img">
                                                            <img src="<?= $event_->event_img ?>" alt="restaurant">
                                                      </div>
                                                      <hr>
                                                      <div class="info d-flex align-items-center justify-content-between">
                                                            <h3><?= $event_->event_name ?></h3>
                                                            <h5 class="btn btn-sm btn-secondary"><?= $event_->city_name ?></h5>
                                                      </div>

                                                      <a href="<?= $event_->booking_link ?>" target="_blank"
                                                            class="btn btn-primary w-100">Booking Link</a>
                                                </div>
                                          </div>
                                    <?php endwhile;
                              } else { ?>
                                    <div class="col-12">
                                          <h1 class="text-center alert alert-info">No Record Found</h1>
                                    </div>
                              <?php }
                              $event_Q->close();
                              $db->next_result(); ?>
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