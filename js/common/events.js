(function($){
    $(document).ready(function(){

        var ajaxurl = $('body').data('admin-url') + 'admin-ajax.php';
        var themeUrl = $('body').data('theme-url');

        // why choose
        $('.whychoose-container').owlCarousel({
            pagination: false,
            navigation: true,
            navigationText: ['<i class="fa fa-angle-left fa-5x"></i>', '<i class="fa fa-angle-right fa-5x"></i>'],
            autoPlay: true,
            items: 3,
            itemsTablet: [768, 2],
            itemsMobile: [479, 1]
        });

        $('.widget-promos').owlCarousel({
            stopOnHover: true,
            navigation: true,
            pagination: false,
            navigationText: ['<i class="fa fa-angle-left fa-5x"></i>', '<i class="fa fa-angle-right fa-5x"></i>'],
            autoPlay: true,
            singleItem: true,
            slideSpeed: 2000
        });

        var lightboxButton = $('.gallery-lightbox');
        $.initLightBox(lightboxButton);

    });
}(jQuery));