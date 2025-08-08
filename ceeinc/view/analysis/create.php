<!-- ========== Topbar End ========== -->
<?php
$towns = [
    "Ajalli",
    "Awa",
    "Ndiokpalaeze",
    "Ndiokolo",
    "Ndiowu",
    "Ndiukwuenu",
    "Ndiuzu",
    "Omogho",
    "Ufuma",
    "Umunze"
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
            <!-- Form 1: Analysis by Users by Town -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p class="sub-header">Analysis by Location by Town</p>
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
                                <button type="submit" class="btn  text-light w-md" style="background: rgb(12, 80, 4)" >Search</button>
                            </div>
                        </form>
                    </div>
                </div> <!-- end card -->
            </div><!-- end col -->

            <!-- Form 2: Analysis by Users by Village -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p class="sub-header">Analysis by Location by Village</p>
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
                                <button type="submit" class="btn  text-light w-md" style="background: rgb(12, 80, 4)" >Search</button>
                            </div>
                        </form>
                    </div>
                </div> <!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->

        <div class="row mt-4">
            <!-- Form 3: Payment by Users in a Given Town or Village and Year -->
            <!-- <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p class="sub-header">Payment by Location in a Given Town and Year</p>
                        <form class="form-horizontal" role="form" method="GET" action="<?= BASE_URL ?>analysis/paymentByYear">
                            <?php Session::form_csfr(); ?>
                            <div class="mb-2">
                                <label class="col-form-label" for="town">Town</label>
                                <select name="town" id="town" class="form-control">
                                    <option value="" selected >Select Town</option>
                                    <option value="Ajalli">Ajalli</option>
                                    <option value="Awa">Awa</option>
                                    <option value="Ndiokpalaeze">Ndiokpalaeze</option>
                                    <option value="Ndiokolo">Ndiokolo</option>
                                    <option value="Ndiowu">Ndiowu</option>
                                    <option value="Ndiukwuenu">Ndiukwuenu</option>
                                    <option value="Ndiuzu">Ndiuzu</option>
                                    <option value="Omogho">Omogho</option>
                                    <option value="Ufuma">Ufuma</option>
                                    <option value="Umunze">Umunze</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="mb-2 col-6">
                                    <label class="col-form-label" for="from_year">From Year</label>
                                    <input type="number" id="from_year" class="form-control" name="from_year" placeholder="Enter From Year">
                                </div>
                                <div class="mb-2 col-6">
                                    <label class="col-form-label" for="to_year">To Year</label>
                                    <input type="number" id="to_year" class="form-control" name="to_year" placeholder="Enter To Year">
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn  text-light w-md" style="background: rgb(12, 80, 4)" >Search</button>
                            </div>
                        </form>
                    </div>
                </div> 
            </div> -->
            <!-- end col -->

            <!-- Form 4: Payment by Users in a Given Town or Village and Year Range -->
            <!-- <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p class="sub-header">Payment by Location in a Given Village and Year Range</p>
                        <form class="form-horizontal" role="form" method="GET" action="<?= BASE_URL ?>analysis/paymentByYearRange">
                            <?php Session::form_csfr(); ?>
                            <div class="mb-2">
                                <label class="col-form-label" for="village">Village</label>
                                <select name="village" id="village" class="form-control">
                                    <option value="" selected >Select Village</option>
                                    <option value="Umueze">Umueze</option>
                                    <option value="Umuonyeche">Umuonyeche</option>
                                    <option value="Umuokoro">Umuokoro</option>
                                    <option value="Umuokpu">Umuokpu</option>
                                    <option value="Amagu">Amagu</option>
                                    <option value="Enugwu">Enugwu</option>
                                    <option value="Eziagu">Eziagu</option>
                                    <option value="Umuawulu">Umuawulu</option>
                                    <option value="Isiokwe">Isiokwe</option>
                                    <option value="Umuagu">Umuagu</option>
                                    <option value="Umuokpe">Umuokpe</option>
                                    <option value="Amokwe">Amokwe</option>
                                    <option value="Umuogbu">Umuogbu</option>
                                    <option value="Eziowu">Eziowu</option>
                                    <option value="Umuowu">Umuowu</option>
                                    <option value="Eziukwuenu">Eziukwuenu</option>
                                    <option value="Eziuzu">Eziuzu</option>
                                    <option value="Eziomogho">Eziomogho</option>
                                    <option value="Eziufuma">Eziufuma</option>
                                    <option value="Eziagulu">Eziagulu</option>
                                    <option value="Eziowelle">Eziowelle</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="mb-2 col-6">
                                    <label class="col-form-label" for="from_year">From Year</label>
                                    <input type="number" id="from_year" class="form-control" name="from_year" placeholder="Enter From Year">
                                </div>
                                <div class="mb-2 col-6">
                                    <label class="col-form-label" for="to_year">To Year</label>
                                    <input type="number" id="to_year" class="form-control" name="to_year" placeholder="Enter To Year">
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <button type="submit" class="btn  text-light w-md" style="background: rgb(12, 80, 4)" >Search</button>
                            </div>
                        </form>
                    </div>
                </div>  -->
            </div>
            <!-- end col -->
        </div>
    </div> <!-- container -->
</div> <!-- content -->

<?php
Session::unset_ceedata("cip_analysis", "");
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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