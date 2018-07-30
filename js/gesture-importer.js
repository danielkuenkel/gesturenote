/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('click', '.chooseExchangeableFile', function (event) {
    if (event.handled !== true && !$(this).hasClass('disabled'))
    {
        event.handled = true;
        var container = $(this).closest('.root');
        $(container).find('.exchangeableFileUpload').val(null);
        $(container).find('.exchangeableFileUpload').click();
    }
});

$(document).on('change', '.exchangeableFileUpload', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var container = $(this).closest('.root');
        $(container).find('.btn-import-exchangeable-gestures').addClass('disabled');
        appendAlert(container, ALERT_NO_EXCHANGEABLE_FILE_SELECTED);

        var infoPanel = $(container).find('.file-info');
        $(infoPanel).find('.info-file-name .text').text('-');
        $(infoPanel).find('.info-file-size .text').text('-');
        $(infoPanel).find('.info-file-last-modified .text').text('-');
        $(infoPanel).find('.info-gestures-count .text').text('-');
        $(container).find('#input-exchangeable-set-title').val('');
        $(container).find('#item-view').empty();

        var files = event.target.files;
        if (!files) {
            console.log("no Files");
            return;
        }

        var file = files[0];
        if (!file) {
            console.log("Unable to access the file");
            return;
        }

        if (file.size === 0) {
            console.log("File is empty");
            return;
        }

        // nur ZIP-Dateien, mp4 videos, jpg Bilder oder Text-Dateien werden angenommen
        if (!file.type.match('application/x-zip-compressed') && !file.type.match('application/zip')) {
            console.log("unknown zip file type : " + file.type);
            console.log(file);
            return;
        }

        var title = file.name.replace('.zip', '');
        $(infoPanel).find('.info-file-name .text').text(title);
        $(infoPanel).find('.info-file-size .text').text(formatBytes(file.size));
        $(infoPanel).find('.info-file-last-modified .text').text(new Date(file.lastModifiedDate).toLocaleString());
        $(container).find('#input-exchangeable-set-title').val(title);
        clearAlerts(container);

        JSZip.loadAsync(file).then(function (zip) {
            console.log(zip);

            zip.forEach(function (relativePath, zipEntry) {
                if (zipEntry.name.indexOf('.txt') !== -1) {
                    zip.file(zipEntry.name).async("string").then(function (data) {

                        var json = JSON.parse(data);
                        var zippedGestures = json.data.trigger;

                        matchingPreviews = [];
                        matchedPreviewCount = 0;
                        matchedPreviewMax = 0;
                        temporalGestureSet = [];

                        for (var i = 0; i < zippedGestures.length; i++) {
                            if (zippedGestures[i].preview && zippedGestures[i].preview.length > 0) {
                                matchedPreviewMax += zippedGestures[i].preview.length;
                            }
                        }

                        for (var i = 0; i < zippedGestures.length; i++) {
                            var tempId = chance.natural();
                            var gestureImages = zippedGestures[i].preview;
                            var gestureImagesElement = document.createElement('div');
                            $(container).find('#temp-image-container').append(gestureImagesElement);
                            matchingPreviews.push({gestureId: tempId, images: []});

                            if (gestureImages && gestureImages.length > 0) {
                                for (var j = 0; j < gestureImages.length; j++) {
                                    var filepath = gestureImages[j];
                                    matchingPreviews[i].images.push({zipPath: filepath, objectURL: null, blob: null, index: j});
                                    loadZIPImageUrlAsync(zip, filepath, tempId);
                                }
                            }

                            var gesture = {
                                id: tempId,
                                title: zippedGestures[i].name,
                                description: zippedGestures[i].description || '',
                                context: zippedGestures[i].context || '',
                                association: zippedGestures[i].association || '',
                                images: [],
                                previewImage: zippedGestures[i].previewIndex || 0,
                                type: zippedGestures[i].style,
                                interactionType: zippedGestures[i].type,
                                joints: zippedGestures[i].joints || null,
                                sensorData: zippedGestures[i].sensorData || null
                            };

                            temporalGestureSet.push(gesture);
                        }

//                        console.log(temporalGestureSet);
                        if (matchedPreviewMax === 0) {
                            $(document).trigger('allZippedImagesLoaded');
                        }

                    });
                }
            });

        }, function (error) {
            console.log("Error reading " + file.name + " : " + error.message);
        });
    }
});

$(document).on('click', '.btn-delete-exchangeable-gesture', function (event) {
    event.preventDefault();
    var thumbnail = $(event.target).closest('.root');
    deleteExchangeableGesture($(thumbnail).attr('id'));

    TweenMax.to(thumbnail, .2, {scaleX: .3, scaleY: .3, opacity: 0, ease: Quad.easeIn, onComplete: function () {
            $(thumbnail).remove();
            renderTemporalGestureSet();
        }});
});

var matchingPreviews = null;
var matchedPreviewCount = 0;
var matchedPreviewMax = 0;
function loadZIPImageUrlAsync(zip, filepath, tempId) {
    zip.file(filepath).async("arraybuffer").then(function (data) {
        var imgBlob = new Blob([data]);
        var url = URL.createObjectURL(imgBlob);

        for (var i = 0; i < matchingPreviews.length; i++) {
            if (parseInt(matchingPreviews[i].gestureId) === parseInt(tempId)) {
                for (var j = 0; j < matchingPreviews[i].images.length; j++) {
                    if (matchingPreviews[i].images[j].zipPath === filepath) {
                        matchingPreviews[i].images[j].objectURL = url;
                        matchingPreviews[i].images[j].blob = imgBlob;
                        matchedPreviewCount++;
                    }
                }
            }
        }

        if (matchedPreviewCount >= matchedPreviewMax) {
            $(document).trigger('allZippedImagesLoaded');
        }
    }, function error(error) {
        // handle the error
        console.log("error with zip", error);
    });
}

var temporalGestureSet = null;
$(document).on('allZippedImagesLoaded', function (event) {
    event.preventDefault();

    for (var i = 0; i < matchingPreviews.length; i++) {
        var matchingPreview = matchingPreviews[i];
        var images = sortByKey(matchingPreview.images, 'index');

        for (var j = 0; j < temporalGestureSet.length; j++) {
            var temporalGesture = temporalGestureSet[j];
            if (parseInt(temporalGesture.id) === parseInt(matchingPreview.gestureId)) {
                var cleanedData = cleanUpLoadedZipImages(images);
                temporalGestureSet[j].images = cleanedData.images;
                temporalGestureSet[j].blobs = cleanedData.blobs;
            }
        }
    }

    function cleanUpLoadedZipImages(images) {
        var cleanedImages = {images: [], blobs: []};
        for (var i = 0; i < images.length; i++) {
            cleanedImages.images.push(images[i].objectURL);
            cleanedImages.blobs.push(images[i].blob);
        }
        return cleanedImages;
    }

    renderTemporalGestureSet();
});

function renderTemporalGestureSet() {
    var container = $('#gesture-importer');
    $(container).find('#item-view').empty();
    for (var i = 0; i < temporalGestureSet.length; i++) {
        var thumbnail = getSimpleGestureListThumbnail(temporalGestureSet[i], 'exchangeable-gesture-thumbnail');
        $(container).find('#item-view').append(thumbnail);
        TweenMax.from(thumbnail, .2, {delay: i * 0.05, opacity: 0, scaleX: .5, scaleY: .5, clearProps: 'all', onComplete: function () {
                initPopover();
            }});
    }
    $(container).find('.info-gestures-count .text').text(temporalGestureSet.length);
    $(container).find('.btn-import-exchangeable-gestures').removeClass('disabled');
}

function deleteExchangeableGesture(id) {
    for (var i = 0; i < temporalGestureSet.length; i++) {
        if (parseInt(temporalGestureSet[i].id) === parseInt(id)) {
            temporalGestureSet.splice(i, 1);
        }
    }
}

$(document).on('change', '.createExchangeableGestureSet', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var checkedId = $(this).find('.btn-option-checked').attr('id');
        if (checkedId === 'yes') {
            $(this).closest('.row').find('.exchangeableGestureSetTitle').removeClass('hidden');
        } else {
            $(this).closest('.row').find('.exchangeableGestureSetTitle').addClass('hidden');
        }
    }
});

$(document).on('click', '.btn-import-exchangeable-gestures', function (event) {
    event.preventDefault();
    if (event.handled !== true && !$(this).hasClass('disabled'))
    {
        event.handled = true;
        var button = $(this);
        lockButton(button, true, 'fa-cloud-upload');
        var container = $('#gesture-importer');
        lockButton($(container).find('.chooseExchangeableFile'));
        exchangeableDataAttachCount = 0;
        exchangeableGestureImportCount = 0;
        exchangeableGestureSet = [];

        var createGestureSet = $(container).find('.createExchangeableGestureSet .btn-option-checked').attr('id');
        if (createGestureSet === 'yes') {
            var title = $(container).find('#input-exchangeable-set-title').val().trim();
            if (title === '' || title.length < 8) {
                unlockButton(button, true, 'fa-cloud-upload');
                unlockButton($(container).find('.chooseExchangeableFile'));
                appendAlert(container, ALERT_GESTURE_SET_TITLE_TOO_SHORT);
                return false;
            } else {
                clearAlerts(container);
                importExchangeableGestures();
            }
        } else {
            importExchangeableGestures();
        }
    }

    function importExchangeableGestures() {
        console.log('import gestures to gesturenote');
        for (var i = 0; i < temporalGestureSet.length; i++) {
            uploadExchangeableImages(temporalGestureSet[i]);
        }
    }
});

function uploadExchangeableImages(gesture) {
    if (gesture.images && gesture.images.length > 0 && gesture.blobs && gesture.blobs.length > 0) {
        var uploadQueue = new UploadQueue();

        $(uploadQueue).bind(EVENT_ALL_FILES_UPLOADED, function () {
            gesture.images = uploadQueue.getUploadURLs();

            var gifUploadQueue = new UploadQueue();
            $(gifUploadQueue).bind(EVENT_ALL_FILES_UPLOADED, function () {
                gesture.gif = gifUploadQueue.getUploadURLs()[0];
                $(document).trigger('exchangableSaveDataAttached', [gesture]);
            });

            // create gif from gesture images and upload it
            var filename = hex_sha512(new Date().getTime() + "" + i) + ".gif";
            createGIF(gesture.images, filename, false, function (blob) {
                gifUploadQueue.upload([blob], filename);
            });
        });

        for (var i = 0; i < gesture.blobs.length; i++) {
            var filename = hex_sha512(new Date().getTime() + "" + i) + ".jpg";
            uploadQueue.upload([gesture.blobs[i]], filename);
        }
    } else {
        $(document).trigger('exchangableSaveDataAttached', [gesture]);
    }
}

var exchangeableDataAttachCount = 0;
$(document).on('exchangableSaveDataAttached', function (event, gesture) {
    event.preventDefault();
    exchangeableDataAttachCount++;
//    console.log('gesture', gesture);
    delete gesture.blobs;
    delete gesture.id;

    var container = $('#gesture-importer');
    saveRecordedGesture(gesture, function (result) {
        if (result.status === RESULT_SUCCESS) {
            gesture.id = result.gestureId;
            $(document).trigger('exchangeableGestureImported', [gesture]);
        } else {
            appendAlert(container, ALERT_GENERAL_ERROR);
        }
    });

    if (exchangeableDataAttachCount >= temporalGestureSet.length) {
        console.log('all exchangeable data uploaded, now save the gestures');
    }
});

var exchangeableGestureImportCount = 0;
var exchangeableGestureSet = [];
$(document).on('exchangeableGestureImported', function (event, gesture) {
    event.preventDefault();
    exchangeableGestureImportCount++;
    var container = $('#gesture-importer');
    var importButton = $(container).find('.btn-import-exchangeable-gestures');
    exchangeableGestureSet.push(gesture.id);

    if (exchangeableGestureImportCount >= temporalGestureSet.length) {
        var createGestureSet = $(container).find('.createExchangeableGestureSet .btn-option-checked').attr('id');
        console.log('all gestures imported successfully, create gesture set: ', createGestureSet);
        if (createGestureSet === 'yes') {
            var title = $(container).find('#input-exchangeable-set-title').val();
            saveGestureSet({title: title, gestures: exchangeableGestureSet}, function (result) {
                if (result.status === RESULT_SUCCESS) {
                    renderSuccess();
                } else {
                    renderError();
                }
            });
        } else {
            renderSuccess();
        }
    }

    function renderSuccess() {
        unlockButton(importButton, true, 'fa-cloud-upload');
        unlockButton($(container).find('.chooseExchangeableFile'));
        lockButton(importButton);

        $(container).find('.exchangeableFileUpload').val(null);
        $(container).find('#item-view').empty();
        $(container).find('#input-exchangeable-set-title').val('');
        appendAlert(container, ALERT_EXCHANGEABLE_GESTURES_IMPORTED_SUCCESS);
    }

    function renderError() {
        unlockButton(importButton, true, 'fa-cloud-upload');
        unlockButton($(container).find('.chooseExchangeableFile'));
        appendAlert(container, ALERT_GENERAL_ERROR);
    }
});