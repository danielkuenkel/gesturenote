function renderData(data, hash) {
    var studyData = data.studyData;
    // general data view
    $('#study-headline').text(studyData.generalData.title);
    $('#type-survey').text(translation.surveyType[studyData.generalData.surveyType]);
    $('#type-phase').text(translation.phaseType[studyData.generalData.phase]);
    $('#study-description .text').text(studyData.generalData.description);


    // date range view
    var now = new Date().getTime();
    var dateFrom = parseInt(studyData.generalData.dateFrom) * 1000;
    var dateTo = addDays(parseInt(studyData.generalData.dateTo) * 1000, 1).getTime(); // add one day because of date selection
    var totalDays = rangeDays(dateFrom, dateTo);
    if ((studyData.generalData.dateFrom !== null && studyData.generalData.dateFrom !== "") &&
            (studyData.generalData.dateTo !== null && studyData.generalData.dateTo !== "")) {
        var renderDateTo = addSeconds(dateTo, -1);
        $('.study-plan').find('.address').text(translation.studyRun + ": ");
        $('.study-plan').find('.text').text(totalDays + " " + (totalDays === 1 ? translation.day : translation.days) + ", " + translation.from + ' ' + new Date(dateFrom).toLocaleDateString() + ' (' + translation.zeroOClick + ') ' + translation.to + " " + renderDateTo.toLocaleDateString() + ' (' + renderDateTo.getHours() + ':' + renderDateTo.getMinutes() + ')');
        $('.study-plan').removeClass('hidden');

        getStudyResults({studyId: data.id}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                if (now > dateFrom && result.studyResults && result.studyResults.length > 0) { // check if there are study results
                    renderStudyParticipants(result.studyResults, hash);
                } else {
                    $('#tab-pane').find('#participants .badge').text('0');
                    $('#statistic-participants').addClass('hidden');
                    appendAlert($('#study-participants'), ALERT_NO_PARTICIPANT_DATA);
                }
            }
        });
    } else {
        appendAlert($('#study-participants'), ALERT_NO_PLAN);
        $('#statistic-participants').addClass('hidden');
        $('#study-range-days .text').text('0 ' + translation.days);
        $('.study-no-plan').removeClass('hidden').find('.text').text(translation.studyNoPlan);
    }

    // url copy clipboard view
    var origin = window.location.origin;
    if (origin.includes('localhost')) {
        origin += '/gesturenote';
    }

    var absoluteStaticStudyUrl = origin + '/study-prepare.php?studyId=' + data.id + '&h=' + data.urlToken;
    var relativeStaticStudyUrl = 'study-prepare.php?studyId=' + data.id + '&h=' + data.urlToken;
    $('#copy-to-clipboard #static-study-url').val(absoluteStaticStudyUrl);

    // participant URL check
    if (now > dateTo) {
        $('.study-plan').find('.address').text(translation.studyRuns + ": ");
        appendAlert($('#study-participants'), ALERT_PLAN_EXPIRED);

        if (studyData.generalData.isOwner && studyData.generalData.isOwner === true) {

        } else {
            $('#fixed-study-owner-controls').find('.btn-preview-study').css({borderBottomRightRadius: '8px'});
        }

//        $('#fixed-study-owner-controls').find('.btn-preview-study').css({borderBottomLeftRadius: '0px'});
    } else if (now < dateFrom) {
        appendAlert($('#study-participants'), ALERT_PLAN_NOT_STARTED);

        if (studyData.generalData.isOwner && studyData.generalData.isOwner === true) {

        } else {
            $('#fixed-study-owner-controls').find('.btn-preview-study').css({borderBottomRightRadius: '8px'});
        }
    } else if (studyData.generalData.surveyType === TYPE_SURVEY_MODERATED) {
        $('#copy-to-clipboard').removeClass('hidden');
        $('.btn-open-static-execution-url').removeClass('hidden');

        if (studyData.generalData.isOwner && studyData.generalData.isOwner === true) {

        } else {
            $('#fixed-study-owner-controls').find('.btn-preview-study').css({borderBottomRightRadius: '0px'});
//            $('#fixed-study-owner-controls').find('.btn-open-static-execution-url').css({borderBottomRightRadius: '8px'});
        }

        $('#copy-to-clipboard #static-study-url').removeClass('readonly');
        $('#copy-to-clipboard #static-study-url').click(function () {
            $('#copy-to-clipboard #static-study-url').select();
        });

        $('.btn-open-static-execution-url').unbind('click').bind('click', {url: relativeStaticStudyUrl}, function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                goto(relativeStaticStudyUrl);
            }
        });
    }

    initPopover();
//    if (studyData.phases && studyData.phases.length > 0 &&
//            (studyData.generalData.dateFrom !== null && studyData.generalData.dateFrom !== "") &&
//            (studyData.generalData.dateTo !== null && studyData.generalData.dateTo !== "")) {
//
//        // url copy clipboard view
//        var origin = window.location.origin;
//        if (origin.includes('localhost')) {
//            origin += '/gesturenote';
//        }
//
//        var absoluteStaticStudyUrl = origin + '/study-prepare.php?studyId=' + data.id + '&h=' + data.urlToken;
//        var relativeStaticStudyUrl = 'study-prepare.php?studyId=' + data.id + '&h=' + data.urlToken;
//        $('#copy-to-clipboard #static-study-url').val(absoluteStaticStudyUrl);

    // prepare study
//        console.log(now > dateFrom, now < dateTo, now, dateFrom, dateTo);
//        if (now > dateFrom && now < dateTo) {
//            $('#copy-to-clipboard #static-study-url').removeClass('readonly');
//            $('#copy-to-clipboard #static-study-url').click(function () {
//                $('#copy-to-clipboard #static-study-url').select();
//            });
//
//            if (studyData.generalData.surveyType === TYPE_SURVEY_MODERATED) {
//                if (studyData.phases && studyData.phases.length > 2) {
//                    $('.btn-open-static-execution-url').on('click', {url: relativeStaticStudyUrl}, function (event) {
//                        event.preventDefault();
//                        if (!$(this).hasClass('disabled')) {
//                            goto(relativeStaticStudyUrl);
//                        }
//                    });
//                } else {
//                    $('.btn-open-static-execution-url').addClass('disabled');
//                    $('.btn-open-static-execution-url').attr('data-content', translation.staticStudyURLNoPhasesteps).data('bs.popover').setContent();
//                }
//            } else {
//                $('.btn-open-static-execution-url').addClass('disabled');
//                $('.btn-open-static-execution-url').attr('data-content', translation.staticStudyURLOnlyModerated).data('bs.popover').setContent();
//            }
//        } else {
//            $('.btn-open-static-execution-url').addClass('disabled');
//            $('.btn-open-static-execution-url').attr('data-content', translation.staticStudyURLCheck).data('bs.popover').setContent();
//        }
//    } else {
//        $('.btn-open-static-execution-url').addClass('disabled');
//        $('.btn-open-static-execution-url').attr('data-content', translation.staticStudyURLCheck).data('bs.popover').setContent();
//    }

    $('.btn-edit-study').on('click', {studyId: data.id}, function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            goto("study-create.php?studyId=" + event.data.studyId + "&h=" + hash + "&joinedConv=" + joinedRoom + getWebRTCSources());
        }
    });

    $('.btn-preview-study').on('click', {studyId: data.id}, function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            goto("study-preview.php?studyId=" + event.data.studyId + "&h=" + hash + "&joinedConv=" + joinedRoom + getWebRTCSources());
        }
    });

    $('.btn-delete-study').on('click', {studyId: data.id}, function (event) {
        event.preventDefault();
        var button = $(this);
        var deleteStudyId = event.data.studyId;
        lockButton($('.btn-preview-study, .btn-edit-study'));

        if (!$(button).hasClass('disabled')) {
            lockButton(button, true, 'fa-trash');
            loadHTMLintoModal('custom-modal', 'externals/modal-delete-study-data.php', 'modal-md');
            $('#custom-modal').unbind('deleteData').bind('deleteData', function () {
                deleteStudy({studyId: deleteStudyId}, function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        gotoStudies();
                    } else {
                        unlockButton(button, true, 'fa-trash');
                        unlockButton($('.btn-preview-study, .btn-edit-study'));
                        // append error alert
                    }
                });
            });
            $('#custom-modal').unbind('cancel').bind('cancel', function () {
                unlockButton($('.btn-preview-study, .btn-edit-study'));
                unlockButton(button, true, 'fa-trash');
            });
        }
    });

    // shared studie view
    if (studyData.generalData.isOwner && studyData.generalData.isOwner === true) {
        renderInvitedUsers();
    } else {
        $('#invited-users').remove();
        $('.btn-delete-study').remove();
        $('.btn-edit-study').remove();
//        $('#fixed-study-owner-controls').find('.btn-preview-study').css({borderBottomLeftRadius: '0px'});
//        $('#fixed-study-owner-controls').find('.btn-open-static-execution-url').css({borderBottomLeftRadius: '0px', borderBottomRightRadius: '8px'});
        $('#fixed-study-owner-controls').find('.btn-join-conversation').css({borderBottomLeftRadius: '0px', borderBottomRightRadius: '8px'});
        $('#fixed-study-owner-controls').find('.btn-leave-conversation').css({borderBottomLeftRadius: '0px', borderBottomRightRadius: '8px'});
    }


    // gesture/trigger extraction view
    if (studyData.generalData.phase === TYPE_PHASE_ELICITATION) {
        $('#extraction').removeClass('hidden');
    }

    for (var i = 0; i < data.studyData.phases.length; i++) {
        if (data.studyData.phases[i].format === IDENTIFICATION) {
            var phaseData = getLocalItem(data.studyData.phases[i].id + '.data');
            if (phaseData.identificationFor === 'gestures') {
                $('#tab-pane').find('#gesture-extraction').removeClass('disabled');
            } else {
                $('#tab-pane').find('#trigger-extraction').removeClass('disabled');
            }
        }
    }

    $('#tab-pane li a').on('click', function (event) {
        event.preventDefault();
        if ($(this).parent().hasClass('disabled')) {
            event.stopImmediatePropagation();
        } else {
            if (!event.handled && !$(this).parent().hasClass('active') && !$(this).hasClass('dropdown-toggle')) {
                event.handled = true;
//                console.log('check if disabled', $(this).parent().hasClass('disabled'));
                $(this).trigger('change', [$(this).closest('li').attr('id')]);
//                console.log('tab pane clicked', $(this).closest('li').attr('id'));
            }
        }
    });

    $('#tab-pane').on('change', function (event, activeId) {
        event.preventDefault();
//        $('#btn-scroll-to-top').addClass('hidden');
//        console.log('active ID', activeId);
        if (activeId !== 'tab-introduction') {
            switch (activeId) {
                case 'catalogs':
                    renderCatalogs();
                    break;
                case 'phase-steps':
                    renderPhaseSteps();
                    break;
                case 'participants':
                    renderParticipants();
                    break;
                case 'gesture-extraction':
                    renderExtraction(ELICITED_GESTURES);
//                    $('#btn-scroll-to-top').removeClass('hidden');
                    break;
                case 'trigger-extraction':
                    renderExtraction(ELICITED_TRIGGER);
                    break;
            }

            window.location.hash = activeId;
            $(document).scrollTop(0);
            TweenMax.from($('#main-content'), .2, {y: -10, opacity: 0.0, clearProps: 'all'});

            setTimeout(function () {
                tutorialAutomaticClicked = true;
                $('#tab-introduction a').click();
            }, 300);

//            var status = window.location.hash.substr(1);
//            if (status !== 'gesture-extraction' && status !== 'trigger-extraction') {
            fixedOwnerControlsTween.play();
//            } else {
//                fixedOwnerControlsTween.reverse();
//            }
        }
    });

    var status = window.location.hash.substr(1);
    if (status !== '') {
        $('#tab-pane').find('#' + status + " a").click();
    } else {
        $('#tab-pane').find('#general a').click();
    }

    function renderCatalogs() {
        // catalogs view
        // check if there are study catalog data
        var studyGestures = getLocalItem(ASSEMBLED_GESTURE_SET);
        var studyFeedback = getLocalItem(ASSEMBLED_FEEDBACK);
        var studyScenes = getLocalItem(ASSEMBLED_SCENES);
        var studyTrigger = getLocalItem(ASSEMBLED_TRIGGER);
        var noCatalogData = true;

        if (studyGestures && studyGestures.length > 0) {
            renderStudyGestures(getStudyCatalogGestures());
            noCatalogData = false;
        } else {
            $('#study-gestures-catalog').remove();
        }

        if (studyScenes && studyScenes.length > 0) {
            renderStudyScenes(studyScenes);
            noCatalogData = false;
        } else {
            $('#study-scenes-catalog').remove();
        }

        if (studyTrigger && studyTrigger.length > 0) {
            renderStudyTrigger(studyTrigger);
            noCatalogData = false;
        } else {
            $('#study-trigger-catalog').remove();
        }

        if (studyFeedback && studyFeedback.length > 0) {
            renderStudyFeedback(studyFeedback);
            noCatalogData = false;
            $('#study-feedback-catalog').remove();
        }

        if (noCatalogData) {
            appendAlert($('#study-catalogs'), ALERT_NO_PHASE_DATA);
        } else {
            $('#study-catalogs').find('.study-catalog').first().css({marginTop: '0px'});
        }
    }

    function renderPhaseSteps() {
        // phase view
        if (studyData.phases && studyData.phases.length > 0) {
            var step = document.createElement('ol');
            $(step).css({paddingLeft: '15px'});
            $('#phase-steps-container').empty().append(step);
            for (var i = 0; i < studyData.phases.length; i++) {
                var text = document.createElement('li');
                $(text).addClass('text');
                $(text).text(studyData.phases[i].title);
                $(step).append(text);
                TweenMax.from(text, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
            }
        } else {
            appendAlert($('#main-content'), ALERT_NO_PHASE_DATA);
            $('#btn-preview-study').addClass('disabled');
        }
    }

    function renderParticipants() {

    }

    function renderExtraction(type) {
        classificationType = type;

        getExtractionData({studyId: data.id, surveyType: studyData.generalData.surveyType}, function (result) {
            var shouldRender = false;
            if (result.status === RESULT_SUCCESS) {
                if (result.elicitedGestures && result.elicitedGestures.length > 0) {
                    setLocalItem(ELICITED_GESTURES, getElicitedGestures(result.elicitedGestures));
                    if (result.classification && result.classification.data) {
                        setLocalItem(CLASSIFICATION_GESTURES, result.classification.data.gestures);
                    } else {
                        setLocalItem(CLASSIFICATION_GESTURES, null);
                    }
                    shouldRender = true;
                } else {
                    appendAlert($('#study-gesture-extraction'), ALERT_NO_PHASE_DATA);
                }

                if (result.elicitedTrigger && result.elicitedTrigger.length > 0) {
                    setLocalItem(ELICITED_TRIGGER, result.elicitedTrigger);
                    if (result.classification && result.classification.data) {
                        setLocalItem(CLASSIFICATION_TRIGGER, result.classification.data.trigger);
                    } else {
                        setLocalItem(CLASSIFICATION_TRIGGER, null);
                    }
                    shouldRender = true;
                } else {
                    appendAlert($('#study-trigger-extraction'), ALERT_NO_PHASE_DATA);
                }

                if (classificationType === ELICITED_GESTURES && shouldRender === true) {
                    renderGestureExtraction();
                } else if (classificationType === ELICITED_TRIGGER && shouldRender === true) {
                    renderTriggerExtraction();
                }
            }
        });
    }
}

function renderInvitedUsers() {
    var invitedUsers = getLocalItem(INVITED_USERS);
    $('#invited-users #shared-studies-list').empty();
    clearAlerts($('#invited-users'));

    if (invitedUsers && invitedUsers.length > 0) {
        for (var i = 0; i < invitedUsers.length; i++) {
            var listItem = $('#shared-list-item').clone().removeAttr('id');
            $(listItem).find('.shared-study-item-email').text(invitedUsers[i].email);
            $(listItem).find('.btn-uninvite-user').attr('data-invite-id', invitedUsers[i].id);
            $(listItem).find('.btn-uninvite-user').attr('data-invite-mail', invitedUsers[i].email);
            $('#invited-users #shared-studies-list').append(listItem);
        }
    } else {
        appendAlert($('#invited-users'), ALERT_NO_USERS_INVITED);
    }

    $('#invited-users').find('#input-email').unbind('keyup').bind('keyup', function (event) {
        event.preventDefault();
        clearAlerts($('#invite-users-form'));
    });

    $('#invited-users').find('#btn-invite-user').unbind('click').bind('click', function (event) {
        event.preventDefault();
        var button = $(this);
        if (!$(button).hasClass('disabled')) {
            lockButton(button, true, 'fa-paper-plane');

            var email = $('#invited-users').find('#input-email');
            if ($(email).val().trim() === '') {
                appendAlert($('#invited-users'), ALERT_MISSING_EMAIL);
                unlockButton(button, true, 'fa-paper-plane');
                $(email).focus();
                return false;
            }

            // validate email
            if (!validateEmail($(email).val().trim())) {
                appendAlert($('#invited-users'), ALERT_INVALID_EMAIL);
                unlockButton(button, true, 'fa-paper-plane');
                $(email).focus();
                return false;
            }

            var study = getLocalItem(STUDY);
            inviteUser({studyId: study.id, email: email.val().trim()}, function (result) {
                unlockButton(button, true, 'fa-paper-plane');
                if (result.status === RESULT_SUCCESS) {
                    setLocalItem(INVITED_USERS, result.invitedUsers);
                    $(email).val('');
                    renderInvitedUsers();
                } else if (result.status === 'userAlreadyInvited') {
                    $(email).val('');
                    appendAlert($('#invite-users-form'), ALERT_USER_ALREADY_INVITED);
                } else if (result.status === 'notInviteYourself') {
                    $(email).val('');
                    appendAlert($('#invite-users-form'), ALERT_INVITE_YOURSELF);
                }
            });
        }
    });
}

$(document).on('click', '.btn-uninvite-user', function (event) {
    event.preventDefault();
    var study = getLocalItem(STUDY);
    var button = $(this);
    if (!$(button).hasClass('disabled')) {
        lockButton(button, true, 'fa-trash');
        uninviteUser({studyId: study.id, id: $(this).attr('data-invite-id'), email: $(this).attr('data-invite-mail')}, function (result) {
            unlockButton(button, true, 'fa-trash');
            if (result.status === RESULT_SUCCESS) {
                setLocalItem(INVITED_USERS, result.invitedUsers);
                renderInvitedUsers();
            }
        });
    }
});

function getStudyCatalogGestures() {
    var gestures = getLocalItem(GESTURE_CATALOG);
    var assembledGestures = getLocalItem(ASSEMBLED_GESTURE_SET);
    if (assembledGestures && assembledGestures.length > 0 && gestures && gestures.length > 0) {
        var array = [];
        for (var i = 0; i < assembledGestures.length; i++) {
            var assembledGestureId = parseInt(assembledGestures[i]);
            for (var j = 0; j < gestures.length; j++) {
                if (parseInt(gestures[j].id) === assembledGestureId) {
                    array.push(gestures[j]);
                    break;
                }
            }
        }
        return array;
    }

    return null;
}

function renderStudyGestures(gestures) {
    $('#study-gestures-catalog').removeClass('hidden');
    $('#study-gestures-catalog').find('.list-container').empty();
    if (gestures && gestures.length > 0) {
        $('#study-gestures-catalog').find('#btn-download-as-json').removeClass('disabled');
        $('#study-gestures-catalog').find('#btn-download-as-exchangeable').removeClass('disabled');

        for (var i = 0; i < gestures.length; i++) {
            var item = getGestureCatalogListThumbnail(gestures[i]);
            $('#study-gestures-catalog .list-container').append(item);
            TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
        }
    }
}

function renderStudyScenes(scenes) {
    $('#study-scenes-catalog').removeClass('hidden');
    $('#study-scenes-catalog').find('.list-container').empty();
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
            loadHTMLintoModal('custom-modal', 'externals/modal-scene.php', 'modal-lg');
        });
    }
}

function renderStudyTrigger(trigger) {
    $('#study-trigger-catalog').removeClass('hidden');
    $('#study-trigger-catalog').find('.list-container').empty();
    for (var i = 0; i < trigger.length; i++) {
        var item = $('#template-study-container').find('#trigger-catalog-thumbnail').clone().removeAttr('id');
        item.text(trigger[i].title);
        $('#study-trigger-catalog .list-container').append(item);
        TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
    }
}

function renderStudyFeedback(feedback) {
    $('#study-feedback-catalog').removeClass('hidden');
    $('#study-feedback-catalog').find('.list-container').empty();
    for (var i = 0; i < feedback.length; i++) {
        var item = $('#template-study-container').find('#feedback-catalog-thumbnail').clone().removeAttr('id');
        item.find('.text').text(feedback[i].title);
        item.find('#' + feedback[i].type).removeClass('hidden');
        if (feedback[i].type === TYPE_FEEDBACK_SOUND && feedback[i].parameters && feedback[i].parameters.url) {
            item.find('.audio-holder').attr('src', feedback[i].parameters.url);
        }
        $('#study-feedback-catalog .list-container').append(item);
        TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
    }
}


function renderStudyParticipants(data, hash) {
//    console.log('render study participants');
    $('#study-participants .list-container').empty();
    $('#tab-pane').find('#participants .badge').text(data.length);
    var aborted = 0;
    var success = 0;

    for (var i = 0; i < data.length; i++) {
        var result = data[i].data;
        var item = $('#template-study-container').find('#participant-thumbnail').clone().removeAttr('id');
        $(item).find('#heading-text').text(convertSQLTimestampToDate(data[i].created).toLocaleString());
        $('#study-participants .list-container').append(item);
//        console.log(data[i].executionPhase);
        $(item).find('#execution-phase-' + data[i].executionPhase).removeClass('hidden');
        initPopover();

        if (result.aborted === 'no' && result.studySuccessfull === 'yes') {
            success++;
            $(item).find('.panel').addClass('panel-success');
            $(item).find('#execution-success').removeClass('hidden');
            $(item).find('#execution-success .label-text').text(translation.studySuccessful);

            var start = null;
            var end = null;
            for (var j = 0; j < result.phases.length; j++) {
                if (result.phases[j].startTime) {
                    if (result.phases[j].format === LETTER_OF_ACCEPTANCE) {
                        start = parseInt(result.phases[j].startTime);
                    } else if (result.phases[j].format === THANKS) {
                        end = parseInt(result.phases[j - 1].endTime);
                    }
                }
            }

            if (start && end) {
                var duration = getTimeBetweenTimestamps(start, end);
                $(item).find('#execution-duration').removeClass('hidden');
                $(item).find('#execution-duration .label-text').text(getTimeString(duration, true));
            }
        } else {
            aborted++;
            $(item).find('.panel').addClass('panel-danger');
            $(item).find('#execution-fault').removeClass('hidden');
            $(item).find('#execution-fault .label-text').text(translation.studyFault);
        }

        if (result.snapshot) {
            $(item).find('.participant-snapshot img').attr('src', result.snapshot);
        }

        $(item).find('.panel').on('click', {studyId: data[i].studyId, participantId: data[i].userId}, function (event) {
            event.preventDefault();
            clearLocalItems();
            goto('study-participant.php?studyId=' + event.data.studyId + '&participantId=' + event.data.participantId + '&h=' + hash + "&joinedConv=" + joinedRoom + getWebRTCSources());
        });
    }

    var chartOptions = {
        rotation: -Math.PI,
        cutoutPercentage: 30,
        circumference: Math.PI
    };
//    console.log(success, aborted);

    var target = $('#study-participants');
    var ctx = $(target).find('#chart-participant-statistics');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [translation.studiesSucceeded, translation.studiesAborted],
            datasets: [{
//                    label: '# of Votes',
                    data: [success, aborted],
                    backgroundColor: [
                        '#5cb85c',
                        '#d9534f'
                    ]
                }]
        },
        options: chartOptions
    });

    $(target).find('#amount-participants-success').text(translation.studiesSucceeded + ': ' + success);
    $(target).find('#amount-participants-aborted').text(translation.studiesAborted + ': ' + aborted);
    $(target).find('#amount-participants-total').text(translation.gestureTypes.total + ': ' + (success + aborted));
}


function renderGestureExtraction() {
    getGestureSets(function (result) {
        if (result.status === RESULT_SUCCESS) {
            setLocalItem(GESTURE_SETS, result.gestureSets);

            var elicitedGestures = getLocalItem(ELICITED_GESTURES);
            if (elicitedGestures && elicitedGestures.length > 0) {
                $('#gesture-extraction-content').removeClass('hidden');
                checkGestureClassificationType();
            } else {
                appendAlert($('#gesture-extraction'), ALERT_NO_PHASE_DATA);
            }

            if ($('#gesture-extraction-navigation').find('.active').length === 0) {
                $('#btn-all-gestures').click();
            }
        }

        initDynamicAffixScrolling($('#gesture-extraction-navigation'));
    });
}

function renderTriggerExtraction() {
    var elicitedTrigger = getLocalItem(ELICITED_TRIGGER);
    if (elicitedTrigger && elicitedTrigger.length > 0) {
        $('#trigger-extraction-content').removeClass('hidden');
        checkTriggerClassificationType();
    } else {
        appendAlert($('#gesture-extraction'), ALERT_NO_PHASE_DATA);
    }

    if ($('#trigger-extraction-navigation').find('.active').length === 0) {
        $('#btn-all-trigger').click();
    }

    initDynamicAffixScrolling($('#trigger-extraction-navigation'));
}

$(document).on('click', '#gesture-extraction-navigation button', function (event) {
    event.preventDefault();
    if (!$(this).hasClass('active') && !$(this).hasClass('disabled')) {
        $(this).closest('#gesture-extraction-navigation').find('button').removeClass('active');
        $(this).addClass('active');
        var selectedId = $(this).attr('id');
        renderExtractionContent(selectedId);
        $("html, body").animate({scrollTop: 0}, 100);
        $('#gesture-extraction-content').find('#extraction-navigation-content').children().addClass('hidden');
        var activeContent = $('#gesture-extraction-content').find('#extraction-navigation-content').find('#content-' + selectedId);
        activeContent.removeClass('hidden');
        TweenMax.from(activeContent, .2, {y: -20, opacity: 0, clearProps: 'all'});
    }
});

$(document).on('click', '#trigger-extraction-navigation button', function (event) {
    event.preventDefault();
    if (!$(this).hasClass('active') && !$(this).hasClass('disabled')) {
        $(this).closest('#trigger-extraction-navigation').find('button').removeClass('active');
        $(this).addClass('active');
        var selectedId = $(this).attr('id');
        renderExtractionContent(selectedId);
        $("html, body").animate({scrollTop: 0}, 100);
        $('#trigger-extraction-content').find('#extraction-navigation-content').children().addClass('hidden');
        var activeContent = $('#trigger-extraction-content').find('#extraction-navigation-content').find('#content-' + selectedId);
        activeContent.removeClass('hidden');
        TweenMax.from(activeContent, .2, {y: -20, opacity: 0, clearProps: 'all'});
    }
});

function checkGestureClassificationType() {
    var unclassifiedGestures = getUnclassifiedGestures();
    if (unclassifiedGestures && unclassifiedGestures.length === 0) {
        $('#gesture-extraction-content').find('#btn-potential-gestures').removeClass('disabled');
        $('#gesture-extraction-content').find('#btn-gesture-sets').removeClass('disabled');
    } else {
        $('#gesture-extraction-content').find('#btn-potential-gestures').addClass('disabled');
        $('#gesture-extraction-content').find('#btn-gesture-sets').addClass('disabled');
    }
}

function checkTriggerClassificationType() {
    var unclassifiedTrigger = getUnclassifiedTrigger();
    if (unclassifiedTrigger && unclassifiedTrigger.length === 0) {
        $('#trigger-extraction-content').find('#btn-potential-trigger').removeClass('disabled');
    } else {
        $('#trigger-extraction-content').find('#btn-potential-trigger').addClass('disabled');
    }
}

function renderExtractionContent(id) {
    $('#custom-modal').unbind('gestureUpdated');

    switch (id) {
        case 'btn-all-gestures':
            renderAllGestures();
            break;
        case 'btn-gesture-classification':
            renderGestureClassification();
            addUpdateMainGestureButtonEvent();
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
        case 'btn-all-trigger':
            renderAllTrigger();
            break;
        case 'btn-trigger-classification':
            renderTriggerClassification();
            break;
        case 'btn-potential-trigger':
            renderPotentialTrigger();
            break;
    }
}



/*
 * gesture classfication and extraction functions
 */

function addUpdateMainGestureButtonEvent() {
    $('.btn-tag-as-main-gesture').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('gesture-tagged')) {
            var id = $(this).closest('.root').attr('id');
            $(this).closest('.root').parent().find('.gesture-thumbnail').removeClass('assembled');
            $(this).closest('.root').parent().find('.btn-tag-as-main-gesture').removeClass('gesture-tagged');
            $(this).closest('.root').parent().find('.btn-tag-as-main-gesture').attr('data-content', translation.tagAsMainGesture);
            $(this).popover('hide');

            $(this).closest('.gesture-thumbnail').addClass('assembled');
            $(this).addClass('gesture-tagged');
            $(this).attr('data-content', translation.gestureTaggedAsMain);
            updateMainGesture(id, $(this).closest('#item-view'));
        }
    });

    $('.btn-delete-from-classification').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(this).popover('hide');
            var id = $(this).closest('.root').attr('id');
            var gesture = getGestureById(id);
            reclassifiyGesture(gesture);
            saveClassification();
            renderGestureClassification();
        }
    });
}

function getElicitedGestures(elicitedGestures) {
    var gestures = getLocalItem(GESTURE_CATALOG);
    if (elicitedGestures && elicitedGestures.length > 0 && gestures && gestures.length > 0) {
        var array = [];
        for (var i = 0; i < elicitedGestures.length; i++) {
            for (var j = 0; j < gestures.length; j++) {
                if (parseInt(gestures[j].id) === parseInt(elicitedGestures[i].gestureId)) {
                    var gesture = gestures[j];
                    gesture.triggerId = parseInt(elicitedGestures[i].triggerId);
                    array.push(gesture);
                    break;
                }
            }
        }
        return array;
    }

    return null;
}

function renderAllGestures() {
    $('#content-btn-all-gestures').empty();
    var gestures = getLocalItem(ELICITED_GESTURES);

    var trigger = getLocalItem(ASSEMBLED_TRIGGER);
    if (trigger && trigger.length > 0 && gestures && gestures.length > 0) {

        var container = document.createElement('div');
        $(container).attr('id', 'item-view');
        $('#content-btn-all-gestures').empty().append(container);

        var gesturesListContainer = document.createElement('div');
        $(gesturesListContainer).attr('id', 'gestures-list-container');
        $(container).append(gesturesListContainer);

        var statistics = {};
        statistics.staticGestures = 0;
        statistics.dynamicGestures = 0;
        statistics.executionMixed = 0;
        statistics.discreteInteractions = 0;
        statistics.continuousInteractions = 0;
        statistics.interactionMixed = 0;
        statistics.totalAmount = 0;

        for (var i = 0; i < trigger.length; i++) {
            var singleStatistics = {};
            singleStatistics.staticGestures = 0;
            singleStatistics.dynamicGestures = 0;
            singleStatistics.executionMixed = 0;
            singleStatistics.discreteInteractions = 0;
            singleStatistics.continuousInteractions = 0;
            singleStatistics.interactionMixed = 0;
            singleStatistics.totalAmount = 0;

            var panel = document.createElement('div');
            $(panel).addClass('panel panel-default panel-shadow');


            var panelHeading = document.createElement('div');
            $(panelHeading).addClass('panel-heading');
            $(panel).append(panelHeading);

            var panelBody = document.createElement('div');
            $(panelBody).addClass('panel-body');
            $(panel).append(panelBody);

            var triggerTitle = document.createElement('div');
            $(triggerTitle).addClass('text');
            $(triggerTitle).text(translation.trigger + ": " + trigger[i].title);

            var listContainer = document.createElement('div');
            $(listContainer).addClass('container-root row root');

            var gestureCount = 0;
            for (var j = 0; j < gestures.length; j++) {
                var gesture = gestures[j];
                if (parseInt(trigger[i].id) === parseInt(gesture.triggerId)) {
                    var clone = getGestureCatalogListThumbnail(gesture, null, 'col-xs-6 col-lg-4', ELICITED_GESTURES);
                    $(listContainer).append(clone);
                    TweenMax.from(clone, .2, {delay: j * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                    gestureCount++;

                    switch (gesture.type) {
                        case TYPE_GESTURE_POSE:
                            statistics.staticGestures++;
                            singleStatistics.staticGestures++;
                            break;
                        case TYPE_GESTURE_DYNAMIC:
                            statistics.dynamicGestures++;
                            singleStatistics.dynamicGestures++;
                            break;
                        case TYPE_GESTURE_MIXED:
                            statistics.executionMixed++;
                            singleStatistics.executionMixed++;
                            break;
                    }

                    switch (gesture.interactionType) {
                        case TYPE_GESTURE_DISCRETE:
                            statistics.discreteInteractions++;
                            singleStatistics.discreteInteractions++;
                            break;
                        case TYPE_GESTURE_CONTINUOUS:
                            statistics.continuousInteractions++;
                            singleStatistics.continuousInteractions++;
                            break;
                        case TYPE_GESTURE_MIXED:
                            statistics.interactionMixed++;
                            singleStatistics.interactionMixed++;
                            break;
                    }
                }
            }

            if (gestureCount > 0) {
//                console.log('append list container');
                $(panelHeading).append(triggerTitle);
                $(panelBody).append(listContainer);
                $(gesturesListContainer).append(panel);
            }

            statistics.totalAmount += gestureCount;
            singleStatistics.totalAmount = gestureCount;
            renderElicitationStatistics(gesturesListContainer, singleStatistics, listContainer, translation.whatGesturesWhereElicitedForTrigger);
            $(document.createElement('hr')).insertBefore(listContainer);

            var countText = document.createElement('span');
            $(countText).addClass('badge');
            $(countText).css({marginLeft: '6px'});
            $(countText).text(gestureCount === 1 ? gestureCount + " " + translation.gesture : gestureCount + " " + translation.gestures);
            $(triggerTitle).append(countText);
        }

        $('#custom-modal').unbind('gestureUpdated').bind('gestureUpdated', function (event) {
            event.preventDefault();
            renderAllGestures();
        });

        renderElicitationStatistics($('#content-btn-all-gestures'), statistics);
        initPopover();
    } else {
        // append alert
    }
}

function renderElicitationStatistics(container, statistics, prependContainer, headline) {
    var statisticsContainer = $('#template-study').find('#elicitation-statistics').clone().removeAttr('id');

    var chartOptions = {
        rotation: -Math.PI,
        cutoutPercentage: 30,
        circumference: Math.PI
    };

    var ctx = $(statisticsContainer).find('.chart-gesture-execution-type');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [translation.gestureTypes.pose, translation.gestureTypes.dynamic, translation.gestureTypes.mixed],
            datasets: [{
                    label: '# of Votes',
                    data: [statistics.staticGestures, statistics.dynamicGestures, statistics.executionMixed],
                    backgroundColor: [
                        '#97CB00',
                        '#4BACC6',
                        '#343C68'
                    ]
                }]
        },
        options: chartOptions
    });

    var ctx = $(statisticsContainer).find('.chart-gesture-interaction-type');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [translation.gestureInteractionTypes.discrete, translation.gestureInteractionTypes.continuous, translation.gestureInteractionTypes.mixed],
            datasets: [{
                    label: '# of Votes',
                    data: [statistics.discreteInteractions, statistics.continuousInteractions, statistics.interactionMixed],
                    backgroundColor: [
                        '#7030A0',
                        '#FFCB00',
                        '#C90F5A'
                    ]
                }]
        },
        options: chartOptions
    });

    $(statisticsContainer).find('.amount-static-gestures').text(translation.gestureTypes.pose + ': ' + statistics.staticGestures);
    $(statisticsContainer).find('.amount-dynamic-gestures').text(translation.gestureTypes.dynamic + ': ' + statistics.dynamicGestures);
    $(statisticsContainer).find('.amount-execution-mixed-gestures').text(translation.gestureTypes.mixed + ': ' + statistics.executionMixed);
    $(statisticsContainer).find('.amount-total-gesture-executions').text(translation.gestureTypes.total + ': ' + (statistics.staticGestures + statistics.dynamicGestures + statistics.executionMixed));

    $(statisticsContainer).find('.amount-discrete-gestures').text(translation.gestureInteractionTypes.discrete + ': ' + statistics.discreteInteractions);
    $(statisticsContainer).find('.amount-continuous-gestures').text(translation.gestureInteractionTypes.continuous + ': ' + statistics.continuousInteractions);
    $(statisticsContainer).find('.amount-interaction-mixed-gestures').text(translation.gestureInteractionTypes.mixed + ': ' + statistics.interactionMixed);
    $(statisticsContainer).find('.amount-total-gesture-interactions').text(translation.gestureTypes.total + ': ' + (statistics.discreteInteractions + statistics.continuousInteractions + statistics.interactionMixed));

    $(statisticsContainer).css({marginBottom: '40px'});

    if (prependContainer) {
        $(statisticsContainer).insertBefore(prependContainer);
    } else {
        $(container).prepend(statisticsContainer);
    }

    if (headline) {
        statisticsContainer.find('#headline').text(headline);
    }
}

var gesturesLeft = null;
var gesturesLeftIndex = 0;
var gesturesRight = null;
var gesturesRightIndex = 0;
function renderGestureClassification() {
    gesturesLeftIndex = 0;
    gesturesRightIndex = 0;
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
    var elicitedGestures = getLocalItem(ELICITED_GESTURES);

    if (elicitedGestures && elicitedGestures.length > 0) {
        if (classification && classification.assignments && classification.assignments.length > 0) {
            // check classified gestures and render them. gesturesLeft must be the matched unclassified gestures
            console.log('there is classification data');
            $('#btn-reclassify-gestures').removeClass('disabled');
            $('#gesture-classification-parameters').addClass('hidden');
            gesturesLeft = getUnclassifiedGestures();
            gesturesRight = [];
            for (var i = 0; i < classification.assignments.length; i++) {
                if (!classification.assignments[i].sameAs) {
                    gesturesRight.push(classification.assignments[i]);
                }
            }
            console.log('gestures right', gesturesRight);
            if (gesturesLeft && gesturesLeft.length > 0) {
                $('#gesture-classification').removeClass('hidden');
                updateMatchingView(true, true);
            } else {
                appendAlert($('#content-btn-gesture-classification'), ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION);
            }
            renderClassifiedGestures($('#classified-gestures'));
        } else {
            appendAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
            console.log('there is NO classification data');
            $('#gesture-classification-parameters').removeClass('hidden');
            $('#gesture-classification').addClass('hidden');

            $('#classification-type').unbind('change').bind('change', function (event) {
                event.preventDefault();
                $('#btn-start-classification').removeClass('disabled');
            });

            $('#btn-help-classification').unbind('click').bind('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'externals/modal-classification.php', 'modal-lg');
            });

            $('#btn-start-classification').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $('#gesture-classification-parameters').addClass('hidden');
                    $('#gesture-classification').removeClass('hidden');
                    var checked = $('#classification-type').find('.btn-option-checked').attr('id');
                    classification = {type: checked, checklist: {used: 'no', items: null}};
                    setLocalItem(CLASSIFICATION_GESTURES, classification);
                    saveClassification();
                    gesturesRight = new Array();
                    gesturesRight.push({mainGestureId: elicitedGestures[0].id, gestures: [elicitedGestures[0]]});
                    gesturesLeft = elicitedGestures;
                    updateMatchingView(true, true);
                    $(document).find('#btn-gesture-yes').click();
                }
            });
        }
    } else {
        appendAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
    }

//    $('#custom-modal').unbind('gestureUpdated').bind('gestureUpdated', function (event) {
//        event.preventDefault();
//        console.log('render gesture Classification on Update');
//        renderGestureClassification();
//    });

    $('#btn-reclassify-gestures').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('disabled');
            removeAlert($('#content-btn-gesture-classification'), ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION);
            setLocalItem(CLASSIFICATION_GESTURES, null);
            saveClassification();
            renderClassifiedGestures($('#classified-gestures'));
            renderGestureClassification();
        }
    });

    $('#btn-redo').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            reclassifiyGesture(gesturesLeft[gesturesLeftIndex - 1]);
            gesturesLeftIndex--;
            gesturesRightIndex = 0;

            if (gesturesRight.length === 0) {
                gesturesRight.push({mainGestureId: elicitedGestures[0].id, gestures: [elicitedGestures[0]]});
            }
            saveClassification();
            updateMatchingView(true, true);
        }
    });
}

function updateMatchingView(updateLeft, updateRight) {
    if (gesturesLeftIndex > 0) {
        $('#btn-redo').removeClass('disabled');
    } else {
        $('#btn-redo').addClass('disabled');
    }


    var leftGesture = gesturesLeft[gesturesLeftIndex];
    var rightGesture = getGestureById(gesturesRight[gesturesRightIndex].mainGestureId, ELICITED_GESTURES);
//    console.log('update matching view', rightGesture, gesturesRight, gesturesRightIndex);

    var leftItem = getGestureCatalogListThumbnail(leftGesture, 'gestures-catalog-thumbnail', 'col-xs-12', ELICITED_GESTURES);
    $(leftItem).removeClass('deleteable');
    var rightItem = getGestureCatalogListThumbnail(rightGesture, 'gestures-catalog-thumbnail', 'col-xs-12', ELICITED_GESTURES);
    $(rightItem).removeClass('deleteable');

    renderClassifiedGestures($('#classified-gestures'));

    if (updateLeft) {
        $('#gesture-left').empty().append(leftItem);
        TweenMax.from(leftItem, .3, {opacity: 0, scaleX: 0.5, scaleY: 0.5, clearProps: 'all'});
    }

    if (updateRight) {
        $('#gesture-right').empty().append(rightItem);
        TweenMax.from(rightItem, .3, {opacity: 0, scaleX: 0.5, scaleY: 0.5, clearProps: 'all'});
    }

    initPopover();
}

function getClassifiedGestures() {
    var classification = getLocalItem(CLASSIFICATION_GESTURES).assignments;
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
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
    var array = new Array();
    if (classification && classification.assignments) {
        var assignments = classification.assignments;
        for (var i = 0; i < elicitedGestures.length; i++) {
            var gestureIsClassified = false;
            for (var j = 0; j < assignments.length; j++) {
                for (var k = 0; k < assignments[j].gestures.length; k++) {
                    if (parseInt(assignments[j].gestures[k]) === parseInt(elicitedGestures[i].id)) {
                        gestureIsClassified = true;
                        break;
                    } else if (j === assignments.length - 1 && k === assignments[j].gestures.length - 1) {
                        array.push(elicitedGestures[i]);
                    }
                }

                if (gestureIsClassified) {
                    break;
                }
            }
        }
        return array;
    }

    return null;
}

function getUnclassifiedTrigger() {
    var elicitedTrigger = getLocalItem(ELICITED_TRIGGER);
    var classification = getLocalItem(CLASSIFICATION_TRIGGER);
    var array = new Array();
    if (classification && classification.assignments) {
        var assignments = classification.assignments;
        for (var i = 0; i < elicitedTrigger.length; i++) {
            var triggerIsClassified = false;
            for (var j = 0; j < assignments.length; j++) {
                for (var k = 0; k < assignments[j].trigger.length; k++) {
                    if (parseInt(assignments[j].trigger[k]) === parseInt(elicitedTrigger[i].id)) {
                        triggerIsClassified = true;
                        break;
                    } else if (j === assignments.length - 1 && k === assignments[j].trigger.length - 1) {
                        array.push(elicitedTrigger[i]);
                    }
                }

                if (triggerIsClassified) {
                    break;
                }
            }
        }
        return array;
    }

    return null;
}

function renderClassifiedGestures(target, type) {
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
    $(target).empty();

    if (classification) {
        if (classification.assignments && classification.assignments.length > 0) {

            if (classification.type === TYPE_CLASSIFICATION_APPEARANCE_TRIGGER) {
                if (type === POTENTIAL_GESTURES) {
                    renderGestureGuessabilityTable(target, classification.assignments);
//                    renderPotentialGesturesTotalStatistics(target, classification.assignments);
                }

                var trigger = getUniqueTrigger();
                for (var i = 0; i < trigger.length; i++) {
                    var counter = 0;
                    var container = $('#template-study-container').find('#amount-container-appearance-trigger').clone();
                    TweenMax.from(container, .2, {delay: .2 + (i * .1), opacity: 0, y: -20});

                    container.find('#headline .text').text(translation.gesturesForTrigger + ': ' + trigger[i].title);
//                    if (type === POTENTIAL_GESTURES) {
//                        renderPotentialGestureSpecificStatistics(container, classification.assignments, classification.type, trigger[i].id);
//                    }

                    for (var j = 0; j < classification.assignments.length; j++) {
                        var assignment = classification.assignments[j];
                        if (parseInt(assignment.triggerId) === parseInt(trigger[i].id)) {
                            counter++;
                            $(container).find('#headline .badge').text(counter + ' ' + (counter === 1 ? translation.Class : translation.Classes));

                            var appearanceTriggerGesture = $('#template-study-container').find('#appearance-trigger-gesture').clone().removeAttr('id');
                            if (type === POTENTIAL_GESTURES) {
                                appearanceTriggerGesture = $('#template-study-container').find('#appearance-trigger-gesture-potential').clone();
                            }

                            appearanceTriggerGesture.attr('data-main-gesture-id', assignment.mainGestureId);
                            appearanceTriggerGesture.find('#headline-trigger-gesture').text(translation.Class + ' ' + counter);
                            $(container).find('#item-view').append(appearanceTriggerGesture);
                            updateGestureAssignmentInfos(container, type, assignment.mainGestureId, assignment);

                            var horizontalLine = document.createElement('hr');
                            $(horizontalLine).css({marginTop: type === POTENTIAL_GESTURES ? '10px' : '20px', marginBottom: type === POTENTIAL_GESTURES ? '80px' : '20px'});
                            $(container).find('#item-view').append(horizontalLine);
                        }
                    }

                    if (counter > 0) {
                        $(target).append(container);
                        $(container).find('[data-main-gesture-id]').last().css({marginBottom: '0px'});
                        $(container).find('#item-view hr').last().remove();
                    }
                }
            } else if (classification.type === TYPE_CLASSIFICATION_APPEARANCE) {
                for (var j = 0; j < classification.assignments.length; j++) {
                    var container = $('#template-study-container').find('#amount-container-appearance-trigger').clone();
                    TweenMax.from(container, .2, {delay: .2 + (i * .1), opacity: 0, y: -20});
                    $(target).append(container);

                    var assignment = classification.assignments[j];
//                    console.log(TYPE_CLASSIFICATION_APPEARANCE, assignment);
//                    renderPotentialGestureSpecificStatistics(container, assignment, classification.type);
                    var appearanceTriggerGesture = $('#template-study-container').find('#appearance-trigger-gesture').clone().removeAttr('id');
                    if (type === POTENTIAL_GESTURES) {
                        appearanceTriggerGesture = $('#template-study-container').find('#appearance-trigger-gesture-potential').clone();
                    }

                    container.find('#headline .text').text(translation.Class + ' ' + (j + 1));
                    container.find('#headline .badge').text(assignment.gestures.length === 1 ? assignment.gestures.length + ' ' + translation.gesture : assignment.gestures.length + ' ' + translation.gestures);

                    appearanceTriggerGesture.attr('data-main-gesture-id', assignment.mainGestureId);
                    container.find('#item-view').append(appearanceTriggerGesture);
                    updateGestureAssignmentInfos(container, type, assignment.mainGestureId, assignment);
                    $(container).find('[data-main-gesture-id]').css({marginBottom: '0px'});
                }

            }


            $('#custom-modal').unbind('gestureUpdated').bind('gestureUpdated', function (event) {
                event.preventDefault();
                renderClassifiedGestures(target, type);
            });

            initPopover(300);
        } else {
            appendAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
        }
    } else {
        appendAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
    }

    addUpdateMainGestureButtonEvent();
}

function updateGestureAssignmentInfos(container, type, updateId, assignment) {
    var target = $(container).find('[data-main-gesture-id=' + updateId + ']');
    $(target).attr('data-main-gesture-id', assignment.mainGestureId);

    if (assignment.gestures.length > 1) {
        $(target).find('#more-classified-gestures').removeClass('hidden');
    } else {
        $(target).find('#more-classified-gestures').addClass('hidden');
    }

    if (type === POTENTIAL_GESTURES) {
        $(target).find('#potential-parameters-container').children().not('#potential-parameters').remove();
    }
    $(target).find('#gestures-list-container').empty();

    for (var k = 0; k < assignment.gestures.length; k++) {
        var gesture = getGestureById(assignment.gestures[k], ELICITED_GESTURES);
        if (gesture) {
            var gestureType = 'classified-gestures-catalog-thumbnail';
            if (type === POTENTIAL_GESTURES) {
                gestureType = 'potential-gestures-catalog-thumbnail';
            }

            var involvedGesture = getGestureCatalogListThumbnail(gesture, gestureType, 'col-xs-6 col-md-4 col-lg-4', ELICITED_GESTURES);
            if ((type === POTENTIAL_GESTURES && parseInt(assignment.mainGestureId) !== parseInt(gesture.id)) || type !== POTENTIAL_GESTURES) {
                $(target).find('#gestures-list-container').append(involvedGesture);

                if (parseInt(assignment.mainGestureId) === parseInt(gesture.id)) {
                    $(involvedGesture).find('.gesture-thumbnail').addClass('assembled');
                    $(involvedGesture).find('.btn-tag-as-main-gesture').addClass('gesture-tagged');
                    $(involvedGesture).find('.btn-tag-as-main-gesture').attr('data-content', translation.gestureTaggedAsMain);
                }
            } else if (type === POTENTIAL_GESTURES && parseInt(assignment.mainGestureId) === parseInt(gesture.id)) {
                involvedGesture = getGestureCatalogListThumbnail(gesture, gestureType, 'col-xs-12 col-md-5', ELICITED_GESTURES);
                $(target).find('#potential-parameters-container').prepend(involvedGesture);
            }
        } // else the participant data is marked as pretest
    }

    if (type === POTENTIAL_GESTURES) {
        renderPotentialGesturesParameters(target, assignment);
    }
}

function getClassifiedGestureIndex(gesture) {
    var classification = getLocalItem(CLASSIFICATION_GESTURES).assignments;
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

    if (gesturesLeft.length > 0 && gesturesLeftIndex < gesturesLeft.length) {
        updateMatchingView(true, true);
        removeAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
    } else {
        checkGestureClassificationType();
        renderClassifiedGestures($('#classified-gestures'));
        $('#gesture-classification').addClass('hidden');
        appendAlert($('#content-btn-gesture-classification'), ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION);
    }
});

$(document).on('click', '#btn-gesture-no', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var leftId = parseInt($('#gesture-left').children().attr('id'));
    var leftGesture = getGestureById(leftId, ELICITED_GESTURES);

    if (gesturesRightIndex < gesturesRight.length - 1) {
        console.log('more rights', gesturesRight.length);
        gesturesRightIndex++;
        updateMatchingView(false, true);
    } else if (gesturesLeftIndex < gesturesLeft.length - 1) {
        console.log('no more rights, classify gesture');
        classifyGesture(leftGesture, false);
        gesturesLeftIndex++;
        gesturesRightIndex = 0;
        updateMatchingView(true, true);
        removeAlert($('#content-btn-gesture-classification'), ALERT_NO_GESTURES_CLASSIFIED);
    } else {
        console.log('no more gestures');
        classifyGesture(leftGesture, false);
        checkGestureClassificationType();
        renderClassifiedGestures($('#classified-gestures'));
        $('#gesture-classification').addClass('hidden');
        appendAlert($('#content-btn-gesture-classification'), ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION);
    }
});

function classifyGesture(gesture, foundMatch) {
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
    if (foundMatch) {
        if (classification && classification.assignments && classification.assignments.length > 0) {
            var matchedSourceGesture = gesturesRight[gesturesRightIndex];
            if (classification.type === TYPE_CLASSIFICATION_APPEARANCE) {
                classification.assignments[gesturesRightIndex].gestures.push(gesture.id);
            } else {
                if (parseInt(matchedSourceGesture.triggerId) === parseInt(gesture.triggerId)) {
                    for (var i = 0; i < classification.assignments.length; i++) {
                        if (parseInt(classification.assignments[i].mainGestureId) === parseInt(matchedSourceGesture.mainGestureId)) {
                            classification.assignments[i].gestures.push(gesture.id);
                        }
                    }
                } else {
                    var matchedSameAsAssignment = false;
                    for (var i = 0; i < classification.assignments.length; i++) {
                        if (parseInt(classification.assignments[i].sameAs) === parseInt(matchedSourceGesture.mainGestureId)) {
                            classification.assignments[i].gestures.push(gesture.id);
                            matchedSameAsAssignment = true;
                            break;
                        }
                    }

                    if (matchedSameAsAssignment === false) {
                        classification.assignments.push({mainGestureId: gesture.id, triggerId: gesture.triggerId, sameAs: matchedSourceGesture.mainGestureId, gestures: [gesture.id]});
                    }
                }
            }
        } else {
            classification.assignments = [{mainGestureId: gesture.id, triggerId: gesture.triggerId, gestures: [gesture.id]}];
            gesturesRight = classification.assignments;
        }
    } else {
        if (classification && classification.assignments && classification.assignments.length > 0) {
            classification.assignments.push({mainGestureId: gesture.id, triggerId: gesture.triggerId, gestures: [gesture.id]});
            gesturesRight.push({mainGestureId: gesture.id, triggerId: gesture.triggerId, gestures: [gesture.id]});
        } else {
            classification.assignments = [{mainGestureId: gesture.id, triggerId: gesture.triggerId, gestures: [gesture.id]}];
            gesturesRight = classification.assignments;
        }
    }

    setLocalItem(CLASSIFICATION_GESTURES, classification);
    saveClassification();
    $('#btn-reclassify-gestures').removeClass('disabled');
}

function reclassifiyGesture(gesture) {
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
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

    for (var i = 0; i < gesturesRight.length; i++) {
        if (parseInt(gesture.id) === parseInt(gesturesRight[i].id)) {
            gesturesRight.splice(i, 1);
        }
    }

    setLocalItem(CLASSIFICATION_GESTURES, classification);
}

var classificationType = null;
function saveClassification() {
    var classificationGestures = getLocalItem(CLASSIFICATION_GESTURES);
    var classificationTrigger = getLocalItem(CLASSIFICATION_TRIGGER);
    var studyId = getLocalItem(STUDY).id;

    saveExtractionData({studyId: studyId, classification: {gestures: classificationGestures, trigger: classificationTrigger}}, function (result) {
        if (result.status === RESULT_SUCCESS) {
//            console.log('classification saved');
        } else {
//            console.log('save classification error');
        }

        if (classificationType === ELICITED_GESTURES) {
            checkGestureClassificationType();
        } else if (classificationType === ELICITED_TRIGGER) {
            checkTriggerClassificationType();
        }
    });
}

function renderChecklist() {
    var classification = null;
    var updateId = null;
    if (classificationType === ELICITED_GESTURES) {
        classification = getLocalItem(CLASSIFICATION_GESTURES);
        updateId = CLASSIFICATION_GESTURES;
    } else if (classificationType === ELICITED_TRIGGER) {
        classification = getLocalItem(CLASSIFICATION_TRIGGER);
        updateId = CLASSIFICATION_TRIGGER;
    }

    var useChecklistSwitch = classificationType === ELICITED_TRIGGER ? $('#trigger-extraction-content').find('#use-checklist-switch') : $('#gesture-extraction-content').find('#use-checklist-switch');
    var alertContainer = classificationType === ELICITED_TRIGGER ? $('#trigger-extraction-content').find('#content-btn-checklist') : $('#gesture-extraction-content').find('#content-btn-checklist');

//    var predefinedItems = null;
//    if (classificationType === ELICITED_GESTURES) {
//        predefinedItems = translation.extractionChecklistItems;
//    }

    if (classification && classification.checklist && classification.checklist.items !== '' && classification.checklist.items !== null) {
        $(useChecklistSwitch).find('#' + classification.checklist.used).click();
    } else {
        if (!classification) {
            classification = {};
        }
        classification.checklist = {used: 'no', items: null};
        setLocalItem(updateId, classification);
    }

    var listContainer = classificationType === ELICITED_TRIGGER ? $('#trigger-extraction-content').find('#checklist-container') : $('#gesture-extraction-content').find('#checklist-container');
    $(listContainer).empty();

    if (classification.checklist.items && classification.checklist.items.length > 0) {
        for (var i = 0; i < classification.checklist.items.length; i++) {
            renderFormatItem(listContainer, classification.checklist.items[i]);
            updateBadges(listContainer, classification.checklist.items[i].format);
        }
        checkCurrentListState(listContainer);
    } else {
        appendAlert(alertContainer, ALERT_NO_DATA_QUESTIONNAIRE);
    }

    $(useChecklistSwitch).unbind('change').bind('change', function (event) {
        event.preventDefault();
        var activeId = $(this).find('.btn-option-checked').attr('id');
//        console.log('active id', activeId, $(this).find('.btn-option-checked').attr('id'))
        var classification = getLocalItem(updateId);
        classification.checklist.used = activeId;
        setLocalItem(updateId, classification);
        saveChecklist(activeId === 'yes');
    });


    var buttonGroup = classificationType === ELICITED_TRIGGER ? $('#trigger-extraction-content').find('#add-question-button-group') : $('#gesture-extraction-content').find('#add-question-button-group');
    initQuestionnaireButtonGroup(buttonGroup, listContainer, alertContainer, true, true, ALERT_NO_DATA_QUESTIONNAIRE);
    function initQuestionnaireButtonGroup(buttonGroup, listContainer, alertContainer, initListItemAdded, initChange, alertFormat) {
        $(buttonGroup).unbind('change').bind('change', function (event) {
            var itemType = $(event.target).attr('id');
            var clone = $('#form-item-container').find('#' + itemType).clone();
            clone.attr('id', itemType);
            clone.attr('name', chance.natural());
            initJustificationFormElements(clone);
            tweenAndAppend(clone, $(event.target), listContainer, itemType);
        });

        if (initListItemAdded === true) {
            initQuestionnaireListItemAdded(listContainer, alertContainer);
        }

        if (initChange === true) {
            initQuestionnaireListChange(listContainer, alertContainer, alertFormat);
        }
    }

    function initQuestionnaireListItemAdded(listContainer, alertContainer) {
        $(listContainer).unbind('listItemAdded').bind('listItemAdded', function (event) {
            event.preventDefault();
            var addedElement = $(event.target).children().last();
            initializeItemType(addedElement);
            clearAlerts(alertContainer);
            var newScrollTop = Math.max(0, $(addedElement).offset().top + $(addedElement).height() - $(window).height() + 190); // 190 due to padding-top 110px + padding-bottom 80px
            $('html,body').animate({
                scrollTop: newScrollTop
            }, 200);
            $(listContainer).find('.filter-options').remove();
            saveChecklist(true);
        });
    }

    function initQuestionnaireListChange(listContainer, alertContainer, alertFormat) {
        $(listContainer).unbind('change').bind('change', function (event) {
            if ($(this).children().length > 0) {
                clearAlerts(alertContainer);
            } else if (alertFormat) {
                appendAlert(alertContainer, alertFormat);
            }

//            var activeId = $(useChecklistSwitch).find('.btn-option-checked').attr('id');
            saveChecklist(true);
        });
    }

    initQuestionnairePreview($(alertContainer).find('.btn-preview-questionnaire'), listContainer);
    function initQuestionnairePreview(button, list) {
        $(button).unbind('click').bind('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                var itemList = $(list).children();
                var questionnaire = new Array();
                for (var i = 0; i < itemList.length; i++) {
                    questionnaire.push(getFormatData(itemList[i]));
                }

                currentPreviewData = questionnaire;
                loadHTMLintoModal('custom-modal', 'externals/modal-preview.php', 'modal-lg');
            }
        });

        if ($(list).children().length === 0) {
            $(button).addClass('disabled');
        }

        $(list).bind('change listItemAdded', function (event) {
            if ($(this).children().length > 0) {
                $(button).removeClass('disabled');
            } else {
                $(button).addClass('disabled');
            }
        });
    }

    function saveChecklist(saveItems) {
        var classification = null;
        if (classificationType === ELICITED_GESTURES) {
            classification = getLocalItem(CLASSIFICATION_GESTURES);
        } else if (classificationType === ELICITED_TRIGGER) {
            classification = getLocalItem(CLASSIFICATION_TRIGGER);
        }

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

        setLocalItem(updateId, classification);
        saveClassification();
    }

    /*
     * functions cound use for all overlay formats
     */

    function tweenAndAppend(item, triggerElement, container, itemType) {
        var tweenTarget = container.children().last();
        var tweenTargetOffset = !tweenTarget || (tweenTarget && tweenTarget.length === 0) ? $(container).offset() : $(tweenTarget).offset();
        var tweenElementOffset = $(triggerElement).offset();
        var tweenOffset = {offsetY: tweenTargetOffset.top - tweenElementOffset.top + tweenTarget.height(), offsetX: tweenTargetOffset.left - tweenElementOffset.left};
        var alphaY = tweenOffset.offsetY < 0 ? '' + tweenOffset.offsetY : '+' + tweenOffset.offsetY;
        var alphaX = tweenOffset.offsetX < 0 ? '' + tweenOffset.offsetX : '+' + tweenOffset.offsetX;
        TweenMax.to($(triggerElement), .3, {x: alphaX, y: alphaY, opacity: 0, clearProps: 'all', ease: Quad.easeIn, onComplete: onMoveComplete, onCompleteParams: [item, container, itemType]});
    }

    function onMoveComplete(clone, listContainer, itemType) {
        $(listContainer).append(clone);
        checkCurrentListState(listContainer);
        if (itemType) {
            updateBadges(listContainer, itemType);
        }

        TweenMax.from(clone, 1, {y: -40, opacity: 0, ease: Elastic.easeOut, clearProps: 'all'});
        $(listContainer).trigger('listItemAdded', [clone]);
        initPopover();
    }
}

function renderPotentialGestures() {
    $('#content-btn-potential-gestures').empty();
    renderClassifiedGestures($('#content-btn-potential-gestures'), POTENTIAL_GESTURES);
}

function renderGestureSets() {
    var formatClone = $('#content-btn-gesture-sets');
    currentFilterList = $(formatClone).find('#gesture-sets-container').empty();

    getGestureSets(function (result) {
        if (result.status === RESULT_SUCCESS) {
            originalFilterData = result.gestureSets;
            setLocalItem(GESTURE_SETS, result.gestureSets);
            if (originalFilterData && originalFilterData.length > 0) {
                var data = {
                    pager: {
                        top: $(formatClone).find('#pager-top .pagination'),
                        bottom: $(formatClone).find('#pager-bottom .pagination'),
                        dataLength: originalFilterData.length,
                        maxElements: parseInt($(formatClone).find('#resultsCountSelect .chosen').attr('id').split('_')[1])
                    },
                    filter: {
                        countSelect: $(formatClone).find('#resultsCountSelect'),
                        filter: $(formatClone).find('#filter'),
                        sort: $(formatClone).find('#sort')
                    }
                };
                initPagination(data);
                $(formatClone).find('#sort #newest').removeClass('selected');
                $(formatClone).find('#sort #newest').click();
            } else {
                // show alert that no data is there
            }



//            setLocalItem(GESTURE_SETS, result.gestureSets);
//
//            if (result.gestureSets && result.gestureSets.length > 0) {
//                for (var i = 0; i < result.gestureSets.length; i++) {
//                    var set = result.gestureSets[i];
//                    var setPanel = getGestureCatalogGestureSetPanel(set, 'potential-gestures-catalog-thumbnail', 'col-xs-6 col-md-4');
//
//                    $('#content-btn-gesture-sets #gesture-sets-container').append(setPanel);
//                    TweenMax.from(setPanel, .2, {delay: i * .1, opacity: 0, y: -20});
//
//                    $(setPanel).unbind('gestureSetDeleted').bind('gestureSetDeleted', function (event) {
//                        event.preventDefault();
//                        renderGestureSets();
//                    });
//                }
//
//                $('#custom-modal').unbind('gestureSetsUpdated').bind('gestureSetsUpdated', function (event) {
//                    event.preventDefault();
//                    renderGestureSets();
//                });
//            } else {
//                // append alert, no gesture set(s) available
//            }
//            initPopover(300);
        }
    });
//
//    $(currentFilterList).unbind('change').bind('change', function (event, gestureId, assemble, rerender) {
//        console.log('current  filter list changed');
//        event.preventDefault();
//        var tweenParams = initAddGestureToStudyGestures($(event.target), formatClone);
//        if (assemble) {
//            assembleGesture(gestureId);
//            TweenMax.to(tweenParams.tweenElement, .4, {x: tweenParams.alphaX, y: tweenParams.alphaY, opacity: 0, scale: 0, rotation: tweenParams.rotation, transformOrigin: "left top", clearProps: 'all', ease: Quad.easeOut, onComplete: function () {
//                    if (rerender) {
//                        renderData(originalFilterData);
//                    }
//                    updateCatalogButtons();
//                    updateNavBadges();
//                }});
//        } else {
//            reassembleGesture(gestureId);
//            if (rerender) {
//                renderData(originalFilterData);
//            }
//            updateCatalogButtons();
//            updateNavBadges();
//        }
//    });

    $(currentFilterList).unbind('gestureSetDeleted').bind('gestureSetDeleted', function (event) {
        getGestureSets(function (result) {
            if (result.status === RESULT_SUCCESS) {
                originalFilterData = result.gestureSets;
                setLocalItem(GESTURE_SETS, result.gestureSets);
                renderGestureSetList(originalFilterData);
            }
        });
    });

    $(formatClone).find('.filter').unbind('change').bind('change', function (event) {
        event.preventDefault();
        currentFilterData = sort();
        updatePaginationItems();
        if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
            $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
        } else {
            renderGestureSetList(currentFilterData, true);
        }
    });

    $(formatClone).find('.sort').unbind('change').bind('change', function (event) {
        event.preventDefault();
        currentFilterData = sort();
        updatePaginationItems();
        if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
            $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
        } else {
            renderGestureSetList(currentFilterData, true);
        }
    });

    $(formatClone).find('.resultsCountSelect').unbind('change').bind('change', function (event) {
        event.preventDefault();
        currentFilterData = sort();
        updatePaginationItems();
        if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
            $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
        } else {
            renderGestureSetList(currentFilterData, true);
        }
    });

    $(formatClone).unbind('indexChanged').bind('indexChanged', '.pagination', function (event, index) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            renderGestureSetList(sort(), true);
        }
    });

    $(currentFilterList).unbind('renderData').bind('renderData', function (event, data) {
        event.preventDefault();
        renderGestureSetList(data);
    });


    function renderGestureSetList(data, animation) {
        var currentActiveTab = formatClone;
        currentFilterData = data;
        $(currentFilterList).empty();
        var index = getCurrentPaginationIndex();
        var listCount = parseInt($(currentPaginationData.filter.countSelect).find('.chosen').attr('id').split('_')[1]);
        var viewFromIndex = index * listCount;
        var viewToIndex = Math.min((index + 1) * listCount, currentFilterData.length);
        var count = 0;

        if (currentFilterData.length > 0) {
            clearAlerts($(currentActiveTab).find('#item-view'));
            for (var i = viewFromIndex; i < viewToIndex; i++) {
                var clone = getGestureCatalogGestureSetPanel(currentFilterData[i], null, 'col-xs-12 col-sm-12 col-md-6 col-lg-4');
                $(currentFilterList).append(clone);
                if (animation && animation === true) {
                    TweenMax.from(clone, .2, {delay: count * .03, opacity: 0, y: -10});
                }
            }
        } else {
            appendAlert($(currentActiveTab).find('#item-view'), ALERT_NO_SEARCH_RESULTS);
            $(currentActiveTab).find('#item-view #pager-top .pagination').addClass('hidden');
            $(currentActiveTab).find('#item-view #pager-bottom .pagination').addClass('hidden');
        }

        initPopover();
        initTooltips();
//        updateNavBadges();
    }

    $('#btn-add-gesture-set').unbind('click').bind('click', function (event) {
        event.preventDefault();
        removeAlert($('#content-btn-gesture-sets'), ALERT_GESTURE_SET_TITLE_TOO_SHORT);
        if (!$(this).hasClass('disabled')) {
            var button = $(this);
            lockButton(button, true, 'fa-plus');
            var title = $('#content-btn-gesture-sets').find('#input-new-set-title').val();
            if (title && title !== undefined && title.trim() !== '') {
                if (title.trim().length > 7) {
                    var query = getQueryParams(document.location.search);
                    saveGestureSetForStudyId({studyId: query.studyId, title: title}, function (result) {
                        unlockButton(button, true, 'fa-plus');
                        if (result.status === RESULT_SUCCESS) {
                            $('#content-btn-gesture-sets').find('#input-new-set-title').val('');
//                            renderGestureSets();
                            getGestureSets(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestureSets;
                                    setLocalItem(GESTURE_SETS, result.gestureSets);
                                    renderGestureSetList(originalFilterData);
                                }
                            });
                        }
                    });
                } else {
                    unlockButton(button, true, 'fa-plus');
                    appendAlert($('#content-btn-gesture-sets'), ALERT_GESTURE_SET_TITLE_TOO_SHORT);
                }
            } else {
                unlockButton(button, true, 'fa-plus');
                // show errors for invalid input 
            }
        }
    });
}

var currentAssignment = null;
function renderPotentialGesturesParameters(target, assignment, mainGesture) {
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
    if (classification.type === TYPE_CLASSIFICATION_APPEARANCE_TRIGGER) {
        $(target).find('#potential-parameters').empty().append($('#potential-gesture-parameters-appearance-trigger').clone());

        // amount
        var triggerId = assignment.triggerId;
        var trigger = getTriggerById(triggerId);
        var amountRange = getAmountRange(triggerId);
        $(target).find('#parameters-amount .trigger .address').text(translation.trigger + ':');
        $(target).find('#parameters-amount .trigger .text').text(trigger.title);
        $(target).find('#parameters-amount .amount-specific .text').text(assignment.gestures.length + ' ' + (assignment.gestures.length === 1 ? translation.gesture : translation.gestures));
        $(target).find('#parameters-amount .amount-specific .address').text(translation.forThisClass);
        $(target).find('#parameters-amount .amount-minimal-function .text').text(amountRange.min + ' ' + (amountRange.min === 1 ? translation.gesture : translation.gestures) + ' ' + translation.perClass);
        $(target).find('#parameters-amount .amount-minimal-function .address').text(translation.Minimal + ':');
        $(target).find('#parameters-amount .amount-maximal-function .text').text(amountRange.max + ' ' + (amountRange.max === 1 ? translation.gesture : translation.gestures) + ' ' + translation.perClass);
        $(target).find('#parameters-amount .amount-maximal-function .address').text(translation.Maximal + ':');
        if (amountRange.max > amountRange.min) {
            if (assignment.gestures.length === amountRange.max) {
                target.find('#parameters-amount #well').removeClass('hidden');
            } else if (assignment.gestures.length === amountRange.min) {
                target.find('#parameters-amount #less-well').removeClass('hidden');
            }
        } else {
            // can't found best gesture for these trigger, because every gesture are demonstrated the same amount
            target.find('#parameters-amount #even').removeClass('hidden');
        }

        // agreement measures
//        var agreementMeasures = getAgreementMeasures(assignment, TYPE_CLASSIFICATION_APPEARANCE_TRIGGER);
//        $(target).find('#agreement .text').text(agreementMeasures + '%');
//        if (amountRange.max > 1) {
//            var agreementMeasures = getAgreementMeasures(assignment, TYPE_CLASSIFICATION_APPEARANCE_TRIGGER);
//            if (agreementMeasures) {
//                $(target).find('#agreement .text').text(agreementMeasures + '%');
//            } else {
//                $(target).find('#agreement .text').text('Konnte nicht berechnet werden, da diese Geste nur einmal vorkommt.');
//            }
//        }

        // guessability / accordance
//        var accordance = parseFloat(getAccordance(triggerId).toFixed(2));
//        $(target).find('#parameters-guessability').removeClass('hidden');
//        $(target).find('#accordance .text').text(accordance === 1 ? '1.00' : accordance);
//
//        if (accordance <= 0) {
//            $(target).find('#parameters-guessability .lowAgreement').removeClass('hidden');
//        } else if (accordance >= 1) {
//            $(target).find('#parameters-guessability .veryHighAgreement').removeClass('hidden');
//        } else {
//            var agreementMargins = AGREEMENT_MARGINS;
//            for (var i = 0; i < agreementMargins.length; i++) {
//                var min = i > 0 ? agreementMargins[i - 1].max : 0;
//                var max = agreementMargins[i].max;
//                if (accordance > min && accordance <= max) {
//                    $(target).find('#parameters-guessability .' + agreementMargins[i].interpretation).removeClass('hidden');
//                    break;
//                }
//            }
//        }
    } else if (classification.type === TYPE_CLASSIFICATION_APPEARANCE) {
        $(target).find('#potential-parameters').empty().append($('#potential-gesture-parameters-appearance').clone());

        var trigger = getUniqueTrigger();

        for (var i = 0; i < trigger.length; i++) {
            var item = $('#potential-gesture-parameters-appearance-trigger-amount-item').clone().removeAttr('id');
            $(item).find('#trigger-title').text(trigger[i].title);
            $(target).find('#potential-parameters #parameters-amount #trigger-container').append(item);

            if (i > 0) {
                $(item).css({marginTop: '10px'});
            }

            var count = 0;
            for (var j = 0; j < assignment.gestures.length; j++) {
                var gesture = getGestureById(assignment.gestures[j], ELICITED_GESTURES);
                if (parseInt(gesture.triggerId) === parseInt(trigger[i].id)) {
                    count++;
                }
            }

            $(item).find('#justification').text(count + ' ' + translation.of + ' ' + assignment.gestures.length + ' ' + translation.classifiednGestures);
        }
    }

    // cognitive relationships
    $(target).find('#btn-open-cognitive-relationships').unbind('click').bind('click', function (event) {
        event.preventDefault();
        currentAssignment = getAssignmentByMainGestureId($(this).closest('.root').attr('data-main-gesture-id'));
        loadHTMLintoModal('custom-modal', 'externals/modal-cognitive-relationships.php', 'modal-lg');
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
            currentAssignment = getAssignmentByMainGestureId($(this).closest('.root').attr('data-main-gesture-id'));
            loadHTMLintoModal('custom-modal', 'externals/modal-checklist.php', 'modal-lg');
        });

        if (assignment.checklist && assignment.checklist.objectiveAnswer) {
            target.find('#parameters-checklist #' + assignment.checklist.objectiveAnswer).removeClass('hidden');
        } else {
            target.find('#parameters-checklist #not-checked').removeClass('hidden');
        }
    }

    // attached gesture sets
    function updateAttachtedGestureSets(mainGestureId, getLocalGestureSets) {
        var thumbnail = $('#content-btn-potential-gestures').find('[data-main-gesture-id=' + mainGestureId + ']');
        $(thumbnail).find('#attached-gesture-sets-container').empty();

        if (getLocalGestureSets && getLocalGestureSets === true) {
            renderAttachedSets(getAttachedGestureSets(mainGestureId), thumbnail);
        } else {
            getGestureSets(function (result) {
                if (result.status === RESULT_SUCCESS) {
                    setLocalItem(GESTURE_SETS, result.gestureSets);
                    renderAttachedSets(getAttachedGestureSets(mainGestureId), thumbnail);
                }
            });
        }
    }

    function renderAttachedSets(sets, thumbnail) {
        if (sets && sets.length > 0) {
            $(thumbnail).find('#parameters-gesture-sets #not-assigned').addClass('hidden');
            for (var i = 0; i < sets.length; i++) {
                var item = $('#attached-gesture-set-item').clone().removeAttr('id');
                $(item).find('#gesture-set-title').text(sets[i].title);
                $(thumbnail).find('#attached-gesture-sets-container').append(item);
            }
        } else {
            $(thumbnail).find('#parameters-gesture-sets #not-assigned').removeClass('hidden');
        }
    }

    setTimeout(function () {
        updateAttachtedGestureSets(assignment.mainGestureId, true);
    }, 100);


    $('#custom-modal').unbind('gestureSetsUpdated').bind('gestureSetsUpdated', function (event, gestureId) {
        event.preventDefault();
        updateAttachtedGestureSets(gestureId, true);
    });
}

function renderGestureGuessabilityTable(target, assignments) {
    var table = $('#template-study-container').find('#guessability-table').clone();
    $(target).append(table);
    var trigger = getUniqueTrigger();
    var amountAccordance = 0.00;

    for (var i = 0; i < trigger.length; i++) {
        for (var j = 0; j < assignments.length; j++) {
            var assignment = assignments[j];
            if (parseInt(assignment.triggerId) === parseInt(trigger[i].id)) {
                var gesture = getGestureById(assignment.mainGestureId);

                var row = document.createElement('tr');
                $(table).find('.table-body').append(row);

                var mainRow = $(table).find('[data-trigger-id=' + trigger[i].id + ']');
                var mainRowExists = $(mainRow).length > 0;
                if (mainRowExists) {
                    var currentRowSpan = parseInt($($(mainRow).find('td')[0]).attr('rowspan'));
                    $($(mainRow).find('td')[0]).attr('rowspan', currentRowSpan + 1);
                } else {
                    $(row).attr('data-trigger-id', trigger[i].id);

                    var col = document.createElement('td');
                    $(col).attr('rowspan', 1);
                    $(col).text(trigger[i].title);
                    $(row).append(col);
                }

                var col = document.createElement('td');
                $(col).text(assignment.gestures.length + 'x ' + gesture.title);
                $(col).addClass('hover-cell');
                $(col).attr('scroll-to-gesture', gesture.id);
                $(row).append(col);
                $(col).unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    var linkId = parseInt($(this).attr('scroll-to-gesture'));
                    var scrollToGesture = $('#content-btn-potential-gestures').find('#item-view #' + linkId);
                    $('html, body').animate({
                        scrollTop: ($(scrollToGesture).offset().top - 100) + 'px'
                    }, 'fast');
                });

                // agreement score
//                var agreementScore = getAgreementMeasures(assignment, TYPE_CLASSIFICATION_APPEARANCE_TRIGGER);

//                var col = document.createElement('td');
//                $(col).text(agreementScore + '%');
//                $(row).append(col);

                if (mainRowExists) {
                    var currentRowSpan = parseInt($($(mainRow).find('td')[0]).attr('rowspan'));
                    $($(mainRow).find('td').last()).attr('rowspan', currentRowSpan);
                } else {
                    // guessability / accordance
                    var accordance = getAccordance(trigger[i].id).toFixed(2);
                    amountAccordance += parseFloat(accordance);

                    var col = document.createElement('td');
                    $(col).attr('rowspan', 1);
                    $(col).text(accordance);
                    $(row).append(col);
                }
            }
        }
    }

    var meanAccordance = (amountAccordance / trigger.length).toFixed(2);
    var meanAccordanceItem = $('#template-study-container').find('#mean-accordance-gestures').clone();
    $(meanAccordanceItem).find('#accordance-amount').text(meanAccordance);
    $(target).append(meanAccordanceItem);

    if (meanAccordance <= .1) {
        $(meanAccordanceItem).find('.lowAgreement').removeClass('hidden');
    } else if (meanAccordance <= .3) {
        $(meanAccordanceItem).find('.mediumAgreement').removeClass('hidden');
    } else if (meanAccordance <= .5) {
        $(meanAccordanceItem).find('.highAgreement').removeClass('hidden');
    } else {
        $(meanAccordanceItem).find('.veryHighAgreement').removeClass('hidden');
    }
}

function renderPotentialGesturesTotalStatistics(target, assignments) {
    console.log('renderPotentialGesturesTotalStatistics');

    var staticGestures = 0;
    var dynamicGestures = 0;
    var executionMixed = 0;
    var unclassifiedExecutions = 0;
    var discreteInteractions = 0;
    var continuousInteractions = 0;
    var interactionMixed = 0;
    var unclassifiedInteractions = 0;

    if (assignments && assignments.length > 0) {
        var statistics = $('#template-study-container').find('#potential-gesture-statistics').clone().removeAttr('id');
        $(target).append(statistics);

        for (var i = 0; i < assignments.length; i++) {
            var gesture = getGestureById(assignments[i].mainGestureId);
            if (gesture.type !== null) {
                switch (gesture.type) {
                    case TYPE_GESTURE_POSE:
                        staticGestures++;
                        break;
                    case TYPE_GESTURE_DYNAMIC:
                        dynamicGestures++;
                        break;
                    case TYPE_GESTURE_MIXED:
                        executionMixed++;
                        break;
                }
            } else {
                unclassifiedExecutions++;
            }

            if (gesture.interactionType !== null) {
                switch (gesture.interactionType) {
                    case TYPE_GESTURE_DISCRETE:
                        discreteInteractions++;
                        break;
                    case TYPE_GESTURE_CONTINUOUS:
                        continuousInteractions++;
                        break;
                    case TYPE_GESTURE_MIXED:
                        interactionMixed++;
                        break;
                }
            } else {
                unclassifiedInteractions++;
            }
        }

        var chartOptions = {
            rotation: -Math.PI,
            cutoutPercentage: 30,
            circumference: Math.PI
        };

        var ctx = $(statistics).find('.chart-gesture-execution-type');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [translation.gestureTypes.pose, translation.gestureTypes.dynamic, translation.gestureTypes.mixed],
                datasets: [{
                        label: '# of Votes',
                        data: [staticGestures, dynamicGestures, executionMixed],
                        backgroundColor: [
                            '#97CB00',
                            '#4BACC6',
                            '#00FF00'
                        ]
                    }]
            },
            options: chartOptions
        });

        var ctx = $(statistics).find('.chart-gesture-interaction-type');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [translation.gestureInteractionTypes.discrete, translation.gestureInteractionTypes.continuous, translation.gestureInteractionTypes.mixed],
                datasets: [{
                        label: '# of Votes',
                        data: [discreteInteractions, continuousInteractions, interactionMixed],
                        backgroundColor: [
                            '#7030A0',
                            '#FFCB00',
                            '#FF00FF'
                        ]
                    }]
            },
            options: chartOptions
        });

//        console.log(statistics, target);
        $(statistics).find('.amount-static-gestures').text(translation.gestureTypes.pose + ': ' + staticGestures);
        $(statistics).find('.amount-dynamic-gestures').text(translation.gestureTypes.dynamic + ': ' + dynamicGestures);
        $(statistics).find('.amount-total-gesture-executions').text(translation.gestureTypes.total + ': ' + (staticGestures + dynamicGestures));

        $(statistics).find('.amount-discrete-gestures').text(translation.gestureInteractionTypes.discrete + ': ' + discreteInteractions);
        $(statistics).find('.amount-continuous-gestures').text(translation.gestureInteractionTypes.continuous + ': ' + continuousInteractions);
        $(statistics).find('.amount-total-gesture-interactions').text(translation.gestureTypes.total + ': ' + (discreteInteractions + continuousInteractions));
    }
}

function renderPotentialGestureSpecificStatistics(target, assignments, classificationType, triggerId) {
    console.log('renderPotentialGestureSpecificStatistics');
    var staticGestures = 0;
    var dynamicGestures = 0;
    var executionMixed = 0;
    var unclassifiedExecutions = 0;
    var discreteInteractions = 0;
    var continuousInteractions = 0;
    var interactionMixed = 0;
    var unclassifiedInteractions = 0;

    if (assignments || assignments.length > 0) {
        var statistics = $(target).find('.specific-gesture-statistics');

        if (classificationType === TYPE_CLASSIFICATION_APPEARANCE_TRIGGER) {
            for (var i = 0; i < assignments.length; i++) {
                if (parseInt(assignments[i].triggerId) === parseInt(triggerId)) {
                    var gesture = getGestureById(assignments[i].mainGestureId);
                    if (gesture.type !== null) {
                        switch (gesture.type) {
                            case TYPE_GESTURE_POSE:
                                staticGestures++;
                                break;
                            case TYPE_GESTURE_DYNAMIC:
                                dynamicGestures++;
                                break;
                            case TYPE_GESTURE_MIXED:
                                executionMixed++;
                                break;
                        }
                    } else {
                        unclassifiedExecutions++;
                    }

                    if (gesture.interactionType !== null) {
                        switch (gesture.interactionType) {
                            case TYPE_GESTURE_DISCRETE:
                                discreteInteractions++;
                                break;
                            case TYPE_GESTURE_CONTINUOUS:
                                continuousInteractions++;
                                break;
                            case TYPE_GESTURE_MIXED:
                                interactionMixed++;
                                break;
                        }
                    } else {
                        unclassifiedInteractions++;
                    }
                }
            }
        } else if (classificationType === TYPE_CLASSIFICATION_APPEARANCE) {
            if (assignments.gestures && assignments.gestures.length > 0) {
                for (var i = 0; i < assignments.gestures.length; i++) {


                    var gesture = getGestureById(assignments.gestures[i]);
                    if (gesture.type !== null) {
                        switch (gesture.type) {
                            case TYPE_GESTURE_POSE:
                                staticGestures++;
                                break;
                            case TYPE_GESTURE_DYNAMIC:
                                dynamicGestures++;
                                break;
                            case TYPE_GESTURE_MIXED:
                                executionMixed++;
                                break;
                        }
                    } else {
                        unclassifiedExecutions++;
                    }

                    if (gesture.interactionType !== null) {
                        switch (gesture.interactionType) {
                            case TYPE_GESTURE_DISCRETE:
                                discreteInteractions++;
                                break;
                            case TYPE_GESTURE_CONTINUOUS:
                                continuousInteractions++;
                                break;
                            case TYPE_GESTURE_MIXED:
                                interactionMixed++;
                                break;
                        }
                    } else {
                        unclassifiedInteractions++;
                    }
                }
            } else {
                return false;
            }
        }


        var chartOptions = {
            rotation: -Math.PI,
            cutoutPercentage: 30,
            circumference: Math.PI
        };

        var ctx = $(statistics).find('.chart-gesture-execution-type');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [translation.gestureTypes.pose, translation.gestureTypes.dynamic, translation.gestureTypes.continuous],
                datasets: [{
                        label: '# of Votes',
                        data: [staticGestures, dynamicGestures, executionMixed],
                        backgroundColor: [
                            '#97CB00',
                            '#4BACC6',
                            '#00FF00'
                        ]
                    }]
            },
            options: chartOptions
        });

        var ctx = $(statistics).find('.chart-gesture-interaction-type');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [translation.gestureInteractionTypes.discrete, translation.gestureInteractionTypes.continuous, translation.gestureInteractionTypes.mixed],
                datasets: [{
                        label: '# of Votes',
                        data: [discreteInteractions, continuousInteractions, interactionMixed],
                        backgroundColor: [
                            '#7030A0',
                            '#FFCB00',
                            '#FF00FF'
                        ]
                    }]
            },
            options: chartOptions
        });

        $(statistics).find('.amount-static-gestures').text(translation.gestureTypes.pose + ': ' + staticGestures);
        $(statistics).find('.amount-dynamic-gestures').text(translation.gestureTypes.dynamic + ': ' + dynamicGestures);
        $(statistics).find('.amount-total-gesture-executions').text(translation.gestureTypes.total + ': ' + (staticGestures + dynamicGestures));

        $(statistics).find('.amount-discrete-gestures').text(translation.gestureInteractionTypes.discrete + ': ' + discreteInteractions);
        $(statistics).find('.amount-continuous-gestures').text(translation.gestureInteractionTypes.continuous + ': ' + continuousInteractions);
        $(statistics).find('.amount-total-gesture-interactions').text(translation.gestureTypes.total + ': ' + (discreteInteractions + continuousInteractions));
    }
}

function getUniqueTrigger() {
    var trigger = [];
    var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
    for (var i = 0; i < phaseSteps.length; i++) {
        if (phaseSteps[i].format === IDENTIFICATION) {
            
            var phaseStepData = getLocalItem(phaseSteps[i].id + '.data');
            if (phaseStepData.identificationFor === 'gestures') {
                console.log(phaseStepData)
                for (var j = 0; j < phaseStepData.identification.length; j++) {
                    var pushTrigger = getTriggerById(phaseStepData.identification[j].triggerId);
                    if (!triggerExists(trigger, pushTrigger)) {
                        trigger.push(pushTrigger);
                    }
                }
            }
        }
    }

    function triggerExists(trigger, pushTrigger) {
        for (var i = 0; i < trigger.length; i++) {
            console.log(trigger,  pushTrigger);
            if (parseInt(trigger[i].id) === parseInt(pushTrigger.id)) {
                return true;
            }
        }
        return false;
    }

    return trigger;
}

function renderTriggerGuessabilityTable(target, assignments) {
    var table = $('#template-study-container').find('#guessability-table').clone();
    $(target).append(table);

    $(table).find('.table-head-row .basic').text(translation.gesture);
    $(table).find('.table-head-row .effect').text(translation.trigger);

    var gestures = getUniqueGestures();
    var amountAccordance = 0.00;

    for (var i = 0; i < gestures.length; i++) {
        for (var j = 0; j < assignments.length; j++) {
            var assignment = assignments[j];
            if (parseInt(assignment.gestureId) === parseInt(gestures[i].id)) {
                var trigger = getTriggerById(assignment.mainTriggerId, ELICITED_TRIGGER);

                var row = document.createElement('tr');
                $(table).find('.table-body').append(row);

                var mainRow = $(table).find('[data-gesture-id=' + trigger.gestureId + ']');
                var mainRowExists = $(mainRow).length > 0;
                if (mainRowExists) {
                    var currentRowSpan = parseInt($($(mainRow).find('td')[0]).attr('rowspan'));
                    $($(mainRow).find('td')[0]).attr('rowspan', currentRowSpan + 1);
                } else {
                    $(row).attr('data-gesture-id', trigger.gestureId);

                    var col = document.createElement('td');
                    $(col).attr('rowspan', 1);
                    $(col).text(trigger.title);
                    $(row).append(col);
                }

                var col = document.createElement('td');
                $(col).text(assignment.trigger.length + 'x ' + trigger.title);
                $(col).addClass('hover-cell');
                $(col).attr('scroll-to-trigger', trigger.id);
                $(row).append(col);
                $(col).unbind('click').bind('click', function (event) {
                    event.preventDefault();
                    var linkId = parseInt($(this).attr('scroll-to-trigger'));
                    var scrollToTrigger = $('#content-btn-potential-trigger').find('#item-view [data-main-trigger-id=' + linkId + ']');
                    $('html, body').animate({
                        scrollTop: ($(scrollToTrigger).offset().top - 70) + 'px'
                    }, 'fast');
                });

                // agreement score
//                var agreementScore = getAgreementMeasures(assignment, TYPE_CLASSIFICATION_APPEARANCE_GESTURE);

//                var col = document.createElement('td');
//                $(col).text(agreementScore + '%');
//                $(row).append(col);

                if (mainRowExists) {
                    var currentRowSpan = parseInt($($(mainRow).find('td')[0]).attr('rowspan'));
                    $($(mainRow).find('td').last()).attr('rowspan', currentRowSpan);
                } else {
                    // guessability / accordance
                    var accordance = getTriggerAccordance(gestures[i].id).toFixed(2);
                    amountAccordance += parseFloat(accordance);

                    var col = document.createElement('td');
                    $(col).attr('rowspan', 1);
                    $(col).text(accordance);
                    $(row).append(col);
                }
            }
        }
    }

    var meanAccordance = (amountAccordance / gestures.length).toFixed(2);
    var meanAccordanceItem = $('#template-study-container').find('#mean-accordance-trigger').clone();
    $(meanAccordanceItem).find('#accordance-amount').text(meanAccordance);
    $(target).append(meanAccordanceItem);

    if (meanAccordance <= .1) {
        $(meanAccordanceItem).find('.lowAgreement').removeClass('hidden');
    } else if (meanAccordance <= .3) {
        $(meanAccordanceItem).find('.mediumAgreement').removeClass('hidden');
    } else if (meanAccordance <= .5) {
        $(meanAccordanceItem).find('.highAgreement').removeClass('hidden');
    } else {
        $(meanAccordanceItem).find('.veryHighAgreement').removeClass('hidden');
    }
}

function getUniqueGestures() {
    var gestures = [];
    var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
    for (var i = 0; i < phaseSteps.length; i++) {
        if (phaseSteps[i].format === IDENTIFICATION) {
            var phaseStepData = getLocalItem(phaseSteps[i].id + '.data');
            if (phaseStepData.identificationFor === 'trigger') {
                for (var j = 0; j < phaseStepData.identification.length; j++) {
                    var pushGesture = getGestureById(phaseStepData.identification[j].gestureId);
                    if (!gestureExists(gestures, pushGesture)) {
                        gestures.push(pushGesture);
                    }
                }
            }
        }
    }

    function gestureExists(gestures, pushGesture) {
        console.log('push gestures', pushGesture);
        for (var i = 0; i < gestures.length; i++) {
            if (parseInt(gestures[i].id) === parseInt(pushGesture.id)) {
                return true;
            }
        }
        return false;
    }

    return gestures;
}

function getAssignmentByMainGestureId(mainGestureId) {
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(mainGestureId) === parseInt(classification.assignments[i].mainGestureId)) {
            return classification.assignments[i];
            break;
        }
    }
    return null;
}

function getAssignmentByMainTriggerId(id) {
    var classification = getLocalItem(CLASSIFICATION_TRIGGER);
    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(id) === parseInt(classification.assignments[i].mainTriggerId)) {
            return classification.assignments[i];
            break;
        }
    }
    return null;
}

function getAmountRange(id) {
    var classification = null;
    if (classificationType === ELICITED_GESTURES) {
        classification = getLocalItem(CLASSIFICATION_GESTURES);
    } else if (classificationType === ELICITED_TRIGGER) {
        classification = getLocalItem(CLASSIFICATION_TRIGGER);
    }
    console.log('get amount ranger', classificationType, classification);

    var min = 1;
    var max = 0;

    if (classification.assignments.length === 1) {
        if (classificationType === ELICITED_GESTURES) {
            min = classification.assignments[0].gestures.length;
        } else if (classificationType === ELICITED_TRIGGER) {
            min = classification.assignments[0].trigger.length;
        }
    }

    for (var i = 0; i < classification.assignments.length; i++) {
        if (classificationType === ELICITED_GESTURES) {
            if (parseInt(classification.assignments[i].triggerId) === parseInt(id)) {
                if (i === 0) {
                    min = classification.assignments[i].gestures.length;
                    max = classification.assignments[i].gestures.length;
                } else {
                    min = Math.min(classification.assignments[i].gestures.length, min);
                    max = Math.max(classification.assignments[i].gestures.length, max);
                }
            }
        } else if (classificationType === ELICITED_TRIGGER) {
            if (parseInt(classification.assignments[i].gestureId) === parseInt(id)) {
                if (i === 0) {
                    min = classification.assignments[i].trigger.length;
                    max = classification.assignments[i].trigger.length;
                } else {
                    min = Math.min(classification.assignments[i].trigger.length, min);
                    max = Math.max(classification.assignments[i].trigger.length, max);
                }
            }
        }
    }

    return {min: min, max: max};
}

function getGestureEffectAmount(triggerId) {
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
    var amount = 0;
    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(classification.assignments[i].triggerId) === parseInt(triggerId)) {
            amount += classification.assignments[i].gestures.length;
        }
    }
    return amount;
}

function getAccordance(triggerId) {
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
    var accordance = 0;
    var effectAmount = getGestureEffectAmount(triggerId);
    if (effectAmount === 1) {
        return 1.0;
    }

    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(classification.assignments[i].triggerId) === parseInt(triggerId)) {
            accordance += Math.pow((classification.assignments[i].gestures.length / effectAmount), 2);
        }
    }

    accordance = ((effectAmount / (effectAmount - 1)) * accordance) - (1 / (effectAmount - 1));
    return accordance;
}


function getTriggerEffectAmount(gestureId) {
    var classification = getLocalItem(CLASSIFICATION_TRIGGER);
    var amount = 0;
    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(classification.assignments[i].gestureId) === parseInt(gestureId)) {
            amount += classification.assignments[i].trigger.length;
        }
    }
    return amount;
}

function getTriggerAccordance(gestureId) {
    var classification = getLocalItem(CLASSIFICATION_TRIGGER);
    var accordance = 0;
    var effectAmount = getTriggerEffectAmount(gestureId);
    if (effectAmount === 1) {
        return 1.0;
    }

    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(classification.assignments[i].gestureId) === parseInt(gestureId)) {
            accordance += Math.pow((classification.assignments[i].trigger.length / effectAmount), 2);
        }
    }

    accordance = ((effectAmount / (effectAmount - 1)) * accordance) - (1 / (effectAmount - 1));
    return accordance;
}

function getAgreementMeasures(assignment, type) {
    var agreementMeasures = 0;

    if (type === TYPE_CLASSIFICATION_APPEARANCE_TRIGGER) {
        var allSameGestures = 0;
        allSameGestures += assignment.gestures.length;

        var sameAssignments = null;
        if (assignment.sameAs) {
            sameAssignments = getAssignmentsForGestureId(assignment.sameAs);
        } else {
            sameAssignments = getSameGestureByGestureId(assignment.mainGestureId);
        }

        if (sameAssignments && sameAssignments.length > 0) {
            for (var i = 0; i < sameAssignments.length; i++) {
                allSameGestures += sameAssignments[i].gestures.length;
            }
        } else {
            agreementMeasures = 100;
        }

        agreementMeasures = Math.floor(assignment.gestures.length / allSameGestures * 100);
    } else if (type === TYPE_CLASSIFICATION_APPEARANCE_GESTURE) {
        var allSameTrigger = 0;
        allSameTrigger += assignment.trigger.length;

        var sameAssignments = null;
        if (assignment.sameAs) {
            sameAssignments = getAssignmentsForTriggerId(assignment.sameAs);
        } else {
            sameAssignments = getSameGestureByGestureId(assignment.mainTriggerId);
        }

        if (sameAssignments && sameAssignments.length > 0) {
            for (var i = 0; i < sameAssignments.length; i++) {
                allSameTrigger += sameAssignments[i].trigger.length;
            }
        } else {
            agreementMeasures = 100;
        }

        agreementMeasures = Math.floor(assignment.trigger.length / allSameTrigger * 100);
    }

    return agreementMeasures;
}


function getAssignmentsForGestureId(id) {
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
    var assignments = new Array();
    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(classification.assignments[i].mainGestureId) === parseInt(id)) {
            assignments.push(classification.assignments[i]);
        }
    }

    return assignments;
}

function getAssignmentsForTriggerId(id) {
    var classification = getLocalItem(CLASSIFICATION_TRIGGER);
    var assignments = new Array();
    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(classification.assignments[i].mainTriggerId) === parseInt(id)) {
            assignments.push(classification.assignments[i]);
        }
    }

    return assignments;
}

function getSameGestureByGestureId(id) {
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
    var assignments = new Array();
    for (var i = 0; i < classification.assignments.length; i++) {
        if (classification.assignments[i].sameAs && parseInt(classification.assignments[i].sameAs) === parseInt(id)) {
            assignments.push(classification.assignments[i]);
        }
    }

    return assignments;
}

function getAssignmentForGestureId(gestureId) {
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(classification.assignments[i].mainGestureId) === parseInt(gestureId)) {
            return classification.assignments[i];
        }
    }

    return null;
}

function getAssignmentForTriggerId(id) {
    var classification = getLocalItem(CLASSIFICATION_TRIGGER);
    for (var i = 0; i < classification.assignments.length; i++) {
        if (parseInt(classification.assignments[i].mainTriggerId) === parseInt(id)) {
            return classification.assignments[i];
        }
    }

    return null;
}

function updateMainGesture(id, target) {
    var classification = getLocalItem(CLASSIFICATION_GESTURES);
    for (var i = 0; i < classification.assignments.length; i++) {
        var assignment = classification.assignments[i];
        for (var j = 0; j < assignment.gestures.length; j++) {
            if (parseInt(assignment.gestures[j]) === parseInt(id)) {
                updateMainGestureInGestureSet(assignment.mainGestureId, id);
                updateSameAsGesture(classification, assignment.mainGestureId, id);
                assignment.mainGestureId = id;
                break;
            }
        }
    }

    var mainGesture = getGestureById(id, ELICITED_GESTURES);
    renderGestureImages($(target).children('#' + id).find('#main-gesture .previewGesture'), mainGesture.images, mainGesture.previewImage, null);

    setLocalItem(CLASSIFICATION_GESTURES, classification);
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



/*
 * trigger classification and extraction functions
 */

function renderAllTrigger() {
    $('#content-btn-all-trigger').empty();
    var trigger = getLocalItem(ELICITED_TRIGGER);
    var gestures = getLocalItem(ASSEMBLED_GESTURE_SET);
    if (gestures && gestures.length > 0 && trigger && trigger.length > 0) {

        var container = document.createElement('div');
        $(container).attr('id', 'item-view');
        $('#content-btn-all-trigger').append(container);

        var triggerListContainer = document.createElement('div');
        $(triggerListContainer).attr('id', 'trigger-list-container');
        $(container).append(triggerListContainer);

        for (var i = 0; i < gestures.length; i++) {
            var gesture = getGestureById(gestures[i]);

            var panel = document.createElement('div');
            $(panel).addClass('panel panel-default panel-shadow');
            $(triggerListContainer).append(panel);

            var panelHeading = document.createElement('div');
            $(panelHeading).addClass('panel-heading');
            $(panel).append(panelHeading);

            var panelBody = document.createElement('div');
            $(panelBody).addClass('panel-body');
            $(panel).append(panelBody);

            var gestureTitle = document.createElement('div');
            $(gestureTitle).addClass('text');
            $(gestureTitle).text(translation.gesture + ": " + gesture.title);
            $(panelHeading).append(gestureTitle);
//            $(triggerListContainer).append(document.createElement('hr'));

            var listContainer = document.createElement('div');
            $(listContainer).addClass('container-root row root');
//            $(listContainer).css({marginTop: '20px', marginBottom: '30px'});
            $(panelBody).append(listContainer);


            var clone = getGestureCatalogListThumbnail(gesture, null, 'col-xs-6 col-lg-4');
            $(listContainer).append(clone);

            var triggerCol = document.createElement('div');
            $(triggerCol).addClass('col-xs-6 col-lg-8');
            $(listContainer).append(triggerCol);

            var list = document.createElement('ul');
            $(list).css({paddingLeft: '15px'});
            $(triggerCol).append(list);

            var triggerCount = 0;
            for (var j = 0; j < trigger.length; j++) {
                if (parseInt(trigger[j].gestureId) === parseInt(gesture.id)) {
                    var clone = document.createElement('li');
                    $(clone).text(trigger[j].title);
                    $(clone).addClass('text');
                    $(list).append(clone);
                    TweenMax.from(clone, .2, {delay: j * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                    triggerCount++;
                }
            }

            var countText = document.createElement('span');
            $(countText).addClass('badge');
            $(countText).css({marginLeft: '6px'});
            $(countText).text(triggerCount === 1 ? triggerCount + " " + translation.trigger : triggerCount + " " + translation.triggers);
            $(gestureTitle).append(countText);
        }
    } else {
        // append alert
    }
}

var triggerLeft = null;
var triggerLeftIndex = 0;
var triggerRight = null;
var triggerRightIndex = 0;
function renderTriggerClassification() {
    triggerLeftIndex = 0;
    triggerRightIndex = 0;
    var classification = getLocalItem(CLASSIFICATION_TRIGGER);
    var elicitedTrigger = getLocalItem(ELICITED_TRIGGER);

    if (elicitedTrigger && elicitedTrigger.length > 0) {
        if (classification && classification.assignments && classification.assignments.length > 0) {
            // check classified gestures and render them. gesturesLeft must be the matched unclassified gestures
            console.log('there is classification data');
            $('#btn-reclassify-trigger').removeClass('disabled');
            $('#trigger-classification-parameters').addClass('hidden');
            triggerLeft = getUnclassifiedTrigger();
            triggerRight = classification.assignments;
            if (triggerLeft && triggerLeft.length > 0) {
                $('#trigger-classification').removeClass('hidden');
                updateTriggerMatchingView(true, true);
            } else {
                appendAlert($('#content-btn-trigger-classification'), ALERT_NO_MORE_TRIGGER_FOR_CLASSIFICATION);
            }
            renderClassifiedTrigger($('#classified-trigger'));
        } else {
            appendAlert($('#content-btn-trigger-classification'), ALERT_NO_TRIGGER_CLASSIFIED);
            console.log('there is NO classification data');
            $('#trigger-classification-parameters').removeClass('hidden');
            $('#trigger-classification').addClass('hidden');

            $('#trigger-classification-type').unbind('change').bind('change', function (event) {
                event.preventDefault();
                $('#btn-start-classification').removeClass('disabled');
            });

            $('#btn-help-classification').unbind('click').bind('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'externals/modal-classification.php', 'modal-lg');
            });

            $('#btn-start-trigger-classification').unbind('click').bind('click', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $('#trigger-classification-parameters').addClass('hidden');
                    $('#trigger-classification').removeClass('hidden');
                    var checked = $('#trigger-classification-type').find('.btn-option-checked').attr('id');
                    classification = {type: checked, checklist: {used: 'no', items: null}};
                    setLocalItem(CLASSIFICATION_TRIGGER, classification);
                    saveClassification();
                    triggerRight = new Array();
                    triggerRight.push({mainTriggerId: elicitedTrigger[0].id, trigger: [elicitedTrigger[0]]});
                    triggerLeft = elicitedTrigger;
                    updateTriggerMatchingView(true, true);
                    $('#btn-trigger-yes').click();
                }
            });
        }
    } else {
        appendAlert($('#content-btn-gesture-classification'), ALERT_NO_TRIGGER_CLASSIFIED);
    }

    $('#btn-reclassify-trigger').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('disabled');
            removeAlert($('#content-btn-trigger-classification'), ALERT_NO_MORE_TRIGGER_FOR_CLASSIFICATION);
            setLocalItem(CLASSIFICATION_TRIGGER, null);
            saveClassification();
            renderClassifiedTrigger($('#classified-trigger'));
            renderTriggerClassification();
        }
    });

    $('#btn-redo').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            reclassifiyTrigger(triggerLeft[triggerLeftIndex - 1]);
            triggerLeftIndex--;
            triggerRightIndex = 0;

            if (triggerRight.length === 0) {
                triggerRight.push({mainTriggerId: elicitedTrigger[0].id, trigger: [elicitedTrigger[0]]});
            }
            saveClassification();
            updateTriggerMatchingView(true, true);
        }
    });
}

function updateTriggerMatchingView(updateLeft, updateRight) {
    if (triggerLeftIndex > 0) {
        $('#btn-redo').removeClass('disabled');
    } else {
        $('#btn-redo').addClass('disabled');
    }

    var leftTrigger = triggerLeft[triggerLeftIndex];
    var rightTrigger = getTriggerById(triggerRight[triggerRightIndex].mainTriggerId, ELICITED_TRIGGER);

    var leftItem = $('#trigger-left');
    $(leftItem).attr('data-trigger-id', leftTrigger.id);
    $(leftItem).find('#trigger-title').text(leftTrigger.title);

    var leftJustification = document.createElement('div');
    if (leftTrigger.justification && leftTrigger.justification !== null) {
        $(leftJustification).text(leftTrigger.justification);
    } else {
        $(leftJustification).text(translation.noJustification);
    }
    $(leftItem).find('#justification').empty().append(leftJustification);


    var rightItem = $('#trigger-right');
    $(rightItem).attr('data-trigger-id', rightTrigger.id);
    $(rightItem).find('#trigger-title').text(rightTrigger.title);

    var rightJustification = document.createElement('div');
    if (rightTrigger.justification && rightTrigger.justification !== null) {
        $(rightJustification).text(rightTrigger.justification);
    } else {
        $(rightJustification).text(translation.noJustification);
    }
    $(rightItem).find('#justification').empty().append(rightJustification);

    renderClassifiedTrigger($('#classified-trigger'));

    if (updateLeft) {
        TweenMax.from(leftItem, .3, {opacity: 0, scaleX: 0.5, scaleY: 0.5, clearProps: 'all'});
    }

    if (updateRight) {
        TweenMax.from(rightItem, .3, {opacity: 0, scaleX: 0.5, scaleY: 0.5, clearProps: 'all'});
    }
}

function renderClassifiedTrigger(target, type) {
    var classification = getLocalItem(CLASSIFICATION_TRIGGER);
    $(target).empty();

    if (classification) {
        if (classification.assignments && classification.assignments.length > 0) {

            if (classification.type === TYPE_CLASSIFICATION_APPEARANCE_GESTURE) {
                if (type === POTENTIAL_TRIGGER) {
                    renderTriggerGuessabilityTable(target, classification.assignments);
                }

                var gestures = getUniqueGestures();

                for (var i = 0; i < gestures.length; i++) {
                    var counter = 0;
                    var container = $('#template-study-container').find('#amount-container-appearance-gesture').clone();
                    TweenMax.from(container, .2, {delay: .2 + (i * .1), opacity: 0, y: -20});
//                    $(target).append(container);

                    container.find('#headline .text').text(translation.triggerForGesture + ': ' + gestures[i].title);

                    for (var j = 0; j < classification.assignments.length; j++) {
                        var assignment = classification.assignments[j];
                        if (parseInt(assignment.gestureId) === parseInt(gestures[i].id)) {
                            counter++;
                            container.find('#headline .badge').text(counter === 1 ? counter + ' ' + translation.Class : counter + ' ' + translation.Classes);

                            var appearanceTriggerGesture = $('#template-study-container').find('#appearance-gesture-trigger').clone().removeAttr('id');

                            if (type === POTENTIAL_TRIGGER) {
                                appearanceTriggerGesture = $('#template-study-container').find('#appearance-gesture-trigger-potential').clone();
                            }

                            appearanceTriggerGesture.attr('data-main-trigger-id', assignment.mainTriggerId);
                            appearanceTriggerGesture.find('#headline-gesture-trigger').text(translation.Class + ' ' + counter);
                            container.find('#item-view').append(appearanceTriggerGesture);
                            updateTriggerAssignmentInfos(container, type, assignment.mainTriggerId, assignment);

                            var horizontalLine = document.createElement('hr');
                            $(horizontalLine).css({marginTop: '20px', marginBottom: type === POTENTIAL_TRIGGER ? '80px' : '20px'});
                            $(container).find('#item-view').append(horizontalLine);
                        }
                    }

                    if (counter > 0) {
                        $(target).append(container);
                        $(container).find('[data-main-trigger-id]').last().css({marginBottom: '0px'});
                        $(container).find('#item-view hr').last().remove();
                    }
                }
            } else if (classification.type === TYPE_CLASSIFICATION_APPEARANCE) {
                for (var j = 0; j < classification.assignments.length; j++) {
                    var container = $('#template-study-container').find('#amount-container-appearance-gesture').clone();
                    TweenMax.from(container, .2, {delay: .2 + (i * .1), opacity: 0, y: -20});
                    $(target).append(container);


                    var assignment = classification.assignments[j];
                    var appearanceTriggerGesture = $('#template-study-container').find('#appearance-gesture-trigger').clone().removeAttr('id');
                    if (type === POTENTIAL_TRIGGER) {
                        appearanceTriggerGesture = $('#template-study-container').find('#appearance-gesture-trigger-potential').clone();
                    }

                    container.find('#headline .text').text(translation.trigger + ' ' + (j + 1));
                    container.find('#headline .badge').text(assignment.trigger.length === 1 ? assignment.trigger.length + ' ' + translation.trigger : assignment.gestures.length + ' ' + translation.triggers);

                    appearanceTriggerGesture.attr('data-main-trigger-id', assignment.mainTriggerId);
                    container.find('#item-view').append(appearanceTriggerGesture);
                    updateTriggerAssignmentInfos(container, type, assignment.mainTriggerId, assignment);
                }
            }
            initPopover(300);
        } else {
            appendAlert($('#content-btn-trigger-classification'), ALERT_NO_TRIGGER_CLASSIFIED);
        }
    } else {
        appendAlert($('#content-btn-trigger-classification'), ALERT_NO_TRIGGER_CLASSIFIED);
    }

    addUpdateMainTriggerButtonEvent();
}

function renderPotentialTrigger() {
    $('#content-btn-potential-trigger').empty();
    renderClassifiedTrigger($('#content-btn-potential-trigger'), POTENTIAL_TRIGGER);
}

function addUpdateMainTriggerButtonEvent() {
    $('.btn-tag-as-main-trigger').unbind('click').bind('click', function (event) {
        event.preventDefault();
        if (!$(this).hasClass('trigger-tagged')) {
            var id = $(this).attr('id');
            $(this).parent().children().removeClass('trigger-tagged');
            $(this).attr('data-content', translation.tagAsMainGesture);
            $(this).popover('hide');

            $(this).addClass('trigger-tagged');
            $(this).attr('data-content', translation.gestureTaggedAsMain);
            updateMainTrigger(id, $(this).closest('#item-view'));
        }
    });
}

function updateTriggerAssignmentInfos(container, type, updateId, assignment) {
    var target = $(container).find('[data-main-trigger-id=' + updateId + ']');
    $(target).attr('data-main-gesture-id', assignment.mainTriggerId);
    $(target).find('.btn-popover-gesture-preview').remove();

    if (type === POTENTIAL_TRIGGER) {
        $(target).find('#potential-parameters-container').children().not('#potential-parameters').remove();
    }
    $(target).find('#trigger-list-container').empty();

    var gestureThumbnailContainer = document.createElement('div');
    $(gestureThumbnailContainer).addClass('row');

    var gesture = getGestureById(assignment.gestureId);
    var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12 col-sm-12 col-lg-8');
    $(gestureThumbnailContainer).append(gestureThumbnail);
//    $(listContainer).append(clone);

//    var gesturePreviewButton = $('#item-container-inputs').find('#btn-show-gesture').clone().removeAttr('id');
//    $(gesturePreviewButton).css({marginBottom: '10px', border: ''});
//    $(gesturePreviewButton).attr('name', assignment.gestureId);

    var involvedTrigger = document.createElement('div');
    $(involvedTrigger).addClass('col-xs-12 col-sm-6 text');

    var ul = document.createElement('ul');
    $(ul).css({paddingLeft: '15px'});
    $(involvedTrigger).append(ul);

    for (var k = 0; k < assignment.trigger.length; k++) {
        var trigger = getTriggerById(assignment.trigger[k], ELICITED_TRIGGER);

        var listItem = document.createElement('li');
        $(listItem).text(trigger.title);
        $(listItem).attr('id', trigger.id);
        $(ul).append(listItem);

        if (type !== POTENTIAL_TRIGGER) {
            $(listItem).addClass('btn-tag-as-main-trigger');
            if (parseInt(assignment.mainTriggerId) === parseInt(trigger.id)) {
                $(listItem).addClass('trigger-tagged');
                $(listItem).attr('data-content', translation.gestureTaggedAsMain);
            }
        }
    }

    if (type === POTENTIAL_TRIGGER) {
        $(target).find('#potential-parameters-container').prepend(involvedTrigger);
        $(involvedTrigger).prepend(gestureThumbnailContainer);
        renderPotentialTriggerParameters(target, assignment);
    } else {
        $(involvedTrigger).prepend(gestureThumbnailContainer);
        $(target).find('#trigger-list-container').append(involvedTrigger);
    }
}

function getClassifiedTriggerIndex(trigger) {
    var classification = getLocalItem(CLASSIFICATION_TRIGGER).assignments;
    var count = 0;
    for (var i = 0; i < classification.length; i++) {
        var mainTrigger = getTriggerById(classification[i].mainTriggerId, ELICITED_TRIGGER);
        if (parseInt(mainTrigger.gestureId) === parseInt(trigger.gestureId)) {
            count++;
        }

        if (parseInt(mainTrigger.id) === parseInt(trigger.id)) {
            return count;
        }
    }
}

$(document).on('click', '#btn-trigger-yes', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var leftId = parseInt($('#trigger-left').attr('data-trigger-id'));
    var leftTrigger = getTriggerById(leftId, ELICITED_TRIGGER);
    classifyTrigger(leftTrigger, true);
    triggerLeftIndex++;
    triggerRightIndex = 0;

    if (triggerLeft.length > 0 && triggerLeftIndex < triggerLeft.length) {
        updateTriggerMatchingView(true, true);
        removeAlert($('#content-btn-trigger-classification'), ALERT_NO_TRIGGER_CLASSIFIED);
    } else {
        checkTriggerClassificationType();
        renderClassifiedTrigger($('#classified-trigger'));
        $('#trigger-classification').addClass('hidden');
        appendAlert($('#content-btn-trigger-classification'), ALERT_NO_MORE_TRIGGER_FOR_CLASSIFICATION);
    }
});

$(document).on('click', '#btn-trigger-no', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var leftId = parseInt($('#trigger-left').attr('data-trigger-id'));
    var leftTrigger = getTriggerById(leftId, ELICITED_TRIGGER);

    if (triggerRightIndex < triggerRight.length - 1) {
        console.log('more rights', triggerRight.length);
        triggerRightIndex++;
        updateTriggerMatchingView(false, true);
    } else if (triggerLeftIndex < triggerLeft.length - 1) {
        console.log('no more rights, classify trigger');
        classifyTrigger(leftTrigger, false);
        triggerLeftIndex++;
        triggerRightIndex = 0;
        updateTriggerMatchingView(true, true);
        removeAlert($('#content-btn-trigger-classification'), ALERT_NO_TRIGGER_CLASSIFIED);
    } else {
        console.log('no more trigger');
        classifyTrigger(leftTrigger, false);
        checkTriggerClassificationType();
        renderClassifiedTrigger($('#classified-trigger'));
        $('#trigger-classification').addClass('hidden');
        appendAlert($('#content-btn-trigger-classification'), ALERT_NO_MORE_TRIGGER_FOR_CLASSIFICATION);
    }
});

function classifyTrigger(trigger, foundMatch) {
    var classification = getLocalItem(CLASSIFICATION_TRIGGER);
    if (foundMatch) {
        if (classification && classification.assignments && classification.assignments.length > 0) {
            var matchedSourceTrigger = triggerRight[triggerRightIndex];
            if (classification.type === TYPE_CLASSIFICATION_APPEARANCE) {
                classification.assignments[triggerRightIndex].trigger.push(trigger.id);
            } else {
                if (parseInt(matchedSourceTrigger.triggerId) === parseInt(trigger.gestureId)) {
                    for (var i = 0; i < classification.assignments.length; i++) {
                        if (parseInt(classification.assignments[i].mainTriggerId) === parseInt(matchedSourceTrigger.mainTriggerId)) {
                            classification.assignments[i].trigger.push(trigger.id);
                        }
                    }
                } else {
                    var matchedSameAsAssignment = false;
                    for (var i = 0; i < classification.assignments.length; i++) {
                        if (parseInt(classification.assignments[i].sameAs) === parseInt(matchedSourceTrigger.mainTriggerId)) {
                            classification.assignments[i].trigger.push(trigger.id);
                            matchedSameAsAssignment = true;
                            break;
                        }
                    }

                    if (matchedSameAsAssignment === false) {
                        classification.assignments.push({mainTriggerId: trigger.id, gestureId: trigger.gestureId, sameAs: matchedSourceTrigger.mainTriggerId, trigger: [trigger.id]});
                    }
                }
            }
        } else {
            classification.assignments = [{mainTriggerId: trigger.id, gestureId: trigger.gestureId, trigger: [trigger.id]}];
            triggerRight = classification.assignments;
        }
    } else {
        if (classification && classification.assignments && classification.assignments.length > 0) {
            classification.assignments.push({mainTriggerId: trigger.id, gestureId: trigger.gestureId, trigger: [trigger.id]});
            triggerRight.push({mainTriggerId: trigger.id, triggerId: trigger.gestureId, trigger: [trigger.id]});
        } else {
            classification.assignments = [{mainTriggerId: trigger.id, gestureId: trigger.gestureId, trigger: [trigger.id]}];
            triggerRight = classification.assignments;
        }
    }

    setLocalItem(CLASSIFICATION_TRIGGER, classification);
    saveClassification();
    $('#btn-reclassify-trigger').removeClass('disabled');
}

function reclassifiyTrigger(trigger) {
    var classification = getLocalItem(CLASSIFICATION_TRIGGER);
    var assignments = classification.assignments;
    for (var i = 0; i < assignments.length; i++) {
        var triggers = assignments[i].triggers;
        for (var j = 0; j < triggers.length; j++) {
            if (parseInt(triggers[j]) === parseInt(trigger.id)) {
                if (triggers.length === 1) {
                    assignments.splice(i, 1);
                    break;
                } else {
                    triggers.splice(j, 1);
                    break;
                }
            }
        }
    }

    for (var i = 0; i < triggerRight.length; i++) {
        if (parseInt(trigger.id) === parseInt(triggerRight[i].id)) {
            triggerRight.splice(i, 1);
        }
    }

    setLocalItem(CLASSIFICATION_TRIGGER, classification);
}

function updateMainTrigger(id) {
    var classification = getLocalItem(CLASSIFICATION_TRIGGER);
    for (var i = 0; i < classification.assignments.length; i++) {
        var assignment = classification.assignments[i];
        for (var j = 0; j < assignment.trigger.length; j++) {
            if (parseInt(assignment.trigger[j]) === parseInt(id)) {
                updateSameAsTrigger(classification, assignment.mainTriggerId, id);
                assignment.mainTriggerId = id;
                break;
            }
        }
    }

    setLocalItem(CLASSIFICATION_TRIGGER, classification);
    saveClassification();
}

function updateSameAsTrigger(classification, oldId, newId) {
    for (var i = 0; i < classification.assignments.length; i++) {
        var assignment = classification.assignments[i];
        if (parseInt(assignment.sameAs) === parseInt(oldId)) {
            assignment.sameAs = newId;
        }
    }
}

var currentAssignment = null;
function renderPotentialTriggerParameters(target, assignment, mainTrigger) {

    var classification = getLocalItem(CLASSIFICATION_TRIGGER);
    if (classification.type === TYPE_CLASSIFICATION_APPEARANCE_GESTURE) {
        $(target).find('#potential-parameters').empty().append($('#potential-trigger-parameters-appearance-gesture').clone());

        // amount
        var gestureId = assignment.gestureId;
        var amountRange = getAmountRange(gestureId);
        $(target).find('#parameters-amount #justification').text(translation.Minimal + ': ' + amountRange.min + ', ' + translation.maximal + ': ' + amountRange.max + ', ' + assignment.trigger.length + ' ' + (assignment.trigger.length === 1 ? translation.classifiedTrigger : translation.classifiedTriggers));

        if (amountRange.max > amountRange.min) {
            if (assignment.trigger.length === amountRange.max) {
                target.find('#parameters-amount #well').removeClass('hidden');
            } else if (assignment.trigger.length === amountRange.min) {
                target.find('#parameters-amount #less-well').removeClass('hidden');
            } else {
                target.find('#parameters-amount #even').removeClass('hidden');
            }
        } else {
            // can't found best gesture for these trigger, because every gesture are demonstrated the same amount
        }

        // agreement measures
//        var agreementMeasures = getAgreementMeasures(assignment, TYPE_CLASSIFICATION_APPEARANCE_GESTURE);
//        $(target).find('#agreement .text').text(agreementMeasures + '%');
//        if (amountRange.max > 1) {
//            var agreementMeasures = getAgreementMeasures(assignment, TYPE_CLASSIFICATION_APPEARANCE_TRIGGER);
//            if (agreementMeasures) {
//                $(target).find('#agreement .text').text(agreementMeasures + '%');
//            } else {
//                $(target).find('#agreement .text').text('Konnte nicht berechnet werden, da diese Geste nur einmal vorkommt.');
//            }
//        }

        // guessability / accordance
//        var accordance = getTriggerAccordance(gestureId).toFixed(2);
//        $(target).find('#parameters-guessability').removeClass('hidden');
//        $(target).find('#accordance .text').text(accordance === 1 ? '1.00' : accordance);

//        if (accordance <= 0) {
//            $(target).find('#parameters-guessability .lowAgreement').removeClass('hidden');
//        } else if (accordance >= 1) {
//            $(target).find('#parameters-guessability .veryHighAgreement').removeClass('hidden');
//        } else {
//            var agreementMargins = AGREEMENT_MARGINS;
//            for (var i = 0; i < agreementMargins.length; i++) {
//                var min = i > 0 ? agreementMargins[i - 1].max : 0;
//                var max = agreementMargins[i].max;
//                if (accordance > min && accordance <= max) {
//                    $(target).find('#parameters-guessability .' + agreementMargins[i].interpretation).removeClass('hidden');
//                    break;
//                }
//            }
//        }


    } else if (classification.type === TYPE_CLASSIFICATION_APPEARANCE) {
        $(target).find('#potential-parameters').empty().append($('#potential-trigger-parameters-appearance').clone());

        var gestures = getUniqueGestures();
        for (var i = 0; i < gestures.length; i++) {
            var item = $('#potential-trigger-parameters-appearance-gesture-amount-item').clone().removeAttr('id');
            $(item).find('#gesture-title').text(gestures[i].title);
            $(target).find('#potential-parameters #parameters-amount #trigger-container').append(item);

            if (i > 0) {
                $(item).css({marginTop: '10px'});
            }

            var count = 0;
            for (var j = 0; j < assignment.trigger.length; j++) {
                var trigger = getTriggerById(assignment.trigger[j], ELICITED_TRIGGER);
                if (parseInt(trigger.gestureId) === parseInt(gestures[i].id)) {
                    count++;
                }
            }

            $(item).find('#justification').text(count + ' ' + translation.of + ' ' + assignment.trigger.length + ' ' + translation.classifiednTrigger);
        }
    }

    // cognitive relationships
    $(target).find('#btn-open-cognitive-relationships').unbind('click').bind('click', function (event) {
        event.preventDefault();
        currentAssignment = getAssignmentByMainTriggerId($(this).closest('.root').attr('data-main-trigger-id'));
        loadHTMLintoModal('custom-modal', 'externals/modal-cognitive-relationships-trigger.php', 'modal-lg');
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
            currentAssignment = getAssignmentByMainTriggerId($(this).closest('.root').attr('data-main-trigger-id'));
            loadHTMLintoModal('custom-modal', 'externals/modal-checklist-trigger.php', 'modal-lg');
        });

        if (assignment.checklist && assignment.checklist.objectiveAnswer) {
            target.find('#parameters-checklist #' + assignment.checklist.objectiveAnswer).removeClass('hidden');
        } else {
            target.find('#parameters-checklist #not-checked').removeClass('hidden');
        }
    }
}






/*
 * dynamic scrolling for side navivation
 */

function initDynamicAffixScrolling(target) {
    $(target).unbind('affix.bs.affix').bind('affix.bs.affix', function () {
        setAffixContainerSize($(this));
    });

    function setAffixContainerSize(target) {
        var newWidth = $(target).parent().innerWidth() - 30;
        $(target).width(newWidth);
    }

    $(window).unbind('scroll resize').bind('scroll resize', function (event) {
        if ($(window).width() > 770) {
            $(target).addClass('affix');
            $(target).attr('data-spy', 'affix');
            $(target).attr('data-offset-top', 0);
            setAffixContainerSize($(target));
        } else {
            setAffixContainerSize($(target));
            $(target).removeClass('affix');
            $(target).removeAttr('data-spy');
            $(target).removeAttr('data-offset-top');
        }
    });



    setAffixContainerSize($(target));
}