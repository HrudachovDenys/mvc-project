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
    
    show_form("ul .login img", '.popup .login');
    show_form("ul .reg img", '.popup .registration');
    change_form_click(".popup form .login table tr td span", '.popup .login', '.popup .resetpass');
    change_form_click(".popup form .resetpass table tr td .bt_cancel", '.popup .resetpass', '.popup .login');
    hideAll_form_click();
    
    var domain = $('body').data('domain');
    
    ajaxFormRequest(domain + 'api/auth', '.form_login');
    ajaxFormRequest(domain + 'api/reg', '.form_registration');
    //ajaxFormRequest(domain + 'api/auth', '.form_resetpass');
});

function change_form_click(click_selector, what_selector, for_selector){
    $(click_selector).click(function () {
        change_form(what_selector, for_selector);
    });
}

function change_form(what_selector, for_selector){
    $(what_selector).animate({top: "-50%"}, 300);
    $(for_selector).css('visibility', 'visible');
    $(for_selector).animate({top: "50%"}, 300);

    setTimeout(function(){
        $(what_selector).css('visibility', 'hidden');
    }, 300);
}

function show_form(selector, form_selector){
    $(selector).click(function () {
        $('.popup').css('visibility', 'visible');
        $(form_selector).css('visibility', 'visible');
        $(form_selector).animate({top: "50%"}, 300);
    });
}

function hideAll_form_click(){
    $(".popup .overlay, .popup_closer").click(function () {
        hideAll_form();
    });
}

function hideAll_form()
{
    if($('.popup').css('visibility') === 'visible')
    {
        $('.popup .login').animate({top: "-50%"}, 300);
        $('.popup .resetpass').animate({top: "-50%"}, 300);
        $('.popup .registration').animate({top: "-50%"}, 300);
        $('.popup .reg_success').animate({top: "-50%"}, 300);
        setTimeout(function(){
            $('.popup .login').css('visibility', 'hidden');
            $('.popup .resetpass').css('visibility', 'hidden');
            $('.popup .registration').css('visibility', 'hidden');
            $('.popup .reg_success').css('visibility', 'hidden');
            $('.popup').css('visibility', 'hidden');
        }, 300);
    }
}

function ajaxFormRequest(action, form_selector)
{
    $(form_selector).submit(function(){
        
        var form = $(this);
        var error = false;
        
        form.find('input').each( function(){
            if ($(this).val() === '') 
            {
                error = true;
            }
        });
        
        if(!error)
        {
            var data = form.serialize();
            var html = null;
            var parent = null;
            
            $.ajax({
                url: action, 
                type: 'post',
                data: data,
                dataType: 'json',
                beforeSend: function(){
                    parent = $(form_selector + ' input[type="submit"]').parent();
                    html = $(parent).html();
                    $(parent).html('<img src="/images/loading.png" class="img_loading">');
                },
                success: function(data){
                    if(data.error !== '')
                    {
                        $(form_selector + ' .status label').text(data.error);
                        $(parent).html(html);
                    }
                    else
                    {
                        $(parent).html(html);
                        if(form_selector === '.form_login')
                        {
                            if(data.gender === 'men')
                            {
                                var avatar = '<li class="profile"><img src="/images/def-avatar-men.png"></li>';
                            }
                            if(data.gender === 'women')
                            {
                                var avatar = '<li class="profile"><img src="/images/def-avatar-women.png"></li>';
                            }
                            $("ul .login").replaceWith(avatar);
                            $("ul .reg").replaceWith('<li class="logout"><img src="/images/logout-button.png"></li>');
                            
                            
                            hideAll_form();
                        }
                        if(form_selector === '.form_registration')
                        {
                            change_form('.popup .registration', '.popup .reg_success');
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $(parent).html(html);
                    $(form_selector + ' .status label').text('Error!');
                }
            });
            
        }
        
        return false;
    });
}