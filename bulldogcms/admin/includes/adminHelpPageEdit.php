<div class ="col-xs-12">

    <h3>Edit Help Page</h3>

    <?php
        if(isset($_GET['edit'])) {
            $helpPageID = $_GET['edit'];
            $query = "SELECT * FROM helpPages WHERE helpPageID = $helpPageID ";
            $hpID = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($hpID)) {
                $helpPageTitle = $row['helpPageTitle'];
                $helpPageContent = $row['helpPageContent'];
            }

            //Update category table
            updateHelpPage($helpPageID);
        }
    ?>

    <form action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="title">Title</label>
            <input value="<?php if(isset($helpPageTitle)) {echo $helpPageTitle;} ?>"type="text" class="form-control" name="helpPageTitle">
        </div>

        <div class="form-group col-xs-12">
            <label for="helpPageContent">Content</label>

            <textarea class="editor form-control" name="helpPageContent" id="helpPageContent" rows="5"><?php echo "{$helpPageContent}"; ?></textarea>
        </div>

        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
                <input class="btn btn-primary" type="submit" name="updatehelppage" value="Update">
                <input class = "btn btn-link" type="button" onclick="window.history.back()" value="Cancel" data-toggle="tooltip" title="Selecting this link will redirect you to the previous page and the User will not be added.">
            </div>
        </div>


    </form>
</div>