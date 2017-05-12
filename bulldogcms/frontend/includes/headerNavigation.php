<?php

    $headerQuery = "SELECT * FROM headerLayout WHERE headerID = '1'";
    $selectHeader = mysqli_query($connection,$headerQuery);

    confirmQuery($selectHeader);

    while($row = mysqli_fetch_assoc($selectHeader)) {
        $headerTitle = htmlentities($row['headerTitle'], ENT_QUOTES, 'UTF-8');//escaping for html display
        $headerLogoImg = $row['headerLogoImg'];
        $headerHeight = $row['headerHeight'];
        $headerHTML = $row['headerHTML'];
        $floatHeader = $row['floatHeader'];
        $headerTextArea1 = htmlentities($row['headerTextArea1'], ENT_QUOTES, 'UTF-8');//escaping for html display
    }

    $heightString = $headerHeight .'px';

    /*if ($floatHeader == 0)
        echo "<nav class='navbar navbar-inverse navbar' role='navigation' style='border: 0; min-height:$heightString; top: -225px'>";
    else*/
        echo "<nav class='navbar navbar-inverse navbar navbar-fixed-top' role='navigation' style='border: 0; min-height:$heightString'>";

?>
<!--<link rel="stylesheet" href="/css/w3.css" >-->
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <?php
            if(isset($headerLogoImg) && $headerLogoImg != '') {
                echo "<a class='navbar-brand' href='index.php'><img class='headerLogo' src='../uploads/{$headerLogoImg}' alt='headerLogo'>";
            }
            if(isset($headerTitle) && $headerTitle != ''){
                echo "<h1 class='headerTitle'>&nbsp;$headerTitle</h1>";
            }
            echo "</a>"
            ?>


        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                findAllNavigations();
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->

    <div class="row">
        <?php
/*        if ($headerHeight >= 200) {
            echo "<div class='w3-col s6 w3-container' style='width:50%'>$headerHTML</div>";
            echo "<div class='w3-col s6 w3-container' style='width:50%'>$headerTextArea1</div>";
        }
        */?>
        <?php
            if(isset($headerHTML) && $headerHTML != ''){
                echo "<div class='container-fluid header-row'>";
                if(isset($headerTextArea1) && $headerTextArea1 != ''){
                    echo "<div class='col-xs-12 col-sm-6 text-left'><p class='c-sm'>$headerHTML</p></div>";
                    echo "<div class='col-xs-12 col-sm-6 text-right'><p class='c-sm'>$headerTextArea1</p></div>";
                }
                else{
                    echo "<div class='col-xs-12 text-center'>$headerHTML</div>";
                }
                echo "</div>";
            } else if(isset($headerTextArea1) && $headerTextArea1 != ''){
                echo "<div class='container-fluid header-row right-under-nav'><div class='col-xs-12 text-right'>$headerTextArea1</div></div>";
            }
        ?>
    </div>
</nav>
