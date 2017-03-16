jQuery(function() {
    var $body = $('body');

    //  Инициализация слайдера на главной
    if (jQuery('.slider').length > 0) {
        jQuery('.slider').slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 5000,
            pauseOnFocus: false,
            pauseOnHover: false
        });
    }

    $('.mobile-menu').click(function() {
        var className = 'menu--open';
        if ($body.hasClass(className)) {
            $body.removeClass(className);
            setTimeout(function() {
                $body.find('.menu--background').remove();
            }, 200);
        } else {
            $body.addClass(className);
            $body.prepend($("<div></div>").addClass('menu--background'));
            $body.find('.menu--background').click(function() {
                var className = 'menu--open';
                if ($body.hasClass(className)) {
                    $body.removeClass(className);
                    setTimeout(function() {
                        $body.find('.menu--background').remove();
                    }, 200);
                }
            });
        }
    });

    $('.nav.nav-pills.black').prepend('<li></li>');
    $('.search').clone().appendTo('.nav.nav-pills.black li:first-child');
    $('.nav.nav-pills.black').find('li.active').append($('.subnav').clone());
});