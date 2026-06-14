<?php

require('admin/include/db_config.php');
require('admin/include/essentials.php');

require('include/razorpay/Razorpay_config.php');
require('include/razorpay/Razorpay.php');

date_default_timezone_set("Asia/Kolkata");

session_start();
// function regenerate_session($uid)
// {
//     $user_q =select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1",[$uid],'i');
//     $user_fetch = mysqli_fetch_assoc($user_q);

//     $_SESSION['login'] = true;
//     $_SESSION['uId'] = $user_fetch['id'];
//     $_SESSION['uName'] = $user_fetch['name'];
//     $_SESSION['uPic'] = $user_fetch['profile'];
//     $_SESSION['uPhone'] = $user_fetch['phonenum'];
//     $_SESSION['uEmail'] = $user_fetch['email'];
// }
// if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
//     redirect('rooms.php');
//     //regenerate_session($user_fetch['id']);
// }

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;
$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false) {
    $api = new Api($keyId, $keySecret);

    try {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    } catch (SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true) {

    $rzp_order_id = $_SESSION['razorpay_order_id'];
    $rap_payment_id = $_POST['razorpay_payment_id'];

    $CUST_ID = $_SESSION['uId'];
    $ROOM_ID = $_SESSION['room']['id'];
    $ROOM_PRICE = $_SESSION['room']['price'];
    $TXN_AMOUNT = $_SESSION['room']['payment'];
    $RECEIPT_ID = 'RECEIPT_'.$_SESSION['uId'] . random_int(11111, 9999999);

    $name = $_SESSION['uName'];
    $email = $_SESSION['uEmail'];
    $phonenum = $_SESSION['uPhone'];
    $address = $_SESSION['uAddress'];

    $checkin = $_SESSION['checkin'];
    $checkout = $_SESSION['checkout'];
    $RECEIPT_ID = $_SESSION['receipt_id'];

    //insert payment data into database

    $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`,`receipt_id`,`rzp_order_id`,`rzp_payment_id`,`trans_amt`,`trans_status`,`booking_status`) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $values1 = [$CUST_ID, $_SESSION['room']['id'], $checkin, $checkout, $RECEIPT_ID, $rzp_order_id, $rap_payment_id, $TXN_AMOUNT, 'TXN_SUCCESS','booked'];
    $res1 = insert($query1, $values1, 'iisssssiss');

    $booking_id = mysqli_insert_id($con);
    $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phonenum`, `email`,`address`) VALUES (?,?,?,?,?,?,?,?)";
    $values2 = [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $TXN_AMOUNT, $name, $phonenum, $email, $address];
    $res2 = insert($query2, $values2, 'isssssss');

    redirect('pay_status.php');
} else {
    redirect('index.php');
}
