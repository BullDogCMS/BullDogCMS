<?php

If ($_GET['author'] == $_SESSION['userID'] or $_SESSION['roleID'] == '2'){

    //Get values for view and display, to dynamically update links depending on origin page.
    if(isset($_GET['originview'])) {
        $originView = "&originview=" . $_GET['originview'];
        $returnView = "view=" . $_GET['originview'];
    }

    if(isset($_GET['origindisplay'])) {
        $originDisplay = "&origindisplay=" . $_GET['origindisplay'];
        $returnDisplay = "&display=" . $_GET['origindisplay'];

    } else {
        $originDisplay = "";
    }

    $articleID = $_GET['edit'];
    $transactionID = $_GET['transaction'];

    echo "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign'></span> This article is locked. By continuing, any unsaved changes could be lost. Are you sure you want to make changes?</div>";

    echo "<tr>";
    echo "<td><a href ='index.php?{$returnView}{$returnDisplay}'>
			<span class='btn btn-primary'>Cancel</span><span class='sr-only'>Cancel</span></a>";
    echo "<td><a href ='index.php?view=articleedit&edit={$articleID}&transaction={$transactionID}{$originView}{$originDisplay}'>
			<span class='btn btn-primary'>Confirm</span><span class='sr-only'>Confirm</span></a>";
    echo "</tr>";

} else {

    echo "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign'></span> Sorry, this article currently locked. Please try again later.</div>";
    echo "<a href ='index.php?view=articles'>
			<span class='btn btn-primary'>Cancel</span><span class='sr-only'>Cancel</span>";
    //echo "<td>{$articlePending}</td>";

}