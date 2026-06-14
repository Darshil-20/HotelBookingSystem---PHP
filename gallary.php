<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_res['site_title'] ?> | GALLERY</title>
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
        <p class="text-center mt-3">
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
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est animi harum doloremque.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est animi harum doloremque.
                </p>
            </div>

            <!-- about image -->
            <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="images/HotelRoomGallery/3.jpg" class="w-100"></div>
                        <div class="swiper-slide"><img src="images/HotelRoomGallery/4.jpg" class="w-100"></div>
                        <div class="swiper-slide"><img src="images/HotelRoomGallery/5.jpg" class="w-100"></div>
                        <div class="swiper-slide"><img src="images/HotelRoomGallery/6.jpg" class="w-100"></div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
                
            </div>

        </div>
    </div>


    <?php require('include/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper1", {
            spaceBetween: 40,
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

        var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        keyboard: {
            enabled: true,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        });
    </script>


</body>

</html>