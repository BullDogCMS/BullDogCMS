<?php

//Set searchMod default to blank value.
$searchMod = "";
//Get sort / search values for dynamic links.
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

//Search Changelog based on page
 if(isset($_GET['searchtype'])) {
    //If already searched, generate variable for dynamic pagination and sort links.
    $searchMod = "&searchtype=" . $_GET['searchtype'] . "&searchterm=" . $_GET['searchterm'];

}
if (isset($_POST['search'])) {

     $searchMod = "&searchtype=" . $_POST['searchtype'] . "&searchterm=" . $_POST['searchterm'];

     ?>
     <script type="text/javascript">
         window.location = "index.php?view=changelog<?php echo "$searchMod"; ?>";   //Refreshes page
     </script>
     <?php

 }

if (isset($_POST['export'])) {

    //$query = "SELECT * FROM changeLog";
    //$result = mysqli_query($connection, $query);

    //https://github.com/PHPOffice/PHPExcel

//include "../admin/changeLogExport.php";

    //Trick to bypass preset headers:  http://stackoverflow.com/questions/8028957/how-to-fix-headers-already-sent-error-in-php
    //echo("<script>location.href = '../admin/changeLogExport.php';</script>");

/*
    $filename = date('m-d-y') . "changelog.csv";

    header("Content-type: text/csv");
    header("Content-Disposition: attachment; $filename.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    //get all changelog values.
    $changelog = "SELECT * FROM changeLog";
    $changelogQuery = mysqli_query($connection, $changelog);
    confirmQuery($changelogQuery);


    $f = fopen('php://temp/', 'wt');
    $first = true;
    while($row = mysqli_fetch_assoc($changelogQuery)) {
        if ($first) {
            fputcsv($f, array_keys($row));
            $first = false;
        }
        fputcsv($f, $row);
    }

    //close db connection after transaction.
    mysqli_close($connection);
    rewind($f);

    echo $filename;
    fpassthru($f);
    exit;
    */
}

ELSE if (isset($_POST['delete'])) {
    global $connection;

    //Attempt to delete from articles table.
    $query1 = "DELETE FROM changeLog";
    $DeleteQuery1 = mysqli_multi_query($connection, $query1);
    confirmquery($DeleteQuery1);

    $changedTable = "changelog";
    $changeDetails = "Changelog was purged.";

    insertChangeLog($_SESSION['userID'], $changedTable, $changeDetails);

    mysqli_close($connection);

    ?>
    <script type="text/javascript">
        window.location = "index.php?view=changelog";   //Refreshes page
    </script>

    <?php
}
ELSE {
    ?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="search-group">
        <input class= "txt-search" type="text" name ="searchterm" placeholder="Search Term...">
        <select class="select-search" name="searchtype">
            <option value="select">Search Type...</option>
            <option value="changeby">Changed By</option>
            <option value="table">Table</option>
            <option value="details">Details</option>
        </select>
        <button class="btn-search" type="submit" name="search" value="Search">
        <span class="glyphicon glyphicon-search" name="span-search"></span></button>
    </div>

    <table class = "table table-hover">
        <thead>
            <tr>
                <th>
                    <ul class="sort-header">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Changed By<b class="caret"></b></a>
                            <ul style="list-style: none;" class="dropdown-menu">
                                <li>
                                    <a href="index.php?view=changelog&order=changeby&sort=asc<?php echo "$searchMod"; ?>">Sort by Ascending</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="index.php?view=changelog&order=changeby&sort=desc<?php echo "$searchMod"; ?>">Sort by Descending</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </th>
                <!--<th>Title</th>-->


                <th>
                    <ul class="sort-header">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Table<b class="caret"></b></a>
                            <ul style="list-style: none;" class="dropdown-menu">
                                <li>
                                    <a href="index.php?view=changelog&order=table&sort=asc<?php echo "$searchMod"; ?>">Sort by Ascending</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="index.php?view=changelog&order=table&sort=desc<?php echo "$searchMod"; ?>">Sort by Descending</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </th>
                <!--<th>Category</th>-->

                <th class="description">
                    <ul class="sort-header">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Details<b class="caret"></b></a>
                            <ul style="list-style: none;" class="dropdown-menu">
                                <li>
                                    <a href="index.php?view=changelog&order=details&sort=asc<?php echo "$searchMod"; ?>">Sort by Ascending</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="index.php?view=changelog&order=details&sort=desc<?php echo "$searchMod"; ?>">Sort by Descending</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </th>
                <!--<th>Author</th>-->

                <th>
                    <ul class="sort-header">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Date<b class="caret"></b></a>
                            <ul style="list-style: none;" class="dropdown-menu">
                                <li>
                                    <a href="index.php?view=changelog&order=date&sort=asc<?php echo "$searchMod"; ?>">Sort by Ascending</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="index.php?view=changelog&order=date&sort=desc<?php echo "$searchMod"; ?>">Sort by Descending</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php listChangeLog() ?>
        </tbody>
    </table>

    <div>
        <a href="../admin/changeLogExport.php" class="btn btn-primary" type="submit" name="export" data-toggle="tooltip" title="Export all changelog entries">Export Changelog</a>
        <input class="btn btn-primary" type="submit" name="delete" value="Delete Changelog" data-toggle="tooltip" title="Delete all changelog entries" onClick="javascript:return confirm('Are you sure you want to delete all changelog entries? This cannot be undone.');">
    </div>

    <ul class="pager">
        <?php
        session_start();

        $numPages = $_SESSION['numLogPages'];
        $page = $_SESSION['currentLogPage'];
        $nextPage = ($_SESSION['currentLogPage'] + 1);
        $prevPage = ($_SESSION['currentLogPage'] - 1);
        if ($numPages > 1) {
                if ($page > 3 && $numPages > 5){
                    echo "<li><a href='index.php?view=changelog{$paginationMod}{$searchMod}&page=1'data-toggle='tooltip' title='First Page'><strong><<</strong></a></li>";
                    echo "<li><a href='index.php?view=changelog{$paginationMod}{$searchMod}&page={$prevPage}'data-toggle='tooltip' title='Previous'><strong><</strong></a></li>";
                }elseif ($page > 1 && $numPages > 5) {
                    echo "<li><a href='index.php?view=changelog{$paginationMod}{$searchMod}&page={$prevPage}'data-toggle='tooltip' title='Previous'><strong><</strong></a></li>";
                }

            if ($page > 1 && $numPages > 5) {
                echo "<li>------</li>";
            }
    //HIGH
            if ($page <= $numPages - 2 && $page >= 3) {
                $high = $page + 2;
            }
            elseif ($page < 3 && $numPages >= 5){
                $high = 5;
            }
            else {
                $high = $numPages;
            }
    //LOW
                if ($page > 2 && $page <= $numPages - 2) {
                    $low = $page - 2;
                }
                elseif ($page > $numPages - 2 && $numPages >= 5){
                    $low = $numPages - 4;
                }
                else {
                    $low = 1;
                }
    //PAGINATE
            for ($i = $low; $i <= $high; $i++) {
                if ($i == $page) {
                    echo "<li><a class='active_link' href='index.php?view=changelog{$paginationMod}{$searchMod}&page={$i}'data-toggle='tooltip' title='Page {$i}'><strong>$i</strong></a></li>";
                }
                else {
                    echo "<li><a href='index.php?view=changelog{$paginationMod}{$searchMod}&page={$i}'data-toggle='tooltip' title='Page {$i}'>$i</a></li>";
                }
            }
            if ($page < $numPages && $numPages > 5) {
                echo "<li>------</li>";
            }

            if ($page < $numPages - 2 && $numPages > 5){
                echo "<li><a href='index.php?view=changelog{$paginationMod}{$searchMod}&page={$nextPage}'data-toggle='tooltip' title='Next'><strong>></strong></a></li>";
                echo "<li><a href='index.php?view=changelog{$paginationMod}{$searchMod}&page={$numPages}'data-toggle='tooltip' title='Last Page'><strong>>></strong></a></li>";
            }elseif ($page < $numPages && $numPages > 5) {
                echo "<li><a href='index.php?view=changelog{$paginationMod}{$searchMod}&page={$nextPage}'data-toggle='tooltip' title='Next'><strong>></strong></a></li>";
            }
        }
        ?>
    </ul>
</form>
<?php } ?>