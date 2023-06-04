<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once '../../db.php';

if(isset($_POST['func']))
{
	switch (trim($_POST['func'])) {
	case "clearDB":
		clearDB();
		break;
	case "dublicate":
		dublicate();
		break;
	}
}



function clearDB(){
	R::wipe('grabrule');
	R::wipe('loader');
	R::wipe('log');
	R::wipe('markerrule');
	R::wipe('topsites');
	$stats = R::findAll("statistics_countries");
	foreach ($stats as $stat)
	{
		$stat->count_c = 0;
		R::store($stat);
	}
	$browsers = R::findAll("browsers");
	foreach ($browsers as $browser)
	{
		$browser->count_c = 0;
		R::store($browser);
	}
};

//////////////////////

function dublicate(){
	$settings = R::load('settings', 1);
	$settings->dublicates = (boolean)json_decode(strtolower($_POST['check'])); 
	R::store($settings);
	echo $result = json_encode($settings->dublicates);	
}


?>
											