-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Host: db661547685.db.1and1.com
-- Generation Time: Apr 24, 2017 at 11:43 AM
-- Server version: 5.5.54-0+deb7u2-log
-- PHP Version: 5.4.45-0+deb7u8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db661547685`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `articleID` int(10) NOT NULL AUTO_INCREMENT,
  `categoryID` int(10) NOT NULL,
  `articleTransactionID` int(10) NOT NULL,
  `articleAuthorID` int(10) NOT NULL,
  `articleCreateDate` datetime NOT NULL,
  `articleVisible` tinyint(1) NOT NULL,
  `articleLock` tinyint(1) NOT NULL,
  PRIMARY KEY (`articleID`),
  KEY `FK_articles1` (`categoryID`),
  KEY `FK_articles2` (`articleTransactionID`),
  KEY `FK_articles3` (`articleAuthorID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`articleID`, `categoryID`, `articleTransactionID`, `articleAuthorID`, `articleCreateDate`, `articleVisible`, `articleLock`) VALUES
(1, 2, 1, 1, '2017-04-21 15:37:28', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `articleTransactions`
--

CREATE TABLE IF NOT EXISTS `articleTransactions` (
  `transactionID` int(10) NOT NULL AUTO_INCREMENT,
  `articleID` int(10) NOT NULL,
  `transactionAuthorID` int(10) NOT NULL,
  `articleTitle` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `articleContent` text COLLATE latin1_general_ci NOT NULL,
  `articleImage` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `fileName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `articleTags` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `articlePending` tinyint(4) NOT NULL DEFAULT '1',
  `transactionDate` datetime NOT NULL,
  `articleVersionID` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`transactionID`),
  KEY `FK_at1` (`articleID`),
  KEY `FK_at2` (`transactionAuthorID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `articleTransactions`
--

INSERT INTO `articleTransactions` (`transactionID`, `articleID`, `transactionAuthorID`, `articleTitle`, `articleContent`, `articleImage`, `fileName`, `articleTags`, `articlePending`, `transactionDate`, `articleVersionID`) VALUES
(1, 1, 1, 'Example Article', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p><img src="../uploads/images/Logo1.png?1492803401091" alt="Logo1" /></p>\r\n<p>This is an example article tied to the ExampleCat1 category which is under the ExampleNav navigation.</p>\r\n</body>\r\n</html>', 'images/Logo2.png', '', 'example article', 0, '2017-04-21 15:37:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `asideSection`
--

CREATE TABLE IF NOT EXISTS `asideSection` (
  `asideSectionID` int(10) NOT NULL AUTO_INCREMENT,
  `asideHeader` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `asideText` text COLLATE latin1_general_ci,
  PRIMARY KEY (`asideSectionID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `asideSection`
--

INSERT INTO `asideSection` (`asideSectionID`, `asideHeader`, `asideText`) VALUES
(1, 'Aside Header', 'Aside section text here');

-- --------------------------------------------------------

--
-- Table structure for table `bodySettings`
--

CREATE TABLE IF NOT EXISTS `bodySettings` (
  `bodySettingID` int(10) NOT NULL AUTO_INCREMENT,
  `bodyView` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `bodyHeroic` tinyint(1) NOT NULL,
  `heroicImage` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `heroicHeader` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `heroicText1` text COLLATE latin1_general_ci,
  `bodyText` tinyint(1) NOT NULL DEFAULT '1',
  `fpEnableCategories` tinyint(1) NOT NULL DEFAULT '1',
  `fpEnableArticles` tinyint(1) NOT NULL DEFAULT '1',
  `fpOrder` tinyint(1) NOT NULL DEFAULT '0',
  `bodyContent` text COLLATE latin1_general_ci,
  `fpPagLength` int(10) NOT NULL DEFAULT '5',
  PRIMARY KEY (`bodySettingID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bodySettings`
--

INSERT INTO `bodySettings` (`bodySettingID`, `bodyView`, `bodyHeroic`, `heroicImage`, `heroicHeader`, `heroicText1`, `bodyText`, `fpEnableCategories`, `fpEnableArticles`, `fpOrder`, `bodyContent`, `fpPagLength`) VALUES
(1, 'includes/categoryList.php', 0, 'bullDogCMSHero.jpg', NULL, NULL, 1, 1, 1, 0, '<h1>Welcome to BullDog CMS</h1>', 5);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `categoryID` int(10) NOT NULL AUTO_INCREMENT,
  `navigationID` int(10) NOT NULL,
  `categoryName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `categoryImage` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `categoryContent` text COLLATE latin1_general_ci,
  `categoryOrder` int(3) NOT NULL,
  `categoryVisible` tinyint(1) NOT NULL,
  `categoryTypeID` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`categoryID`),
  KEY `FK_categories` (`navigationID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `navigationID`, `categoryName`, `categoryImage`, `categoryContent`, `categoryOrder`, `categoryVisible`, `categoryTypeID`) VALUES
(1, 0, 'Special Page', NULL, NULL, 1, 1, 1),
(2, 2, 'ExampleCat1', 'images/Logo2.png', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>This is an example of a category that can have articles.</p>\r\n</body>\r\n</html>', 1, 1, 1),
(3, 2, 'ExampleCat2', 'images/Logo2_v3.png', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>This is an example of a Category that will not have articles.&nbsp; It is just a single page with text and images under the navigation.&nbsp; This is good for a single page that would be under a Navigation, but not its own Navigation.&nbsp; A Special Page is a Navigation link for pages like About Us, Contact Us, etc.</p>\r\n</body>\r\n</html>', 2, 1, 2),
(4, 3, 'Event 1', 'images/Logo2_v2.png', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>An example of an Event.&nbsp; It is a single page that does not allow articles.</p>\r\n</body>\r\n</html>', 1, 1, 3),
(5, 3, 'Event 2', 'images/Logo2_v2.png', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Another example of an event.</p>\r\n</body>\r\n</html>', 2, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `categoryType`
--

CREATE TABLE IF NOT EXISTS `categoryType` (
  `categoryTypeID` int(10) NOT NULL AUTO_INCREMENT,
  `categoryTypeName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`categoryTypeID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categoryType`
--

INSERT INTO `categoryType` (`categoryTypeID`, `categoryTypeName`) VALUES
(1, 'Allow Articles'),
(2, 'Single Page'),
(3, 'Event');

-- --------------------------------------------------------

--
-- Table structure for table `changeLog`
--

CREATE TABLE IF NOT EXISTS `changeLog` (
  `changeID` int(10) NOT NULL AUTO_INCREMENT,
  `changeByUserID` int(10) NOT NULL,
  `changedTable` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `changeDetails` text COLLATE latin1_general_ci NOT NULL,
  `changeDate` datetime NOT NULL,
  PRIMARY KEY (`changeID`),
  KEY `FK_users1` (`changeByUserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `footerLayout`
--

CREATE TABLE IF NOT EXISTS `footerLayout` (
  `footerID` int(10) NOT NULL AUTO_INCREMENT,
  `footerTitle` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `footerLogoImg` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `footerHeight` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `footerTextArea1` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `footerTextArea2` varchar(200) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`footerID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `footerLayout`
--

INSERT INTO `footerLayout` (`footerID`, `footerTitle`, `footerLogoImg`, `footerHeight`, `footerTextArea1`, `footerTextArea2`) VALUES
(1, '', 'images/Logo2.png', '100', 'Text to displayed in the Footer section.', 'Text Area 2 Edit');

-- --------------------------------------------------------

--
-- Table structure for table `headerLayout`
--

CREATE TABLE IF NOT EXISTS `headerLayout` (
  `headerID` int(10) NOT NULL AUTO_INCREMENT,
  `headerTitle` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `headerLogoImg` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `headerHeight` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `headerHTML` text COLLATE latin1_general_ci,
  `floatHeader` tinyint(1) NOT NULL,
  `headerTextArea1` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`headerID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `headerLayout`
--

INSERT INTO `headerLayout` (`headerID`, `headerTitle`, `headerLogoImg`, `headerHeight`, `headerHTML`, `floatHeader`, `headerTextArea1`) VALUES
(1, 'Header Title', 'images/Logo2.png', '100', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `helpPages`
--

CREATE TABLE IF NOT EXISTS `helpPages` (
  `helpPageID` int(10) NOT NULL AUTO_INCREMENT,
  `helpPageTitle` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `helpPageContent` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`helpPageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=24 ;

--
-- Dumping data for table `helpPages`
--

INSERT INTO `helpPages` (`helpPageID`, `helpPageTitle`, `helpPageContent`) VALUES
(1, 'Test1', '<p>Testing help page viewing</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam magnam accusamus obcaecati nisi eveniet quo veniam quibusdam veritatis autem accusantium doloribus nam mollitia maxime explicabo nemo quae aspernatur impedit cupiditate dicta molestias consectetur, sint reprehenderit maiores. Tempora, exercitationem, voluptate. Sapiente modi officiis nulla sed ullam, amet placeat, illum necessitatibus, eveniet dolorum et maiores earum tempora, quas iste perspiciatis quibusdam vero accusamus veritatis. Recusandae sunt, repellat incidunt impedit tempore iusto, nostrum eaque necessitatibus sint eos omnis! Beatae, itaque, in. Vel reiciendis consequatur saepe soluta itaque aliquam praesentium, neque tempora. Voluptatibus sit, totam rerum quo ex nemo pariatur tempora voluptatem est repudiandae iusto, architecto perferendis sequi, asperiores dolores doloremque odit. Libero, ipsum fuga repellat quae numquam cumque nobis ipsa voluptates pariatur, a rerum aspernatur aliquid maxime magnam vero dolorum omnis neque fugit laboriosam eveniet veniam explicabo, similique reprehenderit at. Iusto totam vitae blanditiis. Culpa, earum modi rerum velit voluptatum voluptatibus debitis, architecto aperiam vero tempora ratione sint ullam voluptas non! Odit sequi ipsa, voluptatem ratione illo ullam quaerat qui, vel dolorum eligendi similique inventore quisquam perferendis reprehenderit quos officia! Maxime aliquam, soluta reiciendis beatae quisquam. Alias porro facilis obcaecati et id, corporis accusamus? Ab porro fuga consequatur quisquam illo quae quas tenetur.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque similique, at excepturi adipisci repellat ut veritatis officia, saepe nemo soluta modi ducimus velit quam minus quis reiciendis culpa ullam quibusdam eveniet. Dolorum alias ducimus, ad, vitae delectus eligendi, possimus magni ipsam repudiandae iusto placeat repellat omnis veritatis adipisci aliquam hic ullam facere voluptatibus ratione laudantium perferendis quos ut. Beatae expedita, itaque assumenda libero voluptatem adipisci maiores voluptas accusantium, blanditiis saepe culpa laborum iusto maxime quae aperiam fugiat odit consequatur soluta hic. Sed quasi beatae quia repellendus, adipisci facilis ipsa vel, aperiam, consequatur eaque mollitia quaerat. Iusto fugit inventore eveniet velit.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque similique, at excepturi adipisci repellat ut veritatis officia, saepe nemo soluta modi ducimus velit quam minus quis reiciendis culpa ullam quibusdam eveniet. Dolorum alias ducimus, ad, vitae delectus eligendi, possimus magni ipsam repudiandae iusto placeat repellat omnis veritatis adipisci aliquam hic ullam facere voluptatibus ratione laudantium perferendis quos ut. Beatae expedita, itaque assumenda libero voluptatem adipisci maiores voluptas accusantium, blanditiis saepe culpa laborum iusto maxime quae aperiam fugiat odit consequatur soluta hic. Sed quasi beatae quia repellendus, adipisci facilis ipsa vel, aperiam, consequatur eaque mollitia quaerat. Iusto fugit inventore eveniet velit.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam magnam accusamus obcaecati nisi eveniet quo veniam quibusdam veritatis autem accusantium doloribus nam mollitia maxime explicabo nemo quae aspernatur impedit cupiditate dicta molestias consectetur, sint reprehenderit maiores. Tempora, exercitationem, voluptate. Sapiente modi officiis nulla sed ullam, amet placeat, illum necessitatibus, eveniet dolorum et maiores earum tempora, quas iste perspiciatis quibusdam vero accusamus veritatis. Recusandae sunt, repellat incidunt impedit tempore iusto, nostrum eaque necessitatibus sint eos omnis! Beatae, itaque, in. Vel reiciendis consequatur saepe soluta itaque aliquam praesentium, neque tempora. Voluptatibus sit, totam rerum quo ex nemo pariatur tempora voluptatem est repudiandae iusto, architecto perferendis sequi, asperiores dolores doloremque odit. Libero, ipsum fuga repellat quae numquam cumque nobis ipsa voluptates pariatur, a rerum aspernatur aliquid maxime magnam vero dolorum omnis neque fugit laboriosam eveniet veniam explicabo, similique reprehenderit at. Iusto totam vitae blanditiis. Culpa, earum modi rerum velit voluptatum voluptatibus debitis, architecto aperiam vero tempora ratione sint ullam voluptas non! Odit sequi ipsa, voluptatem ratione illo ullam quaerat qui, vel dolorum eligendi similique inventore quisquam perferendis reprehenderit quos officia! Maxime aliquam, soluta reiciendis beatae quisquam. Alias porro facilis obcaecati et id, corporis accusamus? Ab porro fuga consequatur quisquam illo quae quas tenetur.</p>'),
(2, 'Dashboard Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>&nbsp;</p>\r\n<h1>Dashboard Help</h1>\r\n<h2>Overview</h2>\r\n<p>The dashboard is the Administrator''s homepage for quick access to view site statistics.</p>\r\n<p>&nbsp;The statistics currently shown are:</p>\r\n<ol>\r\n<li>Articles that have been approved.</li>\r\n<li>The current number of special pages</li>\r\n<li>The current number of users.</li>\r\n<li>The number of articles that are currently pending</li>\r\n</ol>\r\n<p>If you require more information about any one of the statistics listed please click&nbsp;the <strong>View Details</strong> button and you will be directed to the corrisponding page.</p>\r\n<p>Under the statistics of the website is the Google Analytics information. The information listed is as followed:</p>\r\n<p>1. The number of sessions each day over the last month.</p>\r\n<p>2. The type of devices used to access the website and the number of times each device has been used.</p>\r\n<p>3. The number of sessions that have taken place based on the region and city.</p>\r\n<p>4. The time in seconds each user spends on specific pages.</p>\r\n<p>More information is available at <cite class="_Rm"><a href="https://www.google.com/analytics/">https://www.google.com/analytics/</a></cite></p>\r\n<p><cite class="_Rm">To sign into the account navigate to the page listed above then look for the <strong>sign in</strong> up at the top right of the page. Click on this and&nbsp; then click <strong>Analytics </strong>from the drop down menu. When the next page loads sign in to google by clicking the person icon in the top right corner. </cite></p>\r\n<p><cite class="_Rm">Here you can see all kinds of interesting information in real time. Also the Google Analytics website will allow you to set up your own dashboard&nbsp; to moniter the information you want to see.</cite></p>\r\n<p>&nbsp;</p>\r\n</body>\r\n</html>'),
(4, 'Articles & Special Pages Help Page', '<p>&nbsp;</p>\r\n<h1>Articles &amp; Special Pages Help</h1>\r\n<h2>Overview</h2>\r\n<p>Articles and Special pages from a creating and editing aspect are exactly the same. &nbsp;An article is a post about a specific topic. &nbsp;It is included in the general list of articles or the list of articles under a category. A special page is used for&nbsp;single pages that don''t necessarily relate to a category (e.g. About Us, Contact Us, etc). A special page does not show up in any list or display author or date details. After you have created a special page, you can then create a Navigation and choose the URL to be the special page. &nbsp;That navigation will point to the special page.</p>\r\n<p>This page lists all articles&nbsp;or special pages. If you would like to create a new article&nbsp;or special page, select <em><strong>Articles&gt;Add Article&nbsp;</strong></em>or&nbsp;<em><strong>Special Pages&gt;Add Page</strong></em> from the left side navigation.</p>\r\n<h2>Requirements</h2>\r\n<p>A&nbsp;Navigation and Category must be created before you can create an article or special page.</p>\r\n<h2>Details</h2>\r\n<p>The following chart summarizes the different buttons and options available on this screen.</p>\r\n<table style="width: 100%; height: auto;">\r\n<tbody>\r\n<tr style="margin-bottom: 10px;">\r\n<td style="width: 150px; padding-right: 20px;"><img src="images/helppages/exclamation.png?1490738306328" alt="exclamation" />&nbsp; <strong>Pending</strong></td>\r\n<td>The exclamation point means that your article is still pending approval before it is published. If you are an administrator, you can click this button to approve the article.</td>\r\n</tr>\r\n<tr style="margin-bottom: 10px;">\r\n<td style="width: 150px; padding-right: 20px;"><img src="images/helppages/Check.png?1490737855077" alt="Check" />&nbsp;<strong>Approved</strong></td>\r\n<td>This indicates that the content in the article/special page has been approved by an administrator.</td>\r\n</tr>\r\n<tr style="margin-bottom: 10px;">\r\n<td style="width: 150px; padding-right: 20px;"><img src="images/helppages/eye_close.png?1490738750079" alt="eye_close" />&nbsp;<strong>Not Visible</strong></td>\r\n<td>A closed eye means that the current article/special page is not being displayed on your website. You can click on this to make the article/special page visible.</td>\r\n</tr>\r\n<tr style="margin-bottom: 10px;">\r\n<td style="width: 150px; padding-right: 20px;"><img src="images/helppages/openEye.png?1490738774662" alt="openEye" />&nbsp;<strong>Visible</strong></td>\r\n<td>A open eye means that the current article/special page is being displayed on your website. You can click on this to make the article/special page invisible.</td>\r\n</tr>\r\n<tr style="margin-bottom: 10px;">\r\n<td style="width: 150px; padding-right: 20px;"><img src="images/helppages/archive.png?1490738788302" alt="archive" />&nbsp;<strong>Archive</strong></td>\r\n<td>Clicking on this icon will move the article/special page into your site archive. From there you can restore or delete the article.</td>\r\n</tr>\r\n<tr style="margin-bottom: 10px;">\r\n<td style="width: 150px; padding-right: 20px;"><img src="images/helppages/duplicate.png?1490738808442" alt="duplicate" />&nbsp;<strong>Duplicate</strong></td>\r\n<td>This will create a copy of the article/special page.</td>\r\n</tr>\r\n<tr style="margin-bottom: 10px;">\r\n<td style="width: 150px; padding-right: 20px;"><img src="images/helppages/Edit.png?1490738822408" alt="Edit" />&nbsp;<strong>Edit</strong></td>\r\n<td>Clicking on the pencil icon will take you to a page where you can make changes to the article/special page you have selected.</td>\r\n</tr>\r\n<tr style="margin-bottom: 10px;">\r\n<td style="width: 150px; padding-right: 20px;"><img src="images/helppages/locked.png?1490738830335" alt="locked" />&nbsp;<strong>Locked</strong></td>\r\n<td>This icon indicates that the article/special page you want to edit is being worked on by another. If you are an administrator or the author, you can override this lock and make changes to the entry.</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(22, 'Add/Edit Articles & Special Pages Help Page', '<h1>Add/Edit Help</h1>\r\n<p>On the Add/Edit page for Articles and Special Pages, you can create and/or modify content. At a minimum, you must include a T<strong>itle</strong>, a C<strong>ategory</strong>, and some form of <strong>Content</strong>.</p>\r\n<p>The <strong>content editor</strong> area allows you to use different fonts, font sizes, images, tables, imbedded links, and much more. (Select <em>Advanced Editor</em> for even more options.)</p>\r\n<p>Additional features of the add/edit include:</p>\r\n<ul>\r\n<li><strong>Image -&nbsp;</strong>This differs from images you add in the content area. This will be the primary image displayed in article lists or displayed at the top of the page, so it can pay to use something eye-grabbing.</li>\r\n<li><strong>Upload File&nbsp;-&nbsp;</strong>You can use the file uploader to add a powerpoint, word document, PDF, excel spreadsheet, and many more types of files to your content.&nbsp;When your content is viewed by visitors, your uploaded file will be displayed in a preview at the bottom of your content. The visitor can zoom in and out of the content, download the file, or open it in a new tab.</li>\r\n<li><strong>Media Removal -&nbsp;</strong>If you''ve added a primary image&nbsp;or a file, but then decided that you don''t want &nbsp;to include one or both of these, simply check the box underneath the media you want to remove <em>(Remove image? or Remove file?),</em> and it will no longer be included with your&nbsp;article or special page. This does not remove the media from the file manager, so it will still be available if you want to use it again.</li>\r\n</ul>'),
(5, 'Aside Section Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<h1>Aside Section Help</h1>\r\n<h2>Where is it?</h2>\r\n<p>The Aside Section is along the right side of the homepage below the Search and above the Aside Links.</p>\r\n<h2>How to use it?</h2>\r\n<p>You can enter any text into the <strong>Aside Header</strong> and that will be the header of the Aside Section. Then enter content&nbsp;in the Editor under <strong>Front Body Text</strong>&nbsp;and click the&nbsp;Edit Aside Section button and it will update&nbsp;the one on the front page. (Hitting Edit Aside Section will immedietly change the one on the front page as there is only one so anytime you change something and click it you will see it right away)</p>\r\n</body>\r\n</html>'),
(6, 'Categories Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<h1>Categories Help</h1>\r\n<h2>Getting Started</h2>\r\n<p>On this page, you will find the&nbsp;<strong>Add Category</strong> form for creating new Categories, as well as a list of any existing Categories. If there are many existing Categories, you can use the page buttons at the bottom to load and access additional Categories that are not visible on the first page. In the list, you can use the <em>Delete</em> trash can icon (&nbsp;&nbsp;<span class="glyphicon glyphicon-trash">&nbsp;</span>) to delete the Category*, the&nbsp;<em>View &amp; Edit</em> pencil icon (&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil">&nbsp;</span>) to edit a Category (see further instructions below under <strong>Editing an Existing Category</strong>), and the&nbsp;<em>Visibility Toggle</em> eye icons (&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open">&nbsp;&amp;&nbsp;</span><span class="glyphicon glyphicon-eye-close">&nbsp;</span>) to control whether or not the Category is visible on the pubic site.</p>\r\n<p>Categories reside under, belong to, and are accessed through Navigations. Therefore, you must create a Navigation to assign a Category to before you can create a Category. In addition, Articles reside under, belong to, and are accessed through Categories. Therefore, you must create a Category to assign an Article to before you can create an Article.</p>\r\n<p>On the public site, users can access Categories in the following ways:</p>\r\n<ul>\r\n<li>Clicking on a Navigation in the header will take the user to that Navigation''s page, and if that Navigation has Categories assigned to it, they will be listed on that page in tiles that show the Category''s title and image, as well as a button for the user to access the Articles under that Category.</li>\r\n<li>If a Navigation has Categories assigned to it, when the user hovers over that Navigation in the header, a dropdown with the list of Category titles will appear. If the user clicks on a Category title in the dropdown, they will be taken to that Category''s page to access the Articles under that Category.&nbsp;</li>\r\n<li>In the left side navigation, under&nbsp;<em><strong>Layout Settings</strong></em>&nbsp;&gt;&nbsp;<em><strong>Homepage Settings</strong></em>, if you choose ''Categories'' under&nbsp;<strong>Front Display</strong>, any Navigation whose&nbsp;<strong>Location</strong>&nbsp;is set to ''Header, Footer, Body'' will have its title displayed on the Homepage with its Categories listed on that page in tiles that show the Category''s title and image, as well as a button for the user to access the Articles under that Category.</li>\r\n</ul>\r\n<h2>Creating a New Category</h2>\r\n<p>You can create a new Category using the form at the top of this page. The fields can be described as follows:</p>\r\n<ul>\r\n<li><span style="text-decoration: underline;">Category Title</span>: The Category Title is a required field and will be what shows in the navigation dropdown, the Category tile on Navigation pages, and as the Heading of that Category''s page.<strong>&nbsp;</strong></li>\r\n<li><span style="text-decoration: underline;">Navigation Page</span>: The Navigation Page is a required field and dictates which Navigation that Category belongs to. The Category will show up on the dropdown and page of the Navigation it is assigned to.</li>\r\n<li><span style="text-decoration: underline;">Description</span>: The Description is an optional field for any content directly related to that Category. Any content added to the Description for the Category will show up on the Category''s page below the Category Title and above the list of Articles for that Category.</li>\r\n<li><span style="text-decoration: underline;">Category Image</span>: The Category Image is an optional field for an image to represent that Category. If an Image is selected for the Category, it will show in that Category''s tile on the Navigation Page is belongs to, as well as on that Category''s page below the Category Title and above the list of Articles for that Category. If there is also content added in the description, the image will appear to the left of the text. The ideal Category Image is about 600 x 600 pixels and 72-96 ppi.</li>\r\n</ul>\r\n<p>Once you have filled out all the necessary fields, click the&nbsp;<strong>Add Category</strong>&nbsp;button to create the Category, or&nbsp;<strong>Cancel</strong>&nbsp;to clear all fields and start over.</p>\r\n<h2>Editing an Existing Category</h2>\r\n<p>If there are existing Categories, they will be listed below the&nbsp;<strong>Add Category</strong> form on this page. To edit one of the existing Categories:</p>\r\n<ol>\r\n<li>Find the Category you would like to edit in the list. (If there are many existing Categories, you may need to use the page buttons at the bottom to load and access additional Categories that do not appear on the first page.)</li>\r\n<li>Click the&nbsp;<em>View &amp; Edit</em> pencil icon (&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil">&nbsp;</span>) for that Category. This will open the&nbsp;<em><strong>Category Edit</strong></em> page with all of the fields populated with that Categories current content.</li>\r\n<li>Here you can edit the <span style="text-decoration: underline;">Category Title</span> or Navigation Page, add or edit the <span style="text-decoration: underline;">Category Description</span>, and/or add or select a new&nbsp;<span style="text-decoration: underline;">Category Image</span>.</li>\r\n<li>Once you are finished making changes, click the&nbsp;<strong>Update Category</strong> button to update the Category with your edits, or you can click&nbsp;<strong>Cancel</strong> to exit the&nbsp;<em><strong>Category Edit</strong></em> page without saving any changes you may have made.</li>\r\n</ol>\r\n</body>\r\n</html>'),
(7, 'View/Add Users Help Page', '<p>&nbsp;</p>\r\n<h1>Users Help</h1>\r\n<h2>View Users Page</h2>\r\n<p>Lists All Users and their information within the system.</p>\r\n<p>From this screen, you''re able to select the Pencil icon (&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil">&nbsp;</span>) to ''View and Edit'' a given User, or select the Eye icons (&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open">&nbsp;&amp;&nbsp;</span><span class="glyphicon glyphicon-eye-close">&nbsp;</span>) to ''Deactivate'' or ''Activate'' a given User.</p>\r\n<h2>Add User Page</h2>\r\n<p>The Add User Page allows Administrators to create and add a User into the system.</p>\r\n<p>User information includes;</p>\r\n<ul>\r\n<li>First Name</li>\r\n<li>Last Name</li>\r\n<li>User Role:&nbsp;<strong>Contributor</strong>&nbsp;and&nbsp;<strong>Admin</strong>&nbsp;are the available&nbsp;User Roles.&nbsp;<strong>Contributors</strong>&nbsp;are able to modify their profile information including their password, as well as access the Articles, and Special Pages tabs.&nbsp;<strong>Administrators&nbsp;</strong>are given full access to the Administrative site.</li>\r\n<li>Username: Must&nbsp;be unique within the system.</li>\r\n<li>Email&nbsp;</li>\r\n<li>Password</li>\r\n<li>Receive Email Notifications?: This setting determines whether the User will receive email notifications for pending changes within the system.</li>\r\n</ul>\r\n<p>Clicking&nbsp;the <strong>Add User</strong> button validates the entered data, and adds the User if everything checks out. The appropriate error message will be displayed if this is not the case. Clicking&nbsp;<strong>Cancel</strong>&nbsp;will redirect you back to the previous page, and the User will not be added into the system.</p>\r\n<p>&nbsp;</p>'),
(8, 'Add User Page', '<p>Allows you to&nbsp;add a new User into the system.</p>'),
(9, 'Header Settings Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<h1>Header Settings Help</h1>\r\n<p>Displays current&nbsp;Header settings for the front end site, and allows you to modify them.</p>\r\n<p>Settings include:&nbsp;</p>\r\n<ul>\r\n<li><span style="text-decoration: underline;">Logo image</span>: It&nbsp;is recommended to use an image height equal to the Header height at 72&nbsp;ppi.</li>\r\n<li><span style="text-decoration: underline;">Title</span>: Will be displayed if there''s no logo image selected, or if the logo doesn''t include a title.&nbsp;Maximum&nbsp;length of 50 characters.</li>\r\n<li><span style="text-decoration: underline;">Height</span>: Is expressed in pixels. The default value is 100.</li>\r\n<li><span style="text-decoration: underline;">Left Side HTML Text</span>: Is text that''s displayed&nbsp;in&nbsp;the left side of the Header section. Maximum length of 200 characters.*</li>\r\n<li><span style="text-decoration: underline;">Right Side HTML Text</span>: Is additional text that''s displayed&nbsp;in&nbsp;the right side of the Header section.&nbsp;Maximum length of 200 characters.*</li>\r\n</ul>\r\n<p><em>*Note: These fields will only show if the Header Height is at or over 200 pixels.</em></p>\r\n</body>\r\n</html>'),
(10, 'Footer Settings Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<h1>Footer Settings Help</h1>\r\n<p>Displays current Footer settings for the front end site, and allows you to modify them.</p>\r\n<p>Settings include;&nbsp;</p>\r\n<ul>\r\n<li><span style="text-decoration: underline;">Logo image</span>: Is recommended to use an image height equal to the Footer height at 72&nbsp;ppi.</li>\r\n<li><span style="text-decoration: underline;">Title</span>: Will be displayed if there''s no logo image selected, or if the logo doesn''t include a title.&nbsp;Maximum&nbsp;length of 50 characters.</li>\r\n<li><span style="text-decoration: underline;">Height</span>: Is expressed in pixels. The default value is 100.</li>\r\n<li><span style="text-decoration: underline;">HTML Text Area</span>: Is text that''s displayed&nbsp;in&nbsp;the Footer section. Maximum length of 200 characters.</li>\r\n</ul>\r\n</body>\r\n</html>'),
(11, 'User Profile Page Help', '<p>&nbsp;</p>\r\n<h1>User Profile Help</h1>\r\n<p>Displays current User information, and allows you to modify it.</p>\r\n<p>User information includes;&nbsp;</p>\r\n<ul>\r\n<li>First Name</li>\r\n<li>Last Name</li>\r\n<li>Username</li>\r\n<li>Email</li>\r\n<li>Change Password: Selecting this link will redirect the user to a separate page, and the other profile changes will not be saved.</li>\r\n<li>Receive Email Notifications?: This setting determines whether the User will receive email notifications for pending changes within the system.</li>\r\n</ul>\r\n<p>Clicking&nbsp;the <strong>Update Profile</strong> button will save the changes, and clicking&nbsp;<strong>Cancel</strong>&nbsp;will take the user back to the previous page, and the changes won''t be saved.</p>'),
(12, 'Change Password Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<h1>Change Password Help</h1>\r\n<p>Allows the User to change their password.</p>\r\n<p>The User is expected to enter a new password&nbsp;and then&nbsp;confirm the password in the second textbox.</p>\r\n<p>&nbsp;</p>\r\n<p>Selecting the <strong>Update Password</strong> button will ensure the passwords match and then update the password, taking the User back to the <strong>Edit Profile</strong>&nbsp;page.</p>\r\n<p>Selecting <strong>Cancel</strong> will take the User back to the Edit Profile page, and the password will not be updated.</p>\r\n</body>\r\n</html>'),
(13, 'Edit Users Page Help', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<h1>Edit Users Help</h1>\r\n<p>Displays the selected User and their information and allows you to modify it.&nbsp;</p>\r\n<p>Much like the Edit Profile page, the Edit User page displays basic User information, including;&nbsp;</p>\r\n<ul>\r\n<li>First Name</li>\r\n<li>Last Name</li>\r\n<li>User Role: <strong>Contributor</strong> and <strong>Admin</strong> are the available&nbsp;User Roles. <strong>Contributors</strong> are able to modify their profile information including their password, as well as access the Articles and Special Pages tabs. <strong>Administrators&nbsp;</strong>are given full access to the Administrative site.</li>\r\n<li>Username</li>\r\n<li>Email</li>\r\n<li>Password:&nbsp;<strong>Administrators</strong> are given the ability to change a User''s password in the event the User forgets it, and this should be the only time this field is modified.</li>\r\n<li>Active?: This setting determines whether the User is activated and able to access the administrative site. Unchecking this box deactivates the User, and they will be denied access upon attempting to log into the system using their credentials until an <strong>Administrator</strong> activates their account again.</li>\r\n<li>Receive Email Notifications?: This setting determines whether the User will receive email notifications for pending changes within the system.</li>\r\n</ul>\r\n<p>Clicking&nbsp;the <strong>Update User</strong> button will save the changes, and clicking&nbsp;<strong>Cancel</strong>&nbsp;will take the user back to the previous page, and the changes won''t be saved.</p>\r\n</body>\r\n</html>'),
(14, 'Site Colors Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<h1>Site Colors Help</h1>\r\n<h2>Overview</h2>\r\n<p>The site colors allow you to modify almost any aspect of the website to a color of your choosing. &nbsp;</p>\r\n<h2>Details</h2>\r\n<p>If you click on a color option, a popout color picker will display.</p>\r\n<p><img src="images/helppages/SiteColorChoiceJPG.jpg?1489704775782" alt="SiteColorChoiceJPG" width="212" height="166" /></p>\r\n<p>To select the color for that item, you can click or drag the crosshair&nbsp;to choose the desired hue, then drag the right slider to lighten or darken, or if you already know the hexadecimal color code you may just enter it in the color option box. &nbsp;Once you have made your color choices, click the <strong>Update Settings</strong> button at the bottom of the screen to save your changes.&nbsp;</p>\r\n<p>It is suggested you open a new web browser to view your website and see the changes. &nbsp; If you are not happy with the choices, you can continue to make modifications&nbsp;<strong>Site Colors</strong> page you still have open and <strong>Update Settings</strong> again.</p>\r\n</body>\r\n</html>'),
(15, 'Homepage Settings Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<h1>Homepage Settings Help</h1>\r\n<h2>Overview</h2>\r\n<p>The Home Page Settings area allows you to modify how the front page looks. &nbsp;You will have the ability to enable/disable and choose which heroic image you would want. &nbsp;You also have the ability to choose whether the home page will display the newest articles, a list of categories, or use your own text and images with the Froot Body&nbsp;text option.</p>\r\n<h2>Details</h2>\r\n<p><span style="text-decoration: underline;">Hero Image</span>:<strong>&nbsp;</strong>To show the large Heroic image on the front page, the checked value must be set to Yes. To change the image, click the Choose image button</p>\r\n<p><img src="images/helppages/UploadButton.jpg?1489705554643" alt="UploadButton" width="47" height="69" /></p>\r\n<p>and either click on the Drp file here to upload text or drag the image into that area.&nbsp;</p>\r\n<p><img src="images/helppages/Upload2.jpg?1489705593414" alt="Upload2" width="178" height="64" /></p>\r\n<p>After the image has been uploaded, click on it to make it your chosen image.<u></u></p>\r\n<p>You can also add text that overlays on top of the heroic image by using the Heroic Text options.</p>\r\n<p><img src="images/helppages/HeroicText.jpg?1489705749362" alt="HeroicText" width="520" height="66" /></p>\r\n<p><strong>Front page display:</strong></p>\r\n<p>&nbsp;You can change the front page to display categories, articles or text by changing the Front Display option.</p>\r\n<p><img src="images/helppages/FrontDisplay.jpg?1489706004584" alt="FrontDisplay" width="254" height="43" /></p>\r\n<p>If Categories are chosen, those categories that are a part of a Navigation with the location of header, footer, body chosen, will show up on the front page.</p>\r\n<p><img src="images/helppages/NavigationBody.jpg?1489706062850" alt="NavigationBody" width="181" height="107" /></p>\r\n<p>If Articles is chosen, the newest&nbsp;articles that are visible will displayed on the front page.</p>\r\n<p>If Text is chosen, the text you create in the Front Body Text is what will be displayed.</p>\r\n<p>After all changed, you wll need to click on the Update Settings button to make them take effect.&nbsp; You can then view them on the website''s front page to view the changes.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n</body>\r\n</html>'),
(16, 'Help Pages Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p><strong>Overview:</strong></p>\r\n<p>The Help Pages area will only be seen if a developer unhides the navigation from the includes\\adminNavigationSide.php. &nbsp;</p>\r\n<p>The developer will also need to modify the admin\\filemanager\\config\\config.php and point the two uploads folder location and thumb location to the images folder. &nbsp;</p>\r\n<p><strong>Details:</strong></p>\r\n<p>Once the new Help Pages have been created, the developer will need to:</p>\r\n<ul>\r\n<li>Re-comment out the Help Pages navigation so it is not seen by regular users</li>\r\n<li>Change the config.php back to the uploads folder</li>\r\n<li>Copy all the new images to all the sites using BullDog CMS</li>\r\n<li>Copy any new database rows to all the sites using BullDog CMS</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n</body>\r\n</html>'),
(18, 'Navigations Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<h1>&nbsp;Navigations Help</h1>\r\n<h2>Creating Navigation Links</h2>\r\n<p><span style="font-size: 12pt;">To make a link on the front-end site, two conditions must be met:</span></p>\r\n<ol>\r\n<li>The Navigation must have a unique name. (You cannot make duplicate navigation links.)</li>\r\n<li>The Navigation must link to another URL or perform a Javascript action. (To choose a URL not found in the list, choose "other" and type a URL, prefixed with <em>http://</em> or <em>https://</em>, into the field that appears.)</li>\r\n</ol>\r\n<h2>Linking Navigations to Categories</h2>\r\n<p>To make a Navigation link display one or more categories, follow these steps:</p>\r\n<ol>\r\n<li>Create a new Navigation link\r\n<ul>\r\n<li>Give it a unique name</li>\r\n<li>Select the result in the dropdown named "<em>your_navigation_name&nbsp;</em>Categories"</li>\r\n</ul>\r\n</li>\r\n<li>On the Categories page create a new, or update an existing Category\r\n<ul>\r\n<li>Select the Navigation Link you created in step 1 from the Navigation Page dropdown list.</li>\r\n</ul>\r\n</li>\r\n</ol>\r\n<h2>Linking Navigations to Special Pages</h2>\r\n<p>In order to link a specific article to a Navigation link you must create the article under Special Pages. Follow these steps:</p>\r\n<ol>\r\n<li>Create a new Special Page.</li>\r\n<li>Create a new Navigation link.\r\n<ul>\r\n<li>Give it a unique name.</li>\r\n<li>Select the result in the URL dropdown list with the name of the Special Page you created in step 1.</li>\r\n</ul>\r\n</li>\r\n</ol>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n</body>\r\n</html>'),
(23, 'Change Log Report Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<h1>Change Log Report Help</h1>\r\n<p>From this page you can view a history of changes and events on your website.</p>\r\n<p>&nbsp;</p>\r\n<p>The <strong>Change By&nbsp;</strong>column indicates who initiated the event.</p>\r\n<p>The <strong>Table</strong>&nbsp;column tells you what part of the website the change was made to.&nbsp;</p>\r\n<p>The <strong>Details</strong>&nbsp;column gives you a brief overview of what happened.</p>\r\n<p>The <strong>Date&nbsp;</strong>column tells you when this change or event happened.</p>\r\n<p>&nbsp;</p>\r\n<p>If you click the&nbsp;<strong>Delete</strong> <strong>Changelog</strong>&nbsp;button at the bottom of the page, all of the data in the Change Log will be deleted from the system.</p>\r\n</body>\r\n</html>'),
(19, 'Site Settings Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<h1>Site Setting Help</h1>\r\n<h2>Overview</h2>\r\n<p>The site settings page contains settings that relate to the overall website. On this page you can change the title of the website, the email of the website, the google analytics website ID that connects to the google analytics for the website, and several features that can be disabled.</p>\r\n<h2>Details</h2>\r\n<ul>\r\n<li><strong>Site Title</strong>: This is the site''s title. It will be what appears in the browser tab, the title of bookmarks to your site, and shown in search-engine results.</li>\r\n<li><strong>Site Email</strong>:&nbsp;This is the email notifications will be sent from.</li>\r\n<li><strong>Google Analytics website ID</strong>: This is the ID from the Google Analytics page that connects your website to google. When a google analytics account is created (most likely using the site email) you will be given this code. It should be put here in this setting.</li>\r\n<li><strong>Enable Article Submission Process</strong>: This enables the requried review and approval of anything added to the website by a contributor user. If this is disabled then anything contributors add will automatically be published to the website without required approval. (by default administrators do not need approval for anything they add.)</li>\r\n<li><strong>Enable Site Search</strong>:&nbsp;The Search box allows your users to search for articles based on their tags.If this is disabled, the search box will be removed from the website (Front end).</li>\r\n<li><strong>Enable Links Section</strong>:&nbsp;This enable or disables the Links side panel where you can provide your user with links to other sites and external resources. If this is disabled the links side panel will be removed from the website (Front end).</li>\r\n<li><strong>Enable Side Widget</strong>:&nbsp;This enables an additional section in the side panel where you can post additional content to be shone on all pages. If this is disabled the side widget section will be removed from the website (Front End).</li>\r\n<li><strong>Enable Author Names</strong>: This enables author names, dates and times to be displayed on the website right below the title of any articles that are added to the website (front end). If disabled then only the article Title and content will show. (The author, dates and times are still stored and can be viewed in the admin side.)</li>\r\n</ul>\r\n</body>\r\n</html>'),
(20, 'Aside Links Help Page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<h1>Aside Links Help&nbsp;</h1>\r\n<h2>Where Does This Information Go?</h2>\r\n<p>The Aside Links page is used to change the links on the right side of the website. The Link Name is what appears as the text on the front page and the Link URL is where the link will take you once you click it.</p>\r\n<h2>How to use it.</h2>\r\n<p>Just enter a Link Name and then a Link URL (That has to be a full link so include http:// before your link) and then decide whether you want it to be go under News or Links and click Add Aside Link and it will be added. Below you can click on the trash can to delete any unwanted links or the pencil to edit the link.</p>\r\n</body>\r\n</html>');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `linkID` int(10) NOT NULL AUTO_INCREMENT,
  `linkName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `linkURL` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `linkOrder` int(3) NOT NULL,
  `linkTypeID` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`linkID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`linkID`, `linkName`, `linkURL`, `linkOrder`, `linkTypeID`) VALUES
(1, 'Ferris State University', 'http://www.ferris.edu', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `linkType`
--

CREATE TABLE IF NOT EXISTS `linkType` (
  `linkTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `linkTypeName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`linkTypeID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `linkType`
--

INSERT INTO `linkType` (`linkTypeID`, `linkTypeName`) VALUES
(1, 'Link'),
(2, 'News');

-- --------------------------------------------------------

--
-- Table structure for table `navigations`
--

CREATE TABLE IF NOT EXISTS `navigations` (
  `navigationID` int(10) NOT NULL AUTO_INCREMENT,
  `navigationName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `navigationURL` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `navigationLocation` tinyint(1) NOT NULL,
  `navigationOrder` int(2) NOT NULL,
  `navButtonColor` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `navButtonSize` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `navigationVisible` tinyint(1) NOT NULL,
  `navJavaScript` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`navigationID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `navigations`
--

INSERT INTO `navigations` (`navigationID`, `navigationName`, `navigationURL`, `navigationLocation`, `navigationOrder`, `navButtonColor`, `navButtonSize`, `navigationVisible`, `navJavaScript`) VALUES
(1, 'Home', 'index.php', 1, 1, NULL, NULL, 1, NULL),
(2, 'ExampleNav', 'index.php?view=catbynavname&navname=ExampleNav', 3, 2, '', '', 1, ''),
(3, 'Events', 'index.php?view=catbynavname&navname=Events', 4, 3, '', '', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `roleID` int(10) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`roleID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleID`, `roleName`) VALUES
(1, 'Contributor'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `siteSettings`
--

CREATE TABLE IF NOT EXISTS `siteSettings` (
  `siteSettingID` int(10) NOT NULL AUTO_INCREMENT,
  `siteName` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT 'bullDogCMS',
  `siteEmail` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `siteSearch` tinyint(1) NOT NULL DEFAULT '1',
  `articleSubmission` tinyint(1) NOT NULL DEFAULT '1',
  `enableLinks` tinyint(1) NOT NULL DEFAULT '1',
  `enableSideWidget` tinyint(1) NOT NULL DEFAULT '1',
  `enableLatestArticles` tinyint(1) NOT NULL DEFAULT '1',
  `enableNews` tinyint(1) NOT NULL DEFAULT '1',
  `enableEvents` tinyint(1) NOT NULL DEFAULT '1',
  `enableAuthorNames` tinyint(1) NOT NULL DEFAULT '1',
  `enableFullName` tinyint(1) NOT NULL DEFAULT '1',
  `googleAnalyticsID` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `gaClientID` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `gaViewID` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `paginationLength` int(10) NOT NULL DEFAULT '10',
  PRIMARY KEY (`siteSettingID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `siteSettings`
--

INSERT INTO `siteSettings` (`siteSettingID`, `siteName`, `siteEmail`, `siteSearch`, `articleSubmission`, `enableLinks`, `enableSideWidget`, `enableLatestArticles`, `enableNews`, `enableEvents`, `enableAuthorNames`, `enableFullName`, `googleAnalyticsID`, `gaClientID`, `gaViewID`, `paginationLength`) VALUES
(1, 'bullDogCMS', 'admin@somewhere.com', 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `themeColors`
--

CREATE TABLE IF NOT EXISTS `themeColors` (
  `themeColorID` int(10) NOT NULL AUTO_INCREMENT,
  `headerBackground` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `footerBackground` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `asideBackground` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `masterBackground` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `buttonHover` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `buttonFont` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `linkFont` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `linkHover` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `masterFont` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `headerFont` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `footerFont` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `headerTitleFont` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `footerTitleFont` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `asideFont` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `buttonBackground` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `heroicFont` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `pageHeading` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `dividingLines` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`themeColorID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `themeColors`
--

INSERT INTO `themeColors` (`themeColorID`, `headerBackground`, `footerBackground`, `asideBackground`, `masterBackground`, `buttonHover`, `buttonFont`, `linkFont`, `linkHover`, `masterFont`, `headerFont`, `footerFont`, `headerTitleFont`, `footerTitleFont`, `asideFont`, `buttonBackground`, `heroicFont`, `pageHeading`, `dividingLines`) VALUES
(1, '5B5D5E', '5B5D5E', '5B5D5E', 'FAFBFF', '252626', 'FAFBFF', '000000', '0038D4', '252626', 'FAFBFF', 'FAFBFF', 'FAFBFF', 'FAFBFF', '252626', '5B5D5E', 'FAFBFF', '252626', '252626');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(10) NOT NULL AUTO_INCREMENT,
  `roleID` int(10) NOT NULL,
  `firstName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `lastName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `username` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `emailNotification` tinyint(1) NOT NULL DEFAULT '0',
  `userCreateDate` datetime NOT NULL,
  PRIMARY KEY (`userID`),
  KEY `FK_users1` (`roleID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `roleID`, `firstName`, `lastName`, `email`, `username`, `password`, `active`, `emailNotification`, `userCreateDate`) VALUES
(1, 2, 'bullDogCMS', 'Admin', 'admin@somewhere.com', 'administrator', '$2y$10$sDkxekTNINoAo63u0wWpFeGmkArxkw5ow61qowW0MSwDVCAPrfaza', 1, 0, '2017-01-05 12:58:26');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
