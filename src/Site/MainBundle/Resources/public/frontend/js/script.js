jQuery(function() {
    //  Инициализация слайдера на главной
    jQuery('.slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true,
        autoplay: false,
        autoplaySpeed: 3000
    });
});