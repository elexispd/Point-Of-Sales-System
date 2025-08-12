<?php


//autoload files


//autoload models
$dbmodel = ['auth_model', 'configurations', 'users_model', 'roles_model','permissions_model' ];

 


Cee_Model::loadModel($dbmodel);

$thirsparty2 = array("jwt/vendor/autoload");
Cee_Model::apploading($thirsparty2);
