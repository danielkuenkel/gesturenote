function renderData(data, hash) {
    var studyData = data.studyData;
    // general data view
    $('#study-headline').text(studyData.generalData.title);
    $('#type-method').text(translation.methodType[studyData.generalData.method]);
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
                    $('#btn-show-all-participant-results').remove();
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
            goto("study-preview.php?studyId=" + event.data.studyId + "&h=" + hash + "&joinedConv=" + joinedRoom + '&view=moderator' + getWebRTCSources());
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
//        console.log(data, studyData, studyData.generalData.method);
        getExtractionData({studyId: data.id, method: studyData.generalData.method, surveyType: studyData.generalData.surveyType}, function (result) {
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

        $(item).find('.text').unbind('mouseenter').bind('mouseenter', {sceneId: scenes[i].id}, function (event) {
            var button = $(this);
            var scene = getSceneById(event.data.sceneId);
            renderScenePopoverPreview(scene, function (popover) {
                var top = $(button).offset().top - popover.height() - 2;
                var left = $(button).offset().left + parseInt(((button.width() - popover.width()) / 2));
                popover.css({left: left, top: top, zIndex: 10000, position: 'absolute'});
                TweenMax.to(popover, .3, {autoAlpha: 1});
            });
        });

        $(item).find('.text').unbind('mouseleave').bind('mouseleave', function (event) {
            event.preventDefault();
            resetScenePopover();
        });

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
    $('#study-participants .list-container').empty();
    $('#tab-pane').find('#participants .badge').text(data.length);
    var aborted = 0;
    var success = 0;

    for (var i = 0; i < data.length; i++) {
        var result = data[i].data;
        var item = $('#template-study-container').find('#participant-thumbnail').clone().removeAttr('id');
        $(item).find('#heading-text').text(convertSQLTimestampToDate(data[i].created).toLocaleString());
        $('#study-participants .list-container').append(item);
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

    var target = $('#study-participants');
    var ctx = $(target).find('#chart-participant-statistics');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [translation.studiesSucceeded, translation.studiesAborted],
            datasets: [{
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

    $('#btn-show-all-participant-results').unbind('click').bind('click', function (event) {
        clearLocalItems();
        var query = getQueryParams(document.location.search);
        goto('study-participant-all.php?studyId=' + query.studyId + '&h=' + hash + "&joinedConv=" + joinedRoom + getWebRTCSources());
    });
}