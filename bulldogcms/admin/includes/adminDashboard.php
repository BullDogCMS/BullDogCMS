<!--Dashboard screen in Admin Console -->
<!--
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
-->
<h1 class="page-header">
    BullDogCMS Admin

</h1>

<!-- /.row -->

<!--<div class="row">-->
<div class ="col-xs-12">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-newspaper-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                        <?php
                        //$query = "SELECT * FROM articles WHERE categoryID <> '1' ";
                        $query = "SELECT * FROM articles a";
                        $query .= " JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID";
                        $query .= " WHERE at.articlePending <> '2' AND a.categoryID <> '1'"; //No archived or special pages
                        $selectAllArticles = mysqli_query($connection, $query);
                        $pendingCounts = mysqli_num_rows($selectAllArticles);
                        echo "<div class='huge'>{$pendingCounts}</div>"
                          /*  $query = "SELECT * FROM articles WHERE categoryID <> '1' AND articleVisible = '1'";
                            $selectAllArticles = mysqli_query($connection, $query);
                            $articlesCounts = mysqli_num_rows($selectAllArticles);
                            echo "<div class='huge'>{$articlesCounts}</div>"
                            */
                        ?>
                        <div>Articles</div>
                    </div>
                </div>
            </div>
            <a href="./index.php?view=articles">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-newspaper-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                        <?php
                        /*$query = "SELECT * FROM articles WHERE categoryID <> '1' AND articleVisible = '0'";
                        $selectAllArticles = mysqli_query($connection, $query);
                        $pendingCounts = mysqli_num_rows($selectAllArticles);
                        echo "<div class='huge'>{$pendingCounts}</div>"
                                */
                        $query = "SELECT * FROM articles a";
                        $query .= " JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID";
                        $query .= " WHERE at.articlePending = '1' AND a.categoryID <> '1'";
                        //$query = "SELECT * FROM articles WHERE categoryID <> '1' AND articleVisible = '1'";
                        $selectAllArticles = mysqli_query($connection, $query);
                        $articlesCounts = mysqli_num_rows($selectAllArticles);
                        echo "<div class='huge'>{$articlesCounts}</div>"
                        ?>
                        <div><i class="fa fa-fw fa-exclamation-triangle"></i>Pending Articles</div>
                    </div>
                </div>
            </div>
            <a href="index.php?view=articles&display=pendingarticles">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                        <?php
                        //$query = "SELECT * FROM articles Where categoryID = 1 ";
                        $query = "SELECT * FROM articles a";
                        $query .= " JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID";
                        $query .= " WHERE at.articlePending <> '2' AND a.categoryID = '1'"; //No archived or articles
                        $selectAllArticles = mysqli_query($connection, $query);
                        $specialPagesCounts = mysqli_num_rows($selectAllArticles);
                        echo "<div class='huge'>{$specialPagesCounts}</div>"

                        ?>
                        <div>Special Pages</div>
                    </div>
                </div>
            </div>
            <a href="index.php?view=articles&display=specialpages">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                        <?php
                        //$query = "SELECT * FROM articles Where categoryID = 1 ";
                        $query = "SELECT * FROM articles a";
                        $query .= " JOIN articleTransactions at ON a.articleID = at.articleID and a.articleTransactionID = at.transactionID";
                        $query .= " WHERE at.articlePending = '1' AND a.categoryID = '1'"; //Pending but not an article
                        $selectAllArticles = mysqli_query($connection, $query);
                        $specialPagesCounts = mysqli_num_rows($selectAllArticles);
                        echo "<div class='huge'>{$specialPagesCounts}</div>"

                        ?>
                        <div><i class="fa fa-fw fa-exclamation-triangle"></i>Pending Special Pages</div>
                    </div>
                </div>
            </div>
            <a href="index.php?view=articles&display=pendingpages">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                        <?php
                        $query = "SELECT * FROM users";
                        $selectAllUsers = mysqli_query($connection, $query);
                        $usersCounts = mysqli_num_rows($selectAllUsers);
                        echo "<div class='huge'>{$usersCounts}</div>"

                        ?>

                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="index.php?view=users">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

<!-- /.row -->
<div class="row">

    <!-- /.row -->
    <div class ="row"></div>

</div>

    <?php include "googleAnalytics.php"; ?>

</div>


