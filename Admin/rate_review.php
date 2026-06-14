<?php
    require('include/db_config.php');
    require('include/essentials.php');
    adminLogin();
    // session_regenerate_id(true);

    // mark as seen msg
    if(isset($_GET['seen']))
    {
        $frm_data = filtration($_GET);
        
        //seen all
        if($frm_data['seen']=='all'){
            $q = "UPDATE `rating_review` SET `seen`=? ";
            $values = [1];
            if(update($q,$values,'i')){
                alert('success','Marked all as read !!');
            }
            else{
                alert('error','Operation Failed !!');
            }
        }
        else{
            //seen one
            $q = "UPDATE `rating_review` SET `seen`=? WHERE `sr_no`=?";
            $values = [1,$frm_data['seen']];
            if(update($q,$values,'ii')){
                alert('success','Marked as read !!');
            }
            else{
                alert('error','Operation Failed !!');
            }
        }
    }

    // delete msg
    if(isset($_GET['del']))
    {
        $frm_data = filtration($_GET);
        
        // delete all
        if($frm_data['del']=='all'){
            $q = "DELETE FROM `rating_review`";
            if(mysqli_query($con,$q)){
                alert('success','All data deleted !!');
            }
            else{
                alert('error','Operation failed !!');
            }
        }
        else{
            // delete one
            $q = "DELETE FROM `rating_review` WHERE `sr_no`=?";
            $values = [$frm_data['del']];
            if(update($q,$values,'i')){
                alert('success','Data Deleted !!');
            }
            else{
                alert('error','Operation failed !!');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Ratings & Reviews</title>
    <?php require('include/links.php'); ?>
</head>

<body class="bg-white">

    <!-- header file -->
    <?php require('include/header.php'); ?>

    <!-- middle area main content -->
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">RATINGS & REVIEWS</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <!-- All data delete and seen buttons -->
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-primary rounded-pill shadow-none btn-sm">
                                <i class="bi bi-check-all me-1"></i>Mark all read
                            </a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                                <i class="bi bi-trash me-1"></i>Delete all
                            </a>
                        </div>

                        <!-- display table -->
                        <div class="table-responsive-md">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Room Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Rating</th>
                                        <th scope="col" width="20%">Review</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $q = "SELECT rr.*,uc.name AS uname, r.name AS rname FROM `rating_review` rr 
                                              INNER JOIN `user_cred` uc ON rr.user_id = uc.id 
                                              INNER JOIN `rooms` r ON rr.room_id = r.id 
                                              ORDER BY `sr_no` DESC";

                                        $data = mysqli_query($con,$q);
                                        $i = 1;

                                        while($row = mysqli_fetch_assoc($data))
                                        {   
                                            $date = date('d-m-Y',strtotime($row['datentime']));

                                            $seen ='';
                                            if($row['seen'] != 1){
                                                $seen = "<a href='?seen=$row[sr_no]' class='btn btn-sm rounded-pill btn-primary me-2'>Mark As Read</a>";
                                            }
                                            $seen.="<a href='?del=$row[sr_no]' class='btn btn-sm rounded-pill btn-danger'>Delete</a>";
                                            
                                            echo <<<data
                                                <tr>
                                                    <td>$i</td>
                                                    <td>$row[rname]</td>
                                                    <td>$row[uname]</td>
                                                    <td>$row[rating]</td>
                                                    <td>$row[review]</td>
                                                    <td>$date</td>
                                                    <td>$seen</td>
                                                </tr>
                                            data;
                                            $i++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('include/script.php'); ?>
</body>

</html>