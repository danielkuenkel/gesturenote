/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var STATUS_UNINITIALIZED = 'uninitialized';
var STATUS_INITIALIZED = 'initialized';
var STATUS_STOPPED = 1;
var STATUS_STARTED = 2;
var EVENT_FILE_SAVED = 'fileSaved';

UploadQueue.prototype.status = STATUS_UNINITIALIZED;

var uploader = null;
function UploadQueue() {
    this.status = STATUS_INITIALIZED;
    var uploadQueue = this;

    uploader = new Resumable({
        target: 'includes/upload-rtc.php',
        chunkSize: 2 * 1024 * 1024
    });

    uploader.on('fileAdded', function (file, event) {
        if (!uploader.isUploading()) {
            console.log('start/resume uploading', new Date());
            uploader.upload();
        }
    });
    uploader.on('fileSuccess', function (file, message) {
        console.log('file success: ', file, message, new Date());
        $(uploadQueue).trigger(EVENT_FILE_SAVED, [getTempUploads(file.fileName)]);
    });
    uploader.on('fileError', function (file, message) {
        console.log('file error: ', file, message);
    });
    uploader.on('error', function (file, message) {
        console.log('error: ', file, message);
    });
}

var tempUploads = new Array();
UploadQueue.prototype.upload = function (blob, phaseStepId) {
    if (this.getStatus() !== STATUS_UNINITIALIZED) {
        var filename = hex_sha512(new Date().toLocaleString()) + '.webm';
        var file = new File(blob, filename);
        tempUploads.push({phaseStepId: phaseStepId, filename: filename, uploaded: false});
        console.log(tempUploads, new Date());
        uploader.addFile(file);
    }
};

UploadQueue.prototype.getStatus = function () {
    return this.status;
};

function getTempUploads(filename) {
    console.log('set uploaded to true', new Date());
    for (var i = 0; i < tempUploads.length; i++) {
        if (filename === tempUploads[i].filename) {
            tempUploads[i].uploaded = true;
            return tempUploads[i];
        }
    }
    return null;
}

UploadQueue.prototype.allVideosUploaded = function () {
    console.log('check allVideosUploaded');
    for (var i = 0; i < tempUploads.length; i++) {
        if (tempUploads[i].uploaded === false) {
            console.log(tempUploads[i]);
            return false;
        }
    }
    return true;
};