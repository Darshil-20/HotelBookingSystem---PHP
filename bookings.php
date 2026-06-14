<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_res['site_title'] ?> | PROFILE</title>
</head>

<body class="bg-light">

    <?php 
        require('include/header.php'); 

        if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
            redirect('index.php');
        }
    ?>

     <!-- main content -->
     <div class="container">
        <div class="row">

            <!-- title -->
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">BOOKINGS</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">BOOKINGS</a>
                    <span class="text-secondary"> > </span>
                </div>
            </div>

                <?php

                    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
                                    INNER JOIN `booking_details` bd
                                    ON bo.booking_id = bd.booking_id
                                    WHERE ((bo.booking_status='booked')
                                    OR (bo.booking_status='cancelled')
                                    OR (bo.booking_status='payment failed'))
                                    AND (bo.user_id=?)
                                    ORDER BY bo.booking_id DESC
                                ";

                    $result = select($query, [$_SESSION['uId']], 'i');

                    while ($data = mysqli_fetch_assoc($result)) {
                        $date = date("d-m-Y", strtotime($data['datentime']));
                        $checkin = date("d-m-Y", strtotime($data['check_in']));
                        $checkout = date("d-m-Y", strtotime($data['check_out']));

                        $status_bg = "";
                        $btn = "";

                        if ($data['booking_status'] == 'booked') {
                            $status_bg = "bg-success";

                            if ($data['arrival'] == 1) {
                                $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark text-white btn-sm shadow-none me-3'>Download PDF</a>";

                                if ($data['rate_review'] == 0) {
                                    $btn .= "<button type='button' onclick='review_room($data[booking_id],$data[room_id])' data-bs-toggle='modal' data-bs-target='#reviewModal' class='btn btn-dark btn-sm shadow-none'>Ratings & Reviews</button>";
                                }
                            } else {
                                $btn = "<button type='button' onclick='cancel_booking($data[booking_id])' class='btn btn-danger btn-sm shadow-none'>Cancel</button>";
                            }
                        } else if ($data['booking_status'] == 'cancelled') {
                            $status_bg = "bg-danger";
                            if ($data['refund'] == 0) {
                                $btn = "<span class='badge bg-primary'>Refund in process !!</span>";
                            } else {
                                $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark text-white btn-sm shadow-none me-3'>
                                                Download PDF
                                            </a>
                                        ";
                            }
                        } else {
                            $status_bg = "bg-warning";
                            $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark text-white btn-sm shadow-none'>
                                                Download PDF
                                            </a>
                                        ";
                        }

                        echo <<<bookings
                                <div class='col-md-4 px-4 mb-4'>
                                    <div class='bg-white p-3 rounded shadow-sm'>
                                        <h5>$data[room_name]</h5>
                                        <p>₹$data[price]</p>
                                        <p>
                                            <b>Check-in : </b> $checkin <br>
                                            <b>Check-out : </b> $checkout
                                        </p>
                                        <p>
                                            <b>Amount : </b> ₹$data[price] <br>
                                            <b>Order ID :</b> $data[receipt_id] <br>
                                            <b>Date :</b> $date
                                        </p>
                                        <p>
                                            <span class='badge $status_bg'>$data[booking_status]</span>
                                        </p>
                                        $btn
                                    </div>
                                </div>
                            bookings;
                    }

                ?>

        </div>
     </div>

     <!-- ratings and review Modal -->
    <div class="modal fade" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <!-- review form -->
                <form id="review-form">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-chat-square-heart-fill"></i> Rate & Review
                        </h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select class="form-select shadow-none" name="rating">
                                <option selected>Open this select menu</option>
                                <option value="5">Excellent</option>
                                <option value="4">Good</option>
                                <option value="3">Ok</option>
                                <option value="2">Bad</option>
                                <option value="1">Poor</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Review</label>
                            <textarea id="review" name="pass" rows="3" required class="form-control shadow-none"></textarea>
                        </div>

                        <input type="hidden" name="booking_id">
                        <input type="hidden" name="room_id">

                        <div class="text-end">
                            <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- user end alert msg -->
    <?php
    
        if (isset($_GET['cancel_status'])) {
            alert('success', 'Booking Cancelled !!');
        }
        else if (isset($_GET['review_status'])) {
            alert('success', 'Thank you for Rating & Review !!');
        }

        // require('include/header.php');
    ?>

    
    <script src="script/bookings.js"></script> 
    <?php require('include/footer.php'); ?>

</body>

</html>