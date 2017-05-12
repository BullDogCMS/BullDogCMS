<?php

function confirmQuery($result) {
    global $connection;
    if(!$result) {
        die("QUERY FAILED ." . mysqli_error($connection));
    }
}
function findAllNavigations()
{
    global $connection;

    $navigationQuery = "SELECT * FROM navigations WHERE navigationVisible = '1' AND navigationLocation IN(1,2,3) ORDER BY navigationOrder";
    $select_all_navigations_query = mysqli_query($connection, $navigationQuery);

    while($row = mysqli_fetch_assoc($select_all_navigations_query)) {
        $navigationID = $row['navigationID'];
        $navigationName = htmlentities($row['navigationName'], ENT_QUOTES, 'UTF-8');//escaped for display purposes -Micah
        $navigationClass = $row['navButtonColor'] . " " . $row['navButtonSize'];
        $navigationURL = htmlentities($row['navigationURL'], ENT_QUOTES, 'UTF-8');//escaped for display purposes -Micah
        $navJavaScript = $row['navJavaScript'];

        $categoryQuery = "SELECT * FROM categories WHERE navigationID = {$navigationID} AND categoryVisible = '1' ORDER BY categoryOrder";
        $check_for_categories_query = mysqli_query($connection, $categoryQuery);

        if (mysqli_num_rows($check_for_categories_query) != 0){

            //menu for non-mobile
            echo "<li class='dropdown hidden-xs'><a href='{$navigationURL}' $navJavaScript class='{$navigationClass}'>{$navigationName} <b class='caret'></b></a>";
            echo "<ul class='dropdown-menu'>";

            while($row = mysqli_fetch_assoc($check_for_categories_query)){
                $categoryID = $row['categoryID'];
                $categoryName = htmlentities($row['categoryName'], ENT_QUOTES, 'UTF-8');//escaped for display purposes

                echo "<li><a href='index.php?view=articlelist&display=articlesbycat&category={$categoryID}'>{$categoryName}</a></li>";
            }
            echo "</ul></li>";

            //menu for mobile with dropdowns
//            echo "<li class='dropdown hidden-sm hidden-md hidden-lg'><a href='#' $navJavaScript class='dropdown-toggle {$navigationClass}' data-toggle='dropdown'>{$navigationName} <b class='caret'></b></a>";
//            echo "<ul class='dropdown-menu'>";
//
//            while($row = mysqli_fetch_assoc($check_for_categories_query)){
//                $categoryID = $row['categoryID'];
//                $categoryName = $row['categoryName'];
//
//                echo "<li><a href='index.php?view=articlelist&display=articlesbycat&category={$categoryID}'>{$categoryName}</a></li>";
//            }
//            echo "</ul></li>";

            //menu for mobile without dropdowns
            echo "<li class='hidden-sm hidden-md hidden-lg'><a href='{$navigationURL}' $navJavaScript class='{$navigationClass}'>{$navigationName}</a></li>";

        }else{

        echo "<li><a href='{$navigationURL}' $navJavaScript class='{$navigationClass}'>{$navigationName}</a></li>";

        //echo "<li><a href='{$navigationURL}' onclick = '{$onClick};' class='{$navigationClass}'>{$navigationName}</a></li>";
        }
    }
}

//Grabs Visible Navigations that have a navigationLocation value or either 2 or 3.
function findAllFooterNavigations() {
    global $connection;

    //$navigationQuery = "SELECT * FROM navigations WHERE navigationVisible = '1' && navigationLocation = 2 || navigationVisible = '1' && navigationLocation = 3 ORDER BY navigationOrder";
    $navigationQuery = "SELECT * FROM navigations WHERE navigationVisible = '1' AND navigationLocation IN(2,3,5) ORDER BY navigationOrder";
    $select_nav = mysqli_query($connection, $navigationQuery);

    while($row = mysqli_fetch_assoc($select_nav)) {
        $navigationID = $row['navigationID'];
        $navigationName = $row['navigationName'];
        $navigationClass = $row['navButtonColor'] . " " . $row['navButtonSize'];
        $navigationURL = $row['navigationURL'];
        $navJavaScript = $row['navJavaScript'];


        echo "<li><a href='{$navigationURL}' $navJavaScript>{$navigationName}</a></li>";

    }
}


function findIndexCategories() {
    global $connection;

    $navigationQuery = "SELECT * FROM navigations WHERE navigationLocation IN(3,4) AND navigationVisible = '1' ORDER BY navigationOrder";
    $select_all_navigations_query = mysqli_query($connection, $navigationQuery);

    while($row = mysqli_fetch_assoc($select_all_navigations_query)) {
        $navigationID = $row['navigationID'];
        $navigationName = $row['navigationName'];
        $navigationURL= $row['navigationURL'];

        echo "<div class='col-xs-12'>";
        //Title
        echo "<div class='row'>";
            echo "<div class='page-header col-xs-12'>";
                echo "<a href='{$navigationURL}'><h2>{$navigationName}</h2></a>";
            echo "</div>";
        echo "</div>";

        $categoryQuery = "SELECT * FROM categories WHERE navigationID ='{$navigationID}' AND categoryVisible = '1' ORDER BY categoryOrder";
        $select_all_categories_query = mysqli_query($connection, $categoryQuery);
        while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
            $categoryID = $row['categoryID'];
            $categoryName = $row['categoryName'];
            $categoryImage = $row['categoryImage'];
            $categoryImage = "uploads/" . $categoryImage;

            //create category description snippet for viewing
            //uses first 50 characters + ... if more than 50 characters
            if (strlen($categoryName) > 23) {
                $categoryName = substr($categoryName, 0, 23) . "...";
            }

            echo "<div class='col-lg-3 col-md-4 col-sm-6 col-xs-12 hero-feature'>";
            echo "<div class='thumbnail'><div class='imageContainer'>";
	        if(isset($categoryImage) && $categoryImage != 'uploads/' && file_exists($categoryImage)) {
		        echo "<a href='index.php?view=articlelist&display=articlesbycat&category=$categoryID'><img class='img-responsive img-rounded catListImage' src='$categoryImage' alt='$categoryName' ></a>";
		        /*echo "<div style='background-image: url({$categoryImage});'></div>";*/
	        }
            echo "</div><div class='caption dont-break-out'>";
            echo "<div class='catListContentArea'><a href='index.php?view=articlelist&display=articlesbycat&category=$categoryID'><h3>{$categoryName}</h3></a></div>";
            echo "<a href='index.php?view=articlelist&display=articlesbycat&category=$categoryID' class='btn btn-primary'>More Info</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    }
}

function listFECatByNavID() {
    global $connection;
    if(isset($_GET['navigationID'])) {
        $navigationID = $_GET['navigationID'];
    } else {
        $navigationID = '999';  //Just something incase left blank and SQL doesn't error out.
    }

    $navigationQuery = "SELECT * FROM navigations WHERE navigationID = $navigationID AND navigationVisible = '1'";
    $select_all_navigations_query = mysqli_query($connection, $navigationQuery);

    while($row = mysqli_fetch_assoc($select_all_navigations_query)) {
        $navigationID = $row['navigationID'];
        $navigationName = $row['navigationName'];
        echo "<div class='col-xs-12'>";
        //Title
        echo "<div class='row'>";
        echo "<div class='page-header col-xs-12'>";
        echo "<h2>{$navigationName}</h2>";
        echo "</div>";


        $categoryQuery = "SELECT * FROM categories WHERE navigationID ='{$navigationID}' AND categoryVisible = '1' ORDER BY categoryOrder";
        $select_all_categories_query = mysqli_query($connection, $categoryQuery);
        while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
            $categoryID = $row['categoryID'];
            $categoryName = $row['categoryName'];
            $categoryImage = $row['categoryImage'];
            $categoryImage = "uploads/" . $categoryImage;

            //create category description snippet for viewing
            //uses first 50 characters + ... if more than 50 characters
            if (strlen($categoryName) > 30) {
                $categoryName = substr($categoryName, 0, 20) . "...";
            }

            echo "<div class='col-lg-3 col-md-4 col-sm-6 col-xs-12 hero-feature'>";
            echo "<div class='thumbnail'><div class='imageContainer'>";
            if(isset($categoryImage) && $categoryImage != 'uploads/' && file_exists($categoryImage)) {
                echo "<a href='index.php?view=articlelist&display=articlesbycat&category=$categoryID'><img class='img-responsive img-rounded catListImage' src='$categoryImage' alt='$categoryName' ></a>";
                /*echo "<div style='background-image: url({$categoryImage});'></div>";*/
            }
            echo "</div><div class='caption dont-break-out'>";
            echo "<div class='catListContentArea'><a href='index.php?view=articlelist&display=articlesbycat&category=$categoryID'><h3>{$categoryName}</h3></a></div>";
            echo "<a href='index.php?view=articlelist&display=articlesbycat&category=$categoryID' class='btn btn-primary'>More Info</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    }
    echo "</div>";

}

function listFECatByNavName() {
    global $connection;
    if(isset($_GET['navname'])) {
        $navigationName = mysqli_real_escape_string($connection, $_GET['navname']);
    } else {
        $navigationName = '999';  //Just something incase left blank and SQL doesn't error out.
    }
    $navigationQuery = "SELECT * FROM navigations WHERE navigationName = '{$navigationName}' AND navigationVisible = '1'";
    $select_all_navigations_query = mysqli_query($connection, $navigationQuery);

    while($row = mysqli_fetch_assoc($select_all_navigations_query)) {
        $navigationID = $row['navigationID'];
        $navigationName = $row['navigationName'];
        echo "<div class='col-xs-12'>";
        //Title
        echo "<div class='row'>";
        echo "<div class='page-header col-xs-12'>";
        echo "<h2>{$navigationName}</h2>";
        echo "</div>";


        $categoryQuery = "SELECT * FROM categories WHERE navigationID ='{$navigationID}' AND categoryVisible = '1' ORDER BY categoryOrder";
        $select_all_categories_query = mysqli_query($connection, $categoryQuery);
        while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
            $categoryID = $row['categoryID'];
            $categoryName = $row['categoryName'];
            $categoryImage = $row['categoryImage'];
            $categoryImage = "uploads/" . $categoryImage;

            //create category description snippet for viewing
            //uses first 50 characters + ... if more than 50 characters
            if (strlen($categoryName) > 30) {
                $categoryName = substr($categoryName, 0, 20) . "...";
            }

            echo "<div class='col-lg-3 col-md-4 col-sm-6 col-xs-12 hero-feature'>";
            echo "<div class='thumbnail'><div class='imageContainer'>";
            if(isset($categoryImage) && $categoryImage != 'uploads/' && file_exists($categoryImage)) {
                echo "<a href='index.php?view=articlelist&display=articlesbycat&category=$categoryID'><img class='img-responsive img-rounded catListImage' src='$categoryImage' alt='$categoryName' ></a>";
                /*echo "<div style='background-image: url({$categoryImage});'></div>";*/
            }
            echo "</div><div class='caption dont-break-out'>";
            echo "<div class='catListContentArea'><a href='index.php?view=articlelist&display=articlesbycat&category=$categoryID'><h3>{$categoryName}</h3></a></div>";
            echo "<a href='index.php?view=articlelist&display=articlesbycat&category=$categoryID' class='btn btn-primary'>More Info</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    }
    echo "</div>";

}

function listLinks() {
    global $connection;
    $query = "SELECT * FROM links WHERE linkTypeID = '1' order by linkOrder";
    $selectLinks = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($selectLinks)) {
        $linkName = $row['linkName'];
        $linkURL = $row['linkURL'];

        echo "<li><a href='$linkURL'  target='_blank'>$linkName</a></li>";
    }
}

function listNews() {
    global $connection;
    $query = "SELECT * FROM links WHERE linkTypeID = '2' order by linkOrder";
    $selectLinks = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($selectLinks)) {
        $linkName = $row['linkName'];
        $linkURL = $row['linkURL'];

        echo "<li><a href='$linkURL'  target='_blank'>$linkName</a></li>";
    }
}

function latestArticles() {
    global $connection;

    $query = "SELECT * FROM articles a JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID ";
    $query .= "WHERE a.articleVisible = '1' AND at.articlePending = '0' AND a.categoryID <> '1' ORDER BY transactionDate DESC LIMIT 5";
    $selectLatestArticles = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($selectLatestArticles)) {
        $articleID = $row['articleID'];
        $articleTitle = $row['articleTitle'];
        ?>
        <!-- Article Link -->
        <li><a href="index.php?view=article&articleID=<?php echo $articleID ?>"><?php echo $articleTitle ?></a></li>

        <?php
    }
}

function listEvents() {
    global $connection;

    $query = "SELECT * FROM categories WHERE categoryTypeID = 3 AND categoryVisible = '1' ORDER BY categoryOrder ";
    $selectEvents = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($selectEvents)) {
        $categoryID = $row['categoryID'];
        $categoryName = $row['categoryName'];
        ?>
        <!-- Article Link -->
        <li><a href="index.php?view=articlelist&display=articlesbycat&category=<?php echo $categoryID ?>"><?php echo $categoryName ?></a></li>

        <?php
    }
}

?>