<!-- ========== Topbar End ========== -->

<div class="px-3">
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="py-3 py-lg-4">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="page-title mb-0">Search For User</h4>
                </div>
                <div class="col-lg-6">
                    <div class="d-none d-lg-block">
                        <ol class="breadcrumb m-0 float-end">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                            <li class="breadcrumb-item active">Search User</li>
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
                                    <form class="form-horizontal" role="form" method="POST" action="<?= BASE_URL ?>users/search_result">
                                        <?php
                                        Session::form_csfr();
                                        echo Session::ceedata("cip_search");
                                        ?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="w-50 mx-auto">
                                                    <label class="col-form-label" for="simpleinput">Username</label>
                                                    <input type="text" id="simpleinput" placeholder="" class="form-control p-3" name="username">

                                                    <!-- Submit Button -->
                                                    <div class="mt-3">
                                                        <button type="submit" style="background:rgb(12, 80, 4);"class="btn btn-primary w-md">Search</button>
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
Session::unset_ceedata("cip_search", "");
?>

