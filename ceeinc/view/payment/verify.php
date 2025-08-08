<!-- ========== Topbar End ========== -->

<div class="px-3">
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="py-3 py-lg-4">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="page-title mb-0">Payment Verification</h4>
                </div>
                <div class="col-lg-6">
                    <div class="d-none d-lg-block">
                        <ol class="breadcrumb m-0 float-end">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Location</a></li>
                            <li class="breadcrumb-item active">Payment Verification</li>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="p-2">
                                    <form class="form-horizontal" role="form" method="GET" action="<?= BASE_URL ?>payment/show">
                                        <?php
                                        echo Session::ceedata("cip_payment_verify");
                                        Session::form_csfr();
                                        ?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="w-50 mx-auto">
                                                    <label class="col-form-label" for="simpleinput">Registration Number</label>
                                                    <input type="text" id="simpleinput" placeholder="" class="form-control p-2" name="location" required>
                                                    <div>
                                                        <label class="col-form-label" for="simpleinput">From Date(optional)</label>
                                                        <select class="form-select" id="year" name="from_year">
                                                            <option value=""></option>
                                                            <?php
                                                            $currentYear = date("Y");
                                                            for ($i = $currentYear - 10; $i <= $currentYear ; $i++) {
                                                                echo "<option value='$i'>$i</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label class="col-form-label" for="simpleinput">To Date(optional)</label>
                                                        <select class="form-select" id="year" name="to_year" >
                                                            <option value=""></option>
                                                            <?php
                                                            $currentYear = date("Y");
                                                            for ($i = $currentYear + 2; $i >= $currentYear - 10; $i--) {
                                                                echo "<option value='$i'>$i</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    
                                                    

                                                   <!-- Submit Button -->
                                                    <div class="mt-3">
                                                        <button type="submit" class="btn text-light w-md"  style="background-color:rgb(12, 80, 4);" >Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                      
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div> <!-- end card -->
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container -->
</div> <!-- content -->

<?php
Session::unset_ceedata("cip_payment_verify", "");
?>

