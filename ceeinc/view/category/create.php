
                <!-- ========== Topbar End ========== -->

                <div class="px-3">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="py-3 py-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="page-title mb-0">Create Category</h4>
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                        <li class="breadcrumb-item active">Category</li>
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
                                           Register new category here
                                        </p>
    
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="p-2">
                                                    <form class="form-horizontal" role="form" method="POST" action="<?= BASE_URL ?>category/store" >
                                                    <?php 
                                                        Session::form_csfr(); 
                                                        echo Session::ceedata("cip_category");
                                                    ?>

                                                        <div class="mb-2 row">
                                                            <label class="col-md-12 col-form-label" for="simpleinput">Name</label>
                                                            <div class="col-md-10">
                                                                <input type="text" id="simpleinput" placeholder="Bakery house license" class="form-control" name="name">
                                                            </div>
                                                        </div>
                                                        <div class="mb-2 row">
                                                            <label class="col-md-12 col-form-label" for="example-email">Amount</label>
                                                            <div class="col-md-10">
                                                                <input type="number" id="example-email" placeholder="" class="form-control" name="amount">
                                                            </div>
                                                        </div>
                                                          
                                                        <div>
                                                            <button type="submit" class="btn w-md text-light " style="background:rgb(12, 80, 4);" >Submit</button>
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
    Session::unset_ceedata("cip_category","");
?>