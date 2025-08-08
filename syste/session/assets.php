
<?php



class Cee_assets{
	
	
	public static function loadAssets($value){
	if(!is_file(EXTERNAL_FOLDER."/".$value)){
	      exit("Sorry File does not exist");
		}else{
		echo BASE_URL."".EXTERNAL_FOLDER."/".$value;}
		}
	
	static function throError($err){
		exit($err." , see CEE package for guidance");
		}
	static function Assets(){
		include("syste/main/assets.php");
		}
		
		static function Assetsre(){
		include("syste/main/revolveall.php");
		}
	
	}
















?>