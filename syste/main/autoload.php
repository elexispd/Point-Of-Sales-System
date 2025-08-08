<?php


//autoload files


//autoload models
$dbmodel = ['auth_model', 'configurations', 'users_model', 'category_model', 'payment_model', 'analysis_model', 'location_model','demand_model', 'wallet_model', 'roads_model', 'mail_model', 'sms_model' ];

 


Cee_Model::loadModel($dbmodel);

$thirsparty2 = array("jwt/vendor/autoload");
Cee_Model::apploading($thirsparty2);
