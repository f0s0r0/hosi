<?php 

// the full http path to the PDF form 
$form = 'html2pdf/examples/33weeks12.pdf'; 

function create_fdf ($pdffile, $strings, $keys) 
{ 
   $fdf = "%FDF-1.2\n%????\n"; 
   $fdf .= "1 0 obj \n<< /FDF << /Fields [\n"; 

   foreach ($strings as $key => $value) 
   { 
       $key = addcslashes($key, "\n\r\t\\()"); 
       $value = addcslashes($value, "\n\r\t\\()"); 
       $fdf .= "<< /T ($key) /V ($value) >> \n"; 
   } 
   foreach ($keys as $key => $value) 
   { 
       $key = addcslashes($key, "\n\r\t\\()"); 
       $fdf .= "<< /T ($key) /V /$value >> \n"; 
   } 

   $fdf .= "]\n/F ($pdffile) >>"; 
   $fdf .= ">>\nendobj\ntrailer\n<<\n"; 
   $fdf .= "/Root 1 0 R \n\n>>\n"; 
   $fdf .= "%%EOF"; 

   return $fdf; 
} 

// Fill in text fields 
$strings = array( 
   'date' => '10/17/2004', 
   'full_name' => 'Joe Doe', 
   'phone_num' => '123-4567', 
   'company' => 'ACME Widgets', 
   'amount' => 'USD 100.00' 
   ); 

// Fill in check boxes/radio buttons 
$keys = array(' 
   gender' => 'male',//radio button 
   'is_adult' => 'Off',//checkbox 
   'urgent' => 'On'//checkbox 
   ); 

// Output the PDF form, with form data filled-in 
header('Content-type: application/vnd.fdf'); 
echo create_fdf($form, $strings, $keys); 

?>