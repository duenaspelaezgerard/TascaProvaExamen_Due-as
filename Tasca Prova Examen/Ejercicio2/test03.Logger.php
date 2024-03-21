<?php

  include_once("class.pdofactory.php");
  include_once("abstract.databoundobject.php");
  include_once("class.loguserapp.php");

  class UserApp extends DataBoundObject {

    protected $ID;
    protected $Nom;
    protected $Group;
    protected $Created;

    protected $LastUpdate;
    protected $IsActive;


    protected function DefineTableName() {
            return("userapp");
    }

    protected function DefineRelationMap() {
            return(array(
                    "id" => "ID",
                    "nom" => "Nom",
                    "group" => "Group",
                    "created" => "Created",
                    "lastUpdate" => "LastUpdate",
                    "isActive" => "IsActive"
            ));
    }
  }


  $connectionString = "file:parse\logUserApp.log";
  $connectionString2 = "pgsql:dbname=usuaris;host=localhost;port=5432;user=postgres;password=postgres";

  $urlData = parse_url($connectionString);
  $urlData2 = parse_url($connectionString2);

  var_dump($urlData);
  var_dump($urlData2);

  if (!isset($urlData['scheme'])) {
    throw new Exception("Invalid scheme connection.\n");
  }

  if (!isset($urlData2['scheme'])) {
    throw new Exception("Invalid scheme connection2.\n");
  }


  $fileName = 'Logger/class.' . $urlData['scheme'] . 'LoggerBackend.php';
  $fileName2 = 'Logger/class.' . $urlData2['scheme'] . 'LoggerBackend.php';


  include_once($fileName);
  include_once($fileName2);

  $className = $urlData['scheme'] . 'LoggerBackend';
  $className2 = $urlData2['scheme'] . 'LoggerBackend';

  print "Class Name: " . $className . "\n";
  print "Class Name: " . $className2 . "\n";

  if (!class_exists($className)) {
    throw new Exception("No loggind bakend available for " . $urlData['scheme']);
  }

  if (!class_exists($className2)) {
    throw new Exception("No loggind bakend available for " . $urlData2['scheme']);
  }


  $log = $className::getInstance();
  $log2 = $className2::getInstance();


  $strDSN = "pgsql:dbname=usuaris;host=localhost;port=5432";
  $objPDO = PDOFactory::GetPDO($strDSN, "postgres", "root",array());
  $objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $objUserApp = new UserApp($objPDO,$log,$className,$log2,$className2);
  $ahora = date('Y-m-d H:i:s');


  $objUserApp->setNom('Yaya Adri');
  $objUserApp->setGroup('Patinete Jaraca');
  $objUserApp->setLastUpdated($ahora);
  $objUserApp->setIsActive(0);
  $objUserApp->Save();

  $objUserApp->xetoNombre('Yaya Gerard');