<?php 

    require('../include/db_config.php');
    require('../include/essentials.php');
    adminLogin();

    // retrive site title and about section data 
    if(isset($_POST['get_general']))
    {
        $q = "SELECT * FROM `settings` WHERE `sr_no`=?";
        $values = [1];
        $res = select($q,$values,"i");
        $data = mysqli_fetch_assoc($res);
        $json_data = json_encode($data);
        echo $json_data;
    }

     // update site title and about section data 
     if(isset($_POST['upd_general']))
     {
        $frm_data = filtration($_POST);
        $q = "UPDATE `settings` SET `site_title`=?, `site_about`=? WHERE `sr_no`=? ";
        $values = [$frm_data['site_title'], $frm_data['site_about'], 1];
        $res = update($q,$values,"ssi");
        echo $res;
     }

     // update shutdown mode 
     if(isset($_POST['upd_shutdown']))
     {
        $frm_data = ($_POST['upd_shutdown'] == 0) ? 1 : 0;
        $q = "UPDATE `settings` SET `shutdown`=? WHERE `sr_no`=? ";
        $values = [$frm_data, 1];
        $res = update($q,$values,"ii");
        echo $res;
     }


    // retrive contact details section data 
    if(isset($_POST['get_contacts']))
    {
        $q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
        $values = [1];
        $res = select($q,$values,"i");
        $data = mysqli_fetch_assoc($res);
        $json_data = json_encode($data);
        echo $json_data;
    }

    // update site title and about section data 
    if(isset($_POST['upd_contacts']))
    {
       $frm_data = filtration($_POST);
       $q = "UPDATE `contact_details` SET `address`=?,`gmap`=?,`pn1`=?,`pn2`=?,`email`=?,`fb`=?,`insta`=?,`tw`=?,`iframe`=? WHERE `sr_no`=?";
       $values = [$frm_data['address'], $frm_data['gmap'], $frm_data['pn1'], $frm_data['pn2'], $frm_data['email'], $frm_data['fb'], $frm_data['insta'], $frm_data['tw'], $frm_data['iframe'], 1];
       $res = update($q,$values,"sssssssssi");
       echo $res;
    }

    // add team member data into management team
    if(isset($_POST['add_member']))
    {
       $frm_data = filtration($_POST);

       $img_r = uploadImages($_FILES['picture'],ABOUT_FOLDER);
       if($img_r == 'invalid_image'){
         echo $img_r;
       }
       else if($img_r == 'invalid_size'){
         echo $img_r;
       }
       else if($img_r == 'upload_failed'){
         echo $img_r;
       }
       else{
         $q = "INSERT INTO `team_details`(`name`, `picture`) VALUES (?,?)";
         $values = [$frm_data['name'], $img_r];
         $res = insert($q,$values,"ss");
         echo $res;
       } 
    }

    // get team member info
    if(isset($_POST['get_members']))
    {
      $res = selectAll('team_details');

      while($row = mysqli_fetch_assoc($res))
      {
         $path = UPLOAD_IMG_PATH;
         echo <<<data
            <div class="col-md-2 mb-3">
               <div class="card bg-dark text-white">
                  <img src="$path$row[picture]" class="card-img">
                  <div class="card-img-overlay text-end">
                        <button type="button" onclick="delete_member($row[sr_no])" class="btn btn-danger btn-sm shadow-none">
                           <i class="bi bi-trash me-1"></i>Delete
                        </button>
                  </div>
                  <p class="card-text text-center px-3 py-2">$row[name]</p>
               </div>
            </div>
         data;
      }
    }

    // remove team member
    if(isset($_POST['delete_member']))
    {
      $frm_data = filtration($_POST);
      $values = [$frm_data['delete_member']];

      $Q1 = "SELECT * FROM `team_details` WHERE `sr_no`=?";
      $res = select($Q1,$values,'i');
      $img = mysqli_fetch_assoc($res);

      if(deleteImg($img['picture'],ABOUT_FOLDER)){
         $q = "DELETE FROM `team_details` WHERE `sr_no`=?";
         $res = delete($q,$values,'i');
         echo $res;
      }
      else{
         echo 0;
      }

    }
?>