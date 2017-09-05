/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('click', '.chooseSceneImage', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        $(this).closest('.root').find('.imageUpload').click();
    }
});

$(document).on('change', '.imageUpload', function (event) {
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
        clearAlerts(element);

        var form = $(element).find('#upload-image-form');
        var formData = new FormData(form[0]);
        var uploadFiles = $(this)[0].files[0];
        if (uploadFiles) {
            formData.append('image', uploadFiles);
        }

        // check file
        if (uploadFiles) {
            if (uploadFiles.size > 8000000) {
                appendAlert(element, ALERT_IMAGE_TO_LARGE);
                $(button).next().attr('src', '');
                $(button).removeClass('disabled');
                $(button).closest('.root').find('.chooseSceneImage .btn-text').text('Anderes Bild auswählen');
                $(button).closest('.root').find('.chooseSceneImage .btn-icon').removeClass('glyphicon-picture').addClass('glyphicon-refresh');
                control.replaceWith(control = control.clone(true));
                $(button).trigger('saveData');
                return null;
            }
            $(element).find('.title').val(uploadFiles.name);
        }

        var imageUrl = $(element).find('.imageAreaContent').attr('src');
        if (imageUrl.trim() !== '') {
            deleteSceneImage({image: ["../" + imageUrl]});
        }

        readFile(this.files[0], function () {
            showCursor($('body'), CURSOR_PROGRESS);
            $(button).closest('.root').find('#image-loading-indicator').removeClass('hidden');
            $(imageArea).addClass('hidden');

            uploadSceneImage(formData, function (result) {
                showCursor($('body'), CURSOR_DEFAULT);
                $(button).removeClass('disabled');
                if (result.status === RESULT_SUCCESS) {
                    $(button).closest('.root').find('#image-loading-indicator').addClass('hidden');
                    $(imageAreaContent).attr("src", result.imageUrl);
                    $(element).find('.chooseSceneImage .btn-text').text('Anderes Bild auswählen');
                    $(element).find('.chooseSceneImage .btn-icon').removeClass('glyphicon-picture').addClass('glyphicon-refresh');
                    control.replaceWith(control = control.clone(true));
                    $(button).trigger('saveData');
                } else {

                }

                $(button).closest('.root').find('#image-loading-indicator').addClass('hidden');
                $(imageArea).removeClass('hidden');
            });
        });
    }
});

$(document).on('click', '.btn-delete-image', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        var button = $(this);
        button.addClass('disabled');
        var element = $(this).closest('.root');
        var imageUrl = ["../" + $(element).find('.imageAreaContent').attr('src')];
        showCursor($('body'), CURSOR_PROGRESS);
        clearAlerts(element);

        deleteSceneImage({image: imageUrl}, function (result) {
            showCursor($('body'), CURSOR_DEFAULT);
            $(button).removeClass('disabled');
            if (result.status === RESULT_SUCCESS) {
                $(button).next().attr('src', '');
                $(element).find('.imageArea').addClass('hidden');
                $(button).closest('.root').find('.chooseSceneImage .btn-text').text('Bild auswählen');
                $(button).closest('.root').find('.chooseSceneImage .btn-icon').removeClass('glyphicon-refresh').addClass('glyphicon-picture');
                $(element).find('.title').val('');
                $(button).trigger('saveData');
            } else {

            }
        });
    }
});

$(document).on('click', '.chooseFeedbackSound', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        $(this).closest('.root').find('.soundUpload').click();
    }
});

$(document).on('change', '.soundUpload', function (event) {
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


        var form = new FormData();
        var uploadFiles = $(this)[0].files[0];
        if (uploadFiles) {
            form.append('sound', uploadFiles);
        }

        // check file
        if (uploadFiles) {
            if (uploadFiles.size > 8000000) {
                appendAlert(element, ALERT_SOUND_TO_LARGE);
                $(button).next().attr('src', '');
                $(button).removeClass('disabled');
                $(button).closest('.root').find('.chooseFeedbackSound .btn-text').text('Andere Sounddatei auswählen');
                $(button).closest('.root').find('.chooseFeedbackSound .btn-icon').removeClass('glyphicon-picture').addClass('glyphicon-refresh');
                control.replaceWith(control = control.clone(true));
                $(button).trigger('saveData');
                return null;
            }
            $(element).find('.title').val(uploadFiles.name);
        }

        var soundUrl = $(element).find('.audio-holder').attr('src');
        if (soundUrl.trim() !== '') {
            deleteSound({sound: ["../" + soundUrl]}, function (result) {
            });
        }

//        console.log(form, uploadFiles);
        readFile(this.files[0], function () {
            showCursor($('body'), CURSOR_PROGRESS);
            $(element).find('#sound-loading-indicator').removeClass('hidden');
            $(audioPlayer).addClass('hidden');

            uploadSound(form, function (result) {
                showCursor($('body'), CURSOR_DEFAULT);
                $(button).removeClass('disabled');
                if (result.status === RESULT_SUCCESS) {
                    $(element).find('#sound-loading-indicator').addClass('hidden');
                    $(dataHolder).attr("src", result.soundUrl);
                    $(audioPlayer).removeClass('hidden');
                    $(element).find('.chooseFeedbackSound .btn-text').text('Andere Sounddatei auswählen');
                    $(element).find('.chooseFeedbackSound .btn-icon').removeClass('fa fa-volume-up');
                    $(element).find('.chooseFeedbackSound .btn-icon').addClass('glyphicon glyphicon-refresh');
                    control.replaceWith(control = control.clone(true));
                    $(element).trigger('saveData');
                } else {

                }

                $(element).find('#sound-loading-indicator').addClass('hidden');
                $(audioPlayer).removeClass('hidden');
            });
//
        });
    }
});

$(document).on('click', '.btn-delete-sound', function (event) {
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
                $(element).find('.title').val('');
                $(button).trigger('saveData');
            } else {

            }
        });
    }
});

$(document).on('click', '.choosePrototypeVideo', function (event) {
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

$(document).on('change', '.videoUpload', function (event) {
    event.preventDefault();
    var file = this.files[0];
    var videoAreaContent = $(this).parent().find('.videoAreaContent');
    var videoArea = $(this).parent().find('.videoArea');
    var control = $(this);
    var reader = new FileReader();
    reader.onloadstart = function (event) {
//        console.log('on load start');
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


$(document).on('click', '.checkVideoEmbedURL', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var url = $(this).closest('.root').find('.video-embed-url').val();
        var inputField = $(this).closest('.root').find('.video-embed-url');
        var videoContainer = $(this).closest('.root').find('#video-holder');
        var inputContainer = $(this).closest('.form-group');
        var button = $(this);

        clearAlerts($(this).closest('.root'));
        if (url && url.trim() !== "" && urlIsValid(url, TYPE_URL_VIDEO_EMBED)) {
            // check the video URL if they is valid. works for vimeo & youtube
            videoContainer.find('.videoContainer').html(url);
            videoContainer.removeClass('hidden');
            var video = videoContainer.find('.videoContainer iframe');
            $(video).addClass('embed-responsive-item');
            inputContainer.removeClass('has-error');
            inputContainer.addClass('has-success');
            button.removeClass('btn-danger');
            button.addClass('btn-success');
            inputField.blur();
        } else if (url && url.trim() !== "") {
            videoContainer.addClass('hidden');
            videoContainer.find('.videoContainer').html('');
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
        $(this).trigger('saveData');

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

$(document).on('click', '.checkPidocoEditURL', function (event) {
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

$(document).on('click', '.checkPidocoEmbedURL', function (event) {
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
//            https://pidoco.com/rabbit/api/prototypes/172450/pages/page648229105.xhtml?mode=plain&api_key=kzhIRzrEw4dmNbIvLfhvwL0c6tmUWL7Ek9PaiHNg
            regEx = /https:\/\/pidoco.com\/rabbit\/api\/prototypes\/[0-9]+\/pages\/page[0-9]+/;
            break;
        case TYPE_URL_VIDEO_EMBED:
//            console.log(url);
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

$(document).on("keyup", '.enter-key', function (event) {
    clearAlerts($(this).closest('.root'));
    if (event.keyCode === 13) {
        $(this).parent().find('.checkInput').click();
    } else {
        $(this).parent().find('.checkInput').removeClass('btn-danger');
        $(this).parent().find('.checkInput').removeClass('btn-success');
        $(this).closest('.form-group').removeClass('has-success');
        $(this).closest('.form-group').removeClass('has-error');
    }
});