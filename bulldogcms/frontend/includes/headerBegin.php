<?php include "functions.php"; ?>
<?php
//This code is for adding the site settings global variables to be used by the front end pages. -Micah
//Somewhere better to put this query so not running everytime Header loads?  Maybe Require once in index.php? -LG
$siteSettingsQuery = "SELECT * FROM siteSettings WHERE siteSettingID = '1'";
$selectSiteSettings = mysqli_query($connection, $siteSettingsQuery);

//Setting variables as GLOBAL so can be used on other pages
while($row = mysqli_fetch_assoc($selectSiteSettings)) {
    $GLOBAL['siteName'] = $row['siteName'];
    //$GLOBAL['siteHeroic'] = $row['siteHeroic'];
    //$GLOBAL['siteView'] = $row['siteView'];
    $GLOBAL['siteEmail'] = $row['siteEmail'];
    $GLOBAL['siteSearch'] = $row['siteSearch'];
    $GLOBAL['articleSubmission'] = $row['articleSubmission'];
    $GLOBAL['enableLinks'] = $row['enableLinks'];
    $GLOBAL['enableNews'] = $row['enableNews'];
    $GLOBAL['enableLatestArticles'] = $row['enableLatestArticles'];
    $GLOBAL['enableEvents'] = $row['enableEvents'];
    $GLOBAL['enableSideWidget'] = $row['enableSideWidget'];
    $GLOBAL['enableAuthorNames'] = $row['enableAuthorNames'];
    $GLOBAL['googleAnalyticsID'] = $row['googleAnalyticsID'];
    $GLOBAL['enableFullName'] = $row['enableFullName'];
    //$GLOBAL['paginationLength'] = $row['paginationLength'];
    //echo "<title>{$GLOBAL['siteName']}</title>";

}
//Code for setting the col number for the body pages. If any of the asides are on then the body col will be 8 otherwise 12(full width). -Micah
IF ($GLOBAL['enableLinks'] OR $GLOBAL['enableSideWidget'] OR $GLOBAL['siteSearch']
        OR $GLOBAL['enableNews'] OR $GLOBAL['enableLatestArticles'] OR $GLOBAL['enableEvents'])
{$GLOBAL['colNumberForAsideOption'] = '8';} ELSE { $GLOBAL['colNumberForAsideOption'] = '12';}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $GLOBAL['siteName']; ?></title>





