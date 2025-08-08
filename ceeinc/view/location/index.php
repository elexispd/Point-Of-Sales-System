
                <!-- ========== Topbar End ========== -->

                <div class="px-3">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="py-3 py-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="page-title mb-0">Locations</h4>
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                                        <li class="breadcrumb-item active">Locations</li>
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
                                       
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Business Name</th>
                                                <th>Reg Number</th>
                                                <th>Phone Number</th>
                                                <th>State of Origin</th>
                                                <th>Town</th>
                                                <th>Village</th>
                                                <th>Address</th>
                                                <th>Category</th> <!-- Updated to display category name -->
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                // Fetch locations from the model
                                                $locations = location_model::getLocations();
                                                if (!empty($locations)) {
                                                    $sn = 1;
                                                    foreach ($locations as $location) {
                                            ?>
                                                        <tr>
                                                            <td><?= $sn ?></td>
                                                            <td><?= $location['business_name'] ?></td>
                                                            <td><?= $location['username'] ?></td>
                                                            <td><?= $location['phone'] ?></td>
                                                            <td><?= $location['state_of_origin'] ?></td>
                                                            <td><?= $location['town'] ?></td>
                                                            <td><?= $location['village'] ?></td>
                                                            <td><?= $location['address'] ?></td>
                                                            <td><?= $location['category_name'] ?></td> <!-- Display category name -->
                                                            
                                                            <td><?= Date::getDate($location["created_at"]) ?></td>
                                                        </tr>
                                            <?php 
                                                        $sn++;
                                                    }
                                                } else {
                                                    // Display a message if no locations are found
                                                    echo '<tr><td colspan="12" class="text-center">No locations found.</td></tr>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->


                        
                    </div> <!-- container -->

                </div> <!-- content -->
