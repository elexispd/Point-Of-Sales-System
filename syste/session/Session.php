<?php


class Session{
	
	
	function __construct(){
		if (!isset($_SESSION)) session_start();
		 
		}
	static function GetUniquereferecenc(){
		$rn = uniqid().time();
		return $rn;
		}
	static function unset_ceedata($value){
		if(isset($_SESSION[$value])) unset($_SESSION[$value]);
		}
	static function  set_ceedata($name,$value){
	$_SESSION[$name] = $value;	
		}
		
		static function ceedata($value){
			if(isset($_SESSION[$value]))
		return $_SESSION[$value]; else return "";	
			}
			
	static function confir_csfr(){
		if (!isset($_SESSION)) session_start();
		$variable = $_SESSION['csfr_key_cee'];
		$variable_cdata = Input::post("cee_csfr_security");
		$variable_c = security::decrypt(Input::post("cee_csfr_controller"));
		//$variable_cdata != $variable || 
		if(Session::getCurrentController() != $variable_c){
			if($variable_c == ""){
				cee_matchapp::redirect(D_CONTROLLER);
				}else{
					 cee_matchapp::redirect($variable_c);  
			}
			
			}else{
				if(!isset($_POST['cee_csfr_controller']) || !isset($_POST['cee_csfr_security'])){
					cee_matchapp::redirect(D_CONTROLLER);
				}
				
				}
		}
	static function confir_get_csfr(){
		if (!isset($_SESSION)) session_start();
		$variable = $_SESSION['csfr_key_cee'];
		$variable_cdata = Input::get("cee_csfr_security");
		$variable_c = security::decrypt(Input::get("cee_csfr_controller"));
		//$variable_cdata != $variable || 
		if(Session::getCurrentController() != $variable_c){
			if($variable_c == ""){
				cee_matchapp::redirect(D_CONTROLLER);
				}else{
					 cee_matchapp::redirect($variable_c);  
			}
			
			}else{
				if(!isset($_GET['cee_csfr_controller']) || !isset($_GET['cee_csfr_security'])){
					cee_matchapp::redirect(D_CONTROLLER);
				}
				
				}
		}
	static function form_csfr(){
		if (!isset($_SESSION)) session_start();
	$form = uniqid();
	$_SESSION['csfr_key_cee'] = $form;	
	$_SESSION['form_controller_cee'] = Session::getCurrentController();
	$t_csfr = "<input type='hidden' name='cee_csfr_security' value='".$form."'>";
	$t_mainpage = "<input type='hidden' name='cee_csfr_controller' value='".security::encrypt(Session::getCurrentController())."'>";
	
	echo $t_csfr."".$t_mainpage;
		}
	
	
	 static function getCurrentController(){
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
 
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
 
$query = $_SERVER['QUERY_STRING'];
 	
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
		
		$mainController = D_CONTROLLER;;
			
			}	 
	 
	 }


$mainController = Session::getController($mainController);	
return $mainController;
		}
	
	static function getController($controller){
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
	
	}




new Session();





?>