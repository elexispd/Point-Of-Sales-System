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
    <title>Orumba North Revenue Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 2px solid #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            margin-bottom: 10px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #006600;
            margin: 10px 0;
        }

        .subtitle {
            font-size: 18px;
            color: #333;
            margin-bottom: 5px;
        }

        .address {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        .receipt-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 5px 0;
        }

        .detail-label {
            font-weight: bold;
            color: #444;
        }

        .detail-value {
            color: #333;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .payment-table th {
            background-color: #006600;
            color: white;
            padding: 10px;
            text-align: left;
        }

        .payment-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .total {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
            border-top: 2px solid #333;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="<?= BASE_URL ?>assets/images/logo-light.png" alt="Orumba North Logo" class="logo">
        <div class="title">REVENUE COLLECTION, ORUMBA NORTH LOCAL GOVERNMENT AREA, ANAMBRA STATE</div>
        <div class="subtitle">OFFICIAL PAYMENT RECEIPT</div>
        <div class="address">
            45 Council Road, Ajali<br>
            Anambra State, Nigeria<br>
            Phone: (080) 1234-5678
        </div>
    </div>

    <div class="receipt-details">
        <div class="detail-item">
            <span class="detail-label">Receipt Number:</span>
            <span class="detail-value">ORN-<?= $payment["receipt_no"] ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Date:</span>
            <span class="detail-value"><?= Date::getDate($payment["created_at"]) ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Payment Type:</span>
            <span class="detail-value">Business Permit</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Payment Method:</span>
            <span class="detail-value"><?= ucwords($payment["payment_method"]) ?></span>
        </div>
    </div>

    <div class="payer-info">
        <h3>Payer Information</h3>
        <div class="detail-item">
            <span class="detail-label">Payer Name:</span>
            <span class="detail-value"><?= $location["business_name"] ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Payer ID:</span>
            <span class="detail-value"><?= $payment["location"] ?></span>
        </div>
    </div>

    <table class="payment-table">
        <tr>
            <th>Description</th>
            <th>Amount (NGN)</th>
        </tr>
        <tr>
            <td>
                <?= category_model::getCategoryById($location['category'])["name"]; ?>
            </td>
            <td> <strike>N</strike><?= $payment["amount"] ?> </td>
        </tr>
       
        <tr class="total">
            <td>Total Paid</td>
            <td><strike>N</strike><?= $payment["amount"] ?></td>
        </tr>
    </table>

    <div class="footer">
        <p>Thank you for paying your revenue promptly!</p>
        <p>This receipt serves as official confirmation of your payment.<br>
        Please keep it for your records and future reference.</p>
    </div>
</body>
</html>