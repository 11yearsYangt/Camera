<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JavaScript Camera</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
    <section class="section">
      <div class="container">
        <div class="columns">
          <div class="column is-four-fifths">
            <h1 class="title">
              JavaScript Camera
            </h1>
            <video autoplay id="video"></video>
            <button class="button is-hidden" id="btnPlay">
              <span class="icon is-small">
                <i class="fas fa-play"></i>
              </span>
            </button>
            <button class="button" id="btnPause">
              <span class="icon is-small">
                <i class="fas fa-pause"></i>
              </span>
            </button>
            <button class="button is-success" id="btnScreenshot">
              <span class="icon is-small">
                <i class="fas fa-camera"></i>
              </span>
            </button>
            <button class="button" id="btnChangeCamera">
              <span class="icon">
                <i class="fas fa-sync-alt"></i>
              </span>
              <span>Switch camera</span>
            </button>
          </div>
          <div class="column">
            <h2 class="title">Screenshots</h2>
            <div id="screenshots"></div>
          </div>
        </div>
      </div>
    </section>
    <script async="camera" type="text/javascript">
	(function () {
    if (
        !"mediaDevices" in navigator ||
        !"getUserMedia" in navigator.mediaDevices
    ) {
        alert("Camera API is not available in your browser");
        return;
    }
    const video = document.querySelector("#video");
    const btnPlay = document.querySelector("#btnPlay");
    const btnPause = document.querySelector("#btnPause");
    const btnScreenshot = document.querySelector("#btnScreenshot");
    const btnChangeCamera = document.querySelector("#btnChangeCamera");
    const screenshotsContainer = document.querySelector("#screenshots");
    const canvas = document.querySelector("#canvas");
    const devicesSelect = document.querySelector("#devicesSelect");
    const constraints = {
        video: {
            width: {
                min: 1280,
                ideal: 1920,
                max: 2560,
            },
            height: {
                min: 720,
                ideal: 1080,
                max: 1440,
            },
        },
    };
    let useFrontCamera = true;
    let videoStream;
    btnPlay.addEventListener("click", function () {
        video.play();
        btnPlay.classList.add("is-hidden");
        btnPause.classList.remove("is-hidden");
    });
    btnPause.addEventListener("click", function () {
        video.pause();
        btnPause.classList.add("is-hidden");
        btnPlay.classList.remove("is-hidden");
    });
    btnScreenshot.addEventListener("click", function () {
        const img = document.createElement("img");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext("2d").drawImage(video, 0, 0);
        img.src = canvas.toDataURL("image/png");
        screenshotsContainer.prepend(img);
    });
    btnChangeCamera.addEventListener("click", function () {
        useFrontCamera = !useFrontCamera;

        initializeCamera();
    });
    function stopVideoStream() {
        if (videoStream) {
            videoStream.getTracks().forEach((track) => {
                track.stop();
            });
        }
    }
    async function initializeCamera() {
        stopVideoStream();
        constraints.video.facingMode = useFrontCamera ? "user" : "environment";

        try {
            videoStream = await navigator.mediaDevices.getUserMedia(constraints);
            video.srcObject = videoStream;
        } catch (err) {
            alert("Could not access the camera");
        }
    }

    initializeCamera();
})();
	</script>
</body>
</html>
