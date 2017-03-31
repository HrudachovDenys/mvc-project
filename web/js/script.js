$(window).scroll(function(){
    var top = parseInt($('header').css('height'));
    if($(this).scrollTop() >= top)
    {
        $('ul').css('top', 0);
        $('ul').css('position', 'fixed');
    }
    else
    {
        $('ul').css('top', top);
        $('ul').css('position', 'absolute');
    }
});

$(window).ready(function(){

    $("ul .login a").click(function () {
        $('.popup').css('visibility', 'visible');
        $('.popup .login').css('visibility', 'visible');
    });

    $("ul .reg a").click(function () {
        $('.popup').css('visibility', 'visible');
        $('.popup .reg').css('visibility', 'visible');
    });

    $(".popup .overlay").click(function () {
        if($('.popup').css('visibility') == 'visible')
        {
            $('.popup').css('visibility', 'hidden');
            $('.popup .login').css('visibility', 'hidden');
            $('.popup .reg').css('visibility', 'hidden');
        }
    });
});