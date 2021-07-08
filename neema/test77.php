<script type="text/javascript">
function hideshow()
{
var s1= document.getElementById('OperationType');
var s2= document.getElementById('OperationNos');

if( s1.options[s1.selectedIndex].text=="Operation No")
{
s2.style.visibility = 'visible';
document.getElementById('t1').style.visibility = 'hidden';
}
if( s1.options[s1.selectedIndex].text=="Employee No")
{
s2.style.visibility = 'hidden';
document.getElementById('t1').style.visibility = 'visible';
}
}
function hide()

{

document.getElementById('t1').style.visibility = 'hidden';
}

</script>


<body onload="hide()">

<select id="OperationType" onChange="hideshow()">
 <option value="OpNo">Operation No</option>
 <option value="OpEmp">Employee No</option>
</select>

<select id="OperationNos">
 <option value="1001">1001</option>
 <option value="1002">1002</option>
</select>

<input type="text" id="t1" />
</body>


<html>
<head>
<script type="text/javascript">
function makeDisable(){
    var x=document.getElementById("mySelect")
    x.disabled=true
}
function makeEnable(){
    var x=document.getElementById("mySelect")
    x.disabled=false
}
</script>
</head>

<body>
<form>
<select id="mySelect">
  <option>Apple</option>
  <option>Banana</option>
  <option>Orange</option>
</select>
<input type="button" onclick="makeDisable()" value="Disable list">
<input type="button" onclick="makeEnable()" value="Enable list">
</form>
</body>

</html>

