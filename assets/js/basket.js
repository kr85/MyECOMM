$(document).ready(function () {
    "use strict";
    basketObject.addToBasket('.add_to_basket');
    basketObject.addToWishlist('.add-to-wishlist');
    basketObject.updateBasketKeyPres('.fld_qty');
    basketObject.updateBasketButton('.update_basket');
    basketObject.removeFromBasket('.remove_basket');
    basketObject.removeFromWishlist('.remove_wishlist');
    basketObject.loadingPayPal('.paypal');
    basketObject.shipping('.shipping_radio');
});