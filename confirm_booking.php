<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_res['site_title'] ?> | CONFORM BOOKING</title>
    <style>
        .text-justify {
            text-align: justify;
        }
    </style>
</head>

<body class="bg-light">

    <?php require('include/header.php'); ?>

    <?php

        /* 
            check room id from url is present or not
            shutdown mode is active or not
            user is logged in or not
        */
        if (!isset($_GET['id']) || $settings_res['shutdown']==true) {
            redirect('rooms.php');
        }
        else if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
            redirect('rooms.php');
        }

        //filter and get room ans user data
        $data = filtration($_GET);
        $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');
        if (mysqli_num_rows($room_res) == 0) {
            redirect('rooms.php');
        }
        $room_data = mysqli_fetch_assoc($room_res);

        $_SESSION['room'] = [
                                "id" => $room_data['id'], 
                                "name" => $room_data['name'], 
                                "price" => $room_data['price'], 
                                "payment" => null, 
                                "available" => false, 
                            ];
        
        $user_res = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1",[$_SESSION['uId']],'i');
        $user_data = mysqli_fetch_assoc($user_res);
    ?>

    <!-- main content -->
    <div class="container">
        <div class="row">

            <!-- title -->
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">CONFIRM BOOKING</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">CONFIRM</a>
                    <span class="text-secondary"> > </span>
                </div>
            </div>

            <!-- Room details with thumb image -->
            <div class="col-lg-7 col-md-12 mb-4 px-4">
                <?php 
                    // get thumbnail image of room
                    $room_thumb = ROOM_IMG_UPLOAD_PATH."thumbnail.jpg";
                    $thumb_q = mysqli_query($con,"SELECT * FROM `room_image` WHERE `room_id`='$room_data[id]' AND `thumb`=1");

                    if(mysqli_num_rows($thumb_q) > 0){
                        $thumb_res = mysqli_fetch_assoc($thumb_q);
                        $room_thumb = ROOM_IMG_UPLOAD_PATH.$thumb_res['image'];
                    }

                    echo<<<data
                        <div class="card p-3 shadow-sm rounded">
                            <img src="$room_thumb" class="img-fluid rounded mb-3">
                            <h3 class="mb-3">$room_data[name]</h3>
                            <h5 class="rounded mb-3">₹$room_data[price] per night</h5>
                            <h5 class="mb-3 text-justify">$room_data[description] per night</h5>
                        </div>
                    data;
                ?>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">

                        <!-- Booking Details form -->
                        <form action="pay_now.php" method="POST" id="booking_form">
                            <h5 class="mb-3">BOOKING DETAILS</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input name="name" type="text" value="<?php echo $user_data['name'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input name="phonenum" type="number" value="<?php echo $user_data['phonenum'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Email</label>
                                    <input name="email" type="text" value="<?php echo $user_data['email'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $user_data['address'] ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-in</label>
                                    <input name="checkin" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Check-out</label>
                                    <input name="checkout" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                                </div>
                                <div class="col-12">
                                    <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <h6 class="mb-3 text-danger" id="pay_info">
                                        Provide check-in & check-out date !
                                    </h6>
                                    <button name="pay_now" class="btn w-100 text-white custom-bg shadow-none mb-1" disabled>
                                        Pay Now
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="script/confirm_booking.js"></script> 
    <?php require('include/footer.php'); ?>
    
</body>

</html>