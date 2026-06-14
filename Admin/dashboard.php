<?php
require('include/essentials.php');
require('include/db_config.php');
adminLogin();


// session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Dashboard</title>
    <?php require('include/links.php'); ?>
</head>

<body class="bg-white">

    <!-- header file -->
    <?php
        require('include/header.php');

        $is_shutdown = mysqli_fetch_assoc(mysqli_query($con, "SELECT `shutdown` FROM `settings`"));

        //current bookings query and result
        $current_bookings_q = "SELECT 
                            COUNT(CASE WHEN booking_status='booked' AND arrival=0 THEN 1 END) AS `new_bookings`,
                            COUNT(CASE WHEN booking_status='cancelled' AND refund=0 THEN 1 END) AS `refund_bookings`
                            FROM `booking_order`";
        $current_bookings = mysqli_fetch_assoc(mysqli_query($con, $current_bookings_q));

        $unread_queries = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(sr_no) AS `count` FROM `user_queries` WHERE `seen`=0"));

        $unread_reviews = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(sr_no) AS `count` FROM `rating_review` WHERE `seen`=0"));

        //current users query and result
        $current_users_q = "SELECT 
                                COUNT(id) AS `total`,
                                COUNT(CASE WHEN `status`=1 THEN 1 END) AS `active`,
                                COUNT(CASE WHEN `status`=0 THEN 1 END) AS `inactive`,
                                COUNT(CASE WHEN `is_verified`=0 THEN 1 END) AS `unverified`
                                FROM `user_cred`";
        $current_users = mysqli_fetch_assoc(mysqli_query($con, $current_users_q));

    ?>

    <!-- middle area main content -->
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <!-- Dashboard Titles -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>DASHBOARD</h3>
                    <?php
                    if ($is_shutdown['shutdown']) {
                        echo <<<data
                                <h6 class="badge bg-danger py-2 px-3">Shutdown Mode is On !!</h6>
                            data;
                    }
                    ?>
                </div>

                <!-- Dashboard cards -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>BOOKINGS</h5>
                </div>

                <!-- Bookings -->
                <div class="row mb-4">

                    <!-- New Bookings Card  -->
                    <div class="col-md-3 mb-4">
                        <a href="new_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
                                <h6>New Bookings</h6>
                                <h1 class="mt-2 mb-0"><?php echo $current_bookings['new_bookings'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <!-- Refund Bookings Card  -->
                    <div class="col-md-3 mb-4">
                        <a href="refund_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-warning p-3">
                                <h6>Refund Bookings</h6>
                                <h1 class="mt-2 mb-0"><?php echo $current_bookings['refund_bookings'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <!-- User Queries Card  -->
                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center text-danger p-3">
                                <h6>User Queries</h6>
                                <h1 class="mt-2 mb-0"><?php echo $unread_queries['count'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <!-- Rating & Review Card  -->
                    <div class="col-md-3 mb-4">
                        <a href="rate_review.php" class="text-decoration-none">
                            <div class="card text-center text-info p-3">
                                <h6>Rating & Review</h6>
                                <h1 class="mt-2 mb-0"><?php echo $unread_reviews['count'] ?></h1>
                            </div>
                        </a>
                    </div>
                </div>


                <!-- Booking Analytics Titles -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>BOOKING ANALYTICS</h5>
                    <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
                        <option value="1">Past 1 Days</option>
                        <option value="2">Past 2 Days</option>
                        <option value="3">Past 7 Days</option>    
                        <option value="4">Past 15 Days</option>
                        <option value="5">Past 30 Days</option>
                        <option value="6">Past 90 Days</option>
                        <option value="7">Past 1 Year</option>
                        <option value="8">All time</option>
                    </select>
                </div>

                <!-- Booking Analytics cards -->
                <div class="row mb-3">

                    <!-- New Bookings Card  -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Total Bookings</h6>
                            <h1 class="mt-2 mb-0" id="total_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="total_amt">₹0</h4>
                        </div>
                    </div>

                    <!-- Active Bookings Card  -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Active Bookings</h6>
                            <h1 class="mt-2 mb-0" id="active_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="active_amt">₹0</h4>
                        </div>
                    </div>

                    <!-- Cancelled Bookings Card  -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Cancelled Bookings</h6>
                            <h1 class="mt-2 mb-0" id="cancelled_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="cancelled_amt">₹0</h4>
                        </div>
                    </div>

                </div>


                <!-- USER, QUERIES, REVIEWS Titles -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>USER, QUERIES, REVIEWS ANALYTICS</h5>
                    <select class="form-select shadow-none bg-light w-auto" onchange="user_analytics(this.value)">
                        <option value="1">Past 1 Days</option>
                        <option value="2">Past 2 Days</option>
                        <option value="3">Past 7 Days</option>    
                        <option value="4">Past 15 Days</option>
                        <option value="5">Past 30 Days</option>
                        <option value="6">Past 90 Days</option>
                        <option value="7">Past 1 Year</option>
                        <option value="8">All time</option>
                    </select>
                </div>

                <!-- USER, QUERIES, REVIEWS cards -->
                <div class="row mb-3">

                    <!-- New Registration Card  -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>New Registration</h6>
                            <h1 class="mt-2 mb-0" id="total_new_reg">0</h1>
                        </div>
                    </div>

                    <!-- Queries Card  -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Queries</h6>
                            <h1 class="mt-2 mb-0" id="total_queries">0</h1>
                        </div>
                    </div>

                    <!-- Reviews Card  -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Reviews</h6>
                            <h1 class="mt-2 mb-0" id="total_reviews">0</h1>
                        </div>
                    </div>
                </div>


                <!-- Users  Title -->
                <h5>USERS</h5>

                <!-- Users Card -->
                <div class="row mb-3">

                    <!-- Total Users Card  -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-warning p-3">
                            <h6>Total</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['total'] ?></h1>
                        </div>
                    </div>

                    <!-- Active Users  -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Active</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['active'] ?></h1>
                        </div>
                    </div>

                    <!-- In-Active Users  -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>In-Active</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['inactive'] ?></h1>
                        </div>
                    </div>

                    <!-- Un-Verified Users  -->
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-warning p-3">
                            <h6>Un-Verified</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['unverified'] ?></h1>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <?php require('include/script.php'); ?>
    <script src="scripts/dashboard.js"></script>
</body>

</html>