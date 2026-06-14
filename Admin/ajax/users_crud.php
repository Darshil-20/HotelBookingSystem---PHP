<?php

require '../include/db_config.php';
require '../include/essentials.php';
adminLogin();


// get all users data in table
if (isset($_POST['get_users'])) {

    $res = selectAll('user_cred');
    $i = 1;
    $path = USERS_IMG_UPLOAD_PATH;

    $data = '';

    while ($row = mysqli_fetch_assoc($res)) 
    {
        $del_btn = "<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm'>
                        <i class='bi bi-trash'></i>
                    </button>";

        $block_btn = "<button type='button' onclick='ban_user($row[id])' class='btn btn-danger shadow-none btn-sm'>
                        <i class='bi bi-person-fill-slash'></i> 
                      </button>";

        $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";
        if($row['is_verified']){
            $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
            $del_btn = "";
        }

        $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-success btn-sm shadow-none'>Active</button>";
        if(!$row['status']){
            $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-danger btn-sm shadow-none'>InActive</button>";
        }

        $date = date("d-m-Y",strtotime($row['datentime']));
        $dob = date("d-m-Y",strtotime($row['dob']));

        $data.="
          <tr class='align-middle'>
            <td>$i</td>
            <td>
                <img src='$path$row[profile]' width='55px'>
                <br>
                $row[name]
            </td>
            <td>$row[email]</td>
            <td>$row[phonenum]</td>
            <td style='width: 20%;'>$row[address]-$row[pincode]</td>
            <td>$dob</td>
            <td>$verified</td>
            <td>$status</td>
            <td>$date</td>
            <td>$del_btn</td>
          </tr>
        ";
        $i++;
    }
    echo $data;
}


// change user status activate/inactivate
if (isset($_POST['toggle_status'])) {
    $frm_data = filtration($_POST);
    $q = "UPDATE `user_cred` SET `status`=? WHERE `id`=?";
    $values = [$frm_data['value'], $frm_data['toggle_status']];
    $res = update($q, $values, 'ii');

    if ($res) {
        echo 1;
    } else {
        echo 0;
    }
}

// remove user 
if (isset($_POST['remove_user'])){

  $frm_data = filtration($_POST);

  $res = delete("DELETE FROM `user_cred` WHERE `id`=? AND `is_verified`=?", [$frm_data['user_id'],0], 'ii');

  if($res){
    echo 1;
  }
  else{
    echo 0;
  }
}

// search user
if (isset($_POST['search_user'])) {

    $frm_data = filtration($_POST);

    $query = "SELECT * FROM `user_cred` WHERE `name` LIKE ?";
    $values = ["%$frm_data[name]%"];
    $res = select($query,$values,'s');

    $i = 1;
    $path = USERS_IMG_UPLOAD_PATH;

    $data = '';

    while ($row = mysqli_fetch_assoc($res)) 
    {
        $del_btn = "<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm'>
                        <i class='bi bi-trash'></i>
                    </button>";

        $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";
        if($row['is_verified']){
            $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
            $del_btn = "";
        }

        $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-success btn-sm shadow-none'>Active</button>";
        if(!$row['status']){
            $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-danger btn-sm shadow-none'>InActive</button>";
        }

        $date = date("d-m-Y",strtotime($row['datentime']));

        $data.="
          <tr class='align-middle'>
            <td>$i</td>
            <td>
                <img src='$path$row[profile]' width='55px'>
                <br>
                $row[name]
            </td>
            <td>$row[email]</td>
            <td>₹$row[phonenum]</td>
            <td style='width: 20%;'>$row[address]-$row[pincode]</td>
            <td>$row[dob]</td>
            <td>$verified</td>
            <td>$status</td>
            <td>$date</td>
            <td>$del_btn</td>
          </tr>
        ";
        $i++;
    }
    echo $data;
}


?>



