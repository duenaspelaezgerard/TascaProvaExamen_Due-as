<?php
include_once("class.loguserapp.php");

class pgsqlLoggerBackend {

	private $logFile; 
	private $logLevel; 
	private $confile; 

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
	  		echo "File opened...\n";
	}

	public static function getInstance(){
		static $objLog;
		if(!isset($objLog)){
			$objLog = new pgsqlLoggerBackend();
		}
		return $objLog;
	}

	public function __destruct(){
		if(is_resource($this->confile)){
			fclose($this->confile);
		}
	}


	public function logMessage($id, $estaActivo,  $fecha, $msg, $logLevel = pgsqlLoggerBackend::INFO){

		if ($logLevel > $this->logLevel){
			return false;
		}
	
        $strDSN = "pgsql:dbname=usuaris;host=localhost;port=5432";
        $objPDO = PDOFactory::GetPDO($strDSN, "postgres", "postgres",array());
        $objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		
		date_default_timezone_set('America/New_York');
		$formatterDate = DateTimeImmutable::createFromFormat('U',time());
		$time = $formatterDate->format('Y-m-d H:i:s');

		$msg = str_replace("\t", "", $msg);
		$msg = str_replace("\n", "", $msg);

		$strlogLevel = $this->levelToString($logLevel);

		$message = $time."\t".$strlogLevel."\t".$msg."\n";
		
		if (isset($id)) {
			$IdLog = $id;
		} else {
			$IdLog = 0;
		} 


		$objLog = new LogUserApp($objPDO);
		$objLog->setIDUserApp($IdLog);
		$objLog->setComentari($msg);
		$objLog->setCodi($logLevel);
	   	$objLog->setIsActive($estaActivo);
		$objLog->Save();
		

	}

	public static function levelToString($loglevel = null){

		switch ($loglevel) {
			case pgsqlLoggerBackend::DEBUG:
				return 'DEBUG';
				break;
			case pgsqlLoggerBackend::INFO:
				return 'INFO';
				break;
			case pgsqlLoggerBackend::NOTICE:
				return 'NOTICE';
				break;
			case pgsqlLoggerBackend::WARNING:
				return 'WARNING';
				break;
			case pgsqlLoggerBackend::ERROR:
				return 'ERROR';
				break;
			case pgsqlLoggerBackend::CRITICAL:
				return 'CRITICAL';
				break;			
			default:
				return '[OTHER]';
				break;
		}

	}

}