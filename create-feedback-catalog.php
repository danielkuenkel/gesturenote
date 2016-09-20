<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">Feedbackset zusammenstellen</h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="form-group form-group-no-margin">
        <div class="input-group">
            <span class="input-group-addon">Feedback Format</span>
            <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
            <div class="input-group-btn select" id="addFormatSelect" role="group">
                <button class="btn btn-default btn-shadow btn-dropdown" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                    <li id="text"><a href="#">Text</a></li>
                    <li id="sound"><a href="#">Sound</a></li>
                </ul>
                <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="addFormat" type="button"><span class="glyphicon glyphicon-plus"></span></button>
            </div>
        </div>
    </div>
</div>
<hr style="margin: 0;">
<div id="modal-body" class="modal-body">
    <div class="container-root" id="list-container"></div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>


<script type="text/javascript" src="js/template-create.js"></script>
<script>
        $(document).ready(function () {
            closeClicked = false;

            var data = getLocalItem(ASSEMBLED_FEEDBACK);

            if (data !== null) {
                renderData(data);
            }

            $('#custom-modal').bind('hidden.bs.modal', function () {
                updateCatalogButtons();
                $(this).unbind('hidden.bs.modal');
            });
        });

        function renderData(data) {
            for (var i = 0; i < data.length; i++) {
                var item = data[i];
                var clone = $('#form-item-container').find('#' + item.type).clone();
                clone.find('.item-input-text').val(item.title);
                clone.attr('name', item.id);
                $('#list-container').append(clone);
                updateBadges($('#list-container'), item.type);

                switch (item.type) {
                    case TYPE_FEEDBACK_TEXT:
                        $(clone).find('.negative #' + data[i].parameters.negative).click();
//                        }
                        break;
                    case TYPE_FEEDBACK_SOUND:
                        if (data[i].data !== null) {
                            $(clone).find('.audio-holder').attr('src', data[i].data);
                            $(clone).find('.audioPlayer').removeClass('hidden');

                            $(clone).find('.chooseFeedbackSound .btn-text').text('Andere Sounddatei auswählen');
                            $(clone).find('.chooseFeedbackSound .btn-icon').removeClass('fa fa-volume-up');
                            $(clone).find('.chooseFeedbackSound .btn-icon').addClass('glyphicon glyphicon-refresh');
                        }
                        break;
                }
            }

            checkCurrentListState($('#list-container'));
        }

        function saveData() {
            var assembledData = new Array();
            var items = $('#list-container').children();
            for (var i = 0; i < items.length; i++) {
                var item = items[i];
                var type = $(item).attr('id');
                var id = $(item).attr('name') === undefined || null ? chance.natural() : $(item).attr('name');
                var title = $(item).find('.item-input-text').val();
                var parameters = null;
                var data = null;

                switch (type) {
                    case TYPE_FEEDBACK_TEXT:
                        parameters = {negative: $(item).find('.negative .active').attr('id')};
                        assembledData.push(new Feedback(id, type, title, parameters, data));
                        break;
                    case TYPE_FEEDBACK_SOUND:
                        var url = $(item).find('.audio-holder').attr('src');
                        if (url.trim() !== '') {
                            data = $(item).find('.audio-holder').attr('src');
                        }

                        assembledData.push(new Feedback(id, type, title, parameters, data));
                        break;
                }
            }
            setLocalItem(ASSEMBLED_FEEDBACK, assembledData);
        }
</script>