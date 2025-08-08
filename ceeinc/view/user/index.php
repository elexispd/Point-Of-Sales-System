
                <!-- ========== Topbar End ========== -->

                <div class="px-3">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="py-3 py-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="page-title mb-0">Staff</h4>
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                                        <li class="breadcrumb-item active">Staff</li>
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
                                    Session::form_csfr();
                                    echo Session::ceedata("cip_user");
                                    ?>
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Full Name</th>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                // Fetch users from the model
                                                $users = users_model::getUsers();
                                                if (!empty($users)) {
                                                    $sn = 1;
                                                    foreach ($users as $user) {
                                            ?>
                                                        <tr>
                                                            <td><?= $sn ?></td>
                                                            <td><?= ucwords($user['full_name']) ?></td>
                                                            <td><?= ucwords($user['username']) ?></td>
                                                            <td><?= ucwords($user['role']) ?></td>
                                                            <td><?= Date::getDate($user["created_at"]) ?></td>
                                                            <td>
                                                                <?php 
                                                                    if($user["status"] == 1) {
                                                                     ?>
                                                                    <a href="#" class="btn btn-sm btn-success" >Active</a>
                                                                    <?php } else { ?>
                                                                        <a href="#" class="btn btn-sm btn-danger" >InActive</a>
                                                                    <?php }
                                                                ?>
                                                                <a href="<?= BASE_URL ?>users/show?q=<?= Security::encrypt($user["username"]) ?>" class="btn btn-sm btn-secondary">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                            <?php 
                                                        $sn++;
                                                    }
                                                } else {
                                                    // Display a message if no users are found
                                                    echo '<tr><td colspan="12" class="text-center">No users found.</td></tr>';
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
                <?php
Session::unset_ceedata("cip_user", "");
?>