
<!-- The global variable is inserting the correct number for the css page to display the correct size if the asides are off -->


    <?php

    $query = "SELECT bodyContent FROM bodySettings WHERE bodySettingID = '1' ";
    $selectContent = mysqli_query($connection, $query);

    confirmQuery($selectContent);

    while($row = mysqli_fetch_assoc($selectContent)) {
        $bodyContent = $row['bodyContent'];

        ?>
        <p>
            <?php echo $bodyContent;
            }
            ?>
        </p>

