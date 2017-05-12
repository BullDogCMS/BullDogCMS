$(document).ready(function(){

    $("body").css("margin-top", $("nav").height());

    $(window).resize( function(){

        $("body").css("margin-top", $("nav").height());

    });

});
