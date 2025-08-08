<?php 

if(!isset($_GET["village"]) && !isset($_GET["from_year"]) &&!isset($_GET["to_year"]) && !isset($_GET["cee_csfr_security"]) &&  !isset($_GET["cee_csfr_controller"])  ) {
    cee_matchapp::redirect("analysis");
} else {
    $village = Input::get('village');
    $from = Input::get('from_year');
    $to = Input::get('to_year');
    // $users = payment_model::getUsersByVillage($village);
    Session::confir_get_csfr();
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
                                    <h4 class="page-title mb-0">Analysis By Village - <?= $village ?></h4> <br>
                                    <h5 class="page-title mb-0">From  <?= $from. " - " . $to ?> </h5>
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
                                       
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Business Name</th>
                                                <th>Reg Number</th>                                 
                                                <th>Address</th>
                                                <th>Category</th> 
                                                <th>Amount</th>
                                                <th>Payment Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>John Doe</td>
                                                <td>ORNN/001</td>
                                                <td>Umueme</td>
                                                <td>12, Latiff</td>
                                                <td>₦50,000</td>
                                                <td>2024-02-20</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Jane Doe</td>
                                                <td>ORNN/002</td>
                                                <td>Umueme</td>
                                                <td>12, Latiff</td>
                                                <td>₦100,000</td>
                                                <td>2024-02-20</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Mike Doe</td>
                                                <td>ORNN/003</td>
                                                <td>Umueme</td>
                                                <td>12, Latiff</td>
                                                <td>₦150,000</td>
                                                <td>2024-02-20</td>
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
