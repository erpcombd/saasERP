

const mobileScreen = window.matchMedia("(max-width: 990px )");
$(document).ready(function () {
    $(".dashboard1-nav-dropdown-toggle").click(function () {
        $(this).closest(".dashboard1-nav-dropdown")
            .toggleClass("show")
            .find(".dashboard1-nav-dropdown")
            .removeClass("show");
        $(this).parent()
            .siblings()
            .removeClass("show");
    });

    //$(".menu-toggle").click(function () {
    //    if (mobileScreen.matches) {
    //        $(".dashboard1-nav").toggleClass("mobile-show");
    //    } else {
    //        $(".dashboard1").toggleClass("dashboard1-compact");
    //    }
    //});
});




$(document).on('click','.dashboard1-nav-dropdown-menu .dashboard1-nav-dropdown-item',function(){
    $(this).addClass('active1').siblings().removeClass('active1')
})







//
//
//
//
//const mobileScreen = window.matchMedia("(max-width: 990px )");
//$(document).ready(function () {
//    $(".dashboard1-nav-dropdown-toggle").click(function () {
//        $(this).closest(".dashboard1-nav-dropdown")
//            .toggleClass("show")
//            .find(".dashboard1-nav-dropdown")
//            .removeClass("show");
//        $(this).parent()
//            .siblings()
//            .removeClass("show");
//    });
//
//    //$(".menu-toggle").click(function () {
//    //    if (mobileScreen.matches) {
//    //        $(".dashboard1-nav").toggleClass("mobile-show");
//    //    } else {
//    //        $(".dashboard1").toggleClass("dashboard1-compact");
//    //    }
//    //});
//
//});