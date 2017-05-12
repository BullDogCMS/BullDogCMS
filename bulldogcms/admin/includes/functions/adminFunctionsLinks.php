<?php

function listLinks() {
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

    $linksCountQuery = "SELECT * FROM links";
    $findCount = mysqli_query($connection, $linksCountQuery);
    $count = mysqli_num_rows($findCount);

    $numPages = ceil($count / $perPage);
    session_start();
    $_SESSION['numPages'] = $numPages;//session variables passed to file calling this function
    $_SESSION['currentPage'] = $page;

    $query = "SELECT * FROM links ORDER BY linkTypeID, linkOrder LIMIT $page1, $perPage";
    $selectLinks = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($selectLinks)) {
        $linkID = $row['linkID'];
        $linkName = htmlentities($row['linkName'], ENT_QUOTES, 'UTF-8');
        $linkURL = htmlentities($row['linkURL'], ENT_QUOTES, 'UTF-8');
        $linkOrder = $row['linkOrder'];
        $linkTypeID = $row['linkTypeID'];
        $linkTypeName = $row['linkTypeName'];

        if ($linkName == "" || empty($linkName) || $linkURL == "" || empty($linkURL)) {
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter a Link Name.</div>';
        } else {
            $linkOrderCount = "SELECT * FROM links WHERE linkID = {$linkID} ORDER BY linkOrder DESC LIMIT 1";
            $query = mysqli_query($connection, $linkOrderCount);
            while ($row = mysqli_fetch_assoc($query)) {
                $lastOrderCount1 = $row['linkOrder'];
            }
            $nextOrderCount1 = $lastOrderCount1 + 1;

            echo "<tr>";
            echo "<td>
        <a href ='index.php?view=asidelinks&delete={$linkID}&name={$linkName}' data-toggle='tooltip' title='Delete' 
        onClick=\"javascript:return confirm('Are you sure you want to delete this?');\">
        <span class='glyphicon glyphicon-trash'></span><span class='sr-only'>Delete</span></a>
	    <a href ='index.php?view=linkedit&edit={$linkID}' data-toggle='tooltip' title='View & Edit'>
	        <span class='glyphicon glyphicon-pencil'></span><span class='sr-only'>Edit</span></a></td>";
            echo "<td>{$linkName}</td>";
            echo "<td>{$linkURL}</td>";
            echo "<td>{$linkOrder}</td>";
            if ($linkTypeID == 1) {
                echo "<td > Link</td >";
            }
            else {
                echo "<td>News</td>";
            }


            echo "</tr>";

        }
    }
}


function updatelinks($linkID, $linkOrder, $originalLinkTypeID){
    global $connection;

//update Links Table

    if (isset($_POST['updatelinks'])) {

        $linkName = mysqli_real_escape_string($connection, html_entity_decode($_POST['linkName'], ENT_QUOTES, 'UTF-8'));//unescaped because they were escaped on adminasidelinksedit page to be viewed.
        $linkURL = mysqli_real_escape_string($connection, html_entity_decode($_POST['linkURL'], ENT_QUOTES, 'UTF-8'));//unescaped because they were escaped on adminasidelinksedit page to be viewed.
        $linkNewOrder = mysqli_real_escape_string($connection, $_POST['linkOrder']);
        $linkTypeID = mysqli_real_escape_string($connection, html_entity_decode($_POST['linkTypeID'], ENT_QUOTES, 'UTF-8'));

        if ($originalLinkTypeID == $linkTypeID) { // Link Type Not Changed
//CHECK TO SEE IF ORDER CHANGED. IF SO RE-ORDER ALL NECESSARY LINKS.
        if ($linkNewOrder < $linkOrder) {
            $query = "SELECT * FROM links WHERE linkOrder >= {$linkNewOrder} AND linkTypeID = {$linkTypeID} AND linkID!= {$linkID} ORDER BY linkOrder";
            $getOrder_query = mysqli_query($connection, $query);
            $tempLinkOrder = $linkNewOrder;

            while ($row = mysqli_fetch_assoc($getOrder_query)) {
                $thisLinkID = $row['linkID'];
                $thisLinkOrder = $row['linkOrder'];
                if ($thisLinkOrder == $tempLinkOrder) {
                    $tempLinkOrder += 1;
                    $query = "UPDATE links SET linkOrder = $tempLinkOrder WHERE linkID = $thisLinkID";
                    $orderUpdate_query = mysqli_query($connection, $query);
                    confirmQuery($orderUpdate_query);
                }
            }
        }

        if ($linkNewOrder > $linkOrder) {
            $query = "SELECT * FROM links WHERE linkOrder <= $linkNewOrder AND linkOrder >= $linkOrder AND linkTypeID = {$linkTypeID} AND linkID != $linkID ORDER BY linkOrder DESC";
            $getOrder_query = mysqli_query($connection, $query);
            $tempLinkOrder = $linkNewOrder;

            while ($row = mysqli_fetch_assoc($getOrder_query)) {
                $thisLinkID = $row['linkID'];
                $thisLinkOrder = $row['linkOrder'];
                if ($thisLinkOrder == $tempLinkOrder) {
                    $tempLinkOrder -= 1;
                    $query = "UPDATE links SET linkOrder = $tempLinkOrder WHERE linkID= $thisLinkID";
                    $update_query = mysqli_query($connection, $query);
                    confirmQuery($update_query);
                }
            }
        }
//END OF RE-ORDERING

        $query = "UPDATE links SET linkName = '$linkName', linkURL = '$linkURL', linkOrder = '$linkNewOrder', linkTypeID = '$linkTypeID' WHERE linkID= '$linkID'";
        mysqli_query($connection, $query);
    } else { //Link Type Was Changed
//reorder links from previous type to avoid gap when this link is moved to new type
            $query = "SELECT * FROM links WHERE linkOrder>{$linkOrder} AND linkTypeID={$originalLinkTypeID} ORDER BY linkOrder";
            $orderCheckQuery = mysqli_query($connection, $query);
            if (mysqli_num_rows($orderCheckQuery) != 0) {
                $tempLinkOrder = $linkOrder;
                while($row = mysqli_fetch_assoc($orderCheckQuery)){
                    $thisLinkID = $row['linkID'];

                    $query = "UPDATE links SET linkOrder={$tempLinkOrder} WHERE linkID={$thisLinkID}";
                    $update_query = mysqli_query($connection, $query);

                    confirmQuery($update_query);

                    $tempLinkOrder += 1;
                }
            }

            //Finds the next largest order number based on the Link Type selected
            $linkOrderCount = "SELECT * FROM links WHERE linkTypeID = {$linkTypeID} ORDER BY linkOrder DESC LIMIT 1";
            $query = mysqli_query($connection, $linkOrderCount);
            while ($row = mysqli_fetch_assoc($query)) {
                $lastOrderCount = $row['linkOrder'];
            }
            $nextOrderCount = $lastOrderCount + 1;

            $query = "UPDATE links SET linkName = '$linkName', linkURL = '$linkURL', linkOrder = '$nextOrderCount', linkTypeID = '$linkTypeID' WHERE linkID= '$linkID'";
            mysqli_query($connection, $query);
        }

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=asidelinks";   //Refreshes page
            window.alert("Aside Link updated successfully.");
        </script>
        <?php

        //Insert into changeLog table
        $changedTable = "links";
        $changeDetails = "Aside Link &#039;" . $linkName . " &#039; was edited";

        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);
        mysqli_close($connection);
    }
}
// Delete Links

function deleteLinks() {
    global $connection;

    if (isset($_GET['delete'])) {
        $linkID = $_GET['delete'];

        $query = "SELECT * FROM links WHERE linkID = $linkID";
        $selectLink = mysqli_query($connection, $query);
        confirmQuery($selectLink);
        while ($row = mysqli_fetch_assoc($selectLink)) {
            $deletedLinkOrder = $row['linkOrder'];//linkOrder of to-be-deleted link record
            $deletedLinkTypeID = $row['linkTypeID'];//linkTypeID of to-be-deleted link record
        }

//DELETE LINK
        $query = "DELETE FROM links WHERE linkID = {$linkID}";
        $delete_query = mysqli_query($connection, $query);
        confirmquery($delete_query);

//If deleted link was not last in order, then reorder all links of that linkTypeID that have order greater than the one deleted
        $query = "SELECT * FROM links WHERE linkOrder>{$deletedLinkOrder} AND linkTypeID={$deletedLinkTypeID} ORDER BY linkOrder";
        $orderCheckQuery = mysqli_query($connection, $query);
        if (mysqli_num_rows($orderCheckQuery) != 0) {
            $tempLinkOrder = $deletedLinkOrder;
            while($row = mysqli_fetch_assoc($orderCheckQuery)){
                $thisLinkID = $row['linkID'];

                $query = "UPDATE links SET linkOrder={$tempLinkOrder} WHERE linkID={$thisLinkID}";
                $update_query = mysqli_query($connection, $query);

                confirmQuery($update_query);

                $tempLinkOrder += 1;
            }
        }

        //Insert into changeLog table
        $linkName = $_GET['name'];
        $changedTable = "links";
        $changeDetails = "Aside Link &#039;" . $linkName . " &#039; was deleted";

        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);
        mysqli_close($connection);
        ?>
        <script type="text/javascript">
            window.location = "index.php?view=asidelinks";   //Refreshes page
        </script>
        <?php
    }
}

?>


