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
var EVENT_ALL_FILES_UPLOADED = 'allFilesUploaded';

UploadQueue.prototype.status = STATUS_UNINITIALIZED;

function UploadQueue() {
    this.status = STATUS_INITIALIZED;
    this.files = new Array();
    var uploadQueue = this;

    var uploadObject = this.uploader = new Resumable({
        target: 'includes/upload-rtc.php',
        chunkSize: 2 * 1024 * 1024
    });

    this.uploader.on('fileAdded', function (file, event) {
        if (!uploadObject.isUploading()) {
            console.log('start/resume uploading …', file.filename);
            uploadObject.upload();
        }
    });
    this.uploader.on('fileSuccess', function (file, message) {
        console.log('file success: ', file, message);
        var returnFile = uploadQueue.setUploadStatus(file.fileName);
        $(uploadQueue).trigger(EVENT_FILE_SAVED, [returnFile]);

        if (uploadQueue.allFilesUploaded()) {
            console.log('all files uploaded');
            $(uploadQueue).trigger(EVENT_ALL_FILES_UPLOADED);
        }
    });
    this.uploader.on('fileError', function (file, message) {
        console.log('file error: ', file, message);
    });
    this.uploader.on('error', function (file, message) {
        console.log('error: ', file, message);
    });
}

//var tempUploads = new Array();
UploadQueue.prototype.upload = function (blob, filename, phaseStepId, type, endRecordingKey, timestamp) {
    console.log('upload file:', filename, this.getStatus(), phaseStepId, type, timestamp);
    if (this.getStatus() !== STATUS_UNINITIALIZED) {
        var file = new File(blob, filename);
        if (phaseStepId && type && endRecordingKey && timestamp) {
            // uploading execution recordings
            this.files.push({filename: filename, uploaded: false, phaseStepId: phaseStepId, type: type, endRecordingKey: endRecordingKey, timestamp: timestamp});
        } else {
            // uploading other files than execution recording, e.g. images
            this.files.push({filename: filename, uploaded: false});
        }
        this.uploader.addFile(file);
    }
};

UploadQueue.prototype.getStatus = function () {
    return this.status;
};


UploadQueue.prototype.getUploadURLs = function () {
    var urls = new Array();
    for (var i = 0; i < this.files.length; i++) {
        urls.push(UPLOADS + this.files[i].filename);
    }
    return urls;
};

UploadQueue.prototype.setUploadStatus = function (filename) {
//    console.log('set uploaded to true', this.files, filename);
    for (var i = 0; i < this.files.length; i++) {
        if (filename === this.files[i].filename) {
            this.files[i].uploaded = true;
            return this.files[i];
        }
    }
    return null;
};

UploadQueue.prototype.allFilesUploaded = function () {
    if (this.files && this.files.length > 0) {
        for (var i = 0; i < this.files.length; i++) {
            if (this.files[i].uploaded === false) {
                return false;
            }
        }
    }
    return true;
};