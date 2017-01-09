function renderData(data, hash) {
    var studyData = data.studyData;
    // general data view
    $('#study-headline').text(studyData.generalData.title);
    $('#type-survey').text(translation.surveyType[studyData.generalData.surveyType]);
    $('#type-phase').text(translation.phaseType[studyData.generalData.phase]);
    $('#study-description .address').text(translation.description);
    $('#study-description .text').text(studyData.generalData.description);
    console.log(studyData);

    if (studyData.generalData.panelSurvey === 'yes') {
        $('#panel-survey, .panel-survey').removeClass('hidden');
        $('.panel-survey .address').text(translation.panelSurvey + ":");
        var ageFrom = studyData.generalData.ageRange.split(',')[0];
        var ageTo = studyData.generalData.ageRange.split(',')[1];
        if (studyData.generalData.gender !== undefined) {
            $('.panel-survey .text').text(translation.genderTypes[studyData.generalData.gender] + " " + translation.of + " " + ageFrom + " " + translation.to + " " + ageTo);
        } else {
            $('.panel-survey .text').text(translation.incompleteData);
        }
    }


    // date range view
    var now = new Date().getTime();
    var dateFrom = studyData.generalData.dateFrom * 1000;
    var dateTo = addDays(studyData.generalData.dateTo * 1000, 1);
    var totalDays = rangeDays(dateFrom, dateTo);
    if ((studyData.generalData.dateFrom !== null && studyData.generalData.dateFrom !== "") &&
            (studyData.generalData.dateTo !== null && studyData.generalData.dateTo !== "")) {
        $('.study-plan').find('.address').text(now > dateTo ? translation.studyRuns : translation.studyRun + " " + translation.from + ":");
        $('.study-plan').find('.text').text(new Date(dateFrom).toLocaleDateString() + " " + translation.to + " " + new Date(dateTo).toLocaleDateString() + ", " + totalDays + " " + (totalDays === 1 ? translation.day : translation.days));
        $('.study-plan').removeClass('hidden');
        getStudyResults({studyId: data.id}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                if (now > dateFrom && result.studyResults && result.studyResults.length > 0) { // check either if there are study results
                    //                                $('#btn-edit-study, #btn-delete-study').remove();
                    renderStudyParticipants(result.studyResults, hash);
                } else {
                    appendAlert($('#study-participants'), ALERT_NO_PHASE_DATA);
                }
            }
        });
    } else {
        appendAlert($('#study-participants'), ALERT_NO_PLAN);
        $('#study-range-days .text').text('0 ' + translation.days);
        $('.study-no-plan').removeClass('hidden').find('.text').text(translation.studyNoPlan);
    }

    if (studyData.phases && studyData.phases.length > 0 &&
            (studyData.generalData.dateFrom !== null && studyData.generalData.dateFrom !== "") &&
            (studyData.generalData.dateTo !== null && studyData.generalData.dateTo !== "")) {

        // url copy clipboard view
        var absoluteStaticStudyUrl = 'https://gesturenote.de/study-prepare.php?studyId=' + data.id + '&h=' + data.urlToken;
        var relativeStaticStudyUrl = 'study-prepare.php?studyId=' + data.id + '&h=' + data.urlToken;
        $('#static-study-url').val(absoluteStaticStudyUrl);
        $('#static-study-url').click(function () {
            $('#static-study-url').select();
        });
        // prepare study
        if (studyData.generalData.surveyType === TYPE_SURVEY_MODERATED &&
                now > dateFrom && now < dateTo) {
            $('#btn-prepare-study, #btn-open-static-study-url').on('click', {url: relativeStaticStudyUrl}, function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    goto(event.data.url);
                }
            });
        } else {
            $('#btn-prepare-study').remove();
            $('#btn-open-static-study-url').parent().remove();
        }
    } else {
        $('#copy-to-clipboard').remove();
        $('#btn-prepare-study').remove();
    }


    // phase view
    $('#study-phases .address').text(translation.phases);
    if (studyData.phases && studyData.phases.length > 0) {
        for (var i = 0; i < studyData.phases.length; i++) {
            var step = document.createElement('div');
            $(step).addClass('study-phase-step');
            $('#phase-steps-container').append(step);
            var iconContainer = document.createElement('div');
            $(iconContainer).addClass('study-phase-icon-container');
            $(step).append(iconContainer);
            var colorIcon = document.createElement('i');
            $(colorIcon).addClass('study-phase-step-color-icon fa fa-circle');
            $(colorIcon).css({color: studyData.phases[i].color});
            $(iconContainer).append(colorIcon);
            var icon = document.createElement('i');
            $(icon).addClass('study-phase-step-icon fa fa-circle-thin');
            $(iconContainer).append(icon);
            var iconMiddle = document.createElement('span');
            $(iconMiddle).addClass((i > 8) ? 'study-phase-step-middle-icon-small' : 'study-phase-step-middle-icon');
            $(iconMiddle).text(i + 1);
            $(iconContainer).append(iconMiddle);
            var text = document.createElement('span');
            $(text).addClass('text');
            $(text).text(translation.formats[studyData.phases[i].format].text);
            $(step).append(text);
            if (i < studyData.phases.length - 1) {
                var transition = document.createElement('i');
                $(transition).addClass('study-phase-step-transition fa fa-long-arrow-down');
                $('#phase-steps-container').append(transition);
                TweenMax.from($(transition), .2, {delay: (i * .05), y: -10, opacity: 0.0, clearProps: 'all'});
            }
            TweenMax.from($(step), .3, {delay: 0.2 + (i * .05), y: -10, opacity: 0, clearProps: 'all'});
        }
    } else {
        appendAlert($('#main-content'), ALERT_NO_PHASE_DATA);
        $('#btn-preview-study').addClass('disabled');
    }

    $('#btn-edit-study').on('click', {studyId: data.id}, function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            goto("study-create.php?studyId=" + event.data.studyId + "&h=" + hash);
        }
    });
    $('#btn-preview-study').on('click', {studyId: data.id}, function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            goto("study-preview.php?studyId=" + event.data.studyId + "&h=" + hash);
        }
    });
    $('#btn-delete-study').on('click', {studyId: data.id}, function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            deleteStudy({studyId: event.data.studyId}, function (result) {
                if (result.status === RESULT_SUCCESS) {
                    gotoStudies();
                } else {

                }
            });
        }
    });

    // catalogs view
    // check if there are study catalog data
    var studyGestures = data.gestureCatalog;
    var studyFeedback = studyData.assembledFeedback;
    var studyScenes = studyData.assembledScenes;
    var studyTrigger = studyData.assembledTrigger;
    var noCatalogData = true;
    if (studyGestures && studyGestures.length > 0) {
        setLocalItem(GESTURE_CATALOG, studyGestures);
        renderStudyGestures(studyGestures);
        noCatalogData = false;
    }
    if (studyScenes && studyScenes.length > 0) {
        renderStudyScenes(studyScenes);
        noCatalogData = false;
    }
    if (studyTrigger && studyTrigger.length > 0) {
        renderStudyTrigger(studyTrigger);
        noCatalogData = false;
    }
    if (studyFeedback && studyFeedback.length > 0) {
        renderStudyFeedback(studyFeedback);
        noCatalogData = false;
    }

    if (noCatalogData) {
        appendAlert($('#study-catalogs'), ALERT_NO_PHASE_DATA);
    }


    // gesture/trigger extraction view
    if (studyData.generalData.phase === TYPE_PHASE_ELICITATION) {
        $('#extraction').removeClass('hidden');
        var trigger = false;
        var gestures = false;
        //                    console.log(data.studyData.phases);
        for (var i = 0; i < data.studyData.phases.length; i++) {
            if (data.studyData.phases[i].format === IDENTIFICATION) {
                var phaseData = getLocalItem(data.studyData.phases[i].id + '.data');
                console.log(phaseData);
                if (phaseData.identificationFor === 'gestures') {
                    gestures = true;
                } else {
                    trigger = true;
                }
            }
        }

        console.log('getExtractionData', gestures, trigger);
        getExtractionData({studyId: data.id}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                if (gestures && !trigger && result.elicitedGestures && result.elicitedGestures.length > 0) {
                    console.log('result classification', result.classification);
                    setLocalItem(ELICITED_GESTURES, result.elicitedGestures);
                    if (result.classification && result.classification.data) {
                        setLocalItem(CLASSIFICATION, result.classification.data);
                    } else {
                        setLocalItem(CLASSIFICATION, null);
                    }

                }
                renderExtraction();
            }
        });
    }

    $('#tab-pane li a').on('click', function (event) {
        event.preventDefault();
        $(this).trigger('change', [$(this).closest('li').attr('id')]);
    });
    $('#tab-pane').on('change', function (event, activeId) {
        event.preventDefault();
        window.location.hash = activeId;
        TweenMax.from($('#main-content'), .2, {y: -10, opacity: 0.0, clearProps: 'all'});
    });
    var status = window.location.hash.substr(1);
    if (status !== '') {
        $('#tab-pane').find('#' + status + " a").click();
    } else {
        $('#tab-pane').find('#general a').click();
    }
}

function renderStudyGestures(gestures) {
    $('#study-gestures-catalog').removeClass('hidden');
    $('#study-gestures-catalog .address').text(translation.studyCatalogs.gestures);
    for (var i = 0; i < gestures.length; i++) {
        var item = getGestureCatalogListThumbnail(gestures[i]);
        $('#study-gestures-catalog .list-container').append(item);
        TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
    }
}

function renderStudyScenes(scenes) {
    $('#study-scenes-catalog').removeClass('hidden');
    $('#study-scenes-catalog .address').text(translation.studyCatalogs.scenes);
    setLocalItem(ASSEMBLED_SCENES, scenes);
    for (var i = 0; i < scenes.length; i++) {
        var item = $('#template-study-container').find('#scenes-catalog-thumbnail').clone().removeAttr('id');
        item.find('.text').text(scenes[i].title);
        item.find('.label-text').text(translation.sceneTypes[scenes[i].type]);
        item.find('#' + scenes[i].type).removeClass('hidden');
        $('#study-scenes-catalog .list-container').append(item);
        TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
        $(item).find('#btn-preview-scene').click({sceneId: scenes[i].id}, function (event) {
            event.preventDefault();
            currentSceneId = event.data.sceneId;
            loadHTMLintoModal('custom-modal', 'modal-scene.php', 'modal-lg');
        });
    }
}

function renderStudyTrigger(trigger) {
    $('#study-trigger-catalog').removeClass('hidden');
    $('#study-trigger-catalog .address').text(translation.studyCatalogs.trigger);
    for (var i = 0; i < trigger.length; i++) {
        var item = $('#template-study-container').find('#trigger-catalog-thumbnail').clone().removeAttr('id');
        item.text(trigger[i].title);
        $('#study-trigger-catalog .list-container').append(item);
        TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
    }
}

function renderStudyFeedback(feedback) {
    //                console.log(feedback);

    $('#study-feedback-catalog').removeClass('hidden');
    $('#study-feedback-catalog .address').text(translation.studyCatalogs.feedback);
    for (var i = 0; i < feedback.length; i++) {
        var item = $('#template-study-container').find('#feedback-catalog-thumbnail').clone().removeAttr('id');
        item.find('.text').text(feedback[i].title);
        item.find('#' + feedback[i].type).removeClass('hidden');
        if (feedback[i].type === TYPE_FEEDBACK_SOUND) {
            item.find('.audio-holder').attr('src', feedback[i].data);
        }
        $('#study-feedback-catalog .list-container').append(item);
        TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
    }
}


function renderStudyParticipants(data, hash) {
    var guestUsers = 0;
    var registeredUsers = 0;
    var successfullStudies = 0;
    for (var i = 0; i < data.length; i++) {
        var result = data[i].data;
        var item = $('#template-study-container').find('#participant-thumbnail').clone().removeAttr('id');
        $(item).find('.panel-heading').text(convertSQLTimestampToDate(data[i].created).toUTCString());
        //                    console.log($(item).find('.panel-heading').text('test'));
        $('#study-participants .list-container').append(item);
        if (isNaN(data[i].userId)) {
            guestUsers++;
            $(item).find('#user .label-text').text(translation.userTypes.guest);
        } else {
            registeredUsers++;
            $(item).find('#user .label-text').text(translation.userTypes.registered);
        }

        if (result.aborted === 'no' && result.studySuccessfull === 'no') {
            successfullStudies++;
            $(item).find('.panel').addClass('panel-success');
            $(item).find('#execution-success').removeClass('hidden');
            $(item).find('#execution-success .label-text').text(translation.studySuccessful);
        }
//                    else if (result.aborted === 'no' && result.studySuccessfull === 'yes') {
//                        $(item).find('.panel').addClass('panel-warning');
//                        $(item).find('#execution-error').removeClass('hidden');
//                        $(item).find('#execution-error .label-text').text(translation.studyFault);
//                    }
        else {
            $(item).find('.panel').addClass('panel-danger');
            $(item).find('#execution-fault').removeClass('hidden');
            $(item).find('#execution-fault .label-text').text(translation.studyFault);
        }

        $(item).find('.panel').on('click', {studyId: data[i].studyId, participantId: data[i].userId}, function (event) {
            event.preventDefault();
            clearLocalItems();
            goto('study-participant.php?studyId=' + event.data.studyId + '&participantId=' + event.data.participantId + '&h=' + hash);
        });
    }

    console.log('guests: ' + guestUsers + ', registered: ' + registeredUsers + ', success: ' + successfullStudies);
}


function renderExtraction() {
    var elicitedGestures = getLocalItem(ELICITED_GESTURES);
    if (elicitedGestures && elicitedGestures.length > 0)
    {
        checkClassificationType();
    } else {
        appendAlert($('#gesture-extraction'), ALERT_NO_PHASE_DATA);
        $('#extraction-content').addClass('hidden');
    }

    $('#btn-all-gestures').click();
}

$(document).on('click', '#extraction-navigation button', function (event) {
    event.preventDefault();
    if (!$(this).hasClass('active') && !$(this).hasClass('disabled')) {
        $(this).closest('#extraction-navigation').find('button').removeClass('active');
        $(this).addClass('active');
        var selectedId = $(this).attr('id');
        renderExtractionContent(selectedId);
        $("html, body").animate({scrollTop: 0}, 100);
        $('#extraction-navigation-content').children().addClass('hidden');
        var activeContent = $('#extraction-navigation-content').find('#content-' + selectedId);
        activeContent.removeClass('hidden');
        TweenMax.from(activeContent, .2, {y: -20, opacity: 0, clearProps: 'all'});
    }
});

function checkClassificationType() {
    var unclassifiedGestures = getUnclassifiedGestures();
    if (unclassifiedGestures && unclassifiedGestures.length === 0) {
        var classificationData = getLocalItem(CLASSIFICATION);
        console.log('there are no gestures for classification, but there are classified gestures', classificationData);
        if (classificationData.type === 'appearanceTrigger') {
            $('#extraction-navigation #btn-amount').removeClass('disabled');
            $('#extraction-navigation #btn-guessability').removeClass('disabled');
            $('#extraction-navigation #btn-cognitive-relationships').removeClass('disabled');
            $('#extraction-navigation #btn-checklist').removeClass('disabled');
            $('#extraction-navigation #btn-arrange').removeClass('disabled');
        } else {

        }
    } else {
        $('#extraction-navigation #btn-amount').addClass('disabled');
        $('#extraction-navigation #btn-guessability').addClass('disabled');
        $('#extraction-navigation #btn-cognitive-relationships').addClass('disabled');
        $('#extraction-navigation #btn-checklist').addClass('disabled');
        $('#extraction-navigation #btn-arrange').addClass('disabled');
    }
}

function renderExtractionContent(id) {
    switch (id) {
        case 'btn-all-gestures':
            renderAllGestures();
            break;
        case 'btn-gesture-classification':
            renderGestureClassification();
            break;
        case 'btn-amount':
            renderAmount();
            break;
        case 'btn-guessability':
            renderGuessability();
            break;
        case 'btn-cognitive-relationships':
            renderCognitiveRelationships();
            break;
        case 'btn-preferred-gestures':
            break;
        case 'btn-checklist':
            renderChecklist();
            break;
        case 'btn-arrange':
            renderArrangement();
            break;
    }
}

function renderAllGestures() {
    $('#content-btn-all-gestures').empty();
    var gestures = getLocalItem(ELICITED_GESTURES);
    var trigger = getLocalItem(ASSEMBLED_TRIGGER);
    if (trigger && trigger.length > 0 && gestures && gestures.length > 0) {
        for (var i = 0; i < trigger.length; i++) {
            var triggerTitle = document.createElement('div');
//                        var headlineText = document.createElement('span');
            $(triggerTitle).addClass('text');
//                        $(triggerTitle).css({margin: '0px', float: 'left'});
            $(triggerTitle).text(translation.trigger + ": " + trigger[i].title);
            $('#content-btn-all-gestures').append(triggerTitle);
            var container = document.createElement('div');
            $(container).addClass('container-root row root');
            $(container).attr('id', 'gestures-list-container');
            $(container).css({marginTop: '20px', marginBottom: '30px'});
            $('#content-btn-all-gestures').append(container);
            var gestureCount = 0;
            for (var j = 0; j < gestures.length; j++) {
                var gesture = gestures[j];
                if (parseInt(trigger[i].id) === parseInt(gesture.triggerId)) {
                    var clone = getGestureCatalogListThumbnail(gestures[j], 'col-xs-6 col-sm-6 col-md-4', ELICITED_GESTURES);
                    $(container).append(clone);
                    TweenMax.from(clone, .2, {delay: j * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                    gestureCount++;
                }
            }

            var countText = document.createElement('span');
            $(countText).addClass('badge');
            $(countText).css({marginLeft: '6px'});
            $(countText).text(gestureCount === 1 ? gestureCount + " " + translation.gesture : gestureCount + " " + translation.gestures);
            $(triggerTitle).append(countText);
        }
    } else {
        // append alert
    }
}

var gesturesLeft = null;
var gesturesLeftIndex = 0;
var gesturesRight = null;
var gesturesRightIndex = 0;
function renderGestureClassification() {
    gesturesLeftIndex = 0;
    gesturesRightIndex = 0;
    var classification = getLocalItem(CLASSIFICATION);
    var elicitedGestures = getLocalItem(ELICITED_GESTURES);
    console.log("classification: ", classification, "elicited gestures: ", elicitedGestures);
    if (elicitedGestures && elicitedGestures.length > 0) {
        if (classification && classification.assignments && classification.assignments.length > 0) {
            // check classified gestures and render them. gesturesLeft must be the matched unclassified gestures
            console.log('there is classification data');
            $('#btn-reclassify-gestures').removeClass('disabled');
            $('#gesture-classification-parameters').addClass('hidden');
            gesturesLeft = getUnclassifiedGestures();
            gesturesRight = classification.assignments;
            if (gesturesLeft && gesturesLeft.length > 0) {
                $('#gesture-classification').removeClass('hidden');
                updateMatchingView();
            } else {
                appendAlert($('#content-btn-gesture-classification'), ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION);
            }
            renderClassifiedGestures();
        } else {
            appendAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
            console.log('there is NO classification data');
            $('#gesture-classification-parameters').removeClass('hidden');
            $('#gesture-classification').addClass('hidden');

            $('#classification-type').on('change', function (event) {
                event.preventDefault();
                $('#btn-start-classification').removeClass('disabled');
            });

            $('#btn-help-classification').on('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'modal-classification.php', 'modal-lg');
            });

            $('#btn-start-classification').on('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $('#gesture-classification-parameters').addClass('hidden');
                    $('#gesture-classification').removeClass('hidden');
                    var checked = $('#classification-type').find('.btn-option-checked').attr('id');
                    classification = {type: checked};
                    setLocalItem(CLASSIFICATION, classification);
                    saveClassification();
                    gesturesRight = new Array();
                    gesturesRight.push({mainGestureId: elicitedGestures[0].id, gestures: [elicitedGestures[0]]});
                    gesturesLeft = elicitedGestures;
                    updateMatchingView();
                }
            });
        }
    } else {
        appendAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
    }

    $('#btn-reclassify-gestures').on('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('disabled');
            removeAlert($('#content-btn-gesture-classification'), ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION);
            setLocalItem(CLASSIFICATION, null);
            saveClassification();
            renderClassifiedGestures();
            renderGestureClassification();

        }
    });

    $('#btn-redo').on('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            reclassifiyGesture(gesturesLeft[gesturesLeftIndex - 1]);
            gesturesLeftIndex--;
            gesturesRightIndex = 0;

            if (gesturesRight.length === 0) {
                gesturesRight.push({mainGestureId: elicitedGestures[0].id, gestures: [elicitedGestures[0]]});
            }
            saveClassification();
            updateMatchingView();
        }
    });
}

function updateMatchingView() {
    if (gesturesLeftIndex < gesturesLeft.length) {

        if (gesturesLeftIndex > 0) {
            $('#btn-redo').removeClass('disabled');
        } else {
            $('#btn-redo').addClass('disabled');
        }

        var leftGesture = gesturesLeft[gesturesLeftIndex];
        console.log("update matching view", leftGesture, gesturesRight, gesturesRightIndex);
        var rightGesture = getGestureById(gesturesRight[gesturesRightIndex].mainGestureId, ELICITED_GESTURES);

        var leftItem = getGestureCatalogListThumbnail(leftGesture, 'col-xs-12', ELICITED_GESTURES);
        var rightItem = getGestureCatalogListThumbnail(rightGesture, 'col-xs-12', ELICITED_GESTURES);
        $('#gesture-left').empty().append(leftItem);
        $('#gesture-right').empty().append(rightItem);
        renderClassifiedGestures();
        TweenMax.from($('#match-controls'), .3, {opacity: 0, scaleX: 0.5, scaleY: 0.5, clearProps: 'all'});
    }
}

function getClassifiedGestures() {
    var classification = getLocalItem(CLASSIFICATION).assignments;
    var array = new Array();
    if (classification) {
        for (var i = 0; i < classification.length; i++) {
            array.push(classification[i].mainGesture);
        }
        return array;
    }
    return null;
}

function getUnclassifiedGestures() {
    var elicitedGestures = getLocalItem(ELICITED_GESTURES);
    var classification = getLocalItem(CLASSIFICATION);
    var array = new Array();
    if (classification && classification.assignments) {
        var assignments = classification.assignments;
        for (var i = 0; i < elicitedGestures.length; i++) {
            var gestureIsClassified = false;
            for (var j = 0; j < assignments.length; j++) {
                for (var k = 0; k < assignments[j].gestures.length; k++) {
                    if (parseInt(assignments[j].gestures[k]) === parseInt(elicitedGestures[i].id)) {
//                                    console.log('this gesture is classified', elicitedGestures[i].id);
                        gestureIsClassified = true;
                        break;
                    } else if (j === assignments.length - 1 && k === assignments[j].gestures.length - 1) {
//                                    console.log('this gesture is not classified', elicitedGestures[i].id);
                        array.push(elicitedGestures[i]);
                    }
                }

                if (gestureIsClassified) {
                    break;
                }
            }
        }
        console.log(array);
        return array;
    }

    return null;
}

function renderClassifiedGestures() {
    var classification = getLocalItem(CLASSIFICATION);
    $('#classified-gestures').empty();
    if (classification) {
        var assignments = classification.assignments;
        if (assignments && assignments.length > 0) {
            for (var i = 0; i < assignments.length; i++) {
                var row = document.createElement('div');
//                        $(row).addClass('row');
//                        $('#classified-gestures').append(row);

                var mainGesture = getGestureById(assignments[i].mainGestureId, ELICITED_GESTURES);
                var trigger = getTriggerById(mainGesture.triggerId);
                var headline = document.createElement('h4');
                $('#classified-gestures').append(headline);
                if (classification.type === TYPE_CLASSIFICATION_APPEARANCE) {
                    $(headline).text('Geste ' + (i + 1));
                } else if (classification.type === TYPE_CLASSIFICATION_APPEARANCE_TRIGGER) {
                    $(headline).text('Funktion: ' + trigger.title + ', Geste ' + getClassifiedGestureIndex(mainGesture));
                }

                row = document.createElement('div');
                $(row).addClass('row');
                $('#classified-gestures').append(row);
                for (var j = 0; j < assignments[i].gestures.length; j++) {
                    var gestureThumbnail = getGestureCatalogListThumbnail(getGestureById(assignments[i].gestures[j], ELICITED_GESTURES), 'col-xs-6 col-sm-6 col-md-4', ELICITED_GESTURES);
                    $(row).append(gestureThumbnail);
                }
            }
        } else {
            appendAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
        }
    }
}

function getClassifiedGestureIndex(gesture) {
    var classification = getLocalItem(CLASSIFICATION).assignments;
    var count = 0;
    for (var i = 0; i < classification.length; i++) {
        var mainGesture = getGestureById(classification[i].mainGestureId, ELICITED_GESTURES);
        if (parseInt(mainGesture.triggerId) === parseInt(gesture.triggerId)) {
            count++;
        }

        if (parseInt(mainGesture.id) === parseInt(gesture.id)) {
            return count;
        }
    }
}

$(document).on('click', '#btn-gesture-yes', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var leftId = parseInt($('#gesture-left').children().attr('id'));
    var leftGesture = getGestureById(leftId, ELICITED_GESTURES);
    classifyGesture(leftGesture, true);
    gesturesLeftIndex++;
    gesturesRightIndex = 0;
    updateMatchingView();
    removeAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
});

$(document).on('click', '#btn-gesture-no', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var leftId = parseInt($('#gesture-left').children().attr('id'));
    var leftGesture = getGestureById(leftId, ELICITED_GESTURES);
    if (gesturesRightIndex < gesturesRight.length - 1) {
        gesturesRightIndex++;
    } else {
        classifyGesture(leftGesture, false);
        gesturesLeftIndex++;
        gesturesRightIndex = 0;
        removeAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
    }

    if (gesturesLeft.length > 0 && gesturesLeftIndex < gesturesLeft.length) {
        updateMatchingView();
    } else {
        checkClassificationType();
        renderClassifiedGestures();
        $('#gesture-classification').addClass('hidden');
        appendAlert($('#content-btn-gesture-classification'), ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION);

    }
});

function classifyGesture(gesture, foundMatch) {
    var classification = getLocalItem(CLASSIFICATION);
    if (foundMatch) {
        if (classification && classification.assignments && classification.assignments.length > 0) {
            var matchedSourceGesture = getGestureById(classification.assignments[gesturesRightIndex].gestures[0], ELICITED_GESTURES);
//                        console.log(classification.assignments[gesturesRightIndex].gestures[0]);

            if (classification.type === TYPE_CLASSIFICATION_APPEARANCE ||
                    (classification.type === TYPE_CLASSIFICATION_APPEARANCE_TRIGGER && parseInt(matchedSourceGesture.triggerId) === parseInt(gesture.triggerId)))
            {
                classification.assignments[gesturesRightIndex].gestures.push(gesture.id);
            } else {
                classification.assignments.push({mainGestureId: gesture.id, triggerId: gesture.triggerId, gestures: [gesture.id]});
            }
        } else {
            classification.assignments = [{mainGestureId: gesture.id, triggerId: gesture.triggerId, gestures: [gesture.id]}];
        }
    } else {
        if (classification && classification.assignments && classification.assignments.length > 0) {
            classification.assignments.push({mainGestureId: gesture.id, triggerId: gesture.triggerId, gestures: [gesture.id]});
        } else {
            classification.assignments = [{mainGestureId: gesture.id, triggerId: gesture.triggerId, gestures: [gesture.id]}];
        }
    }

    gesturesRight = classification.assignments;
    setLocalItem(CLASSIFICATION, classification);
    console.log(classification);
    saveClassification();
    $('#btn-reclassify-gestures').removeClass('disabled');
}

function reclassifiyGesture(gesture) {
    console.log('reclassify gesture:', gesture);
    var classification = getLocalItem(CLASSIFICATION);
    var assignments = classification.assignments;
    for (var i = 0; i < assignments.length; i++) {
        var gestures = assignments[i].gestures;
        for (var j = 0; j < gestures.length; j++) {
            if (parseInt(gestures[j]) === parseInt(gesture.id)) {
                if (gestures.length === 1) {
                    assignments.splice(i, 1);
                    break;
                } else {
                    gestures.splice(j, 1);
                    break;
                }
            }
        }
    }
    console.log(assignments);
    gesturesRight = assignments;
//                console.log(classification);
    setLocalItem(CLASSIFICATION, classification);
}

function saveClassification() {
    var classification = getLocalItem(CLASSIFICATION);
    var studyId = getLocalItem(STUDY).id;
    saveExtractionData({studyId: studyId, classification: classification}, function (result) {
        if (result.status === RESULT_SUCCESS) {
            console.log('classification saved');
        } else {
            console.log('save classification error');
        }
        checkClassificationType();
    });
}

function renderAmount() {
    var classification = getLocalItem(CLASSIFICATION);
    if (classification.type === 'appearanceTrigger') {
        $('#content-btn-amount').empty();
        var trigger = getLocalItem(ASSEMBLED_TRIGGER);
        for (var i = 0; i < trigger.length; i++) {
            var counter = 0;
            var container = $('#template-study-container').find('#amount-container-appearance-trigger').clone();
            container.find('#headline').text(translation.trigger + ': ' + trigger[i].title);
            $('#content-btn-amount').append(container);

            for (var j = 0; j < classification.assignments.length; j++) {
                var assignment = classification.assignments[j];

                if (parseInt(assignment.triggerId) === parseInt(trigger[i].id)) {
                    counter++;
                    
                    var appearanceTriggerGesture = $('#template-study-container').find('#appearance-trigger-gesture').clone();
                    appearanceTriggerGesture.find('#headline-main-gesture').text(translation.gesture + ' ' + counter);
                    container.find('#item-view').append(appearanceTriggerGesture);

                    var mainGesture = getGestureById(assignment.mainGestureId, ELICITED_GESTURES);
                    renderGestureImages(appearanceTriggerGesture.find('#main-gesture .previewGesture'), mainGesture.images, mainGesture.previewImage, null);

                    for (var k = 0; k < assignment.gestures.length; k++) {
                        var gesture = getGestureById(assignment.gestures[k], ELICITED_GESTURES);
                        var involvedGesture = getGestureCatalogListThumbnail(gesture, 'col-xs-6 col-md-4 col-lg-3', ELICITED_GESTURES, parseInt(assignment.mainGestureId) === parseInt(gesture.id) ? 'panel-info' : 'panel-default');
                        appearanceTriggerGesture.find('#gestures-list-container').append(involvedGesture);

                    }
                }
            }
        }
    } else if (classification.type === 'appearance') {

    }
}

function renderGuessability() {
    console.log('render Guessability');
}

function renderCognitiveRelationships() {
    console.log('render CognitiveRelationships');
}

function renderChecklist() {
    console.log('render Checklist');
}

function renderArrangement() {
    console.log('render Arrangement');
}