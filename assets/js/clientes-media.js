jQuery(function($){
    let mediaFrame;

    $('#upload_cliente_media').on('click', function(e) {
        e.preventDefault();

        if (mediaFrame) {
            mediaFrame.open();
            return;
        }

        mediaFrame = wp.media({
            title: 'Selecionar logo',
            button: { text: 'Usar esta imagem' },
            library: { type: 'image' },
            multiple: false
        });

        mediaFrame.on('select', function() {
            const attachment = mediaFrame.state().get('selection').first().toJSON();
            $('#cliente_media_id').val(attachment.id);
            if (attachment.sizes && attachment.sizes.thumbnail) {
                $('#upload_cliente_media').before('<img src="'+attachment.sizes.thumbnail.url+'" style="max-width:80px;display:block;margin-bottom:8px;">');
            }
        });

        mediaFrame.open();
    });
});
