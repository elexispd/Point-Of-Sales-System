
<div class="px-3">
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="py-3 py-lg-4">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="page-title mb-0">Analysis Search</h4>
                </div>
                <div class="col-lg-6">
                    <div class="d-none d-lg-block">
                        <ol class="breadcrumb m-0 float-end">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Analysis</a></li>
                            <li class="breadcrumb-item active">Search</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <!-- Form 1: Analysis by Users by Town -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p class="sub-header">Search By Location by Town</p>
                        <form class="form-horizontal" role="form" method="GET" action="<?= BASE_URL ?>analysis/byTown">
                            <?php Session::form_csfr(); ?>
                            <div class="mb-2">
                                <label class="col-form-label" for="town">Town</label>
                                <select name="town" id="town" class="form-control">
                                    <option value="" selected disabled>Select Town</option>
                                    <?php
                                    $towns = location_model::getTowns();
                                    foreach ($towns as $town) { ?>
                                        <option value="<?= $town ?>"><?= $town ?></option>";
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="mt-3">
                                <button style=" border: none; background:rgb(12, 80, 4)" type="submit" class="btn btn-primary w-md">Search</button>
                            </div>
                        </form>
                    </div>
                </div> <!-- end card -->
            </div><!-- end col -->

            <!-- Form 2: Analysis by Users by Village -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p class="sub-header">Search By Location by Village</p>
                        <form class="form-horizontal" role="form" method="GET" action="<?= BASE_URL ?>analysis/byVillage">
                            <?php Session::form_csfr(); ?>
                            <div class="mb-2">
                                <label class="col-form-label" for="town">Town</label>
                                <select name="town" id="townVillage" class="form-control">
                                    <option value="" selected disabled>Select Town</option>
                                    <?php
                                    $towns = location_model::getTowns();
                                    foreach ($towns as $town) { ?>
                                        <option value="<?= $town ?>"><?= $town ?></option>";
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="col-form-label" for="village">Village</label>
                                <select name="village" id="village" class="form-control">
                                    <option value="" selected disabled>Select Village</option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <button style=" border:none; background:rgb(12, 80, 4)" type="submit" class="btn btn-primary w-md">Search</button>
                            </div>
                        </form>
                    </div>
                </div> <!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->

        
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
Session::unset_ceedata("cip_analysis", "");
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#townVillage').change(function() {
        var selectedTown = $(this).val();
        
        $('#village').html('<option value="" selected disabled>Loading...</option>');
        
        if (selectedTown) {
            $('#loadingOverlay').show();
            $.ajax({
                url: '<?= BASE_URL ?>location/getVillages',
                type: 'POST',
                data: { town: selectedTown }, // or townVillage if needed
                dataType: 'json',
                success: function(response) {
                    $('#village').html('<option value="" selected disabled>Select Village</option>');
                    
                    if (response && response.length > 0) {
                        $.each(response, function(index, village) {
                            $('#village').append($('<option>', {
                                value: village,
                                text: village
                            }));
                        });
                        $('#village').prop('disabled', false);
                    } else {
                        $('#village').append('<option value="" disabled>No villages found</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error, xhr.responseText);
                    $('#village').html('<option value="" selected disabled>Error loading villages</option>');
                },
                complete: function() {
                    // Hide loading overlay regardless of success/error
                    $('#loadingOverlay').hide();
                }
            });
        } else {
            $('#village').html('<option value="" selected disabled>Select Village</option>')
                        .prop('disabled', true);
        }
    });
});
</script>