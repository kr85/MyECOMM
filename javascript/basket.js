$(document).ready(function() {

    initializeBinds();

    function initializeBinds() {
        if ($('.update_basket').length > 0) {
            $('.update_basket').bind('click', updateBasket);
        }

        if ($('.remove_basket').length > 0) {
            $('.remove_basket').bind('click', removeFromBasket);
        }

        if ($('.fld_qty').length > 0) {
            $('.fld_qty').bind('keypress', function(e) {
                var code = e.keyCode ? e.keyCode : e.which;
                if (code == 13) {
                    updateBasket();
                }
            });
        }
    }

    function removeFromBasket(event) {
        event.preventDefault();

        var item = $(this).attr('rel');

        $.ajax({
            type: 'POST',
            url: '/modules/basket_remove.php',
            dataType: 'html',
            data: ({ id: item }),
            success: function() {
                refreshMainBasket();
                refreshSmallBasket();
            },
            error: function() {
                alert("An error has occurred.");
            }
        });
    }

    function refreshSmallBasket() {

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
    }

    function refreshMainBasket() {

        $.ajax({
            url: '/modules/basket_view.php',
            dataType: 'html',
            success: function(data) {
                $('#main_basket').html(data);
                initializeBinds();
            },
            error: function() {
                alert("An error has occurred.");
            }
        });
    }

    if ($(".add_to_basket").length > 0) {
        $(".add_to_basket").click(function(event) {
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
                        refreshSmallBasket();
                    }
                },
                error: function() {
                    alert("An error has occurred.");
                }
            });
            return false;
        });
    }

    function updateBasket() {

        $('#frm_basket :input').each(function() {
            var sid = $(this).attr('id').split('-');
            var value = $(this).val();

            $.ajax({
                type: 'POST',
                url: '/modules/basket_quantity.php',
                data: ({ id: sid[1], quantity: value }),
                success: function() {
                    refreshSmallBasket();
                    refreshMainBasket();
                },
                error: function() {
                    alert('An error has occurred.');
                }
            });
        });
    }

    if ($('.paypal').length > 0) {
        $('.paypal').click(function() {
            var token = $(this).attr('id');
            var image = "<div style=\"text-align: center;\">";
            image = image + "<img src=\"/images/loading.gif\"";
            image = image + " alt=\"Proceeding to PayPal\" />";
            image = image + "<br />Please wait while we are redirecting you to PayPal...";
            image = image + "</div><div id=\"frm_pp\"></div>";

            $('#main_basket').fadeOut(200, function() {
                $(this).html(image).fadeIn(200, function() {
                    sendToPayPal(token);
                });
            });
        });
    }

    function sendToPayPal(token) {

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
    }

});