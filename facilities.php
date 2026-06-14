<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_res['site_title'] ?> | FACILITIES</title>
    <style>
        .pop:hover{
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }
    </style>
</head>

<body class="bg-light">

    <?php require('include/header.php'); ?>

    <!-- title -->
    <div class="my-5">
        <h2 class="fw-bold h-font text-center">OUR FACILITIES</h2>
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
            <?php 
                $res = selectAll('facilities');
                $path = FACILITIES_IMG_PATH;

                while($row = mysqli_fetch_assoc($res)){
                    echo <<<data
                        <div class="col-lg-4 col-md-6 mb-5 px-4">
                            <div class="bg-white border-top rounded  shadow p-4 border-4 border-dark pop">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="$path$row[icon]" width="60px">
                                    <h5 class="m-0 ms-3">$row[name]</h5>
                                </div>
                                <p style="text-align: justify;">$row[description]</p>
                            </div>
                        </div>
                    data;
                }
            ?>
        </div>
    </div>


    <?php require('include/footer.php'); ?>

</body>

</html>