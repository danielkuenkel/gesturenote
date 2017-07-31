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
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><?php echo $lang->close ?></button>
</div>

<script>
    $(document).ready(function () {
        var scene = getSceneById(currentSceneId);
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
        $('#list-container').append(container);

        switch (data.type) {
            case SCENE_IMAGE:
                container.find('.imageAreaContent').attr('src', data.data);
                break;
            case SCENE_VIDEO_EMBED:
                container.find('.videoContainer').addClass(data.options[0] === 'ratio_16_9' ? 'embed-responsive-16by9' : 'embed-responsive-4by3');
                container.find('.videoContainer').html(data.data[0]);
                var video = $(container).find('.videoContainer iframe');
                $(video).addClass('embed-responsive-item');
                break;
            case SCENE_PIDOCO:
                container.find('.web-frame').attr('src', data.data[1]);
                container.find('.btn-url').on('click', function (event) {
                    event.preventDefault();
                    console.log(data);
                    var win = window.open(data);
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
                container.find('.web-frame').attr('src', data.data[0]);
                container.find('.btn-url').on('click', function (event) {
                    event.preventDefault();
                    console.log(data);
                    var win = window.open(data.data[0]);
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