$(window).scroll(function(){
    if($(this).scrollTop() >= 200) 
    {
        $('ul').css('top', 0);
        $('ul').css('position', 'fixed');
    }
    else
    {
        $('ul').css('top', 200);
        $('ul').css('position', 'absolute');
    }
});