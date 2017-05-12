<?php

function listSection() {
    global $connection;

    $query = "SELECT * FROM asideSection";
    $selectsection = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($selectsection)) {
        $asideSectionID = $row['asideSectionID'];
        $asideHeader = htmlentities($row['asideHeader'], ENT_QUOTES, 'UTF-8');
        $asideText = $row['asideText'];


            echo "<tr>";
        echo "<td>
        <a href ='index.php?view=asidesection&delete={$asideSectionID}' data-toggle='tooltip' title='Delete' 
        onClick=\"javascript:return confirm('are you sure you want to delete this?');\">
        <span class='glyphicon glyphicon-trash'></span><span class='sr-only'>Delete</span></a>
	    <a href ='index.php?view=sectionedit&edit={$asideSectionID}' data-toggle='tooltip' title='View & Edit'>
	        <span class='glyphicon glyphicon-pencil'></span><span class='sr-only'>Edit</span></a></td>";
            echo "<td>{$asideHeader}</td>";
            echo "<td>{$asideText}</td>";
            echo "</tr>";


    }
}

function updatesection($asideSectionID){
    global $connection;

//update Links Table

    if (isset($_POST['updatesection'])) {

        $asideHeader = mysqli_real_escape_string($connection, $_POST['asideHeader']);
        $asideText = mysqli_real_escape_string($connection, $_POST['asideText']);


        $query = "UPDATE asideSection SET asideHeader = '$asideHeader', asideText = '$asideText' WHERE asideSectionID= '$asideSectionID'";
        mysqli_query($connection, $query);

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=asidesection";   //Refreshes page
        </script>
        <?php
    }
}