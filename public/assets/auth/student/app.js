/* ------------------------------------------------------------------
    student switch page
   ------------------------------------------------------------------ */
(() => {
    const items = document.querySelectorAll('.menu-sidebar .item');
    const landerText = document.getElementById('lander-text');
    const contentArea = document.getElementById('main-content');

    if (!items.length || !landerText || !contentArea) return;

    const loadContent = (item) => {
        items.forEach(i => i.classList.remove('active-item-menu'));
        item.classList.add('active-item-menu');

        const input = item.querySelector('input[type="hidden"]');
        const title = input ? input.value : '';
        const url = item.getAttribute('data-url');

        if (title) landerText.textContent = title;
        if (url) {
            contentArea.innerHTML = '<p>Loading...</p>';
            fetch(url)
                .then(res => res.text())
                .then(html => {
                contentArea.innerHTML = html;
                initDateTimeInfo();
                initQrScan();
                localStorage.setItem('lastPage', JSON.stringify({ title, url }));
                })
                .catch(() => {
                contentArea.innerHTML = '<p>Error loading content.</p>';
                });
        }
    };

    items.forEach(item => {
        item.addEventListener('click', function () {
            loadContent(this);
        });
    });

    const lastPage = localStorage.getItem('lastPage');

    if (lastPage) {
        const { url, title } = JSON.parse(lastPage);
        const targetItem = [...items].find(i => i.getAttribute('data-url') === url);
        if (targetItem) {
            loadContent(targetItem);
        } else {
            loadContent(items[0]);
        }
    } else {
        loadContent(items[0]);
    }

    document.getElementById('logout-form').addEventListener('submit', function () {
        localStorage.removeItem('lastPage');
        sessionStorage.clear();
    });

})();

/* ------------------------------------------------------------------
    student scan page
   ------------------------------------------------------------------ */

let html5QrCode;

function initQrScan() {

    // document.addEventListener('click', async function (e) {
    //     const openBtn = e.target.closest('#open-camera');
    //     const closeBtn = e.target.closest('#close-camera');
    //     const camPopup = document.getElementById('cam-popup');

    //     if (openBtn && camPopup) {
    //         camPopup.style.display = 'flex';

    //         if (!html5QrCode) {
    //             html5QrCode = new Html5Qrcode("reader");
    //         }

    //         try {
    //             await html5QrCode.start(
    //                 { facingMode: "environment" },
    //                 { fps: 100, qrbox: 250 },
    //                 (decodedText, decodedResult) => {
    //                     console.log("Scanned:", decodedText);
    //                     html5QrCode.stop().then(() => {
    //                         camPopup.style.display = 'none';
    //                     });
    //                 },
    //                 (errorMessage) => {}
    //             );
    //         } catch (err) {
    //             console.error("Camera start error", err);
    //         }
    //     }

    //     if (closeBtn && camPopup) {
    //         camPopup.style.display = 'none';

    //         if (html5QrCode && html5QrCode.getState() === Html5QrcodeScannerState.SCANNING) {
    //             html5QrCode.stop().then(() => {
    //                 html5QrCode.clear();
    //             }).catch(err => {
    //                 console.error("Stop failed", err);
    //             });
    //         }
    //     }
    // });

    const fileInput = document.getElementById('qr-file');
    if (!fileInput) return;

    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];
        if (!file) return;

        const qrReader = new Html5Qrcode("reader");
        qrReader.scanFile(file, true)
            .then(token => {
                fetch('/student/scan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ token })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        loadPopup('/popup/success', data);
                    } else if (data.status === 'scanned') {
                        loadPopup('/popup/scanned');
                    } else if (data.status === 'expired') {
                        loadPopup('/popup/expired');
                    } else {
                        loadPopup('/popup/failed');
                    }
                })
                .catch(err => {
                    loadPopup('/popup/failed');
                });
            })
            .catch(err => {
                loadPopup('/popup/failed');
            });
    });
}

function loadPopup(url, data = null) {
    fetch(url)
        .then(res => res.text())
        .then(html => {
            const popupContainer = document.getElementById('popup-container');
            popupContainer.innerHTML = html;

            if (data) {
                popupContainer.querySelector('.teacher .value').textContent = data.teacher;
                popupContainer.querySelector('.subject .value').textContent = data.subject;
                popupContainer.querySelector('.room .value').textContent = data.room;
                popupContainer.querySelector('.time .value').textContent = data.study_time;
                popupContainer.querySelector('.status .value').textContent = data.status_text;
            }
        });
}



document.addEventListener('click', function (e) {
    if (e.target.matches('#scanned-popup .close')) {
        const popup = document.getElementById('scanned-popup');
        if (popup) popup.remove();
        window.location.reload();
    }
});




