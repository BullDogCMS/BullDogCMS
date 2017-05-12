<?php ob_start(); ?> <!--For buffering request in header to send all data as a batch-->
<?php include "adminFunctions.php"; ?>
<?php session_start(); ?>
<?php
//Used for Article Pending process to automatically approve or not
$siteSettingsQuery = "SELECT * FROM siteSettings WHERE siteSettingID = '1'";
$selectSiteSettings = mysqli_query($connection, $siteSettingsQuery);
while($row = mysqli_fetch_assoc($selectSiteSettings)) {
$GLOBAL['articleSubmission'] = $row['articleSubmission'];
//$GLOBAL['paginationLength'] = $row['paginationLength'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>bullDog CMS Admin Console</title>

    <!-- Bootstrap Core CSS -->
<!--    <link href="css/bootstrap.min.css" rel="stylesheet">-->

    <!-- Custom CSS -->
<!--    <link href="css/sb-admin.css" rel="stylesheet">-->

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- Other Custom CSS -->
<!--	<link href="css/adminStyles.css" rel="stylesheet">-->

    <!-- Fancy Box for Image Uploader -->
    <link href="js/plugins/fancybox/jquery.fancybox.css" rel="stylesheet" media="screen">

    <!-- Admin Styles -->
    <link href="css/adminSpecificStyles.php" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body>
