<?php

$uri = $_SERVER['REQUEST_URI'];

$contsant2 = "syste/security/matchapp.php";
include($contsant2);
class System_con extends cee_assets{
	
	
function __construct() { 
 
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
 
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$query = $_SERVER['QUERY_STRING'];

if(!$this->validateDF()){
	Cee_assets::throError("Sorry your Default Controller Does not Exist");	
	}else{
$this->load_url($url); 
}
   
    }

function ReturnBase($url){
$url = $url;	
$base_url = BASE_URL;
$controller = str_replace($base_url,"",$url);
$stringA = explode("/",$controller);

$sizeofstring = sizeof($stringA);
$mainController = $this->getController($sizeofstring[0]);	
//echo exit($mainController);	
	}
function load_url($url){
$url = $url;	
$base_url = BASE_URL;


$controller = str_replace($base_url,"",$url);
$scontroller = str_replace("/",",",$controller);
$stringA = explode(",",$scontroller,4);
$sizeofstring = sizeof($stringA);
 
 if($sizeofstring == 1 ){
	 $mainController = $controller;
	 $edf  = explode("?",$mainController);
		$mainController = $edf[0];
	 }else{
	if($sizeofstring == 2){
		$mainController = $stringA[0];
		$edf  = explode("?",$mainController);
		$mainController = $edf[0];
		
		}else{
			
			 cee_matchapp::redirect(D_CONTROLLER);
			 
			}	 
	 
	 }

$mainController = $this->getController($mainController);

if(isset($_SESSION['cee_green_admin2'])){
$result = users_model::currentuser();	if($result->num_rows > 0){
 while($row = $result->fetch_assoc()){ 
 
 
 $admin1 = array("adminticket","newadmin","viewadmin","payments_cr","users","viewadmin","fundaccount");
 
 
 if($row['level'] == "admin1" || $row['level'] == "admin" || $row['level'] == "admin2" || $row['level'] == "admin3"){
	 
	 if(sizeof($stringA) == 2 ){
	$method =  $stringA[1];
	$edf  = explode("?",$method);
	$method = $edf[0];
$this->load_cee_Method($mainController,$method);
 
 

}else{
 	if($sizeofstring == 1){
	$this->load_controller($mainController);
	 }else{
$this->load_controller(D_CONTROLLER);

} }	 
	 
	 }else{
	if (in_array($mainController,$admin1)) {
			 
	 
		$this->load_controller("accessdenied");
	}else{
		
		
		
		 if(sizeof($stringA) == 2 ){
	$method =  $stringA[1];
	$edf  = explode("?",$method);
	$method = $edf[0];
$this->load_cee_Method($mainController,$method);
 
 

}else{
 	if($sizeofstring == 1){
	$this->load_controller($mainController);
	 }else{
$this->load_controller(D_CONTROLLER);

} }	

	 }
		
		
		
   }
 
 
 }}else{
	 
if(sizeof($stringA) == 2 ){
	$method =  $stringA[1];
	$edf  = explode("?",$method);
	$method = $edf[0];
$this->load_cee_Method($mainController,$method);
 
 

}else{
 	if($sizeofstring == 1){
	$this->load_controller($mainController);
	 }else{
$this->load_controller(D_CONTROLLER);

}	 
	 }
 
  }
	
	}else{
		if(sizeof($stringA) == 2 ){
	$method =  $stringA[1];
	$edf  = explode("?",$method);
	$method = $edf[0];
$this->load_cee_Method($mainController,$method);
 
 

}else{
 	if($sizeofstring == 1){
	$this->load_controller($mainController);
	 }else{
$this->load_controller(D_CONTROLLER);

}	}
		
		}





 }
function getController($controller){
$contr = strtolower($controller);	
if(($controller == "")){
	
	 return D_CONTROLLER;
	
	}else{
$controler1 = 'ceeinc/controller/'.$controller.'.php';
if(is_file($controler1)){
 return $contr;
	}else{
		return D_CONTROLLER;
		}

}
	}
function load_cee_Method($controller,$method){
 
$controler1 = 'ceeinc/controller/'.$controller.'.php';
if(is_file($controler1)){
include($controler1);
$ved = $controller;
if(class_exists($ved)){

$obhh  = new $ved();


if(method_exists($obhh,$method)){
 
 $obhh->$method();
}else{
  	
 cee_matchapp::redirect(D_CONTROLLER);
	}
	
	
	
}else{
	Cee_assets::throError("Controller not properly configured");	

	}}else{
	$this->DefaulNonnexits();	

	}	
	
	}
function load_controller($controller){
$controler1 = 'ceeinc/controller/'.$controller.'.php';
if(is_file($controler1)){
include($controler1);
$ved = $controller;
if(class_exists($ved)){

$obhh  = new $ved();

 
if(method_exists($obhh,"ceem")){
 //echo get_class($obhh);
$obhh->ceem();

}else{
Cee_assets::throError("Controller not properly configured");	
	}
}else{
	Cee_assets::throError("Controller not properly configured");	

	}
	
	}else{
	$this->DefaulNonnexits();	

	}
}

function DefaulNonnexits(){
	
	
	
	}
 
function validateDF(){
$controler1 = 'ceeinc/controller/'.D_CONTROLLER.'.php';	
if(is_file($controler1)){
	return 1;
	}else{
		return 0;
		}	
	}
}
$ved = "System_con";
new $ved();





?>