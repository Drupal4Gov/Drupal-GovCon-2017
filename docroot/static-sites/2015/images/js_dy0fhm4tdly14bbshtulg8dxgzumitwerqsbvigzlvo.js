(function($) {

Drupal.behaviors.moduleFilterDynamicPosition = {
  attach: function(context) {
    var $window = $(window);
    
    $(".messages").prependTo("#user-login");
    $(".alert").prependTo("#user-login");
    $('#edit-pass').keypress(function(e) {
      var s = String.fromCharCode( e.which );
      if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) {
        
        $('#capslockdiv p').show();
      }
      else {
        $('#capslockdiv p').hide();
      }
    });
  
  }
};

})(jQuery);;
