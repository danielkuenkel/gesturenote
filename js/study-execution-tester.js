/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var singleGUSGesture = null;
var screenSharingTester = null;
var Tester = {
    renderView: function renderView() {

        if (syncPhaseStep) {
            appendAlert($('#viewTester'), ALERT_GENERAL_PLEASE_WAIT);
            Tester.initializePeerConnection();
            Tester.initializeRTC();
        } else {
            console.log('render view');
            var item = null;
            var currentPhase = getCurrentPhase();
            var currentPhaseData = getCurrentPhaseData();

            // save start time
            if (previewModeEnabled === false) {
                setLocalItem(currentPhase.id + '.tempSaveData', {});
                getGMT(function (timestamp) {
                    var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                    tempData.startTime = timestamp;
                    setLocalItem(currentPhase.id + '.tempSaveData', tempData);
                });
            }

//            Tester.initializePeerConnection();
            if (currentPhaseData || (currentPhaseData && $.isArray(currentPhaseData) && currentPhaseData.length > 0)) {

                switch (currentPhase.format) {
                    case LETTER_OF_ACCEPTANCE:
                        currentClass = new LetterOfAcceptance();
                        break;
                    case THANKS:
                        currentClass = new Thanks();
                        break;
                    case QUESTIONNAIRE:
                        currentClass = new Questionnaire({isPreview: false, append: true});
                        break;
                    case UEQ:
                        currentClass = new UserExperienceQuestionnaire();
                        break;
                    case INTERVIEW:
                        currentClass = new Interview();
                        break;
                    case IDENTIFICATION:
                        currentClass = new Identification();
                        item = currentClass.renderTesterView();
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
                    case GESTURE_TRAINING:
                        currentClass = new GestureTraining();
                        break;
                    case SLIDESHOW_GESTURES:
                        currentClass = new GestureSlideshow();
                        break;
                    case SLIDESHOW_TRIGGER:
                        currentClass = new TriggerSlideshow();
                        break;
                    case SCENARIO:
                        currentClass = new UserTest();
                        break;
                    case PHYSICAL_STRESS_TEST:
                        currentClass = new PhysicalStressTest();
                        break;
                    case EXPLORATION:
                        currentClass = new Exploration();
                        break;
                }
                item = currentClass.renderTesterView();

                if (item !== false || item !== null) {
                    if (!syncPhaseStep) {
                        $('#viewTester #phase-content').empty().append(item);
                    }
                } else {
                    Tester.renderNoDataView();
                }

                if (currentPhase.format === THANKS) {
                    $('.btn-cancel').addClass('disabled');
                } else {
                    $('.btn-cancel').removeClass('disabled');
                }
            } else {
                Tester.renderNoDataView();
            }

            Tester.initializeRTC();

            $('#viewTester #phase-content').css({y: 0, opacity: 1});
            TweenMax.from($('#viewTester #phase-content'), .2, {delay: 0, y: -20, opacity: 0, clearProps: 'all'});
            if ($(document).scrollTop() > 0) {
                $(document).scrollTop(0);
            }
        }
    },
    renderNoDataView: function renderNoDataView() {
        var alert = $(getSourceContainer(currentView)).find('#no-phase-data').clone().removeAttr('id');
        $('#viewTester #phase-content').append(alert);
        appendAlert(alert, ALERT_NO_PHASE_DATA);
    },
    initializePeerConnection: function initializePeerConnection() {
        if (!peerConnection && !previewModeEnabled && isWebRTCNeededInFuture()) {
            peerConnection = new PeerConnection(true);
            if (getLocalItem(STUDY).surveyType === TYPE_SURVEY_MODERATED) {
                $(peerConnection).unbind(MESSAGE_NEXT_STEP).bind(MESSAGE_NEXT_STEP, function (event, payload) {
                    console.log('next step received');
                    nextStep();
                });

                $(peerConnection).unbind(MESSAGE_CANCEL_SURVEY).bind(MESSAGE_CANCEL_SURVEY, function (event, payload) {
//                    console.log('on cancel survey');
                    var study = getLocalItem(STUDY);
                    study.aborted = 'yes';
                    setLocalItem(STUDY, study);
                    saveCurrentStatus(false);
                    peerConnection.stopRecording(function () {
                        currentPhaseStepIndex = getThanksStepIndex();
                        renderPhaseStep();
                        updateProgress();
                    }, true);
                });

//                $(peerConnection).unbind(MESSAGE_REQUEST_SYNC).bind(MESSAGE_REQUEST_SYNC, function (event, payload) {
//                    console.log('on sync request');
//                    peerConnection.sendMessage(MESSAGE_SYNC_PHASE_STEP, {index: currentPhaseStepIndex});
//                    if (getCurrentPhase().format !== THANKS) {
//                        console.log('render phase step: ' + currentPhaseStepIndex);
//                        peerConnection.stopRecording(function () {
//                            resetConstraints();
//                            renderPhaseStep();
//                        }, false);
//                    }
//
//                    $('#custom-modal').find('.modal-content').empty();
//                    $('#custom-modal').modal('hide');
//                });

//                $(peerConnection).unbind(MESSAGE_SYNC_PHASE_STEP).bind(MESSAGE_SYNC_PHASE_STEP, function (event, payload) {
//                    console.log('on sync phase step', payload.index);
//                    syncPhaseStep = false;
//                    currentPhaseStepIndex = payload.index;
//                    renderPhaseStep();
//                    updateProgress();
//                });

                $(peerConnection).unbind(MESSAGE_REQUEST_SYNC).bind(MESSAGE_REQUEST_SYNC, function (event, payload) {
//                    console.log('REQUEST SYNC', payload);
                    event.preventDefault();
                    currentPhaseStepIndex = payload.index;
//                    console.log('CURRENT PHASE STEP INDEX', currentPhaseStepIndex)

                    setTimeout(function () {
//                        console.log('CONNECTION:', peerConnection);
                        peerConnection.sendMessage(MESSAGE_SYNC_REQUEST, {nick: VIEW_TESTER});
                    }, 500);

                });

                $(peerConnection).unbind(MESSAGE_SYNC_RESPONSE).bind(MESSAGE_SYNC_RESPONSE, function (event, payload) {
                    event.preventDefault();
                    if (payload && payload.nick === VIEW_TESTER) {
//                        console.log('SYNC RESPONSE', payload);
                        syncPhaseStep = false;
                        currentPhaseStepIndex = payload.index;
                        renderPhaseStep();
                        updateProgress();

                        removeAlert($('#viewTester'), ALERT_GENERAL_PLEASE_WAIT);
                        if (getCurrentPhase().format !== THANKS) {
                            $('#viewTester').find('#phase-content').removeClass('hidden');
                            $('#viewTester').find('#pinnedRTC').css({opacity: 1});
                        }
                        resetRTC();
                    }
                });

//                $(peerConnection).unbind('videoAdded').bind('videoAdded', function (event, video) {
//                    event.preventDefault();
////                    if (syncPhaseStep) {
////                        peerConnection.sendMessage(MESSAGE_REQUEST_SYNC, {index: currentPhaseStepIndex});
////
////                    }
//
////                    resetRTC();
////                    peerConnection.takeSnapshot(true);
//                });

                $(peerConnection).unbind('joinedRoom').bind('joinedRoom', function () {
                    peerConnection.sendMessage(MESSAGE_SYNC_REQUEST, {nick: VIEW_TESTER});

                    setTimeout(function () {
                        peerConnection.takeSnapshot(true);
                    }, 5000);
                });

                $(peerConnection).unbind('videoRemoved').bind('videoRemoved', function (event, video, peer) {
                    event.preventDefault();
                    console.log('videoRemoved');
                    removeAlert($('#viewTester'), ALERT_GENERAL_PLEASE_WAIT);
                    if (peer.nick === VIEW_MODERATOR) {
                        syncPhaseStep = true;
                        
                        peerConnection.stopRecording(function () {
                            resetConstraints();
                        }, false);

                        if (getCurrentPhase().format !== THANKS) {
                            appendAlert($('#viewTester'), ALERT_GENERAL_PLEASE_WAIT);
                            $('#viewTester').find('#phase-content').addClass('hidden');
                            $('#viewTester').find('#pinnedRTC').css({opacity: 0});
                        }
                    }
                });

//                $(peerConnection).unbind(CONNECTION_STATE_CONNECTED).bind(CONNECTION_STATE_CONNECTED, function () {
//                    console.log('connected');
//                    removeAlert($('#viewTester'), ALERT_GENERAL_PLEASE_WAIT);
//                    if (getCurrentPhase().format !== THANKS) {
//                        $('#viewTester').find('#phase-content').removeClass('hidden');
//                        $('#viewTester').find('#pinnedRTC').css({opacity: 1});
//                    }
//                    resetRTC();
//                });
//
//                $(peerConnection).unbind(CONNECTION_STATE_DISCONNECTED).bind(CONNECTION_STATE_DISCONNECTED, function () {
//                    console.log('disconnected');
//                    removeAlert($('#viewTester'), ALERT_GENERAL_PLEASE_WAIT);
//                    if (getCurrentPhase().format !== THANKS) {
//                        appendAlert($('#viewTester'), ALERT_GENERAL_PLEASE_WAIT);
//                        $('#viewTester').find('#phase-content').addClass('hidden');
//                        $('#viewTester').find('#pinnedRTC').css({opacity: 0});
//                    }
//                });
            } else {
                clearAlerts($('#viewTester'));
                $('#viewTester').find('#phase-content').removeClass('hidden');
                $('#viewTester').find('#pinnedRTC').css({opacity: 1});
                updateRTCHeight($('#viewTester #column-left').width());
            }
        }
    },
    initializeRTC: function initializeRTC() {
        // check preview or live mode, and check if webRTC is needed
        initPopover();
        $('#animatableRTC').addClass('hidden');
        if (isWebRTCNeededInFuture()) {
            if (previewModeEnabled === true) {
                Tester.appendRTCPreviewStream();
            } else {
                Tester.appendRTCLiveStream();
            }
        } else {
//            resetLiveStream();
        }

//        updateRTCHeight($('#viewTester #column-left').width(), true);
    },
    appendRTCPreviewStream: function appendRTCPreviewStream() {
//        var currentPhase = getCurrentPhase();
//        var source = getSourceContainer(currentView);
//        var target = $('#viewTester').find('#column-left');
//        switch (currentPhase.format) {
//            case SCENARIO:
//            case IDENTIFICATION:
//            case EXPLORATION:
////            case GESTURE_TRAINING:
//                target = $(container).find('#fixed-rtc-preview');
//                $(target).find('#video-caller').css({width: '100%', height: 'auto'});
//                break;
//            default:
//                pinRTC();
//                break;
//        }
//        console.log('appendRTCPreviewStream', target);
//        $(target).empty().append($(source).find('#tester-web-rtc-placeholder').clone().removeAttr('id'));
//        var source = getSourceContainer(currentView);
//        var target = $('#viewTester').find('#fixedRTC');
//        $(target).empty().prepend($(source).find('#tester-web-rtc-placeholder').clone().attr('id', 'web-rtc-placeholder'));

        var source = getSourceContainer(currentView);
        var target = $('#viewTester').find('.pinnedRTC');
        var callerElement = $(source).find('#tester-web-rtc-placeholder').clone().attr('id', 'web-rtc-placeholder');
        $(target).empty().prepend(callerElement);
        pinRTC();
        updateRTCHeight($('#viewTester #column-left').width(), true);

        var currentPhase = getCurrentPhase();
        var options = getPhaseStepOptions(currentPhase.format);
//        console.log(options);
        if (options.tester.recordStream === 'yes') {
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
        var target = $('#viewTester').find('#pinnedRTC');
        var updateRTCHeightBool = false;
//        switch (currentPhase.format) {
//            case SCENARIO:
//            case IDENTIFICATION:
//            case EXPLORATION:
//            case GESTURE_TRAINING:
//            case INTERVIEW:
//                target = $('#viewTester').find('#fixed-rtc-preview');
//                console.log('set fixed width for fixed rtc', target,$(target).find('#video-caller'));
//                break;
//            default:
        pinRTC();
        updateRTCHeightBool = true;
        updateRTCHeight($('#viewTester #column-left').width());
//                break;
//        }

        console.log('append rtc live stream', target, iceTransports);
        var options = getPhaseStepOptions(currentPhase.format);
        console.log(options, currentPhase.format);
        var query = getQueryParams(document.location.search);
        var mainElement = $('#video-caller');
        var callerOptions = {
            target: target,
            callerElement: mainElement,
            localVideoElement: 'local-stream',
            remoteVideoElement: 'remote-stream',
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
            nick: 'tester',
            ignoreRole: 'no',
            selectedRole: 'tester',
            visibleRoles: ['moderator', 'tester'],
            localStream: {audio: options.tester.audio, video: options.tester.video, visualize: options.tester.visualizeStream, record: options.tester.recordStream},
            remoteStream: {audio: options.moderator.audio, video: options.moderator.video}
        };
        if (callerOptions.localStream.video === 'yes' || callerOptions.remoteStream.video === 'yes') {
            $(callerOptions.target).prepend(callerOptions.callerElement);
            if (updateRTCHeightBool) {
                updateRTCHeight($('#viewTester #column-left').width());
            } else {
                $(target).find('#video-caller').css({width: '100%', height: 'auto'});
            }
        } else {
            console.log('dont add video-caller');
        }

        peerConnection.update(callerOptions);
        Tester.keepStreamsPlaying(callerOptions.callerElement);
    },
    keepStreamsPlaying: function keepStreamsPlaying(element) {
        if (peerConnection.status !== STATUS_UNINITIALIZED) {
            var videos = $(element).find('video');
            for (var i = 0; i < videos.length; i++) {
//                if (videos[i].paused) {
                videos[i].play();
//                }
            }
        }
    }
};

function initScreenSharing(container) {
    if (!previewModeEnabled && peerConnection) {
        $(peerConnection).unbind(MESSAGE_SHARED_SCREEN_ADDED).bind(MESSAGE_SHARED_SCREEN_ADDED, function (event, video) {
            console.log('on add shared screen', video);

            $(container).empty().append(video);
            var newHeight = $(window).height() - 70 - 15;
            $(container).css({height: newHeight + "px"});
            $(video).css({height: '100%', width: '100%', objectFit: 'contain'});
            $(video).removeAttr('controls');
            $(video).removeAttr('id');
            $(window).on('resize', function () {
                var newHeight = $(window).height() - 70 - 15;
                console.log('resize:', newHeight);
                $(container).css({height: newHeight + "px"});
            }).resize();

            peerConnection.sendMessage(MESSAGE_SCREEN_SHARING_ESTABLISHED);
            Tester.keepStreamsPlaying($('#video-caller'));
            Tester.keepStreamsPlaying(container);
            $(container).trigger('sharedScreenAdded');
        });
    }
}

function checkRTCUploadStatus(container) {
    if (isUploadRecordingNeeded() && uploadQueue && !uploadQueue.allFilesUploaded() && uploadQueue.uploadPending() === true) {
        console.log('sumbmit final data with upload queue, some files where not uploaded yet!');
        submitFinalData(container, false);
//        $(uploadQueue).unbind(EVENT_ALL_FILES_UPLOADED).bind(EVENT_ALL_FILES_UPLOADED, function () {
//            console.log('Tester: all videos uploaded -> submit final data');
//            $(uploadQueue).unbind(EVENT_ALL_FILES_UPLOADED);
//            submitFinalData(container, true);
//        });
    } else {
        console.log('sumbmit final data without upload queue, or all files where uploaded.');
        submitFinalData(container, true);
    }
}

function submitFinalData(container, areAllRTCsUploaded) {
    $(container).find('#upload-instructions').removeClass('hidden');
    $(container).find('#upload-done, #study-share, #upload-retry, #btn-execution-done').addClass('hidden');
    if (!areAllRTCsUploaded) {
        $(container).find('#rtc-uploads').addClass('hidden');
    } else {
        $(container).find('#rtc-uploads').removeClass('hidden');
    }

    saveCurrentStatus(areAllRTCsUploaded, function (result) {
        if (result.status === RESULT_SUCCESS) {
            if (areAllRTCsUploaded) {
                $(container).find('#upload-instructions').addClass('hidden');
                $(container).find('#upload-done, #study-share, #btn-execution-done').removeClass('hidden');
            } else {
                $(container).find('#rtc-uploads').removeClass('hidden');
            }
        } else {
            $(container).find('#upload-instructions').addClass('hidden');
            $(container).find('#upload-retry').removeClass('hidden');
        }
    });
}

function renderSceneItem(source, container, sceneId) {
    container.find('#scene-container').empty();
    console.log('render scene Item for id', sceneId);

    if (!isNaN(sceneId) && (sceneId !== 'none' || sceneId !== null)) {
        $(container).find('#btn-refresh-scene').removeClass('hidden');
        var scene = getSceneById(sceneId);
        var sceneItem = $(source).find('#' + scene.type).clone().removeAttr('id');
        container.find('#scene-container').empty().append(sceneItem);
        container.find('#scene-container').css({backgroundColor: "rgb(255,255,255)"});

        switch (scene.type) {
            case SCENE_WEB:
                sceneItem.attr('src', scene.parameters.url);
                break;
            case SCENE_IMAGE:
                sceneItem[0].onload = function () {
                    var image = sceneItem[0];
                    var colorThief = new ColorThief();
                    var dominantColor = colorThief.getColor(image);
                    container.find('#scene-container').css("backgroundColor", "rgb(" + dominantColor[0] + "," + dominantColor[1] + "," + dominantColor[2] + ")");
                };
                sceneItem[0].src = scene.parameters.url;
                break;
            case SCENE_PIDOCO:
                sceneItem[0].src = scene.parameters.url;
                break;
            case SCENE_VIDEO_EMBED:
                sceneItem.find('.videoContainer').addClass(scene.parameters.ratio === 'ratio_16_9' ? 'embed-responsive-16by9' : 'embed-responsive-4by3');
                sceneItem.find('.videoContainer').html(scene.parameters.url);
                var video = $(sceneItem).find('iframe');
                var src = video.attr('src');
                video.attr('src', src + "?autoplay=1");
                $(video).addClass('embed-responsive-item');
                container.find('#scene-container').css("backgroundColor", "rgb(0,0,0)");
                break;
        }

        // scene positioning
        // calcuation of the new window height if resizing the window
        $(window).resize(function () {
//            if (!event.handled) {
//                event.handled = true;
            console.log($(container).find('#scene-container').offset());
            var height = $(window).height() - 124 - 15;

            if (scene.type === SCENE_VIDEO_EMBED) {
                var width;
                if (scene.parameters.ratio === 'ratio_16_9') {
                    width = height / 9 * 16;
                } else {
                    width = height / 3 * 4;
                }
                width = Math.min($(window).width(), width);
                sceneItem.width(width);
            }

            sceneItem.height(height);
//            }

        }).resize();

        return sceneItem;
    }
}


var originalPinnedPosition = null;
function animateLiveStream(zoom, swap, callback) {
    setTimeout(function () {
        var stream = $('#animatableRTC');

        console.log('animate live stream', stream);

        if (zoom === true) {
            showStream();
            var video = $('#web-rtc-placeholder');
            if (!previewModeEnabled) {
                video = $('#video-caller');
            }
            $(stream).removeClass('hidden');
            $(stream).empty().append(video);
            $(stream).find('#stream-controls').addClass('hidden');

            var dimensions = calcDimensions();
            originalPinnedPosition = {top: $(stream).position().top, left: $(stream).position().left, width: $(video).width(), height: $(video).height()};
            $(video).css({width: '100%'});
            $(stream).css({width: originalPinnedPosition.width + 'px', height: originalPinnedPosition.height + 'px', top: originalPinnedPosition.top, left: originalPinnedPosition.left});

            console.log('dimensions', dimensions, originalPinnedPosition, $(video).width());
            TweenMax.to(stream, .3, {width: dimensions.width + 'px', height: dimensions.height + 'px', top: dimensions.top + 'px', left: dimensions.left + 'px', opacity: 1, onComplete: function () {
                    $(window).on('resize', function () {
                        var dimensions = calcDimensions();
                        stream.css({width: dimensions.width + 'px', height: dimensions.height + 'px', top: dimensions.top + 'px', left: dimensions.left + 'px'});
                    });

                    if (callback) {
                        callback();
                    }
                }});
        } else {
            if (originalPinnedPosition) {
                TweenMax.to(stream, .2, {top: originalPinnedPosition.top + 'px', left: originalPinnedPosition.left + 'px', width: originalPinnedPosition.width + 'px', height: originalPinnedPosition.height + 'px', onComplete: function () {
                        $(stream).find('#stream-controls').removeClass('hidden');
                        $(stream).addClass('hidden');

                        pinRTC();

                        if (callback) {
                            callback();
                        }
                    }});
            } else {
                pinRTC();
            }
        }

//        return false;
        if (swap && !previewModeEnabled) {
            if (swap === VIEW_TESTER) {
                $(stream).find("#remote-stream").addClass('hidden');
//                $(stream).find(".rtc-local-container").after($(stream).find(".rtc-remote-container"));
                $(stream).find("#local-stream").css({width: '100%', top: '0px', left: '0px'});
//                $(stream).find("#remote-stream").css({width: '30%', height: '30%', top: '5px', left: '5px'});
            } else if (swap === VIEW_MODERATOR) {
                $(stream).find("#remote-stream").removeClass('hidden');
//                $(stream).find(".rtc-remote-container").after($(stream).find(".rtc-local-container"));
                $(stream).find("#local-stream").css({width: '30%', top: '5px', left: '5px'});
//                $(stream).find("#remote-stream").css({width: '100%', height: '100%', top: '0px', left: '0px'});
            }
//            keepStreamsAlive(stream);
        }

        keepStreamsAlive(stream);
    }, 300);
}

function calcDimensions() {
    var screenSize = {width: $(window).width(), height: $(window).height()};
    var maxHeight = screenSize.height - 120;
    var maxWidth = (maxHeight * 4 / 3) - 30;
    var ratio = screenSize.width / screenSize.height;
//    console.log(maxHeight, maxWidth, ratio);
    if (ratio < 1) {
        maxWidth = screenSize.width - 30;
        maxHeight = maxWidth * 3 / 4;
    }

    var newTop = previewModeEnabled ? ((screenSize.height - maxHeight) / 2) + 62 : ((screenSize.height - maxHeight) / 2) + 35;
    var newLeft = (screenSize.width - maxWidth) / 2;
    return {width: maxWidth, height: maxHeight, top: newTop, left: newLeft};
}