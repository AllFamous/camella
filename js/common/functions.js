(function($){
    $(document).ready(function(){

        var ajaxurl = $('body').data('admin-url') + 'admin-ajax.php';
        var themeUrl = $('body').data('theme-url');
        var adminUrl = $('body').data('admin-url');

        $.nl2br = function(str, is_xhtml) {
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
        }

        $.scaleVideoContainer = function() {
            var height = $(window).height();
            var unitHeight = parseInt(height) + 'px';
            $('.homepage-hero-module').css('height', unitHeight);
        }

        $.initBannerVideoSize = function(element){
            $(element).each(function(){
                $(this).data('height', $(this).height());
                $(this).data('width', $(this).width());
            });
            $.scaleBannerVideoSize(element);
        }

        $.scaleBannerVideoSize = function(element){
            var windowWidth = $(window).width(),
                windowHeight = $(window).height(),
                videoWidth,
                videoHeight;

            $(element).each(function(){
                var videoAspectRatio = $(this).data('height')/$(this).data('width'),
                    windowAspectRatio = windowHeight/windowWidth;

                if (videoAspectRatio > windowAspectRatio) {
                    videoWidth = windowWidth + 200;
                    videoHeight = videoWidth * videoAspectRatio;
                    $(this).css({'top' : -(videoHeight - windowHeight) / 2 + 'px', 'margin-left' : -100});
                } else {
                    videoHeight = windowHeight + 100;
                    videoWidth = videoHeight / videoAspectRatio;
                    $(this).css({'margin-top' : 0, 'margin-left' : -(videoWidth - windowWidth) / 2 + 'px'});
                }
                $(this).width(videoWidth).height(videoHeight);
                $('.homepage-hero-module .video-container video').addClass('fadeIn animated');
            });
        }

        $.togglePanel = function (button, panel){
            $(button).click(function(){
                $(panel).slideToggle('slow', function(){
                    if ($(panel).is(':visible')){
                        $(button).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
                    } else {
                        $(button).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
                    }
                });
            });
        }

        $.expandMapDiv = function(sourceDiv, mapDiv, extend){
            var windowWidth = $(window).width();
            var sourceDivHeight = $(sourceDiv).height();
            if (windowWidth <= 767){
                sourceDivHeight = 300;
                $(mapDiv).css('height', sourceDivHeight + 'px');     
            } else {
                if (extend == true) { extend = 450; } else { extend = 0 }
                sourceDivHeight = parseInt(sourceDivHeight) + 300 + extend;
                $(mapDiv).css('height', sourceDivHeight + 'px');        
            }
        }

        $.forceEqualizePanels = function (elements) {
            var panels = $('body').find($(elements));
            var heightArr = [];
            $.each(panels, function(i, element){
                var height = $(element).outerHeight();
                heightArr.push(height);
            });
            var tallestHeight = Math.max.apply(Math, heightArr);
            $('body').find($(elements)).css('height', tallestHeight + 'px');
        }

        $.initLightBox = function(buttonElement){
            $(buttonElement).click(function(e){
                e.preventDefault();
                $(this).ekkoLightbox();
            });
        }

        // anchor
        $('a.anchor[href*=#]:not([href=#])').click(function(){
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });

        $(window).scroll(function(){
            var winTop = $(this).scrollTop();
            $('.section').each(function(){
                var elTop = $(this).offset().top,
                    elHeight = $(this).height();
                if (winTop >= elTop && winTop < elTop + elHeight){
                    $(this).addClass('current').siblings().removeClass('current');
                    $('.back-to-top').data('location', elTop);
                }
            });
        });

        $('.back-to-top').on('click', function(event){
            event.preventDefault();
            if ($(this).hasClass('inner')) {
                var target = $(this.hash);
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            } else {
                var location = $('.back-to-top').data('location');
                $('html, body').animate({
                    scrollTop: location - 80
                }, 1000);
                return false;
            }
        });

        // social icons more
        $('.social-buttons a.social-more').click(function(event){
            event.preventDefault();
            if (!$(this).hasClass('open')){
                $(this).addClass('hide open');
                var hiddenElements = $(this).parent().parent().find('li.hide');
                $(hiddenElements).each(function(i, element){
                    $(element).removeClass('hide');
                });
            }
        });

        // homeonwers hover
        $('.fixed-homeowners').hover(function(){
            $('.homeowners-hover').addClass('hover');
        }, function(){
            $('.homeowners-hover').removeClass('hover');
        });

        // map marker elements
        $.loadMapMarkers = function(mapElement, markerType, markerData){
            switch(markerType){
                case 'property':
                    var propertiesArr = [];
                    $(markerData).each(function(count, value){
                        var propertiesArrItem = [];
                        propertiesArrItem.push(value['post_title']);
                        propertiesArrItem.push(value['custom_field']['locationLong']);
                        propertiesArrItem.push(value['custom_field']['locationLat']);
                        propertiesArrItem.push(count + 1);
                        propertiesArrItem.push(value['featured_image']);
                        propertiesArrItem.push(value['post_content']);
                        propertiesArrItem.push(value['property_permalink']);
                        propertiesArr.push(propertiesArrItem);
                    });
                    google.maps.event.addDomListener(window, 'load', $.mapInitialize(propertiesArr));
                    break;
                case 'hero':
                    var propertiesArr = [];
                     $(markerData).each(function(count, value){
                        var propertiesArrItem = [];
                        propertiesArrItem.push(value['post_title']);
                        propertiesArrItem.push(value['category_id']);
                        propertiesArrItem.push(value['category_name']);
                        propertiesArrItem.push(value['custom_field']['locationLong']);
                        propertiesArrItem.push(value['custom_field']['locationLat']);
                        propertiesArrItem.push(count + 1);
                        propertiesArrItem.push(value['ID']);
                        propertiesArr.push(propertiesArrItem);
                    });
                    propertiesArr = $.uniqueEntries(propertiesArr, 1);
                    google.maps.event.addDomListener(window, 'load', $.mapInitializeHero(propertiesArr));
                    break;
            }
        }

        $.uniqueEntries = function(array, key){
            var temp_array = [];
            var new_array = [];
            $(array).each(function(count, value){
                if ($.inArray(value[key], temp_array) === -1){
                    temp_array.push(value[key]);
                    new_array.push(value);
                }
            });
            return new_array;
        }

        $.placePropertiesHero = function(elemContainer, items){
            var string = '';
            $(items).each(function(count, value){
                string += '<a href="#" data-location-id="'+value['projectLocationId']+'" data-project-id="'+value['projectData']['ID']+'" data-toggle="tooltip" data-placement="top" title="'+value['projectData']['post_title']+'"><img src="'+value['projectFeaturedImage'][0]+'" width="105px"></a>'
            });
            $.removeLoading($(elemContainer));
            $(elemContainer).append(string);
        }


        var mapHero;
        window.mapHero = mapHero;
        var mapBoundsHero = new google.maps.LatLngBounds();
        window.mapBoundsHero = mapBoundsHero;
        $.mapInitializeHero = function(markerArray){
            var customMapStyle = [{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#C6E2FF"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#C5E3BF"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#D1D1B8"}]}]
            var mapOptions = {
                mapTypeControlOptions: {
                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'camellaMapHero']
                },
                scrollwheel: false,
                disableDoubleClickZoom: false
            };
            window.mapHero = mapHero = new google.maps.Map(document.getElementById('hero-locations-map'), mapOptions);
            var styledMapOptions = { name: 'Camella Projects' };
            var camellaComminitiesMapType = new google.maps.StyledMapType(customMapStyle, styledMapOptions);
            mapHero.mapTypes.set('camellaMapHero', camellaComminitiesMapType);
            mapHero.setMapTypeId('camellaMapHero');
            $.mapSetProjectMarkersHero(mapHero, markerArray, mapBoundsHero);
        }
        
        $.mapInitialize = function(markerArray){
            var customMapStyle = [{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#C6E2FF"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#C5E3BF"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#D1D1B8"}]}]
            var mapBounds = new google.maps.LatLngBounds();
            var map;
            var mapOptions = {
                mapTypeControlOptions: {
                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'camellaMap']
                },
                scrollwheel: false,
                disableDoubleClickZoom: false
            };
            
            map = new google.maps.Map(document.getElementById('index-properties'), mapOptions);
            var styledMapOptions = { name: 'Camella Projects' };
            var camellaComminitiesMapType = new google.maps.StyledMapType(customMapStyle, styledMapOptions);
            map.mapTypes.set('camellaMap', camellaComminitiesMapType);
            map.setMapTypeId('camellaMap');
            $.mapSetProjectMarkers(map, markerArray, mapBounds);
        }


        $.mapSetProjectMarkers = function(map, locations, mapBounds){
            var mapMarker = { url: themeUrl + '/img/common/mapMarker.png' }
            
            for (var i = 0; i < locations.length; i++) {
                var community = locations[i];
                
                if ( parseFloat(community[1]) && parseFloat(community[2] ) ) {
        
                var communityLatLng = new google.maps.LatLng(community[1], community[2]);
                
                var marker = new google.maps.Marker({
                    position: communityLatLng,
                    map: map,
                    icon: mapMarker,
                    title: community[0],
                    zIndex: community[3],
                    clickable: true
                });
                mapBounds.extend(marker.position);
                var communityContent = '' +
                '<div class="custom-infowindow">' +
                '<div class="custom-infowindow-header">'+community[4]+'</div>' +
                '<div class="custom-infowindow-body">' +
                '<h4><a href="#"><i class="fa fa-home"></i> '+community[0]+'</a></h4>' +
                '<p>'+community[5]+'</p>' +
                '</div>' +
                '<div class="custom-infowindow-footer text-center">' +
                '<div class="agent-title text-left">Contact an Agent</div>' +
                '<div class="custom-infowindow-footer-content"></div>';

                communityContent += '</div><a href="'+community[6]+'" class="btn btn-primary btn-block">VIEW PROJECT</a></div>';

                var infoWindow = new google.maps.InfoWindow({
                    pixelOffset: new google.maps.Size(25, 0)
                });
                
                google.maps.event.addListener(marker, 'click', (function(marker, communityContent, infoWindow) { 
                    return function() {
                        infoWindow.setContent(communityContent);
                        infoWindow.open(map, marker);
                    };
                })(marker, communityContent, infoWindow));
                
                google.maps.event.addListener(infoWindow, 'domready', function() {
                    var iwOuter = $('.gm-style-iw');
                    var iwBackground = iwOuter.prev();
                    iwBackground.children(':nth-child(2)').css({ 'display' : 'none' });
                    iwBackground.children(':nth-child(4)').css({ 'display' : 'none' });
                    iwBackground.children(':nth-child(1)').css({ 'display' : 'none' });
                    iwBackground.children(':nth-child(3)').css({ 'display' : 'none' });
                    var iwCloseBtn = iwOuter.next();
                    iwCloseBtn.css({ opacity: '1', right: '38px', top: '3px', border: '5px solid #b4d449', 'border-radius': '20px', 'box-shadow': 'none', 'width': '23px', 'height': '23px' });
                    iwCloseBtn.mouseout(function(){ $(this).css({opacity: '1'}); });
                    // load agents
                    $.removeElements($('.custom-infowindow-footer-content'));
                    $.showLoading($('.custom-infowindow-footer-content'));
                    var formDetails = [];
                    formDetails['agentName'] = '';
                    formDetails['agentCountry'] = '';
                    formDetails['agentLocation'] = '';
                    formDetails['projectAssigned'] = '';
                    formDetails['type'] = 0;
                    
                    $.ajax({
                        url: ajaxurl,
                        dataType: 'JSON',
                        data: {'action': 'get-agents', 'type': formDetails['type'], 'agentName': formDetails['agentName'], 'agentCountry': formDetails['agentCountry'], 'agentLocation': formDetails['agentLocation'], 'projectAssigned': formDetails['projectAssigned']},
                        success: function(data){
                            $.removeLoading($('.custom-infowindow-footer-content'));
                            $.each(data, function(ii, value){
                                if (ii <= 3){
                                    var string = '<a href="#" class="contact-agent-map" data-toggle="modal" data-target="#agentModal"><img src="'+value['agentFeaturedImage'][0]+'" width="65px"></a>';
                                    $('.custom-infowindow-footer-content').append(string);
                                    $('.custom-infowindow-footer-content > a:last-child').data(value);
                                }
                            });
                        }
                    });
                
                });
                }
            }
            
            map.fitBounds(mapBounds);
            var listener = google.maps.event.addListener(map, 'idle', function(){
                google.maps.event.removeListener(listener);
            });
        }

        $.mapSetProjectMarkersHero = function(mapHero, locations, mapBoundsHero){
            var mapMarker = { url: themeUrl + '/img/common/mapMarker.png' }
            for (var i = 0; i < locations.length; i++) {
                var community = locations[i];
                var communityLatLng = new google.maps.LatLng(community[3], community[4]);
                var marker = new google.maps.Marker({
                    position: communityLatLng,
                    map: mapHero,
                    icon: mapMarker,
                    title: community[2],
                    zIndex: community[5],
                    clickable: true,
                    customInfo: community[1]
                });
                mapBoundsHero.extend(marker.position);

                google.maps.event.addListener(marker, 'click', function(){
                    $.closeWindowUpdateSelect($('.hero-panel-map'), $('#hero-location'), this.customInfo, 1);
                });
            }
            mapHero.fitBounds(mapBoundsHero);
            var listener = google.maps.event.addListener(mapHero, 'idle', function(){
                google.maps.event.removeListener(listener);
            });
        }

        /*
        // hero hover location
        $('.location-container, .type-container, .range-container').hover(function(){
            $(this).find('.panel').fadeIn(function(){
                google.maps.event.trigger(mapHero, 'resize');
                mapHero.fitBounds(mapBoundsHero);
            });
        }, function(){
            $(this).find('.panel').fadeOut();
        });      
        */
        
        $.closeWindowUpdateSelect = function(panel, element, data, type){
            $(panel).fadeOut();
            $(element).select2('val', data);
            if (type == 1){
                $.getProperties(data);
            }
        }

        $.getProperties = function(categoryId, callback){
            $.removeElements('#hero-properties');
            $.showLoading('#hero-properties');
            $.ajax({
                url: ajaxurl,
                dataType: 'JSON',
                data: {'action': 'get-properties', 'categoryId': categoryId},
                success: function(data){
                    if (data.length == 0){
                        $.removeLoading('#hero-properties');
                        var string = '<div class="col-md-12"><div class="alert alert-danger text-center">There are no results. Please try again.</div></div>';
                        $('#hero-properties').append(string);
                    } else {
                        var values = [];
                        $.each(data, function(i, value){
                            var categoryItem = {
                                'optionId' : value['projectData']['ID'],
                                'optionName' : value['projectData']['post_title']
                            }
                            values.push(categoryItem);
                        });
                        $.updateSelect($('#hero-property'), values, 0);
                        $.removeLoading('#hero-properties');
                        $.placePropertiesHero($('#hero-properties'), data);
                    }
                }
            });
        }

        // update/append selects
        $.updateSelect = function(element, data, type){
            element.select2('destroy');
            element.html('<option></option>');
            if (type == 0){
                $.each(data, function(i, value){
                    var string = '<option value="'+value['optionId']+'">'+value['optionName']+'</option>';
                    element.append(string);
                });
            } else if (type == 1) {
                $.each(data, function(i, value){
                    var string = '<optgroup label="'+value['optionName']+'">';
                    $.each(value['optionSubCategory'], function(iSub, valueSub){
                        string += '<option value="'+valueSub['optionId']+'" data-parent-id="'+valueSub['optionParent']+'">'+valueSub['optionName']+'</option>';
                    });
                    string += '</optgroup>';
                    element.append(string);
                });
            } else if (type == 2)  {
                $.each(data, function(i, value){
                    $.each(value['optionSubCategory'], function(iSub, valueSub){
                        var string = '<optgroup label="'+valueSub['optionName']+'">';
                        $.each(valueSub['optionSubCategory'], function(iSubSub, valueSubSub){
                            string += '<option value="'+valueSubSub['optionId']+'" data-parent-id="'+valueSubSub['optionParent']+'">'+valueSubSub['optionName']+'</option>';
                        });
                        string += '</optgroup>';
                        element.append(string);
                    });
                });
            } else if (type == 3) {
                $.each(data, function(i, value){
                    var string = '<option value="'+value['optionId']+'" data-parent-id="'+value['optionParent']+'">'+value['optionName']+'</option>';
                    element.append(string);
                });
            }
            element.select2({
                width: '100%',
                placeholder: 'select one',
                allowClear: true
            });
            element.prop('disabled', false);
        }

        $.shortenPrice = function(number, decPlaces){
            number = parseInt(number);
            decPlaces = Math.pow(10, decPlaces);
            var abbrev = ['K', 'M'];
            for (var i=abbrev.length-1; i>=0; i--) {
                var size = Math.pow(10,(i+1)*3);
                if(size <= number){
                    number = Math.round(number*decPlaces/size)/decPlaces;
                    if((number == 1000) && (i < abbrev.length - 1)){
                        number = 1;
                        i++;
                    }
                    number += abbrev[i];
                    number = 'P'+number;
                    break;
                }
            }
            return number;
        }

        $.showAlert = function(container, type, header, content, fields){
            var string = '<div class="alert alert-'+type+'" role="alert">';
            string += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            string += '<h3>'+header+'</h3>';
            string += '<p>'+content+'</p>';
            if (fields != false){
                string += '<ul>';
                $.each(fields, function(i, value){
                    string += '<li>'+value+'</li>';
                });
                string += '</ul>';
            }
            string += '</div>';
            $(container).append(string);
            var alertElement = $(container).find('.alert');
            $(alertElement).alert();
            $(alertElement).fadeTo(3000, 500).slideUp(500, function(){
                $(alertElement).alert('close');
            });
        }

        $.showLoading = function(container){
            var string = '<div class="loading-container text-center text-grey">';
            string += '<p><i class="fa fa-spinner fa-pulse fa-2x"></i></p>';
            string += '</div>';
            $(container).prepend(string);
        }

        $.removeLoading = function(container){
            $(container).find('.loading-container').remove();
        }

        $.showLoadingButton = function(button){
            var string = ' <i class="fa fa-spinner fa-pulse fa-lg"></i>';
            $(button).append(string);
            $(button).prop('disabled', true);
        }

        $.removeLoadingButton = function(button){
            $(button).find('i').remove();
            $(button).prop('disabled', false);
        }

        $.generatePagination = function(containerElement, resultCount, iteration, itemsPerPage, page){
            var string = '<div class="row"><div class="col-md-12 text-center"><ul class="pagination">';
            string += '</ul></div></div>';
            $(containerElement).html(string);
            resultCount = resultCount + iteration;
            var pagesCount = Math.ceil(resultCount / itemsPerPage);
            for (i = 1; i <= pagesCount; i++){
                if (i > 1){ iteration = 0; }
                var string = '<li class="pagination-item"><a href="#" data-page-no="'+i+'" data-page-iteration="'+iteration+'">'+i+'</a></li>';
                $(containerElement).find('ul').append(string);
            }
            var pageActive = page - 1;
            $(containerElement).find('.pagination-item').eq(pageActive).addClass('active');
        }

        $.computeComputationPMT = function(rate_per_period, number_of_payments, present_value, future_value, type){
            if(rate_per_period != 0.0){
                // Interest rate exists
                var q = Math.pow(1 + rate_per_period, number_of_payments);
                return -(rate_per_period * (future_value + (q * present_value))) / ((-1 + q) * (1 + rate_per_period * (type)));
            } else if(number_of_payments != 0.0){
                // No interest rate, but number of payments exists
                return -(future_value + present_value) / number_of_payments;
            }
            return 0;
        }

        $.removeElements = function(element){
            $(element).html('');
        }

        $.getAgentsMap = function(){
            var formDetails = [];
            formDetails['agentName'] = '';
            formDetails['agentCountry'] = '';
            formDetails['agentLocation'] = '';
            formDetails['projectAssigned'] = '';
            formDetails['type'] = 0;
            $.ajax({
                url: ajaxurl,
                dataType: 'JSON',
                data: {'action': 'get-agents', 'type': formDetails['type'], 'agentName': formDetails['agentName'], 'agentCountry': formDetails['agentCountry'], 'agentLocation': formDetails['agentLocation'], 'projectAssigned': formDetails['projectAssigned']},
                success: function(data){
                    return data;
                }
            });
        }

        $.validateEmail = function(email) {
            var comply = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,6})+$/;
            return comply.test(email);
        }

        $.sendEmail = function(buttonElement, formDetails, siteSection){
            $.showLoadingButton(buttonElement);
            $.ajax({
                url: ajaxurl,
                dataType: 'JSON',
                data: {'action': 'send-email', 'formDetails': formDetails},
                success: function(data){
                    switch(siteSection){
                        case 1:
                            if (data == 1){
                                $.showAlert($('#agentModal .agent-contact-alerts'), 'success', 'Success', 'Your message has been sent successfully.', '');
                            } else {
                                $.showAlert($('#agentModal .agent-contact-alerts'), 'danger', 'Error', 'There has been a problem. Please try again later.', '');
                            }
                            $('#agentContactFullName').val('');
                            $('#agentContactEmailAddress').val('');
                            $('#agentContactNumber').val('');
                            $('#agentContactMessage').val('');
                            $.removeLoadingButton(buttonElement);
                            break;
                        case 2:
                            if (data == 1){
                                $.showAlert($('.sample-compute-alert'), 'success', 'Success', 'Your sample computation will be downloaded shortly.', '');
                            } else {
                                $.showAlert($('.sample-compute-alert'), 'danger', 'Error', 'There has been a problem. Please try again later.', '');
                            }
                            $('#sampleComputationContent').steps('reset');
                            $('#compute-loan-type').select2('val', '');
                            $('#compute-down-payment').select2('val', '');
                            $('#compute-terms').select2('val', '');
                            $('#compute-full-name').val('');
                            $('#compute-email-address').val('');
                            $.removeLoadingButton(buttonElement);
                            break;
                    }
                }
            });
        }

        $.userSubscribe = function(formDetails, fieldsError, buttonElement, emailField, alertContainer){
            $.ajax({
                url: ajaxurl,
                dataType: 'JSON',
                data: {'action': 'user-subscribe', 'formDetails': formDetails},
                success: function(data){
                    $.showAlert($(alertContainer), 'success', 'Success', 'Congratulations! Your email has been added successfully.', fieldsError);
                    $.removeLoadingButton($(buttonElement));
                    $(emailField).prop('disabled', false).val('');
                }
            });
        }

        $.formatFirewallType = function(firewallType){
            switch(firewallType){
                case 'rowHouseIU':
                    return 'Row House (Inner Unit)';
                    break;
                case 'rowHouseEU':
                    return 'Row House (End Unit)';
                    break;
                case 'townHouseIU':
                    return 'Townhouse (Inner Unit)';
                    break;
                case 'townHouseEU':
                    return 'Townhouse (End Unit)';
                    break;
                case 'singleFirewall':
                    return 'Single Firewall';
                    break;
                case 'singleFirewallUH':
                    return 'Single Firewall (Uphill)';
                    break;
                case 'singleFirewallDH':
                    return 'Single Firewall (Downhill)';
                    break;
                case 'singleFirewallUHDH':
                    return 'Single Firewall (Uphill/Downhill)';
                    break;
                case 'singleDetached':
                    return 'Single Detached';
                    break;
            }
        }

        $.formatInclusions = function(value){
            switch(value){
                case 'nA':
                    return '<i class="fa fa-times fa-lg"></i>';
                    break;
                case 'included':
                    return '<i class="fa fa-check fa-lg"></i>';
                    break;
                case 'provision':
                    return 'Provision';
                    break;
            }
        }

        $.initiateMapInside = function(){
            $('#map-inside').css('height', '600px');

            var locLong = $('#map-inside').data('long');
            var locLat = $('#map-inside').data('lat');
            google.maps.event.addDomListener(window, 'load', mapInitialize(locLong, locLat));

            var directionsDisplay;
            var directionsService = new google.maps.DirectionsService();
            var map;

            function hideDirectionButton(){
                $('#directions-button').addClass('hide');
            }

            function showDirectionButton(){
                $('#directions-button').removeClass('hide');
                $('#directions-button').attr('data-start-lat', '');
                $('#directions-button').attr('data-start-long', '');
            }

            function mapInitialize(locLong, locLat){
                hideDirectionButton();
                directionsDisplay = new google.maps.DirectionsRenderer();
                var customMapStyle = [{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#C6E2FF"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#C5E3BF"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#D1D1B8"}]}]
                var locationLatLong = new google.maps.LatLng(locLong, locLat);
                var mapOptions = {
                    center: new google.maps.LatLng(locLong, locLat),
                    zoom: 13,
                    mapTypeControlOptions: {
                        mapTypeIds: [google.maps.MapTypeId.SATELLITE, 'camellaMap']
                    },
                    scrollwheel: false,
                    disableDoubleClickZoom: true,
                    zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.SMALL,
                        position: google.maps.ControlPosition.RIGHT_BOTTOM
                    },
                    panControl: false
                };
                map = new google.maps.Map(document.getElementById('map-inside'), mapOptions);
                directionsDisplay.setMap(map);

                // start input elements
                var input = document.getElementById('pac-input');
                var types = document.getElementById('type-selector');
                var directionButton = document.getElementById('directions-button');
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(directionButton);

                var styledMapOptions = { name: 'Camella Map' };
                var camellaComminitiesMapType = new google.maps.StyledMapType(customMapStyle, styledMapOptions);
                map.mapTypes.set('camellaMap', camellaComminitiesMapType);
                map.setMapTypeId('camellaMap');

                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.bindTo('bounds', map);
                
                var marker = new google.maps.Marker({map: map, anchorPoint: new google.maps.Point(0, -29)});

                google.maps.event.addListener(autocomplete, 'place_changed', function(){
                    marker.setVisible(false);
                    var place = autocomplete.getPlace();
                    if (!place.geometry) {
                        window.alert("The search returned no result/s.");
                        hideDirectionButton();
                        startingLocationMarker();
                        directionsDisplay.setMap(null);
                        return;
                    }

                    // If the place has a geometry, then present it on a map.
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);  // Why 17? Because it looks good.
                    }
                    
                    marker.setIcon(/** @type {google.maps.Icon} */({
                        url: themeUrl + '/img/common/mapMarker.png'
                    }));
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);

                    var address = '';
                    if (place.address_components) {
                        address = [
                            (place.address_components[0] && place.address_components[0].short_name || ''),
                            (place.address_components[1] && place.address_components[1].short_name || ''),
                            (place.address_components[2] && place.address_components[2].short_name || '')
                        ].join(' ');
                    }
                    showDirectionButton();

                    // add location details to button
                    var startingPlace = autocomplete.getPlace();
                    var startLocLat = startingPlace.geometry.location.lat()
                    var startLocLong = startingPlace.geometry.location.lng();
                    document.getElementById('directions-button').setAttribute('data-start-lat', startLocLat);
                    document.getElementById('directions-button').setAttribute('data-start-long', startLocLong);
                });

                function setupClickListener(id, types){
                    var radioButton = document.getElementById(id);
                    google.maps.event.addDomListener(radioButton, 'click', function() {
                        autocomplete.setTypes(types);
                    });
                }

                setupClickListener('changetype-all', []);
                setupClickListener('changetype-address', ['address']);
                setupClickListener('changetype-establishment', ['establishment']);
                setupClickListener('changetype-geocode', ['geocode']);

                startingLocationMarker();

                function startingLocationMarker(){
                    var mapMarker = { url: themeUrl + '/img/common/mapMarker.png' }
                    var marker = new google.maps.Marker({
                        icon: mapMarker,
                        position: locationLatLong,
                        map: map
                    });
                    map.setCenter(locationLatLong);
                }
            }

            function calcRoute(startLocLong, startLocLat, endLocLong, endLocLat){
                var startingLocation = new google.maps.LatLng(startLocLat, startLocLong);
                var endingLocation = new google.maps.LatLng(endLocLong, endLocLat);
                var request = {
                    origin: startingLocation,
                    destination: endingLocation,
                    travelMode: google.maps.TravelMode.DRIVING
                };
                directionsService.route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setOptions({
                            suppressMarkers: true,
                            polylineOptions: {
                                strokeWeight: 7,
                                strokeOpacity: 1,
                                strokeColor:  '#95b62b' 
                            }
                        });
                        directionsDisplay.setDirections(response);
                    }
                });
            }

            $('#directions-button').on('click', function(){
                // get end location
                var endLocLong = $('#map-inside').data('long');
                var endLocLat = $('#map-inside').data('lat');

                // get start location
                var startLocLong = $('#directions-button').attr('data-start-long');
                var startLocLat = $('#directions-button').attr('data-start-lat');

                calcRoute(startLocLong, startLocLat, endLocLong, endLocLat);

            });
			
			
			$('.expand-one').click(function(){
				$('.content-one').slideToggle('slow');
			});
			
			
			
			
        }

    });
}(jQuery));




