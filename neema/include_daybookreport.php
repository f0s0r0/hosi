<?php
$queryd2 = "select * from master_transactionpaynow where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd2 = mysql_query($queryd2) or die ("Error in Queryd2".mysql_error());
$resd2 = mysql_fetch_array($execd2);
$numsd2 = mysql_num_rows($execd2);
$queryd23 = "select * from master_billing where username = '$res21username' and billingdatetime between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd23 = mysql_query($queryd23) or die ("Error in Queryd23".mysql_error());
$resd23 = mysql_fetch_array($execd23);
$numsd23 = mysql_num_rows($execd23);
$queryd24 = "select * from master_transactionexternal where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd24 = mysql_query($queryd24) or die ("Error in Queryd24".mysql_error());
$resd24 = mysql_fetch_array($execd24);
$numsd24 = mysql_num_rows($execd24);
$queryd25 = "select * from refund_paynow where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd25 = mysql_query($queryd25) or die ("Error in Queryd25".mysql_error());
$resd25 = mysql_fetch_array($execd25);
$numsd25 = mysql_num_rows($execd25);
$queryd26 = "select * from master_transactionadvancedeposit where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd26 = mysql_query($queryd26) or die ("Error in Queryd26".mysql_error());
$resd26 = mysql_fetch_array($execd26);
$numsd26 = mysql_num_rows($execd26);
$queryd27 = "select * from master_transactionipdeposit where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd27 = mysql_query($queryd27) or die ("Error in Queryd27".mysql_error());
$resd27 = mysql_fetch_array($execd27);
$numsd27 = mysql_num_rows($execd27);
$queryd28 = "select * from master_transactionip where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd28 = mysql_query($queryd28) or die ("Error in Queryd28".mysql_error());
$resd28 = mysql_fetch_array($execd28);
$numsd28 = mysql_num_rows($execd28);
$queryd29 = "select * from master_transactionipcreditapproved where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd29 = mysql_query($queryd29) or die ("Error in Queryd29".mysql_error());
$resd29 = mysql_fetch_array($execd29);
$numsd29 = mysql_num_rows($execd29);
$queryd40 = "select * from receiptsub_details where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$execd40 = mysql_query($queryd40) or die ("Error in Queryd40".mysql_error());
$resd40 = mysql_fetch_array($execd40);
$numsd40 = mysql_num_rows($execd40);
?>