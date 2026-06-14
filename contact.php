<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_res['site_title'] ?> | CONTACT</title>
</head>

<body class="bg-light">

    <?php require('include/header.php'); ?>

    <!-- title -->
    <div class="my-5">
        <h2 class="fw-bold h-font text-center">CONTACT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Distinctio aspernatur error<br> ratione omnis nesciunt, corrupti numquam accusamus.
            Distinctio, commodi unde.
        </p>
    </div>

    <!-- main content -->
    <div class="container">
        <div class="row">

            <!-- LEFT SIDE SECTION  -->
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">

                    <!-- GOOGLE MAP LOCATION SECTION -->
                    <iframe class="w-100 rounded mb-4" height="320px" src="<?php echo $contact_res['iframe'] ?>" loading="lazy"></iframe>
                    <h5>Address</h5>
                    <a href="<?php echo $contact_res['gmap'] ?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
                        <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_res['address'] ?>
                    </a>

                    <!-- CONTACT-US DETAILS SECTION -->
                    <h5 class="mt-4">Call us</h5>
                    <a href="tel: +91 <?php echo $contact_res['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +91 <?php echo $contact_res['pn1'] ?>
                    </a>
                    <br>
                    <?php 
                        if($contact_res['pn2']!=''){
                            echo <<<data
                                <a href="tel: +91 $contact_res[pn2]" class="d-inline-block text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill"></i> +91 $contact_res[pn2]
                                </a>
                            data;
                        }
                    ?>
                    <h5 class="mt-4">Email</h5>
                    <a href="mailto: <?php echo $contact_res['email'] ?>" class="d-inline-block text-decoration-none text-dark">
                        <i class="bi bi-envelope-fill me-2"></i> <?php echo $contact_res['email'] ?>
                    </a>

                    <!-- FOLLOW US SECTION -->
                    <h5 class="mt-4">Follow Us</h5>
                    <a href="<?php echo $contact_res['fb'] ?>" class="d-inline-block mb-3 text-dark fs-5">
                        <i class="bi bi-facebook me-2"></i>
                    </a>
                    <a href="<?php echo $contact_res['insta'] ?>" class="d-inline-block mb-3 text-dark fs-5">
                        <i class="bi bi-instagram me-2"></i>
                    </a>
                    <?php 
                        if($contact_res['tw']!=''){
                            echo <<<data
                                <a href="$contact_res[tw]" class="d-inline-block mb-3 text-dark fs-5">
                                    <i class="bi bi-twitter me-1"></i>
                                </a> 
                            data;
                        }
                    ?>
                </div>

            </div>

            <!-- RIGHT SIDE SECTION -->
            <div class="col-lg-6 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4">

                    <!-- send queries form -->
                    <form method="POST">
                        <h5>Send A message</h5>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;" >Name</label>
                            <input name="name" id="name_inp" required type="text" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;" >Email</label>
                            <input name="email" id="email_inp" required type="email" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;" >Subject</label>
                            <input name="subject" id="subject_inp" required type="text" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;" >Message</label>
                            <textarea name="message" id="message_inp" required class="form-control shadow-none" rows="5" style="resize: none;" ></textarea>
                        </div>
                        <button type="submit" name="send" class="btn text-white custom-bg mt-3">SEND</button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>

    <?php 
        if(isset($_POST['send'])){
            $frm_data = filtration($_POST);
            $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
            $values = [$frm_data['name'],$frm_data['email'],$frm_data['subject'],$frm_data['message']];
            $res = insert($q,$values,'ssss');

            if($res==1){
                alert('success','Mail Sent !!😄😄');
            }
            else{
                alert('error','Server Down !!🙁🙁');
            }
        }
    ?>
    <?php require('include/footer.php'); ?>

</body>

</html>