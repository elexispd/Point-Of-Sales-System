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
                                    <h4 class="page-title mb-0">Demand Notice</h4>
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Location</a></li>
                                        <li class="breadcrumb-item active">Demand Notice</li>
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
                                        <h5 class="card-title">Demand Notice</h5>
                                        <?php 
                                            echo Session::ceedata("cip_demand");
                                        ?>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Registration Number</th>
                                                    <td><?= htmlspecialchars($location['username']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Business Name</th>
                                                    <td><?= htmlspecialchars($location['business_name']) ?></td>
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
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#yearSelectionModal" class="btn text-light" style="background-color:rgb(12, 80, 4);" id="payButton">Print Notice</button>
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

                        <input type="hidden" id="username" value="<?= Security::encrypt($username) ?>">

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
                                        <form id="yearSelectionForm">
                                            <div class="mb-3">
                                                <label for="year" class="form-label">Year</label>
                                                <select class="form-select" id="year" name="year" required>
                                                    <option value="">Select Year</option>
                                                    <?php
                                                    $currentYear = date("Y");
                                                    for ($i = $currentYear; $i >= $currentYear - 2; $i--) {
                                                        echo "<option value='$i'>$i</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="deadline" class="form-label">Deadline</label>
                                                <input type="date" class="form-control" id="deadline" placeholder="dd-mm-yyyy" name="deadline" required>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" id="printDemandNotice" class="btn text-light" style="background-color: navy;">Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <?php        
    Session::unset_ceedata("cip_demand","");
?>



<script>
$(document).ready(function() {
    // Handle Print Button Click
    $('#printDemandNotice').click(function() {
        // Get the selected year, deadline, and username
        var year = $('#year').val();
        var deadline = $('#deadline').val();
        var username = $('#username').val();

        

        // Send an AJAX request to demandProcess
        $.ajax({
            url: '<?= BASE_URL ?>payment/demandProcess',
            type: 'POST',
            data: {
                year: year,
                location: username,
                deadline: deadline,
                cee_csfr_security: '<?= Input::get("cee_csfr_security") ?>', // Include CSRF token
                cee_csfr_controller: '<?= Input::get("cee_csfr_controller") ?>' // Include CSRF token
            },
            success: function(response) {
                // Parse the JSON response
                var result = JSON.parse(response);

                if (result.status === 1) {
                    window.location.href = '<?= BASE_URL ?>payment/demandNotice?location=' + encodeURIComponent(username) + '&year=' + year;
                } else {
                    // Display error message
                    alert(result.message || "Failed to process demand notice.");
                }
            },
            error: function() {
                // Handle AJAX error
                alert("An error occurred while processing your request.");
            }
        });
    });



});
</script>