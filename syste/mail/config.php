<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 
class emailconfig extends Cee_assets{
	
	
	function __construct(){
	 
	//emailconfig::verifyFunce();
	
		}
	static function settingsVariable(){
		
	$emailsettings = array(
	'SMTPDebug'	=> '2',
	'Host' => 'ballass.com',
	'SMTPAuth' => true,
	'username' => 'no_reply@ballass.com',
	'password' => 'ballass.com',
	'SMTPSecure' => 'tls',  
	'Port' => 465,
	'application' => 'cee'   //please dont edit
	
 );
		return $emailsettings;
		
		}
	 
	static function Setmail(){
		$mail = new PHPMailer(true);
		emailconfig::verifyFunce();
		return $mail;
		}
	static function verifyFunce(){
	$variable = emailconfig::settingsVariable();	
	if($variable['SMTPDebug'] == "") Cee_assets::throError("Sorry , SMTP Debug Mode Not Set in Email Setup") ;
	 
    if($variable['Host'] == "") Cee_assets::throError("Sorry , SMTP Host not Set correctly in Email Setup") ; 
	
	if($variable['Host'] == "") Cee_assets::throError("Sorry , SMTP Host not Set correctly in Email Setup") ; 
	
	if($variable['SMTPAuth'] == "") Cee_assets::throError("Sorry , SMTP Authentication Mode not Set correctly in Email Setup") ; 
	
	if($variable['username'] == "") Cee_assets::throError("Sorry , SMTP Username not Set correctly in Email Setup") ;
	
	if($variable['password'] == "") Cee_assets::throError("Sorry , SMTP Password not Set correctly in Email Setup") ;
	  
	 
	 if($variable['SMTPSecure'] == "") Cee_assets::throError("Sorry , SMTP Secure Mode not Set correctly in Email Setup") ;                                  
                                                     // SMTP username
     
     if($variable['Port'] == "") Cee_assets::throError("Sorry , SMTP Port not Set correctly in Email Setup") ;
 	
	if($variable['application'] != "cee") Cee_assets::throError("Sorry , SMTP Application Configuration Must be set to cee in Email Setup") ;
		}
	static function variableDeclrartion($mail){
	 
    $variable = emailconfig::settingsVariable();;
	$mail->SMTPDebug = $variable['SMTPDebug'];                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host =  $variable['Host'];  // Specify main and backup SMTP servers
    $mail->SMTPAuth = $variable['SMTPAuth'];                                // Enable SMTP authentication
    $mail->Username = $variable['username'];                  // SMTP username
    $mail->Password = $variable['password'];                            // SMTP password
    $mail->SMTPSecure = $variable['SMTPSecure'];                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $variable['Port'];  
	
		}
	
	}





?>