<?php  
$username = Input::get("location");
$from_date = Input::get("from_year");
$to_date = Input::get("to_year");
$paymentHistory = payment_model::getPaymentHistory($username, $from_date, $to_date);
?>
                <!-- ========== Topbar End ========== -->

                <div class="px-3">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="py-3 py-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="page-title mb-0">Payment History</h4>
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                                        <li class="breadcrumb-item active">Payment</li>
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
                                        <!-- <div class="d-flex justify-content-between">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#yearSelectionModal">
                                                <button class="btn text-light btn-sm" style="background-color: navy;">Print Demand Of Notice</button>
                                            </a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#demandNoticeModal">
                                                <button class="btn text-light btn-sm" style="background-color: navy;">Check Demand Of Notice</button>
                                            </a>
                                        </div> -->
                                    
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Business Name</th>
                                                <th>Reg Number</th>
                                                <th>Address</th>
                                                <th>Amount</th>
                                                <th>Year</th>
                                                <th>Payment Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php  
                                            $sn = 1;
                                             foreach ($paymentHistory as $payment) {
                                                $location = location_model::getLocationByUsername($payment["location"]);
                                                ?>
                                                <tr>
                                                     <td><?= $sn;?></td>
                                                     <td><?= $location["business_name"]; ?></td>
                                                     <td><?= $payment["location"];?></td>
                                                     <td><?= $location["address"];?></td>
                                                     <td><strike>N</strike><?= $payment["amount"];?></td>
                                                     <td><?= $payment["year"];?></td>
                                                     <td><?= Date::getDate($payment["created_at"])  ?></td>
                                                     <td>
                                                        <a href="<?= BASE_URL ?>payment/receipt?id=<?= Security::encrypt($payment["receipt_no"]) ?>">
                                                            <button class="btn text-light btn-sm" style="background-color: navy;">View Receipt</button>
                                                        </a>
                                                     </td>
                                                 </tr>
                                                </tr>
                                             <?php
                                             $sn++;
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



<!-- Hidden Input for Username -->
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
<div class="modal fade" id="demandNoticeModal" tabindex="-1" aria-labelledby="yearSelectionModalLabel" aria-hidden="true">
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
                        <select class="form-select" id="check_year" name="check_year" required>
                            <option value="">Select Year</option>
                            <?php
                            $currentYear = date("Y");
                            for ($i = $currentYear; $i >= $currentYear - 10; $i--) {
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="checkDemandNotice" class="btn text-light" style="background-color: navy;">Print</button>
            </div>
        </div>
    </div>
</div>


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

    $('#checkDemandNotice').click(function() {
        // Get the selected year, deadline, and username
        var year = $('#check_year').val();
        var username = $('#username').val();

        window.location.href = '<?= BASE_URL ?>payment/demandNotice?location=' + encodeURIComponent(username) + '&year=' + year;

        
   
    });


});
</script>