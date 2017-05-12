<?php
/*
//Different SQL query for only articles labeled as Special Pages, but still using adminArticleList.php for display.

function listPages($pending) {
    global $connection;

    $query = "SELECT * FROM articles a";
    $query .= " JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID";
    $query .= " JOIN users u ON articleAuthorID = u.userID";
    $query .= " JOIN categories c ON c.categoryID = a.categoryID";
    $query .= " WHERE at.articlePending IN($pending) and a.categoryID = '1'"; //CatID 1 = Special Page
    $query .= " ORDER BY transactionDate desc";
    $select_all_articles = mysqli_query($connection, $query);

    confirmQuery($select_all_articles);

    while($row = mysqli_fetch_assoc($select_all_articles)) {

        $articleID = $row['articleID'];
        $articleTitle = $row['articleTitle'];
        $categoryName = $row['categoryName']; //Should always be Special Page
        $articleAuthorID = $row['articleAuthorID'];
        $username = $row['username'];
        $transactionID = $row['transactionID'];
        $articleCreateDate = $row['createDate'];
        $transactionDate = $row['transactionDate'];
        $articleImage = $row['articleImage'];
        $articleTags = $row['articleTags'];
        $articleContent = $row['articleContent'];

        echo "<tr>";
        if($row['articlePending'] == '1'){
            echo "<td><a href='index.php?view=articles&setpendingno={$transactionID}'>
                <span class='glyphicon glyphicon-exclamation-sign'></span><span class='sr-only'>Visibility</span></a></td>";
        }else{
            echo "<td><span class='glyphicon glyphicon-ok-sign'></span><span class='sr-only'>Visibility</span></td>";
        }
        if($row['articleVisible'] == '0'){
            echo "<td><a href='index.php?view=articles&setvisibleyes={$articleID}'>
                <span class='glyphicon glyphicon-eye-close'></span><span class='sr-only'>Visibility</span></a></td>";
        }else{
            echo "<td><a href='index.php?view=articles&setvisibleno={$articleID}'>
                <span class='glyphicon glyphicon-eye-open'></span><span class='sr-only'>Visibility</span></a></td>";
        }
        //echo "<td>{$articleVisible}</td>";
        echo "<td>{$articleID}</td>";
        echo "<td>{$articleTitle}</td>";
        echo "<td>{$categoryName}</td>";
        echo "<td>{$articleAuthorID}</td>";
        echo "<td>{$username}</td>";
        echo "<td>{$transactionID}</td>";
        echo "<td>{$articleCreateDate}</td>";
        echo "<td>{$transactionDate}</td>";
        echo "<td><img width='100' src='../images/{$articleImage}'></td>";  //Hard code to special page image?
        echo "<td>{$articleTags}</td>";
        echo "<td>{$articleContent}</td>";
        echo "</tr>";

    }
}
*/
?>