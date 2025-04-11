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
                                                <a href="#useful-apps" class="btn bg-primary-custom text-white">Useful
                                                      Applications</a>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-12 col-md-6">
                                    <div class="bg-img" data-title="<?= env("TITLE") ?>">
                                          <img src="./img/bg_2.jpeg" alt="explore_bg">
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
            <?php include_once 'home_sections.php'; ?>
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


                  // Add to Favorite Places
                  $(document).on("click", ".btn-add-fav-place", function (e) {
                        e.preventDefault();
                        let place_id = $(this).data("placeid");

                        $.ajax({
                              url: "ajax/add_fav.php",
                              method: "post",
                              data: {
                                    fav_place_id: place_id
                              },
                              success: function (response) {
                                    let res = JSON.parse(response);
                                    if (res.status == 'success') {
                                          $("#ToastSuccess").addClass("fade show");
                                          $("#ToastSuccess .toast-body").html(res.msg);
                                          setTimeout(() => {
                                                window.location.reload();
                                          }, 1500);
                                    } else {
                                          $("#ToastDanger").addClass("fade show");
                                          $("#ToastDanger .toast-body").html(res.msg);
                                          setTimeout(() => {
                                                $("#ToastDanger .toast-body").html('');
                                                $("#ToastDanger").removeClass("fade show");
                                          }, 1500);
                                    }
                              }
                        })
                  });

                  // Add to Favorite Accommodation
                  $(document).on("click", ".btn-add-fav-acc", function (e) {
                        e.preventDefault();
                        let acc_id = $(this).data("acc");

                        $.ajax({
                              url: "ajax/add_fav.php",
                              method: "post",
                              data: {
                                    fav_acc_id: acc_id
                              },
                              success: function (response) {
                                    let res = JSON.parse(response);
                                    if (res.status == 'success') {
                                          $("#ToastSuccess").addClass("fade show");
                                          $("#ToastSuccess .toast-body").html(res.msg);
                                          setTimeout(() => {
                                                window.location.reload();
                                          }, 1500);
                                    } else {
                                          $("#ToastDanger").addClass("fade show");
                                          $("#ToastDanger .toast-body").html(res.msg);
                                          setTimeout(() => {
                                                $("#ToastDanger .toast-body").html('');
                                                $("#ToastDanger").removeClass("fade show");
                                          }, 1500);
                                    }
                              }
                        })
                  });

                  // Add to Favorite Events
                  $(document).on("click", ".btn-add-fav-event", function (e) {
                        e.preventDefault();
                        let event_id = $(this).data("event");

                        $.ajax({
                              url: "ajax/add_fav.php",
                              method: "post",
                              data: {
                                    fav_event_id: event_id
                              },
                              success: function (response) {
                                    let res = JSON.parse(response);
                                    if (res.status == 'success') {
                                          $("#ToastSuccess").addClass("fade show");
                                          $("#ToastSuccess .toast-body").html(res.msg);
                                          setTimeout(() => {
                                                window.location.reload();
                                          }, 1500);
                                    } else {
                                          $("#ToastDanger").addClass("fade show");
                                          $("#ToastDanger .toast-body").html(res.msg);
                                          setTimeout(() => {
                                                $("#ToastDanger .toast-body").html('');
                                                $("#ToastDanger").removeClass("fade show");
                                          }, 1500);
                                    }
                              }
                        })
                  });

            });
      </script>
</body>

</html>