
                <!-- ========== Topbar End ========== -->

                <div class="px-3">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="py-3 py-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="page-title mb-0">Categories</h4>
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                                        <li class="breadcrumb-item active">Categories</li>
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
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Created Date</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
                                                <?php 
                                                    $categories = category_model::getCategories();
                                                    if(!empty($categories)) {
                                                        $sn = 1;
                                                        foreach($categories as $category) {
                                                ?>
                                                            <tr>
                                                                <td><?= $sn ?></td>
                                                                <td><?= $category['name'] ?></td>
                                                                <td><strike>N</strike><?= $category['amount'] ?></td>
                                                                <td>
                                                                    <?php
                                                                        if($category['status'] == 1) { 
                                                                            echo '<span class="badge bg-success">Active</span>';
                                                                        } else {
                                                                            echo '<span class="badge bg-danger">InActive</span>';
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td><?= Date::getDate($category["created_at"]) ?></td>
                                                            </tr>
                                                <?php 
                                                            $sn++;
                                                        }
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
