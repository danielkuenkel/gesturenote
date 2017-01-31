<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Zu einem Gesten-Set hinzufügen</h4>
</div>

<div id="modal-body" class="modal-body">
    <p class="text">Es wird nur die Hauptgeste der Klassifizierung zu einem Gesten-Set hinzugefügt. Eine Hauptgeste ist durch ihren blauen Rahmen erkennbar.</p>

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
        
        <div class="alert-space alert-gesture-set-title-too-short"></div>
        
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
//                var sets = getLocalItem(GESTURE_SETS);
//                if (sets === undefined || sets === null) {
                setLocalItem(GESTURE_SETS, result.gestureSets);
//                }

                renderData(preselect, id);
            }
        });
    }

    function renderData(preselect, id) {
        clearAlerts($('#modal-body'));
        
        var sets = getLocalItem(GESTURE_SETS);
        if (sets && sets !== null && sets !== '' && sets.length > 0) {
            $('#existing-sets-container').find('.option-container').empty();
            for (var i = 0; i < sets.length; i++) {
                var option = $('#item-container-inputs').find('#checkbox').clone();
                option.find('.option-text').text(sets[i].title);
                option.find('.btn-checkbox').attr('id', sets[i].id);
                $('#existing-sets-container').find('.option-container').append(option);
                $('#existing-sets-container').find('.option-container').append(document.createElement('br'));

                // preselect item after adding new gesture set
                if (preselect === true && id && parseInt(id) === parseInt(sets[i].id)) {
                    option.find('.btn-checkbox').click();
                }

                // check gestures and make checkbox selected if gesture is in gesture set [i]
                if (sets[i].gestures && sets[i].gestures.length > 0) {
                    if (checkSetAssignment(sets[i].gestures)) {
                        option.find('.btn-checkbox').click();
                    }
                }
            }
        } else {
            appendAlert($('#modal-body'), ALERT_NO_GESTURE_SETS_FOR_STUDY);
        }
    }

    function saveData() {
        var listItems = $('#existing-sets-container').find('.option-container').find('.btn-checkbox');
        for (var i = 0; i < listItems.length; i++) {
//            console.log(listItems[i]);
            if ($(listItems[i]).hasClass('btn-option-checked')) {
//                console.log('add to gesture set with id:', $(listItems[i]).attr('id'));
                addToGestureSet($(listItems[i]).attr('id'), currentAssignment.mainGestureId);
            } else {
//                console.log('remove from gesture set with id:', $(listItems[i]).attr('id'));
                removeFromGestureSet($(listItems[i]).attr('id'), currentAssignment.mainGestureId);

            }
        }

        // call ajax update gesture sets, calling php 
        updateGestureSets({sets: getLocalItem(GESTURE_SETS)});
        var target = $('#content-btn-potential-gestures').find('#' + currentAssignment.mainGestureId);
        console.log(target);
        renderPotentialGesturesParameters(target, currentAssignment, currentAssignment.triggerId);
    }

    function checkSetAssignment(gestures) {
        for (var i = 0; i < gestures.length; i++) {
            for (var j = 0; j < currentAssignment.gestures.length; j++) {
                console.log('checkSetAssignment', gestures[i], currentAssignment.gestures[j]);
                if (parseInt(gestures[i]) === parseInt(currentAssignment.gestures[j])) {
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
                appendAlert($('#modal-body'), ALERT_GESTURE_SET_TITLE_TOO_SHORT);
            }
        } else {
            // show errors for invalid input 
        }
    });

    function addToGestureSet(setId, gestureId) {
        var sets = getLocalItem(GESTURE_SETS);
        for (var i = 0; i < sets.length; i++) {
            if (parseInt(sets[i].id) === parseInt(setId)) {
                var gestureIsAvailable = false;
                if (sets[i].gestures && sets[i].gestures !== null && sets[i].gestures.length > 0) {
                    for (var j = 0; j < sets[i].gestures.length; j++) {
                        if (parseInt(gestureId) === parseInt(sets[i].gestures[j])) {
                            gestureIsAvailable = true;
                            break;
                        }
                    }
                }

                if (!gestureIsAvailable) {
                    if (sets[i].gestures && sets[i].gestures !== null && sets[i].gestures.length > 0) {
                        sets[i].gestures.push(gestureId);
                    } else {
//                        console.log('add new gestures array');
                        sets[i].gestures = [gestureId];
                    }
                }
            }
        }

//        console.log(sets);
        setLocalItem(GESTURE_SETS, sets);
    }

    function removeFromGestureSet(setId, gestureId) {
        var sets = getLocalItem(GESTURE_SETS);
        for (var i = 0; i < sets.length; i++) {
            if (parseInt(sets[i].id) === parseInt(setId)) {
//                var gestureIsAvailable = false;
                if (sets[i].gestures && sets[i].gestures !== null && sets[i].gestures.length > 0) {
                    for (var j = 0; j < sets[i].gestures.length; j++) {
                        if (parseInt(gestureId) === parseInt(sets[i].gestures[j])) {
                            sets[i].gestures.splice(j, 1);
                            if (sets[i].gestures.length === 0) {
                                sets[i].gestures = null;
                            }
                            break;
                        }
                    }
                }
//
//                if (!gestureIsAvailable) {
//                    console.log('remove gesture from array');
//                    sets[i].gestures = [gestureId];
//                    break;
//                }
            }
        }

//        console.log(sets);
        setLocalItem(GESTURE_SETS, sets);
    }
</script>