function renderData(data, hash) {
    var studyData = data.studyData;
    // general data view
    $('#study-headline').text(studyData.generalData.title);
    $('#type-method').text(translation.methodType[studyData.generalData.method]);
    $('#type-survey').text(translation.surveyType[studyData.generalData.surveyType]);
    $('#type-phase').text(translation.phaseType[studyData.generalData.phase]);
    $('#study-description .text').text(studyData.generalData.description);

    var mappingForTriggers = getMappingForTriggers();
    var mappingForGestures = getMappingForGestures();

    if (mappingForTriggers && mappingForTriggers.length > 0) {
        $('#extraction').removeClass('hidden');
        $('#tab-pane').find('#gesture-extraction').removeClass('disabled');
    }

    if (mappingForGestures && mappingForGestures.length > 0) {
        $('#extraction').removeClass('hidden');
        $('#tab-pane').find('#trigger-extraction').removeClass('disabled');
    }

    initPopover();

    $('.btn-edit-study').on('click', {studyId: data.id}, function (event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            goto("extraction-create.php?studyId=" + event.data.studyId + "&h=" + hash + "&joinedConv=" + joinedRoom + getWebRTCSources());
        }
    });

    $('.btn-delete-study').on('click', {studyId: data.id}, function (event) {
        event.preventDefault();
        var button = $(this);
        var deleteStudyId = event.data.studyId;
        lockButton($('.btn-edit-study'));

        if (!$(button).hasClass('disabled')) {
            lockButton(button, true, 'fa-trash');
            loadHTMLintoModal('custom-modal', 'externals/modal-delete-study-data.php', 'modal-md');
            $('#custom-modal').unbind('deleteData').bind('deleteData', function () {
                deleteStudy({studyId: deleteStudyId}, function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        gotoStudies();
                    } else {
                        unlockButton(button, true, 'fa-trash');
                        unlockButton($('.btn-edit-study'));
                        // append error alert
                    }
                });
            });

            $('#custom-modal').unbind('cancel').bind('cancel', function () {
                unlockButton($('.btn-edit-study'));
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
        $('#fixed-study-owner-controls').find('.btn-join-conversation').css({borderBottomLeftRadius: '0px', borderBottomRightRadius: '8px'});
        $('#fixed-study-owner-controls').find('.btn-leave-conversation').css({borderBottomLeftRadius: '0px', borderBottomRightRadius: '8px'});
    }

    $('#tab-pane li a').on('click', function (event) {
        event.preventDefault();
        if ($(this).parent().hasClass('disabled')) {
            event.stopImmediatePropagation();
        } else {
            if (!event.handled && !$(this).parent().hasClass('active') && !$(this).hasClass('dropdown-toggle')) {
                event.handled = true;
                $(this).trigger('change', [$(this).closest('li').attr('id')]);
            }
        }
    });

    $('#tab-pane').on('change', function (event, activeId) {
        event.preventDefault();

        if (activeId !== 'tab-introduction') {
            switch (activeId) {
                case 'catalogs':
                    renderCatalogs();
                    break;
                case 'mapping':
                    renderMapping();
                    break;
                case 'gesture-extraction':
                    renderExtraction(ELICITED_GESTURES);
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

            fixedOwnerControlsTween.play();
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

        if (noCatalogData) {
            appendAlert($('#study-catalogs'), ALERT_NO_PHASE_DATA);
        } else {
            $('#study-catalogs').find('.study-catalog').first().css({marginTop: '0px'});
        }
    }

    // render mappings
    function renderMapping() {
        var mappingForTriggers = getMappingForTriggers();
        var mappingForGestures = getMappingForGestures();

        var container = $('#extraction-mapping').find('#trigger-mapping-container');
        $(container).empty();
        if (mappingForTriggers && mappingForTriggers.length > 0) {
            for (var i = 0; i < mappingForTriggers.length; i++) {
                var mappingItem = $('#template-study-container').find('#trigger-extraction-mapping-item').clone().removeAttr('id');
                $(mappingItem).find('#trigger-title').text(getTriggerById(mappingForTriggers[i].triggerId).title);
                $(container).append(mappingItem);

                // render assembled gestures
                if (mappingForTriggers[i].gestureIds && mappingForTriggers[i].gestureIds.length) {
                    for (var j = 0; j < mappingForTriggers[i].gestureIds.length; j++) {
                        var gesture = getGestureById(mappingForTriggers[i].gestureIds[j]);
                        var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12 col-sm-6 col-md-4');
                        $(mappingItem).find('#gestures .list-container').append(gestureThumbnail);
                    }
                }

                // render assembled scenes
                if (mappingForTriggers[i].sceneIds && mappingForTriggers[i].sceneIds.length) {
                    for (var j = 0; j < mappingForTriggers[i].sceneIds.length; j++) {
                        var scene = getSceneById(mappingForTriggers[i].sceneIds[j]);
                        var item = $('#template-study-container').find('#scenes-catalog-thumbnail').clone().removeAttr('id').css({marginTop:'-10px'});
                        item.find('.text').text(scene.title);
                        item.find('.label-text').text(translation.sceneTypes[scene.type]);
                        item.find('#' + scene.type).removeClass('hidden');
                        $(mappingItem).find('#scenes .list-container').append(item).append(document.createElement('br'));
                        TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});

                        $(item).unbind('mouseenter').bind('mouseenter', {scene: scene}, function (event) {
                            var button = $(this);
                            renderScenePopoverPreview(event.data.scene, function (popover) {
                                var top = $(button).offset().top - popover.height() - 2;
                                var left = $(button).offset().left + parseInt(((button.width() - popover.width()) / 2));
                                popover.css({left: left, top: top, zIndex: 10000, position: 'absolute'});
                                TweenMax.to(popover, .3, {autoAlpha: 1});
                            });
                        });

                        $(item).unbind('mouseleave').bind('mouseleave', function (event) {
                            event.preventDefault();
                            resetScenePopover();
                        });

                        $(item).find('#btn-preview-scene').click({scene: scene}, function (event) {
                            event.preventDefault();
                            currentSceneId = event.data.scene.id;
                            loadHTMLintoModal('custom-modal', 'externals/modal-scene.php', 'modal-lg');
                        });
                    }
                }

                TweenMax.from(mappingItem, .2, {delay: i * .03, opacity: 0, y: '-20px'});
            }
        } else {
            appendAlert(container, ALERT_NO_PHASE_DATA);
        }

        container = $('#extraction-mapping').find('#gesture-mapping-container');
        $(container).empty();
        if (mappingForGestures && mappingForGestures.length > 0) {
            for (var i = 0; i < mappingForGestures.length; i++) {
                var mappingItem = $('#template-study-container').find('#gesture-extraction-mapping-item').clone().removeAttr('id');
                $(container).append(mappingItem);

                var gesture = getGestureById(mappingForGestures[i].gestureId);
                var gestureThumbnail = getGestureCatalogListThumbnail(gesture, null, 'col-xs-12');
                $(mappingItem).find('#gestures .list-container').append(gestureThumbnail);

                // render assembled trigger
                if (mappingForGestures[i].triggerIds && mappingForGestures[i].triggerIds.length) {
                    for (var j = 0; j < mappingForGestures[i].triggerIds.length; j++) {
                        var triggerItem = document.createElement('div');
                        $(triggerItem).text(getTriggerById(mappingForGestures[i].triggerIds[j]).title);
                        $(mappingItem).find('#trigger .list-container').append(triggerItem);
                    }
                }

                TweenMax.from(mappingItem, .2, {delay: i * .03, opacity: 0, y: '-20px'});
            }
        } else {
            appendAlert(container, ALERT_NO_PHASE_DATA);
        }
    }

    function getMappingForTriggers() {
        var mapping = getLocalItem('extractionMapping');
        var array = [];
        for (var i = 0; i < mapping.length; i++) {
            if (mapping[i].format === 'trigger-mapping') {
                array.push(mapping[i]);
            }
        }
        return array;
    }

    function getMappingForGestures() {
        var mapping = getLocalItem('extractionMapping');
        var array = [];
        for (var i = 0; i < mapping.length; i++) {
            if (mapping[i].format === 'gesture-mapping') {
                array.push(mapping[i]);
            }
        }
        return array;
    }

    function renderExtraction(type) {
        classificationType = type;

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
                    var elicitedTrigger = [];
                    for (var i = 0; i < result.elicitedTrigger.length; i++) {
                        var trigger = getTriggerById(result.elicitedTrigger[i].triggerId);
                        var tempTrigger = {id: trigger.id, title: trigger.title, gestureId: result.elicitedTrigger[i].gestureId, justification: ''}
                        elicitedTrigger.push(tempTrigger);
                    }

                    setLocalItem(ELICITED_TRIGGER, elicitedTrigger);
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
            console.log('mouse enter');
            var button = $(this);
            var scene = getSceneById(event.data.sceneId);
            renderScenePopoverPreview(scene, function (popover) {
                var top = $(button).offset().top - popover.height() - 2;
                var left = $(button).offset().left + parseInt(((button.width() - popover.width()) / 2));
                popover.css({left: left, top: top, zIndex: 10000, position: 'absolute'});
                TweenMax.to(popover, .3, {autoAlpha: 1});
            });
        });

        $(item).find('.text').unbind('mouseleave').bind('mouseleave', {sceneId: scenes[i].id}, function (event) {
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