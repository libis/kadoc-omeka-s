(function($) {
    $(document).ready(function() {        
        var galleryState = ($('#itemfiles li').length > 1) ? true : false;

        var lgContainer = document.getElementById('itemfiles');
        var inlineGallery = lightGallery(lgContainer, {
            container: lgContainer,
            dynamic: false,
            hash: true,
            download: false,
            closable: false,
            thumbnail: true,
            selector: '.media.resource',
            showMaximizeIcon: true,
            autoplayFirstVideo: false,
            exThumbImage: 'data-thumb',
            flipVertical: false,
            flipHorizontal: false,
            height:'300px',
            plugins: [
                lgThumbnail,lgVideo,lgHash
            ],
        });

        inlineGallery.openGallery();
    });
})(jQuery)

