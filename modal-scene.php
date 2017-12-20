<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Zustands-Vorschau</h4>
</div>
<div id="modal-body" class="modal-body">

    <div id="list-container"></div>

</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    $(document).ready(function () {
        var scene = getSceneById(currentSceneId);
        
        console.log(scene);
        if (scene) {
            renderData(scene);
        }

        $('#modal-body').closest('.modal').on('hidden.bs.modal', function () {
            $('#modal-body').find('#list-container').empty();
        });
    });

    function renderData(data) {
        var container = $('#item-container-moderator').find('#' + data.type).clone().removeAttr('id');
        container.find('.type .label-text').text(translation.sceneTypes[data.type]);
        container.find('.title').text(data.title);
        $('#modal-body').find('#list-container').append(container);

        switch (data.type) {
            case SCENE_IMAGE:
                container.find('.imageAreaContent').attr('src', data.parameters.url);
                break;
            case SCENE_VIDEO_EMBED:
                container.find('.videoContainer').addClass(data.parameters.ratio === 'ratio_16_9' ? 'embed-responsive-16by9' : 'embed-responsive-4by3');
                container.find('.videoContainer').html(data.parameters.url);
                var video = $(container).find('.videoContainer iframe');
                $(video).addClass('embed-responsive-item');
                break;
            case SCENE_PIDOCO:
                container.find('.web-frame').attr('src', data.parameters.url);
                container.find('.btn-url').on('click', function (event) {
                    event.preventDefault();
                    console.log(data);
                    var win = window.open(data.parameters.url);
                    if (win) {
                        //Browser has allowed it to be opened
                        win.focus();
                    } else {
                        //Broswer has blocked it
                        console.log('Please allow popups for this site');
                    }
                });
                break;
            case SCENE_WEB:
                container.find('.web-frame').attr('src', data.parameters.url);
                container.find('.btn-url').on('click', function (event) {
                    event.preventDefault();
                    console.log(data);
                    var win = window.open(data.parameters.url);
                    if (win) {
                        //Browser has allowed it to be opened
                        win.focus();
                    } else {
                        //Broswer has blocked it
                        console.log('Please allow popups for this site');
                    }
                });
                break;
        }
    }

</script>