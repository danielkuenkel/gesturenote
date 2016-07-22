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
        var selectedID = $(this).parent().find('.chosen').attr('id');
        if (selectedID !== 'unselected') {
            var clone = $('#form-item-container').find('#' + selectedID).clone(true);
            $('#list-container').prepend(clone);
            checkCurrentListState($('#list-container'));
            updateBadges($('#list-container'), selectedID);
        }
    }
});

$(document).on('click', '.btn-add-groupingQuestionOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var clone = $('#groupingQuestionItem').clone().removeClass('hidden');
        $(this).prev().find('.panel-body').append(clone);
        checkCurrentListState($(this).prev().find('.panel-body'));
    }
});

$(document).on('click', '.btn-add-ratingOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var clone = $('#ratingItem').clone().removeClass('hidden');
        clone.removeAttr('id');
        $(this).prev().find('.panel-body').append(clone);
        checkCurrentListState($(this).prev().find('.panel-body'));
        $(clone).find('.chosen').attr('id', 3);
        $(clone).find('.show-dropdown').val(3);
        $(clone).find('#scale_3').addClass('selected');
        renderScaleItems($(clone).find('.ratingScaleItemContainer'), 3);
    }
});

$(document).on('click', '.btn-add-sumQuestionOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var clone = $('#sumQuestionItem').clone().removeClass('hidden');
        $(this).prev().find('.panel-body').append(clone);
        checkCurrentListState($(this).prev().find('.panel-body'));
    }
});

$(document).on('click', '.btn-add-rankingOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var clone = $('#rankingItem').clone().removeClass('hidden');
        $(this).prev().find('.panel-body').append(clone);
        checkCurrentListState($(this).prev().find('.panel-body'));
    }
});

$('body').on('click', '.btn-add-woz-experimentOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
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

$('body').on('click', '.scaleSelect .option li', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        if (!$(this).hasClass('selected')) {
            var scaleItemContainer = $(this).closest('.root').find('.ratingScaleItemContainer');
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
        var children = $(container).children('#' + selector);
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
//
//$('body').on('click', '.btn-delete', function (event) {
//    if (event.handled !== true)
//    {
//        event.handled = true;
//        updateBadges($(this).closest('.container-root'), $(this).closest('.root').attr('id'));
//    }
//});


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

$('body').on('click', '.alternativeSwitch .check', function (event) {
    event.preventDefault();

    $(this).closest('.root').find('.alternativeGestureSelect').addClass('hidden');
    $(this).closest('.root').find('.alternativeTriggerSelect').addClass('hidden');

    if ($(this).hasClass(ALERT_NO_GESTURES_ASSEMBLED)) {
        if (assembledGestures() !== null) {
            $(this).closest('.root').find('.alternativeGestureSelect').removeClass('hidden');
        }
    } else if ($(this).hasClass(ALERT_NO_TRIGGER_ASSEMBLED)) {
        if (getLocalItem(ASSEMBLED_TRIGGER) !== null) {


        }
    }
});

$('body').on('click', '.chooseSceneImage', function (event) {
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
        $(imageArea).parent().find('.chooseSceneImage .btn-text').text('Anderes Bild auswählen');
        $(imageArea).parent().find('.chooseSceneImage .btn-icon').removeClass('glyphicon-picture');
        $(imageArea).parent().find('.chooseSceneImage .btn-icon').addClass('glyphicon-refresh');
        control.replaceWith(control = control.clone(true));
    });
});

$('body').on('click', '.btn-delete-image', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        $(this).next().attr('src', '');
        $(this).parent().addClass('hidden');
        $(this).closest('.root').find('.chooseSceneImage .btn-text').text('Bild auswählen');
        $(this).closest('.root').find('.chooseSceneImage .btn-icon').removeClass('glyphicon-refresh');
        $(this).closest('.root').find('.chooseSceneImage .btn-icon').addClass('glyphicon-picture');
    }
});

$('body').on('click', '.chooseFeedbackSound', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        $(this).closest('.root').find('.soundUpload').click();
    }
});

$('body').on('change', '.soundUpload', function (event) {
    event.preventDefault();
    var dataHolder = $(this).parent().find('.audio-holder');
    var audioPlayer = $(this).parent().find('.audioPlayer');
    var control = $(this);
    console.log(this.files[0]);
    readFile(this.files[0], function (event) {
        $(dataHolder).attr("src", event.target.result);
        $(audioPlayer).removeClass('hidden');
        $(audioPlayer).parent().find('.chooseFeedbackSound .btn-text').text('Andere Sounddatei auswählen');
        $(audioPlayer).parent().find('.chooseFeedbackSound .btn-icon').removeClass('fa fa-volume-up');
        $(audioPlayer).parent().find('.chooseFeedbackSound .btn-icon').addClass('glyphicon glyphicon-refresh');
        control.replaceWith(control = control.clone(true));
    });
});

$('body').on('click', '.btn-delete-sound', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        $(this).next().attr('src', '');
        $(this).closest('.audioPlayer').addClass('hidden');
        $(this).closest('.root').find('.chooseFeedbackSound .btn-text').text('Sounddatei auswählen');
        $(this).closest('.root').find('.chooseFeedbackSound .btn-icon').removeClass('glyphicon glyphicon-refresh');
        $(this).closest('.root').find('.chooseFeedbackSound .btn-icon').addClass('fa fa-volume-up');
        $(this).closest('.root').find('#stop').click();
    }
});

$('body').on('click', '.audioPlayer #play', function (event) {
    event.preventDefault();
    var audioElement = $(this).closest('.audioPlayer').find('.audio-holder')[0];
    audioElement.play();
});

$('body').on('click', '.audioPlayer #pause', function (event) {
    event.preventDefault();
    var audioElement = $(this).closest('.audioPlayer').find('.audio-holder')[0];
    audioElement.pause();
});

$('body').on('click', '.audioPlayer #stop', function (event) {
    event.preventDefault();
    var audioElement = $(this).closest('.audioPlayer').find('.audio-holder')[0];
    audioElement.pause();
    audioElement.currentTime = 0;
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
        var ratio = $(this).closest('.root').find('.ratioSelect .chosen').attr('id');
//        console.log(ratio);

        $(this).closest('.root').find('.alert-' + ALERT_VIDEO_EMBED_URL_INVALID).empty();

        if (url && url.trim() !== "" && urlIsValid(url, TYPE_URL_VIDEO_EMBED)) {
            // check the video URL if they is valid. works for vimeo & youtube
            videoContainer.html(url);
            videoContainer.removeClass('hidden');
            var video = $(this).closest('.root').find('.videoContainer iframe');
            $(video).addClass('embed-responsive-item');
//            var newWidth = videoContainer.width();
//            video.data('aspectRatio', video.attr('height') / video.attr('width'));
//            console.log('url valid: ' + video.data('aspectRatio') + ", " + video.attr('height') + ", " + video.attr('width') + ', ' + newWidth);
//            video.attr('width', newWidth);
//            video.attr('height', newWidth * video.data('aspectRatio'));
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
        } else {
            videoContainer.addClass('hidden');
            videoContainer.html('');
            button.removeClass('btn-success');
            button.removeClass('btn-danger');
            inputContainer.removeClass('has-success');
            inputContainer.removeClass('has-error');
            inputField.focus();
        }

        $(this).closest('.root').find('.ratioSelect .option li').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('selected')) {
                var ratio = $(this).attr('id');
                var videoContainer = $(this).closest('.root').find('.videoContainer');
                if (ratio === 'ratio_16_9') {
                    $(videoContainer).removeClass('embed-responsive-4by3').addClass('embed-responsive-16by9');
                } else {
                    $(videoContainer).removeClass('embed-responsive-16by9').addClass('embed-responsive-4by3');
                }
            }
        });
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
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        $(this).prev().append($('#slideshowItem').clone().removeClass('hidden'));
        checkCurrentListState($(this).prev());
    }
});

// identification
$('body').on('click', '.btn-add-identificationOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var item = $('#identificationItem').clone().removeClass('hidden').removeAttr('id');
        $(this).prev().append(item);
        var identificationFor = $('#identificationTypeSwitch').find('.active').attr('id');

        if (identificationFor === 'gestures') {
            $(item).find('#group-gestures').remove();
//            $(item).find('#group-trigger').removeClass('hidden');
        } else {
            $(item).find('#group-trigger').remove();
//            $(item).find('#group-gestures').removeClass('hidden');
        }
        checkCurrentListState($(this).prev());
    }
});



// gus dimension handling
function renderDimensions(target) {
    var dimensions = translation.dimensions;

    for (var key in dimensions) {
        if (dimensions.hasOwnProperty(key)) {
            var value = dimensions[key];
            var button = document.createElement('button');
            $(button).addClass('btn btn-default btn-shadow btn-toggle btn-dimension hidden');
            $(button).attr('id', key);
            $(button).text(value);
            $(target).prepend(button);
        }
    }
}

$('body').on('click', '#dimension-btn-group .btn-toggle', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;

        if ($(this).hasClass('active')) {
            removeQuestionaireItems($(this).attr('id'));
            $(this).removeClass('active');
            $(this).removeClass('btn-info');
            $(this).addClass('inactive');

            if ($(this).attr('id') === 'all') {
                $('#factor-seperator').addClass('hidden');

                var children = $(this).parent().children('.btn-toggle');
                $(children).filter('.active').removeClass('btn-info');
                $(children).filter('.active').addClass('inactive');
                $(children).filter('.active').removeClass('active');
                $(this).text('Alle');
            } else {
                $(this).parent().find('#all').removeClass('active');
                $(this).parent().find('#all').removeClass('btn-info');
                $(this).parent().find('#all').text('Alle');
                checkDimensionItems();
            }
        } else {
            addQuestionnaireItems($(this).attr('id'));
            $(this).addClass('active');
            $(this).addClass('btn-info');
            $(this).removeClass('inactive');

            if ($(this).attr('id') === 'all') {
                $('#factor-seperator').removeClass('hidden');

                var children = $(this).parent().children('.btn-toggle');
                $(children).filter('.inactive').addClass('btn-info');
                $(children).filter('.inactive').addClass('active');
                $(children).filter('.inactive').removeClass('inactive');
                $(this).text('Keine');
            } else {
                checkDimensionItems();
            }
        }
    }
});

function checkDimensionItems() {
    var dimensions = $('#dimension-btn-group').children('.btn-dimension');
    var shownDimensions = $('#dimension-btn-group').children('.btn-dimension:not(:hidden)');
    var inactiveDimensions = dimensions.filter('.inactive');

    if (inactiveDimensions.length === shownDimensions.length) {
        $('#factor-seperator').addClass('hidden');

    } else {
        $('#factor-seperator').removeClass('hidden');
    }

    if (inactiveDimensions.length <= 0) {
        $('#dimension-btn-group').find('#all').addClass('active');
        $('#dimension-btn-group').find('#all').removeClass('inactive');
        $('#dimension-btn-group').find('#all').addClass('btn-info');
        $('#dimension-btn-group').find('#all').text('Keine');
    }
}

function addQuestionnaireItems(dimension) {
    if (dimension === 'all') {
        var dimensions = $('#dimension-btn-group').children('.btn-dimension');
        for (var i = 0; i < dimensions.length; i++) {
            var dimensionButton = dimensions[i];
            if (!$(dimensionButton).hasClass('hidden') && !$(dimensionButton).hasClass('active')) {
                renderData(getPredefinedQuestionnaireItemsByDimension($(dimensionButton).attr('id')));
            }
        }
    } else {
        renderData(getPredefinedQuestionnaireItemsByDimension(dimension));
    }
}

var currentGUS = null;
function getPredefinedQuestionnaireItemsByDimension(dimension) {
    var predefinedQuestionnaire = currentGUS === GUS_SINGLE_GESTURES ? getLocalItem(PROJECT_ORIGIN_GUS) : getLocalItem(PREDEFINED_GESTURE_QUESTIONNAIRE);
    var questionnaire = new Array();
    for (var i = 0; i < predefinedQuestionnaire.length; i++) {
        if (predefinedQuestionnaire[i].dimension === dimension) {
            questionnaire.push(predefinedQuestionnaire[i]);
        }
    }
    return {gus: questionnaire};
}

function removeQuestionaireItems(dimension) {
    var itemList = $('#list-container').children();
    for (var i = 0; i < itemList.length; i++) {
        var item = itemList[i];
        var itemDimension = getDimensionByElement($(item));
        if (itemDimension !== DIMENSION_ANY) {
            if (dimension === 'all' || itemDimension === dimension) {
                var itemId = $(item).attr('id');
                $(item).find('.btn-delete').click();
                updateBadges($('#list-container'), itemId);
            }
        }
    }
}

function checkDimensions(predefinedQuestionnaire) {
    for (var i = 0; i < predefinedQuestionnaire.length; i++) {
        if ($('#dimension-btn-group').find('#' + predefinedQuestionnaire[i].dimension)) {
            $('#dimension-btn-group').find('#' + predefinedQuestionnaire[i].dimension).removeClass('hidden');
            $('#dimension-btn-group').find('#' + predefinedQuestionnaire[i].dimension).addClass('inactive');
        }
    }
}


/*
 * get the format item
 */

function renderFormatItem(target, data) {
    var clone = $('#form-item-container').find('#' + data.type).clone();
    $(clone).find('.question').val(data.question);
    clone.addClass(data.dimension);
    target.append(clone);

    var parameters = data.parameters;
    var options = data.options;

    switch (data.type) {
        case DICHOTOMOUS_QUESTION:
            var aGestures = assembledGestures();
//            if (parameters[0] === true && (aGestures && aGestures.length > 0)) {
//                $(clone).find('.gesture-select .switchButtonAddon').click();
//            }

            if (parameters[0] === true) {
                $(clone).find('.justification .switchButtonAddon').click();
            }
            break;
        case GROUPING_QUESTION:
            if (parameters[0] === true) {
                $(clone).find('.multiselect .switchButtonAddon').click();
            }
            if (parameters[1] === true) {
                $(clone).find('.optionalanswer .switchButtonAddon').click();
            }

            if (options) {
                for (var j = 0; j < options.length; j++) {
                    var option = $('#groupingQuestionItem').clone().removeClass('hidden');
                    $(option).find('.option').val(options[j]);
                    $(clone).find('.option-container').append(option);
                    checkCurrentListState($(clone).find('.option-container'));
                }
            }
            break;
        case GROUPING_QUESTION_GUS:
            if (parameters[0] === true) {
                $(clone).find('.multiselect .switchButtonAddon').click();
            }
            if (parameters[1] === true) {
                $(clone).find('.justification .switchButtonAddon').click();
            }
//            console.log($(clone).find('.optionselect #' + parameters[2]));
//                        $(clone).find('.optionselect #' + parameters[2]).unbind('click').bind('click');

//            $('.optionselect #gestures').unbind('click').bind('click', function (event) {
////                console.log('gestures clicked');
//                event.preventDefault();
//                var aGestures = assembledGestures();
//                var container = $(this).closest('.root').find('.option-container');
//                container.find('.groupingQuestionItem').remove();
//
//                if (aGestures !== null) {
//                    for (var i = 0; i < aGestures.length; i++) {
//                        var item = $(this).closest('.root').find('#groupingQuestionItem').clone().removeClass('hidden').removeAttr('id');
//                        item.addClass('groupingQuestionItem');
//                        item.find('.option').val(aGestures[i].title);
//                        item.find('.option').attr('id', aGestures[i].id);
//                        container.append(item);
//                    }
//                    checkCurrentListState(container);
//                }
//            });
//
//            $('.optionselect #triggers').unbind('click').bind('click', function (event) {
//                event.preventDefault();
//                var triggers = getLocalItem(ASSEMBLED_TRIGGER);
//                var container = $(this).closest('.root').find('.option-container');
//                container.find('.groupingQuestionItem').remove();
//
//                if (triggers !== null) {
//                    for (var i = 0; i < triggers.length; i++) {
//                        var item = $(this).closest('.root').find('#groupingQuestionItem').clone().removeClass('hidden').removeAttr('id');
//                        item.addClass('groupingQuestionItem');
//                        item.find('.option').val(triggers[i].title);
//                        item.find('.option').attr('id', triggers[i].id);
//                        container.append(item);
//                    }
//                    checkCurrentListState(container);
//                }
//            });

            $(clone).find('.optionselect #' + parameters[2]).click();

            break;
        case RATING:
            if (options) {
                for (var j = 0; j < options.length; j++) {
                    var option = $('#ratingItem').clone().removeClass('hidden');
                    $(option).find('.option').val(options[j]);
                    $(clone).find('.option-container').append(option);
                    $(option).find('.optionQuestion').val(options[j][options[j].length - 2]);
                    $(option).find('.chosen').attr('id', (options[j].length - 2));
                    $(option).find('.show-dropdown').val(options[j].length - 2);
                    $(option).find('#scale_' + (options[j].length - 2)).addClass('selected');
                    checkCurrentListState($(clone).find('.option-container'));

                    renderScaleItems($(option).find('.ratingScaleItemContainer'), options[j].length - 2, options[j]);

                    if (options[j][options[j].length - 1] === true) {
                        $(option).find('#yes').click();
                    }
                }
            }
            break;
        case SUM_QUESTION:
            $(clone).find('.allocationSelect #' + parameters[0]).click();
            $(clone).find('.maximum').val(parameters[1]);

            if (options) {
                for (var j = 0; j < options.length; j++) {
                    var option = $('#sumQuestionItem').clone().removeClass('hidden');
                    $(option).find('.option').val(options[j]);
                    $(clone).find('.option-container').append(option);
                    checkCurrentListState($(clone).find('.option-container'));
                }
            }
            break;
        case RANKING:
            if (options) {
                for (var j = 0; j < options.length; j++) {
                    var option = $('#rankingItem').clone().removeClass('hidden');
                    $(option).find('.option').val(options[j]);
                    $(clone).find('.option-container').append(option);
                    checkCurrentListState($(clone).find('.option-container'));
                }
            }
            break;
        case ALTERNATIVE_QUESTION:
            if (parameters[0] === true) {
                $(clone).find('.justification .switchButtonAddon').click();
            }
            if (parameters[1] === true) {
                $(clone).find('.optionalanswer .switchButtonAddon').click();
            }

            $(clone).find('.alternative #' + parameters[2]).click();

            var currentPhase = getPhaseById(currentIdForModal);
            if (currentPhase && currentPhase.selectedId === GUS_SINGLE_GESTURES) {
                $(clone).find('#alternativeTrigger').remove();
                $(clone).find('.alternativeFor').addClass('hidden');
                break;
            }

            if (parameters[3] === 'gesture') {
                if (assembledGestures()) {
                    $(clone).find('#alternativeGesture').click();
                }

                var gesture = parameters[4];
                if (gesture) {
                    if (isGestureAssembled(gesture.id)) {
                        $(clone).find('.option-gesture').val(gesture.title);
                        $(clone).find('.gestureSelect .chosen').attr('id', gesture.id);
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                    }
                }

            } else if (parameters[3] === 'trigger') {
                if (getLocalItem(ASSEMBLED_TRIGGER))
                {
                    $(clone).find('#alternativeTrigger').click();
                }

                if (getTriggerById(parameters[4].id)) {
                    $(clone).find('.option-trigger').val(parameters[4].title);
                    $(clone).find('.triggerSelect .chosen').attr('id', parameters[4].id);
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                }
            } else if (parameters[3] === 'feedbacks') {
                if (getLocalItem(ASSEMBLED_FEEDBACK))
                {
                    $(clone).find('#alternativeFeedback').click();
                }

                if (getTriggerById(parameters[4].id)) {
                    $(clone).find('.option-feedback').val(parameters[4].title);
                    $(clone).find('.feedbackSelect .chosen').attr('id', parameters[4].id);
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_FEEDBACK_REMOVED);
                }
            }
            break;
        case GUS_SINGLE:
            if (parameters[0] === true) {
                $(clone).find('.switchButtonAddon').click();
            }
            break;
    }

    var dimension = data.dimension;
    if (dimension !== DIMENSION_ANY) {
        $(clone).find('#item-factors').removeClass('hidden');
        var dimensionButton = $('#dimension-btn-group').find('#' + dimension);
        if (dimensionButton) {
            $(dimensionButton).addClass('active');
            $(dimensionButton).addClass('btn-info');
            $(dimensionButton).removeClass('inactive');
        }
        var dimensions = translation.dimensions;
        var mainDimensions = translation.mainDimensions;
        $(clone).find('#factor-primary').text(dimensions[dimension]);
        $(clone).find('#factor-main').text(mainDimensions[dimension]);
    }
}

function getFormatData(element) {
    var type = $(element).attr('id');
    var dimension = getDimensionByElement($(element));
    var question = $(element).find('.question').val();
    var parameters = null;
    var options = null;

    switch (type) {
        case DICHOTOMOUS_QUESTION:
            parameters = new Array();
            parameters.push($(element).find('.justification .active').attr('id') === 'yes' ? true : false);
            break;
        case GROUPING_QUESTION:
            parameters = new Array();
            parameters.push($(element).find('.multiselect .active').attr('id') === 'yes' ? true : false);
            parameters.push($(element).find('.optionalanswer .active').attr('id') === 'yes' ? true : false);

            options = new Array();
            var groupingOptions = $(element).find('.option-container').children();
            for (var j = 0; j < groupingOptions.length; j++) {
                options.push($(groupingOptions[j]).find('.option').val());
            }
            break;
        case GROUPING_QUESTION_GUS:
            parameters = new Array();
            parameters.push($(element).find('.multiselect .active').attr('id') === 'yes' ? true : false);
            parameters.push($(element).find('.justification .active').attr('id') === 'yes' ? true : false);
            parameters.push($(element).find('.optionselect .active').attr('id'));
            break;
        case RATING:
            options = new Array();
            var optionList = $(element).find('.option-container').children();
            for (var j = 0; j < optionList.length; j++) {
                var ratingOptions = ($(optionList[j]).find('.ratingScaleItemContainer').children());
                var tempArray = new Array();
                for (var k = 0; k < ratingOptions.length; k++) {
                    tempArray.push($(ratingOptions[k]).find('.option').val());
                }
                tempArray.push($(optionList[j]).find('.optionQuestion').val());
                tempArray.push($(optionList[j]).find('.negative').find('#yes').hasClass('active'));
                options.push(tempArray);
            }
            break;
        case SUM_QUESTION:
            parameters = new Array();
            parameters.push($(element).find('.allocationSelect .chosen').attr('id'));
            parameters.push($(element).find('.maximum').val());

            options = new Array();
            var sumQuestionOptions = $(element).find('.option-container').children();
            for (var j = 0; j < sumQuestionOptions.length; j++) {
                options.push($(sumQuestionOptions[j]).find('.option').val());
            }
            break;
        case RANKING:
            options = new Array();
            var rankingOptions = $(element).find('.option-container').children();
            for (var j = 0; j < rankingOptions.length; j++) {
                options.push($(rankingOptions[j]).find('.option').val());
            }
            break;
        case ALTERNATIVE_QUESTION:
            parameters = new Array();

            parameters.push($(element).find('.justification #yes').hasClass('active'));
            parameters.push($(element).find('.optionalanswer #yes').hasClass('active'));
            parameters.push($(element).find('.alternative').find('.active').attr('id'));
//            console.log(parameters);
            var aGestures = assembledGestures();
            var aTriggers = getLocalItem(ASSEMBLED_TRIGGER);

            var currentPhase = getPhaseById(currentIdForModal);
            if (currentPhase && currentPhase.selectedId === GUS_SINGLE_GESTURES) {
                parameters.push(ALTERNATIVE_FOR_GESTURE);
                break;
            }

            if (aGestures && $(element).find('.alternativeFor .active').attr('id') === 'alternativeGesture') {
                var gestureId = $(element).find('.alternativeGestureSelect .chosen').attr('id');
                if (gestureId !== 'unselected') {
                    parameters.push(ALTERNATIVE_FOR_GESTURE);
                    parameters.push(getGestureById(gestureId));
                }

            } else if (aTriggers && $(element).find('.alternativeFor .active').attr('id') === 'alternativeTrigger') {
                var triggerId = $(element).find('.triggerSelect .chosen').attr('id');
                if (triggerId !== 'unselected') {
                    parameters.push(ALTERNATIVE_FOR_TRIGGER);
                    parameters.push(getTriggerById(triggerId));
                }
            } else if (aTriggers && $(element).find('.alternativeFor .active').attr('id') === 'alternativeFeedback') {
                var feedbackId = $(element).find('.feebackSelect .chosen').attr('id');
                if (feedbackId !== 'unselected') {
                    parameters.push(ALTERNATIVE_FOR_FEEDBACK);
                    parameters.push(feedbackId);
                }
            }
            break;
        case GUS_SINGLE:
            parameters = new Array();
            parameters.push($(element).find('.negative #yes').hasClass('active'));
            options = gusOptions;
            break;
    }
    return new QuestionnaireItem(type, dimension, question, parameters, options);
}