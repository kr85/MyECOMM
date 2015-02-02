var adminObject = {
    isEmpty: function(thisValue) {
        "use strict";

        return (thisValue !== '' && typeof thisValue !== 'undefined') ? false : true;
    },
    clickReplace: function(thisIdentity) {
        "use strict";

        $(document).on('click', thisIdentity, function(e) {
            e.preventDefault();
            var thisObj = $(this);
            var thisUrl = thisObj.data('url');
            $.getJSON(thisUrl, function(data) {
                if (data && !data.error) {
                    if (!adminObject.isEmpty(data.replace)) {
                        thisObj.replaceWith(data.replace);
                    }
                }
            });
        });
    },
    clickCallReload: function(thisIdentity) {
        "use strict";

        $(document).on('click', thisIdentity, function(e) {
            e.preventDefault();
            var thisUrl = $(this).data('url');
            $.getJSON(thisUrl, function(data) {
                if (data && !data.error) {
                    window.location.reload();
                }
            });
        });
    },
    clickYesNoSingle: function(thisIdentity) {
        "use strict";

        $(document).on('click', thisIdentity, function(e) {
            e.preventDefault();
            var thisObj = $(this);
            var thisValue = thisObj.data('value');
            if (parseInt(thisValue, 10) === 0) {
                var thisGroup = thisObj.data('group');
                var thisGroupItems = $('[data-group="' + thisGroup + '"]');
                var thisUrl = thisObj.data('url');
                $.getJSON(thisUrl, function(data) {
                    if (data && !data.error) {
                        $.each(thisGroupItems, function() {
                            $(this).text('No');
                            $(this).attr('data-value', 0);
                        });
                        thisObj.text('Yes');
                        thisObj.attr('data-value', 1);
                    }
                });
            }
        });
    }
};