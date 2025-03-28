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
                                                <div class="content position-relative bg-white p-2 rounded">
                                                      <div class="img">
                                                            <a href="./viewComments.php?place_id=<?= $place_->place_id ?>"
                                                                  class="btn btn-sm btn-primary btn-view-rating position-absolute">
                                                                  <span>View Comments</span>
                                                            </a>
                                                            <img src="<?= $place_->place_img ?>" alt="restaurant">
                                                      </div>
                                                      <hr>
                                                      <a href="#!" data-id="<?= $place_->place_id ?>"
                                                            class="btn btn-sm btn-success btn-rating position-absolute"
                                                            data-bs-toggle="modal" data-bs-target="#addComment">
                                                            <span>Give Comments</span>
                                                      </a>
                                                      <div class="info d-flex align-items-center justify-content-between mt-5">
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
                                                      <p>
                                                            <strong>Event Date: </strong>
                                                            <?= date('d-M-Y', strtotime($event_->date)) ?>
                                                      </p>
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

      <!-- Modal Image -->
      <div class="modal fade" id="addComment" tabindex="-1" aria-labelledby="addCommentLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                        <form id="addCommentForm">
                              <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addCommentLabel">Add Rating & Comment</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                          aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                    <div class="row">
                                          <div class="col-12 mb-3">
                                                <div class="form-group">
                                                      <label for="">Rating</label>
                                                      <div class="checkbox-group d-flex gap-2 align-items-center">
                                                            <!-- one -->
                                                            <div class="form-check">
                                                                  <input class="form-check-input d-none" name="stars[]"
                                                                        type="checkbox" id="one" value="1" />
                                                                  <label class="form-check-label" for="one">
                                                                        <i class="fas fa-star"></i>
                                                                  </label>
                                                            </div>
                                                            <!-- two -->
                                                            <div class="form-check">
                                                                  <input class="form-check-input d-none" name="stars[]"
                                                                        type="checkbox" id="two" value="2" />
                                                                  <label class="form-check-label" for="two">
                                                                        <i class="fas fa-star"></i>
                                                                  </label>
                                                            </div>
                                                            <!-- three -->
                                                            <div class="form-check">
                                                                  <input class="form-check-input d-none" name="stars[]"
                                                                        type="checkbox" id="three" value="3" />
                                                                  <label class="form-check-label" for="three">
                                                                        <i class="fas fa-star"></i>
                                                                  </label>
                                                            </div>
                                                            <!-- four -->
                                                            <div class="form-check">
                                                                  <input class="form-check-input d-none" name="stars[]"
                                                                        type="checkbox" id="four" value="4" />
                                                                  <label class="form-check-label" for="four">
                                                                        <i class="fas fa-star"></i>
                                                                  </label>
                                                            </div>
                                                            <!-- five -->
                                                            <div class="form-check">
                                                                  <input class="form-check-input d-none" name="stars[]"
                                                                        type="checkbox" id="five" value="5" />
                                                                  <label class="form-check-label" for="five">
                                                                        <i class="fas fa-star"></i>
                                                                  </label>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-12 mb-3">
                                                <div class="form-group">
                                                      <label for="comments">Comments</label>
                                                      <textarea rows="5" name="comments" id="comments"
                                                            class="form-control" required></textarea>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <div class="modal-footer">
                                    <input type="hidden" name="checked_count" id="checked-count" value="">
                                    <input type="hidden" id="place_id" name="place_id">
                                    <input type="hidden" id="tourist_id" name="tourist_id" value="<?= $userid ?>">
                                    <button type="button" class="btn btn-secondary"
                                          data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                              </div>
                        </form>
                  </div>
            </div>
      </div>
      <?php include_once 'includes/footer.php'; ?>
      <?php include_once 'includes/external_js.php'; ?>
      <script>
            $(document).ready(function () {
                  $(document).on("click", ".btn-rating", function (e) {
                        e.preventDefault();
                        let id = $(this).data("id");
                        $("#place_id").val(id);
                  });

                  $(document).on("submit", "#addCommentForm", function (e) {
                        e.preventDefault();
                        let formData = $(this).serialize();
                        $.ajax({
                              url: "ajax/rating_comments.php",
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
                                          $("#ToastWarning").addClass("fade show");
                                          $("#ToastWarning .toast-body").html(res.msg);
                                    }
                              }
                        });
                  });

                  $('.form-check-input').change(function () {
                        var value = parseInt($(this).val());
                        var isChecked = $(this).prop('checked');
                        // Check or uncheck all stars up to the clicked star
                        $('.form-check-input').each(function () {
                              var currentVal = parseInt($(this).val());

                              if (currentVal <= value && isChecked) {
                                    $(this).prop('checked', true);
                              } else if (currentVal >= value) {
                                    $(`input[value="${value}"]`).prop('checked', true);
                                    $(this).prop('checked', false);
                              }
                        });

                        updateCheckedCount();
                  });

                  $('.form-check-label').hover(function () {
                        var value = parseInt($(this).prev().val());

                        $('.form-check-label i').each(function (index) {
                              if (index < value) {
                                    $(this).css('color', 'gold');
                              } else {
                                    $(this).css('color', '#acacac');
                              }
                        });
                  }, function () {
                        $('.form-check-input:checked ~ .form-check-label i').css('color', 'gold');
                        $('.form-check-input:not(:checked) ~ .form-check-label i').css('color', '#acacac');
                  });

                  function updateCheckedCount() {
                        var checkedCount = $('.form-check-input:checked').length;
                        $('#checked-count').val(checkedCount);
                  }

                  // Initial update
                  updateCheckedCount();
            });
      </script>
</body>

</html>