<?php
require('admin/include/db_config.php');
require('admin/include/essentials.php');

require('include/razorpay/Razorpay_config.php');
require('include/razorpay/Razorpay.php');

//razorpay api config
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

date_default_timezone_set("Asia/Kolkata");

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('rooms.php');
}


if (isset($_POST['pay_now'])) {

    $api = new Api($keyId, $keySecret);

    $CUST_ID = $_SESSION['uId'];
    $ROOM_ID = $_SESSION['room']['id'];
    $ROOM_PRICE = $_SESSION['room']['price'];
    $TXN_AMOUNT = $_SESSION['room']['payment'];
    $RECEIPT_ID = 'RECEIPT_' . $_SESSION['uId'] . random_int(11111, 9999999);

    $name = $_SESSION['uName'];
    $email = $_SESSION['uEmail'];
    $phonenum = $_SESSION['uPhone'];
    $address = $_SESSION['uAddress'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    $_SESSION['checkin'] = $checkin;
    $_SESSION['checkout'] = $checkout;
    $_SESSION['receipt_id'] = $RECEIPT_ID;

    //create order from razorpay
    $orderData = [
        'receipt'         => $RECEIPT_ID,
        'amount'          => $TXN_AMOUNT * 100, // 2000 rupees in paise
        'currency'        => 'INR',
        'payment_capture' => 1 // auto capture
    ];

    // auto generate from razorpay server
    $razorpayOrder = $api->order->create($orderData);
    $razorpayOrderId = $razorpayOrder['id'];
    $_SESSION['razorpay_order_id'] = $razorpayOrderId;
    $displayAmount = $amount = $orderData['amount'];

    if ($displayCurrency !== 'INR') {
        $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
        $exchange = json_decode(file_get_contents($url), true);

        $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
    }

    $checkout = 'manual';

    if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true)) {
        $checkout = $_GET['checkout'];
    }

    $data = [
        "key"               => $keyId,
        "amount"            => $amount,
        "name"              => "ROYAL PARADISE",
        "description"       => "HOTEL ROYAL PARADISE",
        "image"             => "images/rooms/logo.jpg",
        "prefill"           => [
            "name"              => $name,
            "email"             => $email,
            "contact"           => $phonenum,
        ],
        "theme"             => [
            "color"             => "#5ce2b4",
        ],
        "order_id"          => $razorpayOrderId,
    ];

    if ($displayCurrency !== 'INR') {
        $data['display_currency']  = $displayCurrency;
        $data['display_amount']    = $displayAmount;
    }

    $json = json_encode($data);

    require("include/checkout/{$checkout}.php");

    // $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`,`order_id`,`trans_amt`) VALUES (?,?,?,?,?,?)";
    // $values1 = [$CUST_ID,$_SESSION['room']['id'],$frm_data['checkin'],$frm_data['checkout'],$ORDER_ID,$TXN_AMOUNT];
    // $res1 = insert($query1,$values1,'issssi');

    // $booking_id = mysqli_insert_id($con);
    // $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phonenum`, `address`) VALUES (?,?,?,?,?,?,?)";
    // $values2 = [$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],$TXN_AMOUNT,$frm_data['name'],$frm_data['phonenum'],$frm_data['address']];
    // $res2 = insert($query2,$values2,'issssss');
}
