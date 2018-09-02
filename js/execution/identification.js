Identification.prototype.options = null;

function Identification(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

Identification.prototype.renderModeratorView = function () {
    console.log('render moderator view:', IDENTIFICATION.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    removeLocalItem(ELICITED_GESTURES);
    $(container).find('#general .headline').text(getCurrentPhase().title);
    $(container).find('#general #description').text(data.description);
    if (data.identificationFor === 'gestures') {
        $(container).find('#search-gestures').removeClass('hidden');
    } else {
        $(container).find('#search-trigger').removeClass('hidden');
    }

    if (data.identification.length === 0) {
        return false;
    }

    if (!previewModeEnabled) {
        var currentPhase = getCurrentPhase();
        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
        tempData.annotations = [];
        if (data.identificationFor === 'gestures') {
            tempData.gestures = [];
        } else if (data.identificationFor === 'trigger') {
            tempData.trigger = [];
        }
        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
    }

    // slideshow section
    renderIdentification(source, container, data);

    // observation section
    renderObservations(data, container);
    return container;

    function renderIdentification(source, container, data) {
        gestureRecorder = null;

        renderIdentificationItem(source, container, data);
        function renderIdentificationItem(source, container, data) {
            $(container).find('#slides .headline').text(translation.formats.identification.text + " " + (currentIdentificationIndex + 1) + " " + translation.of + " " + data.identification.length);
            if (data.identification && data.identification.length > 0) {
                var item = $(source).find('#identificationItem-' + data.identificationFor).clone().removeAttr('id');
                $(container).find('#identificationContainer').empty().append(item);
                if (data.identificationFor === 'gestures') {
                    renderIdentificationForGesturesItem(item, container, data);
                } else {
                    renderIdentificationForTriggerItem(item, container, data);
                }
            }

            $(item).find('#btn-done').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    currentPhaseStepDone = true;
                    $(this).addClass('hidden');

                    $(container).find('#slides').addClass('hidden');
                    $(container).find('#identified-gesture, #identified-trigger').addClass('hidden');
                    wobble([container.find('#general')]);
                    $(document).scrollTop(0);

                    if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 0) {
                        $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
                    } else {
                        if (peerConnection) {
                            peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                        }
                        nextStep();
                    }
                } else if (!identificationStartTriggered) {
                    wobble([container.find('#slides')]);
                }
            });
        }

        if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 0) {
            if (screenSharingStopped) {
                $(container).find('#slides').addClass('hidden');
                $(container).find('#identified-gesture, #identified-trigger').addClass('hidden');
                $(container).find('#btn-open-prototype').remove();
                $(container).find('#btn-start-screen-sharing').addClass('hidden');
                $(container).find('#btn-stop-screen-sharing').addClass('hidden');
                $(container).find('#btn-done-identification').removeClass('hidden');
            } else if (currentPhaseStepDone) {
                $(container).find('#slides').addClass('hidden');
                $(container).find('#identified-gesture, #identified-trigger').addClass('hidden');
                $(container).find('#btn-open-prototype').remove();
                $(container).find('#btn-start-screen-sharing').addClass('hidden');
                $(container).find('#btn-stop-screen-sharing').removeClass('hidden disabled');
            } else if (identificationPrototypeOpened && !identificationStartTriggered) {
                $(container).find('#btn-open-prototype').addClass('hidden');
                $(container).find('#btn-start-screen-sharing').removeClass('hidden');
            } else if (identificationPrototypeOpened && identificationStartTriggered) {
                $(container).find('#btn-open-prototype').remove();
                $(container).find('#btn-start-screen-sharing').addClass('hidden');
                $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
                $(container).find('.btn-trigger-scene, .btn-reset-scene').removeClass('disabled');
            } else if (!identificationStartTriggered && !identificationPrototypeOpened) {
                $(container).find('#btn-open-prototype').removeClass('hidden');
            }
        } else {
            if (!identificationStartTriggered) {
                $(container).find('#btn-start-elicitation').removeClass('hidden');
            }
        }

        function renderGestureRecorder(recordedData) {
            $(container).find('#file-transfer-loader').addClass('hidden');

            if (!previewModeEnabled) {

                $(container).find('#btn-done, #btn-next-trigger').addClass('disabled');
                var gestureRecorderContent = $('#item-container-gesture-recorder').find('#gesture-recorder-without-introductions').clone().removeAttr('id');
                $(gestureRecorderContent).find('#gesture-recorder-nav').remove();
                container.find('#gesture-recorder-container').empty().append(gestureRecorderContent).removeClass('hidden');

                var options = {
                    recorderTarget: gestureRecorderContent,
                    saveGesture: !previewModeEnabled,
                    allowRerecordGesture: false,
                    allowDeletingGesture: false,
                    ownerId: getLocalItem(STUDY).studyOwner,
                    userId: getLocalItem(STUDY).testerId,
                    source: SOURCE_GESTURE_TESTER,
                    context: data.identification[currentIdentificationIndex].context,
                    checkType: true,
                    checkInteractionType: true,
                    startState: GR_STATE_PLAYBACK,
                    usedStates: [GR_STATE_PLAYBACK, GR_STATE_SAVE, GR_STATE_SAVE_SUCCESS, GR_STATE_DELETE_SUCCESS],
                    initRecorders: [],
                    showRecutButton: true
                };

                for (var i = 0; i < recordedData.length; i++) {
                    var tempOptions = recordedData[i];
                    tempOptions.autoplayPlayback = true;
                    tempOptions.autoplaySave = true;
                    tempOptions.autoplaySaveSuccess = true;
                    if (recordedData[i].type === TYPE_RECORD_LEAP) {
                        tempOptions.previewOnly = true;
                    }
                    options.initRecorders.push(tempOptions);
                }

                gestureRecorder = new GestureRecorder(options);

                $(gestureRecorder).unbind(GR_EVENT_SAVE_SUCCESS).bind(GR_EVENT_SAVE_SUCCESS, function (event, gesture) {
                    $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
                    event.preventDefault();

                    var currentPhase = getCurrentPhase();
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    var triggerId = data.identification[currentIdentificationIndex].triggerId;
                    tempData.gestures.push({id: gesture.id, triggerId: triggerId});
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);

                    initRerecordingButton(gestureRecorder, gesture.id);
                });

                initRerecordingButton(gestureRecorder, null);
            } else {
                var dummyImage = document.createElement('img');
                $(dummyImage).attr('src', translation.gestureRecorderDummyURL);
                $(dummyImage).css({maxWidth: '672px', width: '100%'});
                container.find('#gesture-recorder-container').empty().append(dummyImage).removeClass('hidden');
                container.find('#gesture-recorder-container').addClass('text-center');

                $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
                initRerecordingButton();

//                var gestureRecorderPlaceholder = $('#item-container-gesture-recorder').find('#gesture-recorder-without-introductions').clone().removeAttr('id');
//                container.find('#gesture-recorder-container').empty().append(gestureRecorderPlaceholder).removeClass('hidden');
//                container.find('#gesture-recorder-container .gr-playback').removeClass('hidden');
//                $(gestureRecorderPlaceholder).find('#gesture-recorder-nav').remove();
//                renderBodyJoints(gestureRecorderPlaceholder.find('#human-body'));

                appendAlert(container, ALERT_PREVIEW_DUMMY);
            }
        }

        function startGestureRecording() {
            if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 0) {
                $(container).find('#transition-scenes').addClass('hidden');
            }

            getGMT(function (timestamp) {
                var identificationData = data.identification[currentIdentificationIndex];
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_GESTURE_IDENTIFICATION, triggerId: identificationData.triggerId, time: timestamp});
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                peerConnection.sendMessage(MESSAGE_START_RECORDING_GESTURE);
            });
        }

        function initRerecordingButton(gestureRecorder, gestureId) {
            $(container).find('#btn-start-gesture-rerecording').unbind('click').bind('click', function (event) {
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    if (gestureRecorder) {
                        if (gestureId) {
                            $(gestureRecorder).unbind(GR_EVENT_DELETE_SUCCESS).bind(GR_EVENT_DELETE_SUCCESS, function (event, gestureId) {
                                event.preventDefault();
                                console.log('delete success');
                                gestureRecorder.destroy();
                                gestureRecorder = null;

                                var currentPhase = getCurrentPhase();
                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                                var gestures = new Array();
                                for (var i = 0; i < tempData.gestures.length; i++) {
                                    if (parseInt(tempData.gestures[i].id) !== parseInt(gestureId)) {
                                        gestures.push(tempData.gestures[i]);
                                    }
                                }
                                tempData.gestures = gestures;
                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);

                                $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
                                $(container).find('#file-transfer-loader').addClass('hidden');
                                $(container).find('#identified-gesture').addClass('hidden');
                                $(container).find('#gesture-recorder-container').addClass('hidden');
                                $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
                                $(container).find('#btn-next-trigger, #btn-done').addClass('hidden');

                                if (peerConnection) {
                                    startGestureRecording();
                                }
                            });

                            deleteLastRecordedGesture(gestureId);
                        } else {
                            gestureRecorder.destroy();
                            gestureRecorder = null;

                            $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
                            $(container).find('#file-transfer-loader').addClass('hidden');
                            $(container).find('#identified-gesture').addClass('hidden');
                            $(container).find('#gesture-recorder-container').addClass('hidden');
                            $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
                            $(container).find('#btn-next-trigger, #btn-done').addClass('hidden');


                            if (peerConnection) {
                                startGestureRecording();
                            }
                        }
                    } else {
                        removeAlert(container, ALERT_PREVIEW_DUMMY);
                        $(container).find('#btn-done, #btn-next-trigger').removeClass('disabled');
                        $(container).find('#file-transfer-loader').addClass('hidden');
                        $(container).find('#identified-gesture').addClass('hidden');
                        $(container).find('#gesture-recorder-container').addClass('hidden');
                        $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
                        $(container).find('#btn-next-trigger, #btn-done').addClass('hidden');
                        identificationRecordingStartTriggered = true;
                        identificationRecordingStopTriggered = false;

                        if (peerConnection) {
                            startGestureRecording();
                        }
                    }
                } else {
                    $(document).scrollTop(0);
                    wobble([container.find('#general')]);
                }
            });
        }

        function renderSceneTriggerItems(item, container, data) {
            if (data.identification[currentIdentificationIndex] && data.identification[currentIdentificationIndex].transitionScenes) {
                for (var i = 0; i < data.identification[currentIdentificationIndex].transitionScenes.length; i++) {
                    var scene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[i].sceneId);
                    var transitionItem = $(source).find('#transition-scene-item').clone().attr('id', scene.id);
                    var itemData = $(source).find('#interactive-scenes-catalog-thumbnail').clone().removeAttr('id');
                    $(itemData).find('#info-' + scene.type).removeClass('hidden');
                    $(itemData).find('.btn-text').text(scene.title);
                    $(itemData).find('.scene-description').text(data.identification[currentIdentificationIndex].transitionScenes[i].description);
                    $(transitionItem).find('.scene-data').append(itemData);
                    $(item).find('#transition-scenes').append(transitionItem);
                    $(item).find('#transition-scenes').append(document.createElement('br'));
                    if ((currentIdentificationScene > 0 && i === currentIdentificationScene) || (currentIdentificationScene === 0 && i === 0)) {
                        $(transitionItem).find('.btn-trigger-scene').addClass('btn-primary');
                        $(transitionItem).find('.scene-description').removeClass('hidden');
                    }

                    $(itemData).find('.btn-trigger-scene').unbind('click').bind('click', {scene: scene, index: i}, function (event) {
                        if (!$(this).hasClass('btn-primary') && !$(this).hasClass('disabled')) {
                            $(this).closest('.root').find('.btn-trigger-scene').removeClass('btn-primary');
                            $(this).closest('.root').find('.scene-description').addClass('hidden');
                            $(this).addClass('btn-primary');
                            $(this).parent().parent().find('.scene-description').removeClass('hidden');
                            currentIdentificationScene = event.data.index;
                            openPrototypeScene(event.data.scene, data.identification.length === 1 && data.identification[currentIdentificationIndex].transitionScenes.length === 1, data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);

                            if (identificationStartTriggered && !previewModeEnabled) {
                                getGMT(function (timestamp) {
                                    var currentPhase = getCurrentPhase();
                                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                                    var scene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].sceneId);
                                    tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: scene.id});
                                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                                });
                            }
                        }

                        if ($(this).hasClass('disabled')) {
                            $(document).scrollTop(0);
                            wobble(container.find('#general'));
                        }
                    });
                }

                if (currentIdentificationIndex > 0) {
                    $(container).find('.btn-trigger-scene').removeClass('disabled');
                }
            }
        }

        function renderIdentificationForGesturesItem(item, container, data) {
            renderSceneTriggerItems(item, container, data);

            $(container).find('#btn-start-gesture-recording').removeClass('hidden');
            var searchedData = getTriggerById(data.identification[currentIdentificationIndex].triggerId);
            $(item).find('#search-for .address').text(translation.GestureForTrigger + ':');
            $(item).find('#search-for .text').text(searchedData.title);
            $(item).find('.btn-popover-gesture-preview').remove();

            if (!screenSharingStopped && identificationPrototypeOpened && currentIdentificationIndex > 0) {
                $(item).find('#btn-start-gesture-recording').removeClass('disabled');
                var scene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[0].sceneId);
                openPrototypeScene(scene, data.identification.length === 1 && data.identification[currentIdentificationIndex].transitionScenes.length === 1, data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);

                if (currentIdentificationIndex >= data.identification.length - 1) {
                    $(container).find('#btn-next-trigger').remove();
                }

                if (scene && !previewModeEnabled) {
                    getGMT(function (timestamp) {
                        var currentPhase = getCurrentPhase();
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: scene.id});
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    });
                }
            }

            if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 1) {
                $(item).find('#transition-scenes-controls').removeClass('hidden');
            }

            if (identificationStartTriggered) {
                $(container).find('#btn-start-gesture-recording').removeClass('hidden disabled');

                if (data.sensor !== 'none' && !sensorTypeBanned(data.sensor)) {
                    $(container).find('#waiting-for-sensor').removeClass('hidden');
                    $(container).find('#btn-stop-gesture-recording').addClass('hidden');
                    if (identificationSensorInitialized === true) {
                        $(container).find('#btn-start-gesture-recording').removeClass('hidden');
                        $(container).find('#waiting-for-sensor').addClass('hidden');
                    } else {
                        $(container).find('#btn-start-gesture-recording').addClass('hidden');
                    }
                } else if (identificationRecordingStartTriggered === true) {
                    $(container).find('#btn-start-gesture-recording').addClass('hidden');
                    $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
                } else if (identificationRecordingStopTriggered === true) {
                    $(container).find('#btn-start-gesture-recording').addClass('hidden');
                    $(container).find('#btn-start-gesture-rerecording').removeClass('hidden');
                    $(container).find('#btn-stop-gesture-recording').addClass('hidden');
                    $(container).find('#identified-gesture').removeClass('hidden');
                    $(container).find('#file-transfer-loader').addClass('hidden');
                    renderGestureRecorder();
                    initRerecordingButton(null);

                    if (currentIdentificationIndex < data.identification.length - 1) {
                        $(container).find('#btn-next-trigger').removeClass('hidden disabled');
                    } else {
                        $(container).find('#btn-done').removeClass('hidden disabled');
                    }
                }
            }

            $(item).find('#btn-start-gesture-recording').unbind('click').bind('click', function (event) {
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    $(container).find('#identified-gesture').addClass('hidden');
                    $(container).find('#gesture-recorder-container').addClass('hidden');
                    $(container).find('#btn-stop-gesture-recording').removeClass('hidden');
                    $(container).find('#btn-next-trigger').addClass('hidden');
                    identificationRecordingStartTriggered = true;
                    identificationRecordingStopTriggered = false;

                    if (peerConnection) {
                        startGestureRecording();
                    }
                } else {
                    $(document).scrollTop(0);
                    wobble([container.find('#general')]);
                }
            });

            if (data.sensor !== 'none' && !sensorTypeBanned(data.sensor) && peerConnection) {
                $(peerConnection).unbind(MESSAGE_ALL_RECORDER_READY).bind(MESSAGE_ALL_RECORDER_READY, function (event) {
                    event.preventDefault();
                    console.log('all recorder ready');
                    identificationSensorInitialized = true;
                    $(container).find('#btn-start-gesture-recording').removeClass('disabled');
                    $(container).find('#waiting-for-sensor').addClass('hidden');

                    getGMT(function (timestamp) {
                        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_ALL_RECORDER_READY, time: timestamp});
                        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                    });
                });

                $(peerConnection).unbind(MESSAGE_RECORDER_LOST).bind(MESSAGE_RECORDER_LOST, function (event) {
                    event.preventDefault();
                    identificationSensorInitialized = false;
                    $(container).find('#btn-start-gesture-recording').addClass('disabled');
                    $(container).find('#waiting-for-sensor').removeClass('hidden');

                    getGMT(function (timestamp) {
                        var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                        tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RECORDER_LOST, time: timestamp});
                        setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                    });
                });
            }

            $(item).find('#btn-stop-gesture-recording').unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(this).addClass('hidden');
                identificationRecordingStartTriggered = false;
                identificationRecordingStopTriggered = true;

                initRerecordingButton(null);

                if (!previewModeEnabled && peerConnection) {
                    var receivedGestureData = null;
                    var receivedWebcamRecording = null;

                    $(peerConnection).unbind(EVENT_FILE_TRANSFER).bind(EVENT_FILE_TRANSFER, function (event, bytesReceived, size) {
                        event.preventDefault();
                        $(container).find('#identified-gesture').removeClass('hidden');

                        var percent = Math.round(bytesReceived * 100 / size);
                        console.log('transfer video file', bytesReceived, size, percent);
                        $(container).find('#file-transfer-loading-indicator').css({width: percent + "%"});
                        $(container).find('#file-transfer-loader').removeClass('hidden');
                    });

                    $(peerConnection).unbind(EVENT_RECEIVED_FILE).bind(EVENT_RECEIVED_FILE, function (event, file, metadata) {
                        event.preventDefault();
                        console.log('received video file', file, metadata, receivedGestureData);
                        $(container).find('#btn-start-gesture-rerecording').removeClass('hidden');
                        if (currentIdentificationIndex < data.identification.length - 1) {
                            $(container).find('#btn-next-trigger').removeClass('hidden');
                        } else {
                            $(container).find('#btn-done').removeClass('hidden');
                        }
//                        $(container).find('#file-transfer-loading-indicator').css({width: "100%"});
                        $(container).find('#file-transfer-loader').addClass('hidden');

                        if (metadata.size > 0) {
                            receivedWebcamRecording = file;
                            if (receivedWebcamRecording && receivedGestureData) {
                                renderGestureRecorder(getGestureRecodingData());
                            }
                        } else {
                            // error handling
                        }
                    });

                    $(peerConnection).unbind(MESSAGE_GESTURE_DATA).bind(MESSAGE_GESTURE_DATA, function (event, payload) {
                        event.preventDefault();
                        console.log('gesture data received: ', receivedWebcamRecording, payload);
                        receivedGestureData = payload;
                        if (receivedWebcamRecording && receivedGestureData) {
                            renderGestureRecorder(getGestureRecodingData());
                        }
                    });

                    $(container).find('#file-transfer-loading-indicator').css({width: "0%"});
                    $(container).find('#identified-gesture').removeClass('hidden');
                    $(container).find('#file-transfer-loader').removeClass('hidden');
                    peerConnection.sendMessage(MESSAGE_STOP_RECORDING_GESTURE);


                    function getGestureRecodingData() {
                        for (var i = 0; i < receivedGestureData.length; i++) {
                            if (receivedGestureData[i].type === TYPE_RECORD_WEBCAM) {
                                receivedGestureData[i].data = receivedWebcamRecording;
                                break;
                            }
                        }
                        return receivedGestureData;
                    }
                } else {
                    $(container).find('#file-transfer-loader').removeClass('hidden');
                    $(container).find('#identified-gesture').removeClass('hidden');
                    $(container).find('#file-transfer-loading-indicator').css({width: "0%"});
                    TweenMax.to($(container).find('#file-transfer-loading-indicator'), 2, {width: "100%", ease: Linear.easeNone, onComplete: function () {
                            renderGestureRecorder();
                            initRerecordingButton(null);
                            $(container).find('#file-transfer-loader').addClass('hidden');
                            $(container).find('#btn-start-gesture-rerecording').removeClass('hidden');
                            if (currentIdentificationIndex < data.identification.length - 1) {
                                $(container).find('#btn-next-trigger').removeClass('hidden disabled');
                            } else {
                                $(container).find('#btn-done').removeClass('hidden disabled');
                            }
                        }});
                }
            });

            $(item).find('#btn-next-trigger').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    removeAlert(container, ALERT_PREVIEW_DUMMY);
                    $(container).find('#identified-gesture').addClass('hidden');
                    identificationRecordingStopTriggered = false;
                    currentIdentificationIndex++;
                    currentIdentificationScene = 0;
                    resetRecorder();
                    renderIdentificationItem(source, container, data);
                    if (peerConnection) {
                        peerConnection.sendMessage(MESSAGE_START_IDENTIFICATION);
                    }
                } else if (!identificationStartTriggered) {
                    wobble([container.find('#general')]);
                    $(document).scrollTop(0);
                }
            });
        }

        function startTriggerRecording() {
            getGMT(function (timestamp) {
                var identificationData = data.identification[currentIdentificationIndex];
                var tempData = getLocalItem(getCurrentPhase().id + '.tempSaveData');
                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_TRIGGER_IDENTIFICATION, gestureId: identificationData.gestureId, time: timestamp});
                setLocalItem(getCurrentPhase().id + '.tempSaveData', tempData);
                peerConnection.sendMessage(MESSAGE_REQUEST_TRIGGER, {currentIdentificationIndex: currentIdentificationIndex});
            });
        }

        function renderIdentificationForTriggerItem(item, container, data) {
            renderSceneTriggerItems(item, container, data);

            var searchedData = getGestureById(data.identification[currentIdentificationIndex].gestureId);
            $(item).find('#search-for .address').text(translation.TriggerForGesture + ':');
            $(item).find('#search-for .text').text(searchedData.title);
            item.find('.btn-popover-gesture-preview').attr('name', searchedData.id);

            if (!screenSharingStopped && identificationPrototypeOpened && currentIdentificationIndex > 0) {
                var scene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[0].sceneId);
                openPrototypeScene(scene, data.identification.length === 1 && data.identification[currentIdentificationIndex].transitionScenes.length === 1, data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);

                if (currentIdentificationIndex >= data.identification.length - 1) {
                    $(container).find('#btn-next-trigger').remove();
                }
            }

            if (identificationStartTriggered) {
                $(container).find('.btn-trigger-scene, .btn-reset-scene, #btn-request-trigger').removeClass('disabled');
            }

            $(item).find('#btn-request-trigger').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('hidden');
                    $(container).find('#identified-trigger').removeClass('hidden');
                    appendAlert($(container).find('#identified-trigger'), ALERT_WAITING_FOR_TESTER);
                    identificationTriggerRequest = true;
                    console.log('request trigger', currentIdentificationIndex);
                    if (peerConnection) {
                        startTriggerRecording();
                    }
                } else if (!identificationStartTriggered) {
                    wobble([$(container).find('#general')]);
                    $(document).scrollTop(0);
                }
            });

            if (identificationTriggerRequest) {
                identificationTriggerRequest = false;
                clearAlerts($(container).find('#identified-trigger'));
                $(container).find('#identified-trigger').removeClass('hidden');
                $(item).find('#btn-request-trigger').addClass('hidden');
                renderQuestionnaireAnswers($(container).find('#identified-trigger'), currentQuestionnaireAnswers.data, currentQuestionnaireAnswers.answers, false);

                if (currentIdentificationIndex < data.identification.length - 1) {
                    $(container).find('#btn-next-trigger').removeClass('hidden disabled');
                } else {
                    $(container).find('#btn-done').removeClass('hidden disabled');
                }
            }

            if (peerConnection) {
                $(peerConnection).unbind(MESSAGE_RESPONSE_TRIGGER).bind(MESSAGE_RESPONSE_TRIGGER, function (event, payload) {
                    event.preventDefault();
                    clearAlerts($(container).find('#identified-trigger'));
                    currentQuestionnaireAnswers = payload.answers;
                    console.log(payload.answers);
                    renderQuestionnaireAnswers($(container).find('#identified-trigger'), payload.data, payload.answers, false);

                    if (payload.saveAnswers === true) {
                        if (currentIdentificationIndex < data.identification.length - 1) {
                            $(container).find('#btn-next-trigger').removeClass('hidden disabled');
                        } else {
                            $(container).find('#btn-done').removeClass('hidden disabled');
                        }

                        var currentPhase = getCurrentPhase();
                        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                        tempData.trigger.push({gestureId: payload.gestureId, preferredTrigger: payload.answers});
                        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                    }
                });
            }

            $(item).find('#btn-next-trigger').unbind('click').bind('click', function (event) {
                event.preventDefault();
                $(this).addClass('hidden');
                $(container).find('#identified-trigger').addClass('hidden');
                $(container).find('#identified-trigger .question-container').empty();
                currentQuestionnaireAnswers = null;
                currentIdentificationIndex++;
                currentIdentificationScene = 0;
                identificationTriggerRequest = false;
                renderIdentificationItem(source, container, data);

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_START_IDENTIFICATION);
                }
            });
        }

        $(container).find('#btn-start-elicitation').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(this).remove();
            enableControls();
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_START_IDENTIFICATION);
            }
        });

        $(container).find('#btn-open-prototype').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var currentScene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].sceneId);
            if (currentScene) {
                identificationPrototypeOpened = true;
                $(this).remove();
                $(container).find('#btn-start-screen-sharing').removeClass('hidden');
                openPrototypeScene(currentScene, data.identification.length === 1 && data.identification[currentIdentificationIndex].transitionScenes.length === 1, data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].description);
            }
        });

        $(container).find('#btn-start-screen-sharing').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                var button = $(this);
                lockButton(button, true);

                if (!previewModeEnabled) {
                    $(container).find('#btn-start-screen-sharing').find('.fa-spin').removeClass('hidden');
                    peerConnection.shareScreen(function (error) {
                        unlockButton(button, true);
                        console.error('Maybe check installed extension, ERROR: ' + error);
                    }, function () {
                        peerConnection.startScreenRecording();
                        $(peerConnection).unbind(MESSAGE_SCREEN_SHARING_ESTABLISHED).bind(MESSAGE_SCREEN_SHARING_ESTABLISHED, function (event) {
                            event.preventDefault();
                            unlockButton(button, true);
                            enableControls();
                        });
                        peerConnection.sendMessage(MESSAGE_START_IDENTIFICATION);

                        var currentScene = getSceneById(data.identification[currentIdentificationIndex].transitionScenes[currentIdentificationScene].sceneId);
                        if (currentScene) {
                            getGMT(function (timestamp) {
                                var currentPhase = getCurrentPhase();
                                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_RENDER_SCENE, time: timestamp, scene: currentScene.id});
                                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                            });
                        }
                    });
                } else {
                    enableControls();
                }
            }
        });

        function enableControls() {
            identificationStartTriggered = true;
            wobble([container.find('#slides')]);
            $(container).find('.btn-trigger-scene, .btn-reset-scene, #btn-request-trigger').removeClass('disabled');

            if (data.sensor !== 'none' && !sensorTypeBanned(data.sensor)) {
                if (identificationSensorInitialized === true) {
                    $(container).find('#waiting-for-sensor').addClass('hidden');
                    $(container).find('#btn-start-screen-sharing').removeClass('hidden');
                    $(container).find('#btn-stop-screen-sharing').addClass('hidden');
                } else  {
                    $(container).find('#waiting-for-sensor').removeClass('hidden');
                    $(container).find('#btn-start-screen-sharing').addClass('hidden');
                    $(container).find('#btn-stop-screen-sharing').addClass('hidden');
                }
            } else {
                $(container).find('#btn-start-gesture-recording').removeClass('disabled');
            }

            if (data.identification[currentIdentificationIndex].transitionScenes && data.identification[currentIdentificationIndex].transitionScenes.length > 0) {
                $(container).find('#btn-start-screen-sharing').addClass('hidden');
                $(container).find('#btn-stop-screen-sharing').removeClass('hidden');
            }
        }

        $(container).find('#btn-stop-screen-sharing').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                screenSharingStopped = true;
                $(this).addClass('hidden');
                $(container).find('#btn-done-identification').removeClass('hidden');
                if (peerConnection) {
                    peerConnection.stopShareScreen(true);
                    peerConnection.sendMessage(MESSAGE_STOP_SCREEN_SHARING);
                }
                identificationPrototypeOpened = false;
                identificationStartTriggered = false;
                if (prototypeWindow) {
                    prototypeWindow.close();
                    prototypeWindow = null;
                }
            } else {
                if (identificationStartTriggered) {
                    wobble($(container).find('#slides'));
                } else {
                    $(document).scrollTop(0);
                    wobble(container.find('#general'));
                }
            }
        });

        $(container).find('#btn-done-identification').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                }
                nextStep();
            }
        });
    }
};



/*
 * tester view rendering
 */

Identification.prototype.renderTesterView = function () {
    console.log('render tester view:', IDENTIFICATION.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');



    return container;
};