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
    
    show_form("ul .login a", '.popup .login');
    show_form("ul .reg a", '.popup .registration');
    change_form(".popup form .login table tr td span", '.popup .login', '.popup .resetpass');
    change_form(".popup form .resetpass table tr td .bt_cancel", '.popup .resetpass', '.popup .login');
    hideAll_form();
});

function change_form(click_selector, what_selector, for_selector){
    $(click_selector).click(function () {
        $(what_selector).animate({top: "-50%"}, 300);
        $(for_selector).css('visibility', 'visible');
        $(for_selector).animate({top: "50%"}, 300);
        
        setTimeout(function(){
            $(what_selector).css('visibility', 'hidden');
        }, 300);
    });
}

function show_form(selector, form_selector){
    $(selector).click(function () {
        $('.popup').css('visibility', 'visible');
        $(form_selector).css('visibility', 'visible');
        $(form_selector).animate({top: "50%"}, 300);
    });
}

function hideAll_form(){
    $(".popup .overlay, .popup_closer").click(function () {
        if($('.popup').css('visibility') === 'visible')
        {
            $('.popup .login').animate({top: "-50%"}, 300);
            $('.popup .resetpass').animate({top: "-50%"}, 300);
            $('.popup .registration').animate({top: "-50%"}, 300);
            setTimeout(function(){
                $('.popup .login').css('visibility', 'hidden');
                $('.popup .resetpass').css('visibility', 'hidden');
                $('.popup .registration').css('visibility', 'hidden');
                $('.popup').css('visibility', 'hidden');
            }, 300);
        }
    });
}