<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">


<head>
  <title></title>
<script language="JavaScript" type="text/javascript">
<!--

function ReSize(id,h,src,tb){
 var obj=document.getElementById(id);
 obj.style.height=h+'px';
 obj.src=src;
 document.getElementById(tb).value='Height '+h+'px';
}
//-->
</script></head>

<body>
<span id="L1" onClick="ReSize('Tst',600,'http://www.codingforums.com','TB1');" >Link 1</span><br>
<input id="TB1" >

<br>
<iframe id="Tst" src="IF1.htm" width="500" height="200"></iframe>
</body>

</html>


<body>
    <form id="form1">
    <div>
      <input type="button" id="btnClick" value="Click" onClick="fun()" />
    </div>
    <div id="divExample" style="background-color: Green; width:500px;">
        This is div text</div>
    <script type="text/javascript" language="javascript">
        function fun() {
            var div1 = document.getElementById("divExample");
            if (div1.style.width != "100px") {
                w = div1.style.width;
                h = div1.style.height;
                div1.style.width = "100px";
                div1.style.height = "100px";
            }
            else
             {
                div1.style.width = w;
                div1.style.height = h;
                }
            return false;
        }
    </script>
    </form>
</body>
</html>
