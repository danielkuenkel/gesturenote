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
            console.log('start/resume uploading');
            uploader.upload();
        }
    });
    uploader.on('fileSuccess', function (file, message) {
        console.log('file success: ', file, message);
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
        uploader.addFile(file);
//
//        filename = hex_sha512(new Date().toLocaleString()) + '.webm';
//        file = new File(blob, filename);
//        uploader.addFile(file);

//        console.log(uploader.files);
    }
};

UploadQueue.prototype.getStatus = function () {
    return this.status;
};

function getTempUploads(filename) {
    for (var i = 0; i < tempUploads.length; i++) {
        if (filename === tempUploads[i].filename) {
            tempUploads[i].uploaded = true;
            return tempUploads[i];
        }
    }
    return null;
}