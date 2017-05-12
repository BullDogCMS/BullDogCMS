<h1 class="page-header">
    Footer Settings
</h1>

<div class ="col-xs-12">

    <form action ="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <table class = "table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>

                <?php

                $footerQuery = "SELECT * FROM footerLayout WHERE footerID = '1'";
                $selectFooter = mysqli_query($connection, $footerQuery);

                confirmQuery($selectFooter);

                while($row = mysqli_fetch_assoc($selectFooter)) {
                    $footerTitle = $row['footerTitle'];
                    $footerLogoImg = $row['footerLogoImg'];
                    $footerHeight = $row['footerHeight'];
                    $footerTextArea1 = $row['footerTextArea1'];
                    $footerTextArea2 = $row['footerTextArea2'];

                    if (isset($_POST['imageRemove']) == 'remove') {
                        $footerLogoImg = "";
                    }

                    echo "<tr>";
                    echo "<td>Footer Logo Image</td>";
                    ?>
                    <td>
                        <p>Current Image:</p>
                        <?php
                        echo "<img width='100' src='../uploads/{$footerLogoImg}'>";
                        ?>
                        <br><br><p>Select New Image:</p>
                        <input class="form-control" id="footerLogoImg" type="text" name="footerLogoImg">
                        <a href="filemanager/dialog.php?type=1&field_id=footerLogoImg&relative_url=1&fldr=images" class="btn btn-filemanager btn iframe-btn" type="button" data-toggle="tooltip" title="Choose image">Choose image</a>
                        <div>
                            <input type="checkbox" name="imageRemove" value="remove"> Remove Image?<br>
                        </div>

                    </td>
                    <?php
                    echo "<td>Logo Image displayed in the Footer. Recommended: Image height equal to the Footer height at 72ppi.</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Footer Title</td>";
                    ?>
                    <td><input value="<?php if(isset($footerTitle)) {echo htmlentities($footerTitle, ENT_QUOTES, 'UTF-8');} ?>" type="text" class="form-control" name="footerTitle"></td>
                    <?php
                    echo "<td>Site title to be displayed in the footer if not using a logo image or the logo image doesn't include the title. (Maximum of 50 characters)</td>";
                    echo "</tr>";
                    echo "<td>Footer Height (pixels)</td>";
                    ?>
                    <td><input value="<?php if(isset($footerHeight)) {echo $footerHeight;} ?>" type="number" class="form-control" name="footerHeight"></td>
                    <?php
                    echo "<td>Footer Height, in pixels. (Default 100px)</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Footer Text Area</td>";
                    ?>
                    <td><input value="<?php if(isset($footerTextArea1)) {echo htmlentities($footerTextArea1, ENT_QUOTES, 'UTF-8');} ?>" type="text" class="form-control" name="footerTextArea1"></td>
                    <?php
                    echo "<td>Text to be displayed in the Footer section. Maximum of 200 characters.</td>";
                    echo "</tr>";
                }
                ?>

                <?php
                if(isset($_POST['updatefooter'])) {
                    //Function found in adminFunctionsFooterSettings.php
                    updateFooterSetting($footerLogoImg);

                }
                ?>

                </tbody>
            </table>
        </div>
        <div class="form-group">
            <input class ="btn btn-primary" type="submit" name="updatefooter" value="Update Footer" data-toggle="tooltip" title="Update Footer">
        </div>
    </form>
</div>