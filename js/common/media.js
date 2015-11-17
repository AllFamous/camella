+function($){
        var media = wp.media, frame, Attachments = {},
        wpImage, oldwpImage = $.fn.wpImage,
        
        inputImage = function(input){
                var _i = this;
        
                _i = $.extend(_i, $(input).data());
        
                _i.width = ! _i.width ? 150 : _i.width;
                _i.height = ! _i.height ? 150 : _i.height;
                _i.input = $(input).hide().attr('data-img-edited', 1);                
                
                _i.type = _.isString(_i.addimage) ? _i.addimage.split(',') : 'image';
                _i.template = $('<div class="bf-add-img"><a class="bf-edit-img-icon"><span class="dashicons dashicons-edit"></span></a><a class="bf-del-img-icon"><span class="dashicons dashicons-trash"></span></a></div>').insertAfter( _i.input );
                _i.container = _i.input.next('.bf-add-img');
                
                _i.container
                .css({width: _i.width, height: _i.height})
                .find('.bf-edit-img-icon')
                .on('click', $.proxy(_i, 'editImage') )
                .end()
                .find('.bf-del-img-icon')
                .on('click', $.proxy(_i, 'deleteImage') );
                
                if( ! _i.val || _i.val != 'url' ){
                        if( _i.input.val() != '' ){
                                _i.imgURL( _i.input.val() );
                        }
                }
                else if( _i.val == 'url' && _i.input.val() != '' ){
                        _i.setURLImage( _i.input.val() );
                }
        };
        
        inputImage.prototype.imgURL = function(id){
                var _i = this,
                        param = {id:id, width:_i.width, height:_i.height};
                        
                if ( _i.fullsize ) {
                        param.fullsize = _i.fullsize;
                }
                
                if( !Attachments[id] ){
                        $.getJSON(ajaxurl + '?action=get_image', param, function(res){
                                Attachments[id] = res; 
                                _i.setImage(res);
                        });
                }
                else {
                        _i.setImage(Attachments[id]);
                }
        };
        
        inputImage.prototype.max_dim = function(max_w, max_h, cur_w, cur_h){
                var r = Math.min( max_w/cur_w, max_h/cur_h);                        
                        
                cur_w = cur_w > max_w ? r * cur_w : cur_w;
                cur_h = cur_h > max_w ? r * cur_h : cur_h;
                
                if ( this.fullsize ) {
                        cur_w = this.width;
                        cur_h = this.height;
                }
                        
                return {w:cur_w, h:cur_h};
        };
        
        inputImage.prototype.setImage = function(data){
                var _i = this,
                dim = _i.max_dim( _i.width, _i.height, data[1], data[2] ),
                attr = {src:data[0], width: dim.w, height: dim.h};
                
                _i.img = _i.container.find('img');
                        
                if( _i.img.length > 0 ){
                        _i.img.attr(attr);
                }
                else {
                        _i.img = $('<img>').attr(attr).prependTo( _i.container );
                }
                
                if( dim.w < _i.width ){
                        _i.img.css('margin-left', (_i.width - dim.w) / 2)
                }
                if( dim.h < _i.height ){
                        _i.img.css('margin-top', (_i.height - dim.h) /2 );
                }
        };
        
        inputImage.prototype.setURLImage = function(url){
                var _i = this,
                attr = {src:url, width:_i.width, height: _i.height};
                
                _i.img = _i.container.find('img');
                        
                if( _i.img.length > 0 ){
                        _i.img.attr(attr);
                }
                else {
                        _i.img = $('<img>').attr(attr).prependTo( _i.container );
                }
        };
        
        inputImage.prototype.editImage = function(){
                var _i = this;
               
                _i.settings = {
                        library: {type: _i.type},
                        title: !_i.title ? 'Insert Image' : _i.title
                        };
                        
                frame = new media(_i.settings);
                frame.on('open', function(){
                        
                });
                frame.on('select', function(){
                        var img = frame.state().get('selection').first(),
                        attr = img.attributes;
                        
                        if( attr.type == 'image' && attr.sizes ){
                                var thumb = attr.sizes.thumbnail ? attr.sizes.thumbnail : attr.sizes.full;
                                
                                if ( _i.fullsize && attr.sizes[_i.fullsize] ) {
                                        thumb = attr.sizes[_i.fullsize];
                                }
                                _i.setImage([thumb.url, thumb.width, thumb.height]);
                        }
                        
                        _i.input.val( _i.val && _i.val == 'url' ? attr.sizes.full.url : attr.id ).trigger('change');
                });
                frame.open();
        };
        
        inputImage.prototype.deleteImage = function(){
                var _i = this;
                
                if( _i.remove ) _i.container.remove();
                else {
                        _i.container.find('img').remove();
                        _i.input.val('').trigger('change');
                }
        };
        
        
        $.fn.wpImage = function(){
                return this.each(function(){
                        var input = $(this), is_edited = input.is('[data-img-edited]');
                        
                        if( is_edited ){
                                input.removeAttr('data-img-edited');
                                input.next('.bf-add-img').remove();
                        }
                        new inputImage(this);
                });
        };
        
        $.fn.noConflict = function(){
                $.fn.wpImage = oldwpImage;
                return this;
        };
        
        $(document)
        .on('ready', function(){
                $('[data-addimage]').not('script [data-addimage]').wpImage();
        });
}(jQuery);