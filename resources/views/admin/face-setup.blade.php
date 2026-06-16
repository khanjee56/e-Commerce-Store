@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4">📷 Setup Face Recognition</h2>

        <div class="card">
            <div class="card-body text-center">

                <p class="text-muted mb-4">Position your face in the camera and click "Save My Face" to register your face for login.</p>

                <!-- Camera Feed -->
                <div class="position-relative d-inline-block mb-4">
                    <video id="video" width="480" height="360" autoplay muted
                           style="border-radius: 10px; border: 3px solid #343a40;"></video>
                    <canvas id="overlay" width="480" height="360"
                            style="position: absolute; top: 0; left: 0;"></canvas>
                </div>

                <br>

                <!-- Status Message -->
                <div id="status" class="alert alert-info mb-4">
                    Loading face detection models... Please wait!
                </div>

                <!-- Save Face Button -->
                <button id="saveBtn" class="btn btn-dark btn-lg" disabled onclick="saveFace()">
                    📸 Save My Face
                </button>

                <a href="/admin/dashboard" class="btn btn-outline-dark btn-lg ms-2">← Back</a>

            </div>
        </div>
    </div>
</div>

<!-- face-api.js -->
<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
    const video = document.getElementById('video');
    const overlay = document.getElementById('overlay');
    const status = document.getElementById('status');
    const saveBtn = document.getElementById('saveBtn');
    const ctx = overlay.getContext('2d');

    // Step 1: Load models
    async function loadModels() {
        status.innerHTML = '⏳ Loading face detection models...';
        status.className = 'alert alert-info mb-4';

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
                status.innerHTML = '😊 Face detected! Click "Save My Face" when ready.';
                status.className = 'alert alert-success mb-4';
                saveBtn.disabled = false;
                detectFace();
            });
        } catch(err) {
            status.innerHTML = '❌ Camera access denied! Please allow camera access.';
            status.className = 'alert alert-danger mb-4';
        }
    }

    // Step 3: Detect Face in Real Time
    async function detectFace() {
        setInterval(async () => {
            const detection = await faceapi
                .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks();

            ctx.clearRect(0, 0, overlay.width, overlay.height);

            if(detection) {
                faceapi.draw.drawDetections(overlay, [detection]);
                faceapi.draw.drawFaceLandmarks(overlay, [detection]);
            }
        }, 100);
    }

    // Step 4: Save Face
    async function saveFace() {
        status.innerHTML = '⏳ Capturing face data...';
        status.className = 'alert alert-info mb-4';
        saveBtn.disabled = true;

        const detection = await faceapi
            .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceDescriptor();

        if(!detection) {
            status.innerHTML = '❌ No face detected! Please position your face clearly.';
            status.className = 'alert alert-danger mb-4';
            saveBtn.disabled = false;
            return;
        }

        // Convert face descriptor to array
        const descriptor = Array.from(detection.descriptor);

        // Send to Laravel
        const response = await fetch('/admin/save-face', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ face_descriptor: descriptor })
        });

        const data = await response.json();

        if(data.success) {
            status.innerHTML = '✅ Face saved successfully! You can now login with your face!';
            status.className = 'alert alert-success mb-4';
        } else {
            status.innerHTML = '❌ Error saving face. Please try again!';
            status.className = 'alert alert-danger mb-4';
            saveBtn.disabled = false;
        }
    }

    // Start everything
    loadModels();
</script>

@endsection