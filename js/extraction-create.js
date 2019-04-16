/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var currentIdForModal;
function checkSessionStorage() {
    if (typeof (Storage) !== "undefined") {
        checkAssembledGestures(getLocalItem(ASSEMBLED_GESTURE_SET), getLocalItem(GESTURE_CATALOG));
        renderSessionStorageData();
    } else {
        appendAlert($('#mainContent'), ALERT_NO_STORAGE_API);
    }
}

function renderSessionStorageData() {
//    renderMapping();

    var study = getLocalItem(STUDY);
    if (study) {
        $('#studyTitle').val(study.title);
        $('#studyDescription').val(study.description);
    }

    updateCatalogButtons();
    renderCatalogOverview();
}

function renderCatalogOverview() {
    updateCatalogButtons();

    var studyGestures = getLocalItem(ASSEMBLED_GESTURE_SET);
    $('#gestures-catalog').find('#gestures-list-container').empty();
    if (studyGestures && studyGestures.length > 0) {
        clearAlerts($('#gestures-catalog'));
        renderStudyGestures(studyGestures, true);
    } else {
        appendAlert($('#gestures-catalog'), ALERT_NO_PHASE_DATA);
    }

    var studyTrigger = getLocalItem(ASSEMBLED_TRIGGER);
    $('#trigger-catalog').find('.list-container').empty();
    if (studyTrigger && studyTrigger.length > 0) {
        clearAlerts($('#trigger-catalog'));
        renderStudyTrigger(studyTrigger);
    } else {
        appendAlert($('#trigger-catalog'), ALERT_NO_PHASE_DATA);
    }

    var studyScenes = getLocalItem(ASSEMBLED_SCENES);
    $('#scenes-catalog').find('.list-container').empty();
    if (studyScenes && studyScenes.length > 0) {
         $('#scenes-catalog').find('.list-container').removeClass('hidden');
        clearAlerts($('#scenes-catalog'));
        renderStudyScenes(studyScenes);
    } else {
        appendAlert($('#scenes-catalog'), ALERT_NO_PHASE_DATA);
    }

    if (studyGestures && studyGestures.length > 0 && studyTrigger && studyTrigger.length > 0) {
        $('#create-tab-navigation').find('#tab-mapping').removeClass('disabledTab');
    } else {
        $('#create-tab-navigation').find('#tab-mapping').addClass('disabledTab');
    }
}

function renderStudyGestures(gestures, animate) {
    $('#gestures-catalog').find('#gestures-list-container').empty();
    if (gestures && gestures.length > 0) {
        $('#gestures-catalog').find('#btn-download-as-json').removeClass('disabled');
        $('#gestures-catalog').find('#btn-download-as-exchangeable').removeClass('disabled');
        for (var i = 0; i < gestures.length; i++) {
            var gesture = getGestureById(gestures[i]);
            var clone = getCreateStudyGestureListThumbnail(gesture, 'favorite-gesture-catalog-thumbnail', 'col-xs-6 col-sm-4 col-md-4 col-lg-3');
            $(clone).find('.tagged-symbol').addClass('hidden');
            $('#gestures-catalog').find('#gestures-list-container').append(clone);
            
            if (animate && animate === true) {
                TweenMax.from(clone, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
            }
        }
    } else {
        appendAlert($('#gestures-catalog'), ALERT_NO_PHASE_DATA);
        $('#gestures-catalog').find('#btn-download-as-json').addClass('disabled');
        $('#gestures-catalog').find('#btn-download-as-exchangeable').addClass('disabled');
    }

    $('#gestures-catalog').find('#gestures-list-container').unbind('change').bind('change', function (event, gestureId, assemble) {
        TweenMax.to($(event.target).closest('.root'), .2, {scale: 0, opacity: 0, clearProps: 'all', ease: Quad.easeIn, onComplete: function () {
                reassembleGesture(gestureId);
                updateCatalogButtons();
                renderStudyGestures(getLocalItem(ASSEMBLED_GESTURE_SET), false);
            }
        });
    });

    initPopover();
    initTooltips();
}

function renderStudyTrigger(trigger) {
    for (var i = 0; i < trigger.length; i++) {
        var item = $('#template-study-container').find('#trigger-catalog-thumbnail').clone().removeAttr('id');
        item.text(trigger[i].title);
        $('#trigger-catalog').find('.list-container').append(item);
        TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
    }
}

function renderStudyScenes(scenes) {
    for (var i = 0; i < scenes.length; i++) {
        var item = $('#template-study-container').find('#scenes-catalog-thumbnail').clone().removeAttr('id');
        item.find('.text').text(scenes[i].title);
        item.find('.label-text').text(translation.sceneTypes[scenes[i].type]);
        item.find('#' + scenes[i].type).removeClass('hidden');
        $('#scenes-catalog').find('.list-container').append(item);
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



function renderMapping() {
    $('#mappingList').empty();
    var mappings = getLocalItem('extractionMapping');
    if (mappings && mappings.length > 0) {
        for (var i = 0; i < mappings.length; i++) {
            addMapping(mappings[i].id, mappings[i].format, mappings[i]);
        }
    }
}

function updateAssembledData() {
    renderAssembledGestures($('#mappingList'));
    renderAssembledTriggers($('#mappingList'));
}

function saveMapping() {
    var mapping = new Array();
    var items = $('#mappingList').children();
    for (var i = 0; i < items.length; i++) {
        var item = items[i];
        var id = $(item).attr('data-id');
        var format = $(item).attr('id');


        if (format === 'trigger-mapping') {
            var triggerId = $(item).find('.triggerSelect .chosen').attr('id');
            var gestureIds = [];
            var assembledGestures = $(item).find('#assembled-study-gestures .gesture-thumbnail.assembled');
            for (var j = 0; j < assembledGestures.length; j++) {
                gestureIds.push($(assembledGestures[j]).closest('.root').attr('id'));
            }

            var sceneIds = [];

            var selectedScenes = $(item).find('#scenes .sceneSelect');
            console.log(selectedScenes)
            for (var j = 0; j < selectedScenes.length; j++) {
                var sceneId = $(selectedScenes[j]).find('.chosen').attr('id');
                if (sceneId !== 'unselected') {
                    sceneIds.push(sceneId);
                }
            }
            mapping.push({id: id, format: format, triggerId: triggerId, gestureIds: gestureIds, sceneIds: sceneIds});
        } else if (format === 'gesture-mapping') {
            var gestureId = $(item).find('.gestureSelect .chosen').attr('id');
            var triggerIds = [];
            var assembledTrigger = $(item).find('#assembled-trigger-container .btn-add-trigger-to-gesture.selected');
            for (var j = 0; j < assembledTrigger.length; j++) {
                triggerIds.push($(assembledTrigger[j]).closest('.root').attr('id'));
            }
            mapping.push({id: id, format: format, gestureId: gestureId, triggerIds: triggerIds});

        }
    }
    console.log('save mapping', mapping);
    setLocalItem('extractionMapping', mapping);
}

function renderOverlayTitle(id, target, input) {
    var currentPhaseData = getPhaseById(id);
    if (currentPhaseData.title) {
        $(target).find('#phase-step-title').text(currentPhaseData.title);
    } else {
        $(target).find('#phase-step-title').text(translation.formats[currentPhaseData.format].text);
    }

    $(target).unbind('click').bind('click', function (event) {
        $(target).addClass('hidden');
        $(input).find('#phase-step-title-input').val($(target).find('#phase-step-title').text());
        $(input).removeClass('hidden');
    });

    $(input).find('#btn-save-phase-step-title').unbind('click').bind('click', function (event) {
        $(input).addClass('hidden');
        $(target).removeClass('hidden');
        updatePhaseStepTitle(id, input);
        var currentPhaseData = getPhaseById(id);
        $(target).find('#phase-step-title').text(currentPhaseData.title);
    });
}

function updateCatalogButtons() {
    var gestures = getLocalItem(ASSEMBLED_GESTURE_SET);
    if (gestures && gestures.length > 0) {
        $('#gestures-catalog .btn-open-overlay .btn-text').text(translation.editCatalog);
    } else {
        $('#gestures-catalog .btn-open-overlay .btn-text').text(translation.arrangeSet);
    }

    var trigger = getLocalItem(ASSEMBLED_TRIGGER);
    if (trigger && trigger.length > 0) {
        $('#trigger-catalog .btn-open-overlay .btn-text').text(translation.editCatalog);
    } else {
        $('#trigger-catalog .btn-open-overlay .btn-text').text(translation.arrangeSet);
    }

    var scenes = getLocalItem(ASSEMBLED_SCENES);
    if (scenes && scenes.length > 0) {
        $('#scenes-catalog .btn-open-overlay .btn-text').text(translation.editCatalog);
    } else {
        $('#scenes-catalog .btn-open-overlay .btn-text').text(translation.arrangeSet);
    }
}

function saveGeneralData() {
    var study = new Object();
    study.title = $('#studyTitle').val();
    study.description = $('#studyDescription').val();
    setLocalItem(STUDY, study);
    updateCatalogButtons();
}

var closeClicked = false;
function onCloseClick() {
    closeClicked = true;
    saveData();
    currentIdForModal = null;
}