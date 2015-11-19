+function($){
        var ajaxurl = '',
        categoryCache = {},
        postsCache = {},
        getTemplate = function(template_id, data ){
                var template = $('#' + template_id).html();
                data = ! data ? {} : data;
                
                return _.template( template, {data:data} );
        };
        
        function getIslandGroups(){
            $.ajax({
                url: ajaxurl,
                dataType: 'JSON',
                data: {'action': 'get-islandgroups'},
                success: function(data){
                    var values = [];
                    $.each(data, function(i, value){
                        var categoryItem = {
                            'optionId' : value['cat_ID'],
                            'optionName' : value['name']
                        }
                        values.push(categoryItem);
                    });
                    $.updateSelect($('#refine-island-group'), values, 0);
                }
            });
        }
        
        function getRegionProvince(islandGroupId){
            $.ajax({
                url: ajaxurl,
                dataType: 'JSON',
                data: {'action': 'get-region-province', 'islandGroupId': islandGroupId},
                success: function(data){
                    var values = [];
                    $.each(data, function(i, value){
                        var categoryItem = {
                            'optionId' : value['cat_ID'],
                            'optionName' : value['name'],
                            'optionParent': value['parent'],
                            'optionSubCategory': []
                        }
                        values.push(categoryItem);
                        // add subcategories
                        $.each(value['sub_categories'], function(iSub, valueSub){
                            var subCategoryItem = {
                                'optionId': valueSub['cat_ID'],
                                'optionName': valueSub['name'],
                                'optionParent': valueSub['parent']
                            }
                            values[i]['optionSubCategory'].push(subCategoryItem);
                            
                                // Save results in cache **/
                                categoryCache[valueSub['cat_ID']] = valueSub;
                        });
                        
                    });
                    var type;
                    if(islandGroupId == ''){ type = 1; } else { type = 3; }
                    $.updateSelect($('#refine-province'), values, type);
                    $.updateSelect($('#hero-location'), values, type);
                }
            });
        }

        function getCity(regionProvinceId){
            $.ajax({
                url: ajaxurl,
                dataType: 'JSON',
                data: {'action': 'get-city', 'regionProvinceId': regionProvinceId},
                success: function(data){
                    var values = [];
                    $.each(data, function(i, value){
                        var categoryItem = {
                            'optionId' : value['cat_ID'],
                            'optionName' : value['name'],
                            'optionParent': value['parent'],
                            'optionSubCategory': []
                        }
                        values.push(categoryItem);
                        // add subcategories
                        $.each(value['sub_categories'], function(iSub, valueSub){
                            var subCategoryItem = {
                                'optionId': valueSub['cat_ID'],
                                'optionName': valueSub['name'],
                                'optionParent': valueSub['parent'],
                                'optionSubCategory': []
                            }
                            values[i]['optionSubCategory'].push(subCategoryItem);
                            // add subcategories
                            $.each(valueSub['sub_categories'], function(iSubSub, valueSubSub){
                                var subSubCategoryItem = {
                                    'optionId': valueSubSub['cat_ID'],
                                    'optionName': valueSubSub['name'],
                                    'optionParent': valueSubSub['parent'],
                                }
                                values[i]['optionSubCategory'][iSub]['optionSubCategory'].push(subSubCategoryItem);
                            });
                        });
                    });
                    var type;
                    if(regionProvinceId != ''){ type = 3; } else { type = 2; }
                    $.updateSelect($('#refine-city'), values, type);
                }
            });
        }
        
        function getProjects(catId, callback){
            $.ajax({
                url: ajaxurl,
                dataType: 'JSON',
                data: {'action': 'get-projects', 'catId': catId},
                success: function(data){
                        $.loadMapMarkers('index-properties', 'property', data);
                        $.loadMapMarkers('hero-locations-map', 'hero', data);
                    
                    // Save results to cache **/
                    for(var i in data ){
                        if ( data[i].ID ) {
                                postsCache[data[i]['ID']] = data[i];
                        }
                    }
                    if ( callback ) {
                        callback(data);
                    }
                }
            });
        }
        
$(document).ready(function(){
        ajaxurl = $('body').data('admin-url') + 'admin-ajax.php';
        
        // remove logo
        $('#top-nav').find('.brand').remove();
        
        // Resize video
        $.scaleVideoContainer();

        $.initBannerVideoSize('.video-container .poster img');
        $.initBannerVideoSize('.video-container .filter');
        $.initBannerVideoSize('.video-container video');
            
        $(window).on('resize', function() {
            $.scaleVideoContainer();
            $.scaleBannerVideoSize('.video-container .poster img');
            $.scaleBannerVideoSize('.video-container .filter');
            $.scaleBannerVideoSize('.video-container video');
        });
        
        /********
         * Hero Section
         **************/
        
        // custom class select2
        var heroSelects = $('.hero-footer select');
        var classArray = ['hero-select-location', 'hero-select-type', 'hero-select-range'];
        $(heroSelects).each(function(i, item){
            $(item).select2({
                containerCssClass: classArray[i],
                width: '100%',
                placeholder: 'select one',
                allowClear: true
            });
        });
        
        getIslandGroups();
        getRegionProvince('');
        getProjects('', function(){
                $('.section-ourproperties .map-container').removeClass('active');
                });
         
        // on hero location select
        $('#hero-location').on('select2:select', function(){
            var categoryId = $(this).val();
            $.getProperties(categoryId);
        });
        
        var panels = $('.location-container, .type-container, .range-container').find('.panel');
        
        $('.location-container, .type-container, .range-container').hover(function(){
                var is_show = true,
                        that = $(this);
                        
                // Do not show type-container panel if no location selected
                if (that.is('.type-container') ) {
                        var hero_location = $('#hero-location');
                        if (hero_location.val() == '' ) {
                                is_show = false;
                        }
                }
                
                if ( is_show  ) {
                        $(this).find('.panel').show();
                }
                if ( that.is('.location-container')) {
                        var mapHero = window.mapHero, mapBoundsHeror = window.mapBoundsHero;
                        google.maps.event.trigger(mapHero, 'resize');
                        mapHero.fitBounds(mapBoundsHero);
                }

        }, function(){
                $(this).find('.panel').hide();
        })
        .on('click', function(){
                panels.hide();
        });
        
        // hero submit
        $('#heroSearch').on('click', function(){
            var heroLocation = $('#hero-location').select2('val');
            var heroProject = $('#hero-property').select2('val');
            var heroRange = $('#hero-range').select2('val');
            var fieldsError = [];

            if (heroLocation == ''){
                fieldsError.push('Location');
            }
            if (heroProject == ''){
                fieldsError.push('Property');
            }
            if (heroRange == ''){
                fieldsError.push('Price Range');
            }
            // send error
            if (fieldsError.length >= 1){
                $.showAlert($('.hero-notice'), 'danger', 'Error', 'Please enter or select the following:', fieldsError);
            } else {
                var location_link = categoryCache[heroLocation] ? categoryCache[heroLocation]['permalink'] : null,
                        project_link = postsCache[heroProject] ? postsCache[heroProject].property_permalink : null,
                        range = $('#hero-range'),
                        high = range.data('high'),
                        low = range.data('low');
                        
                        if ( project_link ) {
                                window.open(project_link);
                        }
            }            
        });
        
        /*****
         * FOLD 2: Image Carousel
         ************************/
        $('.pillar-carousel a').each(function(){
                var img = $(this).data('image-url');
                $('<img>').attr('src', img).appendTo(this);
        });

        // initialize carousel
        $('#carousel-promos').owlCarousel({
            stopOnHover: true,
            pagination: false,
            navigation: true,
            navigationText: ['<i class="fa fa-angle-left fa-5x"></i>', '<i class="fa fa-angle-right fa-5x"></i>'],
            autoPlay: true,
            singleItem: true,
            slideSpeed: 2000
        });
        
        /*****
         * FOLD 3: 5 Point Advantage
         ****************************/
        // pillar panels effects
        $('.panel-pillars').hover(function(){
            $(this).prev().find('.key-icon').toggleClass('active');
        });
        
        $('.panel-pillars .panel-body').on('click', function(){
                var href = $('a.btn', $(this).parent()).attr('href');
                window.open(href);
        });
        $.forceEqualizePanels('.panel-pillars .panel-body');
        
        /*******
         * FOLD 5
         ***********/
        $('.communities-groups a').click(function(event){
            event.preventDefault();
            var container = $('.section-ourproperties .map-container');
            container.addClass('active');
            
            $('.communities-groups a').removeClass('active');
            var catId = $(this).data('location-id');
            $(this).addClass('active');
            
            getProjects(catId, function(){
                container.removeClass('active');
                });
        });
        
        /******
         * FOLD 6
         *************/
        // catalog
        var firstCatalogId = $('.catalog-groups a:first-child').data('catalog-id');
        $('.catalog-groups a:first-child').addClass('active');

        selectCatalog(firstCatalogId);

        function selectCatalog(catalogId){
            // remove contents add loading
            $('.series-house-item').css('display', 'block');
            var loadingElement = '<div class="text-center"><i class="fa fa-spinner fa-pulse fa-2x text-grey"></i></div>';
            $('.series-house-item').html(loadingElement);

            $.ajax({
                url: ajaxurl,
                dataType: 'JSON',
                data: {'action': 'get-catalog', 'catalogId': catalogId},
                success: function(data){
                    loadCatalogItems($('.series-house-item'), data);
                }
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

        $('.catalog-groups a').click(function(event){
            event.preventDefault();
            $('.catalog-groups a').removeClass('active');
            var catalogId = $(this).data('catalog-id');
            $(this).addClass('active');
            selectCatalog(catalogId);
        });

        /*****
         * FOLD 7
         ***********/
        getCity('');
       // $.getProperties('');
        $.showLoading($('#hero-properties'));
        
        // on refine selects
        $('#refine-island-group').on('select2:select', function(){
            var islandGroupId = $(this).val();
            $('#refine-province').prop('disabled', true);
            getRegionProvince(islandGroupId);
            getCity('')
        });

        $('#refine-island-group').on('select2:unselect', function(){
            getRegionProvince('');
            getCity('');
        });

        $('#refine-province').on('select2:select', function(){
            var provinceId = $(this).val();
            $('#refine-city').prop('disabled', true);
            getCity(provinceId);
            if (provinceId != ''){
                var parentId = $('#refine-province option:selected').attr('data-parent-id');
                $('#refine-island-group').select2('val', parentId);
            }
        });

        $('#refine-province').on('select2:unselect', function(){
            var islandGroupId = $('#refine-island-group').val();
            getRegionProvince(islandGroupId);
            getCity(''); 
        });

        $('#refine-city').on('select2:select', function(){
            var cityId = $(this).val();
            var parentId = $('#refine-city option:selected').attr('data-parent-id');
            $('#refine-province').select2('val', parentId);
            var parentParentId = $('#refine-province option:selected').attr('data-parent-id');
            $('#refine-island-group').select2('val', parentParentId);
        });

        $('#refine-city').on('select2:unselect', function(){
            var regionProvinceId = $('#refine-province').val();
            getCity(regionProvinceId);
        });
        
        // refine properties click event
        $('#properties-refine').on('click', function(){
            var categoryId;
            var islandGroupId = $('#refine-island-group').val();
            var provinceId = $('#refine-province').val();
            var cityId = $('#refine-city').val();
            
            if (cityId != ''){
                categoryId = cityId;
            } else if (provinceId != ''){
                categoryId = provinceId;
            } else {
                categoryId = islandGroupId;
            }
            var fieldsError = [];
            if ($('#refine-island-group').val() == ''){
                fieldsError.push('Any location');
            }
            if ($('#refine-price').val() == ''){
                fieldsError.push('Price');
            }
            if ($('#refine-bedrooms').val() == ''){
                fieldsError.push('Bedrooms');
            }
            // send error
            if (fieldsError.length >= 1){
                $.showAlert($('.properties-refine-alerts'), 'danger', 'Error', 'Please enter or select the following:', fieldsError);
            } else {
                var formDetails = {};
                formDetails['categoryId'] = categoryId;
                formDetails['priceLow'] = $('#refine-price option:selected').attr('data-low');
                formDetails['priceHigh'] = $('#refine-price option:selected').attr('data-high');
                formDetails['bedrooms'] = $('#refine-bedrooms').val();
                
                $('.properties-refine-alerts').data(formDetails);
                $.removeElements($('#properties-list-container'));
                getListings(formDetails, 0, 1);
            }
        });
        
        // Get random properties
        getListings({random:1}, 0, 1);
        
        function getListings(formDetails, iteration, page) {
                var iterationLimit = 6 - iteration,
                        startingPoint = 0,
                        container = $('#properties-list-container'),
                        params = $.extend(formDetails, {
                                type: 1,
                                paged: page,
                                iteration: iteration,
                                nonce: container.data('nonce')
                        }),
                        url = self.location;
                        
                $.showLoading( container );
                if (page >= 2){ startingPoint = (page - 1) * 6 - iteration; }
        
                $.getJSON(url, params, function(data){
                        $.removeLoading( container );
                        container.empty();
                        $('.properties-pagination-container').empty();
                        
                        var delay = 0, itrationBatch, count = 0, found = 0,
                                found_data = 0,
                                navi = '';
                        
                        if ( data.found_posts ) {
                                found_data = parseInt( data.found_posts );
                                delete data.found_posts;
                        }
                        if ( data.pagenavi ) {
                                navi = data.pagenavi;
                                delete data.pagenavi;
                        }
                        
                        for(var i in data ){
                                var property = $(getTemplate( 'property-result-template', {value:data[i]} ));                                
                                // Attached data to sample computation button
                                property.find('.btn[data-target="#computationModal"]').data(data[i]);
                                container.append( property );
                                found = found + 1;
                        }
                        $.initLightBox( $('.gallery-lightbox') );
                        formDetails['iteration'] = iteration;
                        formDetails['page'] = page;
                        $('#properties-list-container').data(formDetails);
                        
                        if ( found == 0 ) {
                                var string = '<div class="col-md-12"><div class="alert alert-danger text-center">There are no results. Please try again.</div></div>';
                                $('#properties-list-container').append(string);

                        }
                        else {
                                if ( found_data > 6 ) {
                                        
                                        var pagi = $('.properties-pagination-container');  
                                        $.generatePagination(pagi, parseInt( found_data ), 0, 6, page);
                                        
                                        pagi.find('.pagination-item a').click(function(e){
                                                var anchor_nav = $(this),
                                                        page_num = anchor_nav.attr('data-page-no');
                                                        
                                                getListings(formDetails, 0, page_num);
                                                 
                                                e.stopImmediatePropagation();
                                                return false;
                                        });
                                        
                                        // Fixed heights
                                        var items = container.find('.listing-title'),
                                                max_height = items.outerHeight();
                                                
                                        items.each(function(){
                                                var height = $(this).outerHeight();
                                                
                                                if ( height > max_height ) {
                                                        max_height = height;
                                                }
                                        });
                                        items.css('height', max_height);
                                }
                        }
                });
                
        }
        
        $('#computationModal').on('show.bs.modal', function(event){
               
                    var modelItem = $(event.relatedTarget);
                    var itemData = modelItem.data();
                    var modal = $(this);
                    modal.find('section.current').show();
                    modal.find('.modal-title').html(itemData.title + ' Sample Computation');
                    
                    // Set house model
                    var housemodel = modal.find('.house-model-selection').empty(),
                        house_models = null,
                        active_model = null;
                    
                    if ( itemData.houseModels ) {
                        for (var i in itemData.houseModels ) {
                                if ( itemData.houseModels[i] ) {
                                        var model = itemData.houseModels[i],
                                                li = '<div class="label" data-modelId="' + i + '">'
                                                + '<span>' + model.title + '</span>'
                                                + '<img src="' + model.data.modelImage + '" />'
                                                + '</div>';
                                                
                                        housemodel.append(li);
                                }
                        }
                        house_models = housemodel.find('[data-modelId]');
                        
                        house_models.on('click', function(){
                                var _model = $(this),
                                        model_id = _model.attr('data-modelId'),
                                        text_green = modal.find('.text-green');
                                        
                                active_model = itemData.houseModels[model_id];
                                house_models.removeClass('active');
                                _model.addClass('active');
                                modal.find('.model-title').html(active_model.title);
                                text_green.html(active_model.data.modelPriceLow);
                                text_green.data(active_model.data.modelPriceLow);
                                text_green.formatCurrency({symbol:'PHP', roundToDecimalPlace:0});
                                modal.find('.area').html(active_model.data.houseArea);
                                modal.find('.btn.btn-model-details').attr('href', active_model.permalink);
                                modal.data($.extend({}, active_model, {
                                        modelId:model_id,
                                        location: itemData.title
                                }));
                        });
                        
                        house_models.first().trigger('click');
                        housemodel.owlCarousel({
                                pagination: false,
                                navigation: true,
                                navigationText: ['<i class="fa fa-angle-left fa-5x"></i>', '<i class="fa fa-angle-right fa-5x"></i>'],
                                autoPlay: false,
                                items: 4,
                                itemsTablet: [768, 3],
                                itemsMobile: [479, 2] 
                        });
                        
                    }
        });
        
        $('#sampleComputationContent').steps({
            headerTag: "h4",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true,
            onInit: function(event, currentIndex){
                if (currentIndex === 0){
                    $('select.exception').select2({
                        width: '100%',
                        placeholder: 'select one',
                        allowClear: true
                    });
                }
            },

            onStepChanging: function(event, currentIndex, newIndex){
                // Return true when previous button is click
                if ( newIndex < currentIndex ) {
                        return true;
                }
                switch(currentIndex){
                    case 0:
                        return true;
                        break;
                    case 1:
                        var fieldsError = [];
                        var computeLoanType = $('#compute-loan-type').select2('val');
                        if (computeLoanType == ''){
                            fieldsError.push('Loan Type');
                        }
                        if (fieldsError.length >= 1){
                            $.showAlert($('.sample-compute-alert'), 'danger', 'Error', 'Please enter or select the following:', fieldsError);
                            return false;
                        } else {
                            return true;
                        }
                        break;
                    case 2:
                        var fieldsError = [];
                        var computeDownpayment = $('#compute-down-payment').select2('val');
                        if (computeDownpayment == ''){
                            fieldsError.push('Downpayment');
                        }
                        if (fieldsError.length >= 1){
                            $.showAlert($('.sample-compute-alert'), 'danger', 'Error', 'Please enter or select the following:', fieldsError);
                            return false;
                        } else {
                            return true;
                        }
                        break;
                    case 3:
                        var fieldsError = [];
                        var computeTerms = $('#compute-terms').select2('val');
                        if (computeTerms == ''){
                            fieldsError.push('Terms');
                        }
                        if (fieldsError.length >= 1){
                            $.showAlert($('.sample-compute-alert'), 'danger', 'Error', 'Please enter or select the following:', fieldsError);
                            return false;
                        } else {
                            return true;
                        }
                        break;
                    case 4:
                        var fieldsError = [];
                        var computeFullName = $('#compute-full-name').val();
                        var computeEmailAddress = $('#compute-email-address').val();
                        if (computeFullName == ''){
                            fieldsError.push('Full Name');
                        }
                        if (computeEmailAddress == ''){
                            fieldsError.push('Email Address');
                        } else {
                            var result = $.validateEmail(computeEmailAddress);
                            if (result == false){
                                fieldsError.push('Valid Email Address');
                            }
                        }
                        if (fieldsError.length >= 1){
                            $.showAlert($('.sample-compute-alert'), 'danger', 'Error', 'Please enter or select the following:', fieldsError);
                            return false;
                        } else {
                            return true;
                        }
                        break;
                }
            },
            onFinishing: function(event, currentIndex){
                return true;
            },
            onFinished: function(event, currentIndex){
                var computeLoanType = $('#compute-loan-type').select2('val') - 1;
                var computeDownpayment = $('#compute-down-payment').select2('val');
                var computeTerms = $('#compute-terms').select2('val');
                var computeFullName = $('#compute-full-name').val();
                var computeEmailAddress = $('#compute-email-address').val();
                var itemData = $('#computationModal').data();

                var loanTypeArray = ['In-House Financing', 'Bank Financing'];
                
                var Email = window.CamellaEmail;
                
                var formDetails = {
                    'emailDetails': {
                        'emailType': 'data',
                        'toEmailAddress': Email.admin.to,
                        'toFullName': Email.admin.from,
                        'fromEmailAddress': ''+computeEmailAddress+'',
                        'fromFullName': ''+computeFullName+'',
                        'emailSubject': Email.admin.subject,
                        'emailBodyHeader': 'This user wants to submit a proposal to Camella. Contact detals are below:'
                    },
                    'emailContent': {
                        'computeLoanType': ['Loan Type', loanTypeArray[computeLoanType]],
                        'computeDownpayment': ['Downpayment', computeDownpayment + '%' ],
                        'computeTerms': ['Terms', computeTerms + ' Years'],
                        'computeFullName': ['Full Name', computeFullName ],
                        'modelName': ['Model', itemData.title],
                        'modelLowPrice': ['Model Price', itemData.data['modelPriceLow']],
                        'projectLocation': ['Project Location', itemData.location]
                    }
                };
                $.sendEmail($('a[href="#finish"]'), formDetails, 2);
        
                var to_currency = function(amount){
                        return $('<span>').html(amount).formatCurrency({symbol:'PHP ', roundToDecimalPlace:0}).text();
                };
                
                if (computeLoanType == 0){
                    computeType =  0.14;
                } else {
                    computeType =  0.08;
                }
                
                var down_payment = parseInt(computeDownpayment),
                        total = parseInt(itemData.data.modelPriceLow),
                        downpayment = total * ( down_payment / 100 ),
                        monthly_downpayment = (downpayment - 20000) / 14,
                        monthly_amortization = $.computeComputationPMT(computeType / 12, computeTerms * 12, total, 0, 1),
                        formDetails2 = {
                    'emailDetails': {
                        'emailType': 'data',
                        'toEmailAddress': computeEmailAddress, 
                        'toFullName': computeFullName,
                        'fromEmailAddress': Email.user.from_email, 
                        'fromFullName': Email.user.from,
                        'emailSubject': Email.user.subject,
                        'emailBodyHeader': 'Here is your sample computation for ' + itemData.title + ' at ' + itemData.location + '.'
                    },
                    'emailContent': {
                        'projectLocation' : ['Project Location', itemData.location],
                        'modelName' : ['House Model', itemData.title],
                        'contractPrice' : ['Total Contract Price', to_currency( itemData.data['modelPriceLow'] ) ],
                        'computeDownpayment' : ['Downpayment', to_currency( downpayment ) + ' (' + computeDownpayment + '%)'],
                        'reservation' : ['Reservation Fee', 'PHP 20,000'],
                        'monthly' : ['Monthly Downpayment', to_currency( monthly_downpayment ) + ' (14 months)'],
                        'loanable' : ['Loanable Amount', to_currency( total - downpayment ) ],
                        'computeLoanType': ['Loan Type', loanTypeArray[computeLoanType]],                       
                        'computeTerms': ['Payment Terms', computeTerms + ' Years'],
                        'amortization' : ['Monthly Amortization', to_currency( Math.abs( monthly_amortization ) ) ]
                    }
                };
                
                // Send email to user
                $.sendEmail(null, formDetails2, 3);
                
                $('#compute-iframe').attr('src', ajaxurl + '?action=download_pdf&computeLoanType='+computeLoanType+'&computeDownpayment='+computeDownpayment+'&computeTerms='+computeTerms+'&computeFullName='+computeFullName+'&computeEmailAddress='+computeEmailAddress+'&modelName='+itemData.title +'&modelLowPrice='+itemData.data['modelPriceLow']+'&projectLocation='+itemData.location);
            }
        });
        
        $('#computationModal').on('hidden.bs.modal', function(event){
            var modal = $(this);
            modal.find('.text-green').html('');
            modal.find('.text-green').data('');
            modal.find('.area').html('');
            modal.find('.house-model-selection').replaceWith('<div class="house-model-selection"></div>');
            $('#sampleComputationContent').steps('reset', 0);
        });
        
        /********
         * Loan Calculator
         *****************/
        $('#computePrice').blur(function(){
            $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: 2, symbol: '' });
        })
        .keyup(function(e) {
            e = window.event || e;
            var keyUnicode = e.charCode || e.keyCode;
            if (e !== undefined) {
                switch (keyUnicode) {
                    case 16: break; // Shift
                    case 17: break; // Ctrl
                    case 18: break; // Alt
                    case 27: this.value = ''; break; // Esc: clear entry
                    case 35: break; // End
                    case 36: break; // Home
                    case 37: break; // cursor left
                    case 38: break; // cursor up
                    case 39: break; // cursor right
                    case 40: break; // cursor down
                    case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
                    case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
                    case 190: break; // .
                    default: $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: -1, symbol: '' });
                }
            }
        });


        // calculator
        $('.calculator-calculate').on('click', function(){
            var computePrice = $('#computePrice').asNumber({ parseType: 'int' });
            var computeType = $('#computeType').val();
            var computeDownpayment = $('#computeDownpayment').val();
            var computeTerms = $('#computeTerms').val();

            var fieldsError = [];
            if (computePrice == ''){
                fieldsError.push('Total Contract Price');
            }
            if (computeType == ''){
                fieldsError.push('Loan Type');
            }
            if (computeDownpayment == ''){
                fieldsError.push('Downpayment');
            }
            if (computeTerms == ''){
                fieldsError.push('Payment Terms');
            }
            // send error
            if (fieldsError.length >= 1){
                $.showAlert($('.calculator-alerts'), 'danger', 'Error', 'Please enter or select the following:', fieldsError);
            } else {
                if (computeType == 1){
                    computeType =  0.14;
                } else {
                    computeType =  0.08;
                }
                var amountDownpayment = computePrice * computeDownpayment / 100;
                var amountLoan = computeTerms - amountDownpayment;
                var monthsPayable = 14;
                var reservationFee = 20000;
                var downMonthly = (amountDownpayment - reservationFee) / monthsPayable;
                var monthlyPayment = $.computeComputationPMT(computeType / 12, computeTerms * 12, computePrice, 0, 1);
                monthlyPayment = Math.abs(monthlyPayment);

                $('.compute-contract-price').html(computePrice).formatCurrency({ symbol: 'PHP ', roundToDecimalPlace: 0 });
                $('.compute-dp-rate').html(computeDownpayment);
                $('.compute-downpayment').html(amountDownpayment).formatCurrency({ symbol: 'PHP ', roundToDecimalPlace: 0 });
                $('.compute-reservation').html(reservationFee).formatCurrency({ symbol: 'PHP ', roundToDecimalPlace: 0 });
                $('.compute-dp-monthly').html(downMonthly).formatCurrency({ symbol: 'PHP ', roundToDecimalPlace: 0 });
                $('.compute-loan-amount').html(computePrice - amountDownpayment).formatCurrency({ symbol: 'PHP ', roundToDecimalPlace: 0 });
                $('.compute-loan-percent').html(100 - computeDownpayment + '%');
                $('.compute-loan-terms').html(computeTerms + ' Years');
                $('.compute-loan-payment').html(monthlyPayment).formatCurrency({ symbol: 'PHP ', roundToDecimalPlace: 0 });

                var resultPanel = $('body .calculator-result');
                if ($(resultPanel).is(':visible')){
                    $(resultPanel).slideUp(function(){
                        $(this).slideDown();
                    });
                } else {
                    $(resultPanel).slideDown();
                }
            }
        });

        $('.calculator-reset').on('click', function(){
            var resultPanel = $('body .calculator-result');
            if ($(resultPanel).is(':visible')){
                $(resultPanel).slideUp();
            }
            $('#computePrice').val('');
            $('#computeType').select2('val', '');
            $('#computeDownpayment').select2('val', '');
            $('#computeTerms').select2('val', '');
        });

        /*******
         * FOLD 8: Find an Agent
         ***********************/
        // load agents
        var formDetails = [];
        formDetails['agentName'] = '';
        formDetails['agentCountry'] = '';
        formDetails['agentLocation'] = '';
        formDetails['projectAssigned'] = '';
        formDetails['type'] = 0;
        getAgents(formDetails, 0, 1);

        function getAgents(formDetails, iteration, page){
            $.showLoading($('#agents-list-container'));
            $.ajax({
                url: ajaxurl,
                dataType: 'JSON',
                data: {'action': 'get-agents', 'type': formDetails['type'], 'agentName': formDetails['agentName'], 'agentCountry': formDetails['agentCountry'], 'agentLocation': formDetails['agentLocation'], 'projectAssigned': formDetails['projectAssigned']},
                success: function(data){
                    var startingPoint = 0;
                    if (page >= 2){ startingPoint = (page - 1)  * 5; }
                    if (data.length == 0){
                        var string = '<div class="col-md-12"><div class="alert alert-danger text-center">There are no results. Please try again.</div></div>';
                        $('#agents-list-container').append(string);
                    } else {
                        $('#agents-list-container').data(formDetails);
                        
						

                        var delay = 0;
                        var n = 1;
						var f = 0 ;
                        $.each(data, function(count, value){
                            delay = delay + 0.2;
							f++;
                            
                            // Prevent errors from rendering
                            if ( ! value.agentLocation ) {
                                value.agentLocation = {};
                            }
                            
                            if (count >= startingPoint){
                                if (n <= 5){
									
                                    var content = '<div class="col-md-4 col-sm-6"><div class="panel panel-default agent-item" data-sr="move 50px wait '+delay+'s">';
                                    content += '<div class="panel-heading no-padding"><div class="media"><div class="media-left">';
                                    if ( value['agentFeaturedImage'][0] ) {
                                        content += '<img src="'+value['agentFeaturedImage'][0]+'">';
                                    }
                                    else {
                                        content += '<span class="fa-agent-new"><i class="fa fa-user fa-5x"></i></span>';
                                    }
                                    
                                    var location = value['agentCustom']['agentLocation'],
                                        agent_name = value['agentCustom']['firstName'] + ' ' + value['agentCustom']['lastName'];
                                    location = ! location ? 'Metro Manila' : location;
                                    content += '</div>';
                                    content += '<div class="media-body"><h4 class="media-heading"><a href="' + value.redirect_link + '">'+value['agentCustom']['firstName'].toUpperCase()+'<br><span>'+value['agentCustom']['lastName']+'</span></a></h4><hr>';
                                    content += '<span><i class="fa fa-map-marker fa-fw"></i> '+ location +'</span></div></div></div>';
                                    content += '<div class="panel-body">'+value['agentData']['post_content']+'</div><div class="panel-footer no-padding">';
                                    content += '<a href="' + value.redirect_link + '?agent=' + agent_name + '" class="btn btn-primary btn-block agent-send-message" data-toggle="modal" data-target="#agentModal"><i class="fa fa-envelope fa-fw"></i> SEND EMAIL MESSAGE</a></div></div></div>';
                                    $('#agents-list-container').append(content);
                                    $('#agents-list-container div:last-child').data(value);
                                    n++;
									
                                }
                            }
										
                        });
						
                        // add last recruitement item
                        var content = '<div class="col-md-4 col-sm-6"><div class="panel panel-default agent-item" data-sr="move 50px wait 1.2s"><div class="panel-heading no-padding"><div class="media"><div class="media-left">';
                        //content += '<img src="http://localhost:8888/camella/prod/wp-content/uploads/2015/07/testimonial-profile-04.jpg">';
                        content += '<span class="fa-agent-new"><i class="fa fa-question fa-5x"></i></span>';
                        content += '</div><div class="media-body"><h4 class="media-heading"><a href="#">WANT TO BE<br><span>AN AGENT</span></a></h4>';
                        content += '<hr><span><i class="fa fa-map-marker fa-fw"></i> Manila</span></div></div></div>';
                        content += '<div class="panel-body">We are looking for committed full-time and part-time brokers and agents. Join our very dynamic company now!</div>';
                        content += '<div class="panel-footer no-padding"><a href="./sales-recruitment-form/" target="_blank" class="btn btn-primary btn-block"><i class="fa fa-file-text fa-fw"></i> CLICK HERE TO KNOW MORE</a></div></div></div>';
                        
						$('#agents-list-container').append(content);
						
                    }
					if (f > 6){
						$.generatePagination($('.agents-pagination-container'), data.length, iteration, 5, page);
						}
                    $.removeLoading($('#agents-list-container'));
					
                }
				
            });
			
        }
        
        $.forceEqualizePanels('.agent-item .panel-body');
        // agents pagination clicks
		
        $('body').on('click', '.agents-pagination-container a', function(event){
            event.preventDefault();
            var formDetails = $('#agents-list-container').data();
            var iteration = 0;
            var page = $(this).data('page-no');
            $.removeElements($('#agents-list-container'));
            $('.agents-pagination-container').html('');
            getAgents(formDetails, 0, page);
        });

        $('.international-send-message').on('click', function(event){
            event.preventDefault();
            var emailAddress = $(this).data('email-address');
        });

        /******************************
         * Add listener to .whychoose carousel to fix height
         **********************************/
        var chc_listener = setInterval(function(){
                var container = $('.whychoose-container .owl-wrapper-outer'),
                        start_left = parseInt( container.css('left') )
                        items = $('.whychoose-container .owl-item'),
                        max_height = 50,
                        item_title = $('h4', container);
                        
                item_title.css('height', 'auto');
                items.each(function(){
                        var item = $(this),
                                left = item.offset().left,
                                title = $('h4', item),
                                height = title.outerHeight();
                        
                        if ( left >= 0  ) {
                                if ( height > max_height ) {
                                        max_height = height;
                                }
                                title.css('height', max_height);
                        }
                });                
        }, 1);
        
        /********************************************
         * Add carousel to internation sales
         *******************************************/
        $('.international-sales').owlCarousel({
            pagination: false,
            navigation: true,
            navigationText: ['<i class="fa fa-angle-left fa-5x"></i>', '<i class="fa fa-angle-right fa-5x"></i>'],
            autoPlay: true,
            items: 4,
            itemsTablet: [768, 3],
            itemsMobile: [479, 1]
        });
        
        /*******
         * News Articles
         *****************/
         $.forceEqualizePanels('.news-others .panel-body');
         
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
        
        /******************************
         * Add listener to .whychoose carousel to fix height
         **********************************/
        var chc_listener = setInterval(function(){
                var container = $('.whychoose-container .owl-wrapper-outer'),
                        start_left = parseInt( container.css('left') )
                        items = $('.whychoose-container .owl-item'),
                        max_height = 50,
                        item_title = $('h4', container);
                        
                item_title.css('height', 'auto');
                items.each(function(){
                        var item = $(this),
                                left = item.offset().left,
                                title = $('h4', item),
                                height = title.outerHeight();
                        
                        if ( left >= 0  ) {
                                if ( height > max_height ) {
                                        max_height = height;
                                }
                                title.css('height', max_height);
                        }
                });                
        }, 1);

});

}(jQuery);