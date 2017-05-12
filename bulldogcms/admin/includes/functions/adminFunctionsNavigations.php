<?php

function insertNavigation()
{
    global $connection;

    if (isset($_POST['submit'])) {
        $navigationName = mysqli_real_escape_string($connection, ucfirst($_POST['navigationName']));
        $navLocation = $_POST['navLocation'];
        $navButtonColor = $_POST['navButtonColor'];
        $navButtonSize = $_POST['navButtonSize'];
        $navJavaScript = $_POST['navJavaScript'];
        $navURL = mysqli_real_escape_string($connection, $_POST['navURL']);

//      Check to make sure Navigation name is not blank
        if ($navigationName == "" || empty($navigationName)) {
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter a Navigation Name.</div>';
        } else {

//      Check to make sure Navigation name is unique
            $navNames = "SELECT navigationName FROM navigations";
            $nameCheckQuery = mysqli_query($connection, $navNames);
            $navExists = False;
            while($row = mysqli_fetch_assoc($nameCheckQuery)){
                $eachName = $row['navigationName'];
                if (strcasecmp($navigationName, $eachName) == 0){
                    $navExists = True;
                    break;
                }
            }

            if ($navExists == False) {
                //Finds the next largest order number for Navigation
                $navOrderCount = "SELECT * FROM navigations ORDER BY navigationOrder DESC LIMIT 1";
                $query = mysqli_query($connection, $navOrderCount);
                while ($row = mysqli_fetch_assoc($query)) {
                    $lastOrderCount = $row['navigationOrder'];
                }
                $nextOrderCount = $lastOrderCount + 1;

                $query = "INSERT INTO navigations(navigationName,navigationURL,navigationLocation,navigationVisible,navigationOrder, navButtonColor, navButtonSize, navJavaScript) ";
                $query .= "VALUE('{$navigationName}','{$navURL}','{$navLocation}','1','{$nextOrderCount}','{$navButtonColor}','{$navButtonSize}','{$navJavaScript}') ";
                $insertNavigation = mysqli_query($connection, $query);

                #If not successful kill script
                confirmQuery($insertNavigation);

                ?>
                <script type="text/javascript">
                    window.location = "index.php?view=navigations";   //Refreshes page
                </script>
                <?php

                //header("Location: navigations.php"); //Refreshes page

                //Insert into changeLog table
                $userID = $_SESSION['userID'];
                $changedTable = "navigations";
                $changeDetails = "Added: {$navigationName}";
                insertChangeLog($userID, $changedTable, $changeDetails);

                mysqli_close($connection);
            }
            else{
                echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> This Navigation already exists!</div>';
            }
        }
    }
}

function listNavigations() {
    global $connection;
//PAGINATION (REST OF NECESSARY CODE IS AT THE BOTTOM OF THE PAGE CALLING THIS FUNCTION (adminNavigations.php))
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

    $navigationCountQuery = "SELECT * FROM navigations";
    $findCount = mysqli_query($connection, $navigationCountQuery);
    $count = mysqli_num_rows($findCount);

    $numPages = ceil($count / $perPage);
    session_start();
    $_SESSION['numPages'] = $numPages;//session variables passed to file calling this function
    $_SESSION['currentPage'] = $page;


    $query = "SELECT * FROM navigations ORDER BY navigationOrder LIMIT $page1, $perPage";//END PAGINATION
    $selectNavigations = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($selectNavigations)) {
        $navigationID = $row['navigationID'];
        $navigationName = htmlentities($row['navigationName'], ENT_QUOTES, 'UTF-8');
        $navigationURL = htmlentities($row['navigationURL'], ENT_QUOTES, 'UTF-8');
        $navigationOrder = $row['navigationOrder'];
        $navButtonColor = $row['navButtonColor'];
        $navButtonSize = $row['navButtonSize'];
        $navigationVisible = $row['navigationVisible'];
        $navigationLocation = $row['navigationLocation'];
        $navJavaScript = $row['navJavaScript'];

        echo "<tr>";

        echo "<td>";
        if($navigationID  != '1'){
            echo   "<a href ='index.php?view=navigations&delete={$navigationID}&name={$navigationName}' data-toggle='tooltip' title='Delete' 
                onClick=\"javascript:return confirm('Are you sure you want to delete this?');\">
			<span class='glyphicon glyphicon-trash'></span><span class='sr-only'>Delete</span></a>";}
        echo "<a href ='index.php?view=navedit&edit={$navigationID}&name={$navigationName}' data-toggle='tooltip' title='Edit'>
	        <span class='glyphicon glyphicon-pencil'></span><span class='sr-only'>Edit</span></a>";

        if ($navigationVisible == '0'){
            echo "<a href='index.php?view=navigations&setvisibleyes={$navigationID}&name={$navigationName}' data-toggle='tooltip' title='Turn Visibility ON'>
            <span class='glyphicon glyphicon-eye-close'></span><span class='sr-only'>Visibility</span></a></td>";
        }else{
            echo "<a href='index.php?view=navigations&setvisibleno={$navigationID}&name={$navigationName}' data-toggle='tooltip' title='Turn Visibility OFF'>
            <span class='glyphicon glyphicon-eye-open'></span><span class='sr-only'>Visibility</span></a></td>";
        }

        echo "<td>{$navigationName}</td>";
        echo "<td>{$navigationURL}</td>";
        echo "<td>{$navigationOrder}</td>";
 //Color
        /*if ($navButtonColor == "btn btn-primary"){
            echo "<td>Default Button Color</td>";
        }
        elseif ($navButtonColor == "btn btn-info"){
            echo "<td>Light Blue</td>";
        }
        elseif ($navButtonColor == "btn btn-success"){
            echo "<td>Green</td>";
        }
        elseif ($navButtonColor == "btn btn-warning"){
            echo "<td>Yellow</td>";
        }
        elseif ($navButtonColor == "btn btn-danger"){
            echo "<td>Red</td>";
        }
        elseif ($navButtonColor == ""){
            echo "<td>None</td>";
        }
        else {
            echo "<td>$navButtonColor</td>";
        }*/
 //Size
        /*if ($navButtonSize == "btn-xs"){
            echo "<td>Small</td>";
        }
        elseif ($navButtonSize == "btn-lg"){
            echo "<td>Large</td>";
        }
        elseif ($navButtonSize == "") {
            echo "<td>Medium</td>";
        }
        else {
            echo "<td>$navButtonSize</td>";
        }*/
 //Location
        if ($navigationLocation == "1"){
            echo "<td>Header</td>";
        }
        elseif ($navigationLocation == "2"){
            echo "<td>Header, Footer</td>";
        }
        elseif ($navigationLocation == "3") {
            echo "<td>Header, Footer, Body</td>";
        }
        elseif ($navigationLocation == "4") {
            echo "<td>Body</td>";
        }
        elseif ($navigationLocation == "5") {
            echo "<td>Footer</td>";
        }
        else {
            echo "<td>$navigationLocation</td>";
        }

        echo "<td>{$navJavaScript}</td>";
        echo "</tr>";
    }
//    if ($numPages > 1){
//        echo "<h4>Page $page</h4>";
//    }
}

function deleteNavigation() {
    global $connection;

    if(isset($_GET['delete'])) {
        $navID = $_GET['delete'];

//FIND IF NAVIGATION HAS CORRESPONDING CATEGORIES
        $catQuery = "SELECT * FROM categories";
        $getCategoryList = mysqli_query($connection, $catQuery);
        $executeDelete = True;
        while($row = mysqli_fetch_assoc($getCategoryList)){
            $catNavID = $row['navigationID'];
            if ($catNavID == $navID){
                $executeDelete = False;
            }
        }
        if ($executeDelete == True) {

//FIND navigationOrder OF NAVIGATION RECORD BEING DELETED
            $query = "SELECT navigationOrder FROM navigations WHERE navigationID = $navID";
            $selectNavOrder = mysqli_query($connection, $query);
            confirmQuery($selectNavOrder);

            while ($row = mysqli_fetch_assoc($selectNavOrder)) {

                $navOrder = $row['navigationOrder'];//navigationOrder of to-be-deleted navigation record
            }

            $orderQuery = "SELECT * FROM navigations ORDER BY navigationOrder";
            $selectNavigations = mysqli_query($connection, $orderQuery);

//CHANGE ORDER NUMBERS OF ALL NAVIGATIONS WITH A HIGHER navigationOrder
            while ($row = mysqli_fetch_assoc($selectNavigations)) {
                $navigationID = $row['navigationID'];
                $navigationOrder = $row['navigationOrder'];
                if ($navigationOrder > $navOrder) {
                    $navigationOrder--;
                    $updateNavOrderQuery = "UPDATE navigations SET navigationOrder=$navigationOrder WHERE navigationID = $navigationID";
                    $confirm = mysqli_query($connection, $updateNavOrderQuery);
                    confirmQuery($confirm);
                }
            }
            $query = "DELETE FROM navigations WHERE navigationID = {$navID} ";
            $delete_query = mysqli_query($connection, $query);
            confirmquery($delete_query);

            //Insert into changeLog table
            $navigationName = $_GET['name'];
            $userID = $_SESSION['userID'];
            $changedTable = "navigations";
            $changeDetails = "Deleted: {$navigationName}";
            insertChangeLog($userID, $changedTable, $changeDetails);

            mysqli_close($connection);

            ?>
            <script type="text/javascript">
                window.location = "index.php?view=navigations";   //Refreshes page
            </script>
            <?php
            //header("Location: index.php?display=navigations"); //Refreshes page
        } else {
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> This Navigation has Categories assigned it. Delete these, or assign them a new Navigation, before deleting.</div>';
        }
        }
}

function editVisibility() {
    global $connection;

    if(isset($_GET['setvisibleyes'])) {

        $navigationID = $_GET['setvisibleyes'];
        $query = "UPDATE navigations SET navigationVisible = '1' WHERE navigationID = {$navigationID} ";
        mysqli_query($connection, $query);

        $navigationName = htmlentities($_GET['name'], ENT_QUOTES, 'UTF-8');
        $changedTable = "navigations";
        $changeDetails = "Navigation &#039;" . $navigationName . "&#039; was set to visible.";

        //write results to changelog.
        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

        mysqli_close($connection);

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=navigations";   //Refreshes page
        </script>
        <?php
        //header("Location: index.php?display=navigations"); //Refreshes page
    }

    if(isset($_GET['setvisibleno'])) {

        $navigationID = $_GET['setvisibleno'];
        $query = "UPDATE navigations SET navigationVisible = '0' WHERE navigationID = {$navigationID} ";
        mysqli_query($connection, $query);

        $navigationName = htmlentities($_GET['name'], ENT_QUOTES, 'UTF-8');
        $changedTable = "navigations";
        $changeDetails = "Navigation &#039;" . $navigationName . "&#039; was set to not visible.";

        //write results to changelog.
        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=navigations";   //Refreshes page
        </script>
        <?php
        //header("Location: index.php?display=navigations"); //Refreshes page
    }
}

function updateNavigation($navigationID,$navigationOrder) {
    global $connection;
    if(isset($_POST['updatenavigation'])) {

//PULL NEW INFO FROM FORM TO REPLACE OLD DATA IN DATABASE
        $navigationName = mysqli_real_escape_string($connection, $_POST['navigationName']);
        $navigationURL = mysqli_real_escape_string($connection,$_POST['navURL']);
        $navigationLocation = $_POST['navigationLocation'];
        $navOrder = $_POST['navigationOrder'];
        $navButtonSize = $_POST['navButtonSize'];
        $navButtonColor = $_POST['navButtonColor'];
        $navJavaScript = $_POST['navJavaScript'];

        if ($navOrder == 1 && $navigationID != 1){ //Someone trying to make a navigation other than Home order 1
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Order 1 is reserved for Home, please select a different Navigation Order.</div>';
        } else {
//CHECK TO SEE IF ORDER CHANGED. IF SO RE-ORDER ALL NECESSARY NAVIGATIONS.
            if ($navOrder < $navigationOrder) {
                $query = "SELECT * FROM navigations WHERE navigationOrder >= {$navOrder} AND navigationID!={$navigationID} ORDER BY navigationOrder";
                $getOrder_query = mysqli_query($connection, $query);
                $tempNavOrder = $navOrder;

                while ($row = mysqli_fetch_assoc($getOrder_query)) {
                    $thisNavID = $row['navigationID'];
                    $thisNavOrder = $row['navigationOrder'];
                    if ($thisNavOrder == $tempNavOrder) {
                        $tempNavOrder += 1;
                        $query = "UPDATE navigations SET navigationOrder = $tempNavOrder WHERE navigationID = $thisNavID";
                        $orderUpdate_query = mysqli_query($connection, $query);
                        confirmQuery($orderUpdate_query);
                    }
                }
            }

            if ($navOrder > $navigationOrder) {
                $query = "SELECT * FROM navigations WHERE navigationOrder <= $navOrder AND navigationOrder >= $navigationOrder AND navigationID != $navigationID ORDER BY navigationOrder DESC";
                $getOrder_query = mysqli_query($connection, $query);
                $tempNavOrder = $navOrder;

                while ($row = mysqli_fetch_assoc($getOrder_query)) {
                    $thisNavID = $row['navigationID'];
                    $thisNavOrder = $row['navigationOrder'];
                    if ($thisNavOrder == $tempNavOrder) {
                        $tempNavOrder -= 1;
                        $query = "UPDATE navigations SET navigationOrder = $tempNavOrder WHERE navigationID= $thisNavID";
                        $update_query = mysqli_query($connection, $query);
                        confirmQuery($update_query);
                    }
                }
            }
//END OF RE-ORDERING

            if ($navigationID == 1) {
                $query = "UPDATE navigations SET navigationName = '{$navigationName}',  ";
                $query .= "navigationLocation = '{$navigationLocation}', navButtonSize = '{$navButtonSize}', ";
                $query .= "navButtonColor = '{$navButtonColor}' WHERE navigationID = '{$navigationID}' ";

                $update_query = mysqli_query($connection, $query);

                confirmQuery($update_query);
            } else {
                $query = "UPDATE navigations SET navigationName = '{$navigationName}', navigationURL = '{$navigationURL}', ";
                $query .= "navigationLocation = '{$navigationLocation}', navigationOrder = '{$navOrder}', ";
                $query .= "navButtonSize = '{$navButtonSize}', ";
                $query .= "navButtonColor = '{$navButtonColor}', ";
                $query .= "navJavaScript = '{$navJavaScript}' WHERE navigationID = '{$navigationID}' ";

                $update_query = mysqli_query($connection, $query);

                confirmQuery($update_query);
            }

            $changedTable = "navigations";
            $changeDetails = "Navigation &#039;" . $navigationName . "&#039; was edited";

            insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

            mysqli_close($connection);

            ?>
            <script type="text/javascript">
                window.location = "index.php?view=navigations";   //Refreshes page
                window.alert("Navigation updated successfully.");
            </script>

            <?php
        }
        //header("Location: index.php?view=navigations"); //Does not redirect page for some reason.
    }
}

?>