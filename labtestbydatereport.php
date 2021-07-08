<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 week'));
$paymentreceiveddateto = date('Y-m-d');
$snocount='';
$colorloopcount='';
$res3recorddate = array();
$countitem  = '';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

if (isset($_REQUEST["visit_type"])) { $visit_type = $_REQUEST["visit_type"]; } else { $visit_type = ""; }

if (isset($_REQUEST["department-id"])) { $department = $_REQUEST["department-id"]; } else { $department = ""; }
if (isset($_REQUEST["department"])) { $department_name = $_REQUEST["department"]; } else { $department_name = ""; }

if($department==''){
	$department_name='';
}

if (isset($_REQUEST["ward-id"])) { $ward = $_REQUEST["ward-id"]; } else { $ward = ""; }
if (isset($_REQUEST["ward"])) { $ward_name = $_REQUEST["ward"]; } else { $ward_name = ""; }

if($ward==''){
	$ward_name='';
}


//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
	$transactiondateto = date('Y-m-d');
}

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>

  <script>
  $( function() {
    var departments = [

                        <?php
							$querya1=mysql_query("select auto_number,department from master_department");
							while($resa1=mysql_fetch_array($querya1)){
								echo "{ value: '".$resa1['auto_number']."',label: '".$resa1['department']."' },";
							}
						?>    ];
 
    $( "#department" ).autocomplete({
      minLength: 0,
      source: departments,
      focus: function( event, ui ) {
        $( "#department" ).val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#department" ).val( ui.item.label );
        $( "#department-id" ).val( ui.item.value ); 
        return false;
      }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div>" + item.label + "<br>" + item.desc + "</div>" )
        .appendTo( ul );
    };
  
  
  
    var wards = [

                        <?php
							$querya1=mysql_query("select auto_number,ward from master_ward");
							while($resa1=mysql_fetch_array($querya1)){
								echo "{ value: '".$resa1['auto_number']."',label: '".$resa1['ward']."' },";
							}
						?>    ];
 
    $( "#ward" ).autocomplete({
      minLength: 0,
      source: wards,
      focus: function( event, ui ) {
        $( "#ward" ).val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#ward" ).val( ui.item.label );
        $( "#ward-id" ).val( ui.item.value ); 
        return false;
      }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div>" + item.label + "<br>" + item.desc + "</div>" )
        .appendTo( ul );
    };
  
  
  
  } );
  
  
  function clearcode(){
	document.getElementById('department-id').value='';
}

  function clearcode1(){
	document.getElementById('ward-id').value='';
}

function Changetype(){
	if(document.getElementById('visit_type').value=='OP'){
		document.getElementById("op-data").style.display = "";
		document.getElementById("ip-data").style.display = "none";
	}else{
		document.getElementById("ip-data").style.display = "";
		document.getElementById("op-data").style.display = "none";
	}

}

  </script>
  
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<script src="js/datetimepicker_css.js"></script>
<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
             <form name="cbform1" method="post" action="labtestbydatereport.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Lab Test </strong></td>
                      <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Visit Type </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                      	<select name="visit_type" id="visit_type" onChange="Changetype()">
                        	<option value="OP" <?php if($visit_type=="OP") echo 'selected'; ?>> OP </option>
                        	<option value="IP" <?php if($visit_type=="IP") echo 'selected'; ?>> IP </option>
                        </select>
                      </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"></td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"></td>
                    </tr>


				
                    <tr id="op-data" <?php if($visit_type=='IP'){ ?> style="display:none" <?php } ?> >
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Department </td>

                      <td class="bodytext31" valign="center"  align="left" bgcolor="#FFFFFF" colspan="3">
                    <input  name="department" id="department" size="30" value="<?= $department_name ?>" onKeyUp="clearcode()">
                    <input type="hidden"  name="department-id" id="department-id" value="<?= $department ?>" >
                                            </td>
                    </tr>


                    <tr id="ip-data" <?php if($visit_type=='OP' || $visit_type==""){ ?> style="display:none" <?php } ?> >
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Ward </td>

                      <td class="bodytext31" valign="center"  align="left" bgcolor="#FFFFFF" colspan="3">
                    <input  name="ward" id="ward" size="30" value="<?= $ward_name ?>" onKeyUp="clearcode1()">
                    <input type="hidden"  name="ward-id" id="ward-id" value="<?= $ward ?>" >
                                            </td>
                    </tr>


                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>

<?php
	if($visit_type!=''){
?>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="39%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
              <td width="44%" align="center" valign="center"  
                bgcolor="#ffffff" class="style1">Quantity</td>
              </tr>


                 <tr bgcolor="#9999FF">
              <td colspan="7"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo  $visit_type;?></strong></td>
              </tr>
			  
			  <?php
			
			$total_count=0;

			if($visit_type=="OP"){

				if($department!=''){
					$query01a="select department,departmentname from master_visitentry where department='$department' group by department";
				}else{
					$query01a="select department,departmentname from master_visitentry group by department";
				}
				$exec01a=mysql_query($query01a);
				while($res01a=mysql_fetch_array($exec01a)){
			
					$total=0;
					
					$curr_dept=$res01a['department'];
					$curr_dept_name=$res01a['departmentname'];
					?>
                 <tr bgcolor="#9999FF">
              <td colspan="7"  align="left" valign="center" bgcolor="#fff" class="bodytext31"><strong><?php echo  $curr_dept_name;?></strong></td>
              </tr>

                    <?php

				$visit_code_build="''";

				$query01="select visitcode from master_visitentry where department='$curr_dept' group by visitcode";
				$exec01=mysql_query($query01);
				while($res01=mysql_fetch_array($exec01)){
	
					if($visit_code_build=="''"){
						$visit_code_build="'".$res01['visitcode']."'";
					}
					else{	
						$visit_code_build.=",'".$res01['visitcode']."'";
					}
				}


			  $query1 = "select  labitemcode,labitemname,count(auto_number) as countitem  from consultation_lab where paymentstatus = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode IN ($visit_code_build) group by labitemcode ";
			
			/*else{
			  $query1 = "select  labitemcode,labitemname,count(auto_number) as countitem  from ipconsultation_lab where consultationdate between '$transactiondatefrom' and '$transactiondateto' group by labitemcode ";
			}*/
		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		  $num1 = mysql_num_rows($exec1);
		  //echo $num1;
		  while($res1 = mysql_fetch_array($exec1))
		   {
        	 $res1itemcode = $res1['labitemcode'];
        	 $res1itemname = $res1['labitemname'];
			 
			   $countitem = $res1['countitem'];
    			$total_count+=$countitem;
				
				$total+=$countitem;
				
			 $snocount = $snocount + 1;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
             <?php echo $res1itemname; ?>           </td>
              <td class="bodytext31" valign="center"  align="center">
               <?php echo number_format($countitem,2); ?>           </td>
              </tr>
			<?php
				} 
				?>

<?php
if($total==0){
?>
      <tr bgcolor="#D3EEB7">
              <td colspan="3" class="bodytext31" valign="center"  align="left" 
                >No Records Found</td>
		</tr>
<?php
}
?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc">Total</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#cccccc"><?= number_format($total,2) ?></td>
                
            </tr>    
                
                <?php
		
				}
			}
			else if($visit_type=="IP"){


				if($ward!=''){
					$query01a="SELECT ward FROM `ip_bedallocation` where ward='$ward' group by ward 
							    UNION SELECT ward FROM `ip_bedtransfer` where ward='$ward' group by ward";
				}else{
					$query01a="SELECT ward FROM `ip_bedallocation` group by ward 
							    UNION SELECT ward FROM `ip_bedtransfer` group by ward";
				}
				$exec01a=mysql_query($query01a);
				while($res01a=mysql_fetch_array($exec01a)){
			
					$total=0;
					
					$curr_ward=$res01a['ward'];
					$curr_ward_name='';
					
					$querya01=mysql_query("select ward from master_ward where auto_number='$curr_ward'");
					if($resa01=mysql_fetch_array($querya01))
						$curr_ward_name=$resa01['ward'];
					?>
                 <tr bgcolor="#9999FF">
              <td colspan="7"  align="left" valign="center" bgcolor="#fff" class="bodytext31"><strong><?php echo  $curr_ward_name;?></strong></td>
              </tr>

                    <?php

				$visit_code_build="''";

				$query01="select visitcode from ip_bedtransfer where ward='$curr_ward' group by visitcode";
				$exec01=mysql_query($query01);
				while($res01=mysql_fetch_array($exec01)){
	
					if($visit_code_build=="''"){
						$visit_code_build="'".$res01['visitcode']."'";
					}
					else{	
						$visit_code_build.=",'".$res01['visitcode']."'";
					}
				}

				$query01="select visitcode from ip_bedallocation where visitcode NOT IN ($visit_code_build) and ward='$curr_ward' and recordstatus<>'transfered' group by visitcode";
				$exec01=mysql_query($query01);
				while($res01=mysql_fetch_array($exec01)){
	
					if($visit_code_build=="''"){
						$visit_code_build="'".$res01['visitcode']."'";
					}
					else{	
						$visit_code_build.=",'".$res01['visitcode']."'";
					}
				}

 		  $query1 = "select  labitemcode,labitemname,count(auto_number) as countitem  from ipconsultation_lab where consultationdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode IN ($visit_code_build) group by labitemcode ";
			
		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		  $num1 = mysql_num_rows($exec1);
		  //echo $num1;
		  while($res1 = mysql_fetch_array($exec1))
		   {
        	 $res1itemcode = $res1['labitemcode'];
        	 $res1itemname = $res1['labitemname'];
			 
			   $countitem = $res1['countitem'];
    			$total_count+=$countitem;
				
				$total+=$countitem;
				
			 $snocount = $snocount + 1;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
             <?php echo $res1itemname; ?>           </td>
              <td class="bodytext31" valign="center"  align="center">
               <?php echo number_format($countitem,2); ?>           </td>
              </tr>
			<?php
				} 
				?>

	<?php
    if($total==0){
    ?>
          <tr bgcolor="#D3EEB7">
                  <td colspan="3" class="bodytext31" valign="center"  align="left" 
                    >No Records Found</td>
            </tr>
    <?php
    }
    ?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc">Total</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#cccccc"><?= number_format($total,2) ?></td>
                
            </tr>    
                
                <?php
		
				}

			}
			?>
                       <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#fff"> Grand Total</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#fff"><?= number_format($total_count,2) ?></td>
                
            </tr>    
 
            <?php	

			
			
	}
			?>

          </tbody>
        </table></td>
      </tr>
    </table>
</table>


<?php include ("includes/footer1.php"); ?>
</body>
</html>
