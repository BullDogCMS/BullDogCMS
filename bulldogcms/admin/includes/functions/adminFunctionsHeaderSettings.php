<?php

//function that updates the HeaderSetting.
function updateHeaderSetting($headerLogoImg) {

    global $connection;

    $headerTitle = mysqli_real_escape_string($connection, $_POST['headerTitle']);
    $headerHeight = $_POST['headerHeight'];
    $headerHTML = mysqli_real_escape_string($connection, $_POST['headerHTML']);
    $headerTextArea1 = mysqli_real_escape_string($connection, $_POST['headerTextArea1']);
    $headerLogoDBImg = $_POST['headerLogoImg']; //Existing file in Database.

    //If a new image is uploaded, set new file name
    if (!empty($headerLogoDBImg)) {
        $headerLogoImg = $headerLogoDBImg;

        //Check if image name already exists. If so, append an incremented number.
        $imageNameInvalid = true;
        $incrementNumber = 1;
        $tempLogoImage = $headerLogoImg;
        while ($imageNameInvalid) {
            $logoQuery = "SELECT * FROM headerLayout WHERE headerLogoImg ='{$tempLogoImage}'";
            $queryResult = mysqli_query($connection, $logoQuery);

            if ($queryResult && mysqli_num_rows($queryResult)>0) {
                $tempArray = explode(".", $headerLogoImg);
                $tempLogoImage = $tempArray[0] . "_" . $incrementNumber . "." . $tempArray[1];
                $incrementNumber += 1;
            }
            else {
                $headerLogoImg = $tempLogoImage;
                $imageNameInvalid = false;
            }
        }
    }

    //Set the floatHeader value.
    if (isset($_POST['floatHeader']))
        $floatHeader = 1;
    else
        $floatHeader = 0;

    //Validation checking
    if (strlen($headerTitle) > 50)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;Please make sure the Header Title entry is under 50 characters.</div>';
    else if ($headerHeight < 100)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;Please enter a value at or above 100 pixels.</div>';
    else if ($headerHeight > 300)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;Please enter a value at or under 300 pixels.</div>';
    else if (strlen($headerHTML) > 200)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;Please make sure the Header HTML entry is under 200 characters.</div>';
    else if (strlen($headerTextArea1) > 200)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;Please make sure the Header TextArea 1 entry is under 200 characters.</div>';
    else {
        //TO-DO: Validation checking.
        $query = "UPDATE headerLayout 
              SET headerTitle = '{$headerTitle}', 
              headerHeight = '{$headerHeight}', 
              headerHTML = '{$headerHTML}',
              headerLogoImg = '{$headerLogoImg}',
              floatHeader = '{$floatHeader}', 
              headerTextArea1 = '{$headerTextArea1}' 
              WHERE headerID = '1'";

        $updateQuery = mysqli_query($connection, $query);
        confirmQuery($updateQuery);

        //Insert into Changelog table, then safely close the db connection.
        $userID = $_SESSION['userID'];
        $changedTable = "headerLayout";
        $changeDetails = "Updated Header Layout Settings";
        insertChangeLog($userID, $changedTable, $changeDetails);

        mysqli_close($connection);

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=headersettings";   //Refreshes page
            window.alert("Header Settings updated successfully.");
        </script>
        <?php
    }
}

?>