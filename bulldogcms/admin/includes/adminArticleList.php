<!-- Displays a list of articles -->
<?php

//Get values for view and display, to dynamically update sort links depending on page.
if(isset($_GET['view'])) {
    $viewMod = "view=" . $_GET['view'];
}

if(isset($_GET['display'])) {
    $displayMod = "&display=" . $_GET['display'];
} else {
    $displayMod = "";
}
?>

<table class = "table table-hover" id="articleList">
    <thead>
    <tr>
        <th></th>
        <!--<th>Id</th>-->

          <th>
              <ul class="sort-header">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Title<b class="caret"></b></a>
                    <ul style="list-style: none;" class="dropdown-menu">
                        <li>
                            <a href="index.php?<?php echo "$viewMod"."$displayMod"; ?>&order=title&sort=asc">Sort by Ascending</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php?<?php echo "$viewMod"."$displayMod"; ?>&order=title&sort=desc">Sort by Descending</a>
                        </li>
                    </ul>
                </li>
              </ul>
         </th>
        <!--<th>Title</th>-->


        <?php if ($_GET['display'] == "specialpages") { ?>
        <th>
            <ul class="sort-header">Category</ul>
        </th>
        <?php } else {?>
        <th>
            <ul class="sort-header">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Category<b class="caret"></b></a>
                    <ul style="list-style: none;" class="dropdown-menu">
                        <li>
                            <a href="index.php?view=articles<?php echo "$displayMod"; ?>&order=category&sort=asc">Sort by Ascending</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php?view=<?php echo "$displayMod"; ?>articles&order=category&sort=desc">Sort by Descending</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </th>
        <!--<th>Category</th>-->
        <?php } ?>

        <th>
            <ul class="sort-header">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Author<b class="caret"></b></a>
                    <ul style="list-style: none;" class="dropdown-menu">
                        <li>
                            <a href="index.php?view=articles<?php echo "$displayMod"; ?>&order=author&sort=asc">Sort by Ascending</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php?view=articles<?php echo "$displayMod"; ?>&order=author&sort=desc">Sort by Descending</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </th>
        <!--<th>Author</th>-->

        <th>
            <ul class="sort-header">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Date Created<b class="caret"></b></a>
                    <ul style="list-style: none;" class="dropdown-menu">
                        <li>
                            <a href="index.php?view=articles<?php echo "$displayMod"; ?>&order=date&sort=asc">Sort by Ascending</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php?view=articles<?php echo "$displayMod"; ?>&order=date&sort=desc">Sort by Descending</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </th>
        <!--<th>Date Created</th>-->

        <th>
            <ul class="sort-header">Image</ul>
        </th>


        <th class="content">
            <ul class="sort-header">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Content<b class="caret"></b></a>
                    <ul style="list-style: none;" class="dropdown-menu">
                        <li>
                            <a href="index.php?view=articles<?php echo "$displayMod"; ?>&order=content&sort=asc">Sort by Ascending</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php?view=articles<?php echo "$displayMod"; ?>&order=content&sort=desc">Sort by Descending</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </th>
        <!--<th>Content</th>-->


    </tr>
    </thead>
    <tbody>

    <?php
    if(isset($_GET['display'])) {

    }

    if(isset($_GET['display'])) {
        $display = $_GET['display'];
    } else {
        $display = '';  //If something typed in wrong, set to default.
    }


    //Get sort and order values, to pass to list function.
    if (isset($_GET['order'])) {
        $order = $_GET['order'];
        $paginationMod = "&order={$order}";
    } else {
        $paginationMod = "";
    }

    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        $paginationMod .= "&sort={$sort}";
    } else {
        $paginationMod = "";
    }

    switch($display) {
        case 'specialpages';  //index.php?view=articles&display=specialpages
            ?>
            <h1 class="page-header">
                Special Pages List
            </h1>
            <?php
            $catIDCheck = "="; //Used in SQL query of listArticles
            $pending = "0,1"; //List all pages since they are either 0 or 1.  Used for the View All Pages link.
            $articleCheck = '0'; //Not an article

            listArticles($pending, $catIDCheck, $articleCheck, $order, $sort);
            break;
        case 'pendingpages';  //index.php?view=articles&display=pendingpages
            ?>
            <h1 class="page-header">
                Pending Special Pages
            </h1>
            <?php
            $catIDCheck = "="; //Used in SQL query of listArticles
            $pending = "1"; //Only display pending pages.  Used for the Pending Pages link
            $articleCheck = '0'; //Not an article
            listArticles($pending, $catIDCheck, $articleCheck, $order, $sort);
            break;
        case 'archivedpages';  //index.php?view=articles&display=archivedpages
            ?>
            <h1 class="page-header">
                Archived Special Pages
            </h1>
            <?php
            $catIDCheck = "="; //Used in SQL query of listArticles
            $pending = "2"; //Only list archived special pages.
            $articleCheck = '0'; //Not an article
            listArticles($pending, $catIDCheck, $articleCheck, $order, $sort);
            break;
        case 'pendingarticles';  //index.php?view=articles&display=pendingarticles
            ?>
            <h1 class="page-header">
                Pending Articles
            </h1>
            <?php
            $catIDCheck = "<>"; //Used in SQL query of listArticles
            $pending = "1"; //Only display pending articles.  Used for the Pending Article link
            $articleCheck = '1'; //Is an article
            listArticles($pending, $catIDCheck, $articleCheck, $order, $sort);
            break;
        case 'archivedarticles';  //index.php?view=articles&display=archivedarticles
            ?>
            <h1 class="page-header">
                Archived Articles
            </h1>
            <?php
            $catIDCheck = "<>"; //Used in SQL query of listArticles
            $pending = "2"; //Only display archived articles.  Used for the archived Article link
            $articleCheck = '1'; //Is an article
            listArticles($pending, $catIDCheck, $articleCheck, $order, $sort);
            break;
        default:
            ?>
            <h1 class="page-header">
                Articles List
            </h1>

            <?php
            $catIDCheck = "<>"; //Used in SQL query of listArticles
            $pending = "0,1"; //List all articles since they are either 0 or 1.  Used for the View All Articles link.
            $articleCheck = '1'; //Is an article

            listArticles($pending, $catIDCheck, $articleCheck, $order, $sort);
            break;
    }
    ?>

    </tbody>
</table>

<!--Found in functions\adminFunctionsArticles.php -->
<?php changeArticleArchived() ?>
<?php changeArticleVisibility() ?>
<?php changeArticlePending() ?>
<?php deleteArticle() ?>
<?php duplicateArticle() ?>

<ul class="pager">
    <?php
    session_start();
    if(isset($_GET['view'])) {
        $view = $_GET['view'];
    }
    if(isset($_GET['display'])){
        $display = $_GET['display'];
    }
    else{
        $display = null;
    }
    $numPages = $_SESSION['numPages'];
    $page = $_SESSION['currentPage'];
    $nextPage = ($_SESSION['currentPage'] + 1);
    $prevPage = ($_SESSION['currentPage'] - 1);

    if ($numPages > 1) {

//PAGINATE ALL ARTICLES (WITH NO DISPLAY VALUE)
        if ($display == null) {
            if ($view == 'articles') {
                if ($page > 3 && $numPages > 5) {
                    echo "<li><a href='index.php?view=articles{$paginationMod}&page=1'data-toggle='tooltip' title='First Page'><strong><<</strong></a></li>";
                    echo "<li><a href='index.php?view=articles{$paginationMod}&page={$prevPage}'data-toggle='tooltip' title='Previous'><strong><</strong></a></li>";
                } elseif ($page > 1 && $numPages >= 5) {
                    echo "<li><a href='index.php?view=articles{$paginationMod}&page={$prevPage}'data-toggle='tooltip' title='Previous'><strong><</strong></a></li>";
                }
                if ($page > 1 && $numPages >= 5) {
                    echo "<li>------</li>";
                }
//HIGH
                if ($page <= $numPages - 2 && $page >= 3) {
                    $high = $page + 2;
                } elseif ($page < 3 && $numPages >= 5) {
                    $high = 5;
                } else {
                    $high = $numPages;
                }
//LOW
                if ($page > 2 && $page <= $numPages - 2) {
                    $low = $page - 2;
                } elseif ($page > 4 && $page > $numPages - 2) {
                    $low = $numPages - 4;
                } else {
                    $low = 1;
                }

                for ($i = $low; $i <= $high; $i++) {
                    if ($i == $page) {
                        echo "<li><a class='active_link' href='index.php?view=articles{$paginationMod}&page={$i}'data-toggle='tooltip' title='Page {$i}'><strong>$i</strong></a></li>";
                    } else {
                        echo "<li><a href='index.php?view=articles{$paginationMod}&page={$i}'data-toggle='tooltip' title='Page {$i}'>$i</a></li>";
                    }
                }

                if ($page < $numPages && $numPages >= 5) {
                    echo "<li>------</li>";
                }

                if ($page < $numPages - 2 && $numPages > 5) {
                    echo "<li><a href='index.php?view=articles{$paginationMod}&page={$nextPage}'data-toggle='tooltip' title='Next'><strong>></strong></a></li>";
                    echo "<li><a href='index.php?view=articles{$paginationMod}&page={$numPages}'data-toggle='tooltip' title='Last Page'><strong>>></strong></a></li>";
                } elseif ($page < $numPages && $numPages >= 5) {
                    echo "<li><a href='index.php?view=articles{$paginationMod}&page={$nextPage}'data-toggle='tooltip' title='Next'><strong>></strong></a></li>";
                }
            }
        }

//PAGINATE BASED ON DISPLAY VALUE
        else{
         if ($view == 'articles') {
             if ($page > 3 && $numPages >= 5) {
                 echo "<li><a href='index.php?view=articles&display=$display&page=1'data-toggle='tooltip' title='First Page'><strong><<</strong></a></li>";
                 echo "<li><a href='index.php?view=articles&display=$display&page={$prevPage}'data-toggle='tooltip' title='Previous'><strong><</strong></a></li>";
             } elseif ($page > 1 && $numPages >= 5) {
                 echo "<li><a href='index.php?view=articles&display=$display&page={$prevPage}'data-toggle='tooltip' title='Previous'><strong><</strong></a></li>";
             }
             if ($page > 1 && $numPages >= 5) {
                 echo "<li>------</li>";
             }
//HIGH
             if ($page <= $numPages - 2 && $page >= 3) {
                 $high = $page + 2;
             } elseif ($page < 3 && $numPages >= 5) {
                 $high = 5;
             } else {
                 $high = $numPages;
             }
//LOW
             if ($page > 2 && $page <= $numPages - 2) {
                 $low = $page - 2;
             } elseif ($page > 4 && $page > $numPages - 2) {
                 $low = $numPages - 4;
             } else {
                 $low = 1;
             }

             for ($i = $low; $i <= $high; $i++) {
                 if ($i == $page) {
                     echo "<li><a class='active_link' href='index.php?view=articles&display=$display{$paginationMod}&page={$i}'data-toggle='tooltip' title='Page {$i}'><strong>$i</strong></a></li>";
                 } else {
                     echo "<li><a href='index.php?view=articles&display=$display{$paginationMod}&page={$i}'data-toggle='tooltip' title='Page {$i}'>$i</a></li>";
                 }
             }

             if ($page < $numPages && $numPages >= 5) {
                 echo "<li>------</li>";
             }

             if ($page < $numPages - 2 && $numPages >= 5) {
                 echo "<li><a href='index.php?view=articles&display=$display{$paginationMod}&page={$nextPage}'data-toggle='tooltip' title='Next'><strong>></strong></a></li>";
                 echo "<li><a href='index.php?view=articles&display=$display{$paginationMod}&page={$numPages}'data-toggle='tooltip' title='Last Page'><strong>>></strong></a></li>";
             } elseif ($page < $numPages && $numPages >= 5) {
                 echo "<li><a href='index.php?view=articles&display=$display{$paginationMod}&page={$nextPage}'data-toggle='tooltip' title='Next'><strong>></strong></a></li>";
             }
         }
        }
    }
    ?>
</ul>