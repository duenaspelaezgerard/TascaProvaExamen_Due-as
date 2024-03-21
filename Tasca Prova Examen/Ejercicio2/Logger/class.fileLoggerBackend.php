<?php
class fileLoggerBackend {

	private $logFile; //nombre del fichero
	private $logLevel; //nivel para registrar los mensajes
	private $confile; //connexió del fitxer

	const DEBUG = 100;
	const INFO = 75;
	const NOTICE = 50;
	const WARNING = 25;
	const ERROR = 10;
	const CRITICAL = 5;

	private function __construct() {

			$this->logLevel = 100;
			$this->logFile = "logUserApp.log";
			echo "File: ".$this->logFile."\n";

			$this->confile = fopen($this->logFile, 'a+');

	  		if (!is_resource($this->confile)){
	  			printf("No puedo abrir el fichero %s", $this->logFile);
	  			return false;
	  		}
	  		echo "Archivo abierto...\n";
	}

	public static function getInstance(){
		static $objLog;
		if(!isset($objLog)){
			$objLog = new fileLoggerBackend();
		}
		return $objLog;
	}

	public function __destruct(){
		if(is_resource($this->confile)){
			fclose($this->confile);
		}
	}


	public function logMessage($id, $estaActivo,$logLevel = fileLoggerBackend::INFO,  $fecha, $msg ){
		if ($logLevel > $this->logLevel){
			return false;
		}

		date_default_timezone_set('America/New_York');
	  	$formatterDate = DateTimeImmutable::createFromFormat('U',time());
	  	$time = $formatterDate->format('Y-m-d H:i:s');

	  	$msg = str_replace("\t", "", $msg);
	  	$msg = str_replace("\n", "", $msg);

	  	$strlogLevel = $this->levelToString($logLevel);

	  	$message = $id. "@@"."\t". $estaActivo. "@@"."\t". $strlogLevel. "@@"."\t". $time."@@"."\t"."@@"."\t".$msg."\n";
	  	fwrite($this->confile, $message);

	}

	public static function levelToString($loglevel = null){

		switch ($loglevel) {
			case fileLoggerBackend::DEBUG:
				return 'DEBUG';
				break;
			case fileLoggerBackend::INFO:
				return 'INFO';
				break;
			case fileLoggerBackend::NOTICE:
				return 'NOTICE';
				break;
			case fileLoggerBackend::WARNING:
				return 'WARNING';
				break;
			case fileLoggerBackend::ERROR:
				return 'ERROR';
				break;
			case fileLoggerBackend::CRITICAL:
				return 'CRITICAL';
				break;			
			default:
				return '[OTHER]';
				break;
		}

	}

}