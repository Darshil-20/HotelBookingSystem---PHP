<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_res['site_title'] ?> | ABOUT</title>
    <style>
        .box {
            border-top-color: var(--teal) !important;
        }
    </style>
</head>

<body class="bg-light">

    <?php require('include/header.php'); ?>

    <!-- title -->
    <div class="my-5">
        <h2 class="fw-bold h-font text-center">ABOUT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3" style="text-align: justify;">
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Distinctio aspernatur error<br> ratione omnis nesciunt, corrupti numquam accusamus.
            Distinctio, commodi unde.
        </p>
    </div>

    <!-- Middle Area  section -->
    <div class="container">
        <div class="row justify-content-between align-items-center">

            <!-- about content -->
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">
                    Lorem ipsum dolor sit amet.
                </h3>
                <p style="text-align: justify;">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est animi harum doloremque.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est animi harum doloremque.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est animi harum doloremque.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est animi harum doloremque.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est animi harum doloremque.
                </p>
            </div>

            <!-- about image -->
            <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                <div class="swiper mySwiper1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="images/HotelRoomGallery/3.jpg" class="w-100"></div>
                        <div class="swiper-slide"><img src="images/HotelRoomGallery/4.jpg" class="w-100"></div>
                        <div class="swiper-slide"><img src="images/HotelRoomGallery/5.jpg" class="w-100"></div>
                        <div class="swiper-slide"><img src="images/HotelRoomGallery/6.jpg" class="w-100"></div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Testimonials -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Testimonials</h2>
    <div class="container">
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper mb-5">
                <?php

                $review_q = "SELECT rr.*,uc.name AS uname, uc.profile, r.name AS rname FROM `rating_review` rr 
                                INNER JOIN `user_cred` uc ON rr.user_id = uc.id 
                                INNER JOIN `rooms` r ON rr.room_id = r.id 
                                ORDER BY `sr_no` ASC LIMIT 6";
                $review_res = mysqli_query($con, $review_q);
                $img_path = USERS_IMG_UPLOAD_PATH;

                if (mysqli_num_rows($review_res) == 0) {
                    echo 'No reviews yet !!';
                } else {
                    while ($row = mysqli_fetch_assoc($review_res)) {
                        $stars = "<i class='bi bi-star-fill text-warning me-2'></i>";
                        for ($i = 0; $i < $row['rating']; $i++) {
                            $stars .= "<i class='bi bi-star-fill text-warning me-2'></i>";
                        }

                        echo <<<slides
                                <div class="swiper-slide bg-white p-4">
                                    <div class="profile d-flex align-items-center mb-3">
                                        <img src="$img_path$row[profile]" class='rounded-circle' loading="lazy" width="30px">
                                        <h6 class="m-0 ms-2">$row[uname]</h6>
                                    </div>
                                    <p>
                                        $row[review]
                                    </p>
                                    <div class="rating">
                                        $stars
                                    </div>
                                </div>
                            slides;
                    }
                }

                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Rooms images -->
    <h3 class="my-5 fw-bold h-font text-center">BIRTHDAY DECORATION ROOMS</h3>
    <div class="container px-4">
        <!-- Swiper -->
        <div class="swiper mySwiper2">
            <div class="swiper-wrapper mb-5">

                <?php
                $about_res =  selectAll('gallary_image');
                $path = GALLARY_IMG_PATH;
                while ($row = mysqli_fetch_assoc($about_res)) {
                    echo <<<data
                            <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                                <img src="$path$row[picture]" class="w-100 d-block" style="height:10%" />
                            </div>
                        data;
                }
                ?>

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Team Management -->
    <h3 class="my-5 fw-bold h-font text-center">MANAGEMENT TEAM</h3>
    <div class="container px-4">
        <!-- Swiper -->
        <div class="swiper mySwiper3">
            <div class="swiper-wrapper mb-5">

                <?php
                $about_res =  selectAll('team_details');
                $path = UPLOAD_IMG_PATH;
                while ($row = mysqli_fetch_assoc($about_res)) {
                    echo <<<data
                            <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                                <img src="$path$row[picture]" class="w-100">
                                <h5 class="mt-2">$row[name]</h5>
                            </div>
                        data;
                }
                ?>

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>


    <?php require('include/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper1", {
            slidesPerView: 1,
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 1350,
                disableOnInteraction: false,
            }
        });

        var swiper = new Swiper(".mySwiper2", {
            spaceBetween: 40,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });

        var swiper = new Swiper(".mySwiper3", {
            spaceBetween: 40,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });

        var swiper = new Swiper(".swiper-testimonials", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            slidesPerView: "3",
            loop: true,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    </script>


</body>

</html>