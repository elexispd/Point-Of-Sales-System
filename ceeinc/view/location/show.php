<?php 
$username = Input::get("id");
$username = Security::decrypt($username);

if (!empty($username)) {
    // Check if the username exists
    $location = location_model::getLocationByUsername($username);
    if ($location) {
         
    } else {
        // Username does not exist
        Session::set_ceedata("cip_verify", "<div class='cee_error'>Location not found.</div>");
        cee_matchapp::redirect("location/verify");
    }
} 
?>
                <!-- ========== Topbar End ========== -->

                <div class="px-3">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="py-3 py-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="page-title mb-0">Registration Successful</h4>
                                    <img src="<?= !empty($location['shop_photo']) ? $location['shop_photo'] : '' ?>" alt="Shop" class="mx-auto">
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Location</a></li>
                                        <li class="breadcrumb-item active">Verification</li>
                                    </ol>
                                   </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Location Details</h5>
                                        <?= Session::ceedata("cip_location"); ?>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Username</th>
                                                    <td><strong><?= htmlspecialchars($location['username']) ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <th>Business Name</th>
                                                    <td><?= htmlspecialchars($location['business_name']) ?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>Full Name(Contact)</th>
                                                    <td><?= htmlspecialchars($location['contact']) ?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>Road</th>
                                                    <td><?= htmlspecialchars($location['road']) ?></td>
                                                </tr>

                                                <tr>
                                                    <th>Shop</th>
                                                    <td><?= htmlspecialchars($location['shop_number']) ?></td>
                                                </tr>

                                                <tr>
                                                    <th>State of Origin</th>
                                                    <td><?= htmlspecialchars($location['state_of_origin']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>LGA of Origin</th>
                                                    <td><?= htmlspecialchars($location['lga_of_origin']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Town</th>
                                                    <td><?= htmlspecialchars($location['town']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Village</th>
                                                    <td><?= htmlspecialchars($location['village']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td><?= htmlspecialchars($location['address']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Category</th>
                                                    <td><?= htmlspecialchars(category_model::getCategoryById($location['category'])["name"]) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Created At</th>
                                                    <td><?= htmlspecialchars(Date::getDate($location["created_at"])) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>

                        <!-- end row-->


                        
                    </div> <!-- container -->

                </div> <!-- content -->

<?php
    Session::unset_ceedata("cip_location", "");
?>
