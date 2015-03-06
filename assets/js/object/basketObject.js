var basketObject = {
    addToBasket: function (thisIdentity) {
        "use strict";
        $(document).on('click', thisIdentity, function (e) {
            e.preventDefault();
            var trigger = $(this);
            var param = trigger.attr("rel");
            var item = param.split("_");
            $.post('/module/call/basket', { id: item[0], job: item[1] }, function(data) {
                var newId = item[0] + '_' + data.job;
                if (data.job != item[1]) {
                    if (data.job == 0) {
                        trigger.attr("rel", newId);
                        trigger.text("Remove from basket");
                        trigger.addClass("red");
                    } else {
                        trigger.attr("rel", newId);
                        trigger.text("Add to basket");
                        trigger.removeClass("red");
                    }
                    if (!systemObject.isEmpty(data.replace_values)) {
                        systemObject.replaceValues(data.replace_values);
                    }
                }
            }, 'json');
        });
    },
    removeFromBasket: function (thisIdentity) {
        "use strict";
        $(document).on('click', thisIdentity, function (e) {
            e.preventDefault();
            var item = $(this).attr('rel');
            $.post('/module/call/basket-remove', { id: item }, function(data) {
                if (!systemObject.isEmpty(data.replace_values)) {
                    systemObject.replaceValues(data.replace_values);
                }
            }, 'json');
        });
    },
    updateBasket: function () {
        "use strict";
        var thisArray = $('#frm_basket').serializeArray();
        $.post('/module/call/basket-qty', thisArray, function(data) {
            if (!systemObject.isEmpty(data.replace_values)) {
                systemObject.replaceValues(data.replace_values);
            }
        }, 'json');
    },
    updateBasketKeyPres: function (thisIdentity) {
        "use strict";
        $(document).on('keypress', thisIdentity, function (e) {
            var code = e.keyCode ? e.keyCode : e.which;
            if (code == 13) {
                e.preventDefault();
                e.stopPropagation();
                basketObject.updateBasket();
            }
        });
    },
    updateBasketButton: function (thisIdentity) {
        "use strict";
        $(document).on('click', thisIdentity, function (e) {
            e.preventDefault();
            basketObject.updateBasket();
        });
    },
    loadingPayPal: function (thisIdentity) {
        "use strict";
        $(document).on('click', thisIdentity, function (e) {
            e.preventDefault();
            e.stopPropagation();
            var thisShippingOption = $('input[name="shipping"]:checked');
            if (thisShippingOption.length > 0) {
                var token = $(this).attr('id');
                var image = "<div style=\"text-align: center;\">";
                image = image + "<p><img src=\"/images/loading.gif\"";
                image = image + " alt=\"Proceeding to PayPal\" />";
                image = image + "<br />Please wait while we are redirecting you to PayPal...</p>";
                image = image + "</div><div id=\"frm_pp\"></div>";
                $('#main_basket').fadeOut(200, function () {
                    $(this).html(image).fadeIn(200, function () {
                        basketObject.sendToPayPal(token);
                    });
                });
            } else {
                systemObject.topValidation('Please select the shipping option.');
            }
        });
    },
    sendToPayPal: function (token) {
        "use strict";
        $.post('/module/call/paypal', { token: token }, function (data) {
            if (data && !data.error) {
                $('#frm_pp').html(data.form);
                $('#frm_paypal').submit();
            } else {
                systemObject.topValidation(data.message);
                setTimeout(function () {
                    window.location.reload();
                }, 5000);
            }
        }, 'json');
    },
    shipping: function (thisIdentity) {
        "use strict";
        $(document).on('change', thisIdentity, function (e) {
            var thisOption = $(this).val();
            $.getJSON('/module/call/summary-update/shipping/' + thisOption, function (data) {
                if (data && !data.error) {
                    $('#basketSubTotal').html(data.totals.basketSubtotal);
                    $('#basketTax').html(data.totals.basketTax);
                    $('#basketTotal').html(data.totals.basketTotal);
                }
            });
        });
    }
};