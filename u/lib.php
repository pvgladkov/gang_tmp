<?php

/**
 * 
 */
include( 'const.php' );

class Uploader{
	
	/**
	 * Временное имя файла
	 * @var string 
	 */
	private $sFileName;
	
	/**
	 * Имя файла у нас в хранилище
	 * @var string 
	 */
	private $sNewFileName;

	/**
	 * Оригинальное имя файла
	 * @var string 
	 */
	private $sOriginalName;
	
	/**
	 * Хэш идентификатора пользователя
	 * @var string
	 */
	private $sUserHash;
	
	/**
	 * Заголовок
	 * @var string 
	 */
	private $sTitle;

	/**
	 * Комментарий
	 * @var string
	 */
	private $sComment;

	/**
	 * 
	 * @param type $aFileData
	 * @param type $sUserHash
	 */
	public function __construct( ){
		
		$this->setComment();
		$this->setFileName();
		$this->setTitle();
		$this->setUserHash();
		
		// определим как назвать новый файл
		$this->setNewFileName();
	}

	/**
	 * Установить временное имя файла
	 */
	private function setFileName(){
		
		$this->sFileName = $_FILES['file']['tmp_name'];
		$this->sOriginalName = $_FILES['file']['name'];
	}

	/**
	 * Установить хэш идентификатора пользователя
	 * @throws Exception
	 */
	private function setUserHash(){
		
		$sUserHash = htmlspecialchars( $_POST['id'] );
		if( empty( $sUserHash ) ){
			throw new Exception( 'Неверный пользователь' );
		}
		
		$this->sUserHash = $sUserHash;
	}
	
	/**
	 * Установить заголовок
	 */
	private function setTitle(){
		$this->sTitle = htmlspecialchars( $_POST['title'] );
	}
	
	/**
	 * Установить комментарий
	 */
	private function setComment(){
		$this->sComment = htmlspecialchars( $_POST['comment'] );
	}

	/**
	 * Переместить файл
	 * @throws Exception
	 */
	public function moveFile(){

		if( is_uploaded_file( $this->sFileName )) {
			
			$sValid = $this->validateUser();
			if( $sValid == Response::BAD_USER ){
				throw new Exception( Response::getMessageByCode( $sValid ) );
			}
			
			// Если файл загружен успешно, перемещаем его из временной директории в конечную
			$bResult = move_uploaded_file( $this->sFileName, VIDEO_DIR.'/'.$this->sNewFileName );
		} else {
			$bResult = false;
		}	
		
		if( $bResult ){
			$sResult = $this->sentNotify();
			
			if( $sResult != Response::OK ){
				
				throw new Exception( Response::getMessageByCode( $sResult ) );
			}
		} else {
			mail( 'gladkov@idealprice.ru', 'ошибка при загрузке файла', '' );
			throw new Exception( 'Произошла ошибка. Пожалуйста, попробуйте загрузить файл позже.' );
		}
	}
	
	/**
	 * сообщить серверу ИЦ, что файл успешно загружен
	 */
	private function sentNotify(){
		
		$sUsrl = 'http://'.IP_URL.'/quiz/status';
	
		$aParams = array(
			'user_hash'	=> $this->sUserHash,
			'filename'	=> $this->sNewFileName,
			'status'	=> 1,
			'title'		=> $this->sTitle,
			'comment'	=> $this->sComment
		);
		
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $sUsrl );
		curl_setopt( $curl, CURLOPT_POST, count( $aParams ) );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $aParams );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		
		$sResult = curl_exec( $curl );	
		
		return $sResult;
	}
	
	/**
	 * Получить временное имя файла
	 * @return string
	 */
	public function getFileName(){
		return $this->sFileName;
	}
	
	/**
	 * Установоить имя файла для хранения у нас
	 * @throws Exception
	 */
	private function setNewFileName(){
		
		$sTimeStamp = time();
		
		// узнаем расширение файла
		$sExt =  substr( strrchr( $this->sOriginalName, '.' ), 1 );
		
		if( empty( $sExt ) ){
			throw new Exception( 'Неверный формат файла' );
		}
		
		// комбинация хэша и метки времени
		$this->sNewFileName = $this->sUserHash.'-'.$sTimeStamp .'.'.$sExt; 
	}
	
	/**
	 * 
	 * @return string
	 */
	private function validateUser(){
		
		$sUsrl = 'http://'.IP_URL.'/quiz/status';
	
		$aParams = array(
			'user_hash'	=> $this->sUserHash,
			'status'	=> 1,
			'test_flag'	=> 1 // флаг, который говорит, что надо просто проверить валидность хэша
		);
		
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $sUsrl );
		curl_setopt( $curl, CURLOPT_POST, count( $aParams ) );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $aParams );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		
		$sResult = curl_exec( $curl );	
		
		return $sResult;
	}
	
}

/**
 * класс для обработки ответов от ИЦ
 */
class Response {
	
	const OK = 'ok';
	
	const BAD_STATUS = 'bad_status';
	
	const BAD_USER = 'bad_user';
	
	const VALID_USER = 'valid_user';
	
	const ABORT = 'abort';
	
	private static  $aMessages = array(
		self::BAD_STATUS	=> 'При загрузке файла произошла ошибка. Попробуйте повторить позже.',
		self::BAD_USER		=> 'Неверный URL для загрузки',
		self::OK			=> 'все хорошо',
		self::VALID_USER	=> 'норм',
		self::ABORT			=> 'При загрузке файла произошла ошибка. Попробуйте повторить позже.',
	);
	
	/**
	 * 
	 * @param string $sCode
	 * @return string
	 */
	public static function getMessageByCode( $sCode ){
		
		if( isset( self::$aMessages[ $sCode ] ) ){
			return self::$aMessages[ $sCode ] ;
		}
		
		return '';
	}
	
}
