/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var prototypeWindow = null;
var rtcStreamControlsTween = null;
var continuousMouseManipluationGesture = null;

var Moderator = {
    renderView: function renderView() {
        if (syncPhaseStep) {
            appendAlert($('#viewModerator'), ALERT_GENERAL_PLEASE_WAIT);
            Moderator.initializePeerConnection();
            Moderator.initializeRTC();
        } else {
            var currentPhase = getCurrentPhase();
            var currentPhaseData = getCurrentPhaseData();
            if (previewModeEnabled === false) {
                setLocalItem(currentPhase.id + '.tempSaveData', {});
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.startTime = timestamp;
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });
            }

//            Moderator.initializePeerConnection();
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
                item = currentClass.renderModeratorView();

                if (item !== false) {
                    console.log('append item', item, syncPhaseStep);
                    if (!syncPhaseStep || currentPhase.format === THANKS) {
                        $('#viewModerator #phase-content').empty().append(item);
                    }
//                    initObserverAnnotationHandling();
                } else {
                    Moderator.renderNoDataView();
                }

                if (currentPhase.format === THANKS) {
                    $('.btn-cancel').addClass('disabled');
                } else {
                    $('.btn-cancel').removeClass('disabled');
                }
            } else {
                Moderator.renderNoDataView();
            }


            Moderator.initializeRTC();
            removeAlert($('#viewModerator'), ALERT_GENERAL_PLEASE_WAIT);
            $('#viewModerator').find('#phase-content').removeClass('hidden');
            $('#viewModerator').find('#pinnedRTC').css({opacity: 1});
            pinRTC();
            updateRTCHeight($('#viewModerator #column-left').width(), true);

            $('#viewModerator #column-right').css({y: 0, opacity: 1});
            TweenMax.from($('#phase-content #column-right'), .2, {y: -20, opacity: 0});
            if ($(document).scrollTop() > 0) {
                $(document).scrollTop(0);
            }

            if (isPidocoSocketNeeded() && getBrowser() === BROWSER_FIREFOX &&
                    (currentPhase.format === SCENARIO ||
                            currentPhase.format === GESTURE_TRAINING ||
                            currentPhase.format === EXPLORATION ||
                            currentPhase.format === IDENTIFICATION)) {
                console.log('pidoco socket needed');
                initWebSocket();
            } else {
                destroyWebsocket();
            }
        }
    },
    renderNoDataView: function renderNoDataView() {
        var alert = $(getSourceContainer(currentView)).find('#no-phase-data').clone().removeAttr('id');
        $('#viewModerator #phase-content').append(alert);
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
                if (currentPhase.format === IDENTIFICATION || currentPhase.format === EXPLORATION || currentPhase.format === GESTURE_TRAINING || currentPhase.format === SCENARIO) {
                    if (prototypeWindow) {
                        peerConnection.stopShareScreen(true, function () {
                            prototypeWindow.close();
                            prototypeWindow = null;
                            console.log('screen stopped for canceling');

                            saveCurrentStatus(false);
                            peerConnection.stopRecording(function () {
                                console.log('recording stopped for canceling');
                                currentPhaseStepIndex = getThanksStepIndex();
                                renderPhaseStep();
                                updateProgress();
                            }, true);
                        });
                        peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
                    }
                } else {
                    saveCurrentStatus(false);
                    peerConnection.stopRecording(function () {
                        currentPhaseStepIndex = getThanksStepIndex();
                        renderPhaseStep();
                        updateProgress();
                    }, true);
                }
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

//            $(peerConnection).unbind(CONNECTION_STATE_CONNECTED).bind(CONNECTION_STATE_CONNECTED, function () {
//                console.log('connected: ', CONNECTION_STATE_CONNECTED);
//            });
//
//            $(peerConnection).unbind(CONNECTION_STATE_DISCONNECTED).bind(CONNECTION_STATE_DISCONNECTED, function () {
//                console.log('disconnected: ', CONNECTION_STATE_DISCONNECTED);
//                removeAlert($('#viewModerator'), ALERT_GENERAL_PLEASE_WAIT);
//
//                resetConstraints();
//                peerConnection.stopShareScreen();
//                if (prototypeWindow) {
//                    prototypeWindow.close();
//                    prototypeWindow = null;
//                }
//
//                if (getCurrentPhase().format !== THANKS) {
////                    console.log('append alert please wait', $('#viewModerator'));
//                    appendAlert($('#viewModerator'), ALERT_GENERAL_PLEASE_WAIT);
//                    $('#viewModerator').find('#phase-content').addClass('hidden');
//                    $('#viewModerator').find('#pinnedRTC').css({opacity: 0});
//                }
//            });

//            $(peerConnection).unbind('videoAdded').bind('videoAdded', function () {
//                if (syncPhaseStep) {
//                    peerConnection.sendMessage(MESSAGE_REQUEST_SYNC, {index: currentPhaseStepIndex});
//                }
//            });

            var wizardTimer = null;
            var waitForWizard = false;
            $(peerConnection).unbind(MESSAGE_SYNC_REQUEST).bind(MESSAGE_SYNC_REQUEST, function (event, payload) {
//                console.log('SYNC REQUEST', payload);
                var study = getLocalItem(STUDY);
                var currentPhase = getCurrentPhase();

                if (payload.nick === VIEW_WIZARD && currentPhase.format === SCENARIO) {
                    clearTimeout(wizardTimer);

                    if (waitForWizard === true) {
                        console.log('WAIT FOR WIZARD');
                        setTimeout(function () {
                            resetConstraints();
                            renderPhaseStep();
                            waitForWizard = false;
                            test();
                        }, 500);
                    }
                }

                event.preventDefault();
                setTimeout(function () {
                    if (payload.nick === VIEW_TESTER) {
                        $('#custom-modal').find('.modal-content').empty();
                        $('#custom-modal').modal('hide');
                        syncPhaseStep = false;
                        resetConstraints();
                        renderPhaseStep();
                        test();
                    } else {
                        peerConnection.sendMessage(MESSAGE_SYNC_RESPONSE, {index: currentPhaseStepIndex, nick: payload.nick, currentPhaseState: currentPhaseState, evaluatorId: study.sessionUserId});
                        renderObservations(getCurrentPhaseData(), getMainContent());
                    }
                }, 500);
            });

            $(peerConnection).unbind('joinedRoom').bind('joinedRoom', function () {
                peerConnection.sendMessage(MESSAGE_REQUEST_SYNC, {index: currentPhaseStepIndex});
            });

            $(peerConnection).unbind('videoRemoved').bind('videoRemoved', function (event, video, peer) {
//                console.log('videoRemoved', video, peer);
                removeAlert($('#viewModerator'), ALERT_GENERAL_PLEASE_WAIT);
                var currentPhase = getCurrentPhase();
                if (peer.nick === VIEW_TESTER || (peer.nick === VIEW_WIZARD && currentPhase.format === SCENARIO)) {
                    if (getCurrentPhase().format !== THANKS) {
                        appendAlert($('#viewModerator'), ALERT_GENERAL_PLEASE_WAIT);
                        $('#viewModerator').find('#phase-content').addClass('hidden');
                        $('#viewModerator').find('#pinnedRTC').css({opacity: 0});
                    }

                    if (peer.nick === VIEW_WIZARD && currentPhase.format === SCENARIO) {
                        clearTimeout(wizardTimer);
                        waitForWizard = true;
                        peerConnection.stopRecording(null, false);
                        wizardTimer = setTimeout(function () {
                            syncPhaseStep = false;
                            resetConstraints();
                            renderPhaseStep();
                        }, 8000);
                    }
                } else {
                    renderObservations(getCurrentPhaseData(), getMainContent());
                }
            });

            function test() {
                var study = getLocalItem(STUDY);
                var peers = peerConnection.getPeers();

                if (peers && peers.length > 0) {
                    for (var i = 0; i < peers.length; i++) {
                        if (peers[i].type === TYPE_PEER_VIDEO) {
                            peerConnection.sendMessage(MESSAGE_SYNC_RESPONSE, {index: currentPhaseStepIndex, nick: peers[i].nick, currentPhaseState: currentPhaseState, evaluatorId: study.sessionUserId});
                        }
                    }
                }
            }

            $(peerConnection).unbind(MESSAGE_SHARED_SCREEN_ADDED).bind(MESSAGE_SHARED_SCREEN_ADDED, function (event, video) {
                console.log('on add shared screen', video);
                currentSharedScreen = video;
                $(video).css({opacity: 0});
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
                Moderator.appendRTCPreviewStream();
            } else {
                Moderator.appendRTCLiveStream();
            }
        } else {
            resetLiveStream();
        }
    },
    appendRTCPreviewStream: function appendRTCPreviewStream() {
        var source = getSourceContainer(currentView);
        var target = $('#viewModerator').find('.pinnedRTC');
        var callerElement = $(source).find('#moderator-web-rtc-placeholder').clone().attr('id', 'web-rtc-placeholder');
        $(target).empty().prepend(callerElement);
        pinRTC();
        updateRTCHeight($('#viewModerator #column-left').width(), true);

        var currentPhase = getCurrentPhase();
        var options = getPhaseStepOptions(currentPhase.format);
        console.log('options: ', options);
        if (options.moderator.recordStream === 'yes') {
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
            target: $('#viewModerator').find('#pinnedRTC'),
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
            nick: 'moderator',
            ignoreRole: 'no',
            selectedRole: 'moderator',
            visibleRoles: ['moderator', 'tester', 'observer', 'wizard'],
            videoSource: query.vSource ? query.vSource : null,
            audioSource: query.aSource ? query.aSource : null,
            localStream: {audio: options.moderator.audio, video: options.moderator.video, visualize: options.moderator.visualizeStream, record: options.moderator.recordStream},
            remoteStream: {audio: options.tester.audio, video: options.tester.video}
        };

        $(callerOptions.target).prepend(callerOptions.callerElement);
        pinRTC();
        updateRTCHeight($('#viewModerator #column-left').width(), true);

        peerConnection.update(callerOptions);
        Moderator.keepStreamsPlaying();
    },
    keepStreamsPlaying: function keepStreamsPlaying() {
        if (peerConnection) {
            peerConnection.keepStreamsPlaying();
        }
    },
    initMousePositionFunctionalities: function initMousePositionFunctionalities() {
        var shiftKeyDown = false;
        $(window).keydown(function (event) {
            if (event.keyCode === 16) {
                var mouseTarget = previewModeEnabled ? $('body').find('#web-rtc-placeholder') : $('body').find('#video-caller');
                shiftKeyDown = true;
                console.log('shift key down', $(mouseTarget), getMainContent());
                $(mouseTarget).on('mousemove', function (event) {
                    if (shiftKeyDown === true) {
                        var targetDimensions = {width: $(mouseTarget).width(), height: $(mouseTarget).height()};
                        var targetOffset = $(mouseTarget).offset();
                        var pageCoords = {x: event.pageX, y: event.pageY};
                        var relPosX = Math.max(0, Math.min(1, (pageCoords.x - targetOffset.left) / targetDimensions.width));
                        var relPosY = Math.max(0, Math.min(1, (pageCoords.y - targetOffset.top) / targetDimensions.height));

                        showCursor(mouseTarget, CURSOR_CROSSHAIR);
                        if (continuousMouseManipluationGesture) {
                            sendContinuousPosition(continuousMouseManipluationGesture, null, relPosX, relPosY);
                        } else {
                            sendContinuousPosition('', PIDOCO_TYPE_MOUSE_SIMULATION, relPosX, relPosY);
                        }


                        $(mouseTarget).on('click', function () {
                            if (continuousMouseManipluationGesture) {
                                sendContinuousPosition(continuousMouseManipluationGesture, null, relPosX, relPosY, true);
                            } else {
                                sendContinuousPosition('', PIDOCO_TYPE_MOUSE_SIMULATION, relPosX, relPosY, true);
                            }
                        });
                    }
                });
            }
        });

        $(window).keyup(function (event) {
            var mouseTarget = previewModeEnabled ? $('body').find('#web-rtc-placeholder') : $('body').find('#video-caller');
            if (event.keyCode === 16) {
                shiftKeyDown = false;
                console.log('shift key up');
                if ($(mouseTarget).parent().attr('id') === 'draggableRTC') {
                    showCursor(mouseTarget, CURSOR_MOVE);
                } else {
                    showCursor(mouseTarget, CURSOR_DEFAULT);
                }
            }
        });
    }
};

function initScreenSharing() {
    var container = $(getMainContent()).find('#scene-container');
    console.log('INIT SCREEN SHARING', container, currentSharedScreen);

    if (!previewModeEnabled && peerConnection && currentSharedScreen) {
        $(container).empty().append(currentSharedScreen);
//        var newHeight = $(window).height() - 70 - 15;
//        $(container).css({height: newHeight + "px"});
        $(currentSharedScreen).css({height: '100%', width: '100%', objectFit: 'contain', opacity: 1, borderRadius: '4px'});
        $(currentSharedScreen).removeAttr('controls');
        $(currentSharedScreen).removeAttr('id');

//        $(window).on('resize', function () {
//            var newHeight = $(window).height() - 70 - 15;
//            $(container).css({height: newHeight + "px"});
//        }).resize();

        $(container).removeClass('hidden');
        Moderator.keepStreamsPlaying();
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

function renderObservations(data, container) {
    if (data.observations && data.observations.length > 0) {
        var study = getLocalItem(STUDY);

        if (!previewModeEnabled) {
            var savedObservations = getObservationResults(getCurrentPhase().id);

            if (peerConnection && peerConnection.isObserverConnected()) {
                console.log('OBSERVER CONNECTED for Observation rendering');
                $(peerConnection).unbind(MESSAGE_UPDATE_OBSERVATIONS).bind(MESSAGE_UPDATE_OBSERVATIONS, function (event, payload) {
                    event.preventDefault();
                    setLocalItem(STUDY_EVALUATOR_OBSERVATIONS, payload.observations);
                    console.log('UPDATE OBSERVATIONS:', getLocalItem(STUDY_EVALUATOR_OBSERVATIONS));
                    savedObservations = getObservationResults(getCurrentPhase().id);
//                    saveObservations({studyId: study.id, testerId: study.testerId, observations: getLocalItem(STUDY_EVALUATOR_OBSERVATIONS)});

                    var questionnaire = new Questionnaire({isPreview: true, questions: data.observations, source: $('#item-container-inputs'), container: $(container).find('#observations'), answers: {answers: savedObservations}});
                    questionnaire.renderModeratorView();
                });

                $(container).find('#observations').unbind('change');
                var questionnaire = new Questionnaire({isPreview: true, questions: data.observations, source: $('#item-container-inputs'), container: $(container).find('#observations'), answers: {answers: savedObservations}});
                questionnaire.renderModeratorView();
            } else {
                console.log('render observations with answers: ', data.observations, savedObservations);
                if (savedObservations && savedObservations.length > 0) {
                    savedObservations = getObservationResults(getCurrentPhase().id);
                    renderEditableObservations($(container).find('#observations .question-container'), data.observations, {answers: savedObservations});
                } else {
                    var questionnaire = new Questionnaire({isPreview: false, questions: data.observations, source: $('#item-container-inputs'), container: $(container).find('#observations')});
                    questionnaire.renderModeratorView();
                }

                $(container).find('#observations').unbind('change').bind('change', function () {
                    console.log('save observation answers');
                    saveObservationAnwers($(container).find('#observations .question-container'), study.id, study.testerId, study.sessionUserId, getCurrentPhase().id, false, true);
                });
            }
        } else {
            console.log('render observations');
            var savedObservations = getObservationResults(getCurrentPhase().id);

            savedObservations = getObservationResults(getCurrentPhase().id);
            if (savedObservations) {
                renderEditableObservations($(container).find('#observations .question-container'), data.observations, {answers: savedObservations});
            } else {
                var questionnaire = new Questionnaire({isPreview: false, questions: data.observations, source: $('#item-container-inputs'), container: $(container).find('#observations')});
                questionnaire.renderModeratorView();
            }

            $(container).find('#observations').unbind('change').bind('change', function () {
                console.log('save observation answers');
                saveObservationAnwers($(container).find('#observations .question-container'), study.id, study.testerId, study.sessionUserId, getCurrentPhase().id, false, true);
            });
        }

        $(container).find('#observations').css({marginBottom: '30px'});
    } else {
        appendAlert($(container).find('#observations'), ALERT_NO_PHASE_DATA);
    }
}

function checkSingleScene(data) {
    var sceneCount = 0;
    var sceneIds = [];
    var currentPhase = getCurrentPhase();

    switch (currentPhase.format) {
        case SCENARIO:
            for (var i = 0; i < data.length; i++) {
                if (data[i].woz && data[i].woz.length > 0) {
                    for (var j = 0; j < data[i].woz.length; j++) {
                        for (var k = 0; k < data[i].woz[j].transitionScenes.length; k++) {
                            sceneIds.push(data[i].woz[j].transitionScenes[k].sceneId);
                        }

                    }
                    sceneCount += data[i].woz.length;
                }
            }
            break;
        case GESTURE_TRAINING:
            console.log(data);
            data && data.length === 1;
            if (data && data.length > 0) {
                for (var i = 0; i < data.length; i++) {
                    if (data[i].transitionScenes && data[i].transitionScenes.length > 0) {
                        for (var j = 0; j < data[i].transitionScenes.length; j++) {
                            sceneIds.push(data[i].transitionScenes[j].sceneId);
                        }
                    }
                }
            }

            break;
    }

    sceneIds = unique(sceneIds);

    console.log('check single scene: ', sceneIds.length);

    if (sceneIds.length === 1) {
        return {single: true, pidoco: getSceneById(sceneIds[0]).type === SCENE_PIDOCO};
    }
    return {single: sceneIds.length === 1};
}

function openPrototypeScene(scene, isSingleScene, description, index) {
    var windowSpecs = "location=no,menubar=no,status=no,toolbar=no";
    console.log('open prototype window', scene, isSingleScene, prototypeWindow);

    var currentPhase = getCurrentPhase();
    if (scene !== null) {
        if (prototypeWindow && !prototypeWindow.closed && !isSingleScene) {
            console.log('has prototype window');
            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: scene}, 'https://gesturenote.de');
        } else if (!prototypeWindow && !isSingleScene) {
            console.log('has no prototype window, no single scene');
            prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + currentPhase.id + "&type=" + currentPhase.format, "_blank", windowSpecs);
        } else if (!prototypeWindow && isSingleScene === true && (scene.type === SCENE_WEB || scene.type === SCENE_PIDOCO)) {
            console.log('has no prototype window, single scene, ', scene.type);
            prototypeWindow = window.open(scene.parameters.url, "_blank", windowSpecs);
        } else if (prototypeWindow && isSingleScene) {
            // do nothing
        } else {
            console.log('else');
            prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + currentPhase.id + "&type=" + currentPhase.format, "_blank", windowSpecs);
        }
    } else {
        if (prototypeWindow) {
            console.log('no scene, but prototype window');
            prototypeWindow.postMessage({message: MESSAGE_RENDER_SCENE, scene: scene}, 'https://gesturenote.de');
        } else {
            console.log('no scene, else');
            prototypeWindow = window.open("study-execution-prototype-sharing.php?phaseId=" + currentPhase.id + "&type=" + currentPhase.format, "_blank", windowSpecs);
        }
    }

    if (!previewModeEnabled && peerConnection) {
        peerConnection.sendMessage(MESSAGE_RENDER_SCENE, {description: description, index: index});
    }
}


function getWOZTransitionItem(source, transitionScene, disabled, active) {
    var scene = getSceneById(transitionScene.sceneId);
    var btn = $(source).find('#wozItemWithScenesButton').clone().removeAttr('id');
    $(btn).find('.btn-text').text(scene.title);
    $(btn).find('.btn-trigger-scene').attr('id', scene.id);
    $(btn).find('.btn-trigger-scene').attr('data-transition-scene-id', scene.id);
    $(btn).find('.btn-trigger-scene').attr('data-transition-mode', transitionScene.transitionMode);
    $(btn).find('.btn-trigger-scene').attr('data-transition-type', 'scene');
    $(btn).find('.btn-trigger-scene #scene-' + scene.type).removeClass('hidden');

    if (transitionScene.transitionMode === 'automatically') {
        $(btn).find('.btn-trigger-scene').attr('data-transition-time', transitionScene.transitionTime);
        $(btn).find('.btn-trigger-scene').find('.transition-time').text(transitionScene.transitionTime + 's');
    }

    if (disabled === false) {
        $(btn).find('.btn-trigger-scene').removeClass('disabled');
    }

    if (active === true) {
        $(btn).find('.btn-trigger-scene').addClass('btn-primary');
    }

    return btn;
}

function getWOZTransitionFeedbackItem(source, feedback, transitionMode, time, disabled, active) {
    var btn = $(source).find('#wozFeedbackItemButton').clone().removeAttr('id');
    $(btn).find('.btn-text').text(feedback.title);
    $(btn).find('.btn-trigger-feedback').attr('id', feedback.id);
    $(btn).find('.btn-trigger-feedback').attr('data-transition-mode', transitionMode);
    $(btn).find('.btn-trigger-feedback').attr('data-transition-type', 'feedback');
    $(btn).find('.btn-trigger-feedback #feedback-' + feedback.type).removeClass('hidden');
    if (transitionMode === 'automatically') {
        $(btn).find('.btn-trigger-feedback').attr('data-transition-time', time);
        $(btn).find('.btn-trigger-feedback').find('.transition-time').text(time + 's');
    }

    if (disabled === false) {
        $(btn).find('.btn-trigger-feedback').removeClass('disabled');
    }

    if (active === true) {
        $(btn).find('.btn-trigger-feedback').addClass('btn-primary');
    }

    return btn;
}

//function initObserverAnnotationHandling() {
//    if (!previewModeEnabled && peerConnection && peerConnection.isObserverConnected()) {
//        $(peerConnection).unbind(MESSAGE_OBSERVER_ANNOTATION).bind(MESSAGE_OBSERVER_ANNOTATION, function (event, payload) {
//            event.preventDefault();
//            var currentPhase = getCurrentPhase();
//            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
//            tempData.annotations.push({id: tempData.annotations.length, action: ACTION_OBSERVER_ANNOTATION, annotationId: payload.annotationColor, time: payload.timestamp});
//            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
//        });
//    }
//}