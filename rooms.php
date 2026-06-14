<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_res['site_title'] ?> | ROOMS</title>
</head>

<body class="bg-light">

    <?php
    require('include/header.php');

    $checkin_default = "";
    $checkout_default = "";
    $adult_default = "";
    $children_default = "";
    $roomName_default = "";

    if (isset($_GET['check_availability'])) {
        $frm_data = filtration($_GET);

        $checkin_default = $frm_data['checkin'];
        $checkout_default = $frm_data['checkout'];
        $adult_default = $frm_data['adult'];
        $children_default = $frm_data['children'];
        // $roomName_default = $frm_data['name'];
    }
    ?>

    <!-- title -->
    <div class="my-5">
        <h2 class="fw-bold h-font text-center">OUR ROOMS</h2>
        <div class="h-line bg-dark mb-2"></div>
    </div>

    <!-- main content -->
    <div class="container-fluid">

        <div class="row">

            <!-- left side nav bar for filtering -->
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">

                <!-- nav bar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">

                        <h4 class="mt-2">FILTERS</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">

                            <!--check availability filter -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>CHECK AVAILABILITY</span>
                                    <button id="chk_avail_btn" onclick="chk_avail_clear()" class="btn btn-sm text-secondary d-none">Reset</button>
                                </h5>

                                <label class="form-label">Check-In</label>
                                <input type="date" id="checkin" onchange="chk_avail_filter()" value="<?php echo $checkin_default ?>" class="form-control shadow-none mb-3">

                                <label class="form-label">Check-Out</label>
                                <input type="date" id="checkout" onchange="chk_avail_filter()" value="<?php echo $checkout_default ?>" class="form-control shadow-none">
                            </div>

                            <!-- facility filter -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>FACILITIES</span>
                                    <button id="facilities_btn" onclick="facilities_clear()" class="btn btn-sm text-secondary d-none">Reset</button>
                                </h5>
                                <?php
                                $facilities_q = selectAll('facilities');
                                while ($row = mysqli_fetch_assoc($facilities_q)) {
                                    echo <<<facilities
                                                <div class="mb-2">
                                                    <input type="checkbox" onclick="fetch_rooms()" name="facilities" value="$row[id]" class="form-check-input shadow-none me-1" id="$row[id]">
                                                    <label class="form-label" for="$row[id]">$row[name]</label>
                                                </div>
                                        facilities;
                                }
                                ?>
                            </div>

                            <!-- guests filter -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>GUESTS</span>
                                    <button id="guests_btn" onclick="guests_clear()" class="btn btn-sm text-secondary d-none">Reset</button>
                                </h5>

                                <div class="d-flex">
                                    <div class="me-3">
                                        <label class="form-label">Adults</label>
                                        <input id="adults" min="1" oninput="guests_filter()" value="<?php echo $adult_default ?>" type="number" class="form-control shadow-none mb-3">
                                    </div>
                                    <div>
                                        <label class="form-label">Children</label>
                                        <input id="children" min="1" oninput="guests_filter()" value="<?php echo $children_default ?>" type="number" class="form-control shadow-none mb-3">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </nav>

            </div>

            <!-- Room CARDS -->
            <div id="rooms-data" class="col-lg-9 col-md-12 px-4">
            </div>

        </div>
    </div>

    <script src="script/rooms_filter.js"></script>                         
    <?php require('include/footer.php'); ?>

</body>

</html>