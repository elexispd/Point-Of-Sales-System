<?php


//autoload files


//autoload models
$dbmodel = ['auth_model', 'configurations', 'users_model', 'roles_model','permissions_model', 'products_model', 'stocks_model', 'category_model', 'supplies_model', 'purchases_model', 'sales_model', 'expenses_model', 'incomes_model', 'logs_model', 'pins_model' ];

 


Cee_Model::loadModel($dbmodel);

$thirsparty2 = array("jwt/vendor/autoload");
Cee_Model::apploading($thirsparty2);
