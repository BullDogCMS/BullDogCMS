<!--Add Help Page Form-->
<div class ="col-xs-12">

    <h3>Add Help Page</h3>

    <?php
    if(isset($_POST['addhelppage'])) {

        addHelpPage();
    }
    ?>

    <form action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="helpPageTitle">
        </div>

        <div class="form-group col-xs-12">
            <label for="helpPageContent">Content</label>

            <textarea class="editor form-control" name="helpPageContent" id="helpPageContent" rows="5"></textarea>
        </div>

        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
                <input class="btn btn-primary" type="submit" name="addhelppage" value="Submit">
                <input class = "btn btn-link" type="button" onclick="window.history.back()" value="Cancel" data-toggle="tooltip" title="Selecting this link will redirect you to the previous page and the User will not be added.">
            </div>
        </div>


    </form>
</div>