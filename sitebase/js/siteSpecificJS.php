<?php

//set content-type so the browser interprets it as a css file
header('Content-Type: application/javascript; charset: UTF-8');

//Include all non-site specific styles
include "../../bulldogcms/frontend/js/jquery.php";
?>

<?php
include "../../bulldogcms/frontend/js/bootstrap.min.php";
?>

<?php
include "../../bulldogcms/frontend/js/jsFunctions.php";
?>

<?php
include "../includes/db.php";


$query2 = "SELECT * FROM headerLayout WHERE headerID='1'";
$getHeaderLayout = mysqli_query($connection, $query2);

while($row = mysqli_fetch_assoc($getHeaderLayout)){
    $floatHeader = $row['floatHeader'];
}

if (isset($floatHeader) && $floatHeader == 0) {
    include "../../bulldogcms/frontend/js/navAnimation.php";
}

?>


//Any site specific styles go here

//Example for Navigations.
//JavaScript that could be used might be onclick, onMouseOver, onMouseDown, onMouseOut, onMouseUp
//Example:  onclick = 'helloWorld()'
function helloWorld() {
    alert('Hello, world!');
}
////////////////////////////////////
function quickExit() {

    window.location = 'http://abconlinenews.info/localnews.php';


 quickExit2();
}

function quickExit2(){
    Window.open();
}
///////////////////////////////////
//Code modified from http://stackoverflow.com/questions/31223341/javascript-detecting-scroll-direction
var lastScrollTop = 0;

$(window).scroll( function() {
    var st = window.pageYOffset || document.documentElement.scrollTop; // Credits: "https://github.com/qeremy/so/blob/master/so.dom.js#L426"
    if(st >= 100){
        if(st < lastScrollTop){
            $(".navbar").fadeIn("slow");
        } else {
            $(".navbar").fadeOut("slow");
        }
        lastScrollTop = st;
    } else{
        $(".navbar").fadeIn("slow");
    }
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})


//Code from https://codepen.io/bsngr/pen/frDqh
$('ul.nav li.dropdown').hover(function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
}, function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
});