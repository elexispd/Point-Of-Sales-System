<?php

 

class Validate{
	
 

static function verifEmail($email){
 
//$mail = new VerifyEmail();
 
//$mail->setStreamTimeoutWait(20);
	//if($mail->check($email)){
if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
		
		return true;
		}else{
		return false;
		}
	
	}
static function matchpassword($password1,$password2){
if($password1 == $password2){
		
		return true;
		}else{
			
			return false;
			}
	
	}

static function sanitizer($variab){
	return $variab;
	
	}

static function stripTags($varp){
	
	return $varp;
	}
static function myFilter($verd){
	Validate::cee_sanitize_html($string);
	
	
	
	return strip_tags($verd);
	}
static function cee_sanitize_number($number) {
	Validate::cee_sanitize_html($number);
	Validate::cee_sanitize_html($number);
    return filter_var($number, FILTER_SANITIZE_NUMBER_INT);
}

static function cee_sanitize_decimal($decimal) {
	Validate::cee_sanitize_html($string);
    return filter_var($decimal, FILTER_SANITIZE_NUMBER_FLOAT);
}

static function cee_sanitize_string($string) {
	Validate::cee_sanitize_html($string);
    $string = strip_tags($string);
    $string = addslashes($string);
    return filter_var($string, FILTER_SANITIZE_STRING);
}

static function cee_sanitize_html($string) {
    Validate::stripTags($string);
    $string = strip_tags($string, '<a><strong><em><hr><br><p><u><ul><ol><li><dl><dt><dd><table><thead><tr><th><tbody><td><tfoot>');
    $string = addslashes($string);

    $string = str_replace("&","",$string);
    $string = str_replace("<","",$string);
    $string = str_replace(">","",$string);
    $string = str_replace("=","",$string);
    $string = str_replace("'","",$string);

    return htmlspecialchars($string);
}


static function cee_sanitize_url($url) {
	Validate::cee_sanitize_html($string);
    return filter_var($url, FILTER_SANITIZE_URL);
}

static function cee_sanitize_slug($string) {
	Validate::cee_sanitize_html($string);
    $string = str_slug($string);
    return filter_var($string, FILTER_SANITIZE_URL);
}

static function cee_sanitize_email($string) {
	Validate::cee_sanitize_html($string);
    return filter_var($string, FILTER_SANITIZE_EMAIL);
}
	
	
 	
	
static function raw__ismail($email){
	 
	return Validate::verifEmail($email);
}
static function raw__ismail2($email){	
	if(preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$email))
{  
if(checkdnsrr(array_pop(explode("@",$email)),"MX")){
        return true;
      }else{
        return false;
      }
     } 
     else { 
      return 0; 
       }
}
	
	
static function cee_filter($variable_name,$value,$type,$varaible=""){
 
	
	
	}	
	
function validate_email($email){

   $exp = "^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$";

   if(eregi($exp,$email)){

      if(checkdnsrr(array_pop(explode("@",$email)),"MX")){
        return true;
      }else{
        return false;
      }

   }else{

      return false;

   }    
}	
	
	
	
	
	
	
	
	}









?>