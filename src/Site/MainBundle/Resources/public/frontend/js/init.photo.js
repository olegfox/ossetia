jQuery(function(){
    if($('.gallery').length > 0){
        $(".gallery").each(function(i, e){

            $(e).unbind('click').click(function(){
                if (window.history.pushState) {
                    var href = $(this).find('a').eq(0).data('href');
                    window.history.pushState(null, null, href);
                }
                Code.photoSwipe('a', this);
                Code.PhotoSwipe.Current.show(0);
                setTimeout(function(){
                    $('.ps-toolbar-close').click(function(){
                        if (window.history.pushState) {
                            window.history.back();
                        }
                    });
                }, 1000);


                return false;
            });

            $(e).parent().parent().find(".name").unbind('click').click(function(){
                $(e).click();
            });

        });
    }

    $("#photo-block .wrap-photo").each(function(i, e){
        $(e).unbind('click').click(function(){
            Code.photoSwipe('a', '#photo-block');
            Code.PhotoSwipe.Current.show(i);
        });
    });
});