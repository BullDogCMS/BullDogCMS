<?php

    $footerQuery = "SELECT * FROM footerLayout WHERE footerID = '1'";
    $selectFooter = mysqli_query($connection, $footerQuery);

    confirmQuery($selectFooter);

    while ($row = mysqli_fetch_assoc($selectFooter)) {
        $footerTitle = htmlentities($row['footerTitle'], ENT_QUOTES, 'UTF-8');
        $footerLogoImg = $row['footerLogoImg'];
        $footerHeight = $row['footerHeight'];
        $footerTextArea1 = htmlentities($row['footerTextArea1'], ENT_QUOTES, 'UTF-8');
        $footerTextArea2 = htmlentities($row['footerTextArea2'], ENT_QUOTES, 'UTF-8');
    }

?>

<footer>
    <div class="row">
        <div class="container">
            <!-- TODO - Need to add conditional queries for if text area and social media is populated. Logo/Title and nav should always be there. -->
            <div class="col-xs-12 col-sm-6 col-md-3 footSection"> <!--logo and title text (Format same as header)-->
                <?php
                if (isset($footerLogoImg) && $footerLogoImg != '' && file_exists('uploads/' . $footerLogoImg))
                    echo "<img class='headerLogo' src='uploads/{$footerLogoImg}' alt='footerLogoImg'>";

                if (isset($footerTitle) && $footerTitle != '')
                    echo "&nbsp;{$footerTitle}";
                ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 footSection"> <!--text area-->
                <?php
                if (isset($footerTextArea1) && $footerTextArea1 != '')
                    echo "{$footerTextArea1}";
                ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 footSection vertNav">
                <div class="navbar-inverse navbar-footer">
                    <!--<ul class="nav navbar-nav-footer">-->
                    <ul class="nav navbar-nav-footer">
                        <?php
                        findAllFooterNavigations();
                        ?>
                    </ul>
                </div>
            </div>
<!--            <div class="col-xs-12 col-sm-6 col-md-3 footSection"></div><!--social media option (need icons for popular social media sites-->
        </div>
        <!-- /.container -->
    </div>
    <div class="row">
        <div class="col-xs-12">
            <p class="small">Powered by bullDog CMS &copy</p>
        </div>
    </div>
    <!-- /.row -->


