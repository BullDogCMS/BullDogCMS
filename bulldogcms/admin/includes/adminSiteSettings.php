<h1 class="page-header">
    Site Settings
</h1>
<div class="col-xs-12">

    <form action ="" method="post">
        <div class="form-group">
        <table class = "table table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Value</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <?php //This is pulling in the site settings global variables from headerbegin.php and setting them to variables for use here. -Micah

        $siteSettingsQuery = "SELECT * FROM siteSettings WHERE siteSettingID = '1'";
        $selectSiteSettings = mysqli_query($connection, $siteSettingsQuery);
        while($row = mysqli_fetch_assoc($selectSiteSettings)) {
            $siteName = $row['siteName'];
            $siteEmail = $row['siteEmail'];
            $siteSearch = $row['siteSearch'];
            $articleSubmission = $row['articleSubmission'];
            $enableLinks = $row['enableLinks'];
            $enableLatestArticles = $row['enableLatestArticles'];
            $enableEvents = $row['enableEvents'];
            $enableNews = $row['enableNews'];
            $enableSideWidget = $row['enableSideWidget'];
            $enableAuthorNames = $row['enableAuthorNames'];
            $googleAnalyticsID = $row['googleAnalyticsID'];
            $gaClientID = $row['gaClientID'];
            $gaViewID = $row['gaViewID'];
            $paginationLength = $row['paginationLength'];
            $enableAuthorNames = $row['enableAuthorNames'];
            $enableFullName = $row['enableFullName'];

        }

        //This code is populating a table started above the php with the site settings from the database. -Micah
            echo "<tr>";
            echo "<td>Site Title</td>";
        ?>
            <td><input value = "<?php if(isset($siteName)) {echo $siteName;} ?>" type = "text" class = "form-control" name="siteName" required></td>
        <?php
            echo "<td>This is the site's title. It will be what appears in the browser tab, the title of bookmarks to your site, and shown in search-engine results.</td>";
            echo "</tr>";
            echo "<tr>";
        echo "<td>Site Email</td>";
        ?>

        <td><input value = "<?php if(isset($siteEmail)) {echo $siteEmail;} ?>" type = "email" class = "form-control" name="siteEmail" required></td>
        <?php
        echo "<td>This is the email notifications will be sent from.</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Google Analytics Website ID</td>";
        ?>

        <td><input value = "<?php if(isset($googleAnalyticsID)) {echo $googleAnalyticsID;} ?>" type = "text" class = "form-control" name="googleAnalyticsID"></td>
        <?php
        echo "<td>Your Google Analytics website ID.</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Google Analytics Client ID</td>";
        ?>
        <td><input value = "<?php if(isset($gaClientID)) {echo $gaClientID;} ?>" type = "text" class = "form-control" name="gaClientID"></td>
        <?php
        echo "<td>The OAUTH2 Web Client ID created in the Google API Manager that has access to your website</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Google Analytics View ID</td>";
        ?>
        <td><input value = "<?php if(isset($gaViewID)) {echo $gaViewID;} ?>" type = "text" class = "form-control" name="gaViewID"></td>
        <?php
        echo "<td>The Google Analytic site's View ID for your website found in Google Analytics site's properties</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Enable Article Submission Process</td>";
        ?>
            <td><input type="radio" name="articleSubmission"
                    <?php if (isset($articleSubmission) && $articleSubmission=="1") echo "checked";?>
                    value="1">Yes
                <input type="radio" name="articleSubmission"
                    <?php if (isset($articleSubmission) && $articleSubmission=="0") echo "checked";?>
                    value="0">No
            </td>
        <?php
            echo "<td>This enables required review and approval of Contributor generated content by an Administrator before being published to the site and visible to the public.</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Enable Site Search</td>";
        ?>
            <td><input type="radio" name="siteSearch"
                    <?php if (isset($siteSearch) && $siteSearch=="1") echo "checked";?>
                       value="1">Yes
                <input type="radio" name="siteSearch"
                    <?php if (isset($siteSearch) && $siteSearch=="0") echo "checked";?>
                       value="0">No
            </td>
            <?php
            echo "<td>This enables the Search box on your site allowing your users to search for articles based on their tags.</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Enable Aside Section</td>";
            ?>
            <td><input type="radio" name="enableSideWidget"
                    <?php if (isset($enableSideWidget) && $enableSideWidget=="1") echo "checked";?>
                       value="1">Yes
                <input type="radio" name="enableSideWidget"
                    <?php if (isset($enableSideWidget) && $enableSideWidget=="0") echo "checked";?>
                       value="0">No
            </td>
            <?php
            echo "<td>This enables an additional section in the side panel where you can post additional content to be shown on all pages.</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Enable Latest Articles</td>";
            ?>
            <td><input type="radio" name="enableLatestArticles"
                <?php if (isset($enableLatestArticles) && $enableLatestArticles=="1") echo "checked";?>
                   value="1">Yes
            <input type="radio" name="enableLatestArticles"
                <?php if (isset($enableLatestArticles) && $enableLatestArticles=="0") echo "checked";?>
                   value="0">No
            </td>
            <?php
            echo "<td>This enables the Latest Articles section</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Enable Aside Events</td>";
            ?>
            <td><input type="radio" name="enableEvents"
                <?php if (isset($enableEvents) && $enableEvents=="1") echo "checked";?>
                   value="1">Yes
            <input type="radio" name="enableEvents"
                <?php if (isset($enableEvents) && $enableEvents=="0") echo "checked";?>
                   value="0">No
            </td>
            <?php
            echo "<td>This enables the Events section in the side panel.  Events are created under Categories.</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Enable News</td>";
            ?>
            <td><input type="radio" name="enableNews"
                <?php if (isset($enableNews) && $enableNews=="1") echo "checked";?>
                   value="1">Yes
            <input type="radio" name="enableNews"
                <?php if (isset($enableNews) && $enableNews=="0") echo "checked";?>
                   value="0">No
            </td>
            <?php
            echo "<td>This enables the News section in the side panel where you can provide your user with links to other sites and external resources.</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Enable Aside Links</td>";
            ?>
            <td><input type="radio" name="enableLinks"
                    <?php if (isset($enableLinks) && $enableLinks=="1") echo "checked";?>
                    value="1">Yes
                <input type="radio" name="enableLinks"
                    <?php if (isset($enableLinks) && $enableLinks=="0") echo "checked";?>
                    value="0">No
            </td>
            <?php
            echo "<td>This enables the Links section in the side panel where you can provide your user with links to other sites and external resources.</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Enable Author Names</td>";
            ?>
            <td><input type="radio" name="enableAuthorNames"
                    <?php if (isset($enableAuthorNames) && $enableAuthorNames=="1") echo "checked";?>
                       value="1">Yes
                <input type="radio" name="enableAuthorNames"
                    <?php if (isset($enableAuthorNames) && $enableAuthorNames=="0") echo "checked";?>
                       value="0">No
            </td>
            <?php
            echo "<td>This enables to show Author Names on the Articles</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Enable Full Name</td>";
            ?>
            <td><input type="radio" name="enableFullName"
                    <?php if (isset($enableFullName) && $enableFullName=="1") echo "checked";?>
                       value="1">Yes
                <input type="radio" name="enableFullName"
                    <?php if (isset($enableFullName) && $enableFullName=="0") echo "checked";?>
                       value="0">No
            </td>
        <?php
            echo "<td>This shows author's full name if Yes, it shows author's Username if No</td>";
            echo "</tr>";
//          Pagination Length:
            echo "<tr>";
            echo "<td>Items Per Page</td>";
            ?>
            <td><input value = "<?php if(isset($paginationLength)) {echo $paginationLength;} ?>" type = "number" class = "form-control" name="paginationLength" min="1" required></td>
            <?php
            echo "<td>This value controls pagination by limiting the number of results displayed per page.</td>";
            echo "</tr>";
            ?>
        <?php   //This is setting up the update button with any changes to the site settings in the forms -Micah
                //The variables are being changed to match what is in the form. -Micah
        if(isset($_POST['updatesettings'])) {
            $siteName = htmlentities($_POST['siteName'], ENT_QUOTES, 'UTF-8');
            $siteEmail = htmlentities($_POST['siteEmail'], ENT_QUOTES, 'UTF-8');
            $siteSearch = $_POST['siteSearch'];
            $articleSubmission = $_POST['articleSubmission'];
            $enableLinks =        $_POST['enableLinks'];
            $enableLatestArticles =        $_POST['enableLatestArticles'];
            $enableEvents =        $_POST['enableEvents'];
            $enableNews =        $_POST['enableNews'];
            $enableSideWidget =   $_POST['enableSideWidget'];
            $enableAuthorNames =   $_POST['enableAuthorNames'];
            $googleAnalyticsID =   htmlentities($_POST['googleAnalyticsID'], ENT_QUOTES, 'UTF-8');
            $gaClientID =   htmlentities($_POST['gaClientID'], ENT_QUOTES, 'UTF-8');
            $gaViewID =   htmlentities($_POST['gaViewID'], ENT_QUOTES, 'UTF-8');
            $paginationLength = $_POST['paginationLength'];
            $enableFullName =   $_POST['enableFullName'];

            //This is the actual update query -Micah
            //Need to check if any fields blank and post error before actually doing Update
            //This will be the prepared statment for the update query for site settings.
                $siteSettingsPrepStmt = mysqli_stmt_init($connection);

                //This is the creation, execution, and closing of the prepared statment sql query.
                IF (mysqli_stmt_prepare($siteSettingsPrepStmt,
                    "UPDATE siteSettings SET siteName =?, siteEmail =?, siteSearch = '{$siteSearch}',
                      articleSubmission = '{$articleSubmission}', enableLinks = '{$enableLinks}', enableLatestArticles = '{$enableLatestArticles}', enableEvents = '{$enableEvents}', enableNews = '{$enableNews}', enableSideWidget = '{$enableSideWidget}'
                      , enableAuthorNames = '{$enableAuthorNames}', googleAnalyticsID =?, gaClientID =?, gaViewID =?, paginationLength = ?, enableFullName = '{$enableFullName}'
                      WHERE siteSettingID = '1'")) {
                    mysqli_stmt_bind_param($siteSettingsPrepStmt, "sssssi", $siteName, $siteEmail, $googleAnalyticsID, $gaClientID, $gaViewID, $paginationLength);

                    mysqli_stmt_execute($siteSettingsPrepStmt);

                    mysqli_stmt_bind_result($siteSettingsPrepStmt, $updateQuery);

                    mysqli_stmt_fetch($siteSettingsPrepStmt);

                    confirmQuery(mysqli_stmt_errno($siteSettingsPrepStmt));

                    mysqli_stmt_close($siteSettingsPrepStmt);

                }

                //Insert into Changelog table, then safely close the db connection.
                $userID = $_SESSION['userID'];
                $changedTable = "siteSettings";
                $changeDetails = "Updated Site Settings";
                insertChangeLog($userID, $changedTable, $changeDetails);

                mysqli_close($connection);

                /*$query = "UPDATE siteSettings SET siteName = '{$siteName}', siteEmail = '{$siteEmail}', siteSearch = '{$siteSearch}',
                          articleSubmission = '{$articleSubmission}', enableLinks = '{$enableLinks}', enableSideWidget = '{$enableSideWidget}'
                          , enableAuthorNames = '{$enableAuthorNames}', googleAnalyticsID = '{$googleAnalyticsID}'
                          WHERE siteSettingID = '1'";
                $updateQuery = mysqli_query($connection, $query);

                confirmQuery($updateQuery);
                */
                ?>
                <script type="text/javascript">
                    window.location = "index.php?view=sitesettings";   //Refreshes page
                    window.alert("Site Settings updated successfully.");
                </script>
                <?php
        }
        ?>

        </tbody>
        </table>
        </div>
        <div class="form-group">
            <input class = "btn btn-primary" type="submit" name="updatesettings" value="Update Settings" data-toggle="tooltip" title="Update Settings">
        </div>
    </form>
</div>