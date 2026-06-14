<?php 

    require('../include/db_config.php');
    require('../include/essentials.php');
    adminLogin();

    // add team member data into management team
    if(isset($_POST['add_image']))
    {
       $img_r = uploadImages($_FILES['picture'],CAROUSEL_FOLDER);
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
         $q = "INSERT INTO `carousel`(`image`) VALUES (?)";
         $values = [$img_r];
         $res = insert($q,$values,"s");
         echo $res;
       } 
    }

    // get team member info
    if(isset($_POST['get_carousel']))
    {
      $res = selectAll('carousel');

      while($row = mysqli_fetch_assoc($res))
      {
         $path = CAROUSEL_IMG_PATH;
         echo <<<data
            <div class="col-md-4 mb-3">
               <div class="card bg-dark text-white">
                  <img src="$path$row[image]" class="card-img">
                  <div class="card-img-overlay text-end">
                        <button type="button" onclick="delete_image($row[sr_no])" class="btn btn-danger btn-sm shadow-none">
                           <i class="bi bi-trash me-1"></i>Delete
                        </button>
                  </div>
               </div>
            </div>
         data;
      }
   }


    // remove team member
    if(isset($_POST['delete_image']))
    {
      $frm_data = filtration($_POST);
      $values = [$frm_data['delete_image']];

      $Q1 = "SELECT * FROM `carousel` WHERE `sr_no`=?";
      $res = select($Q1,$values,'i');
      $img = mysqli_fetch_assoc($res);

      if(deleteImg($img['image'],CAROUSEL_FOLDER)){
         $q = "DELETE FROM `carousel` WHERE `sr_no`=?";
         $res = delete($q,$values,'i');
         echo $res;
      }
      else{
         echo 0;
      }

    }
?>