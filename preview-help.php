<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Hilfe</h4>
</div>
<div id="modal-body" class="modal-body">
    <div class="container-root" id="list-container"></div>

    <div class="root hidden" id="tester-help-item">
        <div id="text"></div>
        <div class="hidden" id="gesture-preview-container" style="margin-top: 15px">
            <div class="previewGesture"></div>
            <div class="text-center gestureControls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" id="btn-more-help">Mehr Hilfe</button>
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal">Schließen</button>
</div>

<script>
    var currentHelpIndex = 0;
    $(document).ready(function () {

        renderHelpItem();

        $('#btn-more-help').click(function (event) {
            event.preventDefault();
            currentHelpIndex++;
            renderHelpItem();
        });
    });

    function renderHelpItem() {
        $('#list-container').empty();

        var currentPhaseData = getCurrentPhaseData();
        var items = getItemsForSceneId(currentPhaseData.help, currentWOZScene.id);
        
        console.log(items);

        if (items && items.length > 0) {
            if (currentHelpIndex >= items.length - 1) {
                $('#btn-more-help').addClass('hidden');
            }
            
            var data = items[currentHelpIndex];
            var clone = $('#tester-help-item').clone().removeClass('hidden').removeAttr('id');
            clone.find('#text').text(data.option);
            $('#list-container').append(clone);
            if (data.useGestureHelp === true || data.useGestureHelp === 'true') {
                $(clone).find('#gesture-preview-container').removeClass('hidden');
                var gesture = getGestureById(data.gestureId);
                renderGestureImages($(clone).find('.previewGesture'), gesture.images, gesture.previewImage, null);
            }
        }
    }
</script>