<?php 

// подгрузим настройки 
include( 'u/const.php' );
include( 'u/lib.php' );

// получим идентификатор пользователя
$sUserHash = isset( $_GET['id'] ) ? htmlspecialchars( $_GET['id'] ): '' ;

//get unique id
$up_id = uniqid(); 
$sMessage = '';

if( $_POST ) {

	try{
		$oUploader = new Uploader();
		$oUploader->moveFile();
	} catch ( Exception $e ){
		$sMessage = $e->getMessage();
	}
	
	if( empty( $sMessage ) ){
		$sMessage = 'Файл успешно загружен';
	}
}

/*
 *  если в гете не передали идентификатор пользователя
 *  то нет смысла продолжать разговор
 */
if( !empty( $sUserHash ) ){
	include( '_index.php' );
} else{
	include( '_error.php' );
}



