<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_res['site_title'] ?> | PROFILE</title>
</head>

<body class="bg-light">

    <?php 
        require('include/header.php'); 

        if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
            redirect('index.php');
        }

        $u_exist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1",[$_SESSION['uId']],'s');

        if(mysqli_num_rows($u_exist)==0){
            redirect('index.php');
        }
        $u_fetch = mysqli_fetch_assoc($u_exist);
    ?>

    <!-- main content -->
    <div class="container">
        <div class="row">

            <!-- title -->
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">PROFILE</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">PROFILE</a>
                    <span class="text-secondary"> > </span>
                </div>
            </div>

            <!-- basic info update-->
            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="info-form">
                        <h5 class="mb-3 fw-bold">Basic Information</h5>

                        <!-- Update  personal info form -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Name</label>
                                <input name="name" type="text" value="<?php echo$u_fetch['name'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input name="phonenum" type="number" value="<?php echo$u_fetch['phonenum'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" disabled value="<?php echo$u_fetch['email'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input name="dob" type="date" value="<?php echo$u_fetch['dob'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Pincode</label>
                                <input name="pincode" type="number" value="<?php echo$u_fetch['pincode'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo$u_fetch['address'] ?></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn text-white custom-bg shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>

             <!-- picture update-->
             <div class="col-md-4 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="profile-form">
                        <h5 class="mb-3 fw-bold">Picture</h5>
                        <img src="<?php echo USERS_IMG_UPLOAD_PATH.$u_fetch['profile'] ?>" class="rounded img-fluid mb-3"><br>
                        <label class="form-label">New Picture</label>
                        <input name="profile" type="file" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none mb-4" required>
                        <button type="submit" class="btn text-white custom-bg shadow-none" name="register">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- password update-->
            <div class="col-md-8 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="pass-form">
                        <h5 class="mb-3 fw-bold">Change Password</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">New Password</label>
                                <input name="new_pass" type="password" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3=4">
                                <label class="form-label">Confirm Password</label>
                                <input name="confirm_pass" type="password" class="form-control shadow-none" required>
                            </div>
                        </div>
                        <button type="submit" class="btn text-white custom-bg shadow-none" name="register">Save Changes</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    
    <script src="script/profile.js"></script> 
    <?php require('include/footer.php'); ?>
    
   

</body>

</html>