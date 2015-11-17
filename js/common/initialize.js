(function($){
    $(document).ready(function(){

        var ajaxurl = $('body').data('admin-url') + 'admin-ajax.php';

        // tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // attach lightbox
        $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event){
            event.preventDefault();
            $(this).ekkoLightbox();
        }); 

        // initialize reveal
        var config = {
            easing: 'ease-in',
            reset:  false,
            delay:  'once',
            vFactor: 0.90
        }
        window.sr = new scrollReveal( config );
        
        // fixed nav initialize
        var fixedActive = {
            'opacity': '1',
            'z-index': '20000',
            'margin-top': '0'
        }
        var fixedDefault = {
            'opacity': '0',
            'z-index': '-1',
            'margin-top': '-111px'
        }
        $(window).scroll(function(){                          
            if ($(this).scrollTop() > 200) {
                $('.fixed-nav').css(fixedActive);
            } else {
                $('.fixed-nav').css(fixedDefault);
            }
        });

        // fixed back to top initialize
        var fixedBackTopActive = {
            'opacity': '1',
            'z-index': '20000',
            'bottom': '50px'
        }

        var fixedBackTopDefault = {
            'opacity': '0',
            'z-index': '-1',
            'bottom': '0'
        }
        $(window).scroll(function(){                          
            if ($(this).scrollTop() > 500) {
                $('.back-to-top').css(fixedBackTopActive);
            } else {
                $('.back-to-top').css(fixedBackTopDefault);
            }
        });

        // select boxes
        $('select:not(.exception)').select2({
            width: '100%',
            placeholder: 'select one',
            allowClear: true
        });

        // add scroll pane on selections
        $(document).on("select2:open", "select", function() {
            var el;
                
            $('.select2-results').each(function() {
                var api = $(this).data('jsp');
                if (api !== undefined) api.destroy();
            });
            $('.select2-results').each(function() {
                if ($(this).parent().css("display") != 'none') el = $(this);
                if (el === undefined) return;
                el.jScrollPane({ 'mouseWheelSpeed': 40 });
            });
            
        });
        

        // initialize uncover footer
        var footerHeight = $('.uncover').outerHeight();
        $('.section-whychoose').css('margin-bottom', footerHeight + 'px');

        // owl carousel buttons appear
        $('.owl-carousel').hover(function(){
            $(this).find('.owl-prev').css({ 'margin-left': '-50px', 'opacity': '0.7', 'z-index': '2000000 !important' });
            $(this).find('.owl-next').css({ 'margin-right': '-50px', 'opacity': '0.7', 'z-index': '2000000 !important' });
        }, function(){
            $(this).find('.owl-prev').css({ 'margin-left': '0px', 'opacity': '0', 'z-index': '0' });
            $(this).find('.owl-next').css({ 'margin-right': '0px', 'opacity': '0', 'z-index': '0' });
        });

        // wrap footer links
        $('.footer-main-links a').wrap('<div class="col-sm-6"></div>');

        // move logo to center in fixed nav
        var navItems = $('.fixed-nav > .container > ul > li:not(.fixed-brand)');
        var navLogo = $('.fixed-nav .fixed-brand').detach();
        var navItemsCount = $(navItems).length;
        var navItemsCountMiddle = (parseInt(navItemsCount) / 2) - 1;
        navItemsCountMiddle = Math.ceil(navItemsCountMiddle);
        $(navLogo).insertAfter($(navItems).eq(navItemsCountMiddle));

        var navItems = $('.fixed-nav > .container > ul > li:not(.brand)');
        var navLogo = $('.fixed-nav .brand').detach();
        var navItemsCount = $(navItems).length;
        var navItemsCountMiddle = (parseInt(navItemsCount) / 2) - 1;
        navItemsCountMiddle = Math.ceil(navItemsCountMiddle);
        $(navLogo).insertAfter($(navItems).eq(navItemsCountMiddle));

        var navItemsMast = $('.navbar-nav.inner > li:not(.brand)');
        var navLogoMast = $('.navbar-nav.inner .brand').detach();
        var navItemsCountMast = $(navItemsMast).length;
        var navItemsCountMiddleMast = (parseInt(navItemsCountMast) / 2) - 1;
        navItemsCountMiddleMast = Math.ceil(navItemsCountMiddleMast);
        $(navLogoMast).insertAfter($(navItemsMast).eq(navItemsCountMiddleMast));

        $('.footer-main-links').find('.brand').remove();

        // sections with parallax images
        $('.inner-header').parallax('50%', 0.1);
        $('#section-whychoose').parallax('50%', 0.1);

        // subscribe email
        $('#footer-subscribe').on('click', function(event){
            $.showLoadingButton($('#footer-subscribe'));
            $('#subscribeEmai').prop('disabled', true);
            var subscribeEmail = $('#subscribeEmai').val();
            var fieldsError = [];
            if (subscribeEmail == ''){
                fieldsError.push('Email Address');
            }
            // send error
            if (fieldsError.length >= 1){
                $.showAlert($('.subscribe-form-alerts'), 'danger', 'Error', 'Please enter or select the following:', fieldsError);
            } else {
                var formDetails = {
                    'subscribeEmail': subscribeEmail
                };
                $.userSubscribe(formDetails, fieldsError, $('#footer-subscribe'), $('#subscribeEmai'), $('.subscribe-form-alerts'));
            }
        });

        // initialize inside map if exists
        if ($('#map-inside').length == 1){
            $.initiateMapInside();
        }

        // show/hide login panel
        $('.user-login').click(function(event){
            event.preventDefault();
            $('.panel-login').slideToggle();
        });

        $('#login-cancel').click(function(event){
            event.preventDefault();
            $('.panel-login').slideUp();
        });

        $('#user-login-btn').on('click', function(event){
            event.preventDefault();

            var loginUsername = $('#loginUsername').val();
            var loginUserPassword = $('#loginUserPassword').val();

            var fieldsError = [];
            if (loginUsername == ''){ fieldsError.push('Username'); }
            if (loginUserPassword == ''){ fieldsError.push('Password'); }
            // send error
            if (fieldsError.length >= 1){
                $.showAlert($('.login-notice'), 'danger', 'Error', 'Please enter the following:', fieldsError);
            } else {
                $('#loginUsername').prop('disabled', true);
                $('#loginUserPassword').prop('disabled', true);
                $.showLoadingButton($('#user-login-btn'));
                $.ajax({
                    url: ajaxurl,
                    dataType: 'JSON',
                    data: { 'action': 'user-login', 'loginUsername': $('#loginUsername').val(), 'loginUserPassword': $('#loginUserPassword').val() },
                    success: function(data){
                        $.removeLoadingButton($('#user-login-btn'));
                        $('#loginUsername').prop('disabled', false).val('');
                        $('#loginUserPassword').prop('disabled', false).val('');
                        if (data.loggedin == true){
                            $.showAlert($('.login-notice'), 'success', 'Notice', 'Login successful. Please wait...', false);
                            document.location.href = $('body').attr('data-page-url');
                        } else {
                            $.showAlert($('.login-notice'), 'danger', 'Error', 'The username and/or password you supplied is incorrect. Please try again.', false);
                        }
                    }
                });
            }            
        });
        
        
        
    });
    
// Events
var philLocations = null,
        timer = null,
        getPhils = function(){
                var ajaxurl = window.Camella.ajaxurl;
                $.getJSON(ajaxurl, {action:'get_country_locations'}, function(response){
                        philLocations = response;
                });
        },
        getRegions = function(){
                var regions = '';
                
                for(var i in philLocations ){
                        regions += '<option value="' + i + '">' + i + '</option>';
                }
                return regions;
        },
        setCitiesOrMunicipalities = function(){
                var region_selector = $(this),
                        city_selector = region_selector.data('cityid'),
                        city = $(city_selector),
                        region = region_selector.select2('val');
                        
                if ( region && philLocations[region] ) {
                        var options = '<option value=""></option>';
                        for(var i in philLocations[region] ){
                                var city_value = philLocations[region][i];
                                
                                options += '<option value="' + city_value + '">' + city_value + '</option>';
                        }
                        
                        city.html(options);
                        city.select2({
                                width: '100%',
                                placeholder:'select one',
                                allowClear:true
                        });
                }
                
        },
        getProperties = function(select){
                var ajaxurl = window.Camella.ajaxurl;
                select = $(select);
                
                $.getJSON(ajaxurl, {action:'get_hierarchy'}, function(response){
                        if ( response ) {
                                var options = '';
                                
                                for(var i in response ){
                                        options += '<optgroup label="' + i + '">';
                                        for(var ii in response[i] ){
                                                var _name = response[i][ii]['name'];
                                                options += '<option value="' + _name + '">' + _name + '</option>';
                                        }
                                        options += '</optgroup>';
                                }
                                select.html(options);
                        }
                });
        },
        getAgents = function(select){
                var ajaxurl = window.Camella.ajaxurl;
                select = $(select);
                
                $.getJSON(ajaxurl, {action:'get-agents'}, function(response){
                        if ( response ) {
                                var options = '',
                                        emails = {};
                                
                                for(var i in response ){
                                        if ( response[i].agentCustom ) {
                                                var agentData = response[i].agentCustom,
                                                        _name = agentData.firstName + ' ' + agentData.lastName;
                                                        options += '<option value="' + _name + '">' + _name + '</option>';
                                                        
                                                emails[_name] = agentData.emailAddress;
                                        }
                                }
                                select.html(options);
                                
                                select.on('change', function(){                                        
                                        if ( select.data('agent-email')) {
                                                var email_field = $(select.data('agent-email')),
                                                        selected_agent = $(this).val();
                                                
                                                if ( email_field.length > 0 ) {
                                                        email_field.val( emails[selected_agent] );
                                                }
                                        }
                                });
                        }
                });
        },
        setStates = function(){
                if ( philLocations ) {
                        clearInterval(timer);
                        var _regions = getRegions();
                        
                        $('[data-phils="state"]').each(function(){
                                $(this).html(_regions);
                        });
                }
        },
        valAlpha = function(){
                var ptrn = /[a-zA-Z]/,
                        input = $(this),
                        val = input.val(),
                        has_error = false;
                
                val = val.split("");
                
                for( var i in val ){
                        if ( val[i] != " " && val[i].match(ptrn) == null ) {
                                has_error = true;
                        }
                }
                
                if ( has_error ) {
                        input.addClass('input-error');
                        $('<p class="alert alert-warning input-err-text">Please enter letters only!</p>').insertAfter(input);
                }
        },
        valNumeric = function(){
                var ptrn = /[0-9+]/,
                        input = $(this),
                        val = input.val(),
                        has_error = false;
                val = val.split("");
                
                for( var i in val ){
                        if ( val[i] != " " && val[i].match(ptrn) == null ) {
                                has_error = true;
                        }
                }
                
                if ( has_error ) {
                        input.addClass('input-error');
                        $('<p class="alert alert-warning input-err-text">Please enter numbers and/or + sign only!</p>').insertAfter(input);
                }  
        },
        // Remove errors on input fields
        removeErrors = function(){
                var input = $(this),
                        errors = input.parent().find('.input-err-text');
                        
                input.removeClass('input-error');
                errors.slideUp(function(){
                        $(this).remove();
                });
        },
        // Prevent any form from submitting if there's one or more errors
        ifHasErrors = function(){
                var errors = $(this).find('.input-error, .input-err-text');
                
                if ( errors.length && errors.length > 0 ) {
                        return false; 
                }
        };
        
        getPhils();
        
$(document)
        .ready(function(){
                var states = $('[data-phils="state"]');
                
                if ( states.length && states.length > 0 ) {
                        timer = setInterval(setStates, 1);
                }
                
                // Get property listing
                var property_hierarchy = $('[data-property-hierarchy]');
                
                if ( property_hierarchy.length && property_hierarchy.length > 0 ) {
                        property_hierarchy.each(function(){
                                getProperties(this);
                        });
                }
                
                // Autofill agents dropdown
                var agents = $('[data-agents]');
                
                if ( agents.length > 0 ) {
                        agents.each(function(){
                                getAgents(this);
                        });
                }
        })
        .on('click', '.location-container .panel, .type-container .panel, .range-container .panel', function(){
                // Close all panels
                var panel = $(this);
            
                if ( panel && panel.length > 0 ) {
                    panel.fadeOut(1); // Close all panels
                }
        })
        // Autoset cities/municipalities
        .on('change', '[data-phils="state"]', setCitiesOrMunicipalities)
        .on('change', '[data-val="alpha"]', valAlpha)
        .on('change', '[data-val="numeric"]', valNumeric)
        .on('keyup', '.input-error', removeErrors)
        .on('submit', 'form', ifHasErrors);

}(jQuery));