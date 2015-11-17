+function($){
/** Find the needed template at `template-script.php` **/

        var getTemplate = function(template_id, data ){
                var template = $('#' + template_id).html();
                data = ! data ? {} : data;
                
                return _.template( template, {data:data} );
        },
        getRandomProperties = function(page){
                var container = $('#suggested-random-properties-container').appendTo('.entry-content'),
                        params = {
                                random:1,
                                paged:page,
                                nonce: window.camella_js ? window.camella_js.nonce : null
                        },
                        url = window.camella_js ? window.camella_js.home : null;
                
                $.showLoading( container );
                
                $.getJSON(url, params, function(data){ 
                        $.removeLoading( container );
                        container.empty();
                        $('.properties-pagination-container').remove();
                        
                        
                        var delay = 0, itrationBatch, count = 0, found = 0,
                                found_data = 0,
                                navi = '';
                        
                        if ( data.found_posts ) {
                                found_data = parseInt( data.found_posts );
                                delete data.found_posts;
                                
                                if ( found_data > 0 ) {
                                        $('<h2>Suggested Properties</h2><div class="row"></div>').appendTo(container);
                                }
                                
                        }
                        if ( data.pagenavi ) {
                                navi = data.pagenavi;
                                delete data.pagenavi;
                        }
                        
                        for(var i in data ){
                                var props = getTemplate( 'property-result-template', {value:data[i]} );
                                
                                props = props.replace(/col-md-4/g, 'col-md-5');
                                
                                container.find('.row').append(props);
                                found = found + 1;
                        }
                        
                        if ( found == 0 ) {
                                var string = '<div class="col-md-12"><div class="alert alert-danger text-center">There are no results. Please try again.</div></div>';
                                container.empty().append(string);

                        }
                        else {
                                if ( found_data > 6 ) {
                                        
                                        var pagi = $('<div class="properties-pagination-container">').appendTo(container);  
                                        $.generatePagination(pagi, parseInt( found_data ), 0, 6, page);
                                        
                                        pagi.find('.pagination-item a').click(function(e){
                                                var anchor_nav = $(this),
                                                        page_num = anchor_nav.attr('data-page-no');
                                                        
                                                getRandomProperties(page_num);
                                                 
                                                e.stopImmediatePropagation();
                                                return false;
                                        });
                                        
                                        // Fixed heights
                                        var items = container.find('.listing-title'),
                                                max_height = items.outerHeight();
                                                
                                        items.each(function(){
                                                var height = $(this).outerHeight();
                                                
                                                if ( height && height > max_height ) {
                                                        max_height = height;
                                                }
                                        });
                                        items.css('height', max_height);
                                }
                        }
                });
        };
        
$(document)
        .ready(function(){
                // Get random properties if the container exists!
                $('#suggested-random-properties-container').each(function(){
                        getRandomProperties(1);
                });
        });
}(jQuery);