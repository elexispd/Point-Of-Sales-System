<?php
ob_start();
new cee_matchapp();


class cee_matchapp{
	
function __construct(){	
	
		$constant[2] = "syste/main/ceemain.php";
		$constant[1] = "syste/session/assets.php";
 		$constant[0] = "syste/session/Session.php";
		$constant[5] = "syste/security/email_check.php";
		$constant[6] = "syste/security/Cee_validation.php";
		$constant[7] = "syste/security/Cee_global.php";
		$constant[8] = "syste/database/config.php";
		$constant[9] = "syste/database/config.php";
		$constant[10] = "syste/database/ceeconnection.php";
		$constant[11] = "syste/database/cee_model.php";
		$constant[12] = "syste/security/security.php";
		$constant[14] = "syste/mail/config.php";
		$constant[13] = "syste/mail/vendor/autoload.php";
		$constant[15] = "syste/mail/ceeMail.php";
		$constant[16] = "syste/main/autoload.php";
		$constant[17] = "syste/security/cee_os.php";
		$constant[18] = "syste/security/date.php";
		$constant[19] = "syste/security/cache.php";
		$constant[20] = "syste/security/queryBuilder.php";
		
		 
		 $this->inludeFu($constant);	
}



function inludeFu($fun){
	
	foreach($fun as $dked){
		require_once($dked);
		}
	 }

   static function eredirect($url){ 
   
    
	$actual_url = $url;
	
	?>
    <script>
    window.location = "<?php  echo $actual_url; ?>";
    </script>
    
    <?php 
header("location:  ".$actual_url);
exit;
}
    
  static function redirect($url){ 
	$stred = str_replace(BASE_URL,"",$url);
	$actual_url = BASE_URL.$stred;
	
	?>
    <script>
    window.location = "<?php  echo $actual_url; ?>";
    </script>
    
    <?php 
header("location:  ".$actual_url);
exit;
}
	}










ob_flush();


?>