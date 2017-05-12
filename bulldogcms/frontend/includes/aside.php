


    <!-- Get site settings from database -->
    <?php //This code gets the site settings from the global variables initialized in headerbegin.php -Micah


    $enableSideWidget =   $GLOBAL['enableSideWidget'];
    $enableLinks = $GLOBAL['enableLinks'];
    $enableNews = $GLOBAL['enableNews'];
    $enableEvents = $GLOBAL['enableEvents'];
    $siteSearch = $GLOBAL['siteSearch'];
    $enableLatestArticles = $GLOBAL['enableLatestArticles'];
    $asideAnyEnabled = ($enableSideWidget OR $enableLinks OR $siteSearch OR $enableNews OR $enableEvents OR $enableLatestArticles);

    // If any of these variables are 1 then that aside option will show on the website. -Micah
    // If any of these variables are 0 then that aside option will be passed over on the website. -Micah
    ?>
    <?php IF ($asideAnyEnabled) : ?>
    <div class="col-md-4 col-xs-12 aside">

        <!-- Side Widget Well -->
        <?php IF ($enableSideWidget) :  // If statement that surrounds the side widget well html that will hide it based on the
                                        //  variable. -Micah ?>
            <?php

            $asideSection = "SELECT * FROM asideSection WHERE asideSectionID = '1'";
            $asideSectionQuery = mysqli_query($connection,$asideSection);

            confirmQuery($asideSectionQuery);

            while($row = mysqli_fetch_assoc($asideSectionQuery)) {
                $asideHeader = htmlentities($row['asideHeader'], ENT_QUOTES, 'UTF-8');//html escaped for display
                $asideText = $row['asideText'];//editor takes care of escaping
            }
            ?>
        <div class="well">
            <h4><?php if(isset($asideHeader)) {echo $asideHeader;} ?></h4>
            <p><?php if(isset($asideText)) {echo $asideText;} ?></p>
        </div>
        <?php ENDIF; //Other end of the if statement surrounding the side widget well html -Micah?>
        <!-- Latest Articles -->
        <?php IF ($enableLatestArticles) : ?>
            <div class="well">
                <h4>Latest Articles</h4>
                <ul class="list-styled">
                    <?php latestArticles(); ?>
                </ul>
            </div>
        <?php ENDIF; ?>
        <!-- Events -->
        <?php IF ($enableEvents) : ?>
            <div class="well">
                <h4>Events</h4>
                <ul class="list-styled">
                    <?php listEvents(); ?>
                </ul>
            </div>
        <?php ENDIF; ?>

        <?php IF ($enableNews) :   // If statement that surrounds the links well html that will hide it based on the
            //  variable. -Micah ?>
            <div class="well">
                <h4>News</h4>
                <ul class="list-styled">
                    <?php listNews(); ?>
                </ul>
            </div>
        <?php ENDIF; //Other end of the if statement surrounding the links well html -Micah?>

        <!-- Blog Links Well -->
        <?php IF ($enableLinks) :   // If statement that surrounds the links well html that will hide it based on the
                                    //  variable. -Micah ?>
        <div class="well">
            <h4>Links</h4>
            <ul class="list-styled">
                <?php listLinks(); ?>
            </ul>
        </div>
        <?php ENDIF; //Other end of the if statement surrounding the links well html -Micah?>
    <?php ENDIF; //End of the if statement if all three are blank -Micah?>
    </div>
