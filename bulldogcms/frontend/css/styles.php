<?php

//!!!!!Start styles.php

include "../includes/db.php";

//set content-type so the browser interprets it as a css file
//header('content-type: text/css; charset: UTF-8');

//get all of the user-defined color data from the database
//global $connection;

$query = "SELECT * FROM themeColors WHERE themeColorID = '1' ";
$getColors = mysqli_query($connection, $query);

while($row = mysqli_fetch_assoc($getColors)){
    $headerBackground = $row['headerBackground'];
    $footerBackground = $row['footerBackground'];
    $asideBackground = $row['asideBackground'];
    $masterBackground = $row['masterBackground'];
    $buttonFont = $row['buttonFont'];
    $linkFont = $row['linkFont'];
    $linkHover = $row['linkHover'];
    $masterFont = $row['masterFont'];
    $headerFont = $row['headerFont'];
    $footerFont = $row['footerFont'];
    $headerTitleFont = $row['headerTitleFont'];
    $footerTitleFont = $row['footerTitleFont'];
    $asideFont = $row['asideFont'];
    $buttonBackground = $row['buttonBackground'];
    $buttonHover = $row['buttonHover'];
    $heroicFont = $row['heroicFont'];
    $pageHeading = $row['pageHeading'];
    $dividingLines = $row['dividingLines'];
}

$query2 = "SELECT * FROM headerLayout WHERE headerID='1' ";
$getHeaderLayout = mysqli_query($connection, $query2);

while($row = mysqli_fetch_assoc($getHeaderLayout)){
    $headerHeight = $row['headerHeight'];
    $headerHTML = $row['headerHTML'];
}

if (isset($headerHTML) && $headerHTML != ""){
    $actualHeaderHeight = $headerHeight + 50;
} else {
    $actualHeaderHeight = $headerHeight;
}

?>

/*Set user defined colors*/
body {
background-color: <?php if(isset($masterBackground)) {echo "#" . $masterBackground;} ?>;
color: <?php if(isset($masterFont)) {echo "#" . $masterFont;} ?>;
padding-top: 0px;
}

h1, h2, h3 {
color: <?php if(isset($pageHeading)) {echo "#" . $pageHeading;} ?>;
}

.navbar-inverse {
background-color: <?php if(isset($headerBackground)) {echo "#" . $headerBackground;} ?>;
}

.navbar-inverse .navbar-nav>li>a {
color: <?php if(isset($headerFont)) {echo "#" . $headerFont;} ?>;
font-weight: bold;
}

.dropdown-menu {
background-color: <?php if(isset($headerFont)) {echo "#" . $headerFont;} ?>;
}
.dropdown-menu>li>a {
color: <?php if(isset($headerBackground)) {echo "#" . $headerBackground;} ?>;
font-weight: bold;
}

.navbar-footer {
background-color: <?php if(isset($footerBackground)) {echo "#" . $footerBackground;} ?>;
}

.navbar-footer .navbar-nav>li>a {
color: <?php if (isset($footerFont)) {echo "#" . $footerFont;} ?>;
background-color: <?php if(isset($footerBackground)) {echo "#" . $footerBackground;} ?>;
font-weight: bold;
}

.nav>li>a:hover {
color: #FFF;
background-color: <?php if(isset($footerBackground)) {echo "#" . $footerBackground;} ?>;
}

.nav>li>a:focus {
color: #FFF;
background-color: <?php if(isset($footerBackground)) {echo "#" . $footerBackground;} ?>;
}

.navbar-nav>li>a:hover {
color: #FFF;
}

.navbar-nav-footer {
background-color: <?php if(isset($footerBackground)) {echo "#" . $footerBackground;} ?>;
margin: 7.5px -15px;
}
.navbar-nav-footer > li > a {
padding-top: 10px;
padding-bottom: 10px;
line-height: 20px;
float: none;
color: <?php if (isset($footerFont)) {echo "#" . $footerFont;} ?>;
background-color: <?php if(isset($footerBackground)) {echo "#" . $footerBackground;} ?>;
font-weight: bold;
}

.headerTitle {
color: <?php if(isset($headerTitleFont)) {echo "#" . $headerTitleFont;} ?>;
font-size: 1.5em;
display: block;
float: right;
line-height: 50px;
}

.headerText {
color: <?php if(isset($headerFont)) {echo "#" . $headerFont;} ?>;
}

footer {
background-color: <?php if(isset($footerBackground)) {echo "#" . $footerBackground;} ?>;
color: <?php if(isset($footerFont)) {echo "#" . $footerFont;} ?>;
width: 100%;
margin: auto;
padding: 1% 2% 1px 2%;
} .footerTitle {
color: <?php if(isset($footerTitleFont)) {echo "#" . $footerTitleFont;} ?>;
}

.well {
background-color: <?php if(isset($asideBackground)) {echo "#" . $asideBackground;} ?>;
color: <?php if(isset($asideFont)) {echo "#" . $asideFont;} ?>;
}

.btn-primary {
background-color: <?php if(isset($buttonBackground)) {echo "#" . $buttonBackground;} ?>;
color: <?php if(isset($buttonFont)) {echo "#" . $buttonFont;} ?>;
border-color: rgba(0,0,0,0.2);
} .btn-primary:hover {
background-color: <?php if(isset($buttonHover)) {echo "#" . $buttonHover;} ?>;
border-color: rgba(0,0,0,0.2);
}

a {
color: <?php if(isset($linkFont)) {echo "#" . $linkFont;} ?>;
} a:hover {
color: <?php if(isset($linkHover)) {echo "#" . $linkHover;} ?>;
text-decoration: none;
}

.header-row {
color: <?php if(isset($headerFont)) {echo "#" . $headerFont;} ?>;
font-size: 1em;
margin-top: 5px;
margin-bottom: 5px;
}

.vertNav{
border-left: 2px solid <?php if(isset($footerFont)) {echo "#" . $footerFont;} ?>;
}

.hero h1{
color: <?php if(isset($heroicFont)) {echo "#" . $heroicFont;} ?>;
font-size: 4.1em;
margin: auto;
position: absolute;
top: 120px;
left: 0;
right: 0;
bottom: 0;
z-index: 1;
}
.hero p{
color: <?php if(isset($heroicFont)) {echo "#" . $heroicFont;} ?>;
font-size: 1.5em;
margin: auto;
position: absolute;
top: 200px;
left: 0;
right: 0;
bottom: 0;
z-index: 1;
}

hr {
background-color: <?php if(isset($dividingLines)) {echo "#" . $dividingLines;} ?>;
height: 1px;
}
.page-header {
border-bottom: 1px solid <?php if(isset($dividingLines)) {echo "#" . $dividingLines;} ?>;
}

.well>ul>li>a {
color: <?php if(isset($asideFont)) {echo "#" . $asideFont;} ?>;
} .well>ul>li>a:hover {
text-decoration: underline;
}


/*Front end new styles, style overrides, and media queries*/

small {
font-size: 70%;
}

.container {
width: 98%;
}

.aside {
margin-top: 0px;
}

.search {
margin-top: 10px;
float: right;
}

.thumbnail {
height: 330px;
}

.thumbnail .caption {
padding-top: 0px;
}

.imageContainer, .imageContainer>a>img {
height: 197px;
padding: 1px;
}

.footSection{
padding: 5px;
}

img.headerLogo {
margin: 0;
float: left;
height: <?php if(isset($headerHeight)) {echo $headerHeight . "px";} ?>;
width: auto;
}

.navbar-brand {
float: left;
height: <?php if(isset($headerHeight)) {echo $headerHeight . "px";} ?>;
padding: 0;
margin: 0;
}

.artListImage {
width: 100%;
height: auto;
display: block;
float: left;
margin: 10px 20px 5px 0px;
}

img {
margin: 10px;
}

.nav>li>a {
padding: 10px 10px;
}

.readMore {
margin-left: 10px;
}

.xPadding {
padding: 10px;
margin: auto auto;
}

.artImage {
display: block;
float: left;
max-width: 50%;
height: auto;
margin: 5px 20px 5px 0px;
}

.catListImage {
margin: auto;
height: 100%;
width: auto;
}

.catListContentArea {
height: 62px;
margin: auto;
padding: 0px;
}

h3 {
font-size: 1.5em;
}

div.hero{
clear: both;
width: 100%;
text-align: center;
margin: 0;
position: relative;
color: white;
height: auto;
}

.hero img{
width: 100%;
margin: 0;
}

.hero-feature {
margin-bottom: 5px;
}

.col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
padding-right: 10px;
padding-left: 10px;
}

<!--/*code adapted from https://css-tricks.com/snippets/css/prevent-long-urls-from-breaking-out-of-container*/-->
.dont-break-out {

/* These are technically the same, but use both */
overflow-wrap: break-word;
word-wrap: break-word;

word-break: keep-all;

/* Adds a hyphen where the word breaks, if supported (No Blink) */
-ms-hyphens: auto;
-moz-hyphens: auto;
-webkit-hyphens: auto;
hyphens: auto;

}

<!--Code based on W3.CSS Responsive Fluid Grid, found at; https://www.w3schools.com/w3css/w3css_grid.asp-->
<!--/* W3.CSS 2.95 Feb 2017 by Jan Egil and Borge Refsnes */-->
.w3-container:after,.w3-container:before,.w3-row:after,.w3-row:before,.w3-row-padding:after,.w3-row-padding:before {
content:"";display:table;clear:both
}
.w3-container {
padding:0.01em 16px
}
.w3-col {
color: <?php if(isset($headerFont)) {echo "#" . $headerFont;} ?>;
float:left;
width:100%;
}
.w3-col.s6 {
width:49.99999%
}

.v-center {
    height: <?php if(isset($headerHeight)) {echo $headerHeight . "px";} ?>;
    display: block;
    float: left;
}

.navbar-nav-footer {
margin: 0 10px;
}
.navbar-nav-footer>li>a {
padding-top: 0px;
padding-bottom: 5px;
}

.pdf_viewer {
margin-bottom: 15px;
}

<!--Media Queries -->

@media (max-width:670px){
.headerTitle{
font-size: 1.2em;
}
}

@media(min-width:768px){
p {
font-size: 17px;
line-height: 1.5;
margin-bottom: 15px;
}

navbar-right.navbar-nav {
margin: 0 -30px;
}

.pdf_viewer {
width: 75%;
height: 800px;
}

#bottomSpacer {
visibility: hidden;
}
}

@media (min-width: 1200px){
.right-under-nav{
margin-top: -25px;
}
}

@media all and (max-width: 768px) {
.hero{
height: 50vw;
}
.hero h1{
font-size: 8vw;
top: 13vw;
}
.hero p{
font-size: 3vw;
top: 23vw;
}

.pdf_viewer {
width: 100%;
height: 500px;
}

.w3-col {
visibility: hidden;
}

.artImage {
display: block;
margin: auto;
width: 100%;
padding-bottom: 10px;
}

li {
margin: 0;
padding 0;
}

.c-sm {
text-align: center;
}
}

@media (max-width: 480px) {
.headerTitle {
font-size: 1em;
}
}