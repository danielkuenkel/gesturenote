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
        var ageFrom = studyData.generalData.ageRange.min;
        var ageTo = studyData.generalData.ageRange.max;
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
        $('#copy-to-clipboard #static-study-url').val(absoluteStaticStudyUrl);
        $('#copy-to-clipboard #static-study-url').click(function () {
            $('#copy-to-clipboard #static-study-url').select();
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
            $(colorIcon).css({color: '#337ab7'}); // studyData.phases[i].color // #5bb85c
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
            $(text).text(studyData.phases[i].title);
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

        if (result.aborted === 'no' && result.studySuccessfull === 'yes') {
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
    var query = getQueryParams(document.location.search);
    getGestureSetsForStudyId({studyId: query.studyId}, function (result) {
        if (result.status === RESULT_SUCCESS) {
            setLocalItem(GESTURE_SETS, result.gestureSets);

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
    });
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
        $('#extraction-navigation #btn-potential-gestures').removeClass('disabled');
        $('#extraction-navigation #btn-gesture-sets').removeClass('disabled');
    } else {
        $('#extraction-navigation #btn-potential-gestures').addClass('disabled');
        $('#extraction-navigation #btn-gesture-sets').addClass('disabled');
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
        case 'btn-checklist':
            renderChecklist();
            break;
        case 'btn-potential-gestures':
            renderPotentialGestures();
            break;
        case 'btn-gesture-sets':
            renderGestureSets();
            break;
    }

    addUpdateMainGestureButtonEvent();
}

function addUpdateMainGestureButtonEvent() {
    $('.btn-tag-as-main-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('btn-info')) {
            console.log('tag-as-main-gesture')
            var id = $(this).closest('.root').attr('id');
            $(this).closest('.root').closest('.panel').attr('id', id);
            $(this).closest('.root').closest('.panel').attr('name', id);
            $(this).closest('.root').parent().find('.panel').removeClass('panel-info').addClass('panel-default');
            $(this).closest('.root').parent().find('.btn-tag-as-main-gesture').removeClass('btn-info');
            $(this).closest('.root').find('.panel').addClass('panel-info');
            $(this).addClass('btn-info');
            updateMainGesture(id, $(this).closest('#item-view'));
        }
    });
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
                    var clone = getGestureCatalogListThumbnail(gestures[j], null, 'col-xs-6 col-lg-4', ELICITED_GESTURES);
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
            renderClassifiedGestures($('#classified-gestures'));
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
                    classification = {type: checked, checklist: {used: 'no', items: null}};
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

    $('#btn-reclassify-gestures').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('disabled');
            removeAlert($('#content-btn-gesture-classification'), ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION);
            setLocalItem(CLASSIFICATION, null);
            saveClassification();
            clearGestureSets();
            renderClassifiedGestures($('#classified-gestures'));
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
//        console.log("update matching view", leftGesture, gesturesRight, gesturesRightIndex);
        var rightGesture = getGestureById(gesturesRight[gesturesRightIndex].mainGestureId, ELICITED_GESTURES);

        var leftItem = getGestureCatalogListThumbnail(leftGesture, 'gestures-catalog-thumbnail', 'col-xs-12', ELICITED_GESTURES);
        var rightItem = getGestureCatalogListThumbnail(rightGesture, 'gestures-catalog-thumbnail', 'col-xs-12', ELICITED_GESTURES);
        $('#gesture-left').empty().append(leftItem);
        $('#gesture-right').empty().append(rightItem);
        renderClassifiedGestures($('#classified-gestures'));
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
//        console.log(array);
        return array;
    }

    return null;
}

function renderClassifiedGestures(target, type) {
    var classification = getLocalItem(CLASSIFICATION);
    $(target).empty();

    if (classification) {
        if (classification.assignments && classification.assignments.length > 0) {

            if (classification.type === TYPE_CLASSIFICATION_APPEARANCE_TRIGGER) {
                var trigger = getLocalItem(ASSEMBLED_TRIGGER);
                for (var i = 0; i < trigger.length; i++) {
                    var counter = 0;
                    var container = $('#template-study-container').find('#amount-container-appearance-trigger').clone();
                    TweenMax.from(container, .2, {delay: .2 + (i * .1), opacity: 0, y: -20});
                    $(target).append(container);

                    container.find('#headline .text').text(translation.gesturesForTrigger + ': ' + trigger[i].title);

                    for (var j = 0; j < classification.assignments.length; j++) {
                        var assignment = classification.assignments[j];

                        if (parseInt(assignment.triggerId) === parseInt(trigger[i].id)) {

                            counter++;
                            container.find('#headline .badge').text(counter);

                            var appearanceTriggerGesture = $('#template-study-container').find('#appearance-trigger-gesture').clone().removeAttr('id');
                            appearanceTriggerGesture.attr('id', assignment.mainGestureId);
                            appearanceTriggerGesture.find('#headline-main-gesture').text(translation.gesture + ' ' + counter);
                            appearanceTriggerGesture.attr('name', assignment.mainGestureId);
                            container.find('#item-view').append(appearanceTriggerGesture);

                            var mainGesture = getGestureById(assignment.mainGestureId, ELICITED_GESTURES);
                            renderGestureImages(appearanceTriggerGesture.find('#main-gesture .previewGesture'), mainGesture.images, mainGesture.previewImage, null);

                            for (var k = 0; k < assignment.gestures.length; k++) {
                                var gesture = getGestureById(assignment.gestures[k], ELICITED_GESTURES);
                                var gestureType = 'classified-gestures-catalog-thumbnail';
//                                if (type === POTENTIAL_GESTURES) {
//                                    gestureType = 'gestures-catalog-thumbnail';
//                                }
                                var involvedGesture = getGestureCatalogListThumbnail(gesture, gestureType, 'col-xs-6 col-lg-4', ELICITED_GESTURES);
                                appearanceTriggerGesture.find('#gestures-list-container').append(involvedGesture);

                                if (parseInt(assignment.mainGestureId) === parseInt(gesture.id)) {
                                    $(involvedGesture).find('.panel').addClass('panel-info');
                                    $(involvedGesture).find('.btn-tag-as-main-gesture').addClass('btn-info');
                                }
                            }

                            if (type === POTENTIAL_GESTURES) {
                                renderPotentialGesturesParameters(appearanceTriggerGesture, assignment);
                            }
                        }
                    }
                }
            } else if (classification.type === TYPE_CLASSIFICATION_APPEARANCE) {
                for (var j = 0; j < classification.assignments.length; j++) {
                    var container = $('#template-study-container').find('#amount-container-appearance-trigger').clone();
                    TweenMax.from(container, .2, {delay: .2 + (i * .1), opacity: 0, y: -20});
                    $(target).append(container);

                    var assignment = classification.assignments[j];
//                    container.find('#headline .badge').text(j);
                    var appearanceTriggerGesture = $('#template-study-container').find('#appearance-trigger-gesture').clone().removeAttr('id');
                    appearanceTriggerGesture.attr('id', assignment.mainGestureId);
                    appearanceTriggerGesture.find('#headline-main-gesture').text(translation.gesture + ' ' + (j + 1));
                    appearanceTriggerGesture.attr('name', assignment.mainGestureId);
                    container.find('#item-view').append(appearanceTriggerGesture);

                    var mainGesture = getGestureById(assignment.mainGestureId, ELICITED_GESTURES);
                    renderGestureImages(appearanceTriggerGesture.find('#main-gesture .previewGesture'), mainGesture.images, mainGesture.previewImage, null);

                    for (var k = 0; k < assignment.gestures.length; k++) {
                        var gesture = getGestureById(assignment.gestures[k], ELICITED_GESTURES);
                        var involvedGesture = getGestureCatalogListThumbnail(gesture, 'classified-gestures-catalog-thumbnail', 'col-xs-6 col-lg-4', ELICITED_GESTURES);
                        appearanceTriggerGesture.find('#gestures-list-container').append(involvedGesture);

                        if (parseInt(assignment.mainGestureId) === parseInt(gesture.id)) {
                            $(involvedGesture).find('.panel').addClass('panel-info');
                            $(involvedGesture).find('.btn-tag-as-main-gesture').addClass('btn-info');
                        }
                    }

                    if (type === POTENTIAL_GESTURES) {
                        renderPotentialGesturesParameters(appearanceTriggerGesture, assignment);
                    }
                }
            }
        } else {
            appendAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
        }
    }

    addUpdateMainGestureButtonEvent();
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
        renderClassifiedGestures($('#classified-gestures'));
        $('#gesture-classification').addClass('hidden');
        appendAlert($('#content-btn-gesture-classification'), ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION);

    }
});

function classifyGesture(gesture, foundMatch) {
    var classification = getLocalItem(CLASSIFICATION);
    if (foundMatch) {
        if (classification && classification.assignments && classification.assignments.length > 0) {
            var matchedSourceGesture = getGestureById(classification.assignments[gesturesRightIndex].mainGestureId, ELICITED_GESTURES);
            if (classification.type === TYPE_CLASSIFICATION_APPEARANCE ||
                    (classification.type === TYPE_CLASSIFICATION_APPEARANCE_TRIGGER && parseInt(matchedSourceGesture.triggerId) === parseInt(gesture.triggerId)))
            {
                classification.assignments[gesturesRightIndex].gestures.push(gesture.id);
            } else {
                classification.assignments.push({mainGestureId: gesture.id, triggerId: gesture.triggerId, sameAs: matchedSourceGesture.id, gestures: [gesture.id]});
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
//    console.log(classification);
    saveClassification();
    $('#btn-reclassify-gestures').removeClass('disabled');
}

function reclassifiyGesture(gesture) {
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
    gesturesRight = assignments;
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

function renderChecklist() {
    var classification = getLocalItem(CLASSIFICATION);
    var predefinedItems = translation.extractionChecklistItems;
//    console.log(predefinedItems, classification);
    if (classification && classification.checklist && classification.checklist.items !== '' && classification.checklist.items !== null) {
        predefinedItems = classification.checklist.items;
        $('#use-checklist-switch').find('#' + classification.checklist.used).click();
//        console.log('use saved checklist items', classification.checklist.items !== '');
    } else {
        if (!classification) {
            classification = {};
        }
//        console.log('set checklist items to predefined items');
        classification.checklist = {used: 'no', items: predefinedItems};
        setLocalItem(CLASSIFICATION, classification);
    }

    var listContainer = $('#checklist-container').empty();
    for (var i = 0; i < predefinedItems.length; i++) {
//        console.log(listContainer, predefinedItems[i]);
        renderFormatItem(listContainer, predefinedItems[i]);
        updateBadges(listContainer, predefinedItems[i].format);
    }
    checkCurrentListState(listContainer);

    $('#use-checklist-switch').unbind('change').bind('change', function (event, activeId) {
        event.preventDefault();
        var classification = getLocalItem(CLASSIFICATION);
        classification.checklist.used = activeId;
        saveChecklist(classification, activeId === 'yes');
    });

    $(listContainer).unbind('change').bind('change', function (event) {
        event.preventDefault();
        var activeId = $('#use-checklist-switch').find('.active').attr('id');
//        console.log('checklist has changed');
        saveChecklist(getLocalItem(CLASSIFICATION), activeId === 'yes');
    });

    function saveChecklist(classification, saveItems) {
        if (saveItems === true) {
            var questionnaire = new Array();
            var itemList = listContainer.children();
            for (var i = 0; i < itemList.length; i++) {
                questionnaire.push(getFormatData(itemList[i]));
            }

            classification.checklist.items = questionnaire;
        } else {
            classification.checklist.items = null;
        }

        setLocalItem(CLASSIFICATION, classification);
        saveClassification();
    }
}

function renderPotentialGestures() {
    $('#content-btn-potential-gestures').empty();
    renderClassifiedGestures($('#content-btn-potential-gestures'), POTENTIAL_GESTURES);
}

function renderGestureSets() {
    $('#content-btn-gesture-sets #gesture-sets-container').empty();

    var query = getQueryParams(document.location.search);
    getGestureSetsForStudyId({studyId: query.studyId}, function (result) {
        if (result.status === RESULT_SUCCESS) {
            setLocalItem(GESTURE_SETS, result.gestureSets);

            if (result.gestureSets && result.gestureSets.length > 0) {
                for (var i = 0; i < result.gestureSets.length; i++) {
                    var set = result.gestureSets[i];
                    var setPanel = $('#panel-gesture-set').clone().removeAttr('id');
                    $(setPanel).find('.panel-heading .panel-heading-text').text(set.title);
                    $('#content-btn-gesture-sets #gesture-sets-container').append(setPanel);
                    TweenMax.from(setPanel, .2, {delay: i * .1, opacity: 0, y: -20});

//                console.log(result.gestureSets[i].gestures)
                    if (set.gestures !== null) {
                        for (var j = 0; j < set.gestures.length; j++) {
                            var gesture = getGestureById(set.gestures[j], ELICITED_GESTURES);
                            var gestureThumbnail = getGestureCatalogListThumbnail(gesture, 'gestures-catalog-thumbnail', 'col-xs-6 col-lg-4', ELICITED_GESTURES);
                            $(setPanel).find('#gestures-list-container').append(gestureThumbnail);
                        }
                    } else {
                        //append alert
                    }

                    $(setPanel).find('#btn-delete-gesture-set').unbind('click').bind('click', {setId: set.id}, function (event) {
                        event.preventDefault();
                        deleteGestureSet({setId: event.data.setId}, function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                renderGestureSets();
                            } else {
                                // append alert
                            }
                        });
                    });
                }
            } else {
                // append alert, no gesture set(s) available
            }
        }
    });

    $('#btn-add-gesture-set').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var title = $('#content-btn-gesture-sets').find('#input-new-set-title').val();
        if (title && title !== undefined && title.trim() !== '') {
            if (title.trim().length > 7) {
                var query = getQueryParams(document.location.search);
                saveGestureSetForStudyId({studyId: query.studyId, title: title}, function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        $('#content-btn-gesture-sets').find('#input-new-set-title').val('');
                        renderGestureSets();
                    }
                });
            } else {
                appendAlert($('#content-btn-gesture-sets'), ALERT_GESTURE_SET_TITLE_TOO_SHORT);
            }
        } else {
            // show errors for invalid input 
        }
    });
}

var currentAssignment = null;
function renderPotentialGesturesParameters(target, assignment) {

    var classification = getLocalItem(CLASSIFICATION);
    if (classification.type === TYPE_CLASSIFICATION_APPEARANCE_TRIGGER) {
        $(target).find('#potential-parameters').empty().append($('#potential-gesture-parameters-appearance-trigger').clone());

        // amount
        var triggerId = assignment.triggerId;
        var amountRange = getAmountRange(triggerId);
        $(target).find('#parameters-amount #justification').text(translation.Minimal + ': ' + amountRange.min + ', ' + translation.maximal + ': ' + amountRange.max + ', ' + assignment.gestures.length + ' ' + (assignment.gestures.length === 1 ? translation.classifiedGesture : translation.classifiedGestures));

        if (amountRange.max > amountRange.min) {
            if (assignment.gestures.length === amountRange.max) {
                target.find('#parameters-amount #well').removeClass('hidden');
            } else if (assignment.gestures.length === amountRange.min) {
                target.find('#parameters-amount #less-well').removeClass('hidden');
            } else {
                target.find('#parameters-amount #even').removeClass('hidden');
            }
        } else {
            // can't found best gesture for these trigger, because every gesture are demonstrated the same amount
        }

        // agreement measures
        if (amountRange.max > 1) {
            var agreementMeasures = getAgreementMeasures(assignment, TYPE_CLASSIFICATION_APPEARANCE_TRIGGER);
            console.log('agreementMeasures', agreementMeasures);
            if (agreementMeasures) {
                $(target).find('#agreement .text').text(agreementMeasures + '%');
            } else {
                $(target).find('#agreement .text').text('Konnte nicht berechnet werden, da diese Geste nur einmal vorkommt.');
            }
        }

        // guessability / accordance
        var accordance = getAccordance(triggerId).toFixed(2);
        $(target).find('#parameters-guessability').removeClass('hidden');
        $(target).find('#accordance .text').text(accordance);
//        console.log('accordance: ', accordance);


    } else if (classification.type === TYPE_CLASSIFICATION_APPEARANCE) {
        $(target).find('#potential-parameters').empty().append($('#potential-gesture-parameters-appearance').clone());

        // amount
        var trigger = getLocalItem(ASSEMBLED_TRIGGER);
        var usedTrigger = new Array();
        for (var i = 0; i < trigger.length; i++) {
            for (var j = 0; j < assignment.gestures.length; j++) {
                var gesture = getGestureById(assignment.gestures[j], ELICITED_GESTURES);
                if (parseInt(gesture.triggerId) === parseInt(trigger[i].id)) {
                    usedTrigger.push(trigger[i].id);
                }
            }
        }
        usedTrigger = unique(usedTrigger);
//        console.log(usedTrigger);

        for (var i = 0; i < usedTrigger.length; i++) {
            trigger = getTriggerById(usedTrigger[i]);
//            
//            console.log(amountRange);
            var item = $('#potential-gesture-parameters-appearance-trigger-amount-item').clone().removeAttr('id');
            $(item).find('#trigger-title').text(trigger.title);
            $(target).find('#potential-parameters #parameters-amount #trigger-container').append(item);

            if (i > 0) {
                $(item).css({marginTop: '10px'});
            }

            var count = 0;
            for (var j = 0; j < assignment.gestures.length; j++) {
                var gesture = getGestureById(assignment.gestures[j], ELICITED_GESTURES);
                if (parseInt(gesture.triggerId) === parseInt(trigger.id)) {
                    count++;
                }
            }
//            var amountRange = getAmountRange(trigger.id);
            $(item).find('#justification').text(count + ' ' + translation.of + ' ' + assignment.gestures.length + ' ' + translation.classifiednGestures);
            console.log(assignment.gestures.length, count);
        }
    }

    // cognitive relationships
    $(target).find('#btn-open-cognitive-relationships').unbind('click').bind('click', function (event) {
        event.preventDefault();
        currentAssignment = getAssignmentByMainGestureId($(this).closest('.root').attr('name'));
        loadHTMLintoModal('custom-modal', 'modal-cognitive-relationships.php', 'modal-lg');
    });

    if (assignment.cognitiveRelationship && assignment.cognitiveRelationship.objectiveAnswer) {
        target.find('#parameters-cognitive-relationships #' + assignment.cognitiveRelationship.objectiveAnswer).removeClass('hidden');
    } else {
        target.find('#parameters-cognitive-relationships #not-checked').removeClass('hidden');
    }

    // checklist
    if (classification.checklist.used === 'yes') {
        $(target).find('#parameters-checklist').removeClass('hidden');
        $(target).find('#btn-open-checklist').unbind('click').bind('click', function (event) {
            event.preventDefault();
            currentAssignment = getAssignmentByMainGestureId($(this).closest('.root').attr('name'));
            loadHTMLintoModal('custom-modal', 'modal-checklist.php', 'modal-lg');
        });

        if (assignment.checklist && assignment.checklist.objectiveAnswer) {
            target.find('#parameters-checklist #' + assignment.checklist.objectiveAnswer).removeClass('hidden');
        } else {
            target.find('#parameters-checklist #not-checked').removeClass('hidden');
        }
    }

    // attached gesture sets
    var query = getQueryParams(document.location.search);
    getGestureSetsForStudyId({studyId: query.studyId}, function (result) {
        if (result.status === RESULT_SUCCESS) {
            setLocalItem(GESTURE_SETS, result.gestureSets);

            var sets = getAttachedGestureSets(assignment.mainGestureId);
            if (sets) {
                for (var i = 0; i < sets.length; i++) {
                    var item = $('#attached-gesture-set-item').clone().removeAttr('id');
                    $(item).find('#gesture-set-title').text(sets[i].title);
                    $(target).find('#attached-gesture-sets-container').append(item);
                }
            }
        }
    });

    $(target).find('#btn-add-to-gesture-set').unbind('click').bind('click', function (event) {
        event.preventDefault();
        currentAssignment = getAssignmentByMainGestureId($(this).closest('.root').attr('name'));
        loadHTMLintoModal('custom-modal', 'modal-add-to-gesture-set.php', 'modal-md');
    });
}

function getAssignmentByMainGestureId(mainGestureId) {
    var classification = getLocalItem(CLASSIFICATION);
    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(mainGestureId) === parseInt(classification.assignments[i].mainGestureId)) {
            return classification.assignments[i];
            break;
        }
    }
    return null;
}

function getAmountRange(triggerId) {
    var classification = getLocalItem(CLASSIFICATION);
    var min = 1;
    var max = 0;

    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(classification.assignments[i].triggerId) === parseInt(triggerId)) {
            min = Math.min(classification.assignments[i].gestures.length, min);
            max = Math.max(classification.assignments[i].gestures.length, max);
        }
    }

    return {min: min, max: max};
}

function getGestureEffectAmount(triggerId) {
    var classification = getLocalItem(CLASSIFICATION);
    var amount = 0;
    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(classification.assignments[i].triggerId) === parseInt(triggerId)) {
            amount += classification.assignments[i].gestures.length;
        }
    }
    return amount;
}

function getAccordance(triggerId) {
    var classification = getLocalItem(CLASSIFICATION);
    var accordance = 0;
    var effectAmount = getGestureEffectAmount(triggerId);

    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(classification.assignments[i].triggerId) === parseInt(triggerId)) {
            accordance += Math.pow((classification.assignments[i].gestures.length / effectAmount), 2);
        }
    }

    return accordance;
}

function getAgreementMeasures(assignment, type) {
    var agreementMeasures = 0;

    if (type === TYPE_CLASSIFICATION_APPEARANCE_TRIGGER) {
        var allSameGestures = 0;
        allSameGestures += assignment.gestures.length;

        var sameAssignments = null;
        if (assignment.sameAs) {
            sameAssignments = getAssignmentByGestureId(assignment.sameAs);
        } else {
            sameAssignments = getSameGestureByGestureId(assignment.mainGestureId);
        }

        if (sameAssignments && sameAssignments.length > 0) {
            for (var i = 0; i < sameAssignments.length; i++) {
                allSameGestures += sameAssignments[i].gestures.length;
            }
        } else {
            return null;
        }

        agreementMeasures = Math.floor(assignment.gestures.length / allSameGestures * 100);
    } else {

    }

    return agreementMeasures;
}


function getAssignmentByGestureId(gestureId) {
    var classification = getLocalItem(CLASSIFICATION);
    var assignments = new Array();
    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(classification.assignments[i].mainGestureId) === parseInt(gestureId)) {
            assignments.push(classification.assignments[i]);
        }
    }

    return assignments;
}

function getSameGestureByGestureId(gestureId) {
    var classification = getLocalItem(CLASSIFICATION);
    var assignments = new Array();
    for (var i = 0; i < classification.assignments.length; i++) {
        if (classification.assignments[i].sameAs && parseInt(classification.assignments[i].sameAs) === parseInt(gestureId)) {
            assignments.push(classification.assignments[i]);
        }
    }

    return assignments;
}

function updateMainGesture(id, target) {
    var classification = getLocalItem(CLASSIFICATION);
    for (var i = 0; i < classification.assignments.length; i++) {
        var assignment = classification.assignments[i];
//        console.log(assignment);
        for (var j = 0; j < assignment.gestures.length; j++) {
            if (parseInt(assignment.gestures[j]) === parseInt(id)) {
                updateMainGestureInGestureSet(assignment.mainGestureId, id);
                updateSameAsGesture(classification, assignment.mainGestureId, id);
                assignment.mainGestureId = id;
                break;
            }
        }
    }

//    console.log($(target).find('#main-gesture'));
    var mainGesture = getGestureById(id, ELICITED_GESTURES);
    renderGestureImages($(target).children('#' + id).find('#main-gesture .previewGesture'), mainGesture.images, mainGesture.previewImage, null);

    console.log(classification);
    setLocalItem(CLASSIFICATION, classification);
    saveClassification();
}

function updateMainGestureInGestureSet(oldId, newId) {
    var sets = getLocalItem(GESTURE_SETS);
    if (sets && sets.length > 0) {
        for (var i = 0; i < sets.length; i++) {
            var set = sets[i];
            if (set.gestures && set.gestures.length > 0) {
                for (var j = 0; j < set.gestures.length; j++) {
                    if (parseInt(set.gestures[j]) === parseInt(oldId)) {
                        set.gestures[j] = newId;
                    }
                }
            }

        }
        setLocalItem(GESTURE_SETS, sets);
        updateGestureSets({sets: getLocalItem(GESTURE_SETS)});
    }
}

function updateSameAsGesture(classification, oldId, newId) {
    for (var i = 0; i < classification.assignments.length; i++) {
        var assignment = classification.assignments[i];
        if (parseInt(assignment.sameAs) === parseInt(oldId)) {
            assignment.sameAs = newId;
        }
    }
}

function clearGestureSets() {
    resetGestureSets();
    updateGestureSets({sets: getLocalItem(GESTURE_SETS)});
}

function resetGestureSets() {
    var sets = getLocalItem(GESTURE_SETS);
    if (sets && sets.length > 0) {
        for (var i = 0; i < sets.length; i++) {
            sets[i].gestures = null;
        }
    }
    setLocalItem(GESTURE_SETS, sets);
}

function gestureSetsAreEmpty() {
    var sets = getLocalItem();
    if (sets && sets.length > 0) {
        for (var i = 0; i < sets.length; i++) {
            var set = sets[i];
            if (set.gestures && set.gestures.length > 0) {
                return false;
            }
        }
    }
    return true;
}