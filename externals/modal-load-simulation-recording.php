<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->loadSimulation ?></h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="form-group root" id="select-simulation-recording">
        <label class="text"><?php echo $lang->nameOfSimulation ?></label>
        <div class="option-container" style="display: grid"></div>
    </div>

</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" style="float:left"><i class="fa fa-close"></i> <?php echo $lang->cancel ?></button>
    <button type="button" class="btn btn-default btn-shadow" id="btn-load-simulation-recording"><i class="fa fa-save"></i> <?php echo $lang->acceptAndClose ?></button>
</div>

<script>
    var recordings = null;
    $(document).ready(function () {
        renderData();

    });

    function renderData() {
        var modal = $('#custom-modal');
        var query = getQueryParams(document.location.search);

        getSimulationRecordings({gestureSetId: query.gestureSetId}, function (result) {
            $(modal).find('#select-simulation-recording .option-container').empty();
            if (result.status === RESULT_SUCCESS) {
                recordings = result.recordings;
                for (var i = 0; i < result.recordings.length; i++) {
                    var option = document.createElement('div');
                    $(option).addClass('btn-group').css({marginBottom: '5px'});
                    $(modal).find('#select-simulation-recording .option-container').append(option);

                    var deleteOption = document.createElement('div');
                    $(deleteOption).addClass('btn btn-default btn-shadow btn-delete-simulation').attr('id', result.recordings[i].id);
                    $(option).append(deleteOption);

                    var deleteOptionIcon = document.createElement('i');
                    $(deleteOptionIcon).addClass('fa fa-trash');
                    $(deleteOption).append(deleteOptionIcon);

                    var optionRadio = $('#template-general-container').find('#radio').clone();
                    $(optionRadio).css({marginTop: '0px'});
                    optionRadio.find('.option-text').text(result.recordings[i].title);
                    optionRadio.find('.btn-radio').attr('id', result.recordings[i].id);
                    $(option).append(optionRadio);
                }

                var recordedSimulation = getLocalItem(RECORDED_SIMULATION);
                if (recordedSimulation) {
                    $(modal).find('#select-simulation-recording .option-container #' + recordedSimulation.id).click();
                }

                $(modal).find('.btn-delete-simulation').unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        var button = $(this);
                        var checked = $(button).parent().find('.btn-radio').hasClass('btn-option-checked');
                        lockButton(button, true, 'fa-trash');

                        deleteSimulationRecording({id: $(button).attr('id')}, function (result) {
                            unlockButton(button, true, 'fa-trash');
                            if (result.status === RESULT_SUCCESS) {
                                console.log('checked', checked);
                                if (checked === true) {
                                    removeLocalItem(RECORDED_SIMULATION);
                                    $('#main-tab-pane').find('#btn-gestureSet a').click();
                                    $('#main-tab-pane').find('#btn-player').addClass('disabled');
                                }
                                console.log('render data');
                                renderData();
                            }
                        });
                    }
                });
            }
        });
    }


    $('#btn-load-simulation-recording').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var modal = $('#custom-modal');
        var selectedRecording = getSimulationRecordingById($('#select-simulation-recording').find('.btn-option-checked').attr('id'));
        if (selectedRecording) {
            setLocalItem(RECORDED_SIMULATION, {
                id: selectedRecording.id,
                title: selectedRecording.title,
                created: selectedRecording.created,
                gestureSetId: selectedRecording.gestureSetId,
                source: selectedRecording.data.source || null,
                track: selectedRecording.data.track
            });
            
            $(modal).trigger('loadGestureSetSimulation');
            $(modal).modal('hide');
        } else {
        }
    });

    function getSimulationRecordingById(id) {
        if (recordings && recordings.length > 0) {
            for (var i = 0; i < recordings.length; i++) {
                if (parseInt(recordings[i].id) === parseInt(id)) {
                    return recordings[i];
                }
            }
        }
        return null;
    }
</script>