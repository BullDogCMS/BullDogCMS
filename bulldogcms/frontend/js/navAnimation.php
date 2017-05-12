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