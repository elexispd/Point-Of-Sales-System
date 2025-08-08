<!-- ========== Topbar End ========== -->
<?php
$towns = [
    "Ajalli",  
    "Amaokpala",  
    "Amaetiti",  
    "Awa",  
    "Awgbu",  
    "Nanka",  
    "Ndikelionwu",  
    "Ndiokolo",  
    "Ndiokpalaeke",  
    "Ndiokpalaeze",  
    "Ndiowu",  
    "NdiuKwuenu",  
    "Oko",  
    "Okpeze",  
    "Omogho",  
    "Ufuma"
];

$villages = [
    "Umuonyeche", "Umuokoro", "Umuokpu",
    "Amagu", "Enugwu", "Eziagu", "Umuawulu",
    "Isiokwe", "Umuagu", "Umuokpe",
    "Amokwe", "Umuogbu", "Umuonyeche",
    "Amagu", "Eziowu", "Umuowu",
    "Eziukwuenu", "Umuagu", "Umuokoro",
    "Eziuzu", "Umuagu", "Umuokoro",
    "Eziomogho", "Umuagu", "Umuokoro",
    "Eziufuma", "Umuagu", "Umuokoro",
    "Eziagulu", "Eziowelle", "Umuagu", "Umuokoro"
];

?>
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

            <!-- Form 2: Analysis by Users by Village -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="sub-header">Search By Location</p>
                        <form class="form-horizontal" role="form" method="GET" action="<?= BASE_URL ?>roads/getRoads">
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

<?php
Session::unset_ceedata("cip_analysis", "");
?>

<script>
$(document).ready(function() {
    // When town selection changes
    $('#townVillage').change(function() {
        var selectedTown = $(this).val();
        
        // Clear previous villages
        $('#village').html('<option value="" selected disabled>Select Village</option>');
        
        if (selectedTown) {
            // Make AJAX request to get villages
            $.ajax({
                url: '<?= BASE_URL ?>location/getVillages',
                type: 'POST', // or 'GET' depending on your server setup
                data: { town: selectedTown },
                dataType: 'json',
                success: function(response) {
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
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching villages:', error);
                    $('#village').append($('<option>', {
                        value: '',
                        text: 'Error loading villages'
                    }));
                }
            });
        }
    });
});
</script>