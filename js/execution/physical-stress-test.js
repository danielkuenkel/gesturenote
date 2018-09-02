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

    // general data section
    $(container).find('#general .headline').text(getCurrentPhase().title);
    $(container).find('#general #description').text(data.description);

    // stress test controls section
    currentClass.renderPhysicalStressTest(source, container, data);

    // observation section
    renderObservations(data, container);
    if (!previewModeEnabled && peerConnection) {
        $(peerConnection).unbind(MESSAGE_REACTIVATE_CONTROLS).bind(MESSAGE_REACTIVATE_CONTROLS, function (event, payload) {
            if (currentStressTestCount >= data.stressAmount) {
                container.find('#btn-next-gesture').removeClass('disabled');
            } else {
                currentClass.renderPhysicalStressTest(source, container, data);
            }
        });
        $(peerConnection).unbind(MESSAGE_UPDATE_QUESTIONNAIRE).bind(MESSAGE_UPDATE_QUESTIONNAIRE, function (event, payload) {
            console.log('update questionnaire for physical stress test', payload);
            currentQuestionnaireAnswers = payload;
            currentClass.renderPhysicalStressTestQuestionnaire(container, data, payload);
        });
    }

    return container;
};

PhysicalStressTest.prototype.renderPhysicalStressTest = function (source, container, data) {
    $(container).find('#controls .headline').text(translation.gesture + " " + (currentStressTestIndex + 1) + " " + translation.of + " " + data.stressTestItems.length);

    if (stressTestStartTriggered) {
        container.find('#btn-show-gesture').removeClass('disabled');
        container.find('#btn-start-stress-test').remove();
    }

    if (currentStressTestCount >= data.stressAmount) {
        $(container).find('#btn-next-gesture').removeClass('disabled');
        $(container).find('#btn-show-gesture, #btn-show-question').addClass('disabled');

        if (!data.sequenceStressQuestions && !data.singleStressQuestions && data.singleStressGraphicsRating === 'none' && data.sequenceStressGraphicsRating === 'none') {
            $(container).find('#btn-show-question').addClass('hidden');
        } else {
            $(container).find('#btn-show-question').removeClass('hidden');
        }
    } else {
        $(container).find('#btn-next-gesture').addClass('disabled');

        if (!data.singleStressQuestions && data.singleStressGraphicsRating === 'none') {
            $(container).find('#btn-show-question').addClass('hidden');
        }
    }

    if (currentStressTestIndex >= data.stressTestItems.length - 1) {
        $(container).find('#btn-next-gesture .btn-text').text(translation.done);
        $(container).find('#btn-next-gesture .fa-check').removeClass('hidden');
        $(container).find('#btn-next-gesture #next-arrow').addClass('hidden');
    }

    var gesture = getGestureById(data.stressTestItems[currentStressTestIndex]);
    if (gesture) {
        renderGestureImages($(container).find('.previewGesture'), gesture.images, gesture.previewImage);
//            container.find('.btn-popover-gesture-preview').attr('name', gesture.id);
        container.find('#stress-for .text').text(gesture.title);
    } else {
        container.find('.btn-popover-gesture-preview').addClass('disabled');
    }

    container.find('#repeats-left .text').text((data.stressAmount - currentStressTestCount));
    if (stressTestGestureTriggered) {
        if ((currentStressTestCount < data.stressAmount && !data.singleStressQuestions && data.singleStressGraphicsRating === 'none') || (currentStressTestCount >= data.stressAmount && !data.sequenceStressQuestions && data.sequenceStressGraphicsRating === 'none')) {
            container.find('#btn-show-gesture').removeClass('disabled');
        } else {
            container.find('#btn-show-gesture').addClass('disabled');
            container.find('#btn-show-question').removeClass('disabled');
        }
    }

    container.find('#btn-start-stress-test').unbind('click').bind('click', function (event) {
        event.preventDefault();
        $(this).remove();
        stressTestStartTriggered = true;
        container.find('#btn-show-gesture').removeClass('disabled');
        if (peerConnection) {
            peerConnection.sendMessage(MESSAGE_START_STRESS_TEST);
        }
    });

    container.find('#btn-show-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('disabled');
            $(container).find('#gestures-container').addClass('hidden');
            container.find('#btn-show-question').removeClass('disabled');
            stressTestGestureTriggered = true;
            stressTestQuestionsTriggered = false;

            if ((currentStressTestCount < data.stressAmount && !data.singleStressQuestions && data.singleStressGraphicsRating === 'none') || (currentStressTestCount >= data.stressAmount && !data.sequenceStressQuestions && data.sequenceStressGraphicsRating === 'none')) {
                $(this).removeClass('disabled');
//                    currentStressTestCount++;

                if (previewModeEnabled) {
                    currentClass.renderPhysicalStressTest(source, container, data);
                }
            }

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_TRIGGER_STRESS_TEST_GESTURE, {count: currentStressTestCount, index: currentStressTestIndex});
            }
        } else {
            if (stressTestStartTriggered) {
                wobble(container.find('#btn-show-question'));
            } else {
                $(document).scrollTop(0);
                wobble(container.find('#btn-start-stress-test'));
            }
        }
    });


    if (stressTestQuestionsTriggered === true && stressTestGestureTriggered === false) {
        currentClass.renderPhysicalStressTestQuestionnaire(container, data, currentQuestionnaireAnswers);
        $(container).find('#gestures-container').removeClass('hidden');
    }

    container.find('#btn-show-question').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('disabled');
            $(container).find('#btn-show-gesture').addClass('disabled');
            stressTestQuestionsTriggered = true;
            stressTestGestureTriggered = false;
            currentQuestionnaireAnswers = null;

            currentStressTestCount++;
            currentClass.renderPhysicalStressTestQuestionnaire(container, data, currentQuestionnaireAnswers);
            $(container).find('#gestures-container').removeClass('hidden');

            if (peerConnection) {
                peerConnection.sendMessage(MESSAGE_TRIGGER_STRESS_TEST_QUESTION, {count: currentStressTestCount, index: currentStressTestIndex});
            }

            if (previewModeEnabled) {
                currentClass.renderPhysicalStressTest(source, container, data);
            }
        } else {
            if (!stressTestStartTriggered) {
                $(document).scrollTop(0);
                wobble(container.find('#btn-start-stress-test'));
            } else {
                wobble(container.find('#btn-show-gesture'));
            }
        }
    });

    container.find('#btn-next-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('disabled');
            $(container).find('#gestures-container').addClass('hidden');

            if (currentStressTestIndex >= data.stressTestItems.length - 1) {
                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_NEXT_STEP);
                }

                nextStep();
            } else {
                currentStressTestIndex++;
                currentStressTestCount = 0;

                if (peerConnection) {
                    peerConnection.sendMessage(MESSAGE_TRIGGER_NEXT_STRESS_TEST_GESTURE, {count: currentStressTestCount, index: currentStressTestIndex});
                }

                stressTestQuestionsTriggered = false;
                stressTestGestureTriggered = false;
                currentClass.renderPhysicalStressTest(source, container, data);
            }
        } else {
            if (!stressTestStartTriggered) {
                $(document).scrollTop(0);
                wobble(container.find('#btn-start-stress-test'));
            } else {
                wobble(container.find('#btn-show-gesture, #btn-show-question'));
            }
        }
    });
},
        PhysicalStressTest.prototype.renderPhysicalStressTestQuestionnaire = function (container, studyData, resultsData) {
            console.log('renderPhysicalStressTestQuestionnaire', resultsData);
            var currentStressTestData = studyData.stressTestItems[currentStressTestIndex];
            var gesture = getGestureById(currentStressTestData);
            var item = $('#item-container-moderator').find('#physicalStressTest-item').clone().removeAttr('id');
            container.find('#gestures-container').empty().append(item);
            renderGestureImages($(item).find('.previewGesture'), gesture.images, gesture.previewImage);
            $(item).find('#gesture .address').text(translation.gesture + ': ');
            $(item).find('#gesture .text').text(gesture.title);
            $(item).find('#trigger .address').text(translation.trigger + ': ');
            $(item).find('#trigger .text').text(trigger.title);
            $(item).find('#selection .address').text(translation.trigger + ' ' + translation.answer + ': ');

            console.log(studyData, currentStressTestData);

            // single joint section
            var singleStressGraphicsRating = studyData.singleStressGraphicsRating;
            if (singleStressGraphicsRating && singleStressGraphicsRating !== 'none') {
                var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                $(jointAnswers).insertAfter($(item).find('#headline-single-questions'));
                if (singleStressGraphicsRating === 'hands') {
                    $(jointAnswers).find('#joint-answers-body').remove();
                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'single');
                } else if (singleStressGraphicsRating === 'body') {
                    $(jointAnswers).find('#joint-answers-hands').remove();
                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'single');
                } else {
                    renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'single');
                    renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'single');
                }
            }

            // single answers section
            var singleStressQuestionnaire = studyData.singleStressQuestions;
            if (singleStressQuestionnaire && singleStressQuestionnaire.length > 0) {
                $(item).find('#single-stress-answers').removeClass('hidden');
                if (resultsData && resultsData.answers && resultsData.answers.singleAnswers && resultsData.answers.singleAnswers[0]) {
                    renderQuestionnaireAnswers($(item).find('#single-stress-answers'), singleStressQuestionnaire, {answers: resultsData.answers.singleAnswers[0].answers}, false, true);
                } else {
                    renderQuestionnaireAnswers($(item).find('#single-stress-answers'), singleStressQuestionnaire, null, false);
                }
            } else {
//            if (singleStressGraphicsRating && singleStressGraphicsRating !== 'none') {
//                $(item).find('#single-stress-answers').removeClass('hidden');
//            } else {
//                $(item).find('#single-stress-answers').addClass('hidden');
//            }
            }

            // sequence answers section
            var sequenceStressQuestionnaire = studyData.sequenceStressQuestions;
            if (sequenceStressQuestionnaire && sequenceStressQuestionnaire.length > 0) {
                if (currentStressTestCount >= parseInt(studyData.stressAmount)) {
                    $(item).find('#sequence-stress-answers').removeClass('hidden');
                    if (resultsData && resultsData.answers && resultsData.answers.sequenceAnswers && resultsData.answers.sequenceAnswers[0]) {
                        renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), sequenceStressQuestionnaire, {answers: resultsData.answers.sequenceAnswers[0].answers}, false, true);
                    } else {
                        renderQuestionnaireAnswers($(item).find('#sequence-stress-answers'), sequenceStressQuestionnaire, null, false);
                    }
                } else {
                    $(item).find('#sequence-stress-answers').addClass('hidden');
                }
            } else {
                $(item).find('#sequence-stress-answers').addClass('hidden');
            }

            if (currentStressTestCount >= parseInt(studyData.stressAmount)) {
                $(item).find('#sequence-stress-answers').removeClass('hidden');

                // sequence joint section
                var sequenceStressGraphicsRating = studyData.sequenceStressGraphicsRating;
                if (sequenceStressGraphicsRating && sequenceStressGraphicsRating !== 'none') {
                    var jointAnswers = $('#template-study-container').find('#joint-answers').clone().removeAttr('id');
                    $(jointAnswers).insertAfter($(item).find('#headline-sequence-questions'));
                    if (sequenceStressGraphicsRating === 'hands') {
                        $(jointAnswers).find('#joint-answers-body').remove();
                        renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'sequence');
                    } else if (sequenceStressGraphicsRating === 'body') {
                        $(jointAnswers).find('#joint-answers-hands').remove();
                        renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'sequence');
                    } else {
                        renderBodyJointAnswers($(jointAnswers).find('#human-body'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'sequence');
                        renderHandJointAnswers($(jointAnswers).find('#human-hand'), resultsData && resultsData.answers ? resultsData.answers : null, gesture.id, 'sequence');
                    }
                }
            }
        }



/*
 * tester view rendering
 */

PhysicalStressTest.prototype.renderTesterView = function () {
    console.log('render tester view:', PHYSICAL_STRESS_TEST.toUpperCase());

    var currentPhase = currentClass.options.currentPhase;
    var data = currentClass.options.currentPhaseData;
    var source = currentClass.options.source;
    var container = $(source).find('#' + currentPhase.format).clone(false).removeAttr('id');



    return container;
};