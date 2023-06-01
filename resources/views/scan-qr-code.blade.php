<!DOCTYPE html>
<html>
<head>
    <title>Scan QR Code</title>
    <!-- Include the necessary JavaScript libraries -->
    {{-- <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}
    <script type="text/javascript" src={{ asset('instascan.min.js') }}></script>
    <style>
        .d-flex{
            display: flex;
        }
    </style>
</head>
<body>
    <h1>Scan QR Code</h1>

    <div class="d-flex">
        <video id="preview" style="width: 50%;margin:auto"></video>
    </div>

    <script>
        // Initialize the camera and QR code scanning
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

        scanner.addListener('scan', function (content) {
            window.location.href = content
        });

        Instascan.Camera.getCameras()
            .then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
            })
            .catch(function (error) {
                console.error(error);
            });
    </script>
</body>
</html>

