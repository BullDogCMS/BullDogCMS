<!-- Single Web Page template for things like About Us, Contact Us, etc...-->
<!-- Using same process as Articles but has a specialPage flag-->

<!-- The global variable is inserting the correct number for the css page to display the correct size if the asides are off -->


    <?php

    if(isset($_GET['articleID'])) {
        $articleID = $_GET['articleID'];
    } else {
        $articleID = '999';  //Just something incase left blank and SQL doesn't error out.
    }

    $query = "SELECT * FROM articles a JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID WHERE a.articleID = $articleID ";
    $select_articles = mysqli_query($connection, $query);

    confirmQuery($select_articles);

    while($row = mysqli_fetch_assoc($select_articles)) {
        $articleTitle = htmlentities($row['articleTitle'], ENT_QUOTES, 'UTF-8');
        $articleAuthorID = $row['articleAuthorID'];
        $transactionAuthorID = $row['transactionAuthorID'];
        $articleCreateDate = $row['createDate'];
        $transactionDate = $row['transactionDate'];
        $articleImage = $row['articleImage'];
        $articleContent = $row['articleContent'];//escaping covered by editor
        $fileName = $row['fileName'];

        ?>
    <h1 class="page-header">
        <?php echo $articleTitle ?>
    </h1>

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
                <embed src="uploads/<?php echo $fileName ?>" width = "100%" height = "800"></embed>

            <?php }} ?>
        </div>
    </div>

