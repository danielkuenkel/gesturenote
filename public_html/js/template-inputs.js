/* 
 * Close function which called when click save or close button. NOTE: Not called
 * when clicked outside of a modal 
 */

var closeClicked = false;

function onCloseClick() {
    closeClicked = true;
    saveData();
    currentIdForModal = null;
}



/* 
 * common form format functions 
 */

$('body').on('click', '#addFormat', function (event) {
    event.preventDefault();
    if (event.handled !== true && !$(this).hasClass('disabled'))
    {
        event.handled = true;
        var selectedID = $(this).parent().find('.selected').attr('id');
        if (selectedID !== 'unselected') {
            var clone = $('#form-item-container').find('#' + selectedID).clone(true);
            $('#list-container').append(clone);
            checkCurrentListState($('#list-container'));
            updateBadges($('#list-container'), selectedID);
        }
    }
});

$('.btn-add-groupingQuestionOption').unbind('click').bind('click', function (event) {
    event.preventDefault();
    var clone = $('#groupingQuestionItem').clone().removeClass('hidden');
    $(this).prev().find('.panel-body').append(clone);
    checkCurrentListState($(this).prev().find('.panel-body'));
});

$('.btn-add-ratingOption').unbind('click').bind('click', function (event) {
    event.preventDefault();
    var clone = $('#ratingItem').clone().removeClass('hidden');
    clone.removeAttr('id');
    $(this).prev().find('.panel-body').append(clone);
    checkCurrentListState($(this).prev().find('.panel-body'));
    renderScaleItems($(clone).find('.ratingScaleItemContainer'), 3);
    return false;
});

$('.btn-add-sumQuestionOption').unbind('click').bind('click', function (event) {
    event.preventDefault();
    var clone = $('#sumQuestionItem').clone().removeClass('hidden');
    $(this).prev().find('.panel-body').append(clone);
    checkCurrentListState($(this).prev().find('.panel-body'));
});

$('.btn-add-rankingOption').unbind('click').bind('click', function (event) {
    event.preventDefault();
    var clone = $('#rankingItem').clone().removeClass('hidden');
    $(this).prev().find('.panel-body').append(clone);
    checkCurrentListState($(this).prev().find('.panel-body'));
});

$('body').on('click', '.btn-add-woz-experimentOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        $(this).prev().append($('#wozExperimentItem').clone().removeClass('hidden'));
        checkCurrentListState($(this).prev());
    }
});

$('body').on('click', '.btn-add-helpOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        $(this).prev().append($('#helpItem').clone().removeClass('hidden'));
        checkCurrentListState($(this).prev());
        updateHelpItemCounter($(this).prev());
    }
});

$('body').on('click', '.btn-add-triggerOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var clone = $('#triggerItem').clone(true);
        clone.removeClass('hidden');
        clone.removeAttr('id');
        $(this).parent().prev().append(clone);
        checkCurrentListState($(this).parent().prev());
    }
});

$('body').on('click', '.btn-add-gestureTrainingOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        $(this).prev().append($('#gestureTrainingItem').clone().removeClass('hidden'));
        checkCurrentListState($(this).prev());
    }
});

$('body').on('click', '.btn-add-elicitationOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        $(this).prev().append($('#elicitationItem').clone().removeClass('hidden'));
        checkCurrentListState($(this).prev());
    }
});

$('body').on('click', '.select .option li', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        var parent = $(this).closest('.select');
        if ($(parent).hasClass('scaleSelect')) {
            var scaleItemContainer = $(this).parents('.root').first().find('.ratingScaleItemContainer');
            var scaleSelectCount = $(this).children().text().trim();
            renderScaleItems(scaleItemContainer, scaleSelectCount, undefined);
        }
    }
});


function renderScaleItems(container, count, text)
{
    $(container).empty();
    for (var i = 0; i < count; i++)
    {
        var scaleItem = $('#ratingScaleItem').clone();
        scaleItem.removeClass('hidden');
        $(container).append(scaleItem);

        if (i === 0) {
            $(scaleItem).find('.input-group-addon').text("von " + (i + 1));
            $(scaleItem).find('.item-input-text').attr('placeholder', 'z.B. trifft zu');
        } else if (i === count - 1) {
            $(scaleItem).find('.input-group-addon').text("bis " + (i + 1));
            $(scaleItem).find('.item-input-text').attr('placeholder', 'z.B. trifft nicht zu');
        } else {
            $(scaleItem).find('.input-group-addon').text(i + 1);
        }
        if (text !== undefined) {
            $(scaleItem).find('.item-input-text').val(text[i]);
        }
    }
}

function updateBadges(container, selector) {
    if (selector !== null) {
        var children = container.children('#' + selector);
        for (var i = 0; i < children.length; i++) {
            $(children[i]).find('.badgeId').text(i + 1);
            $(children[i]).find('.badgeQuantity').text(children.length);
        }
    }
}

$('body').on('click', '.btn-up', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        updateBadges($(this).closest('.container-root'), $(this).closest('.root').attr('id'));
    }
});

$('body').on('click', '.btn-down', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        updateBadges($(this).closest('.container-root'), $(this).closest('.root').attr('id'));
    }
});

$('body').on('click', '.btn-delete', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        updateBadges(currentContainerList, $(this).closest('.root').attr('id'));
    }
});


/* 
 * specific help up/down button actions 
 */

$('body').on('click', '#helpContainer .btn-up', function (event) {
    event.preventDefault();
    updateHelpItemCounter($(this).closest('.option-container'));
});

$('body').on('click', '#helpContainer .btn-down', function (event) {
    event.preventDefault();
    updateHelpItemCounter($(this).closest('.option-container'));
});

function updateHelpItemCounter(container) {
    var children = container.children();
    for (var i = 0; i < children.length; i++) {
        $(children[i]).find('.count-text').text(i + 1);
    }
}


/*
 * Specific alternative switch functionalities
 */

$('.alternativeSwitch .check').unbind('click').bind('click', function (event) {
    $(this).closest('.root').find('.alternativeGestureSelect').addClass('hidden');
    $(this).closest('.root').find('.alternativeTriggerSelect').addClass('hidden');

    if ($(this).hasClass(ALERT_NO_GESTURES_ASSEMBLED)) {
        if (assembledGestures()) {
            $(this).closest('.root').find('.alternativeGestureSelect').removeClass('hidden');
        }
    } else if ($(this).hasClass(ALERT_NO_TRIGGER_ASSEMBLED)) {
        if (getLocalItem(ASSEMBLED_TRIGGER)) {
            $(this).closest('.root').find('.alternativeTriggerSelect').removeClass('hidden');
        }
    }
});

/* 
 * Check if there are assembled gestures (a gesture set)
 * It's for the alert showing in dichotomous question container 
 * 
 * reset: remove alerts
 */

$('body').on('click', '.check', function (event) {

    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        $(this).closest('.root').find('.alert-space').empty();

        if ($(this).hasClass(ALERT_NO_GESTURES_ASSEMBLED)) {
            if (!assembledGestures()) {
                appendAlert($(this).closest('.root'), ALERT_NO_GESTURES_ASSEMBLED);
            }
        } else if ($(this).hasClass(ALERT_NO_TRIGGER_ASSEMBLED)) {
            if (!getLocalItem(ASSEMBLED_TRIGGER)) {
                appendAlert($(this).closest('.root'), ALERT_NO_TRIGGER_ASSEMBLED);
            }
        }
    }
});

$('body').on('click', '.reset', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        $(this).closest('.root').find('.alert-space').empty();
    }
});


/* 
 * toggable panel with switch button 
 */

$('.btn-toggle-checkbox-panel').unbind('click').bind('click', function (event) {
    event.preventDefault();

    console.log('btn-toggle-checkbox-panel clicked');

    var panelBody = $(this).closest('.root').find('.panel-body');

    if ($(this).attr('id') === 'yes' && panelBody.hasClass('hidden')) {
        togglePanelBody(panelBody);
        togglePanelBadges($(this).closest('.root').find('.badges'));
    } else if ($(this).attr('id') === 'no' && !panelBody.hasClass('hidden')) {
        togglePanelBody(panelBody);
        togglePanelBadges($(this).closest('.root').find('.badges'));
    }
});

function togglePanelBody(panelBody) {
    if ($(panelBody).hasClass('hidden')) {
        $(panelBody).removeClass('hidden');
    } else {
        $(panelBody).addClass('hidden');
    }
}

function togglePanelBadges(badges) {
    if (badges !== undefined || badges !== null) {
        if ($(badges).hasClass('hidden')) {
            $(badges).removeClass('hidden');
        } else {
            $(badges).addClass('hidden');
        }
    }
}


/* 
 * Actions for the gesture select dropdown
 */

function renderAssembledGestures() {
    var gestures = assembledGestures();

    if (gestures) {
        var dropdown = $('#form-item-container').find('.gestureSelect');
        $(dropdown).find('.option').empty();

        for (var i = 0; i < gestures.length; i++) {
            var listItem = document.createElement('li');
            listItem.setAttribute('id', gestures[i].id);
            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(gestures[i].title));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
            $('#form-item-container').find('.gestureSelect .dropdown-toggle').removeClass('disabled');
            $('#form-item-container').find('.option-gesture').attr('placeholder', 'Bitte wählen');
        }
    } else {
        $('#form-item-container').find('.gestureSelect .dropdown-toggle').addClass('disabled');
        $('#form-item-container').find('.option-gesture').attr('placeholder', 'Kein Gestenset vorhanden');
    }
}

/* 
 * Actions for the feedback select dropdown
 */

function renderPredefinedFeedback() {
    var feedback = getLocalItem(PREDEFINED_GESTURE_FEEDBACK);

    var dropdown = $('#form-item-container').find('.feedbackSelect');
    $(dropdown).find('.option').empty();
    var listItem;

    for (var i = 0; i < feedback.length; i++) {
        if (i === 0) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', 'unselected');

            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode('Keines'));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        }

        listItem = document.createElement('li');
        listItem.setAttribute('id', feedback[i].id);

        var link = document.createElement('a');
        link.setAttribute('href', '#');
        link.appendChild(document.createTextNode(feedback[i].title));
        listItem.appendChild(link);
        $(dropdown).find('.option').append(listItem);
    }
}

/* 
 * Actions for the trigger select dropdown
 */

function renderAssembledTriggers() {
    var triggers = getLocalItem(ASSEMBLED_TRIGGER);
    var dropdown = $('#form-item-container').find('.triggerSelect');
    $(dropdown).find('.option').empty();

    if (triggers && triggers.length > 0) {
        $(dropdown).find('.dropdown-toggle').removeClass('disabled');
        var listItem;
        for (var i = 0; i < triggers.length; i++) {
            listItem = document.createElement('li');
            listItem.setAttribute('id', triggers[i].id);
//            console.log(triggers[i].id)

            var link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(triggers[i].title));
            listItem.appendChild(link);
            $(dropdown).find('.option').append(listItem);
        }
        $('body').find('.option-trigger').attr('placeholder', 'Bitte wählen');
    } else {
        $(dropdown).find('.dropdown-toggle').addClass('disabled');
        $('body').find('.option-trigger').attr('placeholder', 'Kein Triggerset vorhanden');
    }
}

/* 
 * Actions for the prototype select dropdown
 */

function renderAssembledPrototypes() {
    var prototypes = getLocalItem(ASSEMBLED_PROTOTYPES);
    var prototypeDropdown = $('body').find('.prototypeSelect');
    $(prototypeDropdown).find('.option').empty();

    if (prototypes && prototypes.length > 0) {
        $(prototypeDropdown).find('.dropdown-toggle').removeClass('disabled');
        var listItem;

        for (var i = 0; i < prototypes.length; i++) {
            var link = document.createElement('a');
            if (i === 0) {
                listItem = document.createElement('li');
                listItem.setAttribute('id', 'unselected');

                link.setAttribute('href', '#');
                link.appendChild(document.createTextNode('keines'));
                listItem.appendChild(link);
                $(prototypeDropdown).find('.option').append(listItem);
            }

            listItem = document.createElement('li');
            listItem.setAttribute('id', prototypes[i].id);

            link = document.createElement('a');
            link.setAttribute('href', '#');
            link.appendChild(document.createTextNode(prototypes[i].title));
            listItem.appendChild(link);
            $(prototypeDropdown).find('.option').append(listItem);
        }
        $('body').find('.option-prototype').attr('placeholder', 'Bitte wählen');
    } else {
        $(prototypeDropdown).find('.dropdown-toggle').addClass('disabled');
        $('body').find('.option-prototype').attr('placeholder', 'Keine Prototypen vorhanden');
    }
}

//$('body').on('click', '.gestureSelect .option li, .triggerSelect .option li, .feedbackSelect .option li, .repeatsSelect .option li, .prototypeSelect .option li', function () {
//    var parent = $(this).closest('.select');
//    var itemText = $(this).children().text();
//    var listItemId = $(this).attr('id');
//    $(parent).find('.selected').attr('id', listItemId);
//    $(parent).prev().val(itemText);
//
//    if ($(parent).closest('.select').hasClass('gestureSelect')) {
//        $(this).closest('.root').find('#assembled-gestures-removed').addClass('hidden');
//    }
//    if ($(parent).closest('.select').hasClass('triggerSelect')) {
//        $(this).closest('.root').find('#assembled-trigger-removed').addClass('hidden');
//    }
//    if ($(parent).closest('.select').hasClass('feedbackSelect')) {
//        if (listItemId === 'unselected') {
//            $(parent).find('.selected').val("");
//        }
//    }
//});

$('body').on('click', '.simple-stepper .btn-stepper-decrease', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var min = parseInt($(this).val());
        var currentValue = parseInt($(this).closest('.simple-stepper').find('.stepper-text').val());
        if (currentValue > min) {
            currentValue--;
        } else {
            currentValue = min;
        }
        $(this).closest('.simple-stepper').find('.stepper-text').val(currentValue);
    }
});

$('body').on('click', '.simple-stepper .btn-stepper-increase', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var max = parseInt($(this).val());
        var currentValue = parseInt($(this).closest('.simple-stepper').find('.stepper-text').val());
        if (currentValue < max) {
            currentValue++;
        } else {
            currentValue = max;
        }
        $(this).closest('.simple-stepper').find('.stepper-text').val(currentValue);
    }
});

$('body').on('click', '.choosePrototypeImage', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        $(this).closest('.root').find('.imageUpload').click();
    }
});

$('body').on('change', '.imageUpload', function (event) {
    event.preventDefault();
    var imageAreaContent = $(this).parent().find('.imageAreaContent');
    var imageArea = $(this).parent().find('.imageArea');
    var control = $(this);

    readFile(this.files[0], function (event) {
        $(imageAreaContent).attr("src", event.target.result);
        $(imageArea).removeClass('hidden');
        $(imageArea).parent().find('.choosePrototypeImage .btn-text').text('Anderes Bild auswählen');
        $(imageArea).parent().find('.choosePrototypeImage .btn-icon').removeClass('glyphicon-picture');
        $(imageArea).parent().find('.choosePrototypeImage .btn-icon').addClass('glyphicon-refresh');
        control.replaceWith(control = control.clone(true));
    });
});

$('body').on('click', '.btn-delete-image', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        $(this).next().attr('src', '');
        $(this).parent().addClass('hidden');
        $(this).closest('.root').find('.choosePrototypeImage .btn-text').text('Bild auswählen');
        $(this).closest('.root').find('.choosePrototypeImage .btn-icon').removeClass('glyphicon-refresh');
        $(this).closest('.root').find('.choosePrototypeImage .btn-icon').addClass('glyphicon-picture');
    }
});

$('body').on('click', '.choosePrototypeVideo', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        var video = $(this).closest('.root').find('.videoContainer');
        video.data('aspectRatio', video.attr('height') / video.attr('width'));
        // and remove the hard coded width/height
        video.removeAttr('height');
        video.removeAttr('width');

        // Get parent width of this video
        var newWidth = video.parent().width();

        video.width(newWidth);
        video.height(newWidth * video.data('aspectRatio'));
//        updateVideoRatios();
//        $(this).closest('.root').find('.videoUpload').click();
    }
});

$('body').on('change', '.videoUpload', function (event) {
    event.preventDefault();
    var file = this.files[0];
    var videoAreaContent = $(this).parent().find('.videoAreaContent');
    var videoArea = $(this).parent().find('.videoArea');
    var control = $(this);


    var reader = new FileReader();
    reader.onloadstart = function (event) {
        console.log('on load start');
        $(videoArea).addClass('hidden');
    };
//    reader.onprogress = function(event) {
////        console.log('on progress');
//    };

    reader.onload = function (event) {
//        console.log('on load');
        the_url = event.target.result;
        //of course using a template library like handlebars.js is a better solution than just inserting a string
        $(videoAreaContent).html("<source id='videoSource' src='" + the_url + "' type='video/mp4'>");
//        $('#name-vid').html(file.name)
//        $('#size-vid').html(humanFileSize(file.size, "MB"))
//        $('#type-vid').html(file.type)
        $(videoArea).removeClass('hidden');
        $(videoArea).parent().find('.choosePrototypeVideo .btn-text').text('Anderes Bild auswählen');
        $(videoArea).parent().find('.choosePrototypeVideo .btn-icon').removeClass('glyphicon-picture');
        $(videoArea).parent().find('.choosePrototypeVideo .btn-icon').addClass('glyphicon-refresh');
        control.replaceWith(control = control.clone(true));

    };

    //when the file is read it triggers the onload event above.
    reader.readAsDataURL(file);

//    fileReader = new FileReader();
//    fileReader.onload = function (event) {
//        $(videoAreaContent).find('#videoSource').attr("src", event.target.result);

//        console.log($(videoAreaContent).find('#videoSource'));
//    };
//    fileReader.readAsDataURL(file);
//    readFile(file, function (event) {
//        console.log($(videoAreaContent).find('#videoSource'));
//        $(videoAreaContent).find('#videoSource').attr("src", event.target.result);
//        $(videoArea).removeClass('hidden');
////        $(videoArea).parent().find('.choosePrototypeVideo .btn-text').text('Anderes Bild auswählen');
////        $(videoArea).parent().find('.choosePrototypeVideo .btn-icon').removeClass('glyphicon-picture');
////        $(videoArea).parent().find('.choosePrototypeVideo .btn-icon').addClass('glyphicon-refresh');
//        control.replaceWith(control = control.clone(true));
//    });
});

function readFile(file, onLoadCallback) {
    var reader = new FileReader();
    reader.onload = onLoadCallback;
    reader.readAsDataURL(file);
}

//function renderVideo(file) {
//    var reader = new FileReader();
//    reader.onload = function (event) {
//        the_url = event.target.result;
//        //of course using a template library like handlebars.js is a better solution than just inserting a string
//        $('.videoAreaContent').html("<source id='vid-source' src='" + the_url + "' type='video/mp4'>");
////        $('#name-vid').html(file.name)
////        $('#size-vid').html(humanFileSize(file.size, "MB"))
////        $('#type-vid').html(file.type)
//
//    };
//
//    //when the file is read it triggers the onload event above.
//    reader.readAsDataURL(file);
//}


$('body').on('click', '.checkVideoEmbedURL', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var url = $(this).closest('.root').find('.video-embed-url').val();
        var inputField = $(this).closest('.root').find('.video-embed-url');
        var videoContainer = $(this).closest('.root').find('.videoContainer');
        var inputContainer = $(this).closest('.form-group');
        var button = $(this);

        $(this).closest('.root').find('.alert-' + ALERT_VIDEO_EMBED_URL_INVALID).empty();

        if (url && url.trim() !== "" && urlIsValid(url, TYPE_URL_VIDEO_EMBED)) {
            // check the video URL if they is valid. works for vimeo & youtube
            videoContainer.html(url);
            videoContainer.removeClass('hidden');
            var video = $(this).closest('.root').find('.videoContainer iframe');
            var newWidth = videoContainer.width();
            video.data('aspectRatio', video.attr('height') / video.attr('width'));
            console.log('url valid: ' + video.data('aspectRatio') + ", " + video.attr('height') + ", " + video.attr('width') + ', ' + newWidth);
            video.attr('width', newWidth);
            video.attr('height', newWidth * video.data('aspectRatio'));
            inputContainer.removeClass('has-error');
            inputContainer.addClass('has-success');
            button.removeClass('btn-danger');
            button.addClass('btn-success');
            inputField.blur();
        } else if (url && url.trim() !== "") {
            videoContainer.addClass('hidden');
            videoContainer.html('');
            inputContainer.removeClass('has-success');
            inputContainer.addClass('has-error');
            button.removeClass('btn-success');
            button.addClass('btn-danger');
            inputField.focus();

            appendAlert($(this).closest('.root'), ALERT_VIDEO_EMBED_URL_INVALID);
//            var alert = $('#form-item-container').find('#' + ALERT_VIDEO_EMBED_URL_INVALID).clone();
//            $(this).closest('.root').find('.alert-' + alert.attr('id')).append(alert);
        } else {
            videoContainer.addClass('hidden');
            videoContainer.html('');
            button.removeClass('btn-success');
            button.removeClass('btn-danger');
            inputContainer.removeClass('has-success');
            inputContainer.removeClass('has-error');
            inputField.focus();
        }
    }
});

$('body').on('click', '.checkPidocoEditURL', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var url = $(this).closest('.root').find('.pidoco-edit-url').val();
        if (url && url.trim() !== "") {
            var container = $(this).closest('.form-group');
            var button = $(this);
            var inputField = $(this).closest('.root').find('.pidoco-edit-url');
            $(this).closest('.root').find('.alert-' + ALERT_PIDOCO_EDIT_URL_INVALID).empty();
            // check the URL if they is valid.
            if (urlIsValid(url, TYPE_URL_PIDOCO_EDIT))
            {
                $(this).closest('.root').find('.transmit-gestures-select').removeClass('hidden');
                container.removeClass('has-error');
                container.addClass('has-success');
                button.removeClass('btn-danger');
                button.addClass('btn-success');
                inputField.blur();

            } else {
                $(this).closest('.root').find('.pidocoUseGestures').addClass('hidden');
                container.removeClass('has-success');
                container.addClass('has-error');
                button.removeClass('btn-success');
                button.addClass('btn-danger');
                inputField.focus();

                appendAlert($(this).closest('.root'), ALERT_PIDOCO_EDIT_URL_INVALID);
//                var alert = $('#form-item-container').find('#' + ALERT_PIDOCO_EDIT_URL_INVALID).clone();
//                $(this).closest('.root').find('.alert-' + alert.attr('id')).append(alert);
            }
        }
    }
});

$('body').on('click', '.checkPidocoEmbedURL', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var url = $(this).closest('.root').find('.pidoco-embed-url').val();
        if (url && url.trim() !== "") {
            var container = $(this).closest('.form-group');
            var button = $(this);
            var inputField = $(this).closest('.root').find('.pidoco-embed-url');
            $(this).closest('.root').find('.alert-' + ALERT_PIDOCO_EMBED_URL_INVALID).empty();
            // check the URL if they is valid.
            // example: https://pidoco.com/rabbit/prototype/result/172450/page781496647/plain
            if (urlIsValid(url, TYPE_URL_PIDOCO_EMBED))
            {
                container.removeClass('has-error');
                container.addClass('has-success');
                button.removeClass('btn-danger');
                button.addClass('btn-success');
                inputField.blur();

            } else {
                container.removeClass('has-success');
                container.addClass('has-error');
                button.removeClass('btn-success');
                button.addClass('btn-danger');
                inputField.focus();

                appendAlert($(this).closest('.root'), ALERT_PIDOCO_EMBED_URL_INVALID);
//                var alert = $('#form-item-container').find('#' + ALERT_PIDOCO_EMBED_URL_INVALID).clone();
//                $(this).closest('.root').find('.alert-' + alert.attr('id')).append(alert);
            }
        }
    }
});

function urlIsValid(url, type) {
    var regEx = null;
    switch (type) {
        case TYPE_URL_PIDOCO_EDIT:
            regEx = /https:\/\/pidoco.com\/rabbit\/edit\/[0-9]+#page\/page[0-9]+/;
            break;
        case TYPE_URL_PIDOCO_EMBED:
            https://pidoco.com/rabbit/api/prototypes/172450/pages/page648229105.xhtml?mode=plain&api_key=kzhIRzrEw4dmNbIvLfhvwL0c6tmUWL7Ek9PaiHNg
                    regEx = /https:\/\/pidoco.com\/rabbit\/api\/prototypes\/[0-9]+\/pages\/page[0-9]+/;
            break;
        case TYPE_URL_VIDEO_EMBED:
            if (
                    url.toLowerCase().indexOf("<iframe") >= 0
                    && url.toLowerCase().indexOf("width=") >= 0
                    && url.toLowerCase().indexOf("height=") >= 0
                    && url.toLowerCase().indexOf("height=") >= 0
                    && url.toLowerCase().indexOf("src=") >= 0
                    && url.toLowerCase().indexOf("</iframe>") >= 0
                    && (/www.youtube.com\/embed\/[A-z0-9]+/.test(url)
                            || /player.vimeo.com\/video\/[A-z0-9]+/.test(url))
                    )
            {
                return true;
            }
            break;
    }

    return regEx && url && regEx.test(url);
}

$('body').on("keyup", '.enter-key', function (event) {
    if (event.keyCode === 13) {
        $(this).parent().find('.checkInput').click();
    } else {
        $(this).parent().find('.checkInput').removeClass('btn-danger');
        $(this).parent().find('.checkInput').removeClass('btn-success');
        $(this).closest('.form-group').removeClass('has-success');
        $(this).closest('.form-group').removeClass('has-error');
    }
});


// slideshow
$('body').on('click', '.btn-add-slideshowOption', function (event) {
    console.log('on btn-add-slideshowOption clicked');
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        $(this).prev().append($('#slideshowItem').clone().removeClass('hidden'));
        checkCurrentListState($(this).prev());
    }
});