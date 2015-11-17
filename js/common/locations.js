(function($){
    $(document).ready(function(){

        var ajaxurl = $('body').data('admin-url') + 'admin-ajax.php';

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

        $('.series-house-item').owlCarousel({
            pagination: false,
            navigation: true,
            navigationText: ['<i class="fa fa-angle-left fa-5x"></i>', '<i class="fa fa-angle-right fa-5x"></i>'],
            autoPlay: false,
            items: 4
        });

        var lightboxButton = $('.gallery-lightbox');
        $.initLightBox(lightboxButton);

        $('#index-properties').css('height', '600px').css('margin-top', '50px');

        function getProjects(catId){
            $.ajax({
                url: ajaxurl,
                dataType: 'JSON',
                data: {'action': 'get-projects', 'catId': catId},
                success: function(data){
                    $.loadMapMarkers('index-properties', 'property', data);
                }
            });
        }

        $('.projects-buttons a').click(function(event){
            event.preventDefault();
            $('.projects-buttons a').removeClass('active');
            var catId = $(this).data('location-id');
            $(this).addClass('active');
            getProjects(catId);
            var buttonText = $(this).html();
            switch(buttonText){
                case 'ALL':
                    buttonText = 'All Locations';
                    break;
                default:
                    buttonText = buttonText.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                        return letter.toUpperCase();
                    });
                    break;
            }
            $('.selected-title').html(buttonText);
            // show/hide panels
            showHidePanels(catId);
        });

        function showHidePanels(catId){
            if (catId == ''){
                $('.location-item').fadeIn();
            } else {
                $('.location-item').fadeIn(function(){
                    $('.location-item').not('[data-location-id="'+catId+'"]').fadeOut();
                });
            }
        }

        // check if sub category page is loaded
        var slugId = $('.project-lists').attr('data-page-category-id');
        var catId = '';
        if (!slugId == 0){
            catId = slugId;
            $('.projects-buttons a').removeClass('active');
            $('.projects-buttons a[data-location-id="'+slugId+'"]').addClass('active');
        }

        getProjects(catId);


        // gallery as carousel
        $('.gallery-container .list-inline').owlCarousel({
            pagination: true,
            navigation: true,
            navigationText: ['<i class="fa fa-angle-left fa-5x"></i>', '<i class="fa fa-angle-right fa-5x"></i>'],
            autoPlay: true,
            items: 5,
            itemsTablet: [768, 4],
            itemsMobile: [479, 1]
        });

    });
}(jQuery));