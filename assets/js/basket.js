$(document).ready(function () {
    "use strict";
    systemObject.showHideRadio('.show_hide_radio');
    basketObject.addToBasket('.add_to_basket');
    basketObject.updateBasketKeyPres('.fld_qty');
    basketObject.updateBasketButton('.update_basket');
    basketObject.removeFromBasket('.remove_basket');
    basketObject.loadingPayPal('.paypal');
    systemObject.emailInactive('#email_inactive');
    basketObject.shipping('.shipping_radio');
    systemObject.selectCountryState('.select_country_state');

});