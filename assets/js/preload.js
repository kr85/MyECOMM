var imagePreload = {
    preloadImages: function (url, type) {
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
    },
    preload: function () {
        imagePreload.preloadImages('/module/call/preload-images', ['images', 'catalog']);
    }
};

(function () {
    imagePreload.preload();
}());