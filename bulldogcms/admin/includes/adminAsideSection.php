<h1 class="page-header">
    Aside Section
</h1>

<!--Add Category Form-->
<div class ="col-xs-12">

    <h3>Edit Aside Section</h3>
    <?php
    if (isset($_POST['submit'])) {
        $asideHeader = mysqli_real_escape_string($connection, html_entity_decode($_POST['asideHeader'], ENT_QUOTES, 'UTF-8'));//unescaping when it goes in. only escaping lower when it comes out.
        $asideText = mysqli_real_escape_string($connection, $_POST['asideText']); //editor takes care of escaping.

        if ($asideHeader == "" || empty($asideHeader) || $asideText == "" || empty($asideText)) {
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter a Link Name.</div>';
        }

            $query = "UPDATE asideSection SET asideHeader = '{$asideHeader}', asideText = '{$asideText}' ";
            $query .= "WHERE asideSectionID = '1'";

            $insertCategory = mysqli_query($connection, $query);

            #If not successful kill script
            confirmQuery($insertCategory);

        $changedTable = "asideSection";
        $changeDetails = "Edit made to Aside Section";

        //write results to changelog.
        insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

        mysqli_close($connection); //Closes db connection

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=asidesection";   //Refreshes page
            window.alert("Aside Section updated successfully.");
        </script>

        <?php
    }
    ?>

    <?php

    $asideSection = "SELECT * FROM asideSection WHERE asideSectionID = '1'";
    $asideSectionQuery = mysqli_query($connection,$asideSection);

    confirmQuery($asideSectionQuery);

    while($row = mysqli_fetch_assoc($asideSectionQuery)) {
        $asideHeader = htmlentities($row['asideHeader'], ENT_QUOTES, 'UTF-8');
        $asideText = htmlentities($row['asideText'], ENT_QUOTES, 'UTF-8');
    }
    ?>

    <form action="" method="post" >

        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
                <label for="asideHeader">Aside Header</label>
                <input value="<?php if(isset($asideHeader)) {echo $asideHeader;} ?>" type="text" class="form-control" name="asideHeader" autofocus required >
            </div>
        </div>

        <div class="form-group col-xs-12">
            <label for="bodyContent">Front Body Text</label>

            <textarea class="editor form-control" name="asideText" id="asideText" rows="5"><?php echo "{$asideText}"; ?></textarea>
        </div>

        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
                <input class="btn btn-primary" type="submit" name="submit" value="Edit Aside Section">
            </div>
        </div>
    </form>
</div>
