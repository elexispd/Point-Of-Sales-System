<?php



class ceemain{
	
	function view($view){
		if(is_file(VIEW_DIR."/".$view.".php")){
		include(VIEW_DIR."/".$view.".php");
		}else{
			Cee_assets::throError("Sorry, View file does not exists");
			}
	 }
	function &load(){
		
		
		}

	
}











?>