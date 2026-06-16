@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4 text-center">🔐 Admin Face Login</h2>

        <div class="card">
            <div class="card-body text-center">

                <p class="text-muted mb-4">Look at the camera to login as admin!</p>

                <!-- Camera Feed -->
                <div class="position-relative d-inline-block mb-4">
                    <video id="video" width="480" height="360" autoplay muted
                           style="border-radius: 10px; border: 3px solid #343a40;"></video>
                    <canvas id="overlay" width="480" height="360"
                            style="position: absolute; top: 0; left: 0;"></canvas>
                </div>

                <br>

                <!-- Status -->
                <div id="status" class="alert alert-info mb-4">
                    ⏳ Loading face detection... Please wait!
                </div>

                <a href="/login" class="btn btn-outline-dark">← Back to Normal Login</a>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
    const video = document.getElementById('video');
    const overlay = document.getElementById('overlay');
    const status = document.getElementById('status');
    const ctx = overlay.getContext('2d');

    let isScanning = false;

    // Step 1: Load Models
    async function loadModels() {
        await faceapi.nets.tinyFaceDetector.loadFromUri('/models');
        await faceapi.nets.faceLandmark68Net.loadFromUri('/models');
        await faceapi.nets.faceRecognitionNet.loadFromUri('/models');

        status.innerHTML = '✅ Models loaded! Starting camera...';
        startCamera();
    }

    // Step 2: Start Camera
    async function startCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;

            video.addEventListener('play', () => {
                status.innerHTML = '😊 Camera ready! Scanning your face...';
                status.className = 'alert alert-success mb-4';
                scanFace();
            });
        } catch(err) {
            status.innerHTML = '❌ Camera access denied!';
            status.className = 'alert alert-danger mb-4';
        }
    }

    // Step 3: Scan and Match Face
    async function scanFace() {
        setInterval(async () => {
            if(isScanning) return;
            isScanning = true;

            const detection = await faceapi
                .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks()
                .withFaceDescriptor();

            ctx.clearRect(0, 0, overlay.width, overlay.height);

            if(detection) {
                faceapi.draw.drawDetections(overlay, [detection]);

                const descriptor = Array.from(detection.descriptor);

                // Send to Laravel for verification
                const response = await fetch('/face-login-verify', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ face_descriptor: descriptor })
                });

                const data = await response.json();

                if(data.success) {
                    status.innerHTML = '✅ Face matched! Logging you in...';
                    status.className = 'alert alert-success mb-4';
                    // Redirect to admin dashboard
                    setTimeout(() => {
                        window.location.href = '/admin/dashboard';
                    }, 1000);
                } else {
                    status.innerHTML = '😊 Scanning... Keep your face in frame!';
                    status.className = 'alert alert-info mb-4';
                }
            }

            isScanning = false;
        }, 2000);
    }

    loadModels();
</script>

@endsection