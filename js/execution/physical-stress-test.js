PhysicalStressTest.prototype.options = null;

function PhysicalStressTest(options) {
    this.options = options ? options : {};
    this.options.currentPhase = getCurrentPhase();
    this.options.currentPhaseData = getCurrentPhaseData();
    this.options.source = getSourceContainer(currentView);

    return this;
}



/*
 * moderator view rendering
 */

PhysicalStressTest.prototype.renderModeratorView = function () {
    console.log('render moderator view:', PHYSICAL_STRESS_TEST.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    if (!data.stressTestItems || data.stressTestItems.length === 0) {
        return false;
    }

    if (!previewModeEnabled) {
        var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
        tempData.annotations = new Array();
        setLocalItem(currentPhase.id + '.tempSaveData', tempData);
    }

    // observation section
    renderObservations(data, container);

    renderCurrentPhaseState();

    function renderCurrentPhaseState() {
        if (currentPhaseState === null) {
            currentPhaseState = 'initialize';
        }

        switch (currentPhaseState) {
            case 'initialize':
                renderStateInitialize();
                break;
            case 'stressTestStarted':
                renderStateStressTestStarted();
                break;
            case 'showGesture':
                renderStateShowGesture();
                break;
            case 'gesturesPresented':
                renderStateGesturesPresented();
                break;
            case 'showQuestions':
                renderStateShowQuestions();
                break;
            case 'askQuestionsDone':
                renderStateAskQuestionsDone();
                break;
            case 'stressTestDone':
                renderStateStressTestDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render moderator state: ', currentPhaseState);

        $(document).scrollTop(0);
        $(container).find('#general').removeClass('hidden');
        $(container).find('#general .headline').text(currentPhase.title);
        $(container).find('#general #description').text(data.description);

        $(container).find('#btn-start-stress-test').unbind('click').bind('click', function (event) {
            event.preventDefault();

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_START_STRESS_TEST);
            }

            currentPhaseState = 'stressTestStarted';
            renderCurrentPhaseState();
        });
    }

    function renderStateStressTestStarted() {
        console.log('render moderator state: ', currentPhaseState);

        $(document).scrollTop(0);
        renderStressTestControls();
        var showButton = $(container).find('#btn-show-gesture');
        $(showButton).removeClass('hidden');
        $(container).find('#question-container').addClass('hidden');

        $(showButton).unbind('click').bind('click', function (event) {
            event.preventDefault();
            currentPhaseState = 'showGesture';
            renderCurrentPhaseState();
        });
    }

    function renderStateShowGesture() {
        console.log('render moderator state: ', currentPhaseState);

        renderStressTestControls();

        var hideButton = $(container).find('#btn-hide-gesture');
        $(hideButton).removeClass('hidden').addClass('disabled');

        if (peerConnection) {
            $(peerConnection).unbind(MESSAGE_GESTURE_INFO_PRESENT).bind(MESSAGE_GESTURE_INFO_PRESENT, function (event) {
                event.preventDefault();
                $(hideButton).removeClass('disabled');
            });

            $(peerConnection).unbind(MESSAGE_GESTURE_INFO_CLOSED).bind(MESSAGE_GESTURE_INFO_CLOSED, function (event) {
                event.preventDefault();
                checkGestureIndex();
            });

            peerConnection.sendMessage(MESSAGE_TRIGGER_STRESS_TEST_GESTURE, {count: currentStressTestCount, index: currentStressTestIndex, gestureIndex: currentStressTestGestureIndex});
        } else {
            $(hideButton).removeClass('disabled');
        }

        $(hideButton).unbind('click').bind('click', function (event) {
            event.preventDefault();

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_CLOSE_GESTURE_INFO);
            } else {
                checkGestureIndex();
            }
        });

        function checkGestureIndex() {
            var gestures = data.stressTestItems[currentStressTestIndex].gestures;
            if (currentStressTestGestureIndex < gestures.length - 1) {
                currentStressTestGestureIndex++;
                currentPhaseState = 'stressTestStarted';
                renderCurrentPhaseState();
            } else {
                currentPhaseState = 'gesturesPresented';
                renderCurrentPhaseState();
            }
        }
    }

    function renderStateGesturesPresented() {
        console.log('render moderator state: ', currentPhaseState);

        renderStressTestSequence();

        if (currentStressTestCount < parseInt(data.stressAmount) - 1) {
            if (data.singleStressQuestions) {
                $(container).find('#btn-show-question').removeClass('hidden');
            } else {
                var gestures = data.stressTestItems[currentStressTestIndex].gestures;
                if (currentStressTestGestureIndex < gestures.length - 1) {
                    currentPhaseState = 'stressTestStarted';
                    renderCurrentPhaseState();
                } else {
                    currentPhaseState = 'askQuestionsDone';
                    renderCurrentPhaseState();
                }
            }
        } else {
            if (data.singleStressQuestions || data.sequenceStressQuestions) {
                $(container).find('#btn-show-question').removeClass('hidden');
            } else {
                currentPhaseState = 'askQuestionsDone';
                renderCurrentPhaseState();
            }
        }


        $(container).find('#btn-show-question').unbind('click').bind('click', function (event) {
            event.preventDefault();

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_TRIGGER_STRESS_TEST_QUESTION, {count: currentStressTestCount, index: currentStressTestIndex, gestureIndex: currentStressTestGestureIndex});
            } else {

            }

            currentPhaseState = 'showQuestions';
            renderCurrentPhaseState();
        });
    }

    function renderStateShowQuestions() {
        console.log('render moderator state: ', currentPhaseState);

        renderStressTestSequence();
        renderStressTestQuestions();
        checkControlButtons();

        $(container).find('#btn-show-question').addClass('hidden');
        $(container).find('#question-container').removeClass('hidden');

        function checkControlButtons() {
            if (currentStressTestCount < parseInt(data.stressAmount) - 1) {
                $(container).find('#btn-repeat-stress-test').removeClass('hidden').addClass('disabled');
            } else {
                if (currentStressTestIndex < data.stressTestItems.length - 1) {
                    $(container).find('#btn-next-gesture').removeClass('hidden').addClass('disabled');
                } else {
                    $(container).find('#btn-done-questionnaire').removeClass('hidden').addClass('disabled');
                }
            }
        }

        if (!previewModeEnabled) {
            $(peerConnection).unbind(MESSAGE_REACTIVATE_CONTROLS).bind(MESSAGE_REACTIVATE_CONTROLS, function (event, payload) {
                currentPhaseState = 'askQuestionsDone';
                renderCurrentPhaseState();
            });

            $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
                console.log('update questionnaire for physical stress test', payload);
                currentQuestionnaireAnswers = payload;
                renderStressTestQuestions();
            });
        }
    }

    function renderStateAskQuestionsDone() {
        console.log('render moderator state: ', currentPhaseState);

        currentStressTestGestureIndex = 0;
        renderStressTestSequence();
        renderStressTestQuestions();

        if (currentStressTestCount < parseInt(data.stressAmount) - 1) {
            $(container).find('#btn-repeat-stress-test').removeClass('hidden disabled');

            if (data.singleStressQuestions) {
                $(container).find('#question-container').removeClass('hidden');
            }
        } else {
            if (currentStressTestIndex < data.stressTestItems.length - 1) {
                $(container).find('#btn-next-gesture').removeClass('hidden disabled');
            } else {
                $(container).find('#btn-done-questionnaire').removeClass('hidden disabled');
            }

            if (data.singleStressQuestions || data.sequenceStressQuestions) {
                $(container).find('#question-container').removeClass('hidden');
            }
        }

        $(container).find('#btn-repeat-stress-test').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(this).unbind('click');
                $(this).addClass('hidden');

                currentQuestionnaireAnswers = null;
                currentStressTestCount++;
                currentStressTestGestureIndex = 0;

                currentPhaseState = 'stressTestStarted';
                renderCurrentPhaseState();
            }
        });

        $(container).find('#btn-next-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(this).unbind('click');
                $(this).addClass('hidden');

                currentQuestionnaireAnswers = null;
                currentStressTestCount = 0;
                currentStressTestIndex++;

                currentPhaseState = 'stressTestStarted';
                renderCurrentPhaseState();
            }
        });

        $(container).find('#btn-done-questionnaire').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(this).unbind('click');
                $(this).addClass('hidden');
                currentPhaseState = 'stressTestDone';
                renderCurrentPhaseState();
            }
        });
    }

    function renderStateStressTestDone() {
        console.log('render moderator state: ', currentPhaseState);
        $(document).scrollTop(0);
        appendAlert(container, ALERT_PHASE_STEP_DONE);
        $(container).find('#stress-test-controls, #question-container').addClass('hidden');

        $(container).find('#btn-stress-test-done').removeClass('hidden');
        $(container).find('#btn-stress-test-done').unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_NEXT_STEP);
            }
            nextStep();
        });
    }









    function renderStressTestControls() {
        $(container).find('#general').addClass('hidden');
        $(container).find('#stress-test-controls').removeClass('hidden');
        $(container).find('#stress-test-controls .headline').text(translation.gestureSequence + " " + (currentStressTestIndex + 1) + " " + translation.of + " " + data.stressTestItems.length);

        var gestures = data.stressTestItems[currentStressTestIndex].gestures;
        if (gestures.length > 0) {
            var gesture = getGestureById(gestures[currentStressTestGestureIndex]);
            if (gesture) {
                var thumbnailControls = $('#item-container-moderator').find('#physical-stress-test-thumbnail-controls').clone().removeAttr('id');
                $(container).find('#stress-test-controls-container').empty().append(thumbnailControls);
                $(thumbnailControls).find('.thumbnail-container').empty().append(getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12'));
            } else {
            }
        }
    }

    function renderStressTestSequence() {
        var gestures = data.stressTestItems[currentStressTestIndex].gestures;
        $(container).find('#stress-test-controls').removeClass('hidden');
        $(container).find('#stress-test-controls-container').empty();
        $(container).find('#stress-test-controls .headline').text(translation.gestureSequence + " " + (currentStressTestIndex + 1) + " " + translation.of + " " + data.stressTestItems.length);

        if (gestures.length > 0) {
            for (var i = 0; i < gestures.length; i++) {
                var gesture = getGestureById(gestures[i]);
                if (gesture) {
                    var gestureThumbnail = getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12 col-sm-4 col-md-4 col-lg-3');
                    $(container).find('#stress-test-controls-container').append(gestureThumbnail);
                }
            }
        }
    }

    function renderStressTestQuestions() {
        var answers = currentQuestionnaireAnswers;
        console.log('render stress test questions, answers:', currentQuestionnaireAnswers, currentStressTestCount, currentStressTestIndex, currentStressTestCount >= parseInt(data.stressAmount) - 1);
        var currentStressTestData = data.stressTestItems[currentStressTestIndex];
        var gesture = getGestureById(currentStressTestData);
        var item = $('#item-container-moderator').find('#physical-stress-test-questions').clone().removeAttr('id');
        $(container).find('#question-container').empty().append(item);

        // single joint section
        var singleStressGraphicsRating = data.singleStressGraphicsRating;
        if (singleStressGraphicsRating && singleStressGraphicsRating !== 'none') {
            var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
            $(jointAnswers).insertAfter($(item).find('#headline-single-questions'));
            if (singleStressGraphicsRating === 'hands') {
                $(jointAnswers).find('#joint-answers-body').remove();
                renderHandJointAnswers($(jointAnswers).find('#human-hand'), answers && answers.answers ? answers.answers : null, gesture.id, 'single');
            } else if (singleStressGraphicsRating === 'body') {
                $(jointAnswers).find('#joint-answers-hands').remove();
                renderBodyJointAnswers($(jointAnswers).find('#human-body'), answers && answers.answers ? answers.answers : null, gesture.id, 'single');
            } else {
                renderHandJointAnswers($(jointAnswers).find('#human-hand'), answers && answers.answers ? answers.answers : null, gesture.id, 'single');
                renderBodyJointAnswers($(jointAnswers).find('#human-body'), answers && answers.answers ? answers.answers : null, gesture.id, 'single');
            }
        }

        // single answers section
        var singleStressQuestionnaire = data.singleStressQuestions;
        if (singleStressQuestionnaire && singleStressQuestionnaire.length > 0) {
            $(item).find('#single-stress-answers').removeClass('hidden');
            if (answers && answers.answers && answers.answers.singleAnswers && answers.answers.singleAnswers[0]) {
                renderQuestionnaireAnswers($(item).find('#single-stress-answers'), singleStressQuestionnaire, {answers: answers.answers.singleAnswers[0].answers}, false, true);
            } else {
                renderQuestionnaireAnswers($(item).find('#single-stress-answers'), singleStressQuestionnaire, null, false);
            }
        } else {

        }

        if (currentStressTestCount >= parseInt(data.stressAmount) - 1) {
            // sequence answers section
            $(item).find('#sequence-stress-answers').addClass('hidden');
            var sequenceStressQuestionnaire = data.sequenceStressQuestions;
            if (sequenceStressQuestionnaire && sequenceStressQuestionnaire.length > 0) {
                $(item).find('#sequence-stress-answers').removeClass('hidden');
                if (answers && answers.answers && answers.answers.sequenceAnswers && answers.answers.sequenceAnswers[0]) {
                    renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), sequenceStressQuestionnaire, {answers: answers.answers.sequenceAnswers[0].answers}, false, true);
                } else {
                    renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), sequenceStressQuestionnaire, null, false);
                }
            }

            // sequence joint section
            var sequenceStressGraphicsRating = data.sequenceStressGraphicsRating;
            if (sequenceStressGraphicsRating && sequenceStressGraphicsRating !== 'none') {
                $(item).find('#sequence-stress-answers').removeClass('hidden');
                var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                $(jointAnswers).insertAfter($(item).find('#headline-sequence-questions'));
                if (sequenceStressGraphicsRating === 'hands') {
                    $(jointAnswers).find('#joint-answers-body').remove();
                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), answers && answers.answers ? answers.answers : null, gesture.id, 'sequence');
                } else if (sequenceStressGraphicsRating === 'body') {
                    $(jointAnswers).find('#joint-answers-hands').remove();
                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), answers && answers.answers ? answers.answers : null, gesture.id, 'sequence');
                } else {
                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), answers && answers.answers ? answers.answers : null, gesture.id, 'sequence');
                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), answers && answers.answers ? answers.answers : null, gesture.id, 'sequence');
                }
            }
        }
    }

    return container;
};








/*
 * tester view rendering
 */

PhysicalStressTest.prototype.renderTesterView = function () {
    console.log('render tester view:', PHYSICAL_STRESS_TEST.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    if (!data.stressTestItems || data.stressTestItems.length === 0) {
        return false;
    }

    renderCurrentPhaseState();
    function renderCurrentPhaseState() {
        if (currentPhaseState === null) {
            currentPhaseState = 'initialize';
        }

        switch (currentPhaseState) {
            case 'initialize':
                renderStateInitialize();
                break;
            case 'stressTestStarted':
                renderStateStressTestStarted();
                break;
            case 'showGesture':
                renderStateShowGesture();
                break;
            case 'gesturesPresented':
                renderStateGesturesPresented();
                break;
            case 'showQuestions':
                renderStateShowQuestions();
                break;
            case 'askQuestionsDone':
                renderStateAskQuestionsDone();
                break;
            case 'stressTestDone':
                renderStateStressTestDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render tester state: ', currentPhaseState);

        // general data section
        $(container).find('.headline').text(data.title);
        $(container).find('.description').text(data.description);

        currentQuestionnaireAnswers = {answers: []};

        if (!previewModeEnabled) {
            getGMT(function (timestamp) {
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.startStressTestTime = timestamp;
                tempData.annotations = [];
                tempData.answers = {singleAnswers: [], sequenceAnswers: []};
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });

            $(peerConnection).unbind(MESSAGE_START_STRESS_TEST).bind(MESSAGE_START_STRESS_TEST, function (event, payload) {
                currentPhaseState = 'stressTestStarted';
                renderCurrentPhaseState();
            });
        }

        appendAlert(container, ALERT_PLEASE_WAIT);
    }

    function renderStateStressTestStarted() {
        console.log('render tester state: ', currentPhaseState);
        appendAlert(container, ALERT_PLEASE_WAIT);

        if (!previewModeEnabled) {
            $(peerConnection).unbind(MESSAGE_TRIGGER_STRESS_TEST_GESTURE).bind(MESSAGE_TRIGGER_STRESS_TEST_GESTURE, function (event, payload) {
                clearAlerts($(container));
                currentStressTestCount = parseInt(payload.count);
                currentStressTestIndex = parseInt(payload.index);
                currentStressTestGestureIndex = parseInt(payload.gestureIndex)

                currentPhaseState = 'showGesture';
                renderCurrentPhaseState();
            });
        }

    }

    function renderStateShowGesture() {
        console.log('render tester state: ', currentPhaseState);

        clearAlerts(container);
        renderGestureInfos();

        if (!previewModeEnabled) {
            getGMT(function (timestamp) {
                var gesture = getGestureById(data.stressTestItems[currentStressTestIndex].gestures[currentStressTestGestureIndex]);
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_PERFORM_GESTURE_STRESS_TEST, gestureId: gesture.id, time: timestamp});
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });

            $(peerConnection).unbind(MESSAGE_TRIGGER_STRESS_TEST_QUESTION).bind(MESSAGE_TRIGGER_STRESS_TEST_QUESTION, function (event, payload) {
                event.preventDefault();
                currentStressTestCount = parseInt(payload.count);
                currentStressTestIndex = parseInt(payload.index);
                currentStressTestGestureIndex = parseInt(payload.gestureIndex);

                currentPhaseState = 'showQuestions';
                renderCurrentPhaseState();
            });

            $(peerConnection).unbind(MESSAGE_CLOSE_GESTURE_INFO).bind(MESSAGE_CLOSE_GESTURE_INFO, function (event) {
                event.preventDefault();
                peerConnection.sendMessage(MESSAGE_GESTURE_INFO_CLOSED);
                currentPhaseState = 'gesturesPresented';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStateGesturesPresented() {
        console.log('render tester state: ', currentPhaseState);

        $(container).find('#stressTestContainer').addClass('hidden');
        $(container).find('#gestures-list-container').empty();
        clearAlerts(container);
        appendAlert(container, ALERT_PLEASE_WAIT);
    }


    function renderStateShowQuestions() {
        console.log('render tester state: ', currentPhaseState);
        clearAlerts(container);
        renderGestureSequence();

        var questionContainer = $(container).find('#stress-test-questionnaire');
        questionContainer.removeClass('hidden');
        if (!previewModeEnabled) {
            getGMT(function (timestamp) {
                var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
                tempData.annotations.push({id: tempData.annotations.length, action: ACTION_START_QUESTIONNAIRE, time: timestamp});
                setLocalItem(currentPhase.id + '.tempSaveData', tempData);
            });
        }

        // single questions section
        if (data.singleStressQuestions && data.singleStressQuestions.length > 0 || data.singleStressGraphicsRating !== 'none') {
            $(container).find('#btn-questionnaire-done, #questionnaire-heading, #single-questions').removeClass('hidden');
            $(container).find('#general-repeats, #btn-gesture-done').addClass('hidden');
            $(container).find('#gesturePreview').removeClass('col-sm-12').addClass('col-sm-5');
            if (data.singleStressQuestions && data.singleStressQuestions.length > 0) {
                renderQuestionnaire(questionContainer.find('#single-questions'), data.singleStressQuestions, currentQuestionnaireAnswers ? currentQuestionnaireAnswers.answers : null, false);
            }
        }

        if (data.singleStressGraphicsRating && data.singleStressGraphicsRating !== 'none') {
            renderSelectionRatingGraphics($(container).find('#single-joint-selection'), data.singleStressGraphicsRating);
        }

        // sequence questions section, only if last currentStressTestCount were reached
        if (currentStressTestCount >= parseInt(data.stressAmount) - 1) {
            console.log('sequenceStressGraphicsRating', data.sequenceStressGraphicsRating);
            if (data.sequenceStressQuestions && data.sequenceStressQuestions.length > 0 || data.sequenceStressGraphicsRating !== 'none') {
                $(container).find('#btn-questionnaire-done, #questionnaire-heading, #sequence-questions').removeClass('hidden');
                $(container).find('#general-repeats, #btn-gesture-done').addClass('hidden');
                $(container).find('#gesturePreview').removeClass('col-sm-12').addClass('col-sm-5');
                if (data.sequenceStressQuestions && data.sequenceStressQuestions.length > 0) {
                    renderQuestionnaire(questionContainer.find('#sequence-questions'), data.sequenceStressQuestions, currentQuestionnaireAnswers ? currentQuestionnaireAnswers.answers : null, false);
                }
            }

            if (data.sequenceStressGraphicsRating && data.sequenceStressGraphicsRating !== 'none') {
                renderSelectionRatingGraphics($(container).find('#sequence-joint-selection'), data.sequenceStressGraphicsRating);
            }
        }

        $(container).find('#btn-done-questionnaire').unbind('click').bind('click', function (event) {
            event.preventDefault();
            savePhysicalStressTestAnswers();

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_REACTIVATE_CONTROLS);
            }

            currentPhaseState = 'askQuestionsDone';
            renderCurrentPhaseState();
        });

        $(container).find('#stress-test-questionnaire').unbind('change').bind('change', function (event) {
            console.log('stress-test-questionnaire changed');
            savePhysicalStressTestAnswers();
        });

    }

    function renderStateAskQuestionsDone() {
        console.log('render tester state: ', currentPhaseState);
        $(container).find('#stressTestContainer').empty().addClass('hidden');
        appendAlert(container, ALERT_PLEASE_WAIT);

        if (!previewModeEnabled) {
            $(peerConnection).unbind(MESSAGE_TRIGGER_NEXT_STRESS_TEST_GESTURE).bind(MESSAGE_TRIGGER_NEXT_STRESS_TEST_GESTURE, function (event, payload) {
                currentPhaseState = 'renderStateStressTestStarted';
                renderCurrentPhaseState();
            });
        }
    }



    function renderGestureInfos() {
        var item = $(source).find('#physicalStressTestModerated').clone().removeAttr('id');
        $(container).find('#stressTestContainer').removeClass('hidden').empty().append(item);
        var gesture = getGestureById(data.stressTestItems[currentStressTestIndex].gestures[currentStressTestGestureIndex]);
        renderGestureImages($(container).find('.previewGesture'), gesture.images, gesture.previewImage, null);

        var gestureThumbnail = $('#item-container-tester').find('#physicalStressTestItem-gesture').clone().removeAttr('id');
        $(gestureThumbnail).removeClass('col-md-4 col-lg-3 ').addClass('col-sm-offset-3').find('.previewGesture').removeClass('mousePlayable').addClass('autoplay');
        renderGestureImages($(gestureThumbnail).find('.previewGesture'), gesture.images, gesture.previewImage, null);
        $(item).find('#gestures-list-container').empty().append(gestureThumbnail);

        if (peerConnection) {
            peerConnection.sendMessage(MESSAGE_GESTURE_INFO_PRESENT);
        }
    }

    function renderGestureSequence() {
        var item = $(source).find('#physicalStressTestModerated').clone().removeAttr('id');
        $(container).find('#stressTestContainer').removeClass('hidden').empty().append(item);

        var gestures = data.stressTestItems[currentStressTestIndex].gestures;
        if (gestures && gestures.length > 0) {
            $(item).find('#gestures-list-container').empty();
            for (var i = 0; i < gestures.length; i++) {
                var gesture = getGestureById(gestures[i]);
                var gestureThumbnail = $('#item-container-tester').find('#physicalStressTestItem-gesture').clone().removeAttr('id');
                renderGestureImages($(gestureThumbnail).find('.previewGesture'), gesture.images, gesture.previewImage, null);
                $(item).find('#gestures-list-container').append(gestureThumbnail);
            }
        }
    }

    function savePhysicalStressTestAnswers() {
        var singleAnswer = {};
        if (data.singleStressQuestions && data.singleStressQuestions.length > 0) {
            var singleQuestionnaire = $(container).find('#single-questions .question-container').children();
            var singleQuestionAnswers = getQuestionnaireAnswers(singleQuestionnaire, data.singleStressQuestions);
            singleAnswer.stressTestIndex = currentStressTestIndex;
            singleAnswer.answers = singleQuestionAnswers;
            getJointSelectionRatings(singleAnswer, data.singleStressGraphicsRating, $(container).find('#single-joint-selection'));
        } else if (data.singleStressGraphicsRating) {
            singleAnswer.stressTestIndex = currentStressTestIndex;
            getJointSelectionRatings(singleAnswer, data.singleStressGraphicsRating, $(container).find('#single-joint-selection'));
        }

        var sequenceAnswer = {};
        if (currentStressTestCount >= parseInt(data.stressAmount) - 1) {
            if (data.sequenceStressQuestions && data.sequenceStressQuestions.length > 0) {
                var sequenceQuestionnaire = $(container).find('#sequence-questions .question-container').children();
                var sequenceQuestionAnswers = getQuestionnaireAnswers(sequenceQuestionnaire, data.sequenceStressQuestions);
                sequenceAnswer.stressTestIndex = currentStressTestIndex;
                sequenceAnswer.answers = sequenceQuestionAnswers;
                getJointSelectionRatings(sequenceAnswer, data.sequenceStressGraphicsRating, $(container).find('#sequence-joint-selection'));
            } else if (data.sequenceStressGraphicsRating) {
                sequenceAnswer.stressTestIndex = currentStressTestIndex;
                getJointSelectionRatings(sequenceAnswer, data.sequenceStressGraphicsRating, $(container).find('#sequence-joint-selection'));
            }
        }

        currentQuestionnaireAnswers = {};
        currentQuestionnaireAnswers.answers = {singleAnswers: $.isEmptyObject(singleAnswer) ? null : [singleAnswer], sequenceAnswers: $.isEmptyObject(sequenceAnswer) ? null : [sequenceAnswer]};
        console.log('current Questionnaire Answers:', currentQuestionnaireAnswers);
        if (!previewModeEnabled) {
            peerConnection.sendMessage(MESSAGE_UPDATE_QUESTIONNAIRE, currentQuestionnaireAnswers);

            // save joints and questionnaire answers if in live mode
            var answerIndex = (parseInt(data.stressAmount) * currentStressTestIndex) + currentStressTestCount;           
            var tempData = getLocalItem(currentPhase.id + '.tempSaveData');
            tempData.answers.singleAnswers[answerIndex] = singleAnswer;
            tempData.answers.sequenceAnswers[currentStressTestIndex] = sequenceAnswer;
            setLocalItem(currentPhase.id + '.tempSaveData', tempData);
        }
    }

    function renderSelectionRatingGraphics(item, selectionRating) {
        if (selectionRating !== 'none') {
            $(item).removeClass('hidden');
            switch (selectionRating) {
                case 'body':
                    $(item).find('#hand-selection-rating').addClass('hidden');
                    $(item).find('#human-body-selection-rating').removeClass('hidden');
                    renderBodyJoints($(item).find('#human-body'));
                    break;
                case 'hands':
                    $(item).find('#human-body-selection-rating').addClass('hidden');
                    $(item).find('#hand-selection-rating').removeClass('hidden');
                    renderHandJoints($(item).find('#human-hand'));
                    break;
                case 'bodyHands':
                    $(item).find('#human-body-selection-rating').removeClass('hidden');
                    renderBodyJoints($(item).find('#human-body'));
                    $(item).find('#hand-selection-rating').removeClass('hidden');
                    renderHandJoints($(item).find('#human-hand'));
                    break;
            }
        }
    }


    function getJointSelectionRatings(answers, selectionRating, container) {
        if (selectionRating !== 'none') {
            var selectedBodyJoints = null;
            var selectedHandJoints = null;
            switch (selectionRating) {
                case 'body':
                    selectedBodyJoints = getSelectedJoints($(container).find('#human-body-selection-rating'));
                    answers.selectedBodyJoints = selectedBodyJoints;
                    break;
                case 'hands':
                    selectedHandJoints = getSelectedJoints($(container).find('#hand-selection-rating'));
                    answers.selectedHandJoints = selectedHandJoints;
                    break;
                case 'bodyHands':
                    selectedBodyJoints = getSelectedJoints($(container).find('#human-body-selection-rating'));
                    selectedHandJoints = getSelectedJoints($(container).find('#hand-selection-rating'));
                    answers.selectedBodyJoints = selectedBodyJoints;
                    answers.selectedHandJoints = selectedHandJoints;
                    break;
            }

            console.log('getJointSelectionRatings', answers);
        }
        return answers;
    }

    return container;
};






/*
 * observer view rendering
 */

PhysicalStressTest.prototype.renderObserverView = function () {
    console.log('render observer view:', PHYSICAL_STRESS_TEST.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');

    if (!data.stressTestItems || data.stressTestItems.length === 0) {
        return false;
    }
    // observation section
    renderObservations(data, container);

    // init annotation controls
    renderAnnotationControls(container);

    renderCurrentPhaseState();

    function renderCurrentPhaseState() {
        if (currentPhaseState === null) {
            currentPhaseState = 'initialize';
        }

        switch (currentPhaseState) {
            case 'initialize':
                renderStateInitialize();
                break;
            case 'stressTestStarted':
                renderStateStressTestStarted();
                break;
            case 'showGesture':
                renderStateShowGesture();
                break;
            case 'gesturesPresented':
                renderStateGesturesPresented();
                break;
            case 'showQuestions':
                renderStateShowQuestions();
                break;
            case 'askQuestionsDone':
                renderStateAskQuestionsDone();
                break;
            case 'stressTestDone':
                renderStateStressTestDone();
                break;
        }
    }

    function renderStateInitialize() {
        console.log('render observer state: ', currentPhaseState);

        $(document).scrollTop(0);
        appendAlert(container, ALERT_PLEASE_WAIT);

        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).bind(MESSAGE_START_STRESS_TEST).bind(MESSAGE_START_STRESS_TEST, function () {
                currentPhaseState = 'stressTestStarted';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStateStressTestStarted() {
        console.log('render observer state: ', currentPhaseState);

        clearAlerts(container);
        $(document).scrollTop(0);
        renderStressTestControls();
//        var showButton = $(container).find('#btn-show-gesture');
//        $(showButton).removeClass('hidden');
//        $(container).find('#question-container').addClass('hidden');

        if (!previewModeEnabled) {
            $(peerConnection).unbind(MESSAGE_TRIGGER_STRESS_TEST_GESTURE).bind(MESSAGE_TRIGGER_STRESS_TEST_GESTURE, function (event, payload) {
                clearAlerts($(container));
                currentStressTestCount = parseInt(payload.count);
                currentStressTestIndex = parseInt(payload.index);
                currentStressTestGestureIndex = parseInt(payload.gestureIndex)

                currentPhaseState = 'showGesture';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStateShowGesture() {
        console.log('render observer state: ', currentPhaseState);

        renderStressTestControls();

        if (peerConnection) {
            $(peerConnection).unbind(MESSAGE_GESTURE_INFO_PRESENT).bind(MESSAGE_GESTURE_INFO_PRESENT, function (event) {
                event.preventDefault();
            });

            $(peerConnection).unbind(MESSAGE_GESTURE_INFO_CLOSED).bind(MESSAGE_GESTURE_INFO_CLOSED, function (event) {
                event.preventDefault();
                currentPhaseState = 'gesturesPresented';
                renderCurrentPhaseState();
//                checkGestureIndex();
            });

//            peerConnection.sendMessage(MESSAGE_TRIGGER_STRESS_TEST_GESTURE, {count: currentStressTestCount, index: currentStressTestIndex, gestureIndex: currentStressTestGestureIndex});
        } else {
//            $(hideButton).removeClass('disabled');
        }

    }

    function renderStateGesturesPresented() {
        console.log('render observer state: ', currentPhaseState);

        renderStressTestSequence();

        if (currentStressTestCount < parseInt(data.stressAmount) - 1) {
            if (data.singleStressQuestions) {
                $(container).find('#btn-show-question').removeClass('hidden');
            } else {
                var gestures = data.stressTestItems[currentStressTestIndex].gestures;
                if (currentStressTestGestureIndex < gestures.length - 1) {
                    currentPhaseState = 'stressTestStarted';
                    renderCurrentPhaseState();
                } else {
                    currentPhaseState = 'askQuestionsDone';
                    renderCurrentPhaseState();
                }
            }
        } else {
            if (data.singleStressQuestions || data.sequenceStressQuestions) {
                $(container).find('#btn-show-question').removeClass('hidden');
            } else {
                currentPhaseState = 'askQuestionsDone';
                renderCurrentPhaseState();
            }
        }


        if (!previewModeEnabled && peerConnection) {
            $(peerConnection).unbind(MESSAGE_TRIGGER_STRESS_TEST_QUESTION).bind(MESSAGE_TRIGGER_STRESS_TEST_QUESTION, function (event, payload) {
                currentStressTestCount = parseInt(payload.count);
                currentStressTestIndex = parseInt(payload.index);
                currentStressTestGestureIndex = parseInt(payload.gestureIndex);

                currentPhaseState = 'showQuestions';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStateShowQuestions() {
        console.log('render observer state: ', currentPhaseState);

        renderStressTestSequence();
        renderStressTestQuestions();
        $(container).find('#question-container').removeClass('hidden');

        if (!previewModeEnabled) {
            $(peerConnection).unbind(MESSAGE_REACTIVATE_CONTROLS).bind(MESSAGE_REACTIVATE_CONTROLS, function (event, payload) {
                currentQuestionnaireAnswers = null;
                currentPhaseState = 'askQuestionsDone';
                renderCurrentPhaseState();
            });

            $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
                console.log('update questionnaire for physical stress test', payload);
                currentQuestionnaireAnswers = payload;
                renderStressTestQuestions();
            });
        }
    }

    function renderStateAskQuestionsDone() {
        console.log('render observer state: ', currentPhaseState);

        currentStressTestGestureIndex = 0;
        $(container).find('#question-container, #stress-test-controls').addClass('hidden');
        
        appendAlert(container, ALERT_PLEASE_WAIT);

        if (!previewModeEnabled) {
            $(peerConnection).unbind(MESSAGE_START_STRESS_TEST).bind(MESSAGE_START_STRESS_TEST, function (event, payload) {
                currentPhaseState = 'renderStateStressTestStarted';
                renderCurrentPhaseState();
            });
        }
    }

    function renderStateStressTestDone() {
        console.log('render observer state: ', currentPhaseState);
        $(document).scrollTop(0);
        appendAlert(container, ALERT_PLEASE_WAIT);
        $(container).find('#stress-test-controls, #question-container').addClass('hidden');
    }









    function renderStressTestControls() {
        $(container).find('#general').addClass('hidden');
        $(container).find('#stress-test-controls').removeClass('hidden');
        $(container).find('#stress-test-controls .headline').text(translation.gestureSequence + " " + (currentStressTestIndex + 1) + " " + translation.of + " " + data.stressTestItems.length);

        var gestures = data.stressTestItems[currentStressTestIndex].gestures;
        if (gestures.length > 0) {
            var gesture = getGestureById(gestures[currentStressTestGestureIndex]);
            if (gesture) {
                var thumbnailControls = $(getSourceContainer(VIEW_MODERATOR)).find('#physical-stress-test-thumbnail-controls').clone().removeAttr('id');
                $(container).find('#stress-test-controls-container').empty().append(thumbnailControls);
                $(thumbnailControls).find('.thumbnail-container').empty().append(getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12'));
            } else {
            }
        }
    }

    function renderStressTestSequence() {
        var gestures = data.stressTestItems[currentStressTestIndex].gestures;
        $(container).find('#stress-test-controls').removeClass('hidden');
        $(container).find('#stress-test-controls-container').empty();
        $(container).find('#stress-test-controls .headline').text(translation.gestureSequence + " " + (currentStressTestIndex + 1) + " " + translation.of + " " + data.stressTestItems.length);

        if (gestures.length > 0) {
            for (var i = 0; i < gestures.length; i++) {
                var gesture = getGestureById(gestures[i]);
                if (gesture) {
                    var gestureThumbnail = getSimpleGestureListThumbnail(gesture, 'simple-gesture-thumbnail', 'col-xs-12 col-sm-4 col-md-4 col-lg-3');
                    $(container).find('#stress-test-controls-container').append(gestureThumbnail);
                }
            }
        }
    }

    function renderStressTestQuestions() {
        var answers = currentQuestionnaireAnswers;
        console.log('render stress test questions, answers:', currentQuestionnaireAnswers, currentStressTestCount, currentStressTestIndex, currentStressTestCount >= parseInt(data.stressAmount) - 1);
        var currentStressTestData = data.stressTestItems[currentStressTestIndex];
        var gesture = getGestureById(currentStressTestData);
        var item = $('#item-container-moderator').find('#physical-stress-test-questions').clone().removeAttr('id');
        $(container).find('#question-container').empty().append(item);

        // single joint section
        var singleStressGraphicsRating = data.singleStressGraphicsRating;
        if (singleStressGraphicsRating && singleStressGraphicsRating !== 'none') {
            var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
            $(jointAnswers).insertAfter($(item).find('#headline-single-questions'));
            if (singleStressGraphicsRating === 'hands') {
                $(jointAnswers).find('#joint-answers-body').remove();
                renderHandJointAnswers($(jointAnswers).find('#human-hand'), answers && answers.answers ? answers.answers : null, gesture.id, 'single');
            } else if (singleStressGraphicsRating === 'body') {
                $(jointAnswers).find('#joint-answers-hands').remove();
                renderBodyJointAnswers($(jointAnswers).find('#human-body'), answers && answers.answers ? answers.answers : null, gesture.id, 'single');
            } else {
                renderHandJointAnswers($(jointAnswers).find('#human-hand'), answers && answers.answers ? answers.answers : null, gesture.id, 'single');
                renderBodyJointAnswers($(jointAnswers).find('#human-body'), answers && answers.answers ? answers.answers : null, gesture.id, 'single');
            }
        }

        // single answers section
        var singleStressQuestionnaire = data.singleStressQuestions;
        if (singleStressQuestionnaire && singleStressQuestionnaire.length > 0) {
            $(item).find('#single-stress-answers').removeClass('hidden');
            if (answers && answers.answers && answers.answers.singleAnswers && answers.answers.singleAnswers[0]) {
                renderQuestionnaireAnswers($(item).find('#single-stress-answers'), singleStressQuestionnaire, {answers: answers.answers.singleAnswers[0].answers}, false, true);
            } else {
                renderQuestionnaireAnswers($(item).find('#single-stress-answers'), singleStressQuestionnaire, null, false);
            }
        } else {

        }

        if (currentStressTestCount >= parseInt(data.stressAmount) - 1) {
            // sequence answers section
            $(item).find('#sequence-stress-answers').addClass('hidden');
            var sequenceStressQuestionnaire = data.sequenceStressQuestions;
            if (sequenceStressQuestionnaire && sequenceStressQuestionnaire.length > 0) {
                $(item).find('#sequence-stress-answers').removeClass('hidden');
                if (answers && answers.answers && answers.answers.sequenceAnswers && answers.answers.sequenceAnswers[0]) {
                    renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), sequenceStressQuestionnaire, {answers: answers.answers.sequenceAnswers[0].answers}, false, true);
                } else {
                    renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), sequenceStressQuestionnaire, null, false);
                }
            }

            // sequence joint section
            var sequenceStressGraphicsRating = data.sequenceStressGraphicsRating;
            if (sequenceStressGraphicsRating && sequenceStressGraphicsRating !== 'none') {
                $(item).find('#sequence-stress-answers').removeClass('hidden');
                var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                $(jointAnswers).insertAfter($(item).find('#headline-sequence-questions'));
                if (sequenceStressGraphicsRating === 'hands') {
                    $(jointAnswers).find('#joint-answers-body').remove();
                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), answers && answers.answers ? answers.answers : null, gesture.id, 'sequence');
                } else if (sequenceStressGraphicsRating === 'body') {
                    $(jointAnswers).find('#joint-answers-hands').remove();
                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), answers && answers.answers ? answers.answers : null, gesture.id, 'sequence');
                } else {
                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), answers && answers.answers ? answers.answers : null, gesture.id, 'sequence');
                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), answers && answers.answers ? answers.answers : null, gesture.id, 'sequence');
                }
            }
        }
    }

    return container;
};