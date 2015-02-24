var basketObject = {
    addToBasket: function (thisIdentity) {
        "use strict";

        $(document).on('click', thisIdentity, function (e) {
            e.preventDefault();

            var trigger = $(this);
            var param = trigger.attr("rel");
            var item = param.split("_");

            $.ajax({
                type: 'POST',
                url: '/modules/basket.php',
                dataType: 'json',
                data: ({id: item[0], job: item[1]}),
                success: function (data) {
                    if (data && !data.error) {
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
                        } else {
                            console.log(data);
                            alert("Error");
                        }
                    }
                },
                error: function (data) {
                    console.log(data);
                    alert("An error has occurred.");
                }
            });
        });
    },
    refreshMainBasket: function () {
        "use strict";

        $.ajax({
            url: '/basket/action/view',
            dataType: 'html',
            success: function (data) {
                $('#main_basket').html(data);
            },
            error: function () {
                alert("An error has occurred.");
            }
        });
    },
    refreshSmallBasket: function () {
        "use strict";

        $.ajax({
            url: '/modules/basket_small_refresh.php',
            dataType: 'json',
            success: function (data) {
                $.each(data, function (k, v) {
                    if (typeof v == 'string' || v instanceof String) {
                        $("#basket_left ." + k + " span").text('$' + v);
                    } else {
                        $("#basket_left ." + k + " span").text(v);
                    }
                });
            },
            error: function () {
                alert("An error has occurred.");
            }
        });
    },
    removeFromBasket: function (thisIdentity) {
        "use strict";

        $(document).on('click', thisIdentity, function (e) {
            e.preventDefault();
            var item = $(this).attr('rel');
            $.ajax({
                type: 'POST',
                url: '/modules/basket_remove.php',
                dataType: 'html',
                data: ({id: item}),
                success: function () {
                    basketObject.refreshSmallBasket();
                    basketObject.refreshMainBasket();
                },
                error: function () {
                    alert("An error has occurred.");
                }
            });
        });
    },
    updateBasket: function () {
        "use strict";

        $.each($('#frm_basket :input'), function () {
            var sid = $(this).attr('id').split('-');
            var value = $(this).val();

            $.ajax({
                type: 'POST',
                url: '/modules/basket_quantity.php',
                data: ({id: sid[1], quantity: value}),
                success: function () {
                    basketObject.refreshSmallBasket();
                    basketObject.refreshMainBasket();
                },
                error: function () {
                    alert('An error has occurred.');
                }
            });
        });
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

        $.post('/modules/paypal.php', {token: token}, function (data) {
            if (data && !data.error) {
                $('#frm_pp').html(data.form);
                $('#frm_paypal').submit();
            } else {
                systemObject.topValidation(data.message);
                var thisTimeout = setTimeout(function () {
                    window.location.reload();
                }, 5000);
            }
        }, 'json');
    },
    emailInactive: function (thisIdentity) {
        "use strict";

        $(document).on('click', thisIdentity, function (e) {
            e.preventDefault();
            var thisId = $(this).attr('data-id');
            $.ajax({
                type: 'POST',
                url: '/modules/resend.php',
                dataType: 'json',
                data: ({id: thisId}),
                success: function (data) {
                    if (!data.error) {
                        location.href = '/resent'
                    } else {
                        location.href = '/resent-failed';
                    }
                },
                error: function () {
                    alert('An error has occurred.');
                }
            });
        });
    },
    shipping: function (thisIdentity) {
        "use strict";

        $(document).on('change', thisIdentity, function (e) {
            var thisOption = $(this).val();
            $.getJSON('/modules/summary_update.php?shipping=' + thisOption, function (data) {
                if (data && !data.error) {
                    $('#basketSubTotal').html(data.totals.basketSubtotal);
                    $('#basketTax').html(data.totals.basketTax);
                    $('#basketTotal').html(data.totals.basketTotal);
                }
            });
        });
    },
    topValidationTemplate: function (thisMessage) {
        "use strict";

        var thisTemplate = '<div id="top_message">';
        thisTemplate += thisMessage;
        thisTemplate += '</div>';
        return thisTemplate;
    },
    topValidation: function (thisMessage) {
        "use strict";

        if (thisMessage !== '' && typeof thisMessage !== 'undefined') {
            if ($('#top_message').length > 0) {
                $('#top_message').remove();
            }
            $('body').prepend($(systemObject.topValidationTemplate(thisMessage)).fadeIn(200));
            var thisTimeout = setTimeout(function () {
                $('#top_message').fadeOut(function () {
                    $(this).remove();
                });
            }, 5000);
        }
    }
};

var systemObject = {
    showHideRadio: function (thisIdentity) {
        "use strict";

        $(document).on('click', thisIdentity, function (e) {
            var thisTarget = $(this).attr('name');
            var thisValue = $(this).val();
            if (thisValue == 1) {
                $('.' + thisTarget).hide();
            } else {
                $('.' + thisTarget).show();
            }
        });
    }
};

$(document).ready(function () {
    "use strict";

    systemObject.showHideRadio('.show_hide_radio');
    basketObject.addToBasket('.add_to_basket');
    basketObject.updateBasketKeyPres('.fld_qty');
    basketObject.updateBasketButton('.update_basket');
    basketObject.removeFromBasket('.remove_basket');
    basketObject.loadingPayPal('.paypal');
    basketObject.emailInactive('#email_inactive');
    basketObject.shipping('.shipping_radio');

});