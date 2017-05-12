<!--PHP page is a place holder and displays the included PHP page based on Action -->


<?php
if(isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = '';  //If something typed in wrong, set to default.
}
switch($action) {
    case 'addpage';  //index.php?view=articles&action=addpage
        ?>
        <h1 class="page-header">
            Add Special Page
        </h1>
        <?php
        include "adminArticleAdd.php";
        $helpPageID = '22';
        break;
    case 'addarticle';  //index.php?view=articles&action=addarticle
    ?>
        <h1 class="page-header">
            Add Article
        </h1>
    <?php
        include "adminArticleAdd.php";
        $helpPageID = '22';
        break;
    default:
        include "adminArticleList.php";
        $helpPageID = '4';
        break;
}

?>

