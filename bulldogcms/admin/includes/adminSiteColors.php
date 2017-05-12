<h1 class="page-header">
    Site Colors
</h1>

<!--Add Category Form-->
<div class ="col-xs-12">
    <form action ="" method="post">
        <div class="form-group">
            <table class = "table table-hover" id="color-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                <?php

                $settingsQuery = "SELECT * FROM themeColors WHERE themeColorID = '1' ";
                $selectSettings = mysqli_query($connection,$settingsQuery);

                confirmQuery($selectSettings);

                while($row = mysqli_fetch_assoc($selectSettings))
                {
                    $headerBackground      = $row['headerBackground'];
                    $footerBackground       = $row['footerBackground'];
                    $asideBackground       = $row['asideBackground'];
                    $masterBackground       = $row['masterBackground'];
                    $buttonBackground       = $row['buttonBackground'];
                    $buttonHover      = $row['buttonHover'];
                    $buttonFont       = $row['buttonFont'];
                    $linkFont       = $row['linkFont'];
                    $linkHover       = $row['linkHover'];
                    $masterFont      = $row['masterFont'];
                    $asideFont      = $row['asideFont'];
                    $headerTitleFont       = $row['headerTitleFont'];
                    $headerFont      = $row['headerFont'];
                    $footerTitleFont       = $row['footerTitleFont'];
                    $footerFont      = $row['footerFont'];
                    $asideFont       = $row['asideFont'];
                    $heroicFont       = $row['heroicFont'];
                    $pageHeading       = $row['pageHeading'];
                    $dividingLines      = $row['dividingLines'];

                    echo "<tr>";
                    echo "<td>Header Background</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($headerBackground)) {echo $headerBackground;} ?>" type = "text"  name="headerBackground"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Footer Background</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($footerBackground)) {echo $footerBackground;} ?>" type = "text" name="footerBackground"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Aside Background</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($asideBackground)) {echo $asideBackground;} ?>" type = "text" class = "form-control" name="asideBackground"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Master Site Background</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($masterBackground)) {echo $masterBackground;} ?>" type = "text" class = "form-control" name="masterBackground"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Button Background</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($buttonBackground)) {echo $buttonBackground;} ?>" type = "text" class = "form-control" name="buttonBackground"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Button Hover</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($buttonHover)) {echo $buttonHover;} ?>" type = "text" class = "form-control" name="buttonHover"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Button Font</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($buttonFont)) {echo $buttonFont;} ?>" type = "text" class = "form-control" name="buttonFont"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Link Font</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($linkFont)) {echo $linkFont;} ?>" type = "text" class = "form-control" name="linkFont"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Link Hover</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($linkHover)) {echo $linkHover;} ?>" type = "text" class = "form-control" name="linkHover"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Master Site Font</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($masterFont)) {echo $masterFont;} ?>" type = "text" class = "form-control" name="masterFont"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Aside Font</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($masterFont)) {echo $masterFont;} ?>" type = "text" class = "form-control" name="asideFont"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Header Title Font</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($headerTitleFont)) {echo $headerTitleFont;} ?>" type = "text" class = "form-control" name="headerTitleFont"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Header Font</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($headerFont)) {echo $headerFont;} ?>" type = "text" class = "form-control" name="headerFont"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Footer Title Font</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($footerTitleFont)) {echo $footerTitleFont;} ?>" type = "text" class = "form-control" name="footerTitleFont"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Footer Font</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($footerFont)) {echo $footerFont;} ?>" type = "text" class = "form-control" name="footerFont"></td>
                    <?php
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td>Heroic Font</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($heroicFont)) {echo $heroicFont;} ?>" type = "text" class = "form-control" name="heroicFont"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Page Heading Color</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($pageHeading)) {echo $pageHeading;} ?>" type = "text" class = "form-control" name="pageHeading"></td>
                    <?php
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Dividing Line Color</td>";
                    ?>
                    <td><input class="jscolor form-control" value = "<?php if(isset($dividingLines)) {echo $dividingLines;} ?>" type = "text" class = "form-control" name="dividingLines"></td>
                    <?php
                    echo "</tr>";
                }
                ?>
                <?php
                if(isset($_POST['updatesettings'])) {
                    $headerBackground = mysqli_real_escape_string($connection, $_POST['headerBackground']);
                    $footerBackground = mysqli_real_escape_string($connection, $_POST['footerBackground']);
                    $asideBackground  = mysqli_real_escape_string($connection, $_POST['asideBackground']);
                    $masterBackground  = mysqli_real_escape_string($connection, $_POST['masterBackground']);
                    $buttonBackground      = mysqli_real_escape_string($connection, $_POST['buttonBackground']);
                    $buttonHover      = mysqli_real_escape_string($connection, $_POST['buttonHover']);
                    $buttonFont       = mysqli_real_escape_string($connection, $_POST['buttonFont']);
                    $linkFont       = mysqli_real_escape_string($connection, $_POST['linkFont']);
                    $linkHover       = mysqli_real_escape_string($connection, $_POST['linkHover']);
                    $masterFont      = mysqli_real_escape_string($connection, $_POST['masterFont']);
                    $headerTitleFont       = mysqli_real_escape_string($connection, $_POST['headerTitleFont']);
                    $headerFont      = mysqli_real_escape_string($connection, $_POST['headerFont']);
                    $footerTitleFont       = mysqli_real_escape_string($connection, $_POST['footerTitleFont']);
                    $footerFont      = mysqli_real_escape_string($connection, $_POST['footerFont']);
                    $asideFont       = mysqli_real_escape_string($connection, $_POST['asideFont']);
                    $heroicFont      = mysqli_real_escape_string($connection, $_POST['heroicFont']);
                    $pageHeading       = mysqli_real_escape_string($connection, $_POST['pageHeading']);
                    $dividingLines       = mysqli_real_escape_string($connection, $_POST['dividingLines']);
                    $asideFont      = mysqli_real_escape_string($connection, $_POST['asideFont']);

                    //Need to check if any fields blank and post error before actually doing Update
                    $query = "UPDATE themeColors SET headerBackground = '{$headerBackground}', footerBackground = '{$footerBackground}', asideBackground = '{$asideBackground}', masterBackground = '{$masterBackground}', ";
                    $query .= "buttonBackground = '{$buttonBackground}', buttonHover = '{$buttonHover}', buttonFont = '{$buttonFont}', linkFont = '{$linkFont}', linkHover = '{$linkHover}', masterFont = '{$masterFont}', ";
                    $query .= "headerTitleFont = '{$headerTitleFont}', headerFont = '{$headerFont}', footerTitleFont = '{$footerTitleFont}', footerFont = '{$footerFont}', asideFont = '{$asideFont}', ";
                    $query .= "heroicFont = '{$heroicFont}',pageHeading = '{$pageHeading}', dividingLines = '{$dividingLines}' ";
                    $query .= "WHERE themeColorID = '1'";
                    $updateQuery = mysqli_query($connection, $query);

                    confirmQuery($updateQuery);

                    $changedTable = "themeColors";
                    $changeDetails = "Site color scheme was updated.";

                    insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

                    mysqli_close($connection);

                    ?>
                    <script type="text/javascript">
                        window.location = "index.php?view=sitecolors";   //Refreshes page
                        window.alert("Site Colors updated successfully.");
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