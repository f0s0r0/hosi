<html>
<?php include ("db/db_connect.php"); ?>
<?php
$timeonly = date('H:i:s');
$updatedatetime = date('Y-m-d H:i:s');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
if(isset($_POST['patient'])){$searchpatient = $_POST['patient'];}else{$searchpatient="";}
if(isset($_POST['patientcode'])){$searchpatientcode=$_POST['patientcode'];}else{$searchpatientcode="";}
if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}
if(isset($_POST['doctor'])){$searchdoctor = $_POST['doctor'];}else{$searchdoctor="";}
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
?>
<style>
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
<script src="js/datetimepicker_css.js"></script>
<body>
<blockquote>
  <table width="54%">
    <tr>
      <td width="99%" valign="top"><table width="106%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="793"><form name="cbform1" method="post" action="publishedpaediatriclistiframe.php">
                <table width="604" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr>
                      <td colspan="4" align="left" valign="middle"  bgcolor="#cccccc" class="bodytext3"><strong><strong>Published List</strong></strong></td>
                    </tr>
                    <tr>
                      <td width="88" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                        <input name="patient" type="text" id="patient" value="" size="52" autocomplete="off">
                      </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Reg No</td>
                      <td width="136" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                        <input name="patientcode" type="text" id="patient" value="" size="20" autocomplete="off">
                      </span></td>
                      <td width="58" align="left" valign="middle"  bgcolor="#FFFFFF"><span class="bodytext3">Visit No</span></td>
                      <td width="290" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                        <input name="visitcode" type="text" id="visitcode" value="" size="19" autocomplete="off">
                      </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doctor</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input name="doctor" type="text" id="doctor" value="" size="20" autocomplete="off"></td>
                    </tr>
                    <tr>
                      <td width="88" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
                      <td width="136" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="58" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
                      <td width="290" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
            </form></td>
          </tr>
          <tr>
            <td><table width="94%" height="80" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >
                <tbody>
                  <tr>
                    <td class="bodytext31">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="49%"  align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient</strong></div></td>
                    <td width="32%"  align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department</strong></div></td>
                    <td width="18%"  align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor </strong></div></td>
                  </tr>
                  <?php
			
			$colorloopcount = '';
			$sno = '';
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		
		$query11 = "select Distinct recorddate as recdate from master_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and username like '%$searchdoctor%' and  results='completed' and closevisit = '' and recorddate between '$fromdate' and '$todate' group by patientvisitcode,recorddate order by auto_number desc";
		$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		$num11=mysql_num_rows($exec11);
		
		while($res11 = mysql_fetch_array($exec11))
		{
		$res11recorddate=$res11['recdate'];
		
			if( $res11recorddate != '')
		{
		?>
                  <?php 
			 $query121 = "select distinct recorddate as rdate from master_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and username like '%$searchdoctor%' and  results='completed' and closevisit = '' and recorddate = '$res11recorddate'  group by patientvisitcode,recorddate order by auto_number desc";
			$exec121 = mysql_query($query121) or die ("Error in Query121".mysql_error());
			while ($res121 = mysql_fetch_array($exec121))
			{
		     $res121recorddate = $res121['rdate'];
			 if($res121recorddate != '')
			  {
			?>
                  <tr bgcolor="#cccccc">
                    <td colspan="14"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo $res11recorddate;?></strong></td>
                  </tr>
                  <?php } } ?>
                  <?php
		}		
					
		$query1 = "select * from master_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and username like '%$searchdoctor%' and  results='completed' and closevisit = '' and recorddate = '$res11recorddate'  group by patientvisitcode,recorddate order by auto_number desc";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		
		$res1patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['patientvisitcode'];
		$accountname = $res1['accountname'];
		$requestedbyname = $res1['username'];
		
		
		$query43 = "select * from master_visitentry where visitcode='$visitcode'";
		$exec43 = mysql_query($query43) or die(mysql_error());
		$res43 = mysql_fetch_array($exec43);
		$opdate = $res43['consultationdate'];
		$dept = $res43['departmentname'];
		$deptcheck = $res43['department'];
		$patientname = $res43['patientfirstname'];
		$age = $res43['age'];
		$gender = $res43['gender'];

		
				
			$query21 = "select * from master_consultationlist where visitcode='$visitcode' order by auto_number";
			$exec21 = mysql_query($query21) or die(mysql_error());
			$num21 = mysql_num_rows($exec21);
			
			$res21 = mysql_fetch_array($exec21);
			$consultationdatetime = $res21['consultationdate'];
			$consultationdatetime2 = strtotime($consultationdatetime);
		    $consultationdatetime1 = strtotime($consultationdatetime . ' + 1 day');
			$updatedatetime1 = strtotime($updatedatetime);
			
						
			$consultationdate1 = date('Y-m-d', $consultationdatetime2);
			
			if($deptcheck==10)
			{
			
		
							
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
		
		   
			?>
                  <tr <?php echo $colorcode; ?>>
                    <td class="bodytext31" valign="center"  align="left"><div align="left"> <a target="_parent" href="paediatricresultscheck.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"> <strong><?php echo $res1patientname; ?> (<?php echo $patientcode; ?>,<?php echo $visitcode; ?>),<?php echo $gender; ?>,<?php echo $age; ?></strong> </a> </div></td>
                    <td class="bodytext31" valign="center"  align="left"><?php echo $dept; ?></td>
                    <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $requestedbyname;?></div></td>
                  </tr>
                  <?php
			}
			}  
		 }	  
		?>
                  <tr>
                    <td colspan="3" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
                  </tr>
                </tbody>
            </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
</blockquote>
</body>
</html>