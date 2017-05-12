<!--Called from the functions\adminArticles.php page-->
<?php
if(isset($_POST['articleAdd'])) {
    //articles table details
    $categoryID = $_POST['categoryID'];
    $transactionIDTemp = '999'; //Need a temporary placement since transactionID not yet created.
    $articleAuthorID = $_POST['articleAuthorID'];
    $createDate = date('d-m-y h:i:s');  //Not used yet
    IF ($GLOBAL['articleSubmission'] == 0) {//Checks site settings and updates visibility and pending accordingly -Micah
        $articlePending = '0'; //Not Pending
        $articleVisible = '1'; //Visibile
        }
    ELSE {
        $articleVisible = '0';  //Not visible
        $articlePending = '1';  //Pending
        }
    $articleLock = '0';  //Unlocked

    //articleTransactions table details
    $transactionAuthorID = $_SESSION['userID'];
    $articleTitle = mysqli_real_escape_string($connection, $_POST['articleTitle']);
    $articleContent = mysqli_real_escape_string($connection, $_POST['articleContent']);
    $articleImage = $_POST['image'];
    $articleTags = mysqli_real_escape_string($connection, $_POST['articleTags']);
    $transactionDate = date('d-m-y h:i:s');  //Not used yet
    $articlePDF = $_POST['PDF'];

    //changelog table details
    $userID = $_SESSION['userID'];
    $changedTable = "articles + articleTransactions";
    $changeDetails = "Added article: {$articleTitle}";


    //Begin transaction
    mysqli_autocommit($connection, false);
    $transactFlag = true;

    //Input validation
    if (isset($_POST['articleAdd'])) {
        if ($_POST['articleTitle'] == "" || $_POST['articleContent'] == "" || $_POST['categoryID'] == "0") {

            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Required fields have been left blank. Any uploads will have to be reselected.</div>';
        } else {
            //Add initial details to the articles table
            $articleAdd = "INSERT INTO articles(categoryID,articleTransactionID,articleAuthorID,articleCreateDate,articleVisible,articleLock) ";
            $articleAdd .= "VALUES({$categoryID},'{$transactionIDTemp}','{$articleAuthorID}',now(),'{$articleVisible}','{$articleLock}') ";
            $addArticleQuery = mysqli_multi_query($connection, $articleAdd);

            //Transaction validate point.
            if (!$addArticleQuery) {
                $transactFlag = false;
                $changedTable = "articles";
                $changeDetails = "SQL INSERT failed at addArticleQuery. Changes rolled back. ";
            }

            //Not the best way to get last ID.  Look into LAST_INSERT_ID()
            $query= "SELECT articleID FROM articles ORDER BY articleID DESC LIMIT 1";
            $articleIDQuery  = mysqli_query($connection, $query);
            confirmQuery($articleIDQuery);


            //Remove media if checkbox selected
            if (isset($_POST['imageRemove']) == 'remove') {
                $articleImage = "";
            }

            if (isset($_POST['fileRemove']) == 'remove') {
                $articlePDF = "";
            }

            //We have the articleID from previous Insert so now Insert into the articleTransaction table.
            while($row = mysqli_fetch_assoc($articleIDQuery)) {
                $articleID = $row['articleID'];

                $articleTransactions = "INSERT INTO articleTransactions(articleID,transactionAuthorID,articleTitle,articleContent,articleImage,fileName, articleTags, transactionDate, articlePending) ";
                $articleTransactions .= "VALUES($articleID,'{$transactionAuthorID}','{$articleTitle}','{$articleContent}','{$articleImage}','{$articlePDF}','{$articleTags}',now(), '{$articlePending}') ";
                $articleTransactionQuery = mysqli_multi_query($connection, $articleTransactions);
                //Transaction validate point.
                if (!$articleTransactionQuery) {
                    $transactFlag = false;
                    $changedTable = "articleTransactions";
                    $changeDetails = "SQL INSERT failed at articleTransactionQuery. Changes rolled back. ";
                }

                //Not the best way to get last ID.  Look into LAST_INSERT_ID()
                $query= "SELECT transactionID FROM articleTransactions ORDER BY transactionID DESC LIMIT 1";
                $transactionIDQuery  = mysqli_query($connection, $query);
                confirmQuery($transactionIDQuery);

                //Data inserted into articleTransaction and we have the transactionID, update the original articleID with that transactionID.
                while($row = mysqli_fetch_assoc($transactionIDQuery)) {
                    $transactionID = $row['transactionID'];

                    //Now Update the articles table the transactionID just inserted and replace the default 999 and unlock the article
                    $articleUpdate .= "UPDATE articles SET articleTransactionID = '{$transactionID}', articleLock = '0' WHERE articleID = {$articleID}";
                    $articleUpdateQuery = mysqli_multi_query($connection, $articleUpdate);
                    //Transaction validate point.
                    if (!$articleUpdateQuery) {
                        $transactFlag = false;
                        $changedTable = "articleTransactions";
                        $changeDetails = "SQL UPDATE failed at articleUpdateQuery. Changes rolled back.";
                    }

                }
            }

            //Check for successful transaction.
            if ($transactFlag) {
                mysqli_commit($connection);
                if(isset($_GET['action'])) {
                    $action = $_GET['action'];
                } else {
                    mysqli_rollback($connection);
                    $action = '';  //If something typed in wrong, set to default.
                }
                switch($action) {
                    case 'addpage';   //Refresh to Pending Pages
                        ?>
                        <script type="text/javascript">
                            window.location = "index.php?view=articles&display=pendingpages";   //Refreshes page
                        </script>
                        <?php
                        break;
                    default:
                        ?>
                        <script type="text/javascript">
                            window.location = "index.php?view=articles&display=pendingarticles";   //Refreshes page
                        </script>
                        <?php
                        break;
                }
                ?>
                <?php
                echo "Changes successful!";

                //Setup email notification details.
                $subject = $articleTitle . " article created in the bullDogCMS";
                $comment = $articleTitle . " article was created by " . $_SESSION['username'];
                emailNotification($subject, $comment); //Testing - LG
            } else {
                echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Changes unsuccessful. Please see changelog for details.' .$articleTransactions . '</div>';
            }
            //write results to changelog.
            insertChangeLog($userID, $changedTable, $changeDetails);

            //close db connection after transaction.
            mysqli_close($connection);
        }
    }

}

else if (isset($_POST['cancel'])) {

    ?>
    <script type="text/javascript">
        window.location = "index.php?view=articles";   //Refreshes page
    </script>
    <?php
}

?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group col-xs-12 col-md-6">
        <label for="articleTitle">Title</label>
        <input type="text" class="form-control" name="articleTitle" value="<?php echo isset($_POST['articleTitle']) ? $_POST['articleTitle'] : '' ?>" autofocus required>
    </div>

    <div class="form-group col-xs-12 col-md-6">
        <label for="categoryID">Category</label>
        <select class="form-control" name='categoryID' required>
            <!--Provide Default Option of 'Please Select', to be validated later.-->
            <!--<option value= "0">Please Select</option>-->
                <?php
                if(isset($_GET['action'])) {
                    $action = $_GET['action'];
                } else {
                    $action = '';  //If something typed in wrong, set to default.
                }
                switch($action) {
                    case 'addpage';
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
                        //Provide Default Option of 'Please Select', to be validated later.
                        echo "<option value= '0'>Please Select</option>";
                        //Query to return category list for dropdown for Articles
                        //CategoryID is not a special page and CategoryType allows articles
                        $categoryListing = "SELECT categoryID,categoryName FROM categories WHERE categoryID <> '1' AND categoryTypeID = '1' ORDER BY categoryName";
                        $categoryListingQuery = mysqli_query($connection, $categoryListing);
                        confirmQuery($categoryListingQuery);
                        //Outputs query results into 'option' control element (Dropdown list).
                        while ($row = mysqli_fetch_assoc($categoryListingQuery)) {
                            echo "<option value=" . $row['categoryID'] . ">" . $row['categoryName'] . "</option>";
                        }
                        break;
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
        <input id="artImage" type="text" name="image">
        <a href="filemanager/dialog.php?type=1&field_id=artImage&relative_url=1&fldr=images" class="btn btn-filemanager btn iframe-btn" type="button" data-toggle="tooltip" title="Choose image">Choose image</a>
        <!--<input class="filestyle" type="file" name="image" id="artImage" accept="image/*" data-classIcon="icon-plus" data-buttonText="Upload Image">-->

        <div>
            <input type="checkbox" name="imageRemove" value="remove"> Remove Image?<br>
        </div>
        <span class='label label-info' id="upload-file-info"></span>
    </div>


    <div class="form-group col-xs-12 col-md-6">
        <p><label for="articlePDF"> Upload File</label></p>
        <input id="artPDF" type="text" name="PDF">
        <a href="filemanager/dialog.php?type=2&field_id=artPDF&relative_url=1&fldr=documents" class="btn btn-filemanager btn iframe-btn" type="button" data-toggle="tooltip" title="Choose file">Choose file</a>
        <!--<input class="filestyle" type="file" name="PDF" id="artPDF" data-classIcon="icon-plus" data-buttonText="Upload PDF">-->

        <div>
            <input type="checkbox" name="fileRemove" value="remove"> Remove file?<br>
        </div>

        <span class='label label-info' id="upload-file-info"></span>
    </div>


    <div class="form-group col-xs-12">
        <label for="articleTags">Search Tags</label>
        <input type="text" class="form-control" name="articleTags" value="<?php echo isset($_POST['articleTags']) ? $_POST['articleTags'] : '' ?>">
    </div>

    <div class="form-group col-xs-12">
        <label for="articleContent">Content</label>
        <textarea class="editor form-control "name="articleContent" id="" cols="30" rows="10"><?php echo isset($_POST['articleContent']) ? $_POST['articleContent'] : '' ?></textarea>
    </div>
    <?php
    if(isset($_GET['action'])) {
        $action = $_GET['action'];
    } else {
        $action = '';  //If something typed in wrong, set to default.
    }
    switch($action) {
        case 'addpage';
            ?>
            <div class="form-group">
                <span>
                    <input class="btn btn-primary" type="submit" name="articleAdd" value="Add Page" data-toggle="tooltip" title="Add Page">
                </span>

                <span>
                    <input type="submit" name="cancel" value="Cancel" data-toggle="tooltip" title="Cancel">
                </span>
            </div>
            <?
            break;
        default:
            ?>
            <div class="form-group">
                <span>
                    <input class="btn btn-primary" type="submit" name="articleAdd" value="Add Article" data-toggle="tooltip" title="Add Article">
                </span>

                <span>
                    <input class = "btn btn-link" type="button" onclick="window.history.back()" value="Cancel" data-toggle="tooltip" title="Cancel">
                </span>
            </div>
            <?php
            break;
    }
    ?>
</form>