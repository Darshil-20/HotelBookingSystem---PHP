<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_res['site_title'] ?> | BOOKING STATUS</title>
</head>

<body class="bg-light">

    <?php require('include/header.php'); ?>

    <!-- main content -->
    <div class="container">
        <div class="row">

            <!-- title -->
            <div class="col-12 my-5 mb-3 px-4">
                <h2 class="fw-bold">PAYMENT STATUS</h2>
            </div>

            <?php 
                $frm_data = filtration($_GET);

                if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
                    redirect('index.php');
                }

                // $booking_q = "SELECT bo.*,bd.* FROM `booking_order` bo
                //                 INNER JOIN  `booking_details` bd
                //                 ON bo.booking_id=bd.booking_id 
                //                 WHERE bo.receipt_id=? AND bo.user_id=? AND bo.booking_status!=? ";

                $booking_q = "SELECT bo.*,bd.* FROM `booking_order` bo
                                INNER JOIN  `booking_details` bd
                                ON bo.booking_id=bd.booking_id 
                                WHERE bo.user_id=? AND bo.booking_status!=? ";

                $booking_vals = [$_SESSION['uId'],'pending'];
                $booking_res = select($booking_q,$booking_vals,'is');

                if(mysqli_num_rows($booking_res)==0){
                    redirect('index.php');
                }

                $booking_fetch = mysqli_fetch_assoc($booking_res);

                if($booking_fetch['trans_status']=="TXN_SUCCESS")
                {
                    echo<<<data
                        <div class="col-12 px-4">
                            <p class="fw-bold alert alert-success">
                                <i class="bi bi-check-circle-fill"></i>
                                Payment Done !! Booking  Successful.
                                <br><br>
                                <a href='bookings.php'>GO TO BOOKINGS</a> 
                            </p>
                        </div>
                    data;
                }
                else
                {
                    echo<<<data
                        <div class="col-12 px-4">
                            <p class="fw-bold alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                 Payment failed !!<br>
                                 $booking_fetch[booking_status]
                                <br><br>
                                <a href='bookings.php'>GO TO BOOKINGS</a> 
                            </p>
                        </div>
                    data;
                }
            ?>

        </div>
    </div>


    <?php require('include/footer.php'); ?>
</body>

</html>