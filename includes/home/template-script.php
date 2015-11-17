<script type="text/html" id="property-result-template">
<% var value = data.value, $ = jQuery; %>
<div class="col-md-4 col-sm-6 property-item-holder property-type">
        <div class="panel panel-default listing-item">
                <div class="panel panel-default listing-item">
                        <div class="panel-heading no-padding">
                                <div class="img-overlay"><div class="img-buttons">
                                        <ul class="no-bullets inline">
                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="house gallery" data-toggle="lightbox" data-gallery="houseItem<%=data.iterationBatch%>" data-remote="<%=value.fullImage%>" data-title="<%=value.title%>" class="gallery-lightbox"><i class="fa fa-file-image-o"></i></a></li>
                                                <li><a href="" data-toggle="tooltip" data-placement="top" title="house details"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <% _.each(value.gallery, function(imageValue, i){ %>
                                            <div data-toggle="lightbox" data-gallery="houseItem<%=data.iterationBatch%>" data-remote="<%=imageValue%>" data-title="<%=value.title%>"></div>
                                        <% }) %>
                                        <div class="social-buttons">
                                                <ul class="no-bullets inline">
                                                        <li><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=5&link=" class="fb"><i class="fa fa-facebook"></i></a></li>
                                                        <li><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=7&link=" class="tw"><i class="fa fa-twitter"></i></a></li>
                                                        <li><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=304&link=" class="gp"><i class="fa fa-google-plus"></i></a></li>
                                                        <li><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=309&link=" class="pi"><i class="fa fa-pinterest"></i></a></li>
                                                        <li><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=313&link=" class="pl"><i class="fa fa-envelope"></i></a></li>
                                                </ul>
                                        </div>
                                </div></div>
                                <img src="<%=value.featuredImage%>" class="img-responsive transition">
                        </div>
                        <div class="panel-body">
                                <a href="#" class="btn btn-secondary btn-sm pull-right" data-toggle="modal" data-target="#computationModal">SAMPLE COMPUTATION</a>
                                <div class="listing-title"><a href="<%=value.permalink%>"><%=value.title%></a></div>
                                <div class="listing-location"><i class="fa fa-map-marker"></i> <%=value.location%></div>
                        </div>     
                </div>
        </div>
</div>
</script>
<script type="text/html" id="property-result-template22">
<% var value = data.value, $ = jQuery; %>
<div class="col-md-4 col-sm-6 property-item-holder property-type-<%=value['modelCustom']['propertyType']%>">
        <div class="panel panel-default listing-item">
                <div class="panel panel-default listing-item" data-sr="move 50px wait '+delay+'s">
                        <div class="panel-heading no-padding">
                                <div class="img-overlay"><div class="img-buttons">
                                        <ul class="no-bullets inline">
                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="house gallery" data-toggle="lightbox" data-gallery="houseItem<%=data.iterationBatch%>" data-remote="<%=value['modelCustom']['modelImage']%>" data-title="<%=value['modelData']['post_title']%>" class="gallery-lightbox"><i class="fa fa-file-image-o"></i></a></li>
                                                <li><a href="<%=value['modelPermalink']%>" data-toggle="tooltip" data-placement="top" title="house details"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <% _.each(value['modelCustom']['imageGallery'], function(imageValue, i){ %>
                                            <div data-toggle="lightbox" data-gallery="houseItem<%=data.iterationBatch%>" data-remote="<%=imageValue['url']%>" data-title="<%=value['modelData']['post_title']%>"></div>
                                        <% }) %>
                                        <div class="social-buttons">
                                                <ul class="no-bullets inline">
                                                        <li><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=5&link=<%=value['modelPermalink']%>" class="fb"><i class="fa fa-facebook"></i></a></li>
                                                        <li><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=7&link=<%=value['modelPermalink']%>" class="tw"><i class="fa fa-twitter"></i></a></li>
                                                        <li><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=304&link=<%=value['modelPermalink']%>" class="gp"><i class="fa fa-google-plus"></i></a></li>
                                                        <li><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=309&link=<%=value['modelPermalink']%>" class="pi"><i class="fa fa-pinterest"></i></a></li>
                                                        <li><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=313&link=<%=value['modelPermalink']%>" class="pl"><i class="fa fa-envelope"></i></a></li>
                                                </ul>
                                        </div>
                                </div></div>
                                <div class="listing-price"><%=$.shortenPrice(value['modelCustom']['modelPriceLow'], 2)+' - '+$.shortenPrice(value['modelCustom']['modelPriceHigh'], 2)%></div>
                                <img src="<%=value['modelCustom']['modelImage']%>" class="img-responsive transition">
                        </div>
                        <div class="panel-body">
                                <a href="#" class="btn btn-secondary btn-sm pull-right" data-toggle="modal" data-target="#computationModal">SAMPLE COMPUTATION</a>
                                <div class="listing-title"><a href="#"><%=value['modelData']['post_title']%></a></div>
                                <div class="listing-location hidden"><i class="fa fa-map-marker"></i> <%=value['projectData']['post_title']+', '+value['projectCustom']['locationText']%></div>
                        </div>
                        <div class="panel-footer"><ul class="no-bullets inline">
                                <% if (value['modelCustom']['propertyType'] == 'house'){ %>
                                    <li><i class="fa fa-expand fa-fw"></i><%=value['modelCustom']['houseArea']%> sqm</li><li><i class="fa fa-bed fa-fw"></i> <%=value['modelCustom']['bedrooms']%> Beds</li><li><i class="fa fa-tint fa-fw"></i> <%=value['modelCustom']['bathrooms']%> Baths</li><li><i class="fa fa-home fa-fw"></i> <%=value['modelCustom']['floors']%> Floors</li>
                                <% } else { %>
                                    <li><i class="fa fa-expand fa-fw"></i><%=value['modelCustom']['lotArea']%> sqm</li>
                                <%}%>
                        </ul></div>
                </div>
        </div>
</div>
</script>