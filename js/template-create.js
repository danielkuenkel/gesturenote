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
        var format = $(this).parent().find('.chosen').attr('id');
        if (format !== 'unselected') {
            var clone = $('#form-item-container').find('#' + format).clone(true);
            var listContainer = $(this).closest('.root').find('#list-container');
            $(listContainer).prepend(clone);
            checkCurrentListState(listContainer);
            updateBadges(listContainer, format);
            TweenMax.from(clone, .3, {y: -20, opacity: 0, clearProps: 'all'});
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
        var wozItem = $('#wozExperimentItem').clone().removeClass('hidden');
        if (getLocalItem(STUDY).phase === TYPE_PHASE_ELICITATION) {
            $(wozItem).find('.evaluation').addClass('hidden');
        }
        $(this).prev().append(wozItem);
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

//$('body').on('click', '.btn-up', function (event) {
//    if (event.handled !== true)
//    {
//        event.handled = true;
//        updateBadges($(this).closest('.container-root'), $(this).closest('.root').attr('id'));
//    }
//});
//
//$('body').on('click', '.btn-down', function (event) {
//    if (event.handled !== true)
//    {
//        event.handled = true;
//        updateBadges($(this).closest('.container-root'), $(this).closest('.root').attr('id'));
//    }
//});
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
    if (event.handled !== true)
    {
        event.handled = true;
        var element = $(this).closest('.root');
        var imageAreaContent = $(element).find('.imageAreaContent');
        var imageArea = $(element).find('.imageArea');
        var control = $(this);
        var button = $(element).find('.chooseSceneImage');
        button.addClass('disabled');
        var imageUrl = $(element).find('.imageAreaContent').attr('src');
        if (imageUrl.trim() !== '') {
            deleteSceneImage({image: ["../" + imageUrl]}, function (result) {
//                console.log('image deleted: ' + result);
            });
        }

        var form = new FormData($(element).find('#upload-image-form'));
        var uploadFiles = $(this)[0].files[0];
        if (uploadFiles) {
            form.append('image', uploadFiles);
        }
        console.log(form, uploadFiles);
        readFile(this.files[0], function () {
            showCursor($('body'), CURSOR_PROGRESS);
            uploadSceneImage(form, function (result) {
                showCursor($('body'), CURSOR_DEFAULT);
                $(button).removeClass('disabled');
                if (result.status === RESULT_SUCCESS) {
                    $(imageAreaContent).attr("src", result.imageUrl);
                    $(imageArea).removeClass('hidden');
                    $(element).find('.chooseSceneImage .btn-text').text('Anderes Bild auswählen');
                    $(element).find('.chooseSceneImage .btn-icon').removeClass('glyphicon-picture');
                    $(element).find('.chooseSceneImage .btn-icon').addClass('glyphicon-refresh');
                    control.replaceWith(control = control.clone(true));
                    saveData();
                } else {

                }
            });
        });
    }
});
$('body').on('click', '.btn-delete-image', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        var button = $(this);
        button.addClass('disabled');
        var element = $(this).closest('.root');
        var imageUrl = ["../" + $(element).find('.imageAreaContent').attr('src')];
        showCursor($('body'), CURSOR_PROGRESS);
        deleteSceneImage({image: imageUrl}, function (result) {
            showCursor($('body'), CURSOR_DEFAULT);
            $(button).removeClass('disabled');
            if (result.status === RESULT_SUCCESS) {
                $(button).next().attr('src', '');
                $(button).parent().addClass('hidden');
                $(button).closest('.root').find('.chooseSceneImage .btn-text').text('Bild auswählen');
                $(button).closest('.root').find('.chooseSceneImage .btn-icon').removeClass('glyphicon-refresh');
                $(button).closest('.root').find('.chooseSceneImage .btn-icon').addClass('glyphicon-picture');
                saveData();
            } else {

            }
        });
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
    if (event.handled !== true)
    {
        var element = $(this).closest('.root');
        event.handled = true;
        var dataHolder = $(element).find('.audio-holder');
        var audioPlayer = $(element).find('.audioPlayer');
        var control = $(this);
        var button = $(dataHolder).parent().find('.chooseFeedbackSound');
        button.addClass('disabled');
        var soundUrl = $(element).find('.audio-holder').attr('src');
        if (soundUrl.trim() !== '') {
            deleteSound({sound: ["../" + soundUrl]}, function (result) {
//                console.log('sound deleted ' + result);
            });
        }

        var form = new FormData();
        var uploadFiles = $(this)[0].files[0];
        if (uploadFiles) {
            form.append('sound', uploadFiles);
        }
        console.log(form, uploadFiles);
        readFile(this.files[0], function () {
            showCursor($('body'), CURSOR_PROGRESS);
            console.log(uploadFiles.size);
            uploadSound(form, function (result) {
                showCursor($('body'), CURSOR_DEFAULT);
                $(button).removeClass('disabled');
                if (result.status === RESULT_SUCCESS) {
                    $(dataHolder).attr("src", result.soundUrl);
                    $(audioPlayer).removeClass('hidden');
                    $(element).find('.chooseFeedbackSound .btn-text').text('Andere Sounddatei auswählen');
                    $(element).find('.chooseFeedbackSound .btn-icon').removeClass('fa fa-volume-up');
                    $(element).find('.chooseFeedbackSound .btn-icon').addClass('glyphicon glyphicon-refresh');
                    control.replaceWith(control = control.clone(true));
                    saveData();
                } else {

                }
            });
//
        });
    }
});
$('body').on('click', '.btn-delete-sound', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        var button = $(this);
        button.addClass('disabled');
        var element = $(this).closest('.root');
        var soundUrl = ["../" + $(element).find('.audio-holder').attr('src')];
        showCursor($('body'), CURSOR_PROGRESS);
        deleteSound({sound: soundUrl}, function (result) {
            showCursor($('body'), CURSOR_DEFAULT);
            $(button).removeClass('disabled');
            if (result.status === RESULT_SUCCESS) {
                $(element).find('.audio-holder').attr('src', '');
                $(element).find('.audioPlayer').addClass('hidden');
                $(element).find('.chooseFeedbackSound .btn-text').text('Sounddatei auswählen');
                $(element).find('.chooseFeedbackSound .btn-icon').removeClass('glyphicon glyphicon-refresh');
                $(element).find('.chooseFeedbackSound .btn-icon').addClass('fa fa-volume-up');
                $(element).find('#stop').click();
                saveData();
            } else {

            }
        });
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
//        var ratio = $(this).closest('.root').find('.ratioSelect .chosen').attr('id');
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
            console.log(url);
            if (
                    url.toLowerCase().indexOf("<iframe") >= 0
                    && url.toLowerCase().indexOf("width=") >= 0
                    && url.toLowerCase().indexOf("height=") >= 0
                    && url.toLowerCase().indexOf("src=") >= 0
                    && url.toLowerCase().indexOf("</iframe>") >= 0
//                    && (/www.youtube.com\/embed\/[A-z0-9]+/.test(url)
//                            || /player.vimeo.com\/video\/[A-z0-9]+/.test(url)
//                            )
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
function renderDimensions(target, questionnaire) {
    var dimensions = translation.dimensions;
    for (var key in dimensions) {
        if (dimensions.hasOwnProperty(key)) {
            var value = dimensions[key];
            var mainDimension = getMainDimensionForDimension(key);
            var button = document.createElement('button');
            $(button).addClass('btn btn-default btn-shadow btn-toggle btn-dimension hidden');
            $(button).attr('id', key);
            $(button).text(value);
            $(target).find('#container-' + mainDimension + " .dimension-btn-group").prepend(button);
        }
    }

    var dimensionContainer = $(target).find('.dimension-container');
    for (var i = 0; i < dimensionContainer.length; i++) {
        if ($(dimensionContainer[i]).find('.btn-dimension').length === 0) {
            $(dimensionContainer[i]).addClass('hidden');
        }
    }

    if (questionnaire && questionnaire.length > 0) {
        for (var i = 0; i < questionnaire.length; i++) {
            if ($(target).find('#' + questionnaire[i].dimension)) {
                $(target).find('#' + questionnaire[i].dimension).removeClass('hidden');
                $(target).find('#' + questionnaire[i].dimension).addClass('inactive');
            }
        }
    } else {
        dimensionContainer.addClass('hidden');
    }
}

$('body').on('click', '.dimension-btn-group .btn-toggle', function (event) {
    if (event.handled !== true)
    {

        event.handled = true;
        var dimensionContainer = $(this).closest('.dimension-container');
        var mainDimension = $(this).closest('.dimension-container').attr('id').split('-')[1];
        console.log(dimensionContainer);
        if ($(this).hasClass('active')) {
            removeQuestionaireItems(mainDimension, $(this).attr('id'));
            $(this).removeClass('active');
            $(this).removeClass('btn-info');
            $(this).addClass('inactive');
            if ($(this).attr('id') === 'all') {
//                $('#factor-seperator').addClass('hidden');

                var children = $(dimensionContainer).find('.btn-toggle');
                $(children).removeClass('btn-info active').addClass('inactive');
                $(this).text('Alle');
            } else {
                $(this).parent().find('#all').removeClass('active btn-info');
                $(this).parent().find('#all').text('Alle');
                checkDimensionItems(dimensionContainer);
            }
        } else {

            addQuestionnaireItems(dimensionContainer, $(this).attr('id'));
            $(this).addClass('active');
            $(this).addClass('btn-info');
            $(this).removeClass('inactive');
            if ($(this).attr('id') === 'all') {
//                $('#factor-seperator').removeClass('hidden');

                var children = $(this).parent().children('.btn-toggle');
                $(children).removeClass('inactive').addClass('btn-info active');
                $(this).text('Keine');
            } else {
                checkDimensionItems(dimensionContainer);
            }
        }
    }
});
function checkDimensionItems(dimensionContainer) {

    for (var i = 0; i < dimensionContainer.length; i++) {
        var container = $(dimensionContainer[i]).find('.dimension-btn-group');
        var dimensions = $(container).children('.btn-dimension');
        var hiddenDimensions = $(container).find('.hidden');
        var inactiveDimensions = dimensions.filter('.inactive');
        if (hiddenDimensions.length < dimensions.length && inactiveDimensions.length === 0) {
            $(container).find('#all').removeClass('inactive').addClass('active btn-info');
            $(container).find('#all').text('Keine');
        }
    }
}

function addQuestionnaireItems(container, dimension) {
    if (dimension === 'all') {
        var dimensions = $(container).find('.btn-dimension');
        for (var i = 0; i < dimensions.length; i++) {
            var dimensionButton = dimensions[i];
            if (!$(dimensionButton).hasClass('hidden') && !$(dimensionButton).hasClass('active')) {
                renderData(getPredefinedQuestionnaireItemsByDimension($(dimensionButton).attr('id')), true);
            }
        }
    } else {
        renderData(getPredefinedQuestionnaireItemsByDimension(dimension), true);
    }
}

var currentGUS = null;
function getPredefinedQuestionnaireItemsByDimension(dimension) {
    var predefinedQuestionnaire = currentGUS === GUS_SINGLE_GESTURES ? getLocalItem(STUDY_ORIGIN_GUS) : getLocalItem(PREDEFINED_GESTURE_QUESTIONNAIRE);
    var questionnaire = new Array();
    for (var i = 0; i < predefinedQuestionnaire.length; i++) {
        if (predefinedQuestionnaire[i].dimension === dimension) {
            questionnaire.push(predefinedQuestionnaire[i]);
        }
    }
    return {gus: questionnaire};
}

function removeQuestionaireItems(mainDimension, dimension) {
    var itemList = $('#list-container').children();
    for (var i = 0; i < itemList.length; i++) {
        var item = itemList[i];
        var itemDimension = getDimensionByElement($(item));
        if (itemDimension !== DIMENSION_ANY) {
            if ((dimension === 'all' && mainDimension === getMainDimensionForDimension(itemDimension)) || itemDimension === dimension) {
                var itemId = $(item).attr('id');
                $(item).find('.btn-delete').click();
                updateBadges($('#list-container'), itemId);
            }
        }
    }
}

$('body').on('click', '.btn-use', function (event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true;
        if ($(this).hasClass('used')) {
            $(this).removeClass('used btn-success').addClass('not-used');
            $(this).closest('.root').removeClass('used');
            $(this).closest('.root').addClass('not-used');
        } else {
            $(this).removeClass('not-used').addClass('used btn-success');
            $(this).closest('.root').removeClass('not-used');
            $(this).closest('.root').addClass('used');
        }
        checkUsedItems($(this).closest('.root'));
    }
});
function checkUsedItems(element) {
    var dimension = getDimensionByElement(element);
    var mainDimension = getMainDimensionForDimension(dimension);
    var usedDimensionElements = element.parent().children('.' + dimension).find('.used');
    if (usedDimensionElements.length > 0) {

    } else {
        $('#dimension-controls #' + dimension).click();
    }
}


/*
 * get the format item
 */

function renderFormatItem(target, data) {
    var clone = $('#form-item-container').find('#' + data.format).clone();
    $(clone).find('.question').val(data.question);
    clone.addClass(data.dimension);
    target.prepend(clone);
    var parameters = data.parameters;
    var options = data.options;
    switch (data.format) {
        case SUS:
            console.log($(clone).find('#negative'));
            $(clone).find('.negative #' + parameters.negative).click();
            break;
        case OPEN_QUESTION_GUS:
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            }
            break;
        case DICHOTOMOUS_QUESTION:
            $(clone).find('.justification #' + parameters.justification).click();
            $(clone).find('.justification-for #' + parameters.justificationFor).click();
            break;
        case DICHOTOMOUS_QUESTION_GUS:
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            }
            $(clone).find('.justification #' + parameters.justification).click();
            $(clone).find('.justification-for #' + parameters.justificationFor).click();
            break;
        case GROUPING_QUESTION:
//            if (parameters[0] === true) {
            $(clone).find('.multiselect #' + parameters.multiselect).click();
//            }
//            if (parameters[1] === true) {
            $(clone).find('.optionalanswer #' + parameters.optionalanswer).click();
//            }

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
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            }
//            if (parameters[1] === true) {
            $(clone).find('.multiselect .switchButtonAddon').click();
//            }
//            if (parameters[2] === true) {
            $(clone).find('.justification #' + parameters.justification).click();
//            }
            $(clone).find('.justification-for #' + parameters.justificationFor).click();
            $(clone).find('.optionselect #' + parameters.optionSource).click();
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
            $(clone).find('.allocationSelect #' + parameters.allocation).click();
            $(clone).find('.maximum').val(parameters.maximum);
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
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            }
            $(clone).find('.justification #' + parameters.justification).click();
            $(clone).find('.justification-for #' + parameters.justificationFor).click();
            $(clone).find('.optionalanswer #' + parameters.optionalanswer).click();
            $(clone).find('.alternative #' + parameters.alternative).click();
            
            var currentPhase = getPhaseById(currentIdForModal);
            if (currentPhase && currentPhase.format === GUS_SINGLE_GESTURES) {
                $(clone).find('#alternativeTrigger').remove();
                $(clone).find('.alternativeFor').addClass('hidden');
                break;
            }

            $(clone).find('#' + parameters.alternativeFor).click();

            if (parameters.alternativeFor === 'alternativeGesture') {
                var gesture = getGestureById(parameters.alternativeForId);
                if (gesture) {
                    if (isGestureAssembled(gesture.id)) {
                        $(clone).find('.option-gesture').val(gesture.title);
                        $(clone).find('.gestureSelect .chosen').attr('id', gesture.id);
                    } else {
                        appendAlert(clone, ALERT_ASSEMBLED_GESTURE_REMOVED);
                    }
                }

            } else if (parameters.alternativeFor === 'alternativeTrigger') {

                var trigger = getTriggerById(parameters.alternativeForId);
                if (trigger) {
                    $(clone).find('.option-trigger').val(trigger.title);
                    $(clone).find('.triggerSelect .chosen').attr('id', trigger.id);
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_TRIGGER_REMOVED);
                }
            } else if (parameters.alternativeFor === 'alternativeFeedback') {
                var feedback = getFeedbackById(parameters.alternativeForId);
                if (feedback) {
                    $(clone).find('.option-feedback').val(feedback.title);
                    $(clone).find('.feedbackSelect .chosen').attr('id', feedback.id);
                } else {
                    appendAlert(clone, ALERT_ASSEMBLED_FEEDBACK_REMOVED);
                }
            }
            break;
        case GUS_SINGLE:
            if (parameters.used === 'used') {
                $(clone).find('.btn-use').click();
            }
            $(clone).find('.negative #' + parameters.negative).click();
            break;
    }

    var dimension = data.dimension;
    if (dimension !== DIMENSION_ANY) {
        $(clone).find('#item-factors').removeClass('hidden');
        var dimensionButton = $('.dimension-btn-group').find('#' + dimension);
        if (dimensionButton) {
            $(dimensionButton).addClass('active');
            $(dimensionButton).addClass('btn-info');
            $(dimensionButton).removeClass('inactive');
        }
        var dimensions = translation.dimensions;
        var mainDimensions = translation.mainDimensions;
        $(clone).find('#factor-primary').text(dimensions[dimension]);
        $(clone).find('#factor-main').text(mainDimensions[getMainDimensionForDimension(dimension)]);
    }
}

function getFormatData(element) {

    var type = $(element).attr('id');
    var dimension = getDimensionByElement($(element));
    var question = $(element).find('.question').val();
    var parameters = null;
    var options = null;
    switch (type) {
        case SUS:
            parameters = {negative: $(element).find('.negative .active').attr('id')};
            break;
        case OPEN_QUESTION_GUS:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used'};
            break;
        case DICHOTOMOUS_QUESTION:
            parameters = {justification: $(element).find('.justification .active').attr('id'),
                justificationFor: $(element).find('.justification-for .active').attr('id')};
            break;
        case DICHOTOMOUS_QUESTION_GUS:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used',
//                negative: $(element).find('.negative .active').attr('id'),
                justification: $(element).find('.justification .active').attr('id'),
                justificationFor: $(element).find('.justification-for .active').attr('id')};
//            parameters.push($(element).find('.btn-use').hasClass('used'));
//            parameters.push($(element).find('.negative #yes').hasClass('active'));
//            parameters.push($(element).find('.justification .active').attr('id') === 'yes' ? true : false);
//            parameters.push($(element).find('.justification-for .active').attr('id'));
            break;
        case GROUPING_QUESTION:
            parameters = {multiselect: $(element).find('.multiselect .active').attr('id'),
                optionalanswer: $(element).find('.optionalanswer .active').attr('id')};
//            parameters = new Array();
//            parameters.push($(element).find('.multiselect .active').attr('id') === 'yes' ? true : false);
//            parameters.push($(element).find('.optionalanswer .active').attr('id') === 'yes' ? true : false);

            options = new Array();
            var groupingOptions = $(element).find('.option-container').children();
            for (var j = 0; j < groupingOptions.length; j++) {
                options.push($(groupingOptions[j]).find('.option').val());
            }
            break;
        case GROUPING_QUESTION_GUS:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used',
                multiselect: $(element).find('.multiselect .active').attr('id'),
                optionSource: $(element).find('.optionselect .active').attr('id'),
                justification: $(element).find('.justification .active').attr('id'),
                justificationFor: $(element).find('.justification-for .active').attr('id')};
//            parameters = new Array();
//            parameters.push($(element).find('.btn-use').hasClass('used'));
//            parameters.push($(element).find('.multiselect .active').attr('id') === 'yes' ? true : false);
//            parameters.push($(element).find('.justification .active').attr('id') === 'yes' ? true : false);
//            parameters.push($(element).find('.justification-for .active').attr('id'));
//            parameters.push($(element).find('.optionselect .active').attr('id'));
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
            parameters = {allocation: $(element).find('.allocationSelect .chosen').attr('id'),
                maximum: $(element).find('.maximum').val()};

//            parameters = new Array();
//            parameters.push($(element).find('.allocationSelect .chosen').attr('id'));
//            parameters.push($(element).find('.maximum').val());
//            
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
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used',
                optionalanswer: $(element).find('.optionalanswer .active').attr('id'),
                justification: $(element).find('.justification .active').attr('id'),
                justificationFor: $(element).find('.justification-for .active').attr('id'),
                alternative: $(element).find('.alternative').find('.active').attr('id')};

//            parameters = new Array();
//            parameters.push($(element).find('.btn-use').hasClass('used'));
//            parameters.push($(element).find('.justification #yes').hasClass('active'));
//            parameters.push($(element).find('.justification-for .active').attr('id'));
//            parameters.push($(element).find('.optionalanswer #yes').hasClass('active'));
//            parameters.push($(element).find('.alternative').find('.active').attr('id'));

            var aGestures = assembledGestures();
            var aTriggers = getLocalItem(ASSEMBLED_TRIGGER);
            var currentPhase = getPhaseById(currentIdForModal);
            if (currentPhase && currentPhase.format === GUS_SINGLE_GESTURES) {
                parameters.alternativeFor = 'alternativeGesture';
//                parameters.push(ALTERNATIVE_FOR_GESTURE);
                break;
            }

            if (aGestures && $(element).find('.alternativeFor .active').attr('id') === 'alternativeGesture') {
                var gestureId = $(element).find('.alternativeGestureSelect .chosen').attr('id');
                if (gestureId !== 'unselected') {
                    parameters.alternativeFor = 'alternativeGesture';
                    parameters.alternativeForId = gestureId;
//                    parameters.push(ALTERNATIVE_FOR_GESTURE);
//                    parameters.push(getGestureById(gestureId));
                }
            } else if (aTriggers && $(element).find('.alternativeFor .active').attr('id') === 'alternativeTrigger') {
                var triggerId = $(element).find('.triggerSelect .chosen').attr('id');
                if (triggerId !== 'unselected') {
                    parameters.alternativeFor = 'alternativeTrigger';
                    parameters.alternativeForId = triggerId;
//                    parameters.push(ALTERNATIVE_FOR_TRIGGER);
//                    parameters.push(getTriggerById(triggerId));
                }
            } else if (aTriggers && $(element).find('.alternativeFor .active').attr('id') === 'alternativeFeedback') {
                var feedbackId = $(element).find('.feebackSelect .chosen').attr('id');
                if (feedbackId !== 'unselected') {
                    parameters.alternativeFor = 'alternativeFeedback';
                    parameters.alternativeForId = feedbackId;
//                    parameters.push(ALTERNATIVE_FOR_FEEDBACK);
//                    parameters.push(feedbackId);
                }
            }
            break;
        case GUS_SINGLE:
            parameters = {used: $(element).find('.btn-use').hasClass('used') ? 'used' : 'not-used',
                negative: $(element).find('.negative .active').attr('id')};

//            parameters = new Array();
//            parameters.push($(element).find('.btn-use').hasClass('used'));
//            parameters.push($(element).find('.negative #yes').hasClass('active'));
            options = gusOptions;
            break;
    }
    return new QuestionnaireItem(type, dimension, question, parameters, options);
}