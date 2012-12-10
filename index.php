<?
include dirname(__FILE__).'/u/UploadHandler.php';

if( 
    isset( $_GET['id'] ) 
    &&
    UploadHandler::validateUser( $_GET['id'] ) != Response::BAD_USER
) {
    include '_index.php';
}else{
    header( 'Location: '.'http://'.IP_URL );
}