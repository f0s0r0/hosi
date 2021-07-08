<?php
   if(isset($_POST['save']))
   {
      //Let $_POST['cscf']['country']= malaysia@email.com
      // you can explode by @ and get the 0 index name of country
      $cnt=explode('@',$_POST['cscf']['country']);
      if(isset($cnt[0]))// check if name exists in email
         echo ucfirst($cnt[0]);// will echo Malaysia
   }
?>

<form method="post">
    <div class="controls">
        <select id="itemType_id" name="cscf[country]" class="input-xlarge">
            <option value="malaysia@email.com">Malaysia</option>
            <option value="indonesia@email.com">Indonesia</option> 
        </select>   
        <span class="help-inline"></span>
    </div>
    <div class="controls">
        <input type="submit" name='save' value="Save"/>   
		
		
        <span class="help-inline"></span>
    </div>
</form>