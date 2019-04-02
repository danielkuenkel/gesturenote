<?php
include '../includes/language.php';
?>

<div id="modal-body" class="modal-body">
    <div class="text-center text">
        <p><?php echo $lang->cancelExecution ?></p>
    </div>

    <div class="btn-group btn-group-justified">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default btn-shadow" id="btn-cancel-survey" data-dismiss="modal"><?php echo $lang->yes ?></button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default btn-shadow" id="btn-continue-survey" data-dismiss="modal"><?php echo $lang->no ?></button>
        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        $('#btn-cancel-survey').click(function (event) {
            event.preventDefault();
            var study = getLocalItem(STUDY);

            if (previewModeEnabled === false) {
                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_CANCEL_SURVEY);
                }

                study.aborted = 'yes';
                setLocalItem(STUDY, study);
                saveCurrentStatus(false);

                if (isUploadRecordingNeededForPhaseStep(getCurrentPhase())) {
                    if (peerConnection) {
                        var currentPhase = getCurrentPhase();
                        console.log('abort study', currentPhase, currentView);
                        if (currentView === VIEW_MODERATOR && (
                                currentPhase.format === IDENTIFICATION || 
                                currentPhase.format === EXPLORATION ||
                                currentPhase.format === GESTURE_TRAINING ||
                                currentPhase.format === SCENARIO ||
                                currentPhase.format === FOCUS_GROUP_INTERVIEW
                                )) {
                            if (prototypeWindow) {
                                peerConnection.stopShareScreen(true, function () {
                                    prototypeWindow.close();
                                    prototypeWindow = null;
                                    console.log('screen sharing stopped for canceling');

                                    peerConnection.stopRecording(function () {
                                        console.log('1: recording stopped for canceling');
                                        abortStudy();
                                    }, true);
                                });
                            } else {
                                peerConnection.stopRecording(function () {
                                    console.log('2: recording stopped for canceling');
                                    abortStudy();
                                }, true);
                            }
                        } else {
                            peerConnection.stopRecording(function () {
                                console.log('3: recording stopped for canceling');
                                abortStudy();
                            }, true);
                        }
                    } else {
                        abortStudy();
                    }
                } else {
                    abortStudy();
                }
            } else {
                abortStudy();
            }
        });

        function abortStudy() {
            gotoThanksScreen();
            resetConstraints();
            $('#custom-modal').modal('hide');
        }

        $('#btn-continue-survey').click(function (event) {
            event.preventDefault();
            $('#custom-modal').modal('hide');
        });
    });

    function gotoThanksScreen() {
        if (previewModeEnabled === true) {
            $('.phaseStepsSelect').find('li a').last().click();
        } else {
            currentPhaseStepIndex = getThanksStepIndex();
//            resetRecorder();
            updateProgress();
            renderPhaseStep();
        }
    }
</script>