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
            if ($('#top_message').length > 0) {
                $('#top_message').remove();
            }
            $('body').prepend($(systemObject.topValidationTemplate(thisMessage)).fadeIn(200));
            setTimeout(function () {
                $('#top_message').fadeOut(function () {
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
            if (option == 'United States') {
                $('.state-input').hide();
                $('.state-select').show();
            } else {
                $('.state-select').hide();
                $('.state-input').show();
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
    }
};