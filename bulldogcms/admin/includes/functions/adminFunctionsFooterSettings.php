<?php

//function that updates the FooterSetting.
function updateFooterSetting($footerLogoImg) {

    global $connection;

    $footerTitle = mysqli_real_escape_string($connection, $_POST['footerTitle']);
    $footerHeight = $_POST['footerHeight'];
    $footerTextArea1 = mysqli_real_escape_string($connection, $_POST['footerTextArea1']);
//    $footerTextArea2 = mysqli_real_escape_string($connection, $_POST['footerTextArea2']);
    $footerLogoDBImg = $_POST['footerLogoImg']; //Existing file in Database.

    //If a new image is uploaded, set new file name
    if (!empty($footerLogoDBImg)) {
        $footerLogoImg = $footerLogoDBImg;

        //Check if image name already exists. If so, append an incremented number.
        $imageNameInvalid = true;
        $incrementNumber = 1;
        $tempLogoImage = $footerLogoImg;
        while ($imageNameInvalid) {
            $logoQuery = "SELECT * FROM footerLayout WHERE footerLogoImg ='{$tempLogoImage}'";
            $queryResult = mysqli_query($connection, $logoQuery);

            if ($queryResult && mysqli_num_rows($queryResult)>0) {
                $tempArray = explode(".", $footerLogoImg);
                $tempLogoImage = $tempArray[0] . "_" . $incrementNumber . "." . $tempArray[1];
                $incrementNumber += 1;
            }
            else {
                $footerLogoImg = $tempLogoImage;
                $imageNameInvalid = false;
            }
        }
    }

    //Validation checking.
    if (strlen($footerTitle) > 50)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;Please make sure the Footer Title entry is under 50 characters.</div>';
    else if ($footerHeight < 100)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;Please enter a value at or above 100 pixels.</div>';
    else if ($footerHeight > 300)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;Please enter a value at or under 300 pixels.</div>';
    else if (strlen($footerTextArea1) > 200)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;Please make sure the Footer TextArea 1 entry is under 200 characters.</div>';
//    else if (strlen($footerTextArea2) > 200)
//        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;Please make sure the Footer TextArea 2 entry is under 200 characters.</div>';
    else {
        $query = "UPDATE footerLayout
            SET footerTitle = '{$footerTitle}',
            footerLogoImg = '{$footerLogoImg}',
            footerHeight = '{$footerHeight}',
            footerTextArea1 = '{$footerTextArea1}'
            WHERE footerID = '1'";

        $updateQuery = mysqli_query($connection, $query);
        confirmQuery($updateQuery);

        //Insert into Changelog table, then safely close the db connection.
        $userID = $_SESSION['userID'];
        $changedTable = "footerLayout";
        $changeDetails = "Updated Footer Layout Settings";
        insertChangeLog($userID, $changedTable, $changeDetails);

        mysqli_close($connection);

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=footersettings";   //Refreshes page
            window.alert("Footer Settings updated successfully.");
        </script>
        <?php
    }
}

?>