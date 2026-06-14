<?php 
    require('include/db_config.php');
    require('include/essentials.php'); 

    session_start();
    if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
        redirect('dashboard.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TJ Hotel | Admin Login Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php require('include/links.php'); ?>
    <style>
        div.login-form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            width: 400px;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Admin login panel -->
    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form method="POST" autocomplete="off">
            <h4 class="bg-dark text-white py-3">ADMIN LOGIN PANEL</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input type="text" name="admin_name" required class="form-control shadow-none text-center" placeholder="Admin Name" >
                </div>
                <div class="mb-4">
                    <input type="password" name="admin_pass" required class="form-control shadow-none text-center" placeholder="Admin Password">
                </div>
                <button type="submit"  name="login" class="btn text-white custom-bg shadow-none">LOGIN</button>
            </div>
        </form>
    </div>

    <?php 

        if(isset($_POST['login'])){

            $frm_data = filtration($_POST);
            $query = "SELECT * FROM `admin_cred` WHERE `admin_name`=? AND `admin_pass`=?";
            $values = [$frm_data['admin_name'],$frm_data['admin_pass']];
            // $datatypes = "ss";
            
            $res = select($query,$values,"ss");
            // print_r($res); 
            
            if($res->num_rows == 1){
                // echo"got user";

                $row = mysqli_fetch_assoc($res);
                session_start();
                $_SESSION['adminLogin'] = true;
                $_SESSION['adminId'] = $row['sr_no'];
                redirect('dashboard.php');
            }
            else{
                alert('error','Login Failed 😢!! - Invalid Credentials');
            }

            // echo "<h1>$frm_data[admin_name]</h1>";
            // echo "<h1>$frm_data[admin_pass]</h1>";
            // print_r($frm_data);
        }
    ?>

    <?php require('include/script.php'); ?>
</body>

</html>