
<?php
include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
open_flash_chart_object( 18, 20, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/chart-data.php', false );
?>
