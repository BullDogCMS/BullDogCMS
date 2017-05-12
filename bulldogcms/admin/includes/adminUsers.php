<!--PHP page is a place holder and displays the included PHP page based on Action -->

<h1 class="page-header">
    Users
</h1>
<?php
if(isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = ''; //If something typed in wrong, set to default.
}
switch($action) {
    case 'adduser';
        include "adminUserAdd.php";
        break;
    case 'useredit';
        include "adminUserEdit.php";
        break;
    case 'profileEdit';
        include "adminUserProfile.php";
        break;
    default:
        include "adminUserList.php";
        break;
}

//Get sort values for dynamic links.
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

?>

<ul class="pager">
    <?php
    session_start();
    if(isset($_GET['action'])){
        $display = $_GET['action'];
    }
    else{
        $display = null;
    }
    $numPages = $_SESSION['numUsersPages'];
    $page = $_SESSION['currentUsersPage'];
    if ($display == null) {
        if ($numPages > 1) {
            for ($i = 1; $i <= $numPages; $i++) {
                if ($i == $page) {
                    echo "<li><a class='active_link' href='index.php?view=users{$paginationMod}&page={$i}'data-toggle='tooltip' title='Page {$i}'><strong>$i</strong></a></li>";
                } else {
                    echo "<li><a href='index.php?view=users{$paginationMod}&page={$i}'data-toggle='tooltip' title='Page {$i}'>$i</a></li>";
                }
            }
        }
    }
    ?>
</ul>