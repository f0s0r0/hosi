
<?php
$gomenu = $_POST['shortcut'];
if(strpos($gomenu, "/") === 0) {
    //if $gomenu contains `/`, then it should open in new tab
    header('Location: ipvisitentry.php'); //--> How to open this into a new tab?
} else {
    header('Location: reportsupplier21.php'); //--> Redirect to somePage.php on the same tab
}
?>

