<?php

spl_autoload_register(function($classe){

	$diretorio = array(
		'1' => 'dataAccess',
		'2' => 'class'
	);

	foreach ($diretorio as $value) {
		$fileName = $value . DIRECTORY_SEPARATOR . $classe . ".php" ;
		if(file_exists($fileName)){
			require_once($fileName);
		}
	}


});
?>