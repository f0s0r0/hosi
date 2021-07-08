<?php
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
?>