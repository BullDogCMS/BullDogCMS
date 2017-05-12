<!-- Navigation -->
<?php include "includes/headerNavigation.php"; ?>

    <?php

    $bodySettingsQuery = "SELECT * FROM bodySettings WHERE bodySettingID = '1'";
    $selectBodySettings = mysqli_query($connection, $bodySettingsQuery);

    //Setting variables as GLOBAL so can be used on other pages
    while($row = mysqli_fetch_assoc($selectBodySettings)) {
        $bodyHeroic     = $row['bodyHeroic'];
        $bodyText     = $row['bodyText'];
        $bodyView       = $row['bodyView'];
        $fpOrder        =$row['fpOrder'];
        $enableCategories       = $row['fpEnableCategories'];
        $enableArticles       = $row['fpEnableArticles'];
        $GLOBAL['heroicImage']      = $row['heroicImage'];
        $GLOBAL['heroicHeader']      = $row['heroicHeader'];
        $GLOBAL['heroicText1']      = $row['heroicText1'];
    }
    //Find out if site is using Heroic image
        //if($bodyHeroic ==  '1'){
            //include "includes/heroic.php";
        //}
    ?>

        <?php
        if(isset($_GET['view'])) {
            $view = $_GET['view'];
        } else {
            $view = '';
        }
        switch($view) {
            case 'articlelist'; //index.php?view=articlelist
                echo "<!-- Page Content --><div class='container'><div class='row'>";
                //Search above body.
                include "includes/search.php";
                ?>
                <div class="col-md-<?php echo $GLOBAL['colNumberForAsideOption']?>">
                <?php
                include "includes/articleList.php";
                break;

            case 'article'; //index.php?view=article&articleID=1
                echo "<!-- Page Content --><div class='container'><div class='row'>";
                //Search above body.
                include "includes/search.php";
                ?>
                <div class="col-md-<?php echo $GLOBAL['colNumberForAsideOption']?>">
                <?php
                include "includes/article.php";
                break;

            case 'specialpage'; //index.php?view=specialpage&articleID=1
                echo "<!-- Page Content --><div class='container'><div class='row'>";
                //Search above body.
                include "includes/search.php";
                ?>
                <div class="col-md-<?php echo $GLOBAL['colNumberForAsideOption']?>">
                <?php
                include "includes/specialPage.php";
                break;

            //Only showing categories marked for showing up on Index. in navigations.navigationsLocation = 3
            case 'indexcategories'; //index.php?view=indexcategories
                echo "<!-- Page Content --><div class='container'><div class='row'>";
                //Search above body.
                include "includes/search.php";
                ?>
                <div class="col-md-<?php echo $GLOBAL['colNumberForAsideOption']?>">
                <?php
                include "includes/categoryList.php";
                break;

            //Show indexcategories and categories per navigationID
            case 'catbynavid'; //index.php?view=catbynavid&navigationID=#
                echo "<!-- Page Content --><div class='container'><div class='row'>";
                //Search above body.
                include "includes/search.php";
                ?>
                <div class="col-md-<?php echo $GLOBAL['colNumberForAsideOption']?>">
                <?php
                include "includes/categoryList.php";
                break;

            case 'catbynavname'; //index.php?view=catbynavname&navname=Something
                echo "<!-- Page Content --><div class='container'><div class='row'>";
                //Search above body.
                include "includes/search.php";
                ?>
                <div class="col-md-<?php echo $GLOBAL['colNumberForAsideOption']?>">
                <?php
                include "includes/categoryList.php";
                break;

            default:
                //Find out if site is using Heroic image.
                //Sets Heroic only on front page
                if($bodyHeroic ==  '1'){
                    include "includes/heroic.php";
                }

                echo "<!-- Page Content --><div class='container'><div class='row'>";

                //Search below Hero image but above body.
                include "includes/search.php";

                //Find out if site is to display body text as well
                ?>

                <!--Enclose bodyText, articleList, categoryList, or non in colNumber div-->
                <div class="col-md-<?php echo $GLOBAL['colNumberForAsideOption']?>">

                <?php
                if($bodyText ==  '1'){
                    include "includes/frontBody.php";
                }
                if($fpOrder == '0') { //Categories before Articles
                    if ($enableCategories == '1') {
                        include "includes/categoryList.php";
                    }
                    if ($enableArticles == '1') {
                        include "includes/articleList.php";
                    }
                }else{  //Articles before Categories
                    if ($enableArticles == '1') {
                        include "includes/articleList.php";
                    }
                    if ($enableCategories == '1') {
                        include "includes/categoryList.php";
                    }
                }

                //include $bodyView;  //Find out default setting on homepage(Categories or Articles) in bodySettings.bodyView

                break;
        }

        ?>
                </div><!--End colNumber div -->
        <?php include_once("includes/analyticstracking.php") ?>
        <!-- Sidebar Widgets Column -->
        <?php include "includes/aside.php"; ?>

    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
<?php if(isset($_GET['view'])) {
    $view = $_GET['view'];
} else {
    $view = $bodyView;  //$bodyView won't be used anymore - LG
}
if(isset($_GET['display'])) {
    $display = $_GET['display'];
} else {
    $display = null;
}
if ($display == null && $view == 'articlelist' || $view == 'includes/articleList.php') { //index.php?view=articlelist
?>

<div class="row">
    <div class="col-xs-12">
        <ul class="pager">
            <?php
            session_start();
            $numPages = $_SESSION['numPages'];
            $page = $_SESSION['currentPage'];
                if ($numPages > 1) {
                    for ($i = 1; $i <= $numPages; $i++) {
                        if ($i == $page) {
                            echo "<li><a class='active_link' href='index.php?view=articlelist&page={$i}'data-toggle='tooltip' title='Page {$i}'><strong>$i</strong></a></li>";
                        } else {
                            echo "<li><a href='index.php?view=articlelist&page={$i}'data-toggle='tooltip' title='Page {$i}'>$i</a></li>";
                        }
                    }
                }
            }
            ?>
        </ul>
    </div>
</div>