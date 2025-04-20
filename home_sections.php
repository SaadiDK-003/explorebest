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
                    $images = explode(',', $place_->place_img);
                    $imagesCount = count($images);
                    ?>
                    <div class="col-12 col-md-3 mb-3">
                        <div class="content position-relative bg-white p-2 rounded">
                            <div class="img">
                                <a href="./viewComments.php?place_id=<?= $place_->place_id ?>"
                                    class="btn btn-sm btn-primary btn-view-rating position-absolute">
                                    <span>View Comments</span>
                                </a>
                                <a href="#!" data-placeid="<?= $place_->place_id ?>"
                                    class="btn btn-sm btn-danger btn-add-fav btn-add-fav-place position-absolute">
                                    <i class="fas fa-heart"></i>
                                </a>
                                <?php if ($imagesCount == 1): ?>
                                    <img src="<?= $place_->place_img ?>" loading="lazy" alt="restaurant">
                                <?php else: ?>
                                    <div class="img-wrapper owl-carousel">
                                        <?php foreach ($images as $image): ?>
                                            <img src="<?= $image ?>" loading="lazy" alt="restaurant">
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <hr>
                            <a href="#!" data-id="<?= $place_->place_id ?>"
                                class="btn btn-sm btn-success btn-rating position-absolute" data-bs-toggle="modal"
                                data-bs-target="#addComment">
                                <span>Give Comments</span>
                            </a>
                            <div class="info d-flex align-items-center justify-content-between mt-5">
                                <h3><?= $place_->city_name ?></h3>
                                <h5 class="btn btn-sm btn-secondary"><?= $place_->type ?></h5>
                            </div>
                            <p>
                                <?= $place_->description ?>
                            </p>
                            <div class="d-flex gap-2">
                                <a href="<?= $place_->location ?>" target="_blank"
                                    class="btn btn-primary w-75 flex-grow-1">Location</a>
                                <a href="tel:<?= $place_->phone ?>" class="btn btn-secondary"><i class="fas fa-phone"></i></a>
                            </div>
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
                    $images = explode(',', $acc_->acc_img);
                    $imagesCount = count($images);
                    ?>
                    <div class="col-12 col-md-3 mb-3">
                        <div class="content bg-white p-2 rounded">
                            <div class="img position-relative">
                                <a href="#!" data-acc="<?= $acc_->acc_id ?>"
                                    class="btn btn-sm btn-danger btn-add-fav btn-add-fav-acc position-absolute">
                                    <i class="fas fa-heart"></i>
                                </a>
                                <?php if ($imagesCount == 1): ?>
                                    <img src="<?= $acc_->acc_img ?>" loading="lazy" alt="restaurant">
                                <?php else: ?>
                                    <div class="img-wrapper owl-carousel">
                                        <?php foreach ($images as $image): ?>
                                            <img src="<?= $image ?>" loading="lazy" alt="restaurant">
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
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
                            <div class="d-flex gap-2">
                                <a href="<?= $acc_->location ?>" target="_blank"
                                    class="btn btn-primary w-75 flex-grow-1">Location</a>
                                <a href="tel:<?= $acc_->phone ?>" class="btn btn-secondary"><i class="fas fa-phone"></i></a>
                            </div>
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
                    $images = explode(',', $event_->event_img);
                    $imagesCount = count($images);
                    ?>
                    <div class="col-12 col-md-3 mb-3">
                        <div class="content bg-white p-2 rounded">
                            <div class="img position-relative">
                                <a href="#!" data-event="<?= $event_->event_id ?>"
                                    class="btn btn-sm btn-danger btn-add-fav btn-add-fav-event position-absolute">
                                    <i class="fas fa-heart"></i>
                                </a>
                                <?php if ($imagesCount == 1): ?>
                                    <img src="<?= $event_->event_img ?>" loading="lazy" alt="restaurant">
                                <?php else: ?>
                                    <div class="img-wrapper owl-carousel">
                                        <?php foreach ($images as $image): ?>
                                            <img src="<?= $image ?>" loading="lazy" alt="restaurant">
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
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
                            <div class="d-flex gap-2">
                                <a href="<?= $event_->booking_link ?>" target="_blank"
                                    class="btn btn-primary w-75 flex-grow-1">Booking
                                    Link</a>
                                <a href="tel:<?= $event_->phone ?>" class="btn btn-secondary"><i class="fas fa-phone"></i></a>
                            </div>
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

<!-- Useful Applications -->
<section id="useful-apps" class="useful_apps">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h2 class="bg-primary-custom text-white rounded p-2">Useful Applications</h2>
            </div>
            <?php $app_Q = $db->query("CALL `get_apps`()");
            if (mysqli_num_rows($app_Q) > 0):
                while ($app = mysqli_fetch_object($app_Q)):
                    ?>
                    <div class="col-12 col-md-3 mb-3">
                        <div class="content p-2 border rounded shadow">
                            <div class="img">
                                <img src="<?= $app->image ?>" height="200" width="300" class="rounded" loading="lazy"
                                    alt="app-<?= $app->app_id ?>">
                            </div>
                            <hr>
                            <h5><?= $app->title ?></h5>
                            <a href="<?= $app->link ?>" class="btn btn-primary btn-sm w-100">Application Link</a>
                        </div>
                    </div>
                <?php endwhile; else: ?>
                <h1 class="text-center alert alert-info">No Application Found.</h1>
            <?php endif;
            $app_Q->close();
            $db->next_result(); ?>
        </div>
    </div>
</section>