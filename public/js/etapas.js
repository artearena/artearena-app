$(document).ready(function() {
    $(".oneAct").click(function() {
        console.log('teste');
        $(this).addClass("active");
        $(".oneAct, .two, .three, .four, .five").removeClass("active");
    });

    $(".two").click(function() {
        $(".one, .two").addClass("active");
        $(".three, .four, .five").removeClass("active");
    });

    $(".three").click(function() {
        $(".one, .two, .three").addClass("active");
        $(".four, .five").removeClass("active");
    });

    $(".four").click(function() {
        $(".one, .two, .three, .four").addClass("active");
        $(".five").removeClass("active");
    });

    $(".five").click(function() {
        $(".one, .two, .three, .four, .five").addClass("active");
    });
});