/**
 * User: Benftwc
 * Date: 18/11/13 : 21:04
 */

$(function() {
    var $allVideos = $("iframe[src^='http://www.youtube.com']"), $fluidEl = $("body");
    $allVideos.each(function() {
        $(this)
            .data('aspectRatio', this.height / this.width)
            .removeAttr('height')
            .removeAttr('width');

    });

    $(window).resize(function() {
        var newWidth = $fluidEl.width();
        $allVideos.each(function() {
            var $el = $(this);
            $el
                .width(newWidth)
                .height(newWidth * $el.data('aspectRatio'));

        });
    }).resize();
});