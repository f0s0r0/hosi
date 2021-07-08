<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$colorloopcount = '';
$sno = '';
$snocount = '';
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
		
		
		$billnumber=$_REQUEST['billnumber'];
		$expirydate=$_REQUEST['expirydate'];
		
		$locationcode=$_REQUEST['locationnew'];
		$storecode=$_REQUEST['storenew'];
		$snum=$_REQUEST['snum'];
	 	
		
			$expirymonth = substr($expirydate, 0, 2);
			$expiryyear = substr($expirydate, 3, 2);
			$expiryday = '01';
			$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
		
		
		
		
		for($i=1; $i<=$snum; $i++)
		{
		
			if(isset($_REQUEST['check'.$i]))
			{
				
				$itemcode=$_REQUEST['itemcode'.$i];
				$itemname=$_REQUEST['itemname'.$i];
				$batchnumber=$_REQUEST['batchnumber'.$i];
				$avlquantity=$_REQUEST['avlquantity'.$i];
				$phyquantity=$_REQUEST['phyquantity'.$i];
				$rate=$_REQUEST['rate'.$i];
				$itemsubtotal=$rate * $phyquantity;
				if($batchnumber!="" )
				{
				
				  $medicinequery2="insert into stock_taking (itemcode, itemname, transactiondate,transactionmodule,transactionparticular,
			 billnumber, quantity, 
			 username, ipaddress, rateperunit,companyanum, companyname,batchnumber,expirydate,store,location,totalrate,allpackagetotalquantity)
			values ('$itemcode', '$itemname', '$updatedatetime', 'OPENINGSTOCK', 
			'BY STOCK ADD', '$billnumber', '$phyquantity', 
			'$username', '$ipaddress','$rate','$companyanum', '$companyname','$batchnumber','$expirydate','$storecode','$locationcode','$itemsubtotal','$avlquantity')";
			
					$execquery2=mysql_query($medicinequery2) or die(mysql_error());
				}
		
		} 
		}
		
		header("location:mainmenu1.php");
		exit;
}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'ST-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from stock_taking order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ST-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'ST-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<script type="text/javascript" src="jquery/jquery-1.11.1.js"></script>
<script>


function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here



function validcheck()
{
	if(confirm("Are You Want To Save The Record?")==false){return false;}	
}

function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	//funcCustomerDropDownSearch4();
	//funcPopupPrintFunctionCall();
	
}
function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
	
	//alert(pharmamount);
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	

}
</script>

<script>
$(function(){
    $("#submit").click(function(){
        alert("The paragraph was clicked.");
    });
});
</script>

<script>
function medicinecheck()
{
if(document.cbform12.location.value=="")
	{
		alert("Please select location name");
		document.cbform12.location.focus();
		return false;
	}
	if(document.cbform12.store.value=="")
	{
		alert("Please select store name");
		document.cbform12.store.focus();
		return false;
	}
	
	return true;
	
}

function checkqty(val,sno)
{
	var snum=sno;
	var value=val;
	
	var avlquantity=document.getElementById("avlquantity"+snum).value;
	var phyquantity=document.getElementById("phyquantity"+snum).value;
	
	if(parseInt(value) > parseInt(avlquantity))
	{
		//alert("Please enter lesser then avlquantity");
		//document.getElementById("phyquantity"+snum).value='';
		
		//return false;
	}
}
//ajax function to get store for corrosponding location
function storefunction(loc)
{
	var username=document.getElementById("username").value;
	
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("store").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax/ajaxstore.php?loc="+loc+"&username="+username,true);
xmlhttp.send();

	}
	
	function functioncheklocationandstock()
	{
		if(document.getElementById("location").value=='')
		{
		alert('Please Select Location!');
		document.getElementById("location").focus();
		return false;
		}
		if(document.getElementById("store").value=='')
		{
		alert('Please Select Store!');
		document.getElementById("store").focus();
		return false;
		}
	}
	function checkallfunc()
	{
		if(document.getElementById("checkall").checked==true)
		{
			//document.getElementById("check").checked=true;
			var checkvar = document.getElementsByClassName("check");
			for(var i=0;i<checkvar.length;i++)
			{
				checkvar[i].checked=true;
			}
		}
		else
		{
			var checkvar = document.getElementsByClassName("check");
			for(var i=0;i<checkvar.length;i++)
			{
				checkvar[i].checked=false;
			}
		}
	}
</script>
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



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall();">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform12" method="post" action="stocktaking.php" onSubmit="return medicinecheck()" >
		<table width="570" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="1" bgcolor="#CCCCCC" class="bodytext3"><strong> Stock Taking </strong></td>
               <td colspan="3" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
						$res12 = mysql_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
						
                  
                  </td> 
              </tr>
          	 <tr>
              <td align="left" valign="middle"  bgcolor="FFFFFF"  class="bodytext3"><strong>Location</strong></td>
              <td   class="bodytext3" bgcolor="FFFFFF"   colspan="3" ><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value); ajaxlocationfunction(this.value);">
             <option value="" >Select Location</option>
                  <?php
						
						$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
						while ($res = mysql_fetch_array($exec))
						{
						$reslocation = $res["locationname"];
						$reslocationanum = $res["locationcode"];
						?>
						<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>
						<?php 
						}
						?>
                  </select></td>
                   
                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
             
              </tr>
		<tr>
		  <td width="104" align="left" bgcolor="FFFFFF"  valign="center" class="bodytext31"><strong>Store</strong> </td>
          <td width="450" align="left" bgcolor="FFFFFF"  valign="center"  class="bodytext31">
		  <?php  $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 				 $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
 				 $frmflag1=isset($_REQUEST['frmflag1'])?$_REQUEST['frmflag1']:'';
				 $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';?>  
                 <select name="store" id="store" style="border: 1px solid #001E6A;">
		   <option value="">-Select Store-</option>
           <?php $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
$query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["storecode"];
				$res5name = $res5["store"];
				//$res5department = $res5["department"];
?>
<option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){echo 'selected';}?>><?php echo $res5name;?></option>
<?php }?>
		  </select>
		  </td>
		  </tr>
          <tr>
          <td align="left" valign="middle" bgcolor="FFFFFF"  class="bodytext31"><strong>Doc No</strong></td>
           <td align="left"  bgcolor="FFFFFF" class="bodytext3"  valign="top"><span >
                <input name="docnumber" type="text" id="docnumber" readonly style="border: 1px solid #001E6A;" value="<?php echo $billnumbercode; ?>" size="8" autocomplete="off">
              </span></td>
          </tr>
            <tr>
              <td align="left" valign="middle" bgcolor="FFFFFF"  class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="FFFFFF" ><input type="hidden" name="cbfrmflag12" value="cbfrmflag12">
                          <input  type="submit" id='submit' value="Search" name="submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
			      
              </tr>
	 <!-- <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				   <table id="presid" width="500" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="177" class="bodytext3">Medicine Name</td>
                      
                       <td width="69" class="bodytext3">Quantity</td>
                      <td width="72" class="bodytext3">Batch</td>
                      
                       
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                        <td><input name="medicinename" type="text" id="medicinename" size="25" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()" onClick="functioncheklocationandstock()"></td>
						
						<td><input name="quantity" type="text" id="quantity" size="8"></td>
						<td><select name="batchnumber" id="batchnumber" onFocus="return funcBatchNumberPopulate1()" onChange="return funcBatchNumberVerify1()" onBlur="return funcBatchNumberVerify2()">
			  <option value="" selected="selected">Batch</option>
              </select></td>
						<input name="expirydate" type="hidden" id="expirydate" size="8">
						<td width="169"><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
			   <tr>
              <td align="left" valign="middle" class="bodytext3"></td>
              <!--<td align="left" valign="top">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit"/>
                 </td>
            </tr>-->
          </tbody>
        </table>
		</form> 	</td>
      </tr>
      
       <tr>
        <td>&nbsp;</td>
      </tr>
      <form name="cbform1" method="post" action="stocktaking.php" onSubmit="return validcheck()">	
        <?php
				if (isset($_REQUEST["cbfrmflag12"])) { $cbfrmflag12 = $_REQUEST["cbfrmflag12"]; } else { $cbfrmflag12 = ""; }
				
				if ($cbfrmflag12 == 'cbfrmflag12')
				{
						 $locationcode = $_REQUEST['location'];
					     $storecode = $_REQUEST['store']; 
					?>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="767" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="10%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="9" bgcolor="#cccccc" class="bodytext31"><span class="bodytext311">
      
	 
					</span></td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="10%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Name </strong></div></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Avl Qty</strong></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch</strong></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Phy Qty </strong></td> 
                <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Select All<input type="checkbox" name="checkall" id="checkall" onClick="checkallfunc()"> </strong></td> 
             
     
           </tr>
			<?php
			
			
			
		  $query01="select * from transaction_stock where  storecode='".$storecode."' AND locationcode='".$locationcode."' AND batch_quantity > '0' AND batch_stockstatus ='1'   order by itemname asc";
			$run01=mysql_query($query01);
			while($exec01=mysql_fetch_array($run01))
			{
				$medanum=$exec01['auto_number'];
				$itemname=$exec01['itemname'];
				$itemcode=$exec01['itemcode'];
				$batchnumber=$exec01['batchnumber'];
				$batch_quantity=$exec01['batch_quantity'];
				$rate=$exec01['rate'];
				
					$sno=0;
					
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
           <tr <?php echo $colorcode; ?> >
              <td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" name="itemname<?php echo $snocount; ?>" id="itemname" value="<?php echo $itemname; ?>"   > 
              <input type="hidden" name="itemcode<?php echo $snocount; ?>" id="itemcode"  value="<?php echo $itemcode; ?>"  > 
                <div class="bodytext31"><?php echo $itemname; ?></div>              </td>
                <td class="bodytext31" valign="center"  align="left">
                <input type="hidden" name="avlquantity<?php echo $snocount; ?>" id="avlquantity<?php echo $snocount; ?>"  value="<?php echo $batch_quantity; ?>"  > 
                <div class="bodytext31"><?php echo $batch_quantity; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" name="batchnumber<?php echo $snocount; ?>" id="batchnumber" value="<?php echo $batchnumber; ?>"  > 
                <div class="bodytext31"><?php echo $batchnumber; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			 <input type="text"  name="phyquantity<?php echo $snocount; ?>"  id="phyquantity<?php echo $snocount; ?>" size="8" onKeyUp="return checkqty(this.value,<?php echo $snocount ?>);" > </td>
              <td class="bodytext31" valign="center"  align="left">
			 <input type="checkbox" name="check<?php echo $snocount; ?>" id="check" class="check"  value="<?php echo $medanum; ?>"   > </td>
             <input type="hidden" name="locationnew" value="<?php echo $locationcode; ?>">
                <input type="hidden" name="storenew" value="<?php echo $storecode; ?>">
                <input type="hidden" name="billnumber"  value="<?php echo $billnumbercode; ?>">
                 <input type="hidden" name="rate<?php echo $snocount; ?>"  value="<?php echo $rate; ?>">
               
           </tr>
			<?php
			
			}
			
			?>
            <input type="hidden" name="snum"  value="<?php echo $snocount; ?>">
               <tr>          <td width="10%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="9" bgcolor="#cccccc" class="bodytext31"><span class="bodytext311"></span></td></tr>
              <tr>
       <td colspan="6" align="right" valign="top"  bgcolor="E0E0E0" >
       		<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Save(Alt+S)" name="save" accesskey="s"/>
                          </td>
                          </tr>
          </tbody>
        </table></td>
      </tr>
      
	  </form>
    </table>
  </table>
  <?php 
  }
  ?>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

