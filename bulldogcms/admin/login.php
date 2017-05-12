<?php include "../../bulldogcms/admin/includes/adminHeader.php" ?>

<?php
if(isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action= '';
}
switch($action) {
    case 'logout';
        include "includes/adminLogout.php";
        break;
    default:
        include "includes/adminLogin.php";
        break;
}
?>

<?php include "../../bulldogcms/admin/includes/adminFooter.php" ?>