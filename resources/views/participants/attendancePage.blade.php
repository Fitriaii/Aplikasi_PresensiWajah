<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Presensi Wajah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @keyframes pulse-ring {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .pulse-animation {
            animation: pulse-ring 2s ease-in-out infinite;
        }

        .spinner {
            animation: spin 1s linear infinite;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">

    <canvas id="canvas" class="hidden"></canvas>

    <!-- Header -->
    <div class="sticky top-0 z-10 bg-white shadow-sm">
        <div class="flex items-center max-w-lg gap-4 px-4 py-4 mx-auto">
            <button onclick="window.history.back()" class="p-2 transition-colors rounded-lg hover:bg-slate-100">
                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </button>
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-slate-800">Presensi Wajah</h1>
                    <p class="text-xs text-slate-500">Verifikasi identitas Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-lg px-4 py-6 pb-8 mx-auto">
        <!-- Camera Container -->
        <div class="mb-6 overflow-hidden bg-white shadow-xl rounded-3xl">
            <div class="relative bg-slate-900 aspect-[3/4] sm:aspect-[4/5]">
                <!-- Video Element -->
                <video id="video" autoplay playsinline muted class="w-full h-full object-cover scale-x-[-1]"></video>

                <!-- Face Guide Overlay -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="relative">
                        <!-- Main oval guide with dynamic border color -->
                        <div id="faceGuide" class="w-48 h-64 transition-all duration-300 border-4 rounded-full sm:w-56 sm:h-72 border-slate-300" style="border-style: dashed"></div>

                        <!-- Corner guides -->
                        <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-white rounded-tl-2xl"></div>
                        <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-white rounded-tr-2xl"></div>
                        <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-white rounded-bl-2xl"></div>
                        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-white rounded-br-2xl"></div>
                    </div>
                </div>

                <!-- Loading Overlay (HIDDEN BY DEFAULT - akan muncul saat processing) -->
                <div id="loadingOverlay" class="absolute inset-0 items-center justify-center hidden bg-black/70 backdrop-blur-sm">
                    <div class="text-center">
                        <div class="relative w-20 h-20 mx-auto mb-4">
                            <div class="absolute inset-0 border-4 rounded-full border-white/20"></div>
                            <div class="absolute inset-0 border-4 border-white rounded-full border-t-transparent spinner"></div>
                        </div>
                        <p class="text-lg font-semibold text-white">Memproses...</p>
                        <p class="mt-1 text-sm text-white/70">Mengenali wajah Anda</p>
                    </div>
                </div>

                <!-- Camera Loading Overlay (hanya saat pertama load kamera) -->
                <div id="cameraLoadingOverlay" class="absolute inset-0 flex items-center justify-center bg-slate-900">
                    <div class="text-center text-white">
                        <div class="w-16 h-16 mx-auto mb-4 border-4 rounded-full border-white/30 border-t-white spinner"></div>
                        <p class="font-medium">Memuat kamera...</p>
                    </div>
                </div>
            </div>

            <!-- Status Bar -->
            <div id="statusBar" class="p-4 border-t-2 bg-slate-50 border-slate-300">
                <div class="flex items-center justify-center gap-3">
                    <svg id="statusIcon" class="w-6 h-6 text-slate-600 pulse-animation" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <p id="statusText" class="font-semibold text-center text-slate-600">Mencari wajah...</p>
                </div>
            </div>
        </div>

        <!-- Instructions Card -->
        <div class="p-6 bg-white shadow-lg rounded-2xl">
            <div class="flex items-start gap-3 mb-4">
                <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-blue-100 rounded-xl">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="mb-1 font-semibold text-slate-800">Panduan Presensi</h3>
                    <p class="text-sm text-slate-600">Ikuti langkah berikut untuk hasil terbaik</p>
                </div>
            </div>

            <ul class="space-y-3">
                <li class="flex items-start gap-3 text-sm text-slate-700">
                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-blue-600">1</span>
                    </div>
                    <span>Posisikan wajah di tengah oval panduan</span>
                </li>
                <li class="flex items-start gap-3 text-sm text-slate-700">
                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-blue-600">2</span>
                    </div>
                    <span>Pastikan pencahayaan cukup dan merata</span>
                </li>
                <li class="flex items-start gap-3 text-sm text-slate-700">
                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-blue-600">3</span>
                    </div>
                    <span>Lepas kacamata, topi, atau masker</span>
                </li>
                <li class="flex items-start gap-3 text-sm text-slate-700">
                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-blue-600">4</span>
                    </div>
                    <span>Sistem akan otomatis mencatat presensi Anda</span>
                </li>
            </ul>
        </div>

        <!-- Privacy Notice -->
        <div class="p-4 mt-4 border bg-slate-50 rounded-xl border-slate-200">
            <p class="text-xs text-center text-slate-600">
                <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Presensi hanya dapat dilakukan sekali per sesi
            </p>
        </div>
    </div>

    <script>
        // DOM Elements
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        const faceGuide = document.getElementById('faceGuide');
        const statusBar = document.getElementById('statusBar');
        const statusIcon = document.getElementById('statusIcon');
        const statusText = document.getElementById('statusText');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const cameraLoadingOverlay = document.getElementById('cameraLoadingOverlay');

        let cameraReady = false;
        let isCapturing = false;
        let isProcessing = false;
        let currentStream = null;
        let checkInterval = null;

        // Status Configuration
        const statusConfig = {
            searching: {
                text: 'Mencari wajah...',
                color: 'text-slate-600',
                bgColor: 'bg-slate-50',
                borderColor: 'border-slate-300',
                iconPath: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'
            },
            too_far: {
                text: 'Wajah terlalu jauh',
                color: 'text-orange-600',
                bgColor: 'bg-orange-50',
                borderColor: 'border-orange-400',
                iconPath: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
            },
            too_close: {
                text: 'Wajah terlalu dekat',
                color: 'text-orange-600',
                bgColor: 'bg-orange-50',
                borderColor: 'border-orange-400',
                iconPath: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
            },
            too_dark: {
                text: 'Pencahayaan terlalu gelap',
                color: 'text-indigo-600',
                bgColor: 'bg-indigo-50',
                borderColor: 'border-indigo-400',
                iconPath: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
            },
            too_bright: {
                text: 'Terlalu terang',
                color: 'text-yellow-600',
                bgColor: 'bg-yellow-50',
                borderColor: 'border-yellow-400',
                iconPath: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
            },
            good: {
                text: 'Posisi ideal',
                color: 'text-green-600',
                bgColor: 'bg-green-50',
                borderColor: 'border-green-400',
                iconPath: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
            }
        };

        // Initialize Camera
        async function initCamera() {
            try {
                console.log('Requesting camera access...');

                const stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        width: { ideal: 1280 },
                        height: { ideal: 720 },
                        facingMode: 'user'
                    }
                });

                console.log('Camera access granted');
                currentStream = stream;
                video.srcObject = stream;

                video.onloadedmetadata = () => {
                    console.log('Video metadata loaded');
                    cameraReady = true;
                    cameraLoadingOverlay.classList.add('hidden');
                    video.play().then(() => {
                        console.log('Video playing');
                        setTimeout(() => {
                            startFaceCheck();
                        }, 1000);
                    }).catch(err => {
                        console.error('Video play error:', err);
                        showError('Gagal memutar video kamera');
                    });
                };
            } catch (err) {
                console.error('Camera error:', err);
                cameraLoadingOverlay.innerHTML = `
                    <div class="p-4 text-center text-white">
                        <svg class="w-16 h-16 mx-auto mb-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="mb-2 font-medium">Akses Kamera Ditolak</p>
                        <p class="mb-4 text-sm text-white/70">${err.message || 'Pastikan izin kamera telah diberikan'}</p>
                        <button onclick="location.reload()" class="px-4 py-2 transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                            Coba Lagi
                        </button>
                    </div>
                `;
            }
        }

        // Capture Frame
        function captureFrame() {
            if (!video.videoWidth || !video.videoHeight) return null;

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            ctx.save();
            ctx.scale(-1, 1);
            ctx.drawImage(video, -canvas.width, 0, canvas.width, canvas.height);
            ctx.restore();

            return canvas.toDataURL('image/jpeg', 0.85);
        }

        // Update Status UI
        function updateStatus(status, customMessage = null) {
            const config = statusConfig[status] || statusConfig.searching;

            statusBar.className = `p-4 border-t-2 ${config.bgColor} ${config.borderColor}`;
            statusText.className = `font-semibold ${config.color} text-center`;
            statusText.textContent = customMessage || config.text;

            faceGuide.className = `w-48 h-64 sm:w-56 sm:h-72 border-4 rounded-full transition-all duration-300 ${config.borderColor}`;

            statusIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${config.iconPath}"/>`;
            statusIcon.className = `w-6 h-6 ${config.color} pulse-animation`;
        }

        // Check Face via API
        async function checkFace() {
            if (!cameraReady || isProcessing || isCapturing) return;

            const image = captureFrame();
            if (!image) return;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                const response = await fetch('/peserta/face-check', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ image })
                });

                const data = await response.json();
                updateStatus(data.status, data.message);

                if (data.status === 'good' && data.can_register && !isCapturing) {
                    stopFaceCheck();
                    await recognizeAndAttend(image);
                }

            } catch (err) {
                console.error("Face check error:", err);
                updateStatus("searching", "Mencari wajah...");
            }
        }

        // Recognize and Attend
        async function recognizeAndAttend(image) {
            try {
                // Tampilkan loading overlay saat processing
                isProcessing = true;
                loadingOverlay.classList.remove('hidden');

                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                const response = await fetch('/presensi/face', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ image })
                });

                // Parse response
                const data = await response.json();

                // Debug logging
                console.log('=== FACE ATTENDANCE DEBUG ===');
                console.log('Response Status:', response.status);
                console.log('Response OK:', response.ok);
                console.log('Response Data:', data);
                console.log('============================');

                // Sembunyikan loading overlay setelah dapat response
                loadingOverlay.classList.add('hidden');
                isProcessing = false;

                // ✅ Prioritas 1: Cek jika ada success flag (berbagai format)
                const isSuccess = data.success === true ||
                                 data.status === 'success' ||
                                 data.message?.toLowerCase().includes('berhasil') ||
                                 (response.ok && data.data);

                if (isSuccess) {
                    const successMessage = data.message || data.data?.message || 'Presensi berhasil dicatat!';
                    updateStatus('success', successMessage);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: successMessage,
                        confirmButtonColor: '#2563eb',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then(() => {
                        window.location.href = '/';
                    });

                    return true;
                }

                // ⚠️ Prioritas 2: Info status
                if (data.status === 'info' || data.status === 'warning') {
                    const infoMessage = data.message || 'Informasi dari sistem';
                    updateStatus('info', infoMessage);

                    Swal.fire({
                        icon: 'info',
                        title: 'Informasi',
                        text: infoMessage,
                        confirmButtonColor: '#2563eb',
                    }).then(() => {
                        startFaceCheck();
                    });

                    return false;
                }

                // ❌ Prioritas 3: Error status
                const errorMessage = data.message ||
                                   data.error ||
                                   data.errors?.[0] ||
                                   'Wajah tidak dikenali';

                updateStatus('error', errorMessage);

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: errorMessage,
                    confirmButtonColor: '#ef4444',
                }).then(() => {
                    startFaceCheck();
                });

                return false;

            } catch (err) {
                console.error('=== CATCH ERROR ===');
                console.error('Error:', err);
                console.error('Error Message:', err.message);
                console.error('==================');

                // Sembunyikan loading overlay jika terjadi error
                loadingOverlay.classList.add('hidden');
                isProcessing = false;

                updateStatus('error', 'Terjadi kesalahan sistem');

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `Terjadi kesalahan: ${err.message}`,
                    confirmButtonColor: '#ef4444',
                }).then(() => {
                    startFaceCheck();
                });

                return false;
            }
        }

        // Start Face Check Loop
        function startFaceCheck() {
            if (checkInterval) clearInterval(checkInterval);
            checkInterval = setInterval(checkFace, 1200);
        }

        // Stop Face Check Loop
        function stopFaceCheck() {
            if (checkInterval) {
                clearInterval(checkInterval);
                checkInterval = null;
            }
        }

        // Show Error Alert
        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonColor: '#dc2626'
            });
        }

        // Cleanup
        function cleanup() {
            stopFaceCheck();
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
                currentStream = null;
            }
        }

        // Initialize on page load
        window.addEventListener('DOMContentLoaded', initCamera);
        window.addEventListener('beforeunload', cleanup);
    </script>
</body>
</html>
