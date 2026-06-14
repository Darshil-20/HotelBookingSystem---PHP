<?php

require('../include/db_config.php');
require('../include/essentials.php');
adminLogin();

// add features data function
if (isset($_POST['add_feature'])) {
  $frm_data = filtration($_POST);

  $q = "INSERT INTO `features`(`name`) VALUES (?)";
  $values = [$frm_data['name']];
  $res = insert($q, $values, 's');
  echo $res;
}

// get features data function
if (isset($_POST['get_feature'])) {
  $res = selectAll('features');
  $i = 1;

  while ($row = mysqli_fetch_assoc($res)) {
    echo <<<data
            <tr>
                <td>$i</td>
                <td>$row[name]</td>
                <td>
                    <button type="button" onclick="delete_feature($row[id])" class="btn btn-danger btn-sm shadow-none">
                      <i class='bi bi-trash'></i>
                    </button>
                </td>
            </tr>
         data;
    $i++;
  }
}

// remove features data function
if (isset($_POST['delete_feature'])) {
  $frm_data = filtration($_POST);
  $values = [$frm_data['delete_feature']];

  $check_q = select('SELECT * FROM `room_features` WHERE `features_id`=?', [$frm_data['delete_feature']], 'i');

  if (mysqli_num_rows($check_q) == 0) {
    $q = "DELETE FROM `features` WHERE `id`=?";
    $res = delete($q, $values, 'i');
    echo $res;
  } else {
    echo 'room_added';
  }
}






// add facilities data function
if (isset($_POST['add_facility'])) {
  $frm_data = filtration($_POST);

  $img_r = uploadSVGImages($_FILES['icon'], FACILITIES_FOLDER);
  if ($img_r == 'invalid_image') {
    echo $img_r;
  } else if ($img_r == 'invalid_size') {
    echo $img_r;
  } else if ($img_r == 'upload_failed') {
    echo $img_r;
  } else {
    $q = "INSERT INTO `facilities`(`icon`, `name`, `description`) VALUES (?,?,?)";
    $values = [$img_r, $frm_data['name'], $frm_data['desc']];
    $res = insert($q, $values, 'sss');
    echo $res;
  }
}

// get facilities data function
if (isset($_POST['get_facility'])) {
  $res = selectAll('facilities');
  $i = 1;
  $path = FACILITIES_IMG_PATH;

  while ($row = mysqli_fetch_assoc($res)) {
    echo <<<data
            <tr>
                <td>$i</td>
                <td><img src="$path$row[icon]" width="80px"></td>
                <td>$row[name]</td>
                <td>$row[description]</td>
                <td>
                    <button type="button" onclick="delete_facility($row[id])" class="btn btn-danger btn-sm shadow-none">
                      <i class='bi bi-trash'></i>
                    </button>
                </td>
            </tr>
         data;
    $i++;
  }
}

// remove facilities data function
if (isset($_POST['delete_facility'])) {
  $frm_data = filtration($_POST);
  $values = [$frm_data['delete_facility']];

  $check_q = select('SELECT * FROM `room_facilities` WHERE `facilities_id`=?', [$frm_data['delete_facility']], 'i');

  if (mysqli_num_rows($check_q) == 0) {
    $Q1 = "SELECT * FROM `facilities` WHERE `id`=?";
    $res = select($Q1, $values, 'i');
    $img = mysqli_fetch_assoc($res);

    if (deleteImg($img['icon'], FACILITIES_FOLDER)) {
      $q = "DELETE FROM `facilities` WHERE `id`=?";
      $res = delete($q, $values, 'i');
      echo $res;
    } else {
      echo 0;
    }
  } else {
    echo 'room_added';
  }
}
