if(typeof allowZooming != 'undefined') {
    if( jQuery(window).width() >= 600) {
        if (view_num == 5) {
            jQuery(for_zoom).hover(function () {
                for_zoom = jQuery(this);
                zoom_start();
            }, function () {
                zoom_resize();
            });
        }
        else {
            zoom_start();
        }

        jQuery(window).resize(function () {
            zoom_resize();
        });
    }
}

jQuery(window).resize(function () {
    if(typeof allowZooming != 'undefined') {
        if( jQuery(window).width() >= 600) {
            jQuery('.main-image-block.not_for_zoom').hide();
            jQuery('.main-image-block.for_zoom').show();
            if (view_num == 5) {
                jQuery(for_zoom).hover(function () {
                    for_zoom = jQuery(this);
                    zoom_start();
                }, function () {
                    zoom_resize();
                });
            }
            else {
                zoom_start();
            }
        }
        else{
            jQuery('.main-image-block.for_zoom').hide();
            jQuery('.main-image-block.not_for_zoom').show();
        }
    }
});
jQuery(window).resize();
function zoom_resize(){
        jQuery('img.zoomed').removeData('elevateZoom');//remove zoom instance from image
        jQuery('.zoomWrapper img.zoomed').unwrap();
        jQuery('.zoomContainer').remove();
        if(jQuery(window).width() > 640){
           if(view_num == 5) { jQuery(for_zoom).hover(function(){ for_zoom = jQuery(this); zoom_start(); }) } else{ zoom_start(); }
        }
        var image_width = jQuery('.main-image-block a').find("img").width();
        var image_height = jQuery('.main-image-block a').find("img").height();
        jQuery('.zoomWrapper').width(image_width);
        jQuery('.zoomWrapper').height(image_height);
}
function zoom_remove(){
        jQuery('img.zoomed').removeData('elevateZoom');//remove zoom instance from image
        jQuery('.zoomWrapper img.zoomed').unwrap();
        jQuery('.zoomContainer').remove();
}
function zoom_start(){
    //    alert(allowZooming);
        if(allowZooming == "on"){
            if(catalogZoomType == "window"){
                jQuery(for_zoom).elevateZoom({
                    responsive : true,
                    imageCrossfade : true,
                    loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif',
                    easingType : "zoomdefault",
                    easingDuration : 2000,
                    containLensZoom : false,

                //    //////////////////////     Zoom Window      ///////////////////////

                    zoomType : catalogZoomType,
                    zoomWindowWidth : catalogWindowWidth,
                    zoomWindowHeight : catalogWindowHeight,
                    zoomWindowOffetx : catalogWindowOffetx,
                    zoomWindowOffety : catalogWindowOffety,
                    zoomWindowPosition : catalogWindowPosition,
                    zoomWindowFadeIn : catalogWindowFadeIn,
                    zoomWindowFadeOut : catalogWindowFadeOut, //
                    borderSize : catalogBorderSize,
                    borderColour : "#" + catalogBorderColour,
                    lensSize : catalogLensSize,
                    constrainSize: 200,

                       //////////////////////     Lens Options

                    lensFadeIn : catalogLensFadeIn,
                    lensFadeOut : catalogLensFadeOut,
                    lensShape : catalogLensShape,
                    lensColour : "#" + catalogLensColour,
                    lensOpacity : catalogLensOpacity,
                    lenszoom : false,
                    cursor : catalogCursor,
                    scrollZoom : catalogScrollZoom,
                    easing : catalogEasing,
                    tint : catalogTint,
                    tintColour : "#" + catalogTintColour,
                    tintOpacity : catalogTintOpacity,
                    zoomTintFadeIn : catalogZoomTintFadeIn,
                    zoomTintFadeOut : catalogZoomTintFadeOut,
                });
            }
            else {
                jQuery(for_zoom).elevateZoom({
                    responsive : true, 
                    imageCrossfade : true, 
                    loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif', 
                    easingType : "zoomdefault",
                    easingDuration : 2000,
                    containLensZoom : true,
                    zoomType : catalogZoomType,
                    lensFadeIn : catalogLensFadeIn,
                    lensFadeOut : catalogLensFadeOut,
                    lensShape : catalogLensShape,
                    lensColour : "#" + catalogLensColour,
                    lensOpacity : catalogLensOpacity,
                    lenszoom : false,
                    cursor : catalogCursor,
                    scrollZoom : catalogScrollZoom,
                    easing : catalogEasing,
                });
            }
        }
}