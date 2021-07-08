<?php
session_start();
set_time_limit(0);
//include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$dateonly = date('Ymd');
$timeonly = date('His');

//This file compares two database and updates missing table, field and field types to destination database.
//Run this file after updating php files.
//Put skeleton database at updates_download/simaclehospitalcomparesource.sql


//*******************************************************************************

//	IMPORTANT : PLEASE CHANGE DESTINATION DATABASE NAME TO LIVE DATABASE NAME //

	//$destinationdbname = 'simaclehospitaldestination'; //CHANGE ONLY THIS TO LVE DB NAME.
	$destinationdbname = 'billingretail'; //CHANGE ONLY THIS TO LVE DB NAME.
	
	$sourcedbname = 'simaclebillingretailcomparesource';
	
	$sourcedbfilepath = 'updates_download/simaclebillingretailcomparesource.sql';
	
	//$comparisonsourcedatabasecontents = file_get_contents($sourcedbfilepath); //TO CHECK FILE EXISTANCE
	if (file_exists($sourcedbfilepath)) 
	{
		echo "<br><br>Success : File $sourcedbfilepath Exists.";
	} 
	else 
	{
		echo "<br><br>Failed : File $sourcedbfilepath Not Found.";
		exit;
	}

//********************************************************************************

if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }
//$username = $_SESSION["username"];

if (isset($_REQUEST["submit"])) { $submit = $_REQUEST["submit"]; } else { $submit = ""; }

if ($submit == 'Yes. Proceed.')
{

	echo "<br><br>Update Started : ".date('Y-m-d H:i:s');
	
	//To compare running and revised database to update the missing tables and columns and update data types.
	$dbhostname = 'localhost';
	$dbusername = 'root';
	$dbpassword = '';

	$sourcedbconnect1 = mysql_connect($dbhostname, $dbusername, $dbpassword);

	//To find compare source database already exists. If not create it.
	///*
	$query1compare = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$sourcedbname' ";
	$exec1compare = mysql_query($query1compare, $sourcedbconnect1) or die ("Error in Query1compare".mysql_error());
	$rowcount1compare = mysql_num_rows($exec1compare);
	if ($rowcount1compare != 0)
	{
		//To drop the existing comparison source database.
		$query2compare = "DROP database $sourcedbname";
		$exec2compare = mysql_query($query2compare, $sourcedbconnect1) or die ("Error in Query1compare".mysql_error());

		//To create new comparison source database.
		$query3compare = "CREATE DATABASE $sourcedbname";
		$exec3compare = mysql_query($query3compare, $sourcedbconnect1) or die ("Error in Query3compare".mysql_error());
	}
	else
	{
		//To create new comparison source database.
		$query3compare = "CREATE DATABASE $sourcedbname";
		$exec3compare = mysql_query($query3compare, $sourcedbconnect1) or die ("Error in Query3compare".mysql_error());
	}
	//*/
	
	

	mysql_select_db($sourcedbname, $sourcedbconnect1);
	
	///*
	
	//To dump the skeleton comparison source database into created database.
	//Here is a memory-friendly function that should be able to split a big file in individual queries without needing to open the whole file at once
	//http://stackoverflow.com/questions/1883079/best-practice-import-mysql-file-in-php-split-queries/2011454#2011454
		
	$file = $sourcedbfilepath;
	//$fileimport1 = SplitSQL();
	
	//function SplitSQL($file, $delimiter = ';')
	//{
		set_time_limit(0);
		$delimiter = ';';
	
		if (is_file($file) === true)
		{
			$file = fopen($file, 'r');
	
			if (is_resource($file) === true)
			{
				$query = array();
	
				while (feof($file) === false)
				{
					$query[] = fgets($file);
	
					if (preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1)
					{
						$query = trim(implode('', $query));
	
						if (mysql_query($query, $sourcedbconnect1) === false)
						{
							//echo '<h3>ERROR: ' . $query . '</h3>' . "\n";
							//echo '<br><br>';
							echo mysql_error();
						}
	
						else
						{
							//echo '<h3>SUCCESS: ' . $query . '</h3>' . "\n";
						}
						while (ob_get_level() > 0)
						{
							ob_end_flush();
						}
	
						flush();
					}
	
					if (is_string($query) === true)
					{
						$query = array();
					}
				}
	
				//return fclose($file);
				fclose($file);
			}
		}
	
		//return false;
	//}
	
	
	//*/
		
	$destinationdbconnect1 = mysql_connect($dbhostname, $dbusername, $dbpassword, true); 


	///*
	$query1compare = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$destinationdbname' ";
	$exec1compare = mysql_query($query1compare, $destinationdbconnect1) or die ("Error in Query1compare".mysql_error());
	$rowcount1compare = mysql_num_rows($exec1compare);
	if ($rowcount1compare == 0)
	{
		//To create new comparison source database.
		$query3compare = "CREATE DATABASE $destinationdbname";
		$exec3compare = mysql_query($query3compare, $destinationdbconnect1) or die ("Error in Query3compare".mysql_error());
	}
	
	//*/
	
	
	
	
	
	mysql_select_db($destinationdbname, $destinationdbconnect1);
	
	
	
	
	
	///*
	
	//To compare all the tables from source database are available with desitination database.
	$query5 = "SHOW TABLES FROM $sourcedbname";
	$exec5 = mysql_query($query5, $sourcedbconnect1);
	while ($line = mysql_fetch_row($exec5)) 
	{
		$tablename = $line[0];
		//echo '<br>'.$tablename;

		$query6 = "SHOW TABLES LIKE '$tablename'";
		$exec6 = mysql_query($query6, $destinationdbconnect1) or die ("Error in Query6".mysql_error());
		$rowcount6 = mysql_num_rows($exec6);
		if ($rowcount6 == 0)
		{
			echo '<br>'.$tablename.' Table Not Found.';
			//Table with auto number creation working.
			$query7 = "CREATE TABLE $tablename (auto_number INT(255) NOT NULL AUTO_INCREMENT, PRIMARY KEY (auto_number))";
			$exec7 = mysql_query($query7, $destinationdbconnect1) or die ("Error in Query7".mysql_error());
		}
		
	}
	//*/





	///*

	//To compare all the fields from source database are available with desitination database.
	$query8 = "SHOW TABLES FROM $sourcedbname";
	$exec8 = mysql_query($query8, $sourcedbconnect1);
	while ($res8 = mysql_fetch_row($exec8)) 
	{
		$res8tablename = $res8[0];
		//echo '<br>'.$res8tablename;
		
		$query9 = "SHOW COLUMNS FROM $res8tablename";
		$exec9 = mysql_query($query9, $sourcedbconnect1) or die ("Error in Query9".mysql_error());
		while ($res9 = mysql_fetch_array($exec9))
		{
			$res9fieldname = $res9[0];
			//echo '<br>'.$res9fieldname;
			$res9fieldtype = $res9[1];
			//echo '<br>'.$res9fieldtype;
			
			$query10 = "SHOW COLUMNS FROM $res8tablename LIKE '$res9fieldname'";
			$exec10 = mysql_query($query10, $destinationdbconnect1) or die ("Error in Query10".mysql_error());
			$rowcount10 = mysql_num_rows($exec10);
			if ($rowcount10 == 0)
			{
				echo '<br>'.$res9fieldname;
				echo ' - Field Not Found.';
				$query11 = "ALTER TABLE $res8tablename ADD $res9fieldname $res9fieldtype";
				$exec11 = mysql_query($query11, $destinationdbconnect1) or die ("Error in Query11".mysql_error());
			}
		}
	}
	//*/







	///*
	//To compare all the field type from source database are available with desitination database.
	$query12 = "SHOW TABLES FROM $sourcedbname";
	$exec12 = mysql_query($query12, $sourcedbconnect1);
	while ($res12 = mysql_fetch_row($exec12)) 
	{
		$res12tablename = $res12[0];
		//echo '<br>'.$res8tablename;
		
		$query13 = "SHOW COLUMNS FROM $res12tablename";
		$exec13 = mysql_query($query13, $sourcedbconnect1) or die ("Error in Query13".mysql_error());
		while ($res13 = mysql_fetch_array($exec13))
		{
			$res13fieldname = $res13[0];
			//echo '<br>'.$res9fieldname;
			$res13fieldtype = $res13[1];
			//echo '<br>'.$res9fieldtype;
			
			$query14 = "SHOW COLUMNS FROM $res12tablename LIKE '$res13fieldname'";
			$exec14 = mysql_query($query14, $destinationdbconnect1) or die ("Error in Query14".mysql_error());
			while ($res14 = mysql_fetch_array($exec14))
			{
				$res14fieldtype = $res14[1];
				//echo '<br>'.$res14fieldtype;
				
				if ($res14fieldtype != $res13fieldtype)
				{
					echo '<br>'.$res12tablename.' '.$res13fieldname.' Field Type Mismatch';
					
					$query11 = "ALTER TABLE $res12tablename CHANGE $res13fieldname $res13fieldname $res13fieldtype";
					$exec11 = mysql_query($query11, $destinationdbconnect1) or die ("Error in Query11".mysql_error());
				}
			}
		}
	}
	//*/




	echo "<br><br>Update Completed : ".date('Y-m-d H:i:s');


}
else
{
	if (isset($_REQUEST["submit"])) { $submit = $_REQUEST["submit"]; } else { $submit = ""; }
	
	if ($submit == 'No. Cancel Updates.')
	{
		echo "Updates Apply Cancelled. Not Applied.";
		exit;
	}
}


?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><strong>Please Take Database Manual Backup Before  Proceeding. Please Follow Backup Procedure Always.</strong>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Yes I have Taken Backup. Please Proceed To Apply Updates.</p>
<p></p>
<form id="updatesapply1" name="updatesapply1" method="post" action="">
<input type="hidden" name="updatesapply1" id="updatesapply1" value="updatesapply1" />
<input type="submit" name="submit" value="Yes. Proceed." style="border: 1px solid #001E6A"/>
<input type="submit" name="submit" value="No. Cancel Updates." style="border: 1px solid #001E6A"/>
</form>
<p></p>