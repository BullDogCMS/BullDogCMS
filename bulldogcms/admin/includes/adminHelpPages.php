<h1 class="page-header">
    Help Pages
</h1>
<div class ="col-xs-12">
<?php
if(isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = ''; //If something typed in wrong, set to default.
}
switch($action) {
    case 'addhelppage';
        include "adminHelpPageAdd.php";
        break;
    case 'edit';
        include "adminHelpPageEdit.php";
        break;
    default:
        include "adminHelpPageList.php";
        break;
}
?>
</div>
