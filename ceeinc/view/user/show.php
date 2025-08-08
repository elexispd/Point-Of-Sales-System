<?php 
$username = Input::get("q");
$username = Security::decrypt($username);

if (!empty($username)) {
    // Check if the username exists
    $user = users_model::getUserByUsername($username);

    $user_info = users_model::getUserInfoById($user["id"]);
    if ($user) {
         
    } else {
        // Username does not exist
        // Session::set_ceedata("cip_user", "<div class='cee_error'>User not found.</div>");
        // cee_matchapp::redirect("users");
    }
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
                                    <h4 class="page-title mb-0">User Detail</h4>
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                        <li class="breadcrumb-item active">Detail</li>
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
                                        <h5 class="card-title">User Details</h5>
                                        <?= Session::ceedata("cip_user"); ?>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Full name</th>
                                                    <td><strong><?= htmlspecialchars($user['full_name']) ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <th>Username</th>
                                                    <td><strong><?= htmlspecialchars($user['username']) ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <th>Phone Number</th>
                                                    <td><?= ($user['phone']) ?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>Wallet Address</th>
                                                    <td><?= htmlspecialchars($user['wallet']) ?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>BVN</th>
                                                    <td> <a href="#"><?= $user_info['bvn'] ?></a> </td>
                                                </tr>

                                                <tr>
                                                    <th>Nin</th>
                                                    <td> <a href="<?= BASE_URL .htmlspecialchars($user_info['nin']) ?>">
                                                        <i class="fa fa-file"></i>
                                                    </a> </td>
                                                </tr>

                                                <tr>
                                                    <th>Nepa</th>
                                                    <td> <a href="<?= BASE_URL .htmlspecialchars($user_info['nepa']) ?>">
                                                        <i class="fa fa-file"></i>
                                                    </a> </td>
                                                </tr>

                                                <tr>
                                                    <th>CAC</th>
                                                    <td> <a href="<?= BASE_URL .htmlspecialchars($user_info['cac']) ?>">
                                                        <i class="fa fa-file"></i>
                                                    </a> </td>
                                                </tr>

                                                <tr>
                                                    <th>ANSSID</th>
                                                    <td><?= htmlspecialchars($user_info['ansid']) ?></td>
                                                </tr>

                                                <tr>
                                                    <th>Account Number</th>
                                                    <td><?= htmlspecialchars($user_info['account_number']) ?></td>
                                                </tr>

                                                <tr>
                                                    <th>Bank</th>
                                                    <td><?= htmlspecialchars(wallet_model::getBankData($user_info['bank']) ); ?></td>
                                                </tr>

                                                
                                                <tr>
                                                    <th>Created At</th>
                                                    <td><?= htmlspecialchars(Date::getDate($user["created_at"])) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>
                                                        <?php 
                                                            if($user["status"] == 1) { ?>
                                                            <span class="badge bg-success">Active</span>
                                                           <?php } else if($user["status"] == 0)  { ?>
                                                            <span class="badge bg-info">Pending</span>
                                                           <?php } else { ?>
                                                            <span class="badge bg-danger">Declined</span>
                                                          <?php }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div>
                                            <form action="<?= BASE_URL ?>users/updateStatus" method="post">
                                            <input type="hidden" name="user_id" value="<?= $user["id"] ?>">
                                                <?php 
                                                 Session::form_csfr();
                                                ?>
                                                <?php 
                                                    if($user["status"] == 1) { ?>
                                                        
                                                        <button name="decline" class="btn btn-danger" type="submit">Disactive/Decline</button>
                                                    <?php } else { ?>
                                                        <button name="accept" class="btn btn-success" type="submit">Approve</button>
                                                    <?php }
                                                ?>
                                            </form>
                                            <a href="#" class="view-details btn btn-info" data-user="<?= $user_info['user_id'] ?>" data-bs-toggle="modal" data-bs-target="#AccountModal">
                                                Change Account
                                            </a>
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>

                        <!-- end row-->


                        
                    </div> <!-- container -->

                </div> <!-- content -->
<div class="modal fade" id="AccountModal" tabindex="-1" aria-labelledby="yearSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="yearSelectionModalLabel">Account Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="<?= BASE_URL ?>users/changeBank" method="POST">
                    <?php
                        session::form_csfr();
                    ?>
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label class="col-form-label" for="account_number">BANK NAME</label>
                            <select name="bank" id="bank" class="form-control">
                                <option value="">Select Bank</option>
                                <?php 
                                $banks = wallet_model::getBankList();
                                foreach($banks as $bank) {?>
                                    <option value="<?= $bank['code']?>"><?= $bank['name']?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label class="col-form-label" for="account_number">ACCOUNT NUMBER</label>
                            <input type="number" maxlength="11" name="account_number" class="form-control">
                            <input type="hidden" value="<?= Input::get('q'); ?>" name="user" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <span id="result"></span>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" style="background:rgb(12, 80, 4);" class="btn btn-primary" name="submit" >Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                   
                </form>
                
                
            </div>

            
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Listen for changes in the account number input
        $('input[name="account_number"]').on('input', function() {
            const bankCode = $('#bank').val(); // Get the selected bank code
            const accountNumber = $(this).val(); // Get the typed account number

            // Ensure both bank and account number are provided
            if (bankCode && accountNumber && accountNumber.length === 10) {
                // Show "Fetching details..." message
                $('#result').html('<div class="alert alert-info">Fetching details...</div>');

                // Send AJAX request to get bank account details
                $.ajax({
                    url: '<?= BASE_URL ?>wallet_api/getBankDetails',
                    type: 'GET',
                    data: {
                        bank_code: bankCode,
                        acctno: accountNumber
                    },
                    success: function(response) {
                        try {
                            const jsonResponse = typeof response === "string" ? JSON.parse(response) : response;

                            if (jsonResponse.status === 1) {
                                // Display the account name in the #result section
                                const accountName = jsonResponse.data.data.accountName;
                                $('#result').html(`<div class="alert alert-success">Account Name: ${accountName}</div>`);
                            } else {
                                // Display error message
                                $('#result').html(`<div class="alert alert-danger">${jsonResponse.message}</div>`);
                            }
                        } catch (e) {
                            console.error("Invalid JSON response", e);
                            $('#result').html('<div class="alert alert-danger">Account Could not be retrieved.</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#result').html(`<div class="alert alert-danger">An error occurred: ${xhr.responseJSON?.message || "Please try again."}</div>`);
                    }
                });
            } else {
                // Clear the result section if inputs are incomplete
                $('#result').html('');
            }
        });
    });
</script>

<?php
    Session::unset_ceedata("cip_user", "");
?>
