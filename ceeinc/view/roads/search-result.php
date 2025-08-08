<?php 

$town = Input::get('town');
$village = Input::get('village');
?>
                <!-- ========== Topbar End ========== -->

                <div class="px-3">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="py-3 py-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="page-title mb-0">Road In <?= $town . " " . $village ?> </h4>
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
                                                <th>Name</th>                                             
                                                <th>Registrar</th> <!-- Updated to display category name -->
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                
                                                $roads = roads_model::getRoadByTownVillage($town,$village);
                                                if (!empty($roads)) {
                                                    $sn = 1;
                                                    foreach ($roads as $road) {
                                            ?>
                                                        <tr>
                                                            <td><?= $sn ?></td>
                                                            <td><?= $road['road'] ?></td>
                                                            <td><?= $road['creator'] ?></td>                                                           
                                                            <td><?= Date::getDate($road["created_at"]) ?></td>
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
