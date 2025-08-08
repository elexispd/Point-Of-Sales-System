<?php 

if(!isset($_GET["town"]) && !isset($_GET["cee_csfr_security"]) &&  !isset($_GET["cee_csfr_controller"])  ) {
    cee_matchapp::redirect("analysis");
} else {
    $town = Input::get('town');
    $locations = location_model::getLocationByTown($town);
    // Session::confir_get_csfr();
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
                                    <h4 class="page-title mb-0">Result</h4>
                                </div>
                                <div class="col-lg-6">
                                   <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                                        <li class="breadcrumb-item active">Analysis</li>
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
                                                <th>Full Name</th>
                                                <th>Reg Number</th>
                                                <th>Category</th> 
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if (!empty($locations)) {
                                                    $sn = 1;
                                                    foreach ($locations as $location) {
                                            ?>
                                                        <tr data-id="<?= $location['id'] ?>">
                                                            <td><?= $sn ?></td>
                                                            <td><?= $location['business_name'] ?></td>
                                                            <td><?= $location['username'] ?></td>
                                                            <td><?= $location['category_name'] ?></td>
                                                            <td>
                                                                <a href="#" class="view-details" data-username="<?= $location['username'] ?>" data-bs-toggle="modal" data-bs-target="#locationModal">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                            <?php 
                                                        $sn++;
                                                    }
                                                } else {
                                                    echo '<tr><td colspan="12" class="text-center">No locations found.</td></tr>';
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
<div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="yearSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="yearSelectionModalLabel">Location Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.view-details').on('click', function(e) {
        e.preventDefault(); 
        var username = $(this).data('username');

        let baseUrl = '<?= BASE_URL ?>location/getLocationByUsername'


        $.ajax({
            url: baseUrl, 
            type: 'GET',
            data: { username: username },
            success: function(response) {
                // Parse the JSON response
                var location = JSON.parse(response);
                console.log(response);

                // Populate the modal with the fetched details
                $('#locationModal .modal-body').html(`
                    <p><strong>Business Name:</strong> ${location.business_name}</p>
                    <p><strong>Username:</strong> ${location.username}</p>
                    <p><strong>Phone:</strong> ${location.phone}</p>
                    <p><strong>State of Origin:</strong> ${location.state_of_origin}</p>
                    <p><strong>LGA of Origin:</strong> ${location.lga_of_origin}</p>
                    <p><strong>Town:</strong> ${location.town}</p>
                    <p><strong>Village:</strong> ${location.village}</p>
                    <p><strong>Address:</strong> ${location.address}</p>
                    <p><strong>Category:</strong> ${location.category_name}</p>
                    <p><strong>Registra:</strong> ${location.registra}</p>
                    <p><strong>Created At:</strong> ${location.created_at}</p>
                `);

                // Show the modal
                $('#locationModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching location details:', error);
            }
        });
    });
});
</script>