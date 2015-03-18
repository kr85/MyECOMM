var systemObject = {
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
            var topMessageId = '#top_message';
            if ($(topMessageId).length > 0) {
                $(topMessageId).remove();
            }
            $('body').prepend($(systemObject.topValidationTemplate(thisMessage)).fadeIn(200));
            setTimeout(function () {
                $(topMessageId).fadeOut(function () {
                    $(this).remove();
                });
            }, 5000);
        }
    },
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
    },
    isEmpty: function (thisValue) {
        "use strict";
        return (!(thisValue !== '' && typeof thisValue !== 'undefined'));
    },
    replaceValues: function(thisArray) {
        "use strict";
        $.each(thisArray, function(thisKey, thisValue) {
            $(thisKey).html(thisValue);
        });
    },
    emailInactive: function (thisIdentity) {
        "use strict";
        $(document).on('click', thisIdentity, function (e) {
            e.preventDefault();
            var thisId = $(this).attr('data-id');
            $.post('/module/call/resend', { id: thisId }, function(data) {
                if (!data.error) {
                    location.href = '/resent';
                } else {
                    location.href = '/resent-failed';
                }
            }, 'json');
        });
    },
    selectCountryState: function (thisIdentity) {
        "use strict";
        $(document).on('change', thisIdentity, function () {
            var option = $(thisIdentity + ' option:selected').text();
            var stateSelect = '.state-select';
            var stateInput = '.state-input';
            if (option == 'United States') {
                $(stateInput).hide();
                $(stateSelect).show();
            } else {
                $(stateSelect).hide();
                $(stateInput).show();
                $(stateInput).val("")
            }
        });
    },
    animateImage: function (thisIdentity) {
        "use strict";
        $(thisIdentity).hover(
            function() {
                var id = this.id;
                $('#product-image-' + id).addClass('animate-image');
                $('#product-name-' + id).css({'display': 'block'});
            },
            function() {
                var id = this.id;
                $('#product-image-' + id).removeClass('animate-image');
                $('#product-name-' + id).css({'display': 'none'});
            });
    },
    showSubNavMain: function (thisIdentity) {
        "use strict";
        $(thisIdentity).hover(
            function () {
                var id = this.id;
                var thisTarget = '#sub-nav-' + id;
                $(thisTarget).removeClass('sub-nav-wrapper-hidden');
                $(thisTarget).addClass('sub-nav-wrapper-shown');
            },
            function () {
                var id = this.id;
                var thisTarget = '#sub-nav-' + id;
                $(thisTarget).removeClass('sub-nav-wrapper-shown');
                $(thisTarget).addClass('sub-nav-wrapper-hidden');
            }
        );
    },
    formSearchEmptyValid: function (thisIdentity) {
        "use strict";
        $(document).on('submit', thisIdentity, function (e) {
            var trigger = $(this);
            var input = trigger.find('#search').val();
            if (systemObject.isEmpty(input) || input == 0) {
                e.preventDefault();
            }
        });
    },
    hideShowSiteMapSections: function (thisIdentity) {
        "use strict";
        $(document).on('click', thisIdentity, function (e) {
            e.preventDefault();
            var trigger = $(this);
            var thisTarget = trigger.attr('id');
            var catLink = 'site-map-cat';
            if (thisTarget == catLink) {
                $('#categories').show();
                $('#products').hide();
            } else {
                $('#products').show();
                $('#categories').hide();
            }
        });
    },
    selectOrderFindBy: function (thisIdentity) {
        "use strict";
        $(document).on('change', thisIdentity, function () {
            var option = $(thisIdentity + ' option:selected').val();
            if (option == 'zipcode') {
                $('#email-address').hide();
                $('#zip-code').show();
            } else {
                $('#zip-code').hide();
                $('#email-address').show();
            }
        });
    },
    useBillingInfoChecked: function (thisIdentity) {
        "use strict";
        $(document).on('change', thisIdentity, function () {
            var trigger = $(this);
            if (trigger.is(':checked')) {
                $('#shipping_first_name').val($('#first_name').val());
                $('#shipping_last_name').val($('#last_name').val());
                $('#shipping_address_1').val($('#address_1').val());
                $('#shipping_address_2').val($('#address_2').val());
                $('#shipping_city').val($('#city').val());
                $('#shipping_state').val($('#state').val())
                $('#shipping_zip_code').val($('#zip_code').val());
                $('#shipping_country').val($('#country').val());
                $('#shipping_email').val($('#email').val());
            } else {
                $('#shipping_first_name').val('');
                $('#shipping_last_name').val('');
                $('#shipping_address_1').val('');
                $('#shipping_address_2').val('');
                $('#shipping_city').val('');
                $('#shipping_state').val('');
                $('#shipping_zip_code').val('');
                $('#shipping_country').val('');
                $('#shipping_email').val('');
            }
        });
    },
    loadingGif: function (thisIdentity) {
        "use strict";
        $(window).load(function() {
            $(thisIdentity).fadeOut('slow');
        });
    },
    preload: function () {
        "use strict";
        systemObject.preloadImages('/module/call/preload-images', ['images', 'catalog']);
    },
    preloadImages: function (url, type) {
        "use strict";
        var currentUrl = window.location.pathname;
        if (currentUrl == '/') {
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: { type: type },
                success: function (data) {
                    if (data && !data.error) {
                        $.imgpreload(data.filenames, {
                            all: function () {
                                console.log('All loaded.');
                            }
                        });
                    }
                },
                error: function () {
                    console.log('Not preloaded.');
                }
            });
        }
    }
};