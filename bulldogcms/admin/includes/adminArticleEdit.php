<!--Called from the functions\adminArticleList.php page-->
<?php
if(isset($_GET['edit'])) {

    //Get origin page for return link.
    if(isset($_GET['originview'])) {
        $viewMod = "view=" . $_GET['originview'];
    }

    if(isset($_GET['origindisplay'])) {
        $displayMod = "&display=" . $_GET['origindisplay'];
    } else {
        $displayMod = "";
    }

    //articles table details
    $categoryID = $_POST['categoryID'];
    $transactionIDTemp = '999'; //Need a temporary placement since transactionID not yet created.
    $articleAuthorID = $_POST['articleAuthorID'];
    $createDate = date('d-m-y h:i:s');  //Not used yet
    IF ($GLOBAL['articleSubmission'] == 0) {//checks site settings for article submission updates visibility and pending accordingly -Micah
        $articlePending = '0'; //Not Pending
        $articleVisible = '1'; //Visible
    }
    ELSE {
        $articleVisible = '0';  //Not visible
        $articlePending = '1';  //Pending
    }

    //articleTransactions table details
    $transactionAuthorID = $_SESSION['userID'];
    $articleTitle = mysqli_real_escape_string($connection, html_entity_decode($_POST['articleTitle'], ENT_QUOTES, 'UTF-8'));//html unescaped for database insertion.
    $articleContent = mysqli_real_escape_string($connection, $_POST['articleContent']);//From editor
    $articleImage = $_POST['image'];
    $articleTags = mysqli_real_escape_string($connection, html_entity_decode($_POST['articleTags'], ENT_QUOTES, 'UTF-8'));//html unescaped for database insertion.
    $transactionDate = date('d-m-y h:i:s');  //Not used yet
    $articlePDF = $_POST['PDF'];

    //changelog table details
    $userID = $_SESSION['userID'];
    $changedTable = "articles + articleTransactions";
    $changeDetails = "Edited article: {$articleTitle}";

    //Flag to check for page refresh
    $refreshFlag = FALSE;

    //Query database for existing article, for default values.
    $originalArticleID = $_GET['edit'];
    $originalTransactionID = $_GET['transaction'];

    //-------------------------------------------------------------------------------------------------------------------
    //Retrieve Original Values
    //-------------------------------------------------------------------------------------------------------------------

    //Lock article, as it is currently being edited.
    $lockArticles = "UPDATE articles SET articleLock = '1' WHERE articleID = {$originalArticleID}";
    $articlesLockQuery = mysqli_query($connection, $lockArticles);
    confirmQuery($articlesLockQuery);

    //get original articles table info
    $originalArticle = "SELECT * FROM articles WHERE articleID = {$originalArticleID} AND articleTransactionID = {$originalTransactionID}";
    $originalArticleQuery = mysqli_query($connection, $originalArticle);
    confirmQuery($originalArticleQuery);
    //Transaction validate point.
    if (!$originalArticleQuery) {
        $transactFlag = false;
        $changedTable = "articles";
        $changeDetails = "SQL SELECT failed at originalArticleQuery. Changes rolled back. " . $originalArticle;
    }
    while($row = mysqli_fetch_assoc($originalArticleQuery)) {
        $originalArticleCreateDate = $row['articleCreateDate'];
        $originalArticleAuthorID = $row['articleAuthorID'];
        $originalCategoryID = $row['categoryID'];
        $originalArticleTransactionID = $row['articleTransactionID'];
    }

    //Get original articleTransactions table details
    $originalTransactions = "SELECT * FROM articleTransactions WHERE articleID = {$originalArticleID} AND transactionID = {$originalTransactionID}";
    $originalTransactionsQuery = mysqli_query($connection, $originalTransactions);
    confirmQuery($originalTransactionsQuery);
    //Transaction validate point.
    if (!$originalTransactionsQuery) {
        $transactFlag = false;
        $changedTable = "articleTransactions";
        $changeDetails = "SQL SELECT failed at originalTransactionsQuery. Changes rolled back. " . $originalTransactions;
    }
    while($row = mysqli_fetch_assoc($originalTransactionsQuery)) {
        $originalArticleTitle = htmlentities($row['articleTitle'], ENT_QUOTES, 'UTF-8');//This is escaped here to be viewed on page but unescaped before database entry.
        $originalArticleTags = htmlentities($row['articleTags'], ENT_QUOTES, 'UTF-8');//This is escaped here to be viewed on page but unescaped before database entry.
        $originalArticleContent = htmlentities($row['articleContent'], ENT_QUOTES, 'UTF-8'); //This is only escaped here to work with wysiwyg editor.
        $originalArticleImage = $row['articleImage'];
        $originalFileName = $row['fileName'];
    }

    //Get original categories table info
    //Get Category name where id = original ID
    $originalCategory = "SELECT categoryName FROM categories WHERE categoryID = {$originalCategoryID}";
    $originalCategoryQuery = mysqli_query($connection, $originalCategory);
    confirmQuery($originalCategoryQuery);
    //Transaction validate point.
    if (!$originalCategoryQuery) {
        $transactFlag = false;
        $changedTable = "categories";
        $changeDetails = "SQL SELECT failed at originalCategoryQuery. Changes rolled back. " . $originalCategory;
    }
    while($row = mysqli_fetch_assoc($originalCategoryQuery)) {
        $originalCategoryName = $row['categoryName'];
    }


    //-------------------------------------------------------------------------------------------------------------------
    //Update Article
    //-------------------------------------------------------------------------------------------------------------------

    //Begin transaction
    mysqli_autocommit($connection, false);
    $transactFlag = true;

    //Input validation
    if (isset($_POST['updateArticle'])) {
        if ($_POST['articleTitle'] == "" || $_POST['articleContent'] == "" || $_POST['categoryID'] == "0") {
            $refreshFlag = TRUE;
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Required fields have been left blank. Any uploads will have to be reselected.</div>';
        } else {
            //Check for Image upload or removal
            if ($articleImage == ""){
                $articleImage = $originalArticleImage;
            } else {

            }

            if (isset($_POST['imageRemove']) == 'remove') {
                $articleImage = "";
            }

            //Check for file upload
            if ($articlePDF == "") {
                $articlePDF = $originalFileName;
            }

            if (isset($_POST['fileRemove']) == 'remove') {
                $articlePDF = "";
            }

            //Update articles table info
            $articles = "UPDATE articles
                         SET categoryID = '{$categoryID}',
                         articleVisible = '{$articleVisible}',
                         articleLock = '{$articleLock}'
                         WHERE articleTransactionID = {$originalTransactionID}";

            $articlesQuery = mysqli_multi_query($connection, $articles);
            //Transaction validate point.
            if (!$articlesQuery) {
                $transactFlag = false;
                $changedTable = "articles";
                $changeDetails = "SQL UPDATE failed at articlesQuery. Changes rolled back. " . $articles;
            }

            //Update articleTransactions table info
            $articleTransactions = "UPDATE articleTransactions 
                                    SET transactionAuthorID = '{$transactionAuthorID}', 
                                    articleTitle = '{$articleTitle}',
                                    articleContent = '{$articleContent}',
                                    articleImage = '{$articleImage}',
                                    fileName = '{$articlePDF}',
                                    articleTags = '{$articleTags}',
                                    articlePending = '{$articlePending}',
                                    transactionDate = now()
                                    WHERE transactionID = {$originalTransactionID}";

            $articleTransactionQuery = mysqli_multi_query($connection, $articleTransactions);
            //Transaction validate point.
            if (!$articleTransactionQuery) {
                $transactFlag = false;
                $changedTable = "articleTransactions";
                $changeDetails = "SQL UPDATE failed at articleTransactionQuery. Changes rolled back. " . $articleTransactions;
            }
        }

        //Check for successful Transaction
        if ($transactFlag) {
            mysqli_commit($connection);
            if(isset($_GET['view'])) {
                $view = $_GET['view'];
            } else {
                mysqli_rollback($connection);
                $view = '';  //If something typed in wrong, set to default.
            }
            switch($view) {
                case 'pageedit'; //Refresh to Pending Pages
                    ?>
                    <script type="text/javascript">
                        window.location = "index.php?view=articles&display=specialpages";   //Refreshes page
                        window.alert("Special Page updated successfully.");
                    </script>
                    <?php
                    break;
                default:
                    ?>
                    <script type="text/javascript">
                        window.location = "index.php?view=articles";   //Refreshes page
                        window.alert("Article updated successfully.");
                    </script>
                    <?php
                    break;
            }
            ?>

            <?php
            echo "Changes successful!";

            //Setup email notification details.
            $subject = $articleTitle . " article edited in the bullDogCMS";
            $comment = $articleTitle . " article was edited by " . $_SESSION['username'];
            emailNotification($subject, $comment); //Testing - LG
        } else {
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Changes unsuccessful. Please see changelog for details.</div>';
        }

        //Unlock article.
        $unlockArticles = "UPDATE articles SET articleLock = 0 WHERE articleID = {$originalArticleID}";
        $articlesUnlockQuery = mysqli_query($connection, $unlockArticles);
        confirmQuery($articlesUnlockQuery);

        //write results to changelog.
        insertChangeLog($userID, $changedTable, $changeDetails);

        //close db connection after transaction.
        mysqli_close($connection);
    }

    //-------------------------------------------------------------------------------------------------------------------
    //Cancel Transaction.
    //-------------------------------------------------------------------------------------------------------------------
    else if (isset($_POST['cancel'])) {
        //Unlock article.
        $unlockArticles = "UPDATE articles SET articleLock = 0 WHERE articleID = {$originalArticleID}";
        $articlesUnlockQuery = mysqli_query($connection, $unlockArticles);
        confirmQuery($articlesUnlockQuery);


        ?>
        <script type="text/javascript">
            window.location = "index.php?<?php echo $viewMod.$displayMod; ?>";   //Refreshes page
        </script>
        <?php
    }
}
?>

<!--End PHP area ------------------------------------------------------------------------------------------------------>
<!--Start of HTML area ------------------------------------------------------------------------------------------------>

<form action="" method="post" enctype="multipart/form-data">
    <!--<h1 class="page-header">Edit Article</h1>-->

    <?php echo $HTMLTest ?>

    <div class="form-group col-xs-12 col-md-6">
        <label for="articleTitle">Title</label>
        <input type="text" class="form-control" name="articleTitle" value="<?php echo isset($_POST['articleTitle']) ? $_POST['articleTitle'] : $originalArticleTitle ?>" required autofocus onfocus="this.select();">
    </div>

    <div class="form-group col-xs-12 col-md-6">
        <label for="categoryID">Category</label>
        <select class="form-control" name= 'categoryID' required>
            <?php

            if(isset($_GET['view'])) {
                $view = $_GET['view'];
            } else {
                $view = '';  //If something typed in wrong, set to default.
            }
            switch($view) {
                case 'pageedit';
                    //Query to set to Special Page on Add Special Page.
                    $categoryListing = "SELECT categoryID,categoryName FROM categories WHERE categoryID = '1'";
                    $categoryListingQuery = mysqli_query($connection, $categoryListing);
                    confirmQuery($categoryListingQuery);
                    //Outputs query results into 'option' control element (Dropdown list).
                    while ($row = mysqli_fetch_assoc($categoryListingQuery)) {
                        echo "<option value=" . $row['categoryID'] . ">" . $row['categoryName'] . "</option>";
                    }
                    break;
                default:
                    echo "<option value ='{$originalCategoryID}'>{$originalCategoryName}</option>";

                    //Query to return category list for dropdown.
                    $categoryListing = "SELECT categoryID,categoryName FROM categories  WHERE categoryID <> '1' AND categoryTypeID = '1' ORDER BY categoryName";
                    $categoryListingQuery = mysqli_query($connection, $categoryListing);
                    confirmQuery($categoryListingQuery);

                    //Outputs query results into 'option' control element (Dropdown list).
                    while ($row = mysqli_fetch_assoc($categoryListingQuery)) {
                        echo "<option value=" . $row['categoryID'] . ">" . $row['categoryName'] . "</option>";
                    }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <input type="hidden" class="form-control" name="articleAuthorID" value= "<?php echo $_SESSION['userID']; ?>" readonly= "readonly">
    </div>

    <div class="form-group col-xs-12">
        <label for="authorName">Author Name</label>
        <input type="text" class="form-control" name="authorName" value= "<?php echo $_SESSION['fullName']; ?>" readonly= "readonly">
    </div>

    <div class="form-group col-xs-12 col-md-6">
        <p><label for="articleImage"> Image</label></p>
        <?php if($originalArticleImage == "") {} else { echo "<div> <img width='100' src='../uploads/{$originalArticleImage}'> </div>";}?>
        <input id="artImage" type="text" name="image">
        <a href="filemanager/dialog.php?type=1&field_id=artImage&relative_url=1&fldr=images" class="btn btn-filemanager btn iframe-btn" type="button" data-toggle="tooltip" title="Choose image">Choose image</a>

        <div>
            <input type="checkbox" name="imageRemove" value="remove"> Remove Image?<br>
        </div>

        <!--<input class="filestyle" type="file" name="image" id="artImage" accept="image/*" data-classIcon="icon-plus" data-buttonText="Upload Image">-->
        <span class='label label-info' id="upload-file-info"></span>
    </div>

    <div class="form-group col-xs-12 col-md-6">
        <p><label for="articlePDF"> Upload File</label></p>
        <?php if($originalFileName == "") {} else { echo "<iframe src='http://docs.google.com/gview?url=http://{$_SERVER['HTTP_HOST']}/uploads/{$originalFileName}&embedded=true' style='width:600px; height:500px;' frameborder='0'></iframe>";}?>
        <input id="artPDF" type="text" name="PDF">
        <a href="filemanager/dialog.php?type=2&field_id=artPDF&relative_url=1&fldr=documents" class="btn btn-filemanager btn iframe-btn" type="button" data-toggle="tooltip" title="Choose file">Choose file</a>
        <!--<input class="filestyle" type="file" name="PDF" id="artPDF" data-classIcon="icon-plus" data-buttonText="Upload PDF">-->
        <span class='label label-info' id="upload-file-info"></span>
    </div>

    <div>
        <input type="checkbox" name="fileRemove" value="remove"> Remove file?<br>
    </div>

    <div class="form-group col-xs-12">
        <label for="articleTags">Search Tags</label>
        <input type="text" class="form-control" name="articleTags" value="<?php echo isset($_POST['articleTags']) ? $_POST['articleTags'] : $originalArticleTags ?>">
    </div>

    <div class="form-group col-xs-12">
        <label for="articleContent">Content</label>
        <textarea class="editor form-control "name="articleContent" id="" cols="30" rows="10"><?php echo isset($_POST['articleContent']) ? $_POST['articleContent'] : $originalArticleContent ?></textarea>

    </div>


    <div class="form-group col-xs-12">
        <span>
            <input class="btn btn-primary" type="submit" name="updateArticle" value="Save Changes" data-toggle="tooltip" title="Save Changes">
        </span>
        <span>
            <input class = "btn btn-link" type="submit" name="cancel" value="Cancel" data-toggle="tooltip" title="Cancel">
        </span>
    </div>
</form>


