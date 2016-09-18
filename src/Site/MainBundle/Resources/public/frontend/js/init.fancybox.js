jQuery(function(){
    $(".fancybox").fancybox({
        'titleShow': false,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'href': this.href,
        'type': 'iframe'
    });
});