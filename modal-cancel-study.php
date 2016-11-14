<?php
include './includes/language.php';
?>

<!--<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">Befragung abbrechen</h4>
</div>-->
<div id="modal-body" class="modal-body">
    <div class="text-center text">
        <p>
            Die Befragung wirklich abbrechen?
        </p>
    </div>

    <div class="btn-group btn-group-justified">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-danger btn-shadow" id="btn-cancel-survey" data-dismiss="modal"><?php echo $lang->yes ?></button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-success btn-shadow" id="btn-continue-survey" data-dismiss="modal"><?php echo $lang->no ?></button>
        </div>

    </div>
</div>

<!--<div id="modal-footer" class="modal-footer">


</div>-->

<script src="js/gesture-recorder.js"></script>
<script src="js/upload-queue.js"></script>
<script>
    $(document).ready(function () {
        $('#btn-cancel-survey').click(function (event) {
            event.preventDefault();
            var study = getLocalItem(STUDY);

            if (previewModeEnabled === false) {
                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_CANCEL_SURVEY);
                }

                if (currentView === VIEW_TESTER) {
                    study.aborted = 'yes';
                    setLocalItem(STUDY, study);
                    saveCurrentStatus(false);

                    if (isUploadRecordingNeededForPhaseStep(getCurrentPhase())) {
                        if (peerConnection) {
                            peerConnection.stopRecording(function () {
                                gotoThanksScreen();
                            }, true);
                        } else {
                            gotoThanksScreen();
                        }
                    } else {
                        gotoThanksScreen();
                    }
                } else {
                    gotoThanksScreen();
                }
            } else {
                gotoThanksScreen();
            }

            resetConstraints();
            $('#custom-modal').modal('hide');
        });

        $('#btn-continue-survey').click(function (event) {
            event.preventDefault();
            $('#custom-modal').modal('hide');
        });
    });

    function gotoThanksScreen() {
        console.log('goto thanks screen');
        currentPhaseStepIndex = getThanksStepIndex();
        resetRecorder();
        renderPhaseStep();
        updateProgress();
    }
</script>