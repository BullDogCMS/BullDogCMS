<!-- Full Article Details Page -->

<!-- The global variable is inserting the correct number for the css page to display the correct size if the asides are off -->


    <?php
    $enableAuthorNames = $GLOBAL['enableAuthorNames'];//grabs site settings for author names -Micah
    if(isset($_GET['articleID'])) {
        $articleID = $_GET['articleID'];
    } else {
        $articleID = '999';  //Just something incase left blank and SQL doesn't error out.
    }

    $query = "SELECT *, DATE_FORMAT(articleCreateDate, \"%m-%d-%Y\") AS artDate, DATE_FORMAT(transactionDate, \"%m-%d-%Y\") AS transDate FROM articles a JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID WHERE a.articleID = $articleID ";
    $query .= "AND a.articleVisible = '1' AND at.articlePending = '0' ";
    $select_articles = mysqli_query($connection, $query);

    confirmQuery($select_articles);

    while($row = mysqli_fetch_assoc($select_articles)) {
        $articleTitle = htmlentities($row['articleTitle'], ENT_QUOTES, 'UTF-8');
        $articleAuthorID = $row['articleAuthorID'];
        $transactionAuthorID = $row['transactionAuthorID'];
        $articleCreateDate = $row['artDate'];
        $transactionDate = $row['transDate'];
        $articleImage = $row['articleImage'];
        $articleContent = $row['articleContent']; //editor takes care of escaping
        $fileName = $row['fileName'];

        ?>
        <!-- Article Details -->
        <h1 class="page-header">
            <?php echo $articleTitle ?>
        </h1>
	    <?php IF ($enableAuthorNames): //If statement to remove this section according to site settings -Micah
            //Resolve userIDs to usernames.  Only run if enableAuthorNames is checked.
            $authorNameSelect = "SELECT username, firstName, lastName from users WHERE userID = $articleAuthorID";
            $selectUser = mysqli_query($connection, $authorNameSelect);
            while ($row = mysqli_fetch_assoc($selectUser)) {
                $username= $row['username'];
                $authorFirstName = $row['firstName'];
                $authorLastName = $row['lastName'];
                if($GLOBAL['enableFullName'] == 1) {
                    $authorName = $authorFirstName . " " . $authorLastName;
                }
                else{
                    $authorName = $username;
                }
            }

            $authorUpdateNameSelect = "SELECT username, firstName, lastName from users WHERE userID = $transactionAuthorID";
            $selectUpdateUser = mysqli_query($connection, $authorUpdateNameSelect);
            while ($row = mysqli_fetch_assoc($selectUpdateUser)) {
                $transactionUserName = $row['username'];
                $transactionFirstName = $row['firstName'];
                $transactionLastName = $row['lastName'];
                if($GLOBAL['enableFullName'] == 1) {
                    $transactionAuthorName = $transactionFirstName . " " . $transactionLastName;
                }
                else {
                    $transactionAuthorName = $username;
                }
            }
            ?>
        <p class="lead">
		    Created by <a href="index.php?view=articlelist&display=articlesbyauthor&authorID=<?php echo $articleAuthorID;?>"><?php echo $authorName ?></a>
		    &nbsp;<small><span class="glyphicon glyphicon-time"></span> <?php echo $articleCreateDate ?></small><br/>
		    <small>Updated by <a href="index.php?view=articlelist&display=articlesbyauthor&authorID=<?php echo $transactionAuthorID;?>"><?php echo $transactionAuthorName ?></a>
			    &nbsp;<small><span class="glyphicon glyphicon-time"></span> <?php echo $transactionDate  ?></small></small>
	    </p>
        <?php ENDIF; //End of the if statement surrounding the author names and dates -Micah?>

	    <div class="row">
            <div class="col-xs-12 dont-break-out">
                <?php if(isset($articleImage) && $articleImage != ''){
                ?>
                    <img class="img-responsive img-rounded artImage" src="uploads/<?php echo $articleImage ?>" alt="<?php echo $articleTitle; ?>">
                <?php } echo $articleContent?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 dont-break-out">
                <?php
                if(!$fileName == ""){  // if no filename in database, do not run this part ?>
                    <br><br><p><a href="uploads/<?php echo $fileName ?>">Download file</a></p>
                    <div>
                        <?php echo "<iframe src='http://docs.google.com/gview?url=http://{$_SERVER['HTTP_HOST']}/uploads/{$fileName}&embedded=true' class='pdf_viewer' frameborder='0'></iframe>" ?>
                    </div>

                <?php }} ?>
            </div>
        </div>

