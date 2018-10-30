/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var rtcStreamControlsTween = null;
var currentSharedScreen = null;

var Wizard = {
    renderView: function renderView() {
        if (syncPhaseStep) {
            appendAlert(getMainContent(), ALERT_GENERAL_PLEASE_WAIT);
            Observer.initializePeerConnection();
            Observer.initializeRTC();
        } else {
            var currentPhase = getCurrentPhase();
            var currentPhaseData = getCurrentPhaseData();
//        var source = getSourceContainer(currentView);
            if (previewModeEnabled === false) {
                setLocalItem(currentPhase.id + '.tempSaveData', {});
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.startTime = timestamp;
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });
            }
//        console.log('render view', currentPhase);

            if (currentPhaseData || (currentPhaseData && $.isArray(currentPhaseData) && currentPhaseData.length > 0)) {

                var item = null;
                switch (currentPhase.format) {
                    case LETTER_OF_ACCEPTANCE:
                        currentClass = new LetterOfAcceptance();
                        break;
                    case THANKS:
                        currentClass = new Thanks();
                        break;
                    case QUESTIONNAIRE:
                        currentClass = new Questionnaire({isPreview: true});
                        break;
                    case INTERVIEW:
                        currentClass = new Interview();
                        break;
                    case FOCUS_GROUP_INTERVIEW:
                        currentClass = new FocusGroupInterview();
                        break;
                    case GUS_SINGLE_GESTURES:
                        currentClass = new GestureUsabilityScaleSingle();
                        break;
                    case GUS_MULTIPLE_GESTURES:
                        currentClass = new GestureUsabilityScaleMultiple();
                        break;
                    case SUS:
                        currentClass = new SystemUsabilityScale();
                        break;
                    case UEQ:
                        currentClass = new UserExperienceQuestionnaire();
                        break;
                    case GESTURE_TRAINING:
                        currentClass = new GestureTraining();
                        break;
                    case SCENARIO:
                        currentClass = new UserTest();
                        break;
                    case SLIDESHOW_GESTURES:
                        currentClass = new GestureSlideshow();
                        break;
                    case SLIDESHOW_TRIGGER:
                        currentClass = new TriggerSlideshow();
                        break;
                    case PHYSICAL_STRESS_TEST:
                        currentClass = new PhysicalStressTest();
                        break;
                    case IDENTIFICATION:
                        currentClass = new Identification();
                        break;
                    case EXPLORATION:
                        currentClass = new Exploration();
                        break;
                }
                item = currentClass.renderWizardView();

                if (item !== false) {
                    console.log('append item', item, syncPhaseStep);
                    if (!syncPhaseStep || currentPhase.format === THANKS) {
                        $('#viewWizard #phase-content').empty().append(item);
                    }
                } else {
                    Wizard.renderNoDataView();
                }

                if (currentPhase.format === THANKS) {
                    $('.btn-cancel').addClass('disabled');
                } else {
                    $('.btn-cancel').removeClass('disabled');
                }
            } else {
                Wizard.renderNoDataView();
            }

            Wizard.initializeRTC();
            removeAlert($('#viewWizard'), ALERT_GENERAL_PLEASE_WAIT);
            $('#viewWizard').find('#phase-content').removeClass('hidden');
            $('#viewWizard').find('#pinnedRTC').css({opacity: 1});
            pinRTC();
            updateRTCHeight($('#viewWizard #column-left').width(), true);

            $('#viewWizard #column-right').css({y: 0, opacity: 1});
            TweenMax.from($('#phase-content #column-right'), .2, {y: -20, opacity: 0, clearProps: 'all'});
            if ($(document).scrollTop() > 0) {
                $(document).scrollTop(0);
            }
        }
    },
    renderNoDataView: function renderNoDataView() {
        var alert = $(getSourceContainer(currentView)).find('#no-phase-data').clone().removeAttr('id');
        $('#viewWizard #phase-content').append(alert);
        appendAlert(alert, ALERT_NO_PHASE_DATA);
    },
    initializePeerConnection: function initializePeerConnection() {
        if (!peerConnection && !previewModeEnabled) {
            peerConnection = new PeerConnection(false);
            $(peerConnection).unbind(MESSAGE_NEXT_STEP).bind(MESSAGE_NEXT_STEP, function (event, payload) {
                nextStep();
            });

            $(peerConnection).unbind(MESSAGE_CANCEL_SURVEY).bind(MESSAGE_CANCEL_SURVEY, function (event, payload) {
                var currentPhase = getCurrentPhase();
//                if (currentPhase.format === IDENTIFICATION || currentPhase.format === EXPLORATION || currentPhase.format === GESTURE_TRAINING || currentPhase.format === SCENARIO) {
//                    if (prototypeWindow) {
//                        peerConnection.stopShareScreen(true, function () {
//                            prototypeWindow.close();
//                            prototypeWindow = null;
//                            console.log('screen stopped for canceling');
//
//                            saveCurrentStatus(false);
//                            peerConnection.stopRecording(function () {
//                                console.log('recording stopped for canceling');
//                                currentPhaseStepIndex = getThanksStepIndex();
//                                renderPhaseStep();
//                                updateProgress();
//                            }, true);
//                        });
//                        peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
//                    }
//                } else {
//                saveCurrentStatus(false);
                peerConnection.stopRecording(function () {
                    currentPhaseStepIndex = getThanksStepIndex();
                    renderPhaseStep();
                    updateProgress();
                }, true);
//                }
            });

//            $(peerConnection).unbind(MESSAGE_REQUEST_SYNC).bind(MESSAGE_REQUEST_SYNC, function (event, payload) {
//                console.log('on sync request');
//
//                resetConstraints();
//                peerConnection.sendMessage(MESSAGE_SYNC_PHASE_STEP, {index: currentPhaseStepIndex});
//
//                $('#custom-modal').find('.modal-content').empty();
//                $('#custom-modal').modal('hide');
//
//                renderPhaseStep();
//            });
//
//            $(peerConnection).unbind(MESSAGE_SYNC_PHASE_STEP).bind(MESSAGE_SYNC_PHASE_STEP, function (event, payload) {
//                console.log('sync phase step', payload.index);
//
//                if (prototypeWindow) {
//                    prototypeWindow.close();
//                    prototypeWindow = null;
//                }
//
//                syncPhaseStep = false;
//                currentPhaseStepIndex = payload.index;
//                renderPhaseStep();
//                updateProgress();
//            });

//            $(peerConnection).unbind('videoAdded').bind('videoAdded', function () {
//                if (syncPhaseStep) {
//                    peerConnection.sendMessage(MESSAGE_REQUEST_SYNC, {index: currentPhaseStepIndex});
//                }
//            });

//            $(peerConnection).unbind(CONNECTION_STATE_CONNECTED).bind(CONNECTION_STATE_CONNECTED, function () {
//                console.log('connected: ', CONNECTION_STATE_CONNECTED);
//                removeAlert($('#viewObserver'), ALERT_GENERAL_PLEASE_WAIT);
//                $('#viewObserver').find('#phase-content').removeClass('hidden');
//                $('#viewObserver').find('#pinnedRTC').css({opacity: 1});
//                pinRTC();
//                updateRTCHeight($('#viewObserver #column-left').width(), true);
//            });
//
//            $(peerConnection).unbind(CONNECTION_STATE_DISCONNECTED).bind(CONNECTION_STATE_DISCONNECTED, function () {
//                console.log('disconnected: ', CONNECTION_STATE_DISCONNECTED);
//                removeAlert($('#viewObserver'), ALERT_GENERAL_PLEASE_WAIT);
//
//                resetConstraints();
//                peerConnection.stopShareScreen();
//                if (prototypeWindow) {
//                    prototypeWindow.close();
//                    prototypeWindow = null;
//                }
//
//                if (getCurrentPhase().format !== THANKS) {
////                    console.log('append alert please wait', $('#viewObserver'));
//                    appendAlert($('#viewObserver'), ALERT_GENERAL_PLEASE_WAIT);
//                    $('#viewObserver').find('#phase-content').addClass('hidden');
//                    $('#viewObserver').find('#pinnedRTC').css({opacity: 0});
//                }
//            });

            $(peerConnection).unbind(MESSAGE_REQUEST_SYNC).bind(MESSAGE_REQUEST_SYNC, function (event, payload) {
//                console.log('REQUEST SYNC');
                event.preventDefault();
                currentPhaseStepIndex = payload.index;
                setTimeout(function () {
//                    console.log('CONNECTION:', peerConnection);
                    peerConnection.sendMessage(MESSAGE_SYNC_REQUEST, {nick: VIEW_WIZARD});
                }, 500);

            });

            $(peerConnection).unbind(MESSAGE_SYNC_RESPONSE).bind(MESSAGE_SYNC_RESPONSE, function (event, payload) {
                event.preventDefault();
                if (payload && payload.nick === VIEW_WIZARD) {
//                    console.log('SYNC RESPONSE', payload);
                    var study = getLocalItem(STUDY);
                    study.evaluatorId = payload.evaluatorId;
                    setLocalItem(STUDY, study);

                    syncPhaseStep = false;
                    currentPhaseStepIndex = payload.index;
                    currentPhaseState = payload.currentPhaseState;
                    renderPhaseStep();
                    updateProgress();
                }
            });

            $(peerConnection).unbind('joinedRoom').bind('joinedRoom', function () {
                peerConnection.sendMessage(MESSAGE_SYNC_REQUEST, {nick: VIEW_OBSERVER});
            });

            $(peerConnection).unbind('videoRemoved').bind('videoRemoved', function (event, video, peer) {
                console.log('videoRemoved', video, peer);
                removeAlert($('#viewWizard'), ALERT_GENERAL_PLEASE_WAIT);
                if (getCurrentPhase().format !== THANKS) {
                    appendAlert($('#viewWizard'), ALERT_GENERAL_PLEASE_WAIT);
                    $('#viewWizard').find('#phase-content').addClass('hidden');
                    $('#viewWizard').find('#pinnedRTC').css({opacity: 0});
                }
            });

            $(peerConnection).unbind(MESSAGE_SHARED_SCREEN_ADDED).bind(MESSAGE_SHARED_SCREEN_ADDED, function (event, video) {
                console.log('on add shared screen', video);
                currentSharedScreen = video;
                setTimeout(function () {
                    initScreenSharing();
                }, 1000);

//                peerConnection.sendMessage(MESSAGE_SCREEN_SHARING_ESTABLISHED);
            });
        }
    },
    initializeRTC: function initializeRTC() {
        // check preview or live mode, and check if webRTC is needed
        $('#animatableRTC').addClass('hidden');
        initPopover();
        if (isWebRTCNeededInFuture()) {
            if (previewModeEnabled === true) {
                Wizard.appendRTCPreviewStream();
            } else {
                Wizard.appendRTCLiveStream();
            }
        } else {
            resetLiveStream();
        }
    },
    appendRTCPreviewStream: function appendRTCPreviewStream() {
        var source = getSourceContainer(currentView);
        var target = $('#viewWizard').find('.pinnedRTC');
        var callerElement = $(source).find('#wizard-web-rtc-placeholder').clone().attr('id', 'web-rtc-placeholder');
        $(target).empty().prepend(callerElement);
        pinRTC();
        updateRTCHeight($('#viewWizard #column-left').width(), true);

        var currentPhase = getCurrentPhase();
        var options = getPhaseStepOptions(currentPhase.format);
//        console.log('options: ', options);
        if (options.observer.recordStream === 'yes') {
            showRecordIndicator();
        } else {
            hideRecordIndicator();
        }

        // init mouse events and pidoco tracking, for live execution the peer connection class handles this
        var tween = new TweenMax($(callerElement).find('.stream-controls'), .3, {opacity: 1.0, paused: true});
        $(callerElement).on('mouseenter', function (event) {
            event.preventDefault();
            tween.play();
        });

        $(callerElement).on('mouseleave', function (event) {
            event.preventDefault();
            tween.reverse();
        });
    },
    appendRTCLiveStream: function appendRTCLiveStream() {
        var currentPhase = getCurrentPhase();
        var options = getPhaseStepOptions(currentPhase.format);
        var query = getQueryParams(document.location.search);
        var mainElement = $('#video-caller');
        console.log('append rtc live stream', iceTransports);

        var callerOptions = {
            target: $('#viewWizard').find('#pinnedRTC'),
            callerElement: mainElement,
            localVideoElement: 'local-stream',
            remoteVideoElement: 'remote-stream',
            sharingVideoElement: '#screen-stream',
            streamControls: $(mainElement).find('#stream-controls'),
            localMuteElement: $(mainElement).find('#btn-stream-local-mute'),
            pauseStreamElement: $(mainElement).find('#btn-pause-stream'),
            remoteMuteElement: $(mainElement).find('#btn-stream-remote-mute'),
            togglePinnedElement: $(mainElement).find('#btn-toggle-rtc-fixed'),
            indicator: $(mainElement).find('#stream-control-indicator'),
            enableWebcamStream: true,
            enableDataChannels: options.enableDataChannels && options.enableDataChannels === 'yes' || false,
            autoRequestMedia: true,
            roomId: query.roomId,
            iceTransports: iceTransports || null,
            nick: 'observer',
            ignoreRole: 'no',
            selectedRole: 'observer',
            visibleRoles: ['moderator', 'tester', 'observer', 'wizard'],
            localStream: {audio: options.observer.audio, video: options.observer.video, visualize: options.observer.visualizeStream, record: options.observer.recordStream},
            remoteStream: {audio: options.tester.audio, video: options.tester.video}
        };

        $(callerOptions.target).prepend(callerOptions.callerElement);
        pinRTC();
        updateRTCHeight($('#viewWizard #column-left').width(), true);

        peerConnection.update(callerOptions);
        Wizard.keepStreamsPlaying();
    },
    keepStreamsPlaying: function keepStreamsPlaying() {
        if (peerConnection) {
            peerConnection.keepStreamsPlaying();
        }

//        if (peerConnection.status !== STATUS_UNINITIALIZED) {
//            var videos = $(element).find('video');
//            for (var i = 0; i < videos.length; i++) {
////                if (new String($(videos[i]).attr('id')).includes('video') && !videos[i].playing) {
//                videos[i].play();
////                }
//            }
//        }
    }
};


function initScreenSharing() {
    var container = $(getMainContent()).find('#scene-container');
    console.log('INIT SCREEN SHARING', container, currentSharedScreen);

    if (!previewModeEnabled && peerConnection && currentSharedScreen) {
        $(container).empty().append(currentSharedScreen);
        var newHeight = $(window).height() - 70 - 15;
        $(container).css({height: newHeight + "px"});
        $(currentSharedScreen).css({height: '100%', width: '100%', objectFit: 'contain'});
        $(currentSharedScreen).removeAttr('controls');
        $(currentSharedScreen).removeAttr('id');

        $(window).on('resize', function () {
            var newHeight = $(window).height() - 70 - 15;
            $(container).css({height: newHeight + "px"});
        }).resize();

        Wizard.keepStreamsPlaying();
    }
}


function checkRTCUploadStatus(container) {
    if (uploadQueue && !uploadQueue.allFilesUploaded() && !uploadQueue.allFilesUploaded() && uploadQueue.uploadPending() === true) {
        console.log('sumbmit final data with upload queue, some files where not uploaded yet!');
        submitFinalData(container, false);
    } else {
        console.log('sumbmit final data without upload queue, or all files where uploaded.');
        submitFinalData(container, true);
    }
}

function submitFinalData(container, areAllRTCsUploaded) {
    $(container).find('#upload-instructions').removeClass('hidden');
    $(container).find('#upload-done, #upload-retry, #btn-leave-survey').addClass('hidden');
    if (!areAllRTCsUploaded) {
        $(container).find('#rtc-uploads').addClass('hidden');
    } else {
        $(container).find('#rtc-uploads').removeClass('hidden');
    }

    saveCurrentStatus(areAllRTCsUploaded, function (result) {
        if (result.status === RESULT_SUCCESS) {
            if (areAllRTCsUploaded) {
                $(container).find('#upload-instructions').addClass('hidden');
                $(container).find('#upload-done, #btn-leave-survey').removeClass('hidden');
            } else {
                $(container).find('#rtc-uploads').removeClass('hidden');
            }
        } else {
            $(container).find('#upload-instructions').addClass('hidden');
            $(container).find('#upload-retry').removeClass('hidden');
        }
    });
}
//
//function renderObservations(data, container) {
//    console.log('render observations:', data.observations);
//    if (data.observations && data.observations.length > 0) {
//        if (!previewModeEnabled) {
//            var savedObservations = getObservationResults(getCurrentPhase().id);
//            console.log('render observations with answers: ', data.observations, savedObservations);
//            if (savedObservations && savedObservations.length > 0) {
//                renderEditableObservations($(container).find('#observations .question-container'), data.observations, {answers: savedObservations});
//            } else {
////                renderEditableObservations($(container).find('#observations .question-container'), data.observations, {answers: null});
//                var questionnaire = new Questionnaire({isPreview: false, questions: data.observations, source: $('#item-container-inputs'), container: $(container).find('#observations')});
//                questionnaire.renderObserverView();
//            }
//
//            $(container).find('#observations').on('change', function () {
//                var study = getLocalItem(STUDY);
//                console.log('save observation answers');
//                saveObservationAnwers($(container).find('#observations .question-container'), study.id, study.testerId, study.evaluatorId, getCurrentPhase().id, true, true);
//            });
//        } else {
//            console.log('render observations');
//            var questionnaire = new Questionnaire({isPreview: false, questions: data.observations, source: $('#item-container-inputs'), container: $(container).find('#observations')});
//            questionnaire.renderObserverView();
//        }
//
//        $(container).find('#observations').css({marginBottom: '30px'});
//    } else {
//        appendAlert($(container).find('#observations'), ALERT_NO_PHASE_DATA);
//    }
//}