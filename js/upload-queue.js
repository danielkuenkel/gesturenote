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
var EVENT_UPLOAD_PROGRESS_ALL = 'uploadProgressAll';

UploadQueue.prototype.status = STATUS_UNINITIALIZED;
UploadQueue.prototype.hasPendingUploads = false;

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

    this.uploader.on('progress', function () {
        var progress = uploadObject.progress() * 100;
        console.log('upload progress', progress);
        $(uploadQueue).trigger(EVENT_UPLOAD_PROGRESS_ALL, [progress]);
    });

    this.uploader.on('fileSuccess', function (file, message) {
        console.log('file success: ', file, message);
        var returnFile = uploadQueue.setUploadStatus(file.fileName);
        $(uploadQueue).trigger(EVENT_FILE_SAVED, [returnFile]);

        if (uploadQueue.allFilesUploaded() && uploadQueue.hasPendingUploads === false) {
            console.log('all files uploaded');
            uploadQueue.hasPendingUploads = false;
            setTimeout(function () {
                $(uploadQueue).trigger(EVENT_ALL_FILES_UPLOADED);
            }, 1000);
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
UploadQueue.prototype.upload = function (blob, filename, phaseStepId, type) {
    console.log('upload file:', filename, this.getStatus(), phaseStepId, type);
    hasPendingUploads = true;
    if (this.getStatus() !== STATUS_UNINITIALIZED) {
        var file = new File(blob, filename);
        if (phaseStepId && type) {
            // uploading execution recordings
            this.files.push({filename: filename, uploaded: false, phaseStepId: phaseStepId, type: type});
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

UploadQueue.prototype.uploadPending = function () {
    return hasPendingUploads || false;
};

UploadQueue.prototype.uploadIsPending = function () {
    hasPendingUploads = true;
};