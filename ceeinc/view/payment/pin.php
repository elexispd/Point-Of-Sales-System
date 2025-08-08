<!-- ========== Topbar End ========== -->
<?php 
    if(isset($_POST['amount']) && isset($_POST['username']) ) {
        $amount = Input::post("amount");
        $username = Input::post("username");
        $year = Input::post("year");
    } else {
        cee_matchapp::redirect("payment/user?location=" . $username);
    }
?>
<div class="px-3">
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="py-3 py-lg-4">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="page-title mb-0">Payment</h4>
                </div>
                <div class="col-lg-6">
                    <div class="d-none d-lg-block">
                        <ol class="breadcrumb m-0 float-end">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Payment</a></li>
                            <li class="breadcrumb-item active">Pin</li>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="p-2">
                                    <form class="form-horizontal" role="form" method="POST" action="<?= BASE_URL ?>payment/process">
                                        <?php 
                                            Session::form_csfr();
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="w-50 mx-auto">
                                                    <label class="col-form-label" for="pin-input">Transaction PIN</label>
                                                    <div class="d-flex gap-2"> <!-- Added gap-2 for spacing between inputs -->
                                                        <input type="number" maxlength="1" class="form-control text-center pin-segment p-2" oninput="moveToNext(this, 1)" style="width: 20%;">
                                                        <input type="number" maxlength="1" class="form-control text-center pin-segment p-2" oninput="moveToNext(this, 2)" style="width: 20%;">
                                                        <input type="number" maxlength="1" class="form-control text-center pin-segment p-2" oninput="moveToNext(this, 3)" style="width: 20%;">
                                                        <input type="number" maxlength="1" class="form-control text-center pin-segment p-2" oninput="moveToNext(this, 4)" style="width: 20%;">
                                                    </div>
                                                    <input type="hidden" id="pin-input" name="pin">
                                                    <input type="hidden" id="" name="username" value="<?= $username ?>">
                                                    <input type="hidden" id="" name="year" value="<?= $year ?>">
                                                    <input type="hidden" id="" name="amount" value="<?= $amount ?>">
                                                    <input type="hidden" id="" name="agent" value="<?= users_model::username(); ?>">
                                                    
                                                    <div class="mt-3">
                                                        <button type="submit" class="btn text-light w-md" style="background-color:rgb(12, 80, 4);">Confirm</button>
                                                    </div>
                                                </div>
                                            </div>
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


<script>
    function moveToNext(input, nextIndex) {
        // Ensure the input is a single digit
        if (input.value.length > 1) {
            input.value = input.value.slice(0, 1);
        }

        // Move focus to the next input field
        if (input.value.length === 1 && nextIndex <= 4) {
            const nextInput = document.querySelector(`.pin-segment:nth-child(${nextIndex})`);
            if (nextInput) {
                nextInput.focus();
            }
        }

        // Combine the segments into the hidden input field
        updateHiddenPin();
    }

    function updateHiddenPin() {
        const pinSegments = document.querySelectorAll('.pin-segment');
        let pin = '';
        pinSegments.forEach(segment => {
            pin += segment.value;
        });
        document.getElementById('pin-input').value = pin;
    }
</script>


