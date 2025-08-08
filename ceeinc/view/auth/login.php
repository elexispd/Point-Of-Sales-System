<?php
Cee_assets::Assets();
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-menu-color="brand" data-topbar-color="light">

<head>
    <meta charset="utf-8">
    <title>Log In | Orumba North Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description">
    <meta content="premium esowp" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/favicon.ico">

    <!-- App css -->
    <link href="<?= BASE_URL ?>assets/css/style.min.css" rel="stylesheet" type="text/css">
    <link href="<?= BASE_URL ?>assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <script src="<?= BASE_URL ?>assets/js/config.js"></script>
</head>

<body class="d-flex justify-content-center align-items-center min-vh-100 p-5" style="background:rgba(227, 222, 209, 0.72)" >
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-md-5">
                <div class="card">
                    <div class="card-body p-4">

                        <div class="text-center w-75 mx-auto auth-logo mb-4">
                            <a class='logo-dark' href='index.htm'>
                                <span><img src="<?= BASE_URL ?>assets/images/logo-light.png" alt="" height="80"></span>
                                <span><img src="<?= BASE_URL ?>assets/images/logo-light12.png" alt="" height="80"></span>
                            </a>

                            <a class='logo-light' href='<?= BASE_URL ?>'>
                                <span><img src="<?= BASE_URL ?>assets/images/logo-light.png" alt="" height="50"></span>
                                <span><img src="<?= BASE_URL ?>assets/images/logo-light12.png" alt="" height="50"></span>
                               
                            </a>
                        </div>

                        <form action="<?= BASE_URL ?>auth/login_process" method="post">
                            <?php 
                                Session::form_csfr();
                                echo Session::ceedata("cip_auth");
                            ?>
                            <div class="form-group mb-3">
                                <label class="form-label" for="emailaddress">Username</label>
                                <input class="form-control" name="username" id="emailaddress" autocomplete="off" required="" placeholder="">
                            </div>

                            <div class="form-group mb-3">
                                <a class='text-muted float-end' href='pages-recoverpw.html'><small></small></a>
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control" name="password" required="" autocomplete="off" type="password" placeholder="Enter your password">
                            </div>

                            <div class="form-group mb-3">
                                <div class="">
                                    <input class="form-check-input" type="checkbox" id="checkbox-signin" checked="">
                                    <label class="form-check-label ms-2" for="checkbox-signin">Remember me</label>
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn w-100 text-light" style="background: #0C5004" type="submit"> Log In </button>
                            </div>

                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-white"> <a class='text-white ms-1' href='#'>Forgot your password?</a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>

    <!-- App js -->
    <script src="<?= BASE_URL ?>assets/js/vendor.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/app.js"></script>

</body>

</html>

<?php        
    Session::unset_ceedata("cip_auth","");
?>