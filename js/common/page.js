(function($){
/*****************
 * Get the lists of careers before hand
 ****************************************/
        var Careers = null, timer;
        
        if ( window.isCareer ) {
                $.getJSON(self.location, {nonce: window.Camella.career_nonce}, function(response){
                        Careers = response;
                });
        }
 
 
    $(document).ready(function(){

        var ajaxurl = $('body').data('admin-url') + 'admin-ajax.php';


        // template requirements

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
        
        /****************************
         * Set selected inquiry type
         ********************************/
        $('[data-inquiry]').each(function(){
                var input = $(this);
                if ( window.Camella.inquiry_type ) {
                        var inquiry_type = window.Camella.inquiry_type;
                        
                        if ( inquiry_type == 'Marketing' ) inquiry_type = 'Marketing and Administrative Briefing';
                        else if ( inquiry_type == 'Submission' ) inquiry_type = 'Submission of Requirements';
                        else if ( inquiry_type == 'move-in') inquiry_type = 'Move-in / Turnover of Property';
                        
                        input.val(inquiry_type);
                        input.select2('val', inquiry_type);
                }
        });

         /******************
         * Set catalog value for search inquries
         *****************************************/
        $('[data-catalogs]').each(function(){
                if ( window.Camella.catalog ) {
                        var catalog = $(this),
                                options = '',
                                value = '',
                                inquiry = $('[data-inquiry]');
                        
                        for(var i in window.Camella.catalog ){
                                options += '<option value="' + window.Camella.catalog[i] + '">' + window.Camella.catalog[i] + '</option>';
                                value = window.Camella.catalog[i];
                        }
                        
                        catalog.html(options).val(value);
                        catalog.select2('val', value);
                        inquiry.val('House Catalog');
                        inquiry.select2('val', 'House Catalog');
                }
        });
        
        /**********************
         * Set list of careers
         ********************************/
        timer = setInterval(function(){
                if ( Careers ) {
                        clearInterval(timer);
                        
                        var options = '',
                                value = '',
                                jobs = $('[data-job]');
                        
                        for(var i in Careers ){
                                options += '<option value="' + Careers[i] + '">' + Careers[i] + '</option>';
                        }
                        
                        jobs.html(options);
                        jobs.select2({
                                width: '100%',
                                placeholder: 'select',
                                'autoClear' : true
                        });
                        
                        if ( window.Camella.career ) {
                                for(var i in window.Camella.career ){
                                        value = window.Camella.career[i];
                                }
                                
                                jobs.val(value);
                                jobs.select2('val', value);
                        }
                }
        }, 1);
        
        /********
         * Set subject for presentation form
         **********************************/
        var schedule = $('#field_mev0bx');
        
        if ( schedule.length > 0 ) {
                if ($('body').is('.page-id-1617')) {
                        schedule.val('Schedule a presentation');
                }
                if ($('body').is('.page-id-1612')) {
                        schedule.val('Schedule a visit');
                }
        }
    });
    
}(jQuery));