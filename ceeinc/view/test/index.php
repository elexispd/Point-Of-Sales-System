<?php





$masterkey="1063552890";
$servicekey="BW295";


getWalletdetails($masterkey,$servicekey);

function getWalletdetails($masterkey,$servicekey){
$walletid = "2321af69-cab1-4935-b1f8-911924500cde";	
	
$url = "https://bwalletpay.com/bwt_api/getwalletdetails";
	
$ch = curl_init($url);
$login = $masterkey;
$password = $servicekey;
$order_id = time().uniqid();

//$POST = ['refno' => $rtye ];

//$data_string = json_encode($POST);
curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_VERBOSE, 0);	
	
	
	
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
//curl_setopt($ch, CURLOPT_POSTFIELDS,urlencode($data_string)); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "cache-control: no-cache",
    "content-type: application/json",
    "bwt-ref: $walletid"
  ));
	
	$response = curl_exec($ch);	


$returnCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
	var_dump(json_decode($response,true));
	
	
	
		
	}


//get_create_wallet($masterkey,$servicekey);



//create wallet

function get_create_wallet($masterkey,$servicekey){
	
$ref = "wallet reference";
$firstname = "";
$bvn = "";
$lastname = "";
$email = "";



$url = "https://bwalletpay.com/bwt_api/create_wallet";
 
$ch = curl_init($url);
$login = $masterkey;
$password = $servicekey;
$order_id = time().uniqid();

//$POST = ['refno' => $rtye ];

//$data_string = json_encode($POST);
curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_VERBOSE, 0); 

curl_setopt($ch,CURLOPT_POSTFIELDS ,'{
	"wallet_reference": '.$ref.',
	"currency": "NGN",
	"type": "bank",
	"customer": {
		"first_name": '.$firstname.',
		"last_name": '.$lastname.', 
		"email": '.$email.',
		"mobile_no": "+2348023431321",
		"bvn":'.$bvn.' } }');

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
//curl_setopt($ch, CURLOPT_POSTFIELDS,urlencode($data_string)); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "cache-control: no-cache",
    "content-type: application/json",
    "bwt-ref: apolk"
  ));
  
 
$response = curl_exec($ch);	


$returnCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
$rt['response'] = $response;;	
$rt['returnCode'] = $returnCode; 

var_dump($response);		 
 

 }
 

//get_list of banks
function get_bank($masterkey,$servicekey){

$url = "https://bwalletpay.com/bwt_api/show_banks";
$amoUnt = "";
$orderId = "";
$sessionId = "";
$txt = "";
$ch = curl_init($url);
$login = $masterkey;
$password = $servicekey;
$order_id = time().uniqid();

//$POST = ['refno' => $rtye ];

//$data_string = json_encode($POST);
curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_VERBOSE, 0); 


curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
//curl_setopt($ch, CURLOPT_POSTFIELDS,urlencode($data_string)); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "cache-control: no-cache",
    "content-type: application/json",
    "x-type: live"
  ));
  
 
$response = curl_exec($ch);	


$returnCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
$rt['response'] = $response;;	
$rt['returnCode'] = $returnCode; 

var_dump($rt);		 
 

 }
 
 
 ?>