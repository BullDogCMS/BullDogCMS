<!-- Article List -->

<!-- The global variable is inserting the correct number for the css page to display the correct size if the asides are off -->

    <?php
    $enableAuthorNames = $GLOBAL['enableAuthorNames'];//grabs site settings for author names -Micah
    if(isset($_GET['display'])) {
        $display = $_GET['display'];
    } else {
        $display = '';  //If something typed in wrong, set to default.
    }
    switch($display) {
        case 'searcharticles';  //index.php?view=articlelist&display=searcharticles
		?>
            <div class="col-xs-12">
		<div class="page-header">
			<h1>Search Results</h1>
		</div>
		<?php
		$search = mysqli_real_escape_string($connection, $_POST['search']) ;

		//Code for multitag search starts here
		// http://www.designersgate.com/blogs/handling-keyword-search-phpmysql/
		// Break String into array
		$searchArray = explode(' ',$search);
		$query = "SELECT *, DATE_FORMAT(articleCreateDate, \"%m-%d-%Y\") AS artDate, DATE_FORMAT(transactionDate, \"%m-%d-%Y\") AS transDate FROM articles a JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID ";
		$query .= "WHERE a.articleVisible = '1' AND at.articlePending = '0' AND a.categoryID <> '1' AND ";
		$multiTag = array();


		foreach($searchArray as $tagCounter) {

			$multiTag[] = "articleTags LIKE '%".addslashes($tagCounter)."%'";
		}
		$query .= " ".join(' OR ',$multiTag)."  ORDER BY transactionDate DESC;";


		$select_all_articles = mysqli_query($connection, $query);
		break;

		case 'articlesbyauthor';  //index.php?view=articlelist&display=articlesbyauthor&authorID=#
			if(isset($_GET['authorID'])) {
				$authorID = $_GET['authorID'];
				$query = "SELECT *, DATE_FORMAT(articleCreateDate, \"%m-%d-%Y\") AS artDate, DATE_FORMAT(transactionDate, \"%m-%d-%Y\") AS transDate FROM articles a JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID ";
				$query .= "WHERE a.articleVisible = '1' AND at.articlePending = '0' AND a.categoryID <> '1' AND (a.articleAuthorID = '" . $authorID . "'  OR at.transactionAuthorID = '" . $authorID . "') ORDER BY transactionDate DESC";

				$select_all_articles = mysqli_query($connection, $query);
			}
			break;

        case 'articlesbycat';  //index.php?view=articlelist&display=articlesbycat&category=#
            if(isset($_GET['category'])) {
                $categoryID = $_GET['category'];
                $query = "SELECT * FROM categories WHERE categoryID = $categoryID ";
                $catID = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($catID)) {
                    $categoryName = htmlentities($row['categoryName'], ENT_QUOTES, 'UTF-8');
                    $categoryOrder = $row['categoryOrder'];
                    $navigationID = $row['navigationID'];
                    $categoryDescription = $row['categoryContent'];
                    $categoryImage = $row['categoryImage'];
                }
            }
            ?>
            <div class="col-xs-12">
            <div class="page-header">
                <h1>
                    <!--Put category details here -->
                    <?php echo $categoryName ?>
                </h1>
            </div>
            <div class="row">
                <div class="col-xs-12 dont-break-out">
                    <?php if(isset($categoryImage) && $categoryImage != '' && file_exists('uploads/' . $categoryImage)){ ?>
                        <img class="img-responsive img-thumbnail img-rounded artImage" src="uploads/<?php echo $categoryImage ?>" alt="<?php echo $categoryName ?>" >
                    <?php } ?>
                    <?php echo $categoryDescription ?>
                </div>
            </div>
            <?php

            $queryByCat = "SELECT *, DATE_FORMAT(articleCreateDate, \"%m-%d-%Y\") AS artDate, DATE_FORMAT(transactionDate, \"%m-%d-%Y\") AS transDate FROM articles a JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID WHERE a.categoryID = $categoryID ";
			$queryByCat.= "AND a.articleVisible = '1' AND at.articlePending = '0' AND a.categoryID <> '1' ORDER BY transactionDate DESC";
            $select_all_articles = mysqli_query($connection, $queryByCat);

            confirmQuery($select_all_articles);
            break;
        default:  //index.php?view=articlelist
            ?>
<!--	            <h1 class="page-header">
	                Articles
	            </h1>
	            -->
            <?php
            $bodySettingsQuery = "SELECT * FROM bodySettings WHERE bodySettingID = '1'";
            $selectBodySettings = mysqli_query($connection, $bodySettingsQuery);

            //Setting variables as GLOBAL so can be used on other pages
            while($row = mysqli_fetch_assoc($selectBodySettings)) {
                $enableArticles       = $row['fpEnableArticles'];
            }
//PAGINATION (REST OF NECESSARY CODE IS AT THE BOTTOM OF THE PAGE CALLING THIS FUNCTION)
             if(isset($_GET['view'])) {
                $view = $_GET['view'];
            } else {
                $view = $enableArticles;
            }
            if(isset($_GET['display'])) {
                $display = $_GET['display'];
            } else {
                $display = null;
            }
        if ($display == null && $view == 'articlelist') { //index.php?view=articlelist
            ?>
            <div class="col-xs-12">
            <h1 class="page-header">
                Articles
            </h1>
            <?php
            $siteSettingsQuery = "SELECT * FROM siteSettings WHERE siteSettingID = '1'";
            $selectSiteSettings = mysqli_query($connection, $siteSettingsQuery);
            while ($row = mysqli_fetch_assoc($selectSiteSettings)) {
                $perPage = $row['paginationLength']; //pulls how many results are displayed per page from database
            }
        } elseif ($display == null && $view == '1'){ //index.php
            ?>
            <div class="col-xs-12">
            <h1 class="page-header">
                Latest Articles
            </h1>
            <?php
            $bodySettingsQuery = "SELECT * FROM bodySettings WHERE bodySettingID = '1'";
            $selectBodySettings = mysqli_query($connection, $bodySettingsQuery);
            while ($row = mysqli_fetch_assoc($selectBodySettings)) {
                $perPage = $row['fpPagLength']; //pulls how many results are displayed per page from database
            }
        } else{
            $perPage = 1;
        }

            if (isset($_GET['page'])){

                $page = $_GET['page'];
            }
            else {
                $page = 1;
            }

            if($page == "" || $page == 1){
                $page1 = 0;
            }
            else {
                $page1 = ($page * $perPage) - $perPage;
            }

            $articleCountQuery = "SELECT * FROM articles a JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID ";
            $articleCountQuery .= "WHERE a.articleVisible = '1' AND at.articlePending = '0' AND a.categoryID <> '1'";
            $findCount = mysqli_query($connection, $articleCountQuery);
            $count = mysqli_num_rows($findCount);

            $numPages = ceil($count / $perPage);
            session_start();
            $_SESSION['numPages'] = $numPages;//session variables passed to file calling this function
            $_SESSION['currentPage'] = $page;

//END PAGINATION
            $query = "SELECT *, DATE_FORMAT(articleCreateDate, \"%m-%d-%Y\") AS artDate, DATE_FORMAT(transactionDate, \"%m-%d-%Y\") AS transDate FROM articles a JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID ";
            $query .= "WHERE a.articleVisible = '1' AND at.articlePending = '0' AND a.categoryID <> '1' ORDER BY transactionDate DESC LIMIT $page1, $perPage";
            $select_all_articles = mysqli_query($connection, $query);
            break;
    }

    //$query = "SELECT * FROM articles a JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID ";
    //$query .= "WHERE a.articleVisible = '1' ";
    //$select_all_articles = mysqli_query($connection, $query);

    confirmQuery($select_all_articles);

    while($row = mysqli_fetch_assoc($select_all_articles)) {
        $articleID = $row['articleID'];
        $articleTitle = $row['articleTitle'];
        $articleAuthorID = $row['articleAuthorID'];
        $transactionAuthorID = $row['transactionAuthorID'];
        $articleCreateDate = $row['artDate'];
        $transactionDate = $row['transDate'];
        $articleImage = $row['articleImage'];
        $articleContent = $row['articleContent'];

	    //create article description snippet for viewing

        //Remove images. Code from http://stackoverflow.com/questions/1107194/php-remove-img-tag-from-string
//        $articleContent = preg_replace("/<img[^>]+\>/i", "", $articleContent);
        $articleContent = strip_tags($articleContent);

	    //uses first 200 characters + ... if more than 200 characters
	    if(strlen($articleContent)>350){
		    $articleContent = substr($articleContent, 0, 300) . "...";
	    }



        ?>

        <!-- Article Details -->
        <h2>
            <a href="index.php?view=article&articleID=<?php echo $articleID ?>"><?php echo $articleTitle ?></a>
        </h2>
        <?php IF ($enableAuthorNames): //If statement to remove this section according to site settings -Micah
			//Resolve userIDs to username or full name only run if enableAuthorNames is checked.
                $authorNameSelect = "SELECT username, firstName, lastName from users WHERE userID = $articleAuthorID";
                $selectUser = mysqli_query($connection, $authorNameSelect);
                while ($row = mysqli_fetch_assoc($selectUser)) {
                    $username= $row['username'];
                    $authorFirstName = $row['firstName'];
                    $authorLastName = $row['lastName'];
                    if($GLOBAL['enableFullName'] == 1) {
                        $authorName = $authorFirstName . " " . $authorLastName;
                    }
                    else{
                        $authorName = $username;
                    }
                }

                $authorUpdateNameSelect = "SELECT username, firstName, lastName from users WHERE userID = $transactionAuthorID";
                $selectUpdateUser = mysqli_query($connection, $authorUpdateNameSelect);
                while ($row = mysqli_fetch_assoc($selectUpdateUser)) {
                    $transactionUserName = $row['username'];
                    $transactionFirstName = $row['firstName'];
                    $transactionLastName = $row['lastName'];
                    if($GLOBAL['enableFullName'] == 1) {
                        $transactionAuthorName = $transactionFirstName . " " . $transactionLastName;
                    }
                    else {
                        $transactionAuthorName = $username;
                    }
                }
			?>
        <p class="lead">
            Created by <a href="index.php?view=articlelist&display=articlesbyauthor&authorID=<?php echo $articleAuthorID;?>"><?php echo $authorName;?></a>
	        &nbsp;<small><span class="glyphicon glyphicon-time"></span> <?php echo $articleCreateDate ?></small><br/>
		    <small>Updated by <a href="index.php?view=articlelist&display=articlesbyauthor&authorID=<?php echo $transactionAuthorID;?>"><?php echo $transactionAuthorName  ?></a>
			    &nbsp;<small><span class="glyphicon glyphicon-time"></span> <?php echo $transactionDate  ?></small></small>
        </p>
        <?php ENDIF; //End of the if statement surrounding the author names and dates -Micah?>
	    <div class="row">
		    <?php if(isset($articleImage) && $articleImage != '' && file_exists('uploads/' . $articleImage)){
		    ?>
		        <div class="col-xs-12 col-sm-3">
			        <img class="img-responsive img-thumbnail img-rounded artListImage" src="uploads/<?php echo $articleImage ?>" alt="<?php echo $articleTitle ?>" >
				</div>
				<div class="col-xs-12 col-sm-9">
			<?php } else{ echo '<div class="col-xs-12">'; } ?>
			        <p><?php echo $articleContent ?></p>
				</div>
	    </div>
	    <a class="btn btn-primary readMore" href="index.php?view=article&articleID=<?php echo $articleID ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
        <hr>
    <?php

    }?>
</div>

