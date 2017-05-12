<!--A general location to put functions not sure where they should go -->
<?php

function confirmQuery($result) {
    global $connection;
    //If there is a problem with SQL process, posts a message where query failed at.
    if(!$result) {
        die("QUERY FAILED ." . mysqli_error($connection));
    }
}

function insertChangeLog($userID, $changedTable, $changeDetails) {
    global $connection;

    $changeDate = date('d-m-y h:i:s');  //Not used yet

    $query = "INSERT INTO changeLog(changeByUserID,changedTable,changeDetails,changeDate) ";
    $query .= "VALUE('{$userID}','{$changedTable}','{$changeDetails}',now()) ";

    $insertChangeLog = mysqli_query($connection, $query);

    #If not successful kill script
    confirmQuery($insertChangeLog);
    mysqli_close($connection);
}

function listChangeLog() {
    global $connection;

//PAGINATION
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

    $changeLogCountQuery = "SELECT * FROM changeLog c JOIN users u on c.changeByUserID = u.userID";
    //If filtering via search, append to query.
    if (isset($_GET['searchtype'])) {
        $searchType = $_GET['searchtype'];
        $searchTerm = $_GET['searchterm'];

        $changeLogCountQuery .= " WHERE";

        switch ($searchType) {
            case 'changeby';
                $changeLogCountQuery .= " u.username LIKE '%" . $searchTerm . "%'";
                break;
            case 'table';
                $changeLogCountQuery .= " c.changedTable LIKE '%" . $searchTerm . "%'";
                break;
            case 'details';
                $changeLogCountQuery.= " c.changeDetails LIKE '%" . $searchTerm . "%'";
                break;
            case 'default';
                $changeLogCountQuery .= "";
                break;
        }
    }

    $findCount = mysqli_query($connection, $changeLogCountQuery);
    $count = mysqli_num_rows($findCount);

    $numPages = ceil($count / $perPage);

    session_start();
    $_SESSION['numLogPages'] = $numPages;//session variables passed to file calling this function
    $_SESSION['currentLogPage'] = $page;
//END PAGINATION (Rest of pagination code in adminChangeLog.php)


    if (isset($_GET['order'])) {
        $order = $_GET['order'];
    }

    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
    }



    $query = "SELECT * FROM changeLog c JOIN users u on c.changeByUserID = u.userID";

    //Get query modifier based on sort and search.
    if (isset($_GET['searchtype'])) {
        $searchType = $_GET['searchtype'];
        $searchTerm = $_GET['searchterm'];

        $query .= " WHERE";

        //Table to search
        switch ($searchType) {
            case 'changeby';
                $query .= " u.username LIKE '%" . $searchTerm . "%'";
                break;
            case 'table';
                $query .= " c.changedTable LIKE '%" . $searchTerm . "%'";
                break;
            case 'details';
                $query .= " c.changeDetails LIKE '%" . $searchTerm . "%'";
                break;
            case 'default';
                $query .= "";
                break;
        }
    }
    //order by selected column
    switch($order) {
        case 'changeby';
            $query .= " ORDER BY c.changeByUserID";
            break;
        case 'table';
            $query .= " ORDER BY c.changedTable";
            break;
        case 'details';
            $query .= " ORDER BY c.changeDetails";
            break;
        case 'date';
            $query .= " ORDER BY c.changeDate";
            break;
        default:
            $query .= " ORDER BY c.changeDate";
            break;
    }
    //Sort by ascending or descending.
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


    $selectCategories = mysqli_query($connection, $query);

    confirmQuery($selectCategories);

    while($row = mysqli_fetch_assoc($selectCategories)) {
        $changeID = $row['changeID'];
        $username = $row['username'];
        $changedTable = $row['changedTable'];
        $changeDetails = $row['changeDetails'];
        $changeDate = $row['changeDate'];

        echo "<tr>";
        echo "<td>{$username}</td>";
        echo "<td>{$changedTable}</td>";
        echo "<td>{$changeDetails}</td>";
        echo "<td>{$changeDate}</td>";
        echo "</tr>";
    }

    //mysqli_close($connection);

}

function emailNotification($subject, $comment) {
    global $connection;

    $queryFrom = "SELECT siteEmail, siteName FROM siteSettings WHERE siteSettingID = '1'";
    $selectFromEmail= mysqli_query($connection, $queryFrom);

    confirmQuery($selectFromEmail);

    while($row = mysqli_fetch_assoc($selectFromEmail)) {
        $emailFrom = $row['siteEmail'];
        $siteName = $row['siteName']; //Used for email name display
    }

    //Email information
    //Initial code came from: http://www.inmotionhosting.com/support/website/sending-email-from-site/using-the-php-mail-function-to-send-emails
    //Lookup which admins want to receive the email notifications.
    $query = "SELECT * FROM users WHERE emailNotification = '1'";
    $selectEmail= mysqli_query($connection, $query);

    confirmQuery($selectEmail);

    //Loop through each user found with emailNotification enabled and email them.
    while($row = mysqli_fetch_assoc($selectEmail)) {
        $emailTo = $row['email'];

        //Send email
        //Adding display name:  http://stackoverflow.com/questions/3644081/what-is-the-format-for-e-mail-headers-that-display-a-name-rather-than-the-e-mail
        mail($emailTo, "$subject", $comment, "From: " . $siteName . "<". $emailFrom .">" );

    }
}


?>