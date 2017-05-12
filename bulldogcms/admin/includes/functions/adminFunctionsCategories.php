<?php

function insertCategory()
{
	global $connection;

	if (isset($_POST['submit'])) {
		$catName = mysqli_real_escape_string($connection, ucfirst($_POST['categoryName']));
		$navID = $_POST['navigationID'];
		$catContent = mysqli_real_escape_string($connection, $_POST['categoryContent']);

        $catImage = $_POST['categoryImage'];
        $categoryTypeID= $_POST['categoryTypeID'];

		if ($catName == "" || empty($catName) || $navID == "" || empty($navID)) {
			echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter a Category Name.</div>';
		} else {

//          ENSURE NO DUPLICATE CATEGORIES UNDER SAME NAVIGATION
            $catNames = "SELECT categoryName FROM categories WHERE navigationID = {$navID}";
            $nameCheckQuery = mysqli_query($connection, $catNames);
            $catExists = False;
            while($row = mysqli_fetch_assoc($nameCheckQuery)){
                $eachName = $row['categoryName'];
                if (strcasecmp($catName, $eachName) == 0){
                    $catExists = True;
                    break;
                }
            }
            if ($catExists == false) {

                //Finds the next largest order number based on the navigation selected
                $catOrderCount = "SELECT * FROM categories WHERE navigationID = {$navID} ORDER BY categoryOrder DESC LIMIT 1";
                $query = mysqli_query($connection, $catOrderCount);
                while ($row = mysqli_fetch_assoc($query)) {
                    $lastOrderCount = $row['categoryOrder'];
                }
                $nextOrderCount = $lastOrderCount + 1;


                if (!empty($catImage)) {
                    $categoryImage = $catImage;
                }

                $query = "INSERT INTO categories(navigationID,categoryName,categoryContent,categoryImage,categoryOrder,categoryVisible,categoryTypeID)";
                $query .= "VALUES('{$navID}','{$catName}','{$catContent}','{$categoryImage}','{$nextOrderCount}','1','{$categoryTypeID}')";

                $insertCategory = mysqli_query($connection, $query);

                #If not successful kill script
                confirmQuery($insertCategory);

                ?>
                <script type="text/javascript">
                    window.location = "index.php?view=categories";   //Refreshes page
                </script>
                <?php

                //Insert into changeLog table
                $userID = $_SESSION['userID']; //Hard coded for now to test
                $changedTable = "categories";
                $changeDetails = "Added " . $catName;
                insertChangeLog($userID, $changedTable, $changeDetails);
                mysqli_close($connection); //Closes db connection
            }
            else {
                echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> This Category already exists under this Navigation Page!</div>';
            }
		}
	}
}

function updateCategory($catID, $originalCategoryOrder, $categoryImage, $navID) {
	global $connection;

	//Update categories table

	if(isset($_POST['updatecategory'])) {
        $categoryName = mysqli_real_escape_string($connection, html_entity_decode($_POST['categoryName'], ENT_QUOTES, 'UTF-8'));//unescaped because it is html escaped when it is displayed on edit page
        $newCategoryOrder = $_POST['categoryOrder'];
        $navigationID = $_POST['navigationID'];
        $categoryDescription = mysqli_real_escape_string($connection, $_POST['categoryContent']);
        $catImage = $_POST['categoryImage'];
        $categoryTypeID = $_POST['categoryTypeID'];

        //if a new image is uploaded set new file name
        if (!empty($catImage)) {
            $categoryImage = $catImage;
        }

        //Check to see if order changed or if the navigation page changed, and if so, change any conflicting orders
        if ($navID == $navigationID) {
            if ($newCategoryOrder != $originalCategoryOrder) { // Navigation is same, order was changed

                if ($newCategoryOrder < $originalCategoryOrder) {
                    $query = "SELECT * FROM categories WHERE categoryOrder >= {$newCategoryOrder} AND navigationID = {$navID} AND categoryID!={$catID} ORDER BY categoryOrder";
                    $getOrder_query = mysqli_query($connection, $query);
                    $tempCatOrder = $newCategoryOrder;

                    while ($row = mysqli_fetch_assoc($getOrder_query)) {
                        $thisCatID = $row['categoryID'];
                        $thisCatOrder = $row['categoryOrder'];
                        if ($thisCatOrder == $tempCatOrder) {
                            $tempCatOrder += 1;
                            $query = "UPDATE categories SET categoryOrder = $tempCatOrder WHERE categoryID = $thisCatID";
                            $orderUpdate_query = mysqli_query($connection, $query);
                            confirmQuery($orderUpdate_query);
                        }
                    }
                }

                if ($newCategoryOrder > $originalCategoryOrder) {
                    $query = "SELECT * FROM categories WHERE categoryOrder <= $newCategoryOrder AND categoryOrder >= $originalCategoryOrder AND navigationID = {$navID} AND categoryID != $catID ORDER BY categoryOrder DESC";
                    $getOrder_query = mysqli_query($connection, $query);
                    $tempCatOrder = $newCategoryOrder;

                    while ($row = mysqli_fetch_assoc($getOrder_query)) {
                        $thisCatID = $row['categoryID'];
                        $thisCatOrder = $row['categoryOrder'];
                        if ($thisCatOrder == $tempCatOrder) {
                            $tempCatOrder -= 1;
                            $query = "UPDATE categories SET categoryOrder = $tempCatOrder WHERE categoryID= $thisCatID";
                            $update_query = mysqli_query($connection, $query);
                            confirmQuery($update_query);
                        }
                    }

                }

                $query = "UPDATE categories 
					SET categoryName='{$categoryName}',
						categoryOrder='{$newCategoryOrder}',
						navigationID='{$navigationID}',
						categoryContent='{$categoryDescription}',
						categoryImage='{$categoryImage}',
						categoryTypeID='{$categoryTypeID}'
					WHERE categoryID = {$catID}";
                $update_query = mysqli_query($connection, $query);

                confirmQuery($update_query);
            } else{ // Neither Navigation nor category order changed
                $query = "UPDATE categories 
					SET categoryName='{$categoryName}',
						navigationID='{$navigationID}',
						categoryContent='{$categoryDescription}',
						categoryImage='{$categoryImage}',
						categoryTypeID='{$categoryTypeID}'
					WHERE categoryID = {$catID}";
                $update_query = mysqli_query($connection, $query);

                confirmQuery($update_query);
            }
        } else { //Navigation Was Changed
//reorder categories from previous navigation to avoid gap when this category is moved to new navigation
            $query = "SELECT * FROM categories WHERE categoryOrder>{$originalCategoryOrder} AND navigationID={$navID} ORDER BY categoryOrder";
            $orderCheckQuery = mysqli_query($connection, $query);
            if (mysqli_num_rows($orderCheckQuery) != 0) {
                $tempCatOrder = $originalCategoryOrder;
                while($row = mysqli_fetch_assoc($orderCheckQuery)){
                    $thisCatID = $row['categoryID'];

                    $query = "UPDATE categories SET categoryOrder={$tempCatOrder} WHERE categoryID={$thisCatID}";
                    $update_query = mysqli_query($connection, $query);

                    confirmQuery($update_query);

                    $tempCatOrder += 1;
                }
            }

            //Finds the next largest order number based on the navigation selected
            $catOrderCount = "SELECT * FROM categories WHERE navigationID = {$navigationID} ORDER BY categoryOrder DESC LIMIT 1";
            $query = mysqli_query($connection, $catOrderCount);
            while ($row = mysqli_fetch_assoc($query)) {
                $lastOrderCount = $row['categoryOrder'];
            }
            $nextOrderCount = $lastOrderCount + 1;

            $query = "UPDATE categories 
					SET categoryName='{$categoryName}',
					    categoryOrder='{$nextOrderCount}',
						navigationID='{$navigationID}',
						categoryContent='{$categoryDescription}',
						categoryImage='{$categoryImage}',
						categoryTypeID='{$categoryTypeID}'
					WHERE categoryID = {$catID}";
            $update_query = mysqli_query($connection, $query);

            confirmQuery($update_query);
        }


        //Insert into changeLog table
        $userID = $_SESSION['userID']; //Hard coded for now to test
        $changedTable = "categories";
        $changeDetails = "Updated " . $categoryName;
        insertChangeLog($userID, $changedTable, $changeDetails);

        mysqli_close($connection); //Closes db connection

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=categories";   //Refreshes page
            window.alert("Category updated successfully.");
        </script>
        <?php
    }
}

/**
 *
 */
function listCategories(){
    global $connection;

    //PAGINATION
    $siteSettingsQuery = "SELECT * FROM siteSettings WHERE siteSettingID = '1'";
    $selectSiteSettings = mysqli_query($connection, $siteSettingsQuery);
    while($row = mysqli_fetch_assoc($selectSiteSettings)) {
        $perPage = $row['paginationLength']; //pulls how many results are displayed per page from database
    }

    if (isset($_GET['page'])) {

        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    if ($page == "" || $page == 1) {
        $page1 = 0;
    } else {
        $page1 = ($page * $perPage) - $perPage;
    }

        $categoryCountQuery = "SELECT * FROM categories c JOIN navigations n ON c.navigationID = n.navigationID ORDER BY c.navigationID";
        $findCount = mysqli_query($connection, $categoryCountQuery);
        $count = mysqli_num_rows($findCount);

        $numPages = ceil($count / $perPage);
        session_start();
        $_SESSION['numCatPages'] = $numPages;//session variables passed to file calling this function
        $_SESSION['currentCatPage'] = $page;


        $query = "SELECT * FROM categories c JOIN navigations n on c.navigationID = n.navigationID ORDER BY c.navigationID, c.categoryOrder LIMIT $page1, $perPage";
//END PAGINATION

        $selectCategories = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($selectCategories)) {
            $categoryID = $row['categoryID'];
            $categoryName = htmlentities($row['categoryName'], ENT_QUOTES, 'UTF-8');
            $navigationName = htmlentities($row['navigationName'], ENT_QUOTES, 'UTF-8');
            $navID = $row['navigationID'];
            $categoryOrder = $row['categoryOrder'];
            $categoryImage = $row['categoryImage'];
            $categoryDescription = $row['categoryContent'];

            //create category description snippet for viewing

            //Remove images. Code from http://stackoverflow.com/questions/1107194/php-remove-img-tag-from-string
//            $categoryDescription = preg_replace("/<img[^>]+\>/i", " (image) ", $categoryDescription);
            $categoryDescription = strip_tags($categoryDescription);

            //uses first 50 characters + ... if more than 50 characters
            if (strlen($categoryDescription) > 150) {
                $categoryDescription = substr($categoryDescription, 0, 150) . "...";
            }


            echo "<tr>";
            echo "<td><a href ='index.php?view=categories&delete={$categoryID}&catName={$categoryName}&catOrder={$categoryOrder}&navID={$navID}' data-toggle='tooltip' title='Delete'
			onClick=\"javascript:return confirm('Are you sure you want to delete this category?');\">
			<span class='glyphicon glyphicon-trash'></span><span class='sr-only'>Delete</span></a>&nbsp; 
	        &nbsp;<a href ='index.php?view=catedit&edit={$categoryID}' data-toggle='tooltip' title='View & Edit'>
	        <span class='glyphicon glyphicon-pencil'></span><span class='sr-only'>View and Edit</span></a>";
            if ($row['categoryVisible'] == '0') {
                echo "&nbsp;&nbsp;<a href='index.php?view=categories&setvisibleyes={$categoryID}&name={$categoryName}' data-toggle='tooltip' title='Turn Visibility ON'>
                <span class='glyphicon glyphicon-eye-close'></span><span class='sr-only'>Visibility set to ON</span></a></td>";
            } else {
                echo "&nbsp;&nbsp;<a href='index.php?view=categories&setvisibleno={$categoryID}&name={$categoryName}' data-toggle='tooltip' title='Turn Visibility Off'>
                <span class='glyphicon glyphicon-eye-open'></span><span class='sr-only'>Visibility set to OFF</span></a></td>";
            }
            echo "<td>$categoryName</td>";
            echo "<td>$navigationName</td>";
            echo "<td>{$categoryOrder}</td>";
            echo "<td><img width='100%' src='../uploads/{$categoryImage}'></td>";
            echo "<td>{$categoryDescription}</td>";
            echo "</tr>";
        }
    }

    function deleteCategory()
    {
        global $connection;

        if (isset($_GET['delete'])) {
            $catID = $_GET['delete'];
            $categoryName = $_GET['catName'];
            $deletedCatOrder = $_GET['catOrder'];
            $navID = $_GET['navID'];

//		Check to see if the category has any articles
            $checkQuery = "SELECT * FROM articles WHERE categoryID = {$catID} ";
            if (mysqli_num_rows(mysqli_query($connection, $checkQuery)) != 0) {
                echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> You cannot delete a Category that has Articles assigned to it.</div>';
            } else {
                $query = "DELETE FROM categories WHERE categoryID = {$catID} ";
                $delete_query = mysqli_query($connection, $query);

                confirmQuery($delete_query);

                //If deleted category was not last in the order of its parent navigation, then reorder all categories of that parent that have order greater than the one deleted
                $query = "SELECT * FROM categories WHERE categoryOrder>{$deletedCatOrder} AND navigationID={$navID} ORDER BY categoryOrder";
                $orderCheckQuery = mysqli_query($connection, $query);
                if (mysqli_num_rows($orderCheckQuery) != 0) {
                    $tempCatOrder = $deletedCatOrder;
                    while($row = mysqli_fetch_assoc($orderCheckQuery)){
                        $thisCatID = $row['categoryID'];

                        $query = "UPDATE categories SET categoryOrder={$tempCatOrder} WHERE categoryID={$thisCatID}";
                        $update_query = mysqli_query($connection, $query);

                        confirmQuery($update_query);

                        $tempCatOrder += 1;
                    }
                }

                //Insert into changeLog table
                $userID = $_SESSION['userID']; //Hard coded for now to test
                $changedTable = "categories";
                $changeDetails = "Deleted " . $categoryName;
                insertChangeLog($userID, $changedTable, $changeDetails);

                mysqli_close($connection); //Closes db connection

                ?>
                <script type="text/javascript">
                    window.location = "index.php?view=categories";   //Refreshes page
                </script>
                <?php
            }

        }
    }

    function changeCategoryVisibility()
    {
        global $connection;

        if (isset($_GET['setvisibleno'])) {

            $categoryID = $_GET['setvisibleno'];

            $query = "UPDATE categories SET categoryVisible = '0' WHERE categoryID = $categoryID";
            $changeVisible = mysqli_query($connection, $query);

            //Insert into changeLog table
            $userID = $_SESSION['userID']; //Hard coded for now to test
            $catName = $_GET['name'];
            $changedTable = "categories";
            $changeDetails = "Category &#039;" . $catName . "&#039; was set to not visible";
            insertChangeLog($userID, $changedTable, $changeDetails);
            mysqli_close($connection); //Closes db connection

            ?>
            <script type="text/javascript">
                window.location = "index.php?view=categories";   //Refreshes page
            </script>
            <?php


        }

        if (isset($_GET['setvisibleyes'])) {

            $categoryID = $_GET['setvisibleyes'];

            $query = "UPDATE categories SET categoryVisible = '1' WHERE categoryID = $categoryID";
            $changeVisible = mysqli_query($connection, $query);

            //Insert into changeLog table
            $userID = $_SESSION['userID']; //Hard coded for now to test
            $catName = $_GET['name'];
            $changedTable = "categories";
            $changeDetails = "Category &#039;" . $catName . "&#039; was set to visible";
            insertChangeLog($userID, $changedTable, $changeDetails);
            mysqli_close($connection); //Closes db connection
            ?>
            <script type="text/javascript">
                window.location = "index.php?view=categories";   //Refreshes page
            </script>
            <?php
        }
    }
?>

