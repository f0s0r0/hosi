<?php
//Simacle Billing Software - Version 7.0 - Released Jan 2012
//Simacle Billing Software - Version 8.0 - Released 21Nov2012 Wednesday
$titlestr = '';
include ("includes/pagetitle1.php");
//include ("db/db_connect.php");
$urlpath = explode('/',$_SERVER['REQUEST_URI']);

?>

<script type="text/javascript">
function date_time(id)
{
        date = new Date;
        year = date.getFullYear();
        month = date.getMonth();
        months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        d = date.getDate();
        day = date.getDay();
        days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        result = ''+days[day]+', '+months[month]+' '+d+', '+year+' '+h+':'+m+':'+s;
        document.getElementById(id).innerHTML = result;
        setTimeout('date_time("'+id+'");','1000');
        return true;
}

function funccheck()
{
var varUserChoice; 
	varUserChoice = confirm('DO YOU LIKE TO END YOUR SHIFT?PLEASE CLICK YES TO SHIFT OUT OR CLICK CANCEL'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		
		return false;
	}
}
function lockscreen()
{
	document.getElementById('imgloader').style.display='block';
	
	document.body.style.overflow='hidden';
	
}

function enablescreen()
{
	document.getElementById('imgloader').style.display='none';
	document.body.style.overflow='auto';
	
	
}

function stopRKey(evt) {

  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
}


document.onkeydown = function(e)
{
	
	/*if (e.target.nodeName.toUpperCase() != 'INPUT' && e.target.nodeName.toUpperCase() != 'TEXTAREA')
		//return (e.keyCode != 8);
		
	if (e.target.nodeName.toUpperCase() != 'INPUT')
		//return (e.keyCode != 13); */
}

document.onkeypress = stopRKey; 


function loginoutfunction()
{
	var hrlogout = new XMLHttpRequest();
	var username = document.getElementById("username").value;
	var timelimit = document.getElementById("timelimit").value;
	var timeout = document.getElementById("timeout").value;	
	var vars = "action=sessioncheck&&username="+username+"&&timelimit="+timelimit+"&&timeout="+timeout;
	var url = "chk_session.php?"+vars;  	
	hrlogout.open("POST", url, true);	
	hrlogout.setRequestHeader("Content-type", "application/x-www-form-urlencoded");	
	hrlogout.onreadystatechange = function() 
	{
		if(hrlogout.readyState == 4 && hrlogout.status == 200) 
		{
			var return_data = hrlogout.responseText;
			if(return_data=='1')
			{
				//alert(return_data);
				document.getElementById("mainlogindiv").style.display = "";
				document.body.style.overflow='hidden';
				window.scrollTo(0,0);
				setTimeout(loginoutfunction, 2000);
			}
			else if(return_data=='0')
			{
				document.getElementById("mainlogindiv").style.display = "none";
				document.body.style.overflow='auto';
				setTimeout(loginoutfunction, 2000);
			}
			else if(return_data=='2')
			{
				window.location.href = "logout1.php";
			}
			else if(return_data=='3')
			{
				window.location.href = "shiftwisereport2.php?anum=254";
			}
		}
	}
	
	hrlogout.send(vars);
}
function loginfunction()
{
	document.getElementById("alertlogmsg").innerHTML = 'Verifying User';
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	var locdocno = document.getElementById("locdocno").value;
	document.getElementById("login").disabled=true;
	document.getElementById("logout").disabled=true;
	var hrlogout = new XMLHttpRequest();	
	var vars = "action=loginuser&&username="+username+'&&password='+password+'&&locdocno='+locdocno;
	var url = "chk_session.php?"+vars; 
	hrlogout.open("POST", url, true);	
	hrlogout.setRequestHeader("Content-type", "application/x-www-form-urlencoded");	
	hrlogout.onreadystatechange = function() 
	{
		if(hrlogout.readyState == 4 && hrlogout.status == 200) 
		{
			var return_data = hrlogout.responseText;
			//alert(return_data);
			var return_data = hrlogout.responseText;
			//alert(return_data);
			var splitreturn_data = return_data.split('||');
			var splitreturn_data0 = splitreturn_data[0];
			var splitreturn_data1 = splitreturn_data[1];
			var splitreturn_data2 = splitreturn_data[2];
			if(splitreturn_data0=='1')
			{			
				document.getElementById("mainlogindiv").style.display = "none";				
				document.body.style.overflow='auto';
				document.getElementById("alertlogmsg").innerHTML = '';	
				document.getElementById("password").value='';	
				document.getElementById("timelimit").value=splitreturn_data1;	
				document.getElementById("locdocno").value=splitreturn_data2;	
				setTimeout(loginoutfunction, 2000);
			}
			else if(splitreturn_data0=='0')
			{
				document.getElementById("alertlogmsg").innerHTML = 'Login Failed. Please Try Again With Proper User Id and Password.';
				document.getElementById("password").value='';
				document.body.style.overflow='hidden';
			}
		}
	}
	
	hrlogout.send(vars);
}

function logoutfunction()
{	
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	var locdocno = document.getElementById("locdocno").value;
	var hrlogout = new XMLHttpRequest();	
	var vars = "action=logoutuser&&username="+username+'&&password='+password+'&&locdocno='+locdocno;
	var url = "chk_session.php?"+vars; 
	hrlogout.open("POST", url, true);	
	hrlogout.setRequestHeader("Content-type", "application/x-www-form-urlencoded");	
	hrlogout.onreadystatechange = function() 
	{
		if(hrlogout.readyState == 4 && hrlogout.status == 200) 
		{
			var return_data = hrlogout.responseText;
			//alert(return_data);
			if(return_data=='logoutuser')
			{			
				window.location.href = "logout1.php";
			}			
		}
	}
	
	hrlogout.send(vars);
	
}
<?php if($urlpath[2]!='shiftwisereport2.php?anum=254') {?>
//setTimeout(loginoutfunction, 2000);
<?php } ?>
</script>
<style type="text/css">

.style4TM1 {font-size: 20px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #000099;}


#alertloader,#imgloader{
position: absolute;
top: 0px;
left: 0px;
width:100%;
height:100%;
background:rgba(54, 25, 25, .5);
}
#maindivlogin,#mainlogindiv{
position: absolute;
top: 0px;
left: 0px;
width:100%;
height:100%;
background:#000;
}
</style>
<?php
$locationshortname='';
if (isset($_SESSION['docno'])) { $sessiondocno = $_SESSION['docno']; } else { $sessiondocno = ""; }
if (isset($_SESSION['username'])) { $sessionusername = $_SESSION['username'];$username = $_SESSION['username']; } else { $sessionusername = ""; }
$timelimit = $_SESSION['timelimit']; 
$timeout = $_SESSION['timeout'];
//$sessiondocno = $_SESSION['docno'];
if($sessiondocno!='')
{
$queryshortloccode = "select locationcode from login_locationdetails where username='$sessionusername' and docno='$sessiondocno' group by locationname order by locationname";
$execshortloccode = mysql_query($queryshortloccode) or die ("Error in Queryshortloccode".mysql_error());
while ($resshortloccode = mysql_fetch_array($execshortloccode))
{
$reslocationanum = $resshortloccode["locationcode"];
$queryshortlocname = "select locationname from master_location where locationcode='$reslocationanum' group by locationname order by locationname";
$execshortlocname = mysql_query($queryshortlocname) or die ("Error in Queryshortlocname".mysql_error());
$resshortlocname = mysql_fetch_array($execshortlocname);
$locationshortname = $resshortlocname["locationname"];
echo '<b>'.$locationshortname.'</b>';
}
}
if($locationshortname=='')
{
	echo '<b>No Location Selected</b>';
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="3%" bgcolor="#FFFFFF">&nbsp;</td>
    <td colspan="4" bgcolor="#FFFFFF">
	<span class="style4TM1">
	<img src="images/medit.gif" />	</span></td>
    <td width="3%" bgcolor="#FFFFFF"><img src="images/user1.png" width="30" height="20"/></td>
    <td width="11%" bgcolor="#FFFFFF" class="style4TM1" align="right" valign="">
	<span style="position: absolute;    left: 226px;    top: 36px;">
	<?php if (isset($_SESSION["username"])) { echo strtoupper($_SESSION["username"]); } ?></span>
	&nbsp;<a  onclick="lockscreen();" accesskey="l"><img src="images/lockscreen.png" width="40" height="30" style="cursor:pointer;" title="Lock Screen"/></a>
    <a  onclick="enablescreen();" accesskey="u" ></a></td>
    <td width="7%" bgcolor="#FFFFFF" class="style4TM1" align="left"><a href="shiftout.php"><img src="images/shiftout.png" width="40" height="30" onclick="return funccheck()" /></a></td>
    <td width="40%" align="left" valign="" bgcolor="#FFFFFF" class="style4TM1">
	<span id="date_time"></span>
    <script type="text/javascript">date_time('date_time');</script>&nbsp;&nbsp;&nbsp;<a href="logout1.php"><img src="images/logout.png"  align="center"width="40" height="30"/></a></td>
    <td width="8%" align="left" bgcolor="#FFFFFF" class="style4TM1"><a href="passwordchange.php"><img src="images/pwdkey.png" width="40" height="30"/></a></td>
    <td width="20%" bgcolor="#FFFFFF" class="style4TM1" align="center"><img src="images/neemalogo.png" width="150" height="48"/></td>
  </tr>
</table>
<div align="center" class="imgloader" id="imgloader" style="display:none;">
<img src="images/unlock.jpg" width="40" height="30" onclick="enablescreen();" style='position: absolute;  left: 400px;  top: 32px;cursor:pointer;'  title="Open Screen"/>
</div>

<div align="center" class="mainlogindiv" id="mainlogindiv" style="display:none">
	<div align="center" style="position: absolute;top: 50px;left: 513px;background: #FFF;width: 27%;height: 27%;border-radius: 30px;">
        <div id='loginimages' class="bodytext3" style=" position:absolute;left:85px;" >
            <img src="images/Lock-64.png" width="40" height="40"/> Idle Time Out 
            <br />
            <b id="alertlogmsg" style="margin-left:-60px; background-color:#F90;"></b>
        </div>
        <div id="usernamediv" style=" position:absolute; top:80px; left:58px;" class="bodytext3">
        User Name <input type="text" id="username" name="username" value="<?php echo trim($username);?>" readonly="readonly"/></div>
        <div id="passworddiv" style="position:absolute; top:110px; left:58px;" class="bodytext3">
        Password &nbsp;&nbsp;<input type="password" id="password" name="password" value="" />
        <input type="hidden" id="locdocno" name="locdocno" value="<?php echo $sessiondocno;?>" />
        <input type="hidden" id="timelimit" name="timelimit" value="<?php echo $timelimit; ?>" />
        <input type="hidden" id="timeout" name="timeout" value="<?php echo $timeout; ?>" />
        </div>    
        <div id="loginoutbutton" style="position: absolute;top: 140px;left: 132px;">
            <input type="button" name='login' id="login" class='login' value="Login" onclick="loginfunction();"/>
            <input type="button" name='logout' id="logout" class='logout' value="Logout" onclick="logoutfunction();"/>
        </div>
    </div>
</div>