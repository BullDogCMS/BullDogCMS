<h1 class="page-header">
    Header Settings
</h1>

<div class ="col-xs-12">

    <form action ="" method="post" enctype="multipart/form-data">
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

                <?php

                $headerQuery = "SELECT * FROM headerLayout WHERE headerID = '1'";
                $selectHeader = mysqli_query($connection,$headerQuery);

                confirmQuery($selectHeader);

                while($row = mysqli_fetch_assoc($selectHeader))
                {
                    $headerTitle = $row['headerTitle'];
                    $headerLogoImg = $row['headerLogoImg'];
                    $headerHeight = $row['headerHeight'];
                    $headerHTML = $row['headerHTML'];
                    $floatHeader = $row['floatHeader'];
                    $headerTextArea1 = $row['headerTextArea1'];

                    if (isset($_POST['imageRemove']) == 'remove') {
                        $headerLogoImg = "";
                    }

                    echo "<tr>";
                    echo "<td>Header Logo Image</td>";
                    ?>
                    <td>
                        <p>Current Image:</p>
                        <?php
                        echo "<img width='100' src='../uploads/{$headerLogoImg}'>";
                        ?>
                        <br><br><p>Select New Image:</p>
                        <input class="form-control" id="headerLogoImg" type="text" name="headerLogoImg">
                        <a href="filemanager/dialog.php?type=1&field_id=headerLogoImg&relative_url=1&fldr=images" class="btn btn-filemanager btn iframe-btn" type="button" data-toggle="tooltip" title="Choose image">Choose image</a>
                       <!-- <input class="filestyle" type="file" name="headerLogoImg" id="headLogoImg" accept="image/*"> -->
                        <div>
                            <input type="checkbox" name="imageRemove" value="remove"> Remove Image?<br>
                        </div>

                    </td>
                    <?php
                    echo "<td>Logo Image displayed in the Header. Recommended: Image height equal to the Header height at 72ppi.</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Header Title</td>";
                    ?>
                    <td><input value="<?php if(isset($headerTitle)) {echo htmlentities($headerTitle, ENT_QUOTES, 'UTF-8');} ?>" type="text" class="form-control" name="headerTitle"></td>
                    <?php
                    echo "<td>Site title to be displayed in the header if not using a logo image or the logo image doesn't include the title. (Maximum of 50 characters)</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Header Height (pixels)</td>";
                    ?>
                    <td><input value="<?php if(isset($headerHeight)) {echo $headerHeight;} ?>" type="number" class="form-control" name="headerHeight"></td>
                    <?php
                    echo "<td>Header Height, in pixels. (Default 100px)</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Floating Header</td>";
                    ?>
                    <td>
                        <?php if ($floatHeader == 1)
                           echo "<input type='checkbox' name='floatHeader' checked>";
                        else
                            echo "<input type='checkbox' name='floatHeader'>"; ?>
                    </td>
                    <?php
                    echo "<td>Enables a floating or 'sticky' header that remains at the top of the page</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Header Left Side HTML Text</td>";
                    ?>
                    <td><input value="<?php if(isset($headerHTML)) {echo htmlentities($headerHTML, ENT_QUOTES, 'UTF-8');} ?>" type="text" class="form-control" name="headerHTML"></td>
                    <?php
                    echo "<td>Text to be displayed in the left side of the Header section. (Maximum of 200 characters)*</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Header Right Side HTML Text</td>";
                    ?>
                    <td><input value="<?php if(isset($headerTextArea1)) {echo htmlentities($headerTextArea1, ENT_QUOTES, 'UTF-8');} ?>" type="text" class="form-control" name="headerTextArea1"></td>
                    <?php
                    echo "<td>Additional text to be displayed in the right side of the Header section. (Maximum of 200 characters)*</td>";
                    echo "</tr>";
                    echo "<td colspan='3'><i>*Note: These fields will only show if the Header Height is at or over 200 pixels.</i></td>";
                }
                ?>

                <?php
                if(isset($_POST['updateheader'])) {
                    //Function found in adminFunctionsHeaderSettings.php
                    updateHeaderSetting($headerLogoImg);
                }
                ?>

                </tbody>
            </table>
        </div>
        <div class="form-group">
            <input class = "btn btn-primary" type="submit" name="updateheader" value="Update Header" data-toggle="tooltip" title="Update Header">
        </div>
    </form>
</div>