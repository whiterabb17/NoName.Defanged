<?php

$dbname = "wk"; 							//Database name
$dbuser = "wk";							//Database login
$dbpwd 	= "wk";							//Database password
$GLOBALS['logspath'] = "logs";				//Logs folder
$GLOBALS['domain'] = "localhost";			//Domain name for loader
$GLOBALS['panel_folder'] = "panel";			//Panel folder
$GLOBALS['password'] = '$2a$10$ZggcH2744Z1YHWa5BpqAm.T9Q0c4UAX50uUUVxbHoJmFBKZi6RjEm';	//Password for login. Now: NaOLpEYru1



//Database connect
require_once $GLOBALS['panel_folder'].'/includes/rb.php';
R::setup( 'mysql:host=localhost;dbname='.$dbname, $dbuser, $dbpwd );
$odb = new PDO("mysql:host=localhost;dbname=$dbname", $dbuser, $dbpwd);
$odb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$PDO = $odb; //new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpwd);
session_start();

?>