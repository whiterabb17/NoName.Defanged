<?php 

$z = new ZipArchive();
$file ='System/Desktop.jpg'; 
$path = $_GET["path"];
if ($z->open(realpath($path))) 
{
	$stat = $z->statName($file);
	$fp   = $z->getStream($file);	
	
	header('Content-Type: image/jpeg');	
	header('Content-Length: ' . $stat['size']); 
	fpassthru($fp); 
}
else
{
	echo "file not found";
}

?>