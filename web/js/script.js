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
        $('.popup .login').animate({top: "50%"}, 300);
    });


    $(".popup .overlay, .popup_closer").click(function () {
        if($('.popup').css('visibility') === 'visible')
        {
            $('.popup .login').animate({top: "-50%"}, 300);
            setTimeout(function(){
                $('.popup .login').css('visibility', 'hidden');
                $('.popup .reg').css('visibility', 'hidden');
                $('.popup').css('visibility', 'hidden');
            }, 300);
        }
    });
});