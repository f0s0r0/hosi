
<?php 
  $x = 0;
  $numfile = 3; 
  $servdir  = " "; 

  if ($_POST) 
 { 
    for ($i=0;$i<$numfile;$i++) 
    { 
      if (trim($_FILES['myfiles']['name'][$i])!="") 
      { 
        $newfile = $servdir.$_FILES['myfiles']['name'][$i]; 
        move_uploaded_file($_FILES['myfiles']['tmp_name'][$i], $newfile); 
        $x++; 
      } 
    } 
 } 

  if (isset($x)&&$x>0) print "All went well.<br>"; 
  print "<form method='post' enctype='multipart/form-data'>"; 
  for($i=0;$i<$numfile;$i++) 
  { 
    print "<input type='file' name='myfiles[]' size='30'><br>"; 
  } 
  print "<input type='submit' name='action' value='Upload'>"; 
  print "</form>"; 
?>
