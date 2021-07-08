<?php

header('Content-Type: application/pdf'); 


// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="downloaded.pdf"');

// The PDF source is in original.pdf
readfile('original.pdf');

?>
<script type='text/javascript'>

function doYourStuff()
{
     var len = document.form.check.length;
     var str = "";
     for (var i = 0; i < len; i++)
     {
          str .= document.form.check[0].value + ",";
     }

     document.form.action = "page2.php?checkbox=" + str;
     document.form.submit();
}

</script>

<form action='page2.php' method='get' name='form' onsubmit='return doYourStuff()'>
<input type='checkbox' name='check' value=1>1<br />
<input type='checkbox' name='check' value=2>2<br />
<input type='checkbox' name='check' value=3>3<br />
<input type='checkbox' name='check' value=4>4<br />
<input type='checkbox' name='check' value=5>5<br />
</form>