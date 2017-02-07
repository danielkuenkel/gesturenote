<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Gesten-Vorschau</h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="row">
        <div class="col-md-5 root">
            <div class="previewGesture mouseScrollable btn-shadow autoplay"></div>
            <div class="progress gesture-progress">
                <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                    <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                    <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <h3 style="margin-top: 0"><i class="fa fa-bookmark-o"></i> Allgemeines</h3>
            <div id="gesture-data-preview">
                <div id="title">Titel:<span class="address"></span> <span class="text"></span></div>
                <div id="context">Kontext:<span class="address"></span> <span class="text"></span></div>
                <div id="association">Assoziation:<span class="address"></span> <span class="text"></span></div>
                <div id="description">Beschreibung:<span class="address"></span> <span class="text"></span></div>

                <div class="preview-joints-humand-body" id="human-body" style="width: 400px; margin: auto; margin-top: 10px">
                    <div id="joint-container" style="position: absolute"></div>
                    <img src="img/human_body.svg">
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
</div>

<script>
    $(document).ready(function () {
        renderModalData();

        $('#custom-modal').bind('hidden.bs.modal', function () {
            currentPreviewGesture = null;
            gesturePreviewOpened = false;
            $(this).unbind('hidden.bs.modal');
        });
    });

    function renderModalData() {
//        console.log(currentPreviewGesture);
        var gesture = currentPreviewGesture.gesture;
        if (gesture === null) {
            return false;
        }

        var container = $('#modal-body');
        container.find('#title .text').text(gesture.title);
        container.find('#association .text').text(gesture.association === null ? '-' : gesture.association);
        container.find('#context .text').text(gesture.context);
        container.find('#description .text').text(gesture.description);

        renderGestureImages(container.find('.previewGesture'), gesture.images, gesture.previewImage, null);
        renderBodyJointsPreview(container.find('#human-body'), gesture.joints);
    }
</script>