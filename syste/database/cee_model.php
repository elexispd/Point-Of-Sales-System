<?php



class Cee_Model extends db{
	
	
	 function __construct(){}



	
	
    static function __LoadModel($model){
	$dfg = "ceeinc/model/".$model.".php";
	if(is_file($dfg)){
		require_once($dfg);
		}else{
			Cee_assets::throError("Sorry , Model ".$model." does not exist");
			}
	}
	static function loadModel($fun){
	
	foreach($fun as $dked){
		if(is_file("ceeinc/model/".$dked.".php")){
		
		require_once("ceeinc/model/".$dked.".php");
		
		}else{
			
		Cee_assets::throError("Sorry , Model ".$dked." does not exist");
			
			}
		}
	 } 

	static function query($sql){
		$conn = db::createion();
		$result[0] = $conn->query($sql);
		$result[1] = $conn;
		return $result;
		}
	 static function encryption_key(){
		return md5("cee");
	}
	
	static function apploading($thirsparty){  
		foreach($thirsparty as $dked){
			if(is_file("ceeinc/ceeparty/".$dked.".php")){
				require_once("ceeinc/ceeparty/".$dked.".php");
			}else{	
				Cee_assets::throError("Sorry , ceeparty ".$dked." does not exist");
			}
		}
	}





}






?>