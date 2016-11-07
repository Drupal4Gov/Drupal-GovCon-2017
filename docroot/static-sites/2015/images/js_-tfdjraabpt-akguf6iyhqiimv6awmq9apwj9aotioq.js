(function($) {

Drupal.behaviors.moduleFilterDynamicPosition = {
  attach: function(context) {
    var $window = $(window);

    $(".messages").prependTo("#user-pass");
    $(".alert").prependTo("#user-pass");
  }
};

})(jQuery);;
