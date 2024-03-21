<?php

include_once("class.pdofactory.php");
include_once("abstract.databoundobject.php");
include_once("class.loguserapp.php");

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
$log->logMessage('Postres logger test debug.', $className::DEBUG, 1, 1);
$log->logMessage('Postres logger test info.', $className::INFO,2, 1);
$log->logMessage('Postres logger test warning.', $className::WARNING,3, 1);

// $log2 = $className2::getInstance();
// $log2->logMessage('Postres logger test debug.', $className2::DEBUG);
// $log2->logMessage('Postres logger test info.', $className2::INFO);
// $log2->logMessage('Postres logger test warning.', $className2::WARNING);

print "Logger " . $urlData['scheme'] . " created. [END]\n";
print "Logger " . $urlData2['scheme'] . " created. [END]\n";