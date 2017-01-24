<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Zu einem Gesten-Set hinzufügen</h4>
</div>

<div id="modal-body" class="modal-body">
    <label class="text">Zu vorhandenen Gesten-Sets zuweisen</label>
    <div id="existing-sets-container">
        <div class="option-container root"></div>
    </div>
    <div class="alert-space alert-no-gesture-sets-for-study"></div>

    <div class="row text-center">
        <label class="uppercase" style="font-size: 10pt"><?php echo $lang->or ?></label>
    </div>


    <div id="add-set-container">
        <label class="text">Neues Gesten-Set anlegen</label>
        <div class="input-group">
            <input type="text" class="form-control" id="input-new-set-title" minlength="8" maxlength="60" placeholder="Name des Gesten-Sets (mindestens 8 Zeichen)">
            <span class="input-group-btn">
                <button class="btn btn-info" type="button" id="btn-add-gesture-set"><i class="fa fa-plus"></i></button>
            </span>
        </div>
    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="saveData()"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo $lang->saveAndClose ?></button>
</div>

<script>
    $(document).ready(function () {
        getData();
    });

    function getData(preselect, id) {
        var query = getQueryParams(document.location.search);
        getGestureSetsForStudyId({studyId: query.studyId}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                setLocalItem(GESTURE_SETS, result);
                renderData(preselect, id);
            }
        });
    }

    function renderData(preselect, id) {
        var sets = getLocalItem(GESTURE_SETS);
        if (sets && sets !== null && sets.gestureSets !== '' && sets.gestureSets.length > 0) {
            $('#existing-sets-container').find('.option-container').empty();
            for (var i = 0; i < sets.gestureSets.length; i++) {
                var option = $('#item-container-inputs').find('#checkbox').clone();
                option.find('.option-text').text(sets.gestureSets[i].title);
                option.find('.btn-checkbox').attr('id', sets.gestureSets[i].id);
                $('#existing-sets-container').find('.option-container').append(option);
                $('#existing-sets-container').find('.option-container').append(document.createElement('br'));

                // preselect item after adding new gesture set
                if (preselect === true && id && parseInt(id) === parseInt(sets.gestureSets[i].id)) {
                    option.find('.btn-checkbox').click();
                }

                // check gestures and make checkbox selected if gesture is in gesture set [i]
                if (sets.gestureSets[i].gestures && sets.gestureSets[i].gestures.length > 0) {
                    if (checkSetAssignment(sets.gestureSets[i].gestures)) {
                        option.find('.btn-checkbox').click();
                    }
                }
            }
        } else {
            appendAlert($('#modal-body'), ALERT_NO_GESTURE_SETS_FOR_STUDY);
        }
    }

    function saveData() {

    }

    function checkSetAssignment(gestures) {
        for (var i = 0; i < gestures.length; i++) {
            for (var j = 0; j < currentAssignment.gestures.length; j++) {
                if (parseInt(gestures[i].id) === parseInt(currentAssignment.gestures[j].id)) {
                    return true;
                }
            }
        }
        return false;
    }

    $('#btn-add-gesture-set').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var title = $('#add-set-container').find('#input-new-set-title').val();
        if (title && title !== undefined && title.trim() !== '') {
            if (title.trim().length > 7) {
                var query = getQueryParams(document.location.search);
                saveGestureSetForStudyId({studyId: query.studyId, title: title}, function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        $('#add-set-container').find('#input-new-set-title').val('');
                        getData(true, result.id);
                    }
                });
            } else {
            }
        } else {
            // show errors for invalid input 
        }
    });
</script>