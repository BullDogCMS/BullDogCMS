<?php
function listArticles($pending, $catIDCheck, $articleCheck, $order, $sort) {
    global $connection;

//PAGINATION (REST OF NECESSARY CODE IS AT THE BOTTOM OF THE PAGE CALLING THIS FUNCTION)
    $siteSettingsQuery = "SELECT * FROM siteSettings WHERE siteSettingID = '1'";
    $selectSiteSettings = mysqli_query($connection, $siteSettingsQuery);
    while($row = mysqli_fetch_assoc($selectSiteSettings)) {
        $perPage = $row['paginationLength']; //pulls how many results are displayed per page from database
    }

    if (isset($_GET['page'])){

        $page = $_GET['page'];
    }
    else {
        $page = 1;
    }

    if($page == "" || $page == 1){
        $page1 = 0;
    }
    else {
        $page1 = ($page * $perPage) - $perPage;
    }

    $navigationCountQuery = "SELECT * FROM articles a ";
    $navigationCountQuery .= " JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID";
    $navigationCountQuery .= " JOIN users u ON articleAuthorID = u.userID";
    $navigationCountQuery .= " JOIN categories c ON c.categoryID = a.categoryID";
    $navigationCountQuery .= " WHERE at.articlePending IN($pending) AND a.categoryID $catIDCheck '1'"; //Don't display Special Pages
    $findCount = mysqli_query($connection, $navigationCountQuery);
    $count = mysqli_num_rows($findCount);

    $numPages = ceil($count / $perPage);
    session_start();
    $_SESSION['numPages'] = $numPages;//session variables passed to file calling this function
    $_SESSION['currentPage'] = $page;
    //End Initial Pagination Code

    //Parameters are telling if Pending and if Article or Special Page from adminArticleList.php
    $query = "SELECT *, DATE_FORMAT(articleCreateDate, \"%m-%d-%Y\") AS artDate FROM articles a ";
    $query .= " JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID";
    $query .= " JOIN users u ON articleAuthorID = u.userID";
    $query .= " JOIN categories c ON c.categoryID = a.categoryID";
    $query .= " WHERE at.articlePending IN($pending) AND a.categoryID $catIDCheck '1'"; //Don't display Special Pages
    //Modify query based on sort.
    switch($order) {
        case 'title';
            $query .= " ORDER BY articleTitle";
            break;
        case 'category';
            $query .= " ORDER BY a.categoryID";
            break;
        case 'author';
            $query .= " ORDER BY articleAuthorID";
            break;
        case 'date';
            $query .= " ORDER BY transactionDate";
            break;
        default:
            $query .= " ORDER BY transactionDate";
            break;
    }

    switch($sort) {
        case 'asc';
            $query .= " asc LIMIT $page1, $perPage";
            break;
        case 'desc';
            $query .= " desc LIMIT $page1, $perPage";
            break;
        default:
            $query .= " desc LIMIT $page1, $perPage";
            break;

    }

    //Get values for view and display, to dynamically update icon links depending on page.
    if(isset($_GET['view'])) {
        $viewMod = "view=" . $_GET['view'];
        $originView = "&originview=" . $_GET['view'];
    }

    if(isset($_GET['display'])) {
        $displayMod = "&display=" . $_GET['display'];
        $originDisplay = "&origindisplay=" . $_GET['display'];

    } else {
        $displayMod = "";
    }

    $select_all_articles = mysqli_query($connection, $query);
    confirmQuery($select_all_articles);

    while($row = mysqli_fetch_assoc($select_all_articles)) {

        $articleID = $row['articleID'];
        $articleLock = $row['articleLock'];
        $articleTitle = $row['articleTitle'];
        //$categoryID = $row['categoryID'];
        $categoryName = $row['categoryName'];
        $articleAuthorID = $row['articleAuthorID'];
        $username = $row['username'];
        $transactionAuthorID = $row['transactionAuthorID'];
        $transactionID = $row['transactionID'];
        $articleCreateDate = $row['artDate'];
        $transactionDate = $row['transactionDate'];
        $articleImage = $row['articleImage'];
        $articleFile = $row['fileName'];
        $articleTags = $row['articleTags'];
        $articleContent = $row['articleContent'];


        //Remove images. Code from http://stackoverflow.com/questions/1107194/php-remove-img-tag-from-string
//        $articleContent = preg_replace("/<img[^>]+\>/i", " (image) ", $articleContent);
        $articleContent = strip_tags($articleContent);

        //uses first 200 characters + ... if more than 200 characters
        if(strlen($articleContent)>200) {
            $articleContent = substr($articleContent, 0, 200) . "...";
        }

        //Get current view and display to dynamically update icon links.
        if(isset($_GET['view'])) {
            $viewMod = "view=" . $_GET['view'];
        }

        if(isset($_GET['display'])) {
            $displayMod = "&display=" . $_GET['display'];
        } else {
            $displayMod = "";
        }

        echo "<tr><td>";
        //echo "<td>{$articlePending}</td>";
        if ($_SESSION['roleID'] == 2) {
            //Pending/Approve icons
            if ($row['articlePending'] == '2') {

            } else {
                if ($row['articlePending'] == '1') {
                    if ($articleCheck == '0') {
                        echo "<a href='index.php?{$viewMod}{$displayMod}&setsppendingno={$transactionID}&title={$articleTitle}' data-toggle='tooltip' title='Approve'>
                <span class='glyphicon glyphicon-exclamation-sign'></span><span class='sr-only'>Pending</span></a>";
                    } else {
                        echo "<a href='index.php?{$viewMod}{$displayMod}&setpendingno={$transactionID}&title={$articleTitle}' data-toggle='tooltip' title='Approve'>
                <span class='glyphicon glyphicon-exclamation-sign'></span><span class='sr-only'>Pending</span></a>";
                    }
                } else {
                    echo "<span class='glyphicon glyphicon-ok-sign' data-toggle='tooltip' title='Approved'></span><span class='sr-only'>Pending</span>";
                }

                //Visibility Icons

                    if ($row['articleVisible'] == '0') {
                        if ($articleCheck == '0') {
                            echo "&nbsp;&nbsp;<a href='index.php?{$viewMod}{$displayMod}&setspvisibleyes={$articleID}&title={$articleTitle}' data-toggle='tooltip' title='Turn Visibility ON'>
                <span class='glyphicon glyphicon-eye-close'></span><span class='sr-only'>Visibility</span></a>";
                        } else {
                            echo "&nbsp;&nbsp;<a href='index.php?{$viewMod}{$displayMod}&setvisibleyes={$articleID}&title={$articleTitle}' data-toggle='tooltip' title='Turn Visibility ON'>
                <span class='glyphicon glyphicon-eye-close'></span><span class='sr-only'>Visibility</span></a>";
                        }
                    } else {
                        if ($articleCheck == '0') {
                            echo "&nbsp;&nbsp;<a href='index.php?{$viewMod}{$displayMod}&setspvisibleno={$articleID}&title={$articleTitle}' data-toggle='tooltip' title='Turn Visibility OFF'>
                <span class='glyphicon glyphicon-eye-open'></span><span class='sr-only'>Visibility</span></a>";
                        } else {
                            echo "&nbsp;&nbsp;<a href='index.php?{$viewMod}{$displayMod}&setvisibleno={$articleID}&title={$articleTitle}' data-toggle='tooltip' title='Turn Visibility OFF'>
                <span class='glyphicon glyphicon-eye-open'></span><span class='sr-only'>Visibility</span></a>";
                        }
                    }

            }
        }
        //echo "<td>{$articleVisible}</td>";

        /*echo "<td><a href ='index.php?view=articles&delete={$articleID}&title={$articleTitle}'>
			<span class='glyphicon glyphicon-trash'></span><span class='sr-only'>Delete</span></a>";*/

        //Archive Icons
        if ($_SESSION['roleID'] == 2) {
            if ($row['articlePending'] == '2') {
                echo "&nbsp;&nbsp;<a href='index.php?{$viewMod}{$displayMod}&unarchive={$transactionID}&title={$articleTitle}' data-toggle='tooltip' title='Unarchive'
			onClick=\"javascript:return confirm('Are you sure you want to unarchive this article?');\">
             <span class='glyphicon glyphicon-floppy-open'></span><span class='sr-only'>Unarchive</span></a>";
            } else {
                echo "&nbsp;&nbsp;<a href='index.php?{$viewMod}{$displayMod}&archive={$transactionID}&title={$articleTitle}' data-toggle='tooltip' title='Archive'
			onClick=\"javascript:return confirm('Are you sure you want to archive this article?');\">
             <span class='glyphicon glyphicon-floppy-save'></span><span class='sr-only'>Archive</span></a>";
            }
        }
        //Duplicate icons
            if ($row['articlePending'] !== '2' AND $articleCheck == '1') {
                echo "&nbsp;&nbsp;<a href ='index.php?{$viewMod}{$displayMod}&duplicate={$articleID}&title={$articleTitle}' data-toggle='tooltip' title='Duplicate Article'
			onClick=\"javascript:return confirm('Are you sure you want to duplicate this entry?');\">
             <span class='glyphicon glyphicon-duplicate'></span><span class='sr-only'>Duplicate</span></a>";
            }

        //Delete/Edit icons.

        if ($row['articlePending'] == '2') {
            echo "&nbsp;&nbsp;<a href='index.php?{$viewMod}{$displayMod}&delete={$articleID}&title={$articleTitle}' data-toggle='tooltip' title='Delete'
		onClick=\"javascript:return confirm('Are you sure you want to delete this article?');\">
             <span class='glyphicon glyphicon-trash'></span><span class='sr-only'>Delete</span></a>";

        } else if ($articleCheck == '0') {  //Is a Special Page so send to Special Page Edit
                echo "&nbsp;&nbsp;<a href ='index.php?view=pageedit&edit={$articleID}&transaction={$transactionID}{$originView}{$originDisplay}' data-toggle='tooltip' title='View & Edit'>
            <span class='glyphicon glyphicon-pencil'></span><span class='sr-only'>View and Edit</span></a>";
        } else if ($articleLock == '1') { //Check for article lock, if true send to LockCheck.
                echo "&nbsp;&nbsp;<a href ='index.php?view=lockcheck&edit={$articleID}&author={$transactionAuthorID}&transaction={$transactionID}{$originView}{$originDisplay}' data-toggle='tooltip' title='Locked'>
            <span class='glyphicon glyphicon-lock'></span><span class='sr-only'>Edit - Locked</span></a>";
        } else { //Send to Article Edit
                echo "&nbsp;&nbsp;<a href ='index.php?view=articleedit&edit={$articleID}&transaction={$transactionID}{$originView}{$originDisplay}' data-toggle='tooltip' title='View & Edit'>
            <span class='glyphicon glyphicon-pencil'></span><span class='sr-only'>View and Edit</span></a>";
        }




        //Comment Flag
        //echo "</td><td>{$articleID}</td>";
        echo "<td>".htmlentities($articleTitle, ENT_QUOTES, 'UTF-8')."</td>";
        echo "<td>".htmlentities($categoryName, ENT_QUOTES, 'UTF-8')."</td>";
        //Comment Flag
        //echo "<td>{$articleAuthorID}</td>";
        echo "<td>".htmlentities($username, ENT_QUOTES, 'UTF-8')."</td>";
        //echo "<td>{$transactionAuthorID}</td>";
        //Comment Flag
        //echo "<td>{$transactionID}</td>";
        echo "<td>{$articleCreateDate}</td>";
        //Comment Flag
        //echo "<td>{$transactionDate}</td>";
        if ($articleImage == "") {
            echo "<td><strong>No Image</td>";
        } else {
            echo "<td><img width='100%' src='../uploads/{$articleImage}'></td>";
        }
        //Comment Flag
        //echo "<td>{$articleFile}</td>";
        //Comment Flag
        //echo "<td>{$articleTags}</td>";
        echo "<td>{$articleContent}</td>";
        echo "</tr>";

    }
}


function changeArticleVisibility() {
    global $connection;

    //Get values for view and display, to dynamically update page refresh links depending on page.
    if(isset($_GET['view'])) {
        $viewMod = "view=" . $_GET['view'];
    }

    if(isset($_GET['display'])) {
        $displayMod = "&display=" . $_GET['display'];
    } else {
        $displayMod = "";
    }

    //Article Visibility
    if(isset($_GET['setvisibleno'])) {

        $articleID = $_GET['setvisibleno'];
        $articleTitle = $_GET['title'];

        $query = "UPDATE articles SET articleVisible = '0' WHERE articleID = $articleID";
        $changeVisible = mysqli_query($connection, $query);
            ?>
            <script type="text/javascript">
                window.location = "index.php?<?php echo "$viewMod"."$displayMod"; ?>";   //Refreshes page
            </script>
            <?

        $changedTable = "articles";
        $changeDetails = "Article &#039;" . $articleTitle . "&#039; was set to not visible.";

        //write results to changelog.
        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

        mysqli_close($connection);
    }

    if (isset($_GET['setvisibleyes'])) {

        $articleID = $_GET['setvisibleyes'];
        $articleTitle = $_GET['title'];

        $query = "UPDATE articles SET articleVisible = '1' WHERE articleID = $articleID";
        $changeVisible = mysqli_query($connection, $query);
        ?>
        <script type="text/javascript">
            window.location = "index.php?<?php echo "$viewMod"."$displayMod"; ?>";   //Refreshes page
        </script>
        <?php

        $changedTable = "articles";
        $changeDetails = "Article &#039;" . $articleTitle . "&#039; was set to visible.";

        //write results to changelog.
        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

        mysqli_close($connection);
    }
    //Special Pages Visibility
    if(isset($_GET['setspvisibleno'])) {

        $articleID = $_GET['setspvisibleno'];
        $articleTitle = $_GET['title'];

        $query = "UPDATE articles SET articleVisible = '0' WHERE articleID = $articleID";
        $changeVisible = mysqli_query($connection, $query);
        ?>
        <script type="text/javascript">
            window.location = "index.php?<?php echo "$viewMod"."$displayMod"; ?>";   //Refreshes page
        </script>
        <?

        $changedTable = "articles";
        $changeDetails = "Special Page  &#039;" . $articleTitle . "&#039; was set to not visible.";

        //write results to changelog.
        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

        mysqli_close($connection);
    }

    if (isset($_GET['setspvisibleyes'])) {

        $articleID = $_GET['setspvisibleyes'];
        $articleTitle = $_GET['title'];

        $query = "UPDATE articles SET articleVisible = '1' WHERE articleID = $articleID";
        $changeVisible = mysqli_query($connection, $query);
        ?>
        <script type="text/javascript">
            window.location = "index.php?<?php echo "$viewMod"."$displayMod"; ?>";   //Refreshes page
        </script>
        <?php

        $changedTable = "articles";
        $changeDetails = "Special Page &#039;" . $articleTitle . "&#039; was set to visible.";

        //write results to changelog.
        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

        mysqli_close($connection);
    }
}


function changeArticleArchived() {
    global $connection;

    //Get values for view and display, to dynamically update page refresh links depending on page.
    if(isset($_GET['view'])) {
        $viewMod = "view=" . $_GET['view'];
    }

    if(isset($_GET['display'])) {
        $displayMod = "&display=" . $_GET['display'];
    } else {
        $displayMod = "";
    }

    if(isset($_GET['archive'])) {

        $transactionID = $_GET['archive'];
        $articleTitle = $_GET['title'];

        $transactionQuery = "UPDATE articleTransactions SET articlePending = '2' WHERE transactionID = $transactionID";
        $changeTransaction = mysqli_query($connection, $transactionQuery);

        $articleQuery = "UPDATE articles SET articleVisible = '0', articleLock ='1' WHERE articleTransactionID = $transactionID";
        $changeArticle = mysqli_query($connection, $articleQuery);
        ?>
        <script type="text/javascript">
            window.location = "index.php?<?php echo "$viewMod"."$displayMod"; ?>";   //Refreshes page
        </script>
        <?php

        $changedTable = "articles + articleTransactions";
        $changeDetails = "Article &#039;" . $articleTitle . "&#039; was archived.";

        //write results to changelog.
        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

        mysqli_close($connection);

    } else if(isset($_GET['unarchive'])) {

        $transactionID = $_GET['unarchive'];
        $articleTitle = $_GET['title'];

        $transactionQuery = "UPDATE articleTransactions SET articlePending = '1' WHERE transactionID = $transactionID";
        $changeTransaction = mysqli_query($connection, $transactionQuery);

        $articleQuery = "UPDATE articles SET articleVisible = '0' WHERE articleTransactionID = $transactionID";
        $changeArticle = mysqli_query($connection, $articleQuery);
        ?>
        <script type="text/javascript">
            window.location = "index.php?<?php echo "$viewMod"."$displayMod"; ?>";   //Refreshes page
        </script>
        <?php

        $changedTable = "articles + articleTransactions";
        $changeDetails = "Article &#039;" . $articleTitle . "&#039; was unarchived.";

        //write results to changelog.
        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

        mysqli_close($connection);
    }

}


function changeArticlePending() {
    global $connection;

    //Get values for view and display, to dynamically update page refresh links depending on page.
    if(isset($_GET['view'])) {
        $viewMod = "view=" . $_GET['view'];
    }

    if(isset($_GET['display'])) {
        $displayMod = "&display=" . $_GET['display'];
    } else {
        $displayMod = "";
    }

    if(isset($_GET['setpendingno'])) {

        $transactionID = $_GET['setpendingno'];
        $articleTitle = $_GET['title'];

        $transactionQuery = "UPDATE articleTransactions SET articlePending = '0' WHERE transactionID = $transactionID";
        $changeTransaction = mysqli_query($connection, $transactionQuery);

        $articleQuery = "UPDATE articles SET articleVisible = '1' WHERE articleTransactionID = $transactionID";
        $changeArticle = mysqli_query($connection, $articleQuery);
        ?>
        <script type="text/javascript">
            window.location = "index.php?<?php echo "$viewMod"."$displayMod"; ?>";   //Refreshes page
        </script>
        <?php

        $changedTable = "articles + articleTransactions";
        $changeDetails = "&#039;" . $articleTitle . "&#039; was approved.";

        //write results to changelog.
        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

        mysqli_close($connection);
    }

    //Duplicate of code above
    if(isset($_GET['setsppendingno'])) {

        $transactionID = $_GET['setsppendingno'];
        $articleTitle = $_GET['title'];

        $transactionQuery = "UPDATE articleTransactions SET articlePending = '0' WHERE transactionID = $transactionID";
        $changeTransaction = mysqli_query($connection, $transactionQuery);

        $articleQuery = "UPDATE articles SET articleVisible = '1' WHERE articleTransactionID = $transactionID";
        $changeArticle = mysqli_query($connection, $articleQuery);
        ?>
        <script type="text/javascript">
            window.location = "index.php?<?php echo "$viewMod"."$displayMod"; ?>";   //Refreshes page
        </script>
        <?php

        $changedTable = "articles + articleTransactions";
        $changeDetails = "&#039;" . $articleTitle . "&#039; was approved.";

        //write results to changelog.
        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

        mysqli_close($connection);
    }
}


function deleteArticle()
{
    global $connection;

    if(isset($_GET['view'])) {
        $viewMod = "view=" . $_GET['view'];
    }

    if(isset($_GET['display'])) {
        $displayMod = "&display=" . $_GET['display'];
    } else {
        $displayMod = "";
    }

    //Begin transaction
    mysqli_autocommit($connection, false);
    $transactFlag = true;

    $articleTitle = $_GET['title'];


    if (isset($_GET['delete'])) {


        $articleID = $_GET['delete'];
        $userID = $_SESSION['userID'];

        echo "<input type=\"hidden\" class=\"form-control\" name=\"persistentArticleTitle\" value= \"<?php echo $articleID; ?>\" readonly= \"readonly\">";

        //Attempt to delete from articles table.
        $query1 = "DELETE FROM articles WHERE articleID = {$articleID} ";
        $articleDeleteQuery1 = mysqli_multi_query($connection, $query1);
        //Transaction validate point.
        if (!$articleDeleteQuery1) {
            $transactFlag = false;
            $changedTable = "articles";
            $changeDetails = "SQL DELETE failed at articleDeleteQuery1. Changes rolled back. " . $articleDeleteQuery1;
        }

        //Attempt to delete from articleTransactions table.
        $query2 = "DELETE FROM articleTransactions WHERE articleID = {$articleID} ";
        $articleDeleteQuery2 = mysqli_query($connection, $query2);
        if (!$articleDeleteQuery2) {
            $transactFlag = false;
            $changedTable = "articles";
            $changeDetails = "SQL DELETE failed at articleDeleteQuery2. Changes rolled back. " . $articleDeleteQuery2;
        }

        //Check for successful transaction.
        if ($transactFlag) {
            mysqli_commit($connection);
            ?>
            <script type="text/javascript">
                window.location = "index.php?<?php echo "$viewMod"."$displayMod"; ?>";   //Refreshes page
            </script>
            <?php

            //Set Changelog Variables
            $changedTable = "articles + articleTransactions";
            $changeDetails = "Deleted article: " . $articleTitle . ".";

        } else {
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Changes unsuccessful. Please see changelog for details.</div>';
        }

        insertChangeLog($userID, $changedTable, $changeDetails);

        //close db connection after transaction.
        mysqli_close($connection);
    }
}


function duplicateArticle()
{
    global $connection;

    //Get values for view and display, to dynamically update page refresh links depending on page.
    if(isset($_GET['view'])) {
        $viewMod = "view=" . $_GET['view'];
    }

    if(isset($_GET['display'])) {
        $displayMod = "&display=" . $_GET['display'];
    } else {
        $displayMod = "";
    }

    //Begin transaction
    mysqli_autocommit($connection, false);
    $transactFlag = true;

    if (isset($_GET['duplicate'])) {

        $articleID = $_GET['duplicate'];
        $articleTitle = $_GET['title'];

        //Retrieve values
        //Get original articles table info
        $originalArticle = "SELECT * FROM articles WHERE articleID = {$articleID}";
        $originalArticleQuery = mysqli_query($connection, $originalArticle);
        confirmQuery($originalArticleQuery);

        while ($row = mysqli_fetch_assoc($originalArticleQuery)) {
            $originalCategoryID = $row['categoryID'];
            $originalArticleTransactionID = $row['articleTransactionID'];
            $originalArticleAuthorID = $row['articleAuthorID'];
            //$originalArticleCreateDate =  $row['articleCreateDate'];
        }

        //Get original articleTransaction table info
        $originalTransactions = "SELECT * FROM articleTransactions WHERE articleID = {$articleID}";
        $originalTransactionsQuery = mysqli_query($connection, $originalTransactions);
        confirmQuery($originalTransactionsQuery);

        while($row = mysqli_fetch_assoc($originalTransactionsQuery)) {
            $originalArticleTitle = $row['articleTitle'];
            $originalArticleContent = $row['articleContent'];
            $originalArticleImage = $row['articleImage'];
            $originalFileName = $row['fileName'];
            $originalArticleTags = $row['articleTags'];
            $articleVersionID = $row['articleVersionID'] + 1;
        }

        //Insert duplicate values into article table
        $articleAdd = "INSERT INTO articles(categoryID,articleTransactionID,articleAuthorID,articleCreateDate,articleVisible,articleLock) ";
        $articleAdd .= "VALUES({$originalCategoryID},'{$originalArticleTransactionID}','{$originalArticleAuthorID}',now(),'0','0') ";
        $addArticleQuery = mysqli_multi_query($connection, $articleAdd);
        //Transaction validate point.
        if (!$addArticleQuery) {
            $transactFlag = false;
            $changedTable = "articles";
            $changeDetails = "SQL INSERT failed at addArticleQuery. Changes rolled back. ";
        }

        //Get article ID of newly created article.
        $getArticleID = "SELECT articleID FROM articles ORDER BY articleID DESC LIMIT 1";
        $getArticleIDQuery = mysqli_query($connection, $getArticleID);
        confirmquery($getArticleIDQuery);

        while($row = mysqli_fetch_assoc($getArticleIDQuery)) {
            $newArticleID = $row['articleID'];
        }

        //insert into articleTransactions table
        $articleTransactions = "INSERT INTO articleTransactions(articleID,transactionAuthorID,articleTitle,articleContent,articleImage,fileName, articleTags, transactionDate, articlePending) ";
        $articleTransactions .= "VALUES($newArticleID,'{$_SESSION['userID']}','{$originalArticleTitle}','{$originalArticleContent}','{$originalArticleImage}','{$originalFileName}','{$originalArticleTags}',now(), '1') ";
        $articleTransactionQuery = mysqli_multi_query($connection, $articleTransactions);
        if (!$articleTransactionQuery) {
            $transactFlag = false;
            $changedTable = "articleTransactions";
            $changeDetails = "SQL INSERT failed at articleTransactionQuery. Changes rolled back. ";
        }

        //Get new transactionID
        $getTransactionID = "SELECT transactionID FROM articleTransactions ORDER BY transactionID DESC LIMIT 1";
        $getTransactionIDQuery = mysqli_query($connection, $getTransactionID);
        confirmquery($getTransactionIDQuery);

        while($row = mysqli_fetch_assoc($getTransactionIDQuery)) {
            $newTransactionID = $row['transactionID'];
        }

        //update articles table with transactionID
        $articleUpdate = "UPDATE articles SET articleTransactionID = '{$newTransactionID}' WHERE articleID = {$newArticleID}";
        $articleUpdateQuery = mysqli_multi_query($connection, $articleUpdate);
        //Transaction validate point.
        if (!$articleUpdateQuery) {
            $transactFlag = false;
            $changedTable = "articleTransactions";
            $changeDetails = "SQL UPDATE failed at articleUpdateQuery. Changes rolled back.";
        }

        //Check for successful transaction.
        if ($transactFlag) {
            mysqli_commit($connection);
            } else {
                mysqli_rollback($connection);
            }
            ?>
            <script type="text/javascript">
                window.location = "index.php?<?php echo "$viewMod"."$displayMod"; ?>";   //Refreshes page
            </script>
            <?php

        $changedTable = "articles + articleTransactions";
        $changeDetails = "Duplicated Article ID #" . $articleID . ": &#039;" . $articleTitle . "&#039;";


        //write results to changelog.
        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

        //close db connection after transaction.
        mysqli_close($connection);

    }
}
?>