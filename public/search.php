<?php
include_once('../database/connection.php');
require_once('../models/job.php');
?>


<div id="results">
    <section class="light">
        <h2 class="text-center py-3">Latest Job Listings</h2>
        <div class="container py-2">
            <?php
            if (isset($_GET) or isset($_POST)) {
                $searchTerm = isset($_POST['title']) ? $_POST['title'] : (isset($_POST['company']) ? $_POST['company'] : (isset($_POST['location']) ? $_POST['location'] : NULL));

                $offreQuery = new Job($conn);
                $allOffres = $offreQuery->search($searchTerm);

                foreach ($allOffres as $offre):
                    ?>


                    <article class="postcard light green">
                        <a class="postcard__img_link" href="#">
                            <?php
                            $imagePath = "../views/admin/dashboard/img/" . $offre['image_path'];
                            ?>
                            <img class="postcard__img" src="<?php echo $imagePath; ?>" alt="Image Title" />
                        </a>
                        <div class="postcard__text t-dark">
                            <h3 class="postcard__title green"><a href="#">
                                    <?php echo $offre['title']; ?>
                                </a></h3>
                            <div class="postcard__subtitle small">
                                <time datetime="2020-05-25 12:00:00">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    <?php echo $offre['company']; ?>
                                </time>
                            </div>
                            <div class="postcard__bar"></div>
                            <div class="postcard__preview-txt">
                                <?php echo $offre['description']; ?>
                            </div>
                            <ul class="postcard__tagbox">
                                <li class="tag__item"><i class="fas fa-tag mr-2"></i><?php echo $offre['location']; ?></li>
                                <li class="tag__item"><i class="fas fa-clock mr-2"></i>55 mins.</li>
                                <li class="tag__item play green">
                                    <a href="#"><i class="fas fa-play mr-2"></i>APPLY NOW</a>
                                </li>
                            </ul>
                        </div>
                    </article>
                <?php
                endforeach;
            }
            ?>
        </div>
    </section>
</div>

<script src="script.js"></script>