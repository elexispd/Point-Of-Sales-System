<!-- ========== Topbar End ========== -->

<div class="px-3">
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="py-3 py-lg-4">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="page-title mb-0">Register Agent</h4>
                </div>
                <div class="col-lg-6">
                    <div class="d-none d-lg-block">
                        <ol class="breadcrumb m-0 float-end">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Agent</li>
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
                        <p class="sub-header">Register Agent</p>

                        <div class="row">
                            <div class="col-12">
                                <div class="p-2">
                                <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="<?= BASE_URL ?>users/store">
                                    <?php
                                    Session::form_csfr();
                                    echo Session::ceedata("cip_user");
                                    ?>

                                    <!-- Row 1: Full Name and Username -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="col-form-label" for="full_name">Full Name</label>
                                                <input type="text" id="full_name" placeholder="" class="form-control" name="full_name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="col-form-label" for="username">Username</label>
                                                <input type="text" id="username" placeholder="" class="form-control" name="username" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 2: Phone Number and BVN -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="col-form-label" for="phone">Phone Number</label>
                                                <input type="tel" id="phone" name="phone" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="col-form-label" for="phone">Email</label>
                                                <input type="email" id="email" name="email" class="form-control" required>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <!-- Row 3: NIN, NEPA Bill, and CAC/TIN -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="col-form-label" for="role">Role</label>
                                                <select name="role" id="role" class="form-control">
                                                    <option value="">Select Role</option>
                                                    <option value="agent">Agent</option>
                                                    <option value="it_sub">IT Sub</option>
                                                    <option value="supervisor">Supervisor</option>
                                                    <option value="supervisor_agent">Supervisor/Agent</option>
                                                    <option value="enforcer">Enforcer</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="col-form-label" for="bvn">BVN</label>
                                                <input type="number" id="bvn"  name="bvn" class="form-control" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="col-form-label" for="nin">NIN Document</label>
                                                <input type="file" id="nin" accept="application/pdf, image/png, image/jpeg" name="nin" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="col-form-label" for="nepa">NEPA Bill</label>
                                                <input type="file" id="nepa" accept="application/pdf, image/png, image/jpeg" name="nepa" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="col-form-label" for="cac">CAC/TIN</label>
                                                <input type="file" id="cac" accept="application/pdf, image/png, image/jpeg" name="cac" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="col-form-label" for="ansid">ANSSID</label>
                                                <input type="text" id="ansid" name="ansid" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="col-form-label" for="bank">BANK</label>
                                                <select name="bank" id="bank" class="form-control">
                                                    <option value="">Select a bank</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="col-form-label" for="account_number">ACCOUNT NUMBER</label>
                                                <input type="number" maxlength="11" name="account_number" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="mt-3">
                                        <button type="submit" style="background-color:rgb(12, 80, 4);border: none;" class="btn btn-primary w-md">Submit</button>
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


<?php
Session::unset_ceedata("cip_user", "");
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Towns and villages data
        const towns = [
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

        const villages = {
            "Ajalli": ["Umueze", "Umuonyeche", "Umuokoro", "Umuokpu"],
            "Awa": ["Amagu", "Enugwu", "Eziagu", "Umuawulu"],
            "Ndiokpalaeze": ["Isiokwe", "Umuagu", "Umuokpe"],
            "Ndiokolo": ["Amokwe", "Umuogbu", "Umuonyeche"],
            "Ndiowu": ["Amagu", "Eziowu", "Umuowu"],
            "Ndiukwuenu": ["Eziukwuenu", "Umuagu", "Umuokoro"],
            "Ndiuzu": ["Eziuzu", "Umuagu", "Umuokoro"],
            "Omogho": ["Eziomogho", "Umuagu", "Umuokoro"],
            "Ufuma": ["Eziufuma", "Umuagu", "Umuokoro"],
            "Umunze": ["Eziagulu", "Eziowelle", "Umuagu", "Umuokoro"]
        };

        // Populate towns dropdown
        $.each(towns, function (index, town) {
            $('#town').append(`<option value="${town}">${town}</option>`);
        });

        // Handle town selection change
        $('#town').on('change', function () {
            const selectedTown = $(this).val();
            const villageDropdown = $('#village');

            // Clear previous villages
            villageDropdown.empty().append('<option value="" selected disabled>Select Village</option>');

            if (selectedTown && villages[selectedTown]) {
                // Populate villages dropdown
                $.each(villages[selectedTown], function (index, village) {
                    villageDropdown.append(`<option value="${village}">${village}</option>`);
                });
            }
        });
    });
</script>



<script>
    // JSON data containing the list of commercial banks
    const bankData = {
        "status": true,
        "data": [
            { "name": "Access Bank", "code": "044" },
            { "name": "Access Bank (Diamond)", "code": "063" },
            { "name": "Citibank Nigeria", "code": "023" },
            { "name": "Ecobank Nigeria", "code": "050" },
            { "name": "Fidelity Bank", "code": "070" },
            { "name": "First Bank of Nigeria", "code": "011" },
            { "name": "First City Monument Bank", "code": "214" },
            { "name": "Globus Bank", "code": "00103" },
            { "name": "Guaranty Trust Bank", "code": "058" },
            { "name": "Heritage Bank", "code": "030" },
            { "name": "Jaiz Bank", "code": "301" },
            { "name": "Keystone Bank", "code": "082" },
            { "name": "Polaris Bank", "code": "076" },
            { "name": "Providus Bank", "code": "101" },
            { "name": "Stanbic IBTC Bank", "code": "221" },
            { "name": "Standard Chartered Bank", "code": "068" },
            { "name": "Sterling Bank", "code": "232" },
            { "name": "Suntrust Bank", "code": "100" },
            { "name": "Union Bank of Nigeria", "code": "032" },
            { "name": "United Bank For Africa", "code": "033" },
            { "name": "Unity Bank", "code": "215" },
            { "name": "Wema Bank", "code": "035" },
            { "name": "Zenith Bank", "code": "057" }
        ]
    };

    // Get the select element
    const bankSelect = document.getElementById("bank");

    // Populate the select element with options
    bankData.data.forEach(bank => {
        const option = document.createElement("option");
        option.value = bank.code; // Set the value to the bank code
        option.textContent = bank.name; // Set the display text to the bank name
        bankSelect.appendChild(option); // Add the option to the select element
    });
</script>