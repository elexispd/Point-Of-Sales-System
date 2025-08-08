
                <!-- ========== Topbar End ========== -->

                <div class="px-3">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="py-3 py-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="page-title mb-0">Change Password</h4>
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                        <li class="breadcrumb-item active">Password</li>
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
                                        <p class="sub-header">
                                           Reset Password
                                        </p>
    
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="p-2">
                                                    <form class="form-horizontal" role="form" method="POST" action="<?= BASE_URL ?>users/changeMyPasswordProcess" >
                                                    <?php 
                                                        Session::form_csfr(); 
                                                        echo Session::ceedata("cip_reset_password");
                                                    ?>

                                                        <div class="mb-2 row">
                                                            <label class="col-md-12 col-form-label" for="simpleinput">New Password</label>
                                                            <div class="col-md-10">
                                                                <input type="password" id="simpleinput"  class="form-control" name="new_pass">
                                                            </div>
                                                        </div>
                                                        <div class="mb-2 row">
                                                            <label class="col-md-12 col-form-label" for="example-email">Confirm Password</label>
                                                            <div class="col-md-10">
                                                                <input type="password" id="example-email" placeholder="" class="form-control" name="new_pass2">
                                                            </div>
                                                        </div>
                                                          
                                                        <div>
                                                            <button type="submit" class="btn w-md text-light " style="background:rgb(12, 80, 4);" >Reset</button>
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
    Session::unset_ceedata("cip_reset_password","");
?>