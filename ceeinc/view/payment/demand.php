<?php 

$username = Security::decrypt($_GET['location']);
$year = Input::get('year');
$demand_info = demand_model::getUserDemandNoticesByYear($username, $year);
if($demand_info){
    $location = location_model::getLocationByUsername($username);
}else{
    Session::set_ceedata("cip_payment_verify", "<div class='cee_error'>Demand Notice Not Found.</div>");
	cee_matchapp::redirect("payment/verify");
    return;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        :root {
            --primary-color: rgb(10, 80, 38);
            --secondary-color: rgb(6, 6, 126);
        }

        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 794px;
            height: 1040px;
            border: 1px solid black;
            margin: 10px auto;
            padding: 1rem;
            color: var(--primary-color);
        }
        .header{
            text-align: center;
        }
        .header .header-content h2{
            font-weight: bolder;
            font-size: 28px;
        }
        .header .header-content h3{
            font-size: 18px;
            padding: 0 4rem;
        }
        .address{
            padding: 0.25rem 1rem;
        }
        .main h1{
            text-align: center;
            font-size: 40px;
            font-weight: bolder;
            text-decoration: underline;
            color: rgb(110, 9, 9);
            line-height: 0;
        }
        .main-body{
            padding: 0 1rem;
            font-size: 20px;
        }
        .main-body ol li{
            line-height: 30px;
        }
        .footer{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            font-size: 20px;
        }
        .right-footer, .left-footer{
            text-align: center;
            color: var(--primary-color);
            font-weight: bold;
        }
        span{
            color:red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="<?= BASE_URL ?>assets/images/logo-light.png" width="150" alt="">
            </div>
            <div class="header-content">
                <h2>REVENUE COLLECTION, ORUMBA NORTH LOCAL GOVERNMENT AREA, ANAMBRA STATE</h2>
                <h3>ORUMBA NORTH LOCAL GOVERNMENT AREA SECRETARIAT, AJALLI, ANAMBRA STATE.</h3>
            </div>
        </div>
        <div class="address">
            <h3>OUR REF:......................................................................</h3>
            <h3>PLOT NO:......................................................................</h3>
            <h3>ESTATE:.........................................................................</h3>
        </div>
        <div class="main">
            <h1>DEMAND NOTICE</h1>
            <div class="main-body">
            <p>You, <?= $location["business_name"] ?>, are hereby demanded to present the following documents to Orumba North L.G.A Revenue Collection, Anambra State within
             <span>
                <?php
                 $date = new DateTime($demand_info[0]["deadline"]); 
                 $formattedDate = $date->format("jS M, Y");
                 echo $formattedDate;
                 
                ?>
            </span> of this NOTICE for payment of amount <span><strike>N</strike><?= number_format(category_model::getCategoryById($location["category"])["amount"],2) ?></span></p>
            <ol>
                <li>.........<?= $location["business_name"] . " ". $location["address"] ?>...........</li>
            </ol>
           <p>Failure to comply with this request, we will be forced to revoke/pursue legal action. A copy of this notice has been provided to our attorney for necessary action.</p>
           <p>Please be guided accordingly.</p>
        </div>
        </div>
        <div class="footer">
            <div class="left-footer">
                <p>.........................................</p>
                <p>Head Development Control</p>
            </div>
            <div class="right-footer">
                        <?= Date::getDate($location["created_at"]); ?>
                <p>.........................................</p>
                <p>Date</p>
            </div>
        </div>
    </div>
</body>
</html>