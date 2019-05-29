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

        var uploadFiles = $(this)[0].files;
        if (uploadFiles && uploadFiles.length > 0)
        {
            showCursor($('body'), CURSOR_PROGRESS);
            $(button).closest('.root').find('#image-loading-indicator').removeClass('hidden');
            $(imageArea).addClass('hidden');

            var tempData = [];
            var uploadQueue = new UploadQueue();
            $(uploadQueue).bind(EVENT_ALL_FILES_UPLOADED, function () {
                showCursor($('body'), CURSOR_DEFAULT);
                $(button).removeClass('disabled');
                $(button).closest('.root').find('#image-loading-indicator').addClass('hidden');
                $(element).find('.chooseSceneImage .btn-text').text('Anderes Bild auswählen');
                $(element).find('.chooseSceneImage .btn-icon').removeClass('fa-picture').addClass('fa-refresh');
                control.replaceWith(control = control.clone(true));
                $(button).trigger('saveData');

                var uploadedFiles = uploadQueue.getUploadURLs();
                var unaddedElementData = [];
                for (var j = 0; j < tempData.length; j++) {
                    if (tempData[j].filename === uploadedFiles[0]) {
                        $(element).find('.title').val(tempData[0].title);
                        $(imageAreaContent).attr("src", uploadedFiles[0]);
                        $(button).closest('.root').find('#image-loading-indicator').addClass('hidden');
                        $(imageArea).removeClass('hidden');
                    } else {
                        unaddedElementData.push(tempData[j]);
                    }
                }

                if (unaddedElementData.length > 0) {
                    $(button).trigger('multipleImages', [unaddedElementData]);
                }
            });

            for (var i = 0; i < uploadFiles.length; i++) {
                var filename = new String(hex_sha512(new Date().getTime() + "" + i)).substring(0, 92) + ".jpg";
                if (uploadFiles[i].size <= 8000000) {
                    uploadQueue.upload([uploadFiles[i]], filename);

                    tempData.push({title: uploadFiles[i].name, filename: UPLOADS + filename});
                    if (i === 0) {
                        var imageUrl = "../" + $(element).find('.imageAreaContent').attr('src');
                        var splitUrl = imageUrl.split('/');
                        if (splitUrl.length > 1 && splitUrl[1].trim() !== '') {
                            deleteFiles({files: [imageUrl]}, null);
                        }
                    }
                }
            }
        }
    }
});

$(document).on('click', '.btn-delete-image', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        var button = $(this);
        button.addClass('disabled');
        var element = $(this).closest('.root');

        var imageUrl = "../" + $(element).find('.imageAreaContent').attr('src');
        var splitUrl = imageUrl.split('/');

        clearAlerts(element);
        if (splitUrl.length > 1 && splitUrl[1].trim() !== '') {
            showCursor($('body'), CURSOR_PROGRESS);

            deleteFiles({files: [imageUrl]}, function (result) {
                showCursor($('body'), CURSOR_DEFAULT);
                $(button).removeClass('disabled');
                if (result.status === RESULT_SUCCESS) {
                    $(button).next().attr('src', '');
                    $(element).find('.imageArea').addClass('hidden');
                    $(button).closest('.root').find('.chooseSceneImage .btn-text').text('Bild auswählen');
                    $(button).closest('.root').find('.chooseSceneImage .btn-icon').removeClass('fa-refresh').addClass('fa-picture');
                    $(element).find('.title').val('');
                    $(button).trigger('saveData');
                } else {

                }
            });
        }
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
        var button = $(element).find('.chooseFeedbackSound');
        button.addClass('disabled');

        var uploadFiles = $(this)[0].files;
        if (uploadFiles && uploadFiles.length > 0)
        {
            showCursor($('body'), CURSOR_PROGRESS);
            $(button).closest('.root').find('#sound-loading-indicator').removeClass('hidden');
            $(audioPlayer).addClass('hidden');

            var tempData = [];
            var uploadQueue = new UploadQueue();
            $(uploadQueue).bind(EVENT_ALL_FILES_UPLOADED, function () {
                showCursor($('body'), CURSOR_DEFAULT);
                $(button).removeClass('disabled');
                $(button).closest('.root').find('#sound-loading-indicator').addClass('hidden');
                $(element).find('.chooseFeedbackSound .btn-text').text('Andere Sounddatei auswählen');
                $(element).find('.chooseFeedbackSound .btn-icon').removeClass('fa-volume-up').addClass('fa-refresh');
                control.replaceWith(control = control.clone(true));
                $(button).trigger('saveData');

                var uploadedFiles = uploadQueue.getUploadURLs();
                var unaddedElementData = [];
                for (var j = 0; j < tempData.length; j++) {
                    if (tempData[j].filename === uploadedFiles[0]) {
                        $(element).find('.title').val(tempData[0].title);
                        $(dataHolder).attr("src", uploadedFiles[0]);
                        $(button).closest('.root').find('#sound-loading-indicator').addClass('hidden');
                        $(audioPlayer).removeClass('hidden');
                    } else {
                        unaddedElementData.push(tempData[j]);
                    }
                }

                if (unaddedElementData.length > 0) {
                    $(button).trigger('multipleSounds', [unaddedElementData]);
                }
            });

            for (var i = 0; i < uploadFiles.length; i++) {
                var filename = new String(hex_sha512(new Date().getTime() + "" + i)).substring(0, 92) + ".mp3";
                if (uploadFiles[i].size <= 8000000) {
                    uploadQueue.upload([uploadFiles[i]], filename);

                    tempData.push({title: uploadFiles[i].name, filename: UPLOADS + filename});
                    if (i === 0) {
                        var imageUrl = "../" + $(element).find('.dataHolder').attr('src');
                        var splitUrl = imageUrl.split('/');
                        if (splitUrl.length > 1 && splitUrl[1].trim() !== '') {
                            deleteFiles({files: [imageUrl]}, null);
                        }
                    }
                }
            }
        }
    }
});

$(document).on('click', '.btn-delete-sound', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        var button = $(this);
        button.addClass('disabled');
        var element = $(this).closest('.root');
        var soundUrl = "../" + $(element).find('.audio-holder').attr('src');
        var splitUrl = soundUrl.split('/');

        if (splitUrl.length > 1 && splitUrl[1].trim() !== '') {
            showCursor($('body'), CURSOR_PROGRESS);

            deleteFiles({files: [soundUrl]}, function (result) {
                showCursor($('body'), CURSOR_DEFAULT);
                $(button).removeClass('disabled');
                if (result.status === RESULT_SUCCESS) {
                    $(element).find('.audio-holder').attr('src', '');
                    $(element).find('.audioPlayer').addClass('hidden');
                    $(element).find('.chooseFeedbackSound .btn-text').text('Sounddatei auswählen');
                    $(element).find('.chooseFeedbackSound .btn-icon').removeClass('fa fa-refresh').addClass('fa fa-volume-up');
                    $(element).find('#stop').click();
                    $(element).find('.title').val('');
                    $(button).trigger('saveData');
                } else {

                }
            });
        }
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
    }
});

function readFile(file, onLoadCallback) {
    var reader = new FileReader();
    reader.onload = onLoadCallback;
    reader.readAsDataURL(file);
}

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
            if (urlIsValid(url, TYPE_URL_PIDOCO_EMBED)) {
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

            // https://pidoco.com/rabbit/invitation/VMxmlrSqbOr16lsRXb5TdkT3lJQsNSo3hU1y3ghn
            // https://pidoco.com/rabbit/api/prototypes/172450/pages/page648229105.xhtml?mode=plain&api_key=kzhIRzrEw4dmNbIvLfhvwL0c6tmUWL7Ek9PaiHNg
            // regEx = /https:\/\/(?:fulda\.)?pidoco.com\/rabbit\/api\/prototypes\/[0-9]+\/pages\/page[0-9]+/;
            regEx = /https:\/\/(?:fulda\.)?pidoco.com\/rabbit\/invitation\/[a-zA-Z0-9]{40}/;
            break;
        case TYPE_URL_VIDEO_EMBED:
            if (url.toLowerCase().indexOf("<iframe") >= 0
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