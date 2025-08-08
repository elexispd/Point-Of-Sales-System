<div class="px-3">
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="py-3 py-lg-4">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="page-title mb-0">Analysis Agent Perfomance</h4>
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
    </div>
        <!-- end page title -->

        <!-- Main Content Row -->
        <div class="row">
            <!-- Search Form -->
             <div>
                <?= Session::ceedata("cip_analysis"); ?>
             </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Search Payments</h5>
                        <form method="POST" action="<?= BASE_URL ?>analysis/agent_performance" role="form" class="needs-validation" novalidate>
                            <?php 
                            Session::form_csfr();
                            ?>
                            
                            <div class="mb-3">
                                <label for="agent" class="form-label">Agent Username</label>
                                <input type="text" class="form-control" id="agent" name="agent" placeholder="Enter username" required>
                                <input type="hidden" class="form-control" id="" name="pay" required>
                                <div class="invalid-feedback">Please enter a username.</div>
                            </div>

                            <button type="submit" class="btn btn-success w-100"  style="background: rgb(12, 80, 4)">Search</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Search Form -->
            <!-- Search Form -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Search Location Registrations</h5>
                        <form method="POST" action="<?= BASE_URL ?>analysis/agent_performance" role="form" class="needs-validation" novalidate>
                            <?php 
                            Session::form_csfr();
                            ?>
                            
                            <div class="mb-3">
                                <label for="agent" class="form-label">Agent Username</label>
                                <input type="text" class="form-control" id="agent" name="agent" placeholder="Enter username" required>
                                <input type="hidden" class="form-control" id="" name="registration" required>
                                <div class="invalid-feedback">Please enter a username.</div>
                            </div>

                            <button type="submit" class="btn btn-success w-100"  style="background: rgb(12, 80, 4)">Search</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Search Form -->
        </div>
        <!-- End Main Content Row -->
    </div>
    </
</div>

<?php Session::unset_ceedata("cip_analysis", ""); ?>


<!-- JS for Bootstrap validation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Bootstrap 5 custom validation
    (function () {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
