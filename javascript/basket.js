var basketObject = {
    addToBasket: function(o) {
        o.live('click', function() {
            event.preventDefault();

            var trigger = $(this);
            var param = trigger.attr("rel");
            var item = param.split("_");

            $.ajax({
                type: 'POST',
                url: '/modules/basket.php',
                dataType: 'json',
                data: ({ id: item[0], job: item[1] }),
                success: function(data) {
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
                        basketObject.refreshSmallBasket();
                    }
                },
                error: function() {
                    alert("An error has occurred.");
                }
            });
            return false;
        });
    },
    refreshMainBasket: function() {
        $.ajax({
            url: '/modules/basket_view.php',
            dataType: 'html',
            success: function(data) {
                $('#main_basket').html(data);
            },
            error: function() {
                alert("An error has occurred.");
            }
        });
    },
    refreshSmallBasket: function() {
        $.ajax({
            url: '/modules/basket_small_refresh.php',
            dataType: 'json',
            success: function(data) {
                $.each(data, function(k, v) {
                    $("#basket_left ." + k + " span").text(v);
                });
            },
            error: function() {
                alert("An error has occurred.");
            }
        });
    },
    removeFromBasket: function(event) {
        event.preventDefault();

        var item = $(this).attr('rel');

        $.ajax({
            type: 'POST',
            url: '/modules/basket_remove.php',
            dataType: 'html',
            data: ({ id: item }),
            success: function() {
                basketObject.refreshSmallBasket();
                basketObject.refreshMainBasket();
            },
            error: function() {
                alert("An error has occurred.");
            }
        });

        return false;
    },
    updateBasket: function() {
        jQuery.each($('#frm_basket :input'), function() {
            var sid = $(this).attr('id').split('-');
            var value = $(this).val();

            $.ajax({
                type: 'POST',
                url: '/modules/basket_quantity.php',
                data: ({ id: sid[1], quantity: value }),
                success: function() {
                    basketObject.refreshSmallBasket();
                    basketObject.refreshMainBasket();
                },
                error: function() {
                    alert('An error has occurred.');
                }
            });
        });
    },
    updateBasketKeyPres: function(o) {
        o.live('keypress', function(e) {
            var code = e.keyCode ? e.keyCode : e.which;
            if (code == 13) {
                basketObject.updateBasket();
            }
        });
    },
    updateBasketButton: function(o) {
        o.live('click', function(e) {
            basketObject.updateBasket();
            return false;
        });
    },
    loadingPayPal: function(o) {
        o.live('click', function() {
            var token = $(this).attr('id');
            var image = "<div style=\"text-align: center;\">";
            image = image + "<img src=\"/images/loading.gif\"";
            image = image + " alt=\"Proceeding to PayPal\" />";
            image = image + "<br />Please wait while we are redirecting you to PayPal...";
            image = image + "</div><div id=\"frm_pp\"></div>";

            $('#main_basket').fadeOut(200, function() {
                $(this).html(image).fadeIn(200, function() {
                    basketObject.sendToPayPal(token);
                });
            });

            return false;
        });
    },
    sendToPayPal: function(token) {
        $.ajax({
            type: 'POST',
            url: '/modules/paypal.php',
            data: ({ token: token }),
            dataType: 'html',
            success: function(data) {
                $('#frm_pp').html(data);
                $('#frm_paypal').submit();
            },
            error: function() {
                alert('An error has occurred.');
            }
        });
    },
    emailInactive: function(o) {
        o.live('click', function() {
            var thisId = $(this).attr('data-id');
            jQuery.getJSON('/modules/resend.php?id=' + thisId, function(data) {
                if (!data.error) {
                    location.href = '/resent'
                } else {
                    location.href = '/resent-failed';
                }
            });
            return false;
        });
    }
};

$(document).ready(function() {

    basketObject.addToBasket($('.add_to_basket'));
    basketObject.updateBasketKeyPres($('.fld_qty'));
    basketObject.updateBasketButton($('.update_basket'));
    basketObject.removeFromBasket($('.remove_basket'));
    basketObject.loadingPayPal($('.paypal'));
    basketObject.emailInactive($('#emailInactive'));

});