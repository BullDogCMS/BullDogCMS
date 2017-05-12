<h1 class="page-header">
    Aside Links
</h1>

<!--Add Category Form-->
<div class ="col-xs-12">
    <h3>Add Link</h3>
    <?php
    if (isset($_POST['submit'])) {
        $linkName = mysqli_real_escape_string($connection, $_POST['linkName']);
        $linkURL = mysqli_real_escape_string($connection, $_POST['linkURL']);
        $linkTypeID = mysqli_real_escape_string($connection, $_POST['linkTypeID']);

    if ($linkName == "" || empty($linkName) || $linkURL == "" || empty($linkURL)) {
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter a Link Name.</div>';
    } else {
        //Finds the next largest order number
        $linkOrderCount = "SELECT * FROM links WHERE linkTypeID = {$linkTypeID} ORDER BY linkOrder DESC LIMIT 1";
        $query = mysqli_query($connection, $linkOrderCount);
        while ($row = mysqli_fetch_assoc($query)) {
            $lastOrderCount1 = $row['linkOrder'];
        }
        $nextOrderCount1 = $lastOrderCount1 + 1;

        $query = "INSERT INTO links(linkName,linkURL,linkOrder,linkTypeID)";
        $query .= "VALUES('{$linkName}','{$linkURL}','$nextOrderCount1','$linkTypeID')";

        $insertCategory = mysqli_query($connection, $query);

        #If not successful kill script
        confirmQuery($insertCategory);

        //Insert into changeLog table
        $changedTable = "links";
        $changeDetails = "Aside Link &#039;" . $linkName . " &#039; was added";

        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);
    }
        mysqli_close($connection); //Closes db connection

    ?>
    <script type="text/javascript">
        window.location = "index.php?view=asidelinks";   //Refreshes page
    </script>

    <?php
    }
    ?>

<!--End PHP area ------------------------------------------------------------------------------------------------------>
<!--Start of HTML area ------------------------------------------------------------------------------------------------>

<form action="" method="post" >

<div class="row">
	<div class="form-group col-xs-12 col-md-6">
	    <label for="linkName">Link Name</label>
	    <input class="form-control" type="text"  name="linkName" autofocus required>
	</div>
</div>

    <div class="row">
        <div class="form-group col-xs-12 col-md-6">
            <label for="linkTypeID">Link Type</label>
            <br>
            <input type="radio" name="linkTypeID" value="1" required> Link<br>
            <input type="radio" name="linkTypeID" value="2"> News<br>
        </div>
    </div>

<div class="row">
	<div class="form-group col-xs-12 col-md-6">
	    <label for="linkURL">Link URL</label>
	    <input class="form-control" type="url"  name="linkURL" required>
	</div>
</div>

<div class="row">
	<div class="form-group col-xs-12 col-md-6">
	    <input class="btn btn-primary" type="submit" name="submit" value="Add Aside Link" data-toggle="tooltip" title="Add Aside Link">
        <input class = "btn btn-link" type="button" onclick="window.location.reload(true)" value="Cancel" data-toggle='tooltip' title='Cancels adding the Link, and refreshes this webpage.'>
    </div>
</div>
</form>
</div>

<div class="col-xs-12">
    <table class="table table-hover">
        <thead>
        <tr>
            <th></th>
            <th>Link Name</th>
            <th>Link URL</th>
            <th>Link Order</th>
            <th>Link Type</th>
        </tr>
        </thead>
        <tbody>
        <?php listLinks(); ?>
        <?php deleteLinks(); ?>
        </tbody>
    </table>
</div>
<ul class="pager">
    <?php
    session_start();
    $numPages = $_SESSION['numPages'];
    $page = $_SESSION['currentPage'];
    if ($numPages > 1) {
        for ($i = 1; $i <= $numPages; $i++) {
            if ($i == $page) {
                echo "<li><a class='active_link' href='index.php?view=asidelinks&page={$i}'data-toggle='tooltip' title='Page {$i}'><strong>$i</strong></a></li>";
            }
            else {
                echo "<li><a href='index.php?view=asidelinks&page={$i}'data-toggle='tooltip' title='Page {$i}'>$i</a></li>";
            }
        }
    }
    ?>
</ul>