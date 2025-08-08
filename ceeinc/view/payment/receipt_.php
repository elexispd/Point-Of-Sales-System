<?php 

$receipt = Security::decrypt($_GET['id']);
$payment = payment_model::getReceipt($receipt);
$location = location_model::getLocationByUsername($payment["location"]);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for the receipt */
        .receipt-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-header h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .receipt-details {
            margin-bottom: 20px;
        }
        .receipt-details p {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }
        .receipt-details strong {
            color: #333;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        .receipt-footer a {
            color: #007bff;
            text-decoration: none;
        }
        .receipt-footer a:hover {
            text-decoration: underline;
        }
        body {
            background:rgba(227, 222, 209, 0.72);
        }
    </style>
</head>


<body>
    <div class="receipt-container">
        <!-- Receipt Header -->
        <div class="receipt-header">
            <h2>Payment Receipt</h2>
            <p>Thank you for your payment!</p>
        </div>

        <!-- Receipt Details -->
        <div class="receipt-details">
            <p><strong>Business Name:</strong> <?= $location["business_name"] ?></p>
            <p><strong>Transaction ID:</strong> #<?= $payment["receipt_no"] ?></p>
            <p><strong>Date:</strong> <?= Date::getDate($payment["created_at"]) ?></p>
            <p><strong>Amount Paid:</strong> <strike>N</strike><?= $payment["amount"] ?></p>
            <p><strong>Payment Year:</strong> <?= $payment["year"] ?> </p>
            <p><strong>Location:</strong> 
                <?php 
                    
                    echo $location['address'];
                ?>
            </p>
            <p><strong>Category:</strong> 
                <?php 
                    echo category_model::getCategoryById($location['category'])["name"];
                ?>
            </p>
        </div>

        <!-- Receipt Footer -->
        <div class="receipt-footer">
            <p>If you have any questions, please contact <a href="mailto:support@example.com">info@orumbanorth.gov</a>.</p>
            <p>&copy; <?= date("Y") ?> ICT Orumba North LGA. All rights reserved.</p>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>