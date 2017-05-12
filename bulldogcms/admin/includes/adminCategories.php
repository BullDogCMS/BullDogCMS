<!--This module controls Category CRUD operations -->

<h1 class="page-header">
	Categories
</h1>

<!--Add Category Form-->
<div class ="col-xs-12">
	<h3>Add Category</h3>

	<?php insertCategory(); ?>

	<form  method="post" enctype="multipart/form-data">
		<div class="form-group col-xs-12 col-md-6">
			<label for="catName1">Category Title</label>
			<input type="text" class="form-control" name="categoryName" id="catName1" autofocus required>
		</div>
		<div class="form-group col-xs-12 col-md-6">
			<label for="parentNav">Navigation Page</label>
			<select class="form-control" name="navigationID" id="parentNav" required>
				<option value="" disabled selected hidden>Select Options</option> <!--Error this out if selected -->
				<?php
				$query = "SELECT * FROM navigations";
				$selectNavigations = mysqli_query($connection, $query);

				confirmQuery($selectNavigations);

				while($row = mysqli_fetch_assoc($selectNavigations)) {
					$navigationID = $row['navigationID'];
					$navigationName = $row['navigationName'];
                    $navigationURL= $row['navigationURL'];

                    //Do not provide Home (navID=1), Special Page, #, or external URL as an option
					if($navigationID != 1){
                        if(substr($navigationURL, 0, 26) != "index.php?view=specialpage") {
                            if (substr($navigationURL, 0, 4) != "http") {
                                if (substr($navigationURL, 0, 1) != "#") {
                                    if(substr($navigationURL, 0, 26) != "index.php?view=articlelist") {
                                        echo "<option value='$navigationID'>{$navigationName}</option>";
                                    }
                                }
                            }
                        }
					}
				}
				?>
			</select>
		</div>
        <div class="form-group col-xs-12 col-md-6">
            <label for="categoryType">Category Type</label>
            <select class="form-control" name="categoryTypeID" id="categoryType" required>
                <option value="" disabled selected hidden>Select Options</option> <!--Error this out if selected -->
                <?php
                $query = "SELECT * FROM categoryType";
                $selectCategoryType = mysqli_query($connection, $query);

                confirmQuery($selectCategoryType);

                while($row = mysqli_fetch_assoc($selectCategoryType)) {
                    $categoryTypeID = $row['categoryTypeID'];
                    $categoryTypeName = $row['categoryTypeName'];

                    echo "<option value='$categoryTypeID'>{$categoryTypeName}</option>";
                }
                ?>
            </select>
        </div>
		<div class="form-group col-xs-12">
			<label for="catContent">Description</label>

            <textarea class="editor form-control" name="categoryContent" id="catContent" rows="5"></textarea>

		</div>
		<div class="form-group col-xs-12 col-md-6">
            <p><label for="catImage">Category Image</label></p>
            <input id="catImage" type="text" name="categoryImage">
            <a href="filemanager/dialog.php?type=1&field_id=catImage&relative_url=1&fldr=images" class="btn btn-filemanager btn iframe-btn" type="button" data-toggle='tooltip' title='Choose image'>Choose image</a>

            <!--<input class="filestyle" type="file" name="categoryImage" id="catImage" accept="image/*" data-classIcon="icon-plus" data-buttonText="Upload Image">-->
			<span class='label label-info' id="upload-file-info"></span>
		</div>
		<div class="form-group col-xs-12">
			<input class = "btn btn-primary" type="submit" name="submit" value="Add Category" data-toggle='tooltip' title='Add Category'>
			<input class = "btn btn-link" type="reset" value="Cancel" data-toggle='tooltip' title='Cancels the adding of the Category and refreshes this webpage.'>
		</div>
	</form>
</div><!--End of Add Category Form-->

<div class="row">
    <div class="col-xs-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th></th>
                <th>Title</th>
                <th>Navigation Page</th>
                <th>Order</th>
                <th>Image</th>
                <th class="description">Description</th>
            </tr>
            </thead>
            <tbody>
            <?php listCategories(); ?>
            <?php deleteCategory(); ?>
            <?php changeCategoryVisibility(); ?>

            </tbody>
        </table>
    </div>
</div>

<ul class="pager">
    <?php
    session_start();
    $numPages = $_SESSION['numCatPages'];
    $page = $_SESSION['currentCatPage'];
    if ($numPages > 1) {
        for ($i = 1; $i <= $numPages; $i++) {
            if ($i == $page) {
                echo "<li><a class='active_link' href='index.php?view=categories&page={$i}'data-toggle='tooltip' title='Page {$i}'><strong>$i</strong></a></li>";
            }
            else {
                echo "<li><a href='index.php?view=categories&page={$i}'data-toggle='tooltip' title='Page {$i}'>$i</a></li>";
            }
        }
    }
    ?>
</ul>