<?php 

require('include/db_config.php');
require('include/essentials.php');
require('include/mpdf/vendor/autoload.php');
require('include/links.php');

adminLogin();

if(isset($_GET['gen_pdf']) && isset($_GET['id']))
{
    $frm_data = filtration($_GET);

    $query = "SELECT bo.*, bd.*,uc.email FROM `booking_order` bo
                INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
                INNER JOIN `user_cred` uc ON bo.user_id = uc.id
                WHERE ((bo.booking_status='booked' AND bo.arrival=1)
                OR (bo.booking_status='cancelled' AND bo.refund=1)
                OR (bo.booking_status='payment failed'))
                AND bo.booking_id = '$frm_data[id]'
            ";

    $res = mysqli_query($con,$query);

    $total_rows = mysqli_num_rows($res);

    if($total_rows==0){
        header('location: dashboard.php');
        exit;
    }

    $data = mysqli_fetch_assoc($res);

    $date = date("d-m-Y | h : i A",strtotime($data['datentime'])); //echo $date;
    $checkin = date("d-m-Y",strtotime($data['check_in']));
    $checkout = date("d-m-Y",strtotime($data['check_out']));

    //$receipt_id = 'HRP_'.random_int(11111,99999999);

    $table_data .= "
        <style>
            .receipt {
                max-width:800px;
                margin: 20px auto;
                background-color: #FFE4C4;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .header {
                text-align: center;
                margin-bottom: 50px;
            }
    
            .header h2 {
                margin-top: 30px;
                color: #DC143C;
            }

            .details {
                margin-bottom: 20px;
            }

            .bid {
                text-align: right
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
    
            table, th, td {
                border: 1px solid #DC143C;
            }
    
            th, td {
                padding: 12px;
                text-align: left;
            }
    
            th {
                background-color: #DC143C;
                color: white;
            }
    
            .total {
                text-align: right;
                font-weight: bold;
                font-size: 18px;
            }
    
            .thank-you {
                text-align: center;
                margin-top: 50px;
            }
    
            .signature {
                margin-top: 30px;
                text-align: center;
            }
        </style>

        <div class='receipt'>

            <div class='header'>
                <img src='../images/rooms/logo.jpg' height='100px' alt='HotelLogo'>
                <h2>BOOKING RECEIPT</h2>
            </div>

            <div class='details'>
                <p><strong>Name : </strong> $data[user_name]</p>
                <p><strong>Email : </strong> $data[email]</p>
                <p><strong>Contact No : </strong> $data[phonenum]</p>
                <p><strong>Address : </strong> $data[address]</p>
            </div>

            <table>
                <tr>
                    <th>Room Details</th>
                    <th>Booking Details</th>
                    <th>Booking Status</th>
                </tr>
                <tr>
                    <td>
                        <b>Room : </b> $data[room_name]
                        <br>
                        <b>Cost : </b> ₹$data[price] Per Night
                    </td>
                    <td>
                        <h6 class='badge bg-primary'>Booking ID : $data[receipt_id]</h6>
                        <br>
                        <b>Check in : </b> $checkin
                        <br>
                        <b>Check out : </b> $checkout
                        <br>
                        <b>Total Amount : </b> ₹$data[trans_amt]/-
                        <br>
                    </td>
                    <td>$data[booking_status]</td>
                </tr>
            </table>   
    ";

    

    if($data['booking_status']=='cancelled')
    {
        $refund = ($data['refund']) ? "Amount Refunded" : "Not Yet Refunded";
        $table_data.="
            <table>
                <tr>
                    <th colspan='2'>Refund Details</th>
                </tr>
                <tr>
                    <td><b>Amount Paid : </b> ₹$data[trans_amt]/- </td>
                    <td><b>Refund : </b> $refund</td>
                </tr>
            </table>
        ";
    }
    else if($data['booking_status']=='payment failed')
    {
        $table_data.="
            <table>
                <tr>
                    <td>Transaction Amount : $data[trans_amt]</td>
                    <td>Failure Response : $data[booking_status]</td>
                </tr>
            </table>
        ";
    }
    else
    {
        $table_data.="
            <table>
                <tr>
                    <td>Room Number : $data[room_no]</td>
                    <td>Amount Paid : $data[trans_amt]</td>
                </tr>
            </table>
        ";
    }
        
    $table_data .= "
            <div class='thank-you'>
                <h5>Thank you for choosing our hotel !!</h5>
            </div>
        </div>       
    ";
    
    // echo $table_data;

    // Generate PDF using M-PDF Library

    // Create an instance of the class:
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($table_data);
    $mpdf->Output($data['receipt_id'].'.pdf','D');
}
else
{
    header('location: dashboard.php');
}



?>

