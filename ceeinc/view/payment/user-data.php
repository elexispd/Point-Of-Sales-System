<?php 
$username = Input::get("location");
if (!empty($username)) {
    // Check if the username exists
    $location = location_model::getLocationByUsername($username);
    if ($location) {
         
    } else {
        // Username does not exist
        Session::set_ceedata("cip_payment_verify", "<div class='cee_error'>Location not found.</div>");
        cee_matchapp::redirect("payment");
    }
} else {
    Session::set_ceedata("cip_payment_verify", "<div class='cee_error'>Please enter a registration number.</div>");
    cee_matchapp::redirect("payment");
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
                                    <h4 class="page-title mb-0">Location Detail</h4>
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Location</a></li>
                                        <li class="breadcrumb-item active">Verification</li>
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
                                        <h5 class="card-title">Location Details</h5>
                                        <?php 
                                            echo Session::ceedata("cip_payment");
                                        ?>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Registration Number</th>
                                                    <td><?= htmlspecialchars($location['username']) ?></td>
                                                </tr>

                                                <tr>
                                                    <th>Address</th>
                                                    <td><?= htmlspecialchars($location['address']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Category</th>
                                                    <td><?= htmlspecialchars(category_model::getCategoryById($location['category'])["name"]) ?></td>
                                                </tr>

                                                <tfoot>
                                                     <tr>
                                                        <th colspan="2">
                                                            <button type="button" class="btn text-light" style="background-color:rgb(12, 80, 4);" id="payButton">Pay</button>
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

                        <!-- Modal -->
                        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <form id="paymentForm" action="<?= BASE_URL ?>payment/verify_pin" method="POST">
                                            <?php 
                                                Session::form_csfr();
                                            ?>
                                            <div class="mb-3">
                                                <label for="amount" class="form-label">Amount</label>
                                                <input type="number" class="form-control" id="amount" name="amount" required>
                                                <input type="hidden" class="form-control" id="username" name="username" value="<?= $username ?>" required>
                                                <input type="hidden" class="form-control" id="agent" name="agent" value="<?= users_model::username(); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="year" class="form-label">Year</label>
                                                <select class="form-select" id="year" name="year" required>
                                                    <?php
                                                    $currentYear = date("Y");
                                                    for ($i = $currentYear + 2; $i >= $currentYear - 10; $i--) {
                                                        echo "<option value='$i'>$i</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- Pay with Wallet Button -->
                                        <button type="submit" form="paymentForm" class="btn text-light d-flex align-items-center" style="background-color:rgb(12, 80, 4);">
                                            <i class='bx bx-wallet me-2'></i> Pay with Wallet
                                        </button>

                                        <!-- Pay with Card Button (Disabled) -->
                                        <button type="button" class="btn btn-secondary d-flex align-items-center" disabled>
                                            <i class='bx bx-credit-card me-2'></i> Pay Direct
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <?php        
    Session::unset_ceedata("cip_payment","");
?>

<script>

$(document).ready(function() {
    // Show modal when Pay button is clicked
    $('#payButton').click(function() {
        // Fetch location details via AJAX
        $.ajax({
            url: '<?= BASE_URL ?>location/getLocation',
            type: 'GET',
            data: {
                username: '<?= htmlspecialchars($location['username']) ?>' // Pass the username from PHP
            },
            success: function(response) {
                if (response) {
                    // Parse the JSON response
                    var location = JSON.parse(response);

                    // Prefill category and amount inputs
                    $('#category').val(location.category_name); // Assuming you have an input with id "category"
                    $('#amount').val(location.amount).prop('readonly', true);

                    // Show the modal
                    $('#paymentModal').modal('show');
                } else {
                    alert('Location not found.');
                }
            },
            error: function() {
                alert('Error fetching location details.');
            }
        });
    });
});



</script>
