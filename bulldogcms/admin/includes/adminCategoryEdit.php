<!--This module controls Category Update operations -->
<!--It is shown on the categories.php when Edit option is used -->

<h1 class="page-header">
	Category Edit
</h1>

<?php

	//Set initial variable values from categories table
	if(isset($_GET['edit'])) {
		$categoryID = $_GET['edit'];
		$query = "SELECT * FROM categories WHERE categoryID = $categoryID ";
		$catID = mysqli_query($connection, $query);

		while ($row = mysqli_fetch_assoc($catID)) {
			$categoryName = htmlentities($row['categoryName'], ENT_QUOTES, 'UTF-8');//escaped here to be displayed. It is html unescaped when it is inserted into database
			$categoryOrder = $row['categoryOrder'];
			$navigationID = $row['navigationID'];
			$categoryDescription = htmlentities($row['categoryContent'], ENT_QUOTES, 'UTF-8');//escaped here when displayed. Editor takes care of unescaping.
			$categoryImage = $row['categoryImage'];
            $categoryTypeID = $row['categoryTypeID'];

			if (isset($_POST['imageRemove']) == 'remove') {
                $categoryImage = "";
            }
		}
		//Update category table
		updateCategory($categoryID, $categoryOrder, $categoryImage, $navigationID);

	}

?>

<div class ="col-xs-12">
	<form action ="" method="post" enctype="multipart/form-data">
            <div class="form-group col-xs-6">
	            <label for="categoryName">Category Name</label>
                <input value = "<?php if(isset($categoryName)) {echo $categoryName;} ?>" type="text" class="form-control" name="categoryName" required autofocus onfocus="this.select();">
            </div>
            <div class="form-group col-xs-6">
	            <label for="parentNav">Navigation Page</label>
	            <select class="form-control" name="navigationID" id="parentNav" onchange="$('#categoryOrder').prop('disabled', true);">
		            <?php
		            $query = "SELECT * FROM navigations";
		            $selectNavigations = mysqli_query($connection, $query);

		            confirmQuery($selectNavigations);

		            while($row = mysqli_fetch_assoc($selectNavigations)) {
			            $newNavigationID = $row['navigationID'];
			            $navigationName = $row['navigationName'];

//					    Do not provide Home (navID=1) as an option
			            if($newNavigationID != 1){
//					        populate select and set selected to current nav
				            if($newNavigationID == $navigationID){
					            echo "<option selected='selected' value='$newNavigationID'>{$navigationName}</option>";
				            }
				            else{
					            echo "<option value='$newNavigationID'>{$navigationName}</option>";
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
                        $newCategoryTypeID = $row['categoryTypeID'];
                        $categoryTypeName = $row['categoryTypeName'];

                        if($newCategoryTypeID == $categoryTypeID){
                            echo "<option selected='selected' value='$newCategoryTypeID'>{$categoryTypeName}</option>";
                        }
                        else{
                            echo "<option value='$newCategoryTypeID'>{$categoryTypeName}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        <!--ORDER DROP-DOWN-->
        <div class="form-group col-xs-12 col-md-6">
            <label for="categoryOrder">Order</label>
            <?php
            $query = "SELECT categoryOrder FROM categories WHERE navigationID = {$navigationID} ORDER BY categoryOrder";
            $selectCategories = mysqli_query($connection, $query);
            confirmQuery($selectCategories);

            echo "<select class='form-control' name='categoryOrder' id='categoryOrder'>";
            while ($row = mysqli_fetch_assoc($selectCategories)) {
                $newCatOrder = $row['categoryOrder'];

                if ($newCatOrder == $categoryOrder) {
                    echo "<option value='$newCatOrder' selected='true'>$newCatOrder</option>";
                } else {
                    echo "<option value='$newCatOrder'>$newCatOrder</option>";
                }
            }
            ?>
            </select>
        </div>
            <div class="form-group col-xs-12">
	            <label for="catContent">Description</label>

                <textarea class="editor form-control" name="categoryContent" id="catContent" rows="5"><?php echo "{$categoryDescription}"; ?></textarea>

            </div>
            <div class="form-group col-xs-12">
	            <label class="col-xs-12">Category Image</label>
	            <div class="col-xs-3">
		            <p>Current Image:</p>
		            <?php
		            echo "<img width='100' src='../uploads/{$categoryImage}'>";
		            ?>
	            </div>
	            <div class="col-xs-6">
		            <p>Upload New Image:</p>
                    <input id="catImage" type="text" name="categoryImage">
                    <a href="filemanager/dialog.php?type=1&field_id=catImage&relative_url=1&fldr=images" class="btn btn-filemanager btn iframe-btn" type="button" data-toggle='tooltip' title='Choose image'>Choose image</a>
		            <!--<input class="form-control" type="file" name="categoryImage" id="catImage" accept="image/*">-->
	            </div>
                <div class="col-xs-12">
                    <input type="checkbox" name="imageRemove" value="remove"> Remove Image?<br>
                </div>
            </div>
<!--
            <div class="form-group col-xs-3">
                <label for="categoryOrder">Category Order</label>
                <input value = "<?php// if(isset($categoryOrder)) {echo $categoryOrder;} ?>" type = "number" class = "form-control" name="categoryOrder" min="1" max="254" required>
            </div>
-->

            <div class="form-group col-xs-12">
                <input class = "btn btn-primary" type="submit" name="updatecategory" value="Update Category" data-toggle='tooltip' title='Update Category'>
                <input class = "btn btn-link" type="button" onclick="window.history.back()" value="Cancel" data-toggle='tooltip' title='Cancels the Category update and redirects you to the previous webpage.'>
            </div>
	</form>
</div>