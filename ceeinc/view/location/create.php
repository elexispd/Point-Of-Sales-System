<!-- ========== Topbar End ========== -->

<div class="px-3">
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="py-3 py-lg-4">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="page-title mb-0">Register Location</h4>
                </div>
                <div class="col-lg-6">
                    <div class="d-none d-lg-block">
                        <ol class="breadcrumb m-0 float-end">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Location</li>
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
                        <p class="sub-header">Register Location</p>

                        <div class="row">
                            <div class="col-12">
                                <div class="p-2">
                                    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="<?= BASE_URL ?>location/store">
                                        <?php
                                        Session::form_csfr();
                                        echo Session::ceedata("cip_location");
                                        ?>

                                        <!-- Row 1: Full Name and State of Origin -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="col-form-label" for="simpleinput">Business Name</label>
                                                    <input type="text" id="simpleinput" placeholder="" class="form-control" name="business_name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="col-form-label" for="simpleinput">Full Name (contact)</label>
                                                    <input type="text" id="simpleinput" placeholder="" class="form-control" name="contact">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="col-form-label" for="simpleinput">Email (optional)</label>
                                                    <input type="email" id="simpleinput" placeholder="" class="form-control" name="email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="col-form-label" for="state_of_origin">State of Origin</label>
                                                    <select name="state_of_origin" id="state_of_origin" class="form-control">
                                                        <option value="" selected></option>
                                                        <?php
                                                        $states = [
                                                            "Abia", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa",
                                                            "Benue", "Borno", "Cross River", "Delta", "Ebonyi", "Edo",
                                                            "Ekiti", "Enugu", "FCT", "Gombe", "Imo", "Jigawa",
                                                            "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara",
                                                            "Lagos", "Nasarawa", "Niger", "Ogun", "Ondo", "Osun",
                                                            "Oyo", "Plateau", "Rivers", "Sokoto", "Taraba", "Yobe",
                                                            "Zamfara"
                                                        ];

                                                        foreach ($states as $state) {
                                                            echo "<option value='$state'>$state</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="col-form-label" for="lga_of_origin">LGA of Origin</label>
                                                    <select name="lga_of_origin" class="form-control" id="lga_of_origin">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Row 2: LGA of Origin and Location -->
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="col-form-label" for="lga_of_origin">Phone Number</label>
                                                    <input type="tel" id="lga_of_origin" placeholder="" class="form-control" name="phone" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="col-form-label" for="town">Location (Town)</label>
                                                    <select name="town" id="town" class="form-control" required>
                                                        <option value="" selected disabled>Select Town</option>
                                                        <?php
                                                        $towns = location_model::getTowns();
                                                        foreach ($towns as $town) { ?>
                                                            <option value="<?= $town ?>"><?= $town ?></option>";
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                          
                                        </div>

                                        <!-- Row 3: Town and Village -->
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="col-form-label" for="village">Location (Village)</label>
                                                    <select name="village" id="village" class="form-control" required>
                                                        <option value="" selected disabled>Select Village</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold" for="category">Category</label>
                                                    <select name="category" id="category" class="form-select" required aria-describedby="categoryHelp">
                                                        <option value="" selected disabled>Select Category</option>
                                                        <?php
                                                        $categories = category_model::getCategories();
                                                        foreach ($categories as $category) { ?>
                                                            <option value='<?= htmlspecialchars($category["id"]) ?>'>
                                                                <?= htmlspecialchars($category["name"]) ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div id="categoryHelp" class="form-text">Choose the appropriate category</div>
                                                    
                                                    <div class="form-check mt-2">
                                                        <input type="checkbox" class="form-check-input" name="mobile_shop" id="mobile_shop">
                                                        <label class="form-check-label" for="mobile_shop">Is Mobile</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Row 5: Category -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="col-form-label" for="address">Address</label>
                                                    <textarea name="address" class="form-control" id="address" required></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="col-form-label" for="road">Roads</label>
                                                    <select name="road" id="road" class="form-control" required>
                                                        <option value="" selected disabled>Select Road</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6" id="shopNumberContainer">
                                                <div class="mb-2">
                                                    <label class="col-form-label" for="address">Shop Number</label>
                                                    <input type="number" name="shop"  class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="col-form-label" for="address">Upload Photo</label>
                                                    <input type="file" name="shop_photo"  class="form-control">
                                                </div>
                                            </div>
                                            
                                            
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="mt-3">
                                            <button style="background-color:rgb(12, 80, 4); border: none;" type="submit" class="btn btn-primary w-md">Submit</button>
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

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay" style="display: none;">
    <div class="spinner-container">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Loading villages...</p>
    </div>
</div>

<style>
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
.spinner-container {
    text-align: center;
    color: white;
}
</style>

<?php
Session::unset_ceedata("cip_location", "");
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
$(document).ready(function() {
    // When town selection changes
    $('#town').change(function() {
        var selectedTown = $(this).val();
        
        // Clear previous villages and disable dropdown
        $('#village').html('<option value="" selected disabled>Loading villages...</option>').prop('disabled', true);
        
        if (selectedTown) {
            // Show loading overlay
            $('#loadingOverlay').show();
            
            // Make AJAX request to get villages
            $.ajax({
                url: '<?= BASE_URL ?>location/getVillages',
                type: 'POST',
                data: { town: selectedTown },
                dataType: 'json',
                success: function(response) {
                    // Rebuild village options
                    $('#village').html('<option value="" selected disabled>Select Village</option>');
                    
                    if (response && response.length > 0) {
                        // Add each village as an option
                        $.each(response, function(index, village) {
                            $('#village').append($('<option>', {
                                value: village,
                                text: village
                            }));
                        });
                    } else {
                        $('#village').append($('<option>', {
                            value: '',
                            text: 'No villages found'
                        }));
                    }
                    
                    // Enable dropdown
                    $('#village').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    $('#village').html('<option value="" selected disabled>Error loading villages</option>');
                },
                complete: function() {
                    // Hide loading overlay regardless of success/error
                    $('#loadingOverlay').hide();
                }
            });
        } else {
            // Reset village dropdown if no town selected
            $('#village').html('<option value="" selected disabled>Select Village</option>').prop('disabled', true);
        }
    });
});
</script>



<script>
    $(document).ready(function() {
        // Attach an event listener to the state dropdown
        $('#state_of_origin').on('change', function() {
            // Get the selected state value
            var selectedState = $(this).val();

            // Clear the LGA dropdown
            $('#lga_of_origin').empty().append('<option value=""></option>');

            // Check if a state is selected
            if (selectedState) {
                // Send an AJAX request to the server
                $.ajax({
                    url: '<?= BASE_URL ?>location_api/getLGA', 
                    type: 'GET',
                    data: { state: selectedState },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 1) {
                            // Populate the LGA dropdown with the retrieved data
                            $.each(response.data, function(index, lga) {
                                $('#lga_of_origin').append('<option value="' + lga + '">' + lga + '</option>');
                            });
                        } else {
                            // Handle errors (e.g., state not found)
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors
                        console.error("AJAX Error: " + status + error);
                    }
                });
            }
        });
    });
</script>


<script>

$(document).ready(function() {
    $('#village').on('change', function() {
        const town = $('#town').val(); // Get the selected town
        const village = $(this).val(); // Get the selected village

        if (town && village) {
            $('#road').html('<option value="" selected disabled>Loading roads...</option>');

            $.ajax({
                url: '<?= BASE_URL ?>roads_api/getRoads',
                type: 'GET',
                data: {
                    town: town,
                    village: village
                },
                success: function(response) {
                    try {
                        const jsonResponse = typeof response === "string" ? JSON.parse(response) : response;

                        if (jsonResponse.status === 1) {
                            $('#road').html('<option value="" selected disabled>Select Road</option>');

                            jsonResponse.data.forEach(function(road) {
                                $('#road').append(`<option value="${road.road}">${road.road}</option>`);
                            });
                        } else {
                            $('#road').html('<option value="" selected disabled>No roads found</option>');
                        }
                    } catch (e) {
                        $('#road').html('<option value="" selected disabled>Error fetching roads</option>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#road').html('<option value="" selected disabled>Error fetching roads</option>');
                }
            });
        } else {
            $('#road').html('<option value="" selected disabled>Select Road</option>');
        }
    });
});



</script>

<script>
$(document).ready(function() {
    // Cache the shop number container
    const $shopContainer = $('#shopNumberContainer');
    
    // Initial check on page load
    if ($('#mobile_shop').is(':checked')) {
        $shopContainer.hide();
    }
    
    // Toggle visibility when checkbox changes
    $('#mobile_shop').change(function() {
        if (this.checked) {
            $shopContainer.hide();
            $('input[name="shop"]').val(''); // Clear the value when hidden
        } else {
            $shopContainer.show();
        }
    });
});
</script>