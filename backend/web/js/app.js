//webkitURL is deprecated but nevertheless
URL = window.URL || window.webkitURL;

var interval;
var gumStream; //stream from getUserMedia()
var rec; //Recorder.js object
var input; //MediaStreamAudioSourceNode we'll be recording

// shim for AudioContext when it's not avb.
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext; //audio context to help us record

var recordButton = document.getElementById("recordButton");
var stopButton = document.getElementById("stopButton");
var pauseButton = document.getElementById("pauseButton");
var controls = document.getElementById("upload-container");
//add events to those 2 buttons
recordButton.addEventListener("click", startRecording);
stopButton.addEventListener("click", stopRecording);
pauseButton.addEventListener("click", pauseRecording);

function startRecording() {
    console.log("recordButton clicked");

    /*
     Simple constraints object, for more advanced audio features see
     https://addpipe.com/blog/audio-constraints-getusermedia/
     */

    var constraints = {audio: true, video: false};

    /*
     Disable the record button until we get a success or fail from getUserMedia() 
     */

    recordButton.disabled = true;
    stopButton.disabled = false;
    pauseButton.disabled = false;

    /*
     We're using the standard promise based getUserMedia() 
     https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
     */
    if(!navigator.mediaDevices)
    alert("Brwoser not supported");
    navigator.mediaDevices
            .getUserMedia(constraints)
            .then(function (stream) {
                console.log(
                        "getUserMedia() success, stream created, initializing Recorder.js ..."
                        );
                $(recordingsList).empty();
                $(controls).empty();
                $("#upload-errors").removeClass("alert alert-error");
                $("#upload-errors").empty();
                /*
                 create an audio context after getUserMedia is called
                 sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
                 the sampleRate defaults to the one set in your OS for your playback device
                 
                 */
                audioContext = new AudioContext();

                //update the format
                //   document.getElementById("formats").innerHTML =
                //     "Format: 1 channel pcm @ " + audioContext.sampleRate / 1000 + "kHz";

                /*  assign to gumStream for later use  */
                gumStream = stream;

                /* use the stream */
                input = audioContext.createMediaStreamSource(stream);

                /* 
                 Create the Recorder object and configure to record mono sound (1 channel)
                 Recording 2 channels  will double the file size
                 */
                rec = new Recorder(input, {numChannels: 2});

                //start the recording process
                rec.record();

                console.log("Recording started");
                countdown();
            })
            .catch(function (err) {
                //enable the record button if getUserMedia() fails
                recordButton.disabled = false;
                stopButton.disabled = true;
                pauseButton.disabled = true;
            });
}

function pauseRecording() {
    console.log("pauseButton clicked rec.recording=", rec.recording);
    if (rec.recording) {
        //pause
        rec.stop();
        clearInterval(interval);
        pauseButton.innerHTML = "Resume";
    } else {
        //resume
        rec.record();
        countdown();
        pauseButton.innerHTML = "Pause";
    }
}

function stopRecording() {
    console.log("stopButton clicked");

    //disable the stop button, enable the record too allow for new recordings
    stopButton.disabled = true;
    recordButton.disabled = false;
    pauseButton.disabled = true;

    //reset button just in case the recording is stopped while paused
    pauseButton.innerHTML = "Pause";

    //tell the recorder to stop the recording
    rec.stop();
    clearInterval(interval);
    $('.js-timeout').text("00:00");
    //stop microphone access
    gumStream.getAudioTracks()[0].stop();

    //create the wav blob and pass it on to createDownloadLink
    rec.exportWAV(createDownloadLink);
}

function createDownloadLink(blob) {
    var url = URL.createObjectURL(blob);
    var au = document.createElement("audio");
    var filename = new Date().toISOString() + ".wav";
    au.controls = true;
    au.src = url;
    $("#upload-btn").removeClass("hide");
    var upload = document.createElement("a");
    upload.href = "#";
    upload.innerHTML = "Upload Now";
    $(upload).addClass("btn btn-success");
    $(upload).on("click", function (event) {
        fd = new FormData();
        fd.append("file", blob, filename);
        $(upload).button("loading");
        $("#progress").removeClass("hide");
        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener(
                        "progress",
                        function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $("#progress div").css("width", percentComplete + "%");
                            }
                        },
                        false
                        );

                return xhr;
            },
            method: "post",
            dataType: "json",
            url: "admin-user-dashboard/upload",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                $("#upload-errors").removeClass("alert alert-error");
                $("#upload-errors").empty();
                $(upload).button("reset");
                $("#progress").addClass("hide");
                $("#progress div").css("width", 0);
                if (response.success == 1) {
                    $(recordingsList).empty();
                    $(controls).empty();
                    $.pjax.reload({container: "#student-uploads-view"});
                } else {
                    $("#upload-errors").addClass("alert alert-danger");
                    $("#upload-errors").append(response.error);
                }
            }
        });
        return false;
    });
    $(controls).empty();
    $(controls).append(upload);
    $(recordingsList).empty();
    recordingsList.append(au);
}

function countdown() {
    clearInterval(interval);
    interval = setInterval(function () {
        var timer = $('.js-timeout').html();
        timer = timer.split(':');
        var minutes = timer[0];
        var seconds = timer[1];
        seconds = parseInt(seconds) + 1;
        if (seconds > 59) {
            minutes = parseInt(minutes) + 1;
            seconds = 00;
        }
        if (seconds < 10)
            seconds = '0' + seconds;
        $('.js-timeout').html(minutes + ':' + seconds);
    }, 1000);
}