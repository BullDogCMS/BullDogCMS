<?php
session_start();
$timeout = 180; // Set timeout in minutes
$logout_redirect_url = "index.php"; // Set logout URL

$timeout = $timeout * 60; // Converts seconds to minutes
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
        session_destroy();
        header("Location: login.php");
    }
}
$_SESSION['start_time'] = time();

if(!isset($_SESSION['user']))

    if(!$_SESSION["username"])
    {
        //Do not show protected data, redirect to login...
        header('Location: login.php');
    }
?>


<!-- Admin Index details under the CMS since would not want site users to modify the code -->
<?php include "../../bulldogcms/admin/includes/adminHeader.php" ?>
<?php checkUserActive(); ?>
<?php
//Check if a user is logged in to allow in Admin section
if(!isset($_SESSION['username']))  {
    ?>
    <!--Should be able to use header(Location: ./login.php) but it is not working. -->
    <script type="text/javascript">
        window.location = "login.php";
    </script>
    <?php
}
?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "../../bulldogcms/admin/includes/adminNavigationTop.php" ?>
        <?php include "../../bulldogcms/admin/includes/adminNavigationSide.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <a href="#0" data-toggle='tooltip' title='Help' class="cd-btn"><span class='glyphicon glyphicon-info-sign'></span><span class='sr-only'>Help</span></a>
                        <?php
                        if(isset($_GET['view'])) {
                            $view = $_GET['view'];
                        } else {
                            $view= '';
                        }


                          IF( $_SESSION['roleID'] == 2){

                        switch($view) {

                            case 'navigations';
                                include "includes/adminNavigations.php";
                                $helpPageID = '18';
                                break;
                            case 'navedit';
                                include "includes/adminNavigationEdit.php";
                                $helpPageID = '1';
                                break;
                            case 'categories';
                                include "includes/adminCategories.php";
                                $helpPageID = '6';
                                break;
                            case 'articles';
                                include "includes/adminArticles.php";
                                $helpPageID = '4';
                                break;
                            case 'articleedit';
                                echo "<h1 class='page-header'>Edit Article</h1>";
                                include "includes/adminArticleEdit.php";
                                $helpPageID = '22';
                                break;
                            case 'lockcheck';
                                include "includes/adminArticleLockCheck.php";
                                $helpPageID = '1';
                                break;
                            case 'pageedit';
                                echo "<h1 class='page-header'>Edit Special Page</h1>";
                                include "includes/adminArticleEdit.php";
                                $helpPageID = '22';
                                break;
                            case 'sitesettings';
                                include "includes/adminSiteSettings.php";
                                $helpPageID = '19';
                                break;
                            case 'users';
                                include "includes/adminUsers.php";
                                $helpPageID = '7';
                                break;
                            case 'useredit';
                                include "includes/adminUserEdit.php";
                                $helpPageID = '13';
                                break;
                            case 'profileEdit';
                                include "includes/adminUserProfile.php";
                                $helpPageID = '11';
                                break;
                            case 'changePassword';
                                include "includes/adminChangePassword.php";
                                $helpPageID = '12';
                                break;
                            case 'changelog';
                                include "includes/adminChangeLog.php";
                                $helpPageID = '23';
                                break;
                            case 'catedit';
                                include "includes/adminCategoryEdit.php";
                                $helpPageID = '1';
                                break;
                            case 'linkedit';
                                include "includes/adminAsideLinksEdit.php";
                                $helpPageID = '1';
                                break;
                            case 'asidelinks';
                                include "includes/adminAsideLinks.php";
                                $helpPageID = '20';
                                break;
                            case 'asidesection';
                                include "includes/adminAsideSection.php";
                                $helpPageID = '5';
                                break;
                            case 'sitecolors';
                                include "includes/adminSiteColors.php";
                                $helpPageID = '14';
                                break;
                            case 'hpsettings';
                                include "includes/adminHomePageSettings.php";
                                $helpPageID = '15';
                                break;
                            case 'headersettings';
                                include "includes/adminHeaderSettings.php";
                                $helpPageID = '9';
                                break;
                            case 'footersettings';
                                include "includes/adminFooterSettings.php";
                                $helpPageID = '10';
                                break;
                            case 'helppages';
                                include "includes/adminHelpPages.php";
                                $helpPageID = '16';
                                break;
                            case 'helppageedit';
                                include "includes/adminHelpPageEdit.php";
                                $helpPageID = '1';
                                break;
                            case 'googleanalytics';
                                include "includes/googleAnalytics.php";
                                $helpPageID = '1';
                                break;
                            default:
                                include "includes/adminDashboard.php";
                                $helpPageID = '2';
                                break;
                        }

                            }
                        Else{
                       // Display what Contributor can see

                            switch($view) {

                                case 'articles';
                                include "includes/adminArticles.php";
                                $helpPageID = '4';
                                break;
                                case 'articleedit';
                                    echo "<h1 class='page-header'>Edit Article</h1>";
                                    include "includes/adminArticleEdit.php";
                                    $helpPageID = '1';
                                    break;
                                case 'lockcheck';
                                    include "includes/adminArticleLockCheck.php";
                                    $helpPageID = '1';
                                    break;
                                case 'pageedit';
                                    echo "<h1 class='page-header'>Edit Special Page</h1>";
                                    include "includes/adminArticleEdit.php";
                                    $helpPageID = '1';
                                    break;
                                case 'profileEdit';
                                    include "includes/adminUserProfile.php";
                                    $helpPageID = '11';
                                    break;
                                case 'changePassword';
                                    include "includes/adminChangePassword.php";
                                    $helpPageID = '12';
                                    break;
                                case 'linkedit';
                                    include "includes/adminAsideLinksEdit.php";
                                    $helpPageID = '1';
                                    break;
                                case 'asidelinks';
                                    include "includes/adminAsideLinks.php";
                                    $helpPageID = '20';
                                    break;
                                case 'asidesection';
                                    include "includes/adminAsideSection.php";
                                    $helpPageID = '5';
                                    break;
                                default:
                                    include "includes/adminDashboard.php";
                                    $helpPageID = '2';
                                    break;
                            }
                        }

                        ?>
                        <?php helpPageView($helpPageID); ?>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "../../bulldogcms/admin/includes/adminFooter.php" ?>
