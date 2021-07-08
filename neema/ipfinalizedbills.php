   <?php

session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

            $colorloopcount ='';
		
		$query1 = "select * from master_ipvisitentry ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$billtype = $res1['billtype'];
		
		
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
             <td align="left" valign="center" class="bodytext31">
			    <div align="center"><?php //echo $billnumbercode; ?></div></td>
			
			  <td align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php //echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php //echo $updatedate; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $billtype; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php //echo $accname; ?></td>
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           