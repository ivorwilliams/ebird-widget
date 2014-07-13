;(function ( $, window, document, undefined ) {
        $(".inline").colorbox({inline:true, width:"450px"});
        $('#tab-container').easytabs();
})( jQuery, window, document );

 window.onload = function()
{
    var $scrollbar = document.getElementById("scrollbar1")
    ,   scrollbar  = tinyscrollbar($scrollbar)
    ;
}