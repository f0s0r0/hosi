<?php
//http://davidwalsh.name/backup-mysql-database-php
date_default_timezone_set('Africa/Nairobi'); 

//Values From db_connect.php file.
$localhost = $hostname;
$dbusername = $hostlogin;
$password = $hostpassword;
$databasename = $databasename;

backup_tables($localhost, $dbusername, $password, $databasename);

/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{
	$backuptime = date('YMd_His');
	$backupdatabasefiletime = date('Y-m-d H:i:s');
	$username = $_SESSION["username"];
	$ipaddress = $_SERVER["REMOTE_ADDR"];
	
	$backupdatabasefilename = 'DB_Backup_'.$backuptime.'.sql';
	$backupdatabasefiletime =  $backupdatabasefiletime;
	
	$query1db = "insert into master_backupdatabase (backupfilename, backupfiledate, username, ipaddress) 
	values ('$backupdatabasefilename', '$backupdatabasefiletime', '$username', '$ipaddress')";
	$exec1db = mysql_query($query1db) or die ("Error in Query1db".mysql_error());

	$return = '';
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		//$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					
					//Slash after and before double quote is compulsory.
					$patterns = "/\n/";
					$replacements = "/\\n/";
					$string = $row[$j]; 
					
					//$row[$j] = preg_replace("\n","\\n",$row[$j]); 
					$row[$j] = preg_replace($patterns, $replacements, $string);
					
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//$backuptime = date('YMd_His');
	//$backupdatabasefiletime = date('Y-m-d H:i:s');
	//$username = $_SESSION["username"];
	//$ipaddress = $_SERVER["REMOTE_ADDR"];

	//save file
	//$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	
	$handle = fopen('zbackupdatabasefiles/DB_Backup_'.$backuptime.'.sql','w+'); //z given to list folders at the end.
	fwrite($handle,$return);
	fclose($handle);
	
	//$backupdatabasefilename = 'DB_Backup_'.$backuptime.'.sql';
	//$backupdatabasefiletime =  $backupdatabasefiletime;
	
	//$query1db = "insert into master_backupdatabase (backupfilename, backupfiledate, username, ipaddress) 
	//values ('$backupdatabasefilename', '$backupdatabasefiletime', '$username', '$ipaddress')";
	//$exec1db = mysql_query($query1db) or die ("Error in Query1db".mysql_error());
	
}


?>