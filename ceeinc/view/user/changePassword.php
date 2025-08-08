<?php 
$username = Input::post("username");
if (!empty($username)) {
    // Check if the username exists
    $user = users_model::getUserByUsername($username);
    if ($user) {
         
    } else {
        // Username does not exist
        Session::set_ceedata("cip_search", "<div class='cee_error'>User not found.</div>");
        cee_matchapp::redirect("users/search");
    }
} else {
    Session::set_ceedata("cip_search", "<div class='cee_error'>Please enter a username.</div>");
    cee_matchapp::redirect("users/search");
    return;
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
                                    <h4 class="page-title mb-0">User</h4>
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                                        <li class="breadcrumb-item active">Reset Password</li>
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
                                        <h5 class="card-title">Reset Password</h5>
                                        
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <td><?= htmlspecialchars(ucwords($user['full_name'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Username</th>
                                                    <td><?= htmlspecialchars(ucwords($user['username'])) ?></td>
                                                </tr>

                                                <tr>
                                                    <th>Role</th>
                                                    <td><?= htmlspecialchars(ucwords($user['role'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Phone</th>
                                                    <td><?= htmlspecialchars(ucwords($user["phone"])) ?></td>
                                                </tr>

                                                <tfoot>
                                                     <tr>
                                                        <th colspan="2">
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#yearSelectionModal" class="btn text-light" style="background-color:rgb(12, 80, 4);" id="payButton">Reset Password</button>
                                                        </th>
                                                     </tr>
                                                </tfoot>
                                                
                                            </tbody>
                                        </table>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>

                        <!-- end row-->



                        <!-- Year Selection Modal -->
                        <div class="modal fade" id="yearSelectionModal" tabindex="-1" aria-labelledby="yearSelectionModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="yearSelectionModalLabel">Select Year</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form id="yearSelectionForm" method="POST" action="<?= BASE_URL ?>users/changeUserPasswordProccess" >
                                            <?php Session::form_csfr(); ?>
                                            <div class="mb-3">
                                                <label for="year" class="form-label">New Password</label>
                                                <input type="password" class="form-control" id="year" placeholder="Enter New Password" name="password" required>
                                                <input type="hidden" name="username" value="<?= $username ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="deadline" class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" id="deadline" placeholder="Confirm New Password" name="confirm_password" required>
                                            </div>
                                            <div class="footer d-flex justify-content-between">
                                                <button type="submit" id="printDemandNotice" class="btn text-light" style="background:rgb(12, 80, 4);">Reset</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>          
                                            </div>
                                        </form>
                                        
                                    </div>

                                  
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <?php        

?>


