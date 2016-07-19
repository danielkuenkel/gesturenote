<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="externals/font-awesome/css/font-awesome.min.css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        <script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
        <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
        <script src="https://cdn.webrtc-experiment.com/RecordRTC/Whammy.js"></script>
        <script src="js/gotoPage.js"></script>
        <script src="js/subPages.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index">Home</a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard">Dashboard</a></li>
                    <li class="active">Gesture Recorder</li>
                </ol>
            </div>
        </div>


        <div class="container">
            <div class="recorder text-center" style="border-radius: 5px; width: 500px">
                <video autoplay id="recorder-video" style="width: 100%; height: auto;"></video>
                <div class="gesture-recorder-controls">
                    <div class="hidden" id="record-controls">
                        <button class="btn btn-danger hidden" id="btn-record"><i class="glyphicon glyphicon-record" aria-hidden="true"></i> Aufzeichnung starten</button>
                        <button class="btn btn-danger hidden" id="btn-record-stop"><i class="glyphicon glyphicon-stop" aria-hidden="true"></i> Aufzeichnung beenden</button>
                    </div>
                    <div class="hidden" id="playback-controls" style="margin-top: -8px">
                        <div class="progress" id="seek-bar" style="height: 8px; border-top-left-radius: 0px; border-radius: 0px">
                            <div class="progress-bar progress-bar-primary" id="seek-bar-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 100%"></div>
                        </div>
                        <div class="progress" id="trim-bar" style="border-top-left-radius: 0px; border-top-right-radius: 0px; margin-top: -20px">
                            <div class="progress-bar progress-bar-danger" id="gesture-beginning" style="width: 100%" style="height: 100%"></div>
                            <div class="progress-bar progress-bar-success" id="gesture-execution" style="width: 0%" style="height: 100%">Geste</div>
                            <div class="progress-bar progress-bar-danger" id="gesture-ending" style="width: 0%" style="height: 100%"></div>
                        </div>
                        <div class="form-group">
                            <div class="btn-group">
                                <button class="btn btn-default" id="btn-play"><i class="glyphicon glyphicon-play" aria-hidden="true"></i></button>
                                <button class="btn btn-default" id="btn-pause"><i class="glyphicon glyphicon-pause" aria-hidden="true"></i></button>
                                <button class="btn btn-default" id="btn-stop"><i class="glyphicon glyphicon-stop" aria-hidden="true"></i></button>
                                <button class="btn btn-default" id="btn-delete-recording"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Löschen</button>
                                <button class="btn btn-success" id="btn-mark-start"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i> Start</button>
                                <button class="btn btn-danger disabled" id="btn-mark-end">Ende <i class="fa fa-chevron-circle-down" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-success disabled" id="btn-extract-gesture"><i class="glyphicon glyphicon-scissors"></i> Geste extrahieren</button
                        </div>
                    </div>
                    <div class="hidden" id="save-controls">
                        
                        <div class="imageContainer previewGesture mouseScrollable"></div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                        </div>

                        <button class="btn btn-block btn-success disabled" id="btn-save-gesture"><i class="glyphicon glyphicon-scissors"></i> Geste extrahieren</button
                    </div>
                </div>
            </div>

        </div>

        <script>
            $(document).ready(function () {
                initialize();
            });

            function initialize() {
                if (recordRTC) {
                    recordRTC.clearRecordedData();
                }

                var mediaConstraints = {video: true, audio: false};
                navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
            }

            var recordRTC, liveStream;
            function successCallback(stream) {
                liveStream = stream;
                $('#recorder-video').attr('src', URL.createObjectURL(stream));
                showRecord();
            }

            function errorCallback(error) {
                alert(error);
                // maybe another application is using the device
            }

            $('.recorder #btn-record').on('click', function (event) {
                event.preventDefault();
                $(this).addClass('hidden');
                $('#btn-record-stop').removeClass('hidden');

                var options = {
                    type: 'video',
                    mimeType: 'video/webm', // or video/mp4 or audio/ogg
                    video: {
                        width: 320,
                        height: 240
                    },
                    recorderType: RecordRTC.WhammyRecorder,
                    frameInterval: 60   // setTimeout interval, quality strength
                };
                recordRTC = RecordRTC(liveStream, options);
                recordRTC.startRecording();
            });

            var NETWORK_NO_SOURCE = 3;
            $('.recorder #btn-record-stop').on('click', function (event) {
                event.preventDefault();
                if (recordRTC) {
                    recordRTC.stopRecording(function (videoUrl) {
                        $('.recorder #recorder-video').attr('src', videoUrl);
                        showPlayback();
                    });
                }
            });

            function showRecord() {
                $('.recorder #btn-record').removeClass('hidden');
                $('.recorder #btn-record-stop').addClass('hidden');
                $('.recorder #recorder-video').removeAttr('loop');
                $('.recorder #record-controls').removeClass('hidden');
                $('.recorder #playback-controls').addClass('hidden');
                $('.recorder #trim-controls').addClass('hidden');
                resetTrimControls();
            }

            function showPlayback() {
                liveStream.getVideoTracks()[0].stop();
                $('.recorder #recorder-video').attr('loop', 'loop');
                $('.recorder #record-controls').addClass('hidden');
                $('.recorder #playback-controls').removeClass('hidden');

                $('.recorder #recorder-video').on('timeupdate', function () {
                    var percent = $(this)[0].currentTime / $(this)[0].duration * 100;
                    $('.recorder #seek-bar .progress-bar').css({width: percent + '%'});
                });

                $('.recorder #btn-play').on('click', function (event) {
                    event.preventDefault();
                    $('.recorder #recorder-video')[0].play();
                });
                $('.recorder #btn-pause').on('click', function (event) {
                    event.preventDefault();
                    $('.recorder #recorder-video')[0].pause();
                });
                $('.recorder #btn-stop').on('click', function (event) {
                    event.preventDefault();
                    $('.recorder #recorder-video')[0].pause();
                    $('.recorder #recorder-video')[0].currentTime = 0;
                });
                $('.recorder #btn-delete-recording').on('click', function (event) {
                    event.preventDefault();
                    initialize();
                });
                $('.recorder #btn-extract-gesture').on('click', function (event) {
                    event.preventDefault();
                    if (!$(this).hasClass('disabled')) {
                        $('.recorder #btn-pause').click();
                    } else {
                        wobble($('.recorder #btn-mark-start, .recorder #btn-mark-end'));
                    }
                });

                // seekbar operations
                $('.recorder #seek-bar, .recorder #trim-bar').on("mousedown", function (event) {
                    event.preventDefault();
                    var seekbar = $('.recorder #seek-bar');
                    $('.recorder #recorder-video')[0].pause();
                    $(window).on("mousemove", function (event) {
                        var positionX = Math.max(0, Math.min(Math.round(event.pageX - $(seekbar).offset().left), $(seekbar).width()));
                        var video = $('.recorder #recorder-video')[0];
                        var time = video.duration * (positionX / $(seekbar).width());
                        video.currentTime = Math.min(time, video.duration - 0.0001);
                    });
                    $(window).on('mouseup', function () {
                        $(window).unbind('mousemove');
                    });
                });
                $('.recorder #seek-bar, .recorder #trim-bar').on("click", function (event) {
                    event.preventDefault();
                    var positionX = Math.abs(event.pageX - $(this).offset().left);
                    var video = $('.recorder #recorder-video')[0];
                    var time = video.duration * (positionX / $(this).width());
                    video.currentTime = time;
                });

                // trim operations
                var gestureStartMarked, gestureEndMarked = false;
                $('.recorder #btn-mark-start').on('click', function (event) {
                    event.preventDefault();
                    var totalWidth = $('.recorder #seek-bar').width();
                    var beginningWidth = $('.recorder #seek-bar').find('.progress-bar').width();
                    if (!gestureStartMarked) {
                        gestureStartMarked = true;
                        $('.recorder #btn-mark-end').removeClass('disabled');
                    }
                    var currentBeginningWidth = $('.recorder #gesture-beginning').width();
                    var currentGestureWidth = $('.recorder #gesture-execution').width();
                    if (beginningWidth < currentBeginningWidth + currentGestureWidth) {
                        var currentEndingWidth = $('.recorder #gesture-ending').width();
                        $('.recorder #gesture-beginning').css({width: beginningWidth + 'px'});
                        $('.recorder #gesture-execution').css({width: (totalWidth - currentEndingWidth - beginningWidth) + 'px'});
                    }
                });

                $('.recorder #btn-mark-end').on('click', function (event) {
                    event.preventDefault();
                    var currentSeekWidth = $('.recorder #seek-bar').find('.progress-bar').width();
                    var beginningWidth = $('.recorder #gesture-beginning').width();
                    if (gestureStartMarked && currentSeekWidth > beginningWidth) {
                        $('.recorder #btn-extract-gesture').removeClass('disabled');

                        var totalWidth = $('.recorder #seek-bar').width();
                        var gestureWidth = currentSeekWidth - beginningWidth;
                        var endingWidth = totalWidth - (beginningWidth + gestureWidth);
                        $('.recorder #gesture-execution').css({width: gestureWidth + 'px'});
                        $('.recorder #gesture-ending').css({width: endingWidth + 'px'});
                    } else if (!gestureStartMarked) {
                        wobble($('.recorder #btn-mark-start'));
                    }
                });
            }

            function resetTrimControls() {
                $('.recorder #gesture-beginning').css({width: '100%'});
                $('.recorder #gesture-execution').css({width: '0%'});
                $('.recorder #gesture-ending').css({width: '0%'});
                $('.recorder #btn-mark-end, .recorder #btn-extract-gesture').addClass('disabled');
            }
        </script>

    </body>
</html>