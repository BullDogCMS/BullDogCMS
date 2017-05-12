<?php

function listHelpPages() {
    global $connection;

    $query = "SELECT * FROM helpPages ";

    $selectAllHelpPages = mysqli_query($connection, $query);
    confirmQuery($selectAllHelpPages);

    while($row = mysqli_fetch_assoc($selectAllHelpPages)) {

        $helpPageID = $row['helpPageID'];
        $helpPageTitle = $row['helpPageTitle'];
        $helpPageContent = $row['helpPageContent'];

        //uses first 200 characters + ... if more than 200 characters
        if (strlen($helpPageContent) > 200) {
            $helpPageContent = substr($helpPageContent, 0, 200) . "...";
        }

        echo "<tr>";
        echo "<td>
        <a href ='index.php?view=helppages&delete={$helpPageID}' data-toggle='tooltip' title='Delete' 
        onClick=\"javascript:return confirm('Are you sure you want to delete this?');\">
        <span class='glyphicon glyphicon-trash'></span><span class='sr-only'>Delete</span></a>
	    <a href ='index.php?view=helppageedit&edit={$helpPageID}' data-toggle='tooltip' title='View & Edit'>
	        <span class='glyphicon glyphicon-pencil'></span><span class='sr-only'>Edit</span></a></td>";

        echo "<td>{$helpPageID}</td>";
        echo "<td>{$helpPageTitle}</td>";
        echo "<td>{$helpPageContent}</td>";
        echo "</tr>";
    }
}

function helpPageView($helpPageID) {
    global $connection;

    echo "<div class='cd-panel from-right'>";

    //$helpPageID = '2';
    $query = "SELECT * FROM helpPages WHERE helpPageID = $helpPageID ";
    $selectHelpPages = mysqli_query($connection, $query);

    confirmQuery($selectHelpPages);

    while($row = mysqli_fetch_assoc($selectHelpPages)) {
        $helpPageTitle = $row['helpPageTitle'];
        $helpPageContent = $row['helpPageContent'];
    }

    ?>
    <header class="cd-panel-header">
        <h1><?php echo $helpPageTitle ?></h1>
        <a href="#0" class="cd-panel-close">Close</a>
    </header>
     
    <div class="cd-panel-container">
        <div class="cd-panel-content">

            <div class="row">
                <div class="col-xs-12 dont-break-out">
                    <?php echo $helpPageContent?>
                </div>
            </div>
        </div> <!-- cd-panel-content -->
    </div> <!-- cd-panel-container -->
    </div> <!-- cd-panel -->


<?php mysqli_close($connection);
}

function addHelpPage() {
    global $connection;

    $helpPageTitle    = mysqli_real_escape_string($connection,$_POST['helpPageTitle']);
    $helpPageContent     = mysqli_real_escape_string($connection,$_POST['helpPageContent']);

    if ($helpPageTitle == "" || empty($helpPageTitle))
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter a title.</div>';
    else {

        $query = "INSERT INTO helpPages(helpPageTitle, helpPageContent) ";

        $query .= "VALUES('{$helpPageTitle}','{$helpPageContent}')";

        $addHelpPage = mysqli_query($connection, $query);

        confirmQuery($addHelpPage);

        mysqli_close($connection);

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=helppages";
        </script>
        <?php

        }
    }

function updateHelpPage($helpPageID){
    global $connection;

//update Links Table

    if (isset($_POST['updatehelppage'])) {

        $helpPageTitle = mysqli_real_escape_string($connection, $_POST['helpPageTitle']);
        $helpPageContent = mysqli_real_escape_string($connection, $_POST['helpPageContent']);


        $query = "UPDATE helpPages SET helpPageTitle = '$helpPageTitle', helpPageContent = '$helpPageContent' WHERE helpPageID= '$helpPageID'";
        mysqli_query($connection, $query);

        mysqli_close($connection);

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=helppages";   //Refreshes page
        </script>
        <?php
    }
}


function deleteHelpPage() {
    global $connection;

    if (isset($_GET['delete'])) {
        $helpPageID= $_GET['delete'];

        $query = "DELETE FROM helpPages WHERE helpPageID = {$helpPageID} ";
        mysqli_query($connection, $query);

        mysqli_close($connection);

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=helppages";   //Refreshes page
        </script>
        <?php
    }


}

?>