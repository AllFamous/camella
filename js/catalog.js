(function($){
        var getTemplate = function(template_id, data ){
                var template = $('#' + template_id).html();
                data = ! data ? {} : data;
                
                return _.template( template, {data:data} );
        };
        
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

        var lightboxButton = $('.gallery-lightbox');
        $.initLightBox(lightboxButton);

        var firstCatalogId = $('.catalog-buttons a:first-child').data('catalog-id');
        $('.catalog-buttons a:first-child').addClass('active');

        if ($('.series-house-item').length >= 1){
            selectCatalog(firstCatalogId);
        }

        function selectCatalog(catalogId){
            $('.series-house-item').owlCarousel({
                pagination: true,
                navigation: true,
                navigationText: ['<i class="fa fa-angle-left fa-5x"></i>', '<i class="fa fa-angle-right fa-5x"></i>'],
                autoPlay: true,
                items: 4
            });
            var carouselCatalog = $('.series-house-item').data('owlCarousel');

            // remove contents add loading
            carouselCatalog.destroy();
            $('.series-house-item').css('display', 'block');
            var loadingElement = '<div class="text-center"><i class="fa fa-spinner fa-pulse fa-2x text-grey"></i></div>';
            $('.series-house-item').html(loadingElement);

            $.ajax({
                url: ajaxurl,
                dataType: 'JSON',
                data: {'action': 'get-catalog', 'catalogId': catalogId},
                success: function(data){ 
                    loadCatalogItems($('.series-house-item'), data, catalogId);
                }
            });
            
            // Get locations
            loadLocations(catalogId);
             
        }
        
        // Get locations
        function loadLocations(series_id){
                var url = self.location,
                        location_container = $('#location-lists-container'),
                        nonce = location_container.data('nonce');
                $.get(url, {nonce:nonce,category_id:series_id}, function(response){ 
                        location_container.empty().html(response);
                });
        }

        // load index catalog items
        function loadCatalogItems(elementContainer, data, catalogId){
            elementContainer.html('');
            if (data.length == 0){
                elementContainer.html('<div class="text-center">Sorry, there are no items to show. Please try a different one.</div>');
            } else {
                var string = '<div class="table-responsive"><table class="table">'
                        active_catalog = $('.catalog-buttons a[data-catalog-id="' + catalogId +'"]'),
                        series_name = active_catalog.data('catalog'),
                        no_maids_room = (series_name == 'bungalow-series' || series_name == 'lessandra-series');
                
                string += '<thead><tr><th style="width:8%;"></th>';
                string += '<th style="width:8%;" class="text-center"><i class="fa fa-home fa-2x" data-toggle="tooltip" data-placement="top" title="firewall / house type"></i><br><div class="label label-secondary">House Type</div></th>';
                string += '<th class="text-center"><i class="fa fa-expand fa-2x" data-toggle="tooltip" data-placement="top" title="floor area (sqm)"></i><br><div class="label label-secondary">Floor Area</div></th>';
                string += '<th class="text-center"><i class="fa fa-arrows-alt fa-2x" data-toggle="tooltip" data-placement="top" title="minimum lot area (sqm)"></i><br><div class="label label-secondary">Lot Area</div></th>';
               // string += '<th style="width: 8%" class="text-center"><i class="fa fa-bed fa-2x" data-toggle="tooltip" data-placement="top" title="master bedroom"></i><br><div class="label label-secondary">Master Bedroom</div></th>';
               // string += '<th style="width: 8%" class="text-center"><i class="fa fa-tint fa-2x" data-toggle="tooltip" data-placement="top" title="master bedroom toilet & bath"></i><br><div class="label label-secondary">MB Toilet/Bath</div></th>';
                string += '<th class="text-center"><i class="fa fa-bed fa-2x" data-toggle="tooltip" data-placement="top" title="bedrooms"></i><br><div class="label label-secondary">Bedrooms</div></th>';
                string += '<th class="text-center"><i class="fa fa-tint fa-2x" data-toggle="tooltip" data-placement="top" title="common toilet & bath"></i><br><div class="label label-secondary">Toilet/Bath</div></th>';
                
                if ( !no_maids_room ) {                
                        string += '<th class="text-center"><i class="fa fa-bed fa-2x" data-toggle="tooltip" data-placement="top" title="maid\'s room"></i><br><div class="label label-secondary">Maid\'s Room</div></th>';
                }
                string += '<th class="text-center"><i class="fa fa-square fa-2x" data-toggle="tooltip" data-placement="top" title="balcony"></i><br><div class="label label-secondary">Balcony</div></th>';
                string += '<th class="text-center"><i class="fa fa-car fa-2x" data-toggle="tooltip" data-placement="top" title="car port"></i><br><div class="label label-secondary">Car Garage</div></th>';
                string += '<th style="width: 8%" class="text-center"><i class="fa fa-credit-card fa-2x" data-toggle="tooltip" data-placement="top" title="Price"></i><br><div class="label label-secondary">Price</div></th>';
                $(data).each(function(count, value){
                    string += '<tr>';
                    // check if floor plan exists and video exists
                    var floorPlanLink = '';
                    var videoTourLink = '';
                    if (value['custom_field']['floorPlanImage']){
                        var floorplan_img = value['custom_field']['floorPlanImage'] ? value['custom_field']['floorPlanImage']['url'] : '';
                        floorPlanLink = '<a href="'+value['custom_field']['floorPlanImage']+'" data-title="' + value.post_title + ' Floor Plan" data-remote="' + floorplan_img + '" class="btn btn-secondary btn-xs" data-toggle="lightbox">Floor Plan</a>';
                    }
                    if (value['custom_field']['videoTourLink']){
                        videoTourLink = '<a href="'+value['custom_field']['videoTourLink']+'" class="btn btn-secondary btn-xs" data-toggle="lightbox">Video Tour</a>';
                    }
                    
                    //string += '<td><div class="text-center"><a href="'+value['model_permalink']+'" data-toggle="tooltip" data-placement="top" title="'+value['post_title']+'"><img src="'+value['custom_field']['modelImage']+'" width="100px;"></a><a href="'+value['model_permalink']+'" data-toggle="tooltip" data-placement="top" title="'+value['post_title']+'"><h4>'+value['post_title']+'</h4></a><div>'+floorPlanLink+''+videoTourLink+'</div></div></td>';
                    string += '<td><div class="text-center">';
                    string += '<a href="#" data-toggle="lightbox" data-gallery="houseItem' + count + '" data-remote="' + value['custom_field']['modelImage'] + '" data-title="' + value['post_title'] + '" class="gallery-lightbox catalog-gallery" data-count="' + count + '" data-toggle="tooltip" data-placement="top" title="View Gallery"><img src="'+value['custom_field']['modelImage']+'" width="100px;"></a>';
                    string += '<a href="'+value['model_permalink']+'" data-toggle="tooltip" data-placement="top" title="'+value['post_title']+'"><h4>'+value['post_title']+'</h4></a><div>'+floorPlanLink+''+videoTourLink+'</div>';
                    string += '</div></td>';
                    
                    string += '<td class="text-center" style="vertical-align: middle">'+$.formatFirewallType(value['custom_field']['firewallType'])+'</td>';
                    string += '<td class="text-center" style="vertical-align: middle">'+value['custom_field']['houseArea']+'</td>';
                    string += '<td class="text-center" style="vertical-align: middle">'+value['custom_field']['lotAreaHouse']+'</td>';
                    //string += '<td class="text-center" style="vertical-align: middle">'+$.formatInclusions(value['custom_field']['mastersBedroom'])+'</td>';
                    //string += '<td class="text-center" style="vertical-align: middle">'+$.formatInclusions(value['custom_field']['mastersBedroomTb'])+'</td>';
                    string += '<td class="text-center" style="vertical-align: middle">'+value['custom_field']['bedrooms']+'</td>';
                    string += '<td class="text-center" style="vertical-align: middle">'+value['custom_field']['bathrooms']+'</td>';
                    
                    if ( ! no_maids_room ) {
                        string += '<td class="text-center" style="vertical-align: middle">'+$.formatInclusions(value['custom_field']['maidsRoom'])+'</td>';
                    }
                    string += '<td class="text-center" style="vertical-align: middle">'+$.formatInclusions(value['custom_field']['balcony'])+'</td>';
                    string += '<td class="text-center" style="vertical-align: middle">'+value['custom_field']['garage']+'</td>';
                    string += '<td class="text-center" style="vertical-align: middle"><span>'+value['custom_field']['modelPriceLow']+'</span> to <span>'+value['custom_field']['modelPriceHigh']+'</span></td>';
                    string += '</tr>';
                });
                
                string += '</table></div>';
                elementContainer.append(string);
                $('body').find('table tr td span').formatCurrency({ symbol: 'PHP', roundToDecimalPlace: 0 });
                $('body').tooltip({ selector: '[data-toggle=tooltip]' });
                
                // Add click event to popup gallery
                elementContainer.find('.catalog-gallery').click(function(){
                        var anchor_toggler = $(this),
                                count = anchor_toggler.data('count'),
                                value = data[count];
                                
                        if ( value && value.custom_field && value.custom_field.imageGallery ) {
                                if ( !anchor_toggler.is('.gallery-added')) {
                                        var images = value.custom_field.imageGallery,
                                                template = getTemplate( 'catalog-gallery-html', {
                                                        title:anchor_toggler.data('title'),
                                                        images:images, count:count});
                                                
                                        $(document.body).append(template);
                                }
                        }
                        anchor_toggler.ekkoLightbox();
                        return false;
                });
            }
        }

        $('.catalog-buttons a').click(function(event){
            event.preventDefault();
            $('.catalog-buttons a').removeClass('active');
            var catalogId = $(this).data('catalog-id');
            $(this).addClass('active');
            selectCatalog(catalogId);
        });

        $('.series-catalog-item').owlCarousel({
            pagination: true,
            navigation: true,
            navigationText: ['<i class="fa fa-angle-left fa-5x"></i>', '<i class="fa fa-angle-right fa-5x"></i>'],
            autoPlay: true,
            items: 4
        });
        
        /*********************************
         * Retrieve location properties **/
        
        $('#location-container').each(function(){
                var container = $(this);
                
                if ( container.data('nonce')) {
                        var nonce = container.data('nonce'),
                                url = self.location,
                                post_id = container.data('post_id');
                                
                        $.get(url, {nonce:nonce, post_id:post_id}, function(response){
                                container.html(response);
                        });
                }
        });
        
        /******************
         * Set catalog value for search inquries
         *****************************************/
        $('[data-catalogs="true"]').each(function(){
                if ( window.Camella.catalog ) {
                        alert(window.Camella.catalog);
                }
        });
    });
}(jQuery));