<?php
Cee_assets::Assets();
$password = Session::ceedata("cip_password");
$username = Session::ceedata("cip_username");
// $e = users_model::currentUser()->fetch_assoc();
// print_r($e); exit;
$user_id = users_model::auth($username, $password);
$user = users_model::getLoggedInUser();
if ($user_id) {
} else {
    // Session::set_ceedata("cip_auth","<div class='cee_error'> Unauthorized Access </div>"); 
    cee_matchapp::redirect("auth/login");
}


?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-menu-color="brand" data-topbar-color="light">

<head>
    <meta charset="utf-8">
    <title>ORUMBA DASHBOARD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Myra Studio" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo-light.png">

    <link href="<?= BASE_URL ?>assets/libs/morris.js/morris.css" rel="stylesheet" type="text/css">

    <!-- App css -->
    <link href="<?= BASE_URL ?>assets/css/style.min.css" rel="stylesheet" type="text/css">
    <link href="<?= BASE_URL ?>assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <script src="<?= BASE_URL ?>assets/js/config.js"></script>
    <!-- App js -->
    

</head>

<body>
    <!-- Begin page -->
    <div class="layout-wrapper">

        <!-- ========== Left Sidebar ========== -->
        <div class="main-menu" >
            <!-- Brand Logo -->
            <div class="logo-box" style="background:rgb(245, 244, 243)">
                <!-- Brand Logo Light -->
                <a class='logo-light' href='<?= BASE_URL ?>'>
                    <img src="<?= BASE_URL ?>assets/images/logo-light.png" alt="logo" class="logo-lg" height="80">
                    <img src="<?= BASE_URL ?>assets/images/logo-light.png" alt="small logo" class="logo-sm" height="60">
                </a>

                <!-- Brand Logo Dark -->
                <a class='logo-dark' href='<?= BASE_URL ?>'>
                    <img src="<?= BASE_URL ?>assets/images/logo-light.png" alt="dark logo" class="logo-lg" height="80">
                    <img src="<?= BASE_URL ?>assets/images/logo-light.png" alt="small logo" class="logo-sm" height="60">
                </a>
            </div>

            <!--- Menu -->
            <div data-simplebar="" style="background:rgb(12, 80, 4)">
                <ul class="app-menu">

                    <!-- Menu Title -->
                    <li class="menu-title">Menu</li>

                    <!-- Dashboards -->
                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>'>
                            <span class="menu-icon"><i class="bx bx-home"></i></span>
                            <span class="menu-text"> Dashboards </span>
                        </a>
                    </li>

                    <?php 
                        if($user["role"] == "supervisor") { ?>
                    <li class="menu-title">Shop Road</li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>roads/create'>
                            <span class="menu-icon"><i class="bx bx-plus"></i></span>
                            <span class="menu-text"> Add Road </span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>roads'>
                            <span class="menu-icon"><i class="bx bx-list-ul"></i></span>
                            <span class="menu-text"> View Roads </span>
                        </a>
                    </li>
                    <!-- Location Section -->
                    <li class="menu-title"> Locations </li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>location/create'>
                            <span class="menu-icon"><i class="bx bx-plus"></i></span>
                            <span class="menu-text"> Register Location </span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>location'>
                            <span class="menu-icon"><i class="bx bx-map"></i></span>
                            <span class="menu-text"> View Location </span>
                        </a>
                    </li>

                    <!-- Analysis Section -->
                    <li class="menu-title"> Analysis </li>

                    <li class="menu-item">
                        <a href="#platform-user" data-bs-toggle="collapse" class="menu-link waves-effect waves-light">
                            <span class="menu-icon"><i class="bx bx-line-chart"></i></span>
                            <span class="menu-text"> Analysis </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="platform-user">
                            <ul class="sub-menu">
                                <li class="menu-item">
                                    <a class='menu-link' href='<?= BASE_URL ?>analysis'>
                                        <span class="menu-text">Analyse Data</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    
                    <?php } ?>

                    <?php 
                        if($user["role"] == "admin") { ?>

                    <!-- Category Section -->
                    <li class="menu-title">Category</li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>category/create'>
                            <span class="menu-icon"><i class="bx bx-plus"></i></span>
                            <span class="menu-text"> Add Category </span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>category'>
                            <span class="menu-icon"><i class="bx bx-list-ul"></i></span>
                            <span class="menu-text"> View Category </span>
                        </a>
                    </li>
                    

                    <!-- Users Section -->
                    <li class="menu-title"> Users </li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>users/create'>
                            <span class="menu-icon"><i class="bx bx-user-pin"></i></span>
                            <span class="menu-text"> Register Agent </span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>users'>
                            <span class="menu-icon"><i class="bx bx-id-card"></i></span>
                            <span class="menu-text"> View Agent </span>
                        </a>
                    </li>
                    <!-- Location Section -->
                    <li class="menu-title"> Locations </li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>location/create'>
                            <span class="menu-icon"><i class="bx bx-plus"></i></span>
                            <span class="menu-text"> Register Location </span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>location'>
                            <span class="menu-icon"><i class="bx bx-map"></i></span>
                            <span class="menu-text"> View Location </span>
                        </a>
                    </li>

                    
                    <!-- Verification Section -->
                    <li class="menu-title"> Verification </li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>location/verify'>
                            <span class="menu-icon"><i class="bx bx-id-card"></i></span>
                            <span class="menu-text"> Verification </span>
                        </a>
                    </li>

                    <li class="menu-title"> Demand Notice </li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>demand_notice'>
                            <span class="menu-icon"><i class="bx bx-id-card"></i></span>
                            <span class="menu-text"> Print Notice </span>
                        </a>
                    </li>
                    

                    <!-- Analysis Section -->
                    <li class="menu-title"> Analysis </li>

                    <li class="menu-item">
                        <a href="#platform-user" data-bs-toggle="collapse" class="menu-link waves-effect waves-light">
                            <span class="menu-icon"><i class="bx bx-line-chart"></i></span>
                            <span class="menu-text"> Analysis </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="platform-user">
                            <ul class="sub-menu">
                                <li class="menu-item">
                                    <a class='menu-link' href='<?= BASE_URL ?>analysis'>
                                        <span class="menu-text">Analyse Data</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>analysis/performance'>
                                        <span class="menu-text"> Agent Perfomance </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    

                    <!-- Payment Section -->
                   <li class="menu-title">Payment</li>
                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>payment'>
                            <span class="menu-icon"><i class="bx bx-money"></i></span>
                            <span class="menu-text"> Make Payment </span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>payment/verify'>
                            <span class="menu-icon"><i class="bx bx-id-card"></i></span>
                            <span class="menu-text"> Confirmation </span>
                        </a>
                    </li>
                   
                    <!-- Payment Section -->
                    <!-- <li class="menu-title">Wallet</li>
                    <li class="menu-item">
                        <a class='menu-link waves-effect waves-light' href='<?= BASE_URL ?>wallet'>
                            <span class="menu-icon"><i class="bx bx-money"></i></span>
                            <span class="menu-text"> Fund Wallet </span>
                        </a>
                    </li> -->

                    <!-- Analysis Section -->
                    <li class="menu-title"> Change Password </li>

                    <li class="menu-item">
                        <a href="#platform-password" data-bs-toggle="collapse" class="menu-link waves-effect waves-light">
                            <span class="menu-icon"><i class="bx bx-line-chart"></i></span>
                            <span class="menu-text"> Reset Password </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="platform-password">
                            <ul class="sub-menu">
                                <li class="menu-item">
                                    <a class='menu-link' href='<?= BASE_URL ?>users/changeMyPassword'>
                                        <span class="menu-text">My password</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class='menu-link' href='<?= BASE_URL ?>users/search'>
                                        <span class="menu-text">Agent's Password</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <?php }
                    ?>
                </ul>
            </div>
        </div>

        <div class="page-content">

            <!-- ========== Topbar Start ========== -->
            <div class="navbar-custom">
                <div class="topbar">
                    <div class="topbar-menu d-flex align-items-center gap-lg-2 gap-1">

                        <!-- Brand Logo -->
                        <div class="logo-box" style="background:rgb(248, 247, 246)" >
                            <!-- Brand Logo Light -->
                            <a class='logo-light' href='index.htm'>
                                <img src="<?= BASE_URL ?>assets/images/logo-light.png" alt="logo" class="logo-lg" height="22">
                                <img src="<?= BASE_URL ?>assets/images/logo-light.png" alt="small logo" class="logo-sm" height="22">
                            </a>

                            <!-- Brand Logo Dark -->
                            <a class='logo-dark' href='index.htm'>
                                <img src="<?= BASE_URL ?>assets/images/logo-light.png" alt="dark logo" class="logo-lg" height="22">
                                <img src="<?= BASE_URL ?>assets/images/logo-light.png" alt="small logo" class="logo-sm" height="22">
                            </a>
                        </div>

                        <!-- Sidebar Menu Toggle Button -->
                        <button class="button-toggle-menu">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </div>

                    <ul class="topbar-menu d-flex align-items-center gap-4">

                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="<?= BASE_URL ?>assets/images/users/avatar-4.jpg" alt="user-image" class="rounded-circle">
                                <span class="ms-1 d-none d-md-inline-block">
                                    <?php
                                       
                                     echo ucwords($user["username"]);
                                     ?> <i class="mdi mdi-chevron-down"></i>
                                </span> 
                                
                                <span class="ms-1 d-none d-md-inline-block">
                                    <?=  wallet_model::getWalletAddress($user["id"]); ?> <i class="mdi mdi-chevron-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-user"></i>
                                    <span>My Account</span>
                                </a>
                                <a href="#" id="pinPop" class="dropdown-item notify-item">
                                    <i class="fe-user"></i>
                                    <span>Change Pin</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a class='dropdown-item notify-item' href='<?= BASE_URL ?>auth/logout'>
                                    <i class="fe-log-out"></i>
                                    <span>Logout</span>
                                </a>

                            </div>
                        </li>
          
                    </ul>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="pinChangeModal" tabindex="-1" aria-labelledby="pinChangeLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pinChangeLabel">Change Payment Pin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="pinChangeForm" >
            
                                <div class="mb-3">
                                    <label for="pin" class="form-label">New Pin</label>
                                    <input type="number" class="form-control" id="pin" name="pin" required>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="pin2" class="form-label">Comfirm Pin</label>
                                    <input type="number" class="form-control" id="pin2" name="pin2" required>
                                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?= $user_id ?>" required>
                                </div>
                            
                            </form>
                        </div>
                        <div class="modal-footer">
                            <!-- Pay with Wallet Button -->
                            <button id="pinButton"  type="button" form="paymentForm" class="btn text-light d-flex align-items-center" style="background-color:rgb(12, 80, 4);">
                                Change
                            </button>

                        </div>
                    </div>
                </div>
            </div>




<script>
    $(document).ready(function() {
        // Handle form submission

        $("#pinPop").click(function() {
            $('#pinChangeModal').modal('show');
        });


        $('#pinButton').click(function() {
            // Validate form inputs
            const pin = $('#pin').val();
            const pin2 = $('#pin2').val();

            if (pin === "" || pin2 === "") {
                alert("Please fill in all fields.");
                return;
            }

            if (pin !== pin2) {
                alert("Pins do not match.");
                return;
            }

            // Prepare form data
            const formData = {
                pin: pin,
                pin2: pin2,
                user_id: $('#user_id').val()
            };

            // Send AJAX request
            $.ajax({
                url: '<?= BASE_URL ?>wallet/changePin',
                type: 'POST',
                data: formData,
                success: function(response) {
                    try {
                        // Parse the response if it's a string
                        var jsonResponse = typeof response === "string" ? JSON.parse(response) : response;

                        // Check if the response has a status and message
                        if (jsonResponse.status !== undefined && jsonResponse.message !== undefined) {
                            alert(jsonResponse.message); // Show the message in an alert
                            window.location.reload();
                        } else {
                            console.error("Invalid response format", jsonResponse);
                            alert("Unexpected response from server.");
                        }
                    } catch (e) {
                        console.error("Invalid JSON response", e);
                        alert("Unexpected response from server.");
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                    var errorMessage = "An error occurred: ";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += xhr.responseJSON.message;
                    } else {
                        errorMessage += "Please try again.";
                    }
                    alert(errorMessage);
                    window.location.reload();
                }
            });
        });
    });
</script>

