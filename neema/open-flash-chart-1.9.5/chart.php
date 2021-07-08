<html>
<head>
</head>
<body>
<?php
include_once 'php-ofc-library/open_flash_chart_object.php';
open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/open-flash-chart-1.9.5/chart-data.php', false );
?>
<?php

echo 'Hello World!';

?>
</body>
</html>