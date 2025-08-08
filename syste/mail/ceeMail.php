<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ceeMail extends emailconfig{
	
	function __construct(){
		new emailconfig();
		}
	static function SendMail($title,$body,$to){
		
	$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
   // $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'ballass.com';   
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'no_reply@ballass.com';    
    $mail->Password   = 'ballass.com';     
    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('no_reply@ballass.com', 'Ballass Platform');
    $mail->addAddress($to, $to);  
    $mail->addReplyTo('no_reply@ballass.com', 'Ballass Platform');
   
    $mail->isHTML(true);    
     $mail->Subject = $title;
    $mail->Body = $body;
   // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



   echo  $mail->send();
   // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}   



		
		}
	static function SendMailEEE($title,$body,$to){
		
 
$mail = emailconfig::Setmail();
emailconfig::variableDeclrartion($mail);
//From email address and name
$mail->From = "bwns@bwalletpay.com";
$mail->FromName = "BOLDWALLET";

//To address and name
   $mail->addAddress($to, $to);
   $mail->isHTML(true);

   $mail->Subject = $title;
   $mail->Body = $body;
 

if(!$mail->send()) 
{
     return "Mailer Error: " . $mail->ErrorInfo;
} 
else  
{
   return true;
}
		}
	
	
	
	}








?>