<!--This module controls Navigations CRUD operations -->

<h1 class="page-header">
    Navigations
</h1>

<div class ="col-xs-12">

    <?php insertNavigation(); ?>

    <form action ="" method="post">
        <div class="form-group col-xs-12 col-md-6">
            <label for="navName">Navigation Title</label>
            <!--copyNavName() located in site's admin\js\bdadmin.js -->
            <input type="text" class="form-control" name="navigationName" id="navigationName" onchange="copyNavName(this.form)" autofocus required>
        </div>
        <div class="form-group col-xs-12 col-md-6">
            <label for="navLocation">Location</label>
            <select class="form-control" name="navLocation" id="navLocation" required>
                <option value="1">Header Only</option>
                <option value="2">Header, Footer</option>
                <option value="3">Header, Footer, Body</option>
                <option value="4">Body Only</option>
                <option value="5">Footer Only</option>
            </select>
        </div>
        <div class="form-group col-xs-12 col-md-6">
            <label for="navButtonColor">Background Color</label>
            <select class="form-control" name="navButtonColor" id="navButtonColor">
                <option selected="true" value="">None</option>
                <option value="btn btn-primary">Default Button Color</option>
                <option value="btn btn-success">Green</option>
                <option value="btn btn-info">Light Blue</option>
                <option value="btn btn-warning">Yellow</option>
                <option value="btn btn-danger">Red</option>
            </select>
        </div>
        <div class="form-group col-xs-12 col-md-6">
            <label for="navButtonSize">Text Size</label>
            <select class="form-control" name="navButtonSize" id="navButtonSize">
                <option value="btn-xs">Small</option>
                <option value="" selected="true">Medium</option>
                <option value="btn-lg">Large</option>
            </select>
        </div>
        <div class="form-group col-xs-12 col-md-6">
            <!--showOtherURLField() located in site's admin\js\bdadmin.js -->
            <label for="navURL">URL</label>
            <select class="form-control" id = 'navURL' name= 'navURL' onchange='showOtherURLField(this.options[this.selectedIndex].value)'>
                <option value= "#" selected="true">None or JavaScript</option>
                <option value= "index.php?view=indexcategories">Home Categories</option>
                <option value= "index.php?view=articlelist">Article List</option>
                <?php
                //Query to return special pages for dropdown.
                $specialPages= "SELECT * FROM articles a JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID WHERE a.categoryID = '1' AND at.articlePending <> '2' ";
                $specialPagesQuery = mysqli_query($connection, $specialPages);
                confirmQuery($specialPagesQuery);

                //Outputs query results into 'option' control element (Dropdown list).
                while ($row = mysqli_fetch_assoc($specialPagesQuery))
                {
                    echo "<option value=index.php?view=specialpage&articleID=".$row['articleID'].">".$row['articleTitle']."</option>";
                }
                ?>
                <option value="otherURL">Other</option>
            </select>
            <div id="otherURLDiv"></div>
        </div>
        <div class="form-group col-xs-12 col-md-6">
            <label for="navJavaScript">JavaScript</label>
            <input type="text" class="form-control" name="navJavaScript">
        </div>
        <div class="form-group col-xs-12">
            <input class = "btn btn-primary" type="submit" name="submit" value="Add Navigation" data-toggle='tooltip' title='Add Navigation'>
            <input class = "btn btn-link" type="button" onclick="window.location.reload(true)" value="Cancel" data-toggle='tooltip' title='Cancels adding the Navigation, and refreshes this webpage.'>
        </div>
    </form>
    <?php
    if(isset($_GET['edit']))
    {
        $navigationID = $_GET['edit'];
        include "adminNavigationEdit.php";
    }
    ?>
</div>

<div class="col-xs-12">

    <table class="table table-hover">
        <thead>
        <tr>
            <th></th>
            <th>Title</th>
            <th>URL</th>
            <th>Order</th>
            <!--<th>Color</th>
            <th>Size</th>-->
            <th>Location</th>
            <th>JavaScript</th>
        </tr>
        </thead>
        <tbody>
        <?php listNavigations(); ?>

        <?php deleteNavigation(); ?>

        <?php editVisibility(); ?>

        </tbody>
    </table>
</div>
<!--End of Add Navigation Form-->


<ul class="pager">
    <?php
        session_start();
        $numPages = $_SESSION['numPages'];
        $page = $_SESSION['currentPage'];
            if ($numPages > 1) {
                for ($i = 1; $i <= $numPages; $i++) {
                    if ($i == $page) {
                        echo "<li><a class='active_link' href='index.php?view=navigations&page={$i}'data-toggle='tooltip' title='Page {$i}'><strong>$i</strong></a></li>";
                    }
                    else {
                        echo "<li><a href='index.php?view=navigations&page={$i}'data-toggle='tooltip' title='Page {$i}'>$i</a></li>";
                    }
                }
            }
    ?>
</ul>