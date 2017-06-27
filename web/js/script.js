$(window).scroll(function(){
    var top = parseInt($('header').css('height'));
    if($(this).scrollTop() >= top)
    {
        $('.main_menu').css('top', 0);
        $('.main_menu').css('position', 'fixed');
        $('.profile_menu').css('top', 70);
        $('.profile_menu').css('position', 'fixed');
    }
    else
    {
        $('.main_menu').css('top', top);
        $('.main_menu').css('position', 'absolute');
        $('.profile_menu').css('top', 20);
        $('.profile_menu').css('position', 'absolute');
    }
    /*
    if($(this).scrollTop() >= top)
    {
        $('.profile_menu').css('top', 0);
        $('.profile_menu').css('position', 'fixed');
    }
    else
    {
        $('.profile_menu').css('top', top);
        $('.profile_menu').css('position', 'absolute');
    }
    */
});

var domain = null;

$(window).ready(function(){
    
    show_form("ul .login img", '.popup .login');
    show_form("ul .reg img", '.popup .registration');
    change_form_click(".popup form .login table tr td span", '.popup .login', '.popup .resetpass');
    change_form_click(".popup form .resetpass table tr td .bt_cancel", '.popup .resetpass', '.popup .login');
    hideAll_form_click();
    
    domain = $('body').data('domain');
    
    ajaxFormRequest(domain + 'api/auth', '.form_login');
    ajaxFormRequest(domain + 'api/reg', '.form_registration');
    
    $(selector).click(function () {
        $('.popup').css('visibility', 'visible');
        $(form_selector).css('visibility', 'visible');
        $(form_selector).animate({top: "50%"}, 300);
    });
    ajaxFormRequest(domain + 'api/logout', '');
});

function edit_about()
{
    var text = $('.p_about').text();
    
    $('.p_about').replaceWith('<form class="form_about" method="post" action="api/editabout">\n\
        <input type="submit" value="" class="ok_about">\n\
        <textarea name="about_text" class="about_text"></textarea></form>');
    $('.about_text').text(text);
    $('.edit_img_about').css("visibility", "hidden");
}

function preview_click()
{
    $('.form_addpost').attr('target', '_blank');
    $('.form_addpost').attr('action', '../post/preview');
}

function addpost_click()
{
    $('.form_addpost').attr('target', '');
    $('.form_addpost').attr('action', '../api/addpost');
}

function edit_flname()
{
    $('#h1_flname').replaceWith('<form class="form_flname" method="post" action="api/editflname">\n\
        <input type="text" class="fname" name="fname" placeholder="Имя" pattern="^[a-zA-Zа-яА-Я]{2,18}$" required>\n\
        <input type="text" class="lname" name="lname" placeholder="Фомилия" pattern="^[a-zA-Zа-яА-Я]{2,18}$" required>\n\
        <input type="submit" value=""></form>');
    $('.edit_img').css("visibility", "hidden");
}

function edit_country()
{
    $(location).attr('href', 'api/editcountry');
}

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
                beforeSend: function(){
                    parent = $(form_selector + ' input[type="submit"]').parent();
                    html = $(parent).html();
                    $(parent).html('<img src="/images/loading.png" class="img_loading">');
                },
                success: function(data){
                    data = JSON.parse(data);
                    if(data.error !== '0')
                    {
                        $(form_selector + ' .status label').text(data.error);
                        $(parent).html(html);
                    }
                    else
                    {
                        $(parent).html(html);
                        if(form_selector === '.form_login')
                        {
                            hideAll_form();
                            location.reload();
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