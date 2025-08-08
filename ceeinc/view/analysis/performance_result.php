<?php 

$username = Input::post("agent");
$agent = users_model::getUserByUsername($username);
if (empty($agent)) {
    Session::set_ceedata("cip_analysis", "<div class='cee_error'>Agent: " . htmlspecialchars($username) . " not found.</div>");
    cee_matchapp::redirect("analysis/performance");
}
if(isset($_POST["pay"])) {
    $payments = payment_model::getPaymentsByAgent($username, $from_date = null, $to_date = null);
    $locations = 0;
} elseif(isset($_POST["registration"])) {
    $locations = location_model::getLocationsByAgent($username, $from_date = null, $to_date = null);
    $payments = 0;
} else {
    Session::set_ceedata("cip_analysis", "<div class='cee_error'>Invalid Request</div>");
    cee_matchapp::redirect("analysis/performance");
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
                                    <h4 class="page-title mb-0">Analysis For <?= $agent["full_name"] ?> Perfomance </h4> <br>
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                                        <li class="breadcrumb-item active">Analysis</li>
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
                                    
                                    <?php 
                                    if($locations === 0) { ?>                                      
                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Business Name</th>
                                                    <th>Business Number</th>                                 
                                                    <th>Year</th>
                                                    <th>Amount</th>
                                                    <th>Payment Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            $sn = 1;
                                            foreach($payments as $payment) { 
                                                ?>
                                                <tr>
                                                    <td><?= $sn++ ?></td>
                                                    <td><?= htmlspecialchars($payment["business_name"]) ?></td>
                                                    <td><?= htmlspecialchars($payment["location"]) ?></td>
                                                    <td><?= htmlspecialchars($payment["year"]) ?></td>
                                                    <td><?= htmlspecialchars(number_format($payment["amount"], 2)) ?></td>
                                                    <td><?= htmlspecialchars(Date::getDate($payment["created_at"])) ?></td>
                                                </tr>
                                            <?php }
                                            ?>
                                            </tbody>
                                        </table>
                                    <?php } elseif($payments === 0) { ?>
                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Business Name</th>
                                                    <th>Business Number</th>                                 
                                                    <th>Category</th>                                 
                                                    <th>Town</th>
                                                    <th>Village</th>
                                                    <th>Address</th>
                                                    <th>Road/Number</th>
                                                    <th>Reg Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            $sn = 1;
                                            foreach($locations as $location) { 
                                                ?>
                                                <tr>
                                                    <td><?= $sn++ ?></td>
                                                    <td><?= htmlspecialchars($location["business_name"]) ?></td>
                                                    <td><?= htmlspecialchars($location["username"]) ?></td>
                                                    <td><?= htmlspecialchars($location["category_name"]) ?></td>
                                                    <td><?= htmlspecialchars($location["town"]) ?></td>
                                                    <td><?= htmlspecialchars($location["village"]) ?></td>
                                                    <td><?= htmlspecialchars($location["address"]) ?></td>
                                                    <td><?= htmlspecialchars($location["road"] . " - ". $location["shop_number"]  ) ?></td>
                                                    <td><?= htmlspecialchars(Date::getDate($location["created_at"])) ?></td>
                                                </tr>
                                            <?php }
                                            ?>
                                            </tbody>
                                        </table>
                                    <?php } ?>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->


                        
                    </div> <!-- container -->

                </div> <!-- content -->
