<?php 

require('admin/include/db_config.php');
require('admin/include/essentials.php');

if(isset($_GET['email_confirmation']))
{
    $data = filtration($_GET);
    $query = "SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? LIMIT 1";
    $values = [$data['email'],$data['token']];

    $res = select($query,$values,'ss');

    if(mysqli_num_rows($res) == 1){
        $fetch = mysqli_fetch_assoc($res);

        if($fetch['is_verified']==1){
            echo "<script>alert('Email Already Verified !!')</script>";
        }
        else{
            $upd_q = "UPDATE `user_cred` SET `is_verified`=? WHERE `id`=?";
            $upd_val = [1,$fetch['id']];
            $upd_res = update($upd_q,$upd_val,'ii');

            if($upd_res){
                echo "<script>alert('Email Verification Successful !!')</script>";
            }
            else{
                echo "<script>alert('Email Verification Failed ! Server Down !!')</script>";
            }
        }
        redirect('index.php');
    }
    else{
        echo "<script>alert('Invalid Link !!')</script>";
    }

}

?>