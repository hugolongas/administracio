$(document).ready(function () {
    $(window).scroll(function (ev) {
        var scroll = $(window).scrollTop();
        if (scroll >= 20) {
            $(".nav-top").addClass("fixed-menu");
            $("#main").addClass("fixed-menu");
        }
        else {
            $(".nav-top").removeClass("fixed-menu");
            $("#main").removeClass("fixed-menu");
        }
    });
    var settings = {
        output: "bmp",
        bgColor: '#ffffff',
        color: '#000000',
        barWidth: 2,
        barHeight: 50,
        showHRI:true
    };
    var num_soci = $("#num_soci").val();
    if (num_soci > 0) {
        $("#carnet").barcode(num_soci.trim(),"code39",settings);
    }

    $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
        $("#main").toggleClass("sidebar-toggled");
        $(".aside").toggleClass("toggled");
        if ($(".aside").hasClass("toggled")) {
          $('.aside .collapse').collapse('hide');
        };
      });
});