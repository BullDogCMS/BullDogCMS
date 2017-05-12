<!--This module controls Navigations Update operations -->
<!--It is shown on the navigations.php when Edit option is used -->

<h1 class="page-header">
    Navigation Edit
</h1>

<div class="col-xs-12">

<form action ="" method="post">

<div class="form-group">
        <?php
        if(isset($_GET['edit'])) {
            $navigationID = $_GET['edit'];
            $query = "SELECT * FROM navigations WHERE navigationID = $navigationID";
            $navID = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($navID)) {
                $navigationID = $row['navigationID'];
                $navigationName = $row['navigationName'];
                $navigationURL = $row['navigationURL'];
                $navigationLocation = $row['navigationLocation'];
                $navigationOrder = $row['navigationOrder'];
                $navButtonColor = $row['navButtonColor'];
                $navButtonSize = $row['navButtonSize'];
                $navigationVisible = $row['navigationVisible'];
                $navJavaScript = $row['navJavaScript'];

                //Check for single or double quotes in name or url link using name
                $navigationName = htmlentities($navigationName, ENT_QUOTES, 'UTF-8');
                ?>

                <div class="form-group col-xs-12 col-md-6">
                    <label for="navName">Title</label>
                    <input value="<?php if (isset($navigationName)) {
                        //echo htmlentities($navigationName, ENT_QUOTES, 'UTF-8');
                        echo $navigationName;
                    } ?>" type="text" class="form-control" name="navigationName"  onchange="copyNavName(this.form)" autofocus required onfocus="this.select();">
                </div>

                <?php if ($navigationID != 1) { ?>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="navURL">URL</label>

                        <?php
                            echo "<select class='form-control' name='navURL' id='navURL'  onchange='showOtherURLField(this.options[this.selectedIndex].value)'>";
                            if ($navigationURL == "#") {
                                echo "<option value='#' selected='true'>None or JavaScript</option>";
                            } else {
                                echo "<option value='#'>None or JavaScript</option>";
                            }
                            if ($navigationURL == "index.php?view=indexcategories") {
                                echo "<option value='index.php?view=indexcategories' selected='true'>Home Categories</option>";
                            } else {
                                echo "<option value='index.php?view=indexcategories'>Home Categories</option>";
                            }
                            if ($navigationURL == "index.php?view=articlelist") {
                                echo "<option value='index.php?view=articlelist' selected='true'>Article List</option>";
                            } else {
                                echo "<option value='index.php?view=articlelist'>Article List</option>";
                            }

                            if (substr($navigationURL, 0, 35) == "index.php?view=catbynavname&navname") {
                                echo "<option value='index.php?view=catbynavname&navname=$navigationName' selected='true'> $navigationName 's Categories</option>";
                            }

                            $specialPages = "SELECT * FROM articles a JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID WHERE a.categoryID = '1' AND at.articlePending <> '2' ";
                            $specialPagesQuery = mysqli_query($connection, $specialPages);
                            confirmQuery($specialPagesQuery);

                            //Outputs query results into 'option' control element (Dropdown list).
                            while ($row = mysqli_fetch_assoc($specialPagesQuery)) {
                                echo "<option value=index.php?view=specialpage&articleID=" . $row['articleID'] . ">" . $row['articleTitle'] . "</option>";
                            }
                            if (substr($navigationURL, 0, 26) == "index.php?view=specialpage") {
                                echo "<option value='$navigationURL' selected='true'>$navigationName Special Page</option>";
                            }
                            //Still an Other URL bug when Editing.  It keeps URL if changing to different option.
                            if (substr($navigationURL, 0, 4) == "http") {
                                echo "<option value='otherURL' selected='true'>Other URL</option>";
                                ?>
                                <input value="<?php if (isset($navigationURL)) {
                                    echo $navigationURL;
                                    } ?>" type="url" class="form-control" name="navURL" id="navURLOld">
                                <?php
                            } else {
                                echo "<option value='otherURL'>Other</option>";
                            }
                        }
                            ?>
                        </select>
                </div>

<!--Other URL text input-->
                <div id="otherURLDiv"></div>
                <!--<div class="form-group col-xs-12 col-md-6" id="otherURLDiv" style="display: none;"></div>-->

<!--Order Drop-down-->
                <?php
                if ($navigationID != 1) {
                    ?>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="navigationOrder">Order</label>
                        <?php
                        $query = "SELECT navigationOrder FROM navigations ORDER BY navigationOrder";
                        $selectNavigations = mysqli_query($connection, $query);
                        confirmQuery($selectNavigations);

                        echo "<select class='form-control' name='navigationOrder' id='navigationOrder'>";
                        while ($row = mysqli_fetch_assoc($selectNavigations)) {
                            $newNavOrder = $row['navigationOrder'];

                            if ($newNavOrder != 1){
                                if ($newNavOrder == $navigationOrder) {
                                    echo "<option value='$newNavOrder' selected='true'>$newNavOrder</option>";
                                } else {
                                    echo "<option value='$newNavOrder'>$newNavOrder</option>";
                                }
                            }
                        }
                        ?>
                        </select>
                    </div>
        <?php
                }
        ?>

 <!--Location drop down-->
                <div class="form-group col-xs-12 col-md-6">
                    <label for="navigationLocation">Location</label>
                    <?php
                    $query = "SELECT navigationLocation FROM navigations WHERE navigationID = $navigationID";
                    $selectNavigations = mysqli_query($connection, $query);

                    confirmQuery($selectNavigations);

                    while($row = mysqli_fetch_assoc($selectNavigations)) {
                        $newNavLocation = $row['navigationLocation'];
                    }

                    echo "<select class='form-control' name='navigationLocation' id='navigationLocation'>";
                        if($newNavLocation == "1") {
                            echo "<option value='1' selected='true'>Header Only</option>";
                        }else{
                            echo "<option value='1'>Header Only</option>";
                        }
                        if($newNavLocation == "2") {
                            echo "<option value='2' selected='true'>Header, Footer</option>";
                        }else{
                            echo "<option value='2'>Header, Footer</option>";
                        }
                        if($newNavLocation == "3") {
                            echo "<option value='3' selected='true'>Header, Footer, Body</option>";
                        }else{
                            echo "<option value='3'>Header, Footer, Body</option>";
                        }
                        if($newNavLocation == "4") {
                            echo "<option value='4' selected='true'>Body Only</option>";
                        }else{
                            echo "<option value='4'>Body Only</option>";
                        }
                        if($newNavLocation == "5") {
                            echo "<option value='5' selected='true'>Footer Only</option>";
                        }else{
                            echo "<option value='5'>Footer Only</option>";
                        }
                            ?>
                    </select>
                </div>

<!--Color Drop-down-->
                <?php
                $query = "SELECT navButtonColor FROM navigations WHERE navigationID = $navigationID ";
                $selectNavigations = mysqli_query($connection, $query);

                confirmQuery($selectNavigations);

                while($row = mysqli_fetch_assoc($selectNavigations)) {
                    $newNavButtonColor= $row['navButtonColor'];
                }
                echo "<div class='form-group col-xs-12 col-md-6'>";
                    echo "<label for='navButtonColor'>Color</label>";
                    echo "<select class='form-control' name='navButtonColor' id='navButtonColor'>";
                        if($newNavButtonColor == "") {
                            echo "<option value='' selected='true'>None</option>";
                        }
                        else{
                            echo "<option value=''>None</option>";
                        }
                        if($newNavButtonColor == "btn btn-primary") {
                            echo "<option value='btn btn-primary' selected='true'>Default Button Color</option>";
                        }else{
                            echo "<option value='btn btn-primary'>Default Button Color</option>";
                        }
                        if($newNavButtonColor == "btn btn-success") {
                            echo "<option value='btn btn-success' selected='true'>Green</option>";
                        }else{
                            echo "<option value='btn btn-success'>Green</option>";
                        }
                        if($newNavButtonColor == "btn btn-info") {
                            echo "<option value='btn btn-info' selected='true'>Light Blue</option>";
                        }else{
                            echo "<option value='btn btn-info'>Light Blue</option>";
                        }
                        if($newNavButtonColor == "btn btn-warning") {
                            echo "<option value='btn btn-warning' selected='true'>Yellow</option>";
                        }else{
                            echo "<option value='btn btn-warning'>Yellow</option>";
                        }
                        if($newNavButtonColor == "btn btn-danger") {
                            echo "<option value='btn btn-danger' selected='true'>Red</option>";
                        }else{
                            echo "<option value='btn btn-danger'>Red</option>";
                        }
                    echo "</select>";
                echo "</div>";
                ?>

<!--Sizing drop down-->
                <div class="form-group col-xs-12 col-md-6">
                <label for="navButtonSize">Text Size</label>
                    <?php
                    $query = "SELECT navButtonSize FROM navigations WHERE navigationID = $navigationID";
                    $selectNavigations = mysqli_query($connection, $query);

                    confirmQuery($selectNavigations);

                    while($row = mysqli_fetch_assoc($selectNavigations)) {
                        $newNavButtonSize = $row['navButtonSize'];
                    }

                    echo "<select class='form-control' name='navButtonSize' id='navButtonSize'>";
                        if($newNavButtonSize == "btn-xs") {
                            echo "<option value='btn-xs' selected='true'>Small</option>";
                        }else{
                            echo "<option value='btn-xs'>Small</option>";
                        }
                        if($newNavButtonSize == "") {
                            echo "<option value='' selected='true'>Medium</option>";
                        }else{
                            echo "<option value=''>Medium</option>";
                        }
                        if($newNavButtonSize == "btn-lg") {
                            echo "<option value='btn-lg' selected='true'>Large</option>";
                        }else{
                            echo "<option value='btn-lg'>Large</option>";
                        }
                        echo "</select>";
                    ?>
                </div>
        <?php if ($navigationID != 1) {?>
                <div class="form-group col-xs-12 col-md-6">
                    <label for="navJavaScript">Javascript</label>
                    <input value = "<?php if(isset($navJavaScript)) {echo $navJavaScript;} ?>" type = "text" class = "form-control" name="navJavaScript">
                </div>

        <?php }
            }
            updateNavigation($navigationID,$navigationOrder);
        }
        ?>

    </div>
    <div class="form-group col-xs-12">
        <input class = "btn btn-primary" type="submit" name="updatenavigation" value="Update Navigation" data-toggle="tooltip" title="Update Navigation">
        <input class = "btn btn-link" type="button" onclick="window.history.back()" value="Cancel" data-toggle='tooltip' title='Cancels editing the Navigation, and sends back to the Navigations page.'>
    </div>
</form>
</div>