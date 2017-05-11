(function ($, Drupal) {
    'use strict';
    Drupal.behaviors.registration_form = {
        attach: function (context) {
            // Conditionally hide the city/state unless user chooses United States.
            $("#edit-address-country").change(function () {
                if ($("#edit-address-country").val() === "United States") {
                    $('.form-item-address-city').show();
                    $('.form-item-address-state-province').show();
                }
                else {
                    $('.form-item-address-city').hide();
                    $('.form-item-address-state-province').hide();
                }
            });
        }
    }
}(jQuery, Drupal));
