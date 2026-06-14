<?php
    require('include/db_config.php');
    require('include/essentials.php');
    adminLogin();
    // session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Users</title>
    <?php require('include/links.php'); ?>
</head>

<body class="bg-white">

    <!-- header file -->
    <?php require('include/header.php'); ?>

    <!-- middle area main content -->
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">USERS</h3>

                <!-- users Section CARD -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <!-- Search user textbox -->
                        <div class="text-end mb-4">
                            <input type="text" oninput="search_user(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to search" >
                        </div>

                        <!-- users display table -->
                        <div class="table-responsive">
                            <table class="table table-hover border text-center" style="min-width: 1500px;" >
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone No</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">DOB</th>
                                        <th scope="col">Verified</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="users-data">
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php require('include/script.php'); ?>
    <script src="scripts/users.js"></script>
</body>

</html>