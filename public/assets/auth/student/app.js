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
    student open camera
   ------------------------------------------------------------------ */
let html5QrCode;

document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('click', async function (e) {
        const openBtn = e.target.closest('#open-camera');
        const closeBtn = e.target.closest('#close-camera');
        const camPopup = document.getElementById('cam-popup');

        if (openBtn && camPopup) {
            camPopup.style.display = 'flex';

            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode("reader");
            }

            try {
                await html5QrCode.start(
                    { facingMode: "environment" },
                    { fps: 10, qrbox: 250 },
                    (decodedText, decodedResult) => {
                        console.log("Scanned:", decodedText);
                        html5QrCode.stop().then(() => {
                            camPopup.style.display = 'none';
                        });
                    },
                    (errorMessage) => {}
                );
            } catch (err) {
                console.error("Camera start error", err);
            }
        }

        if (closeBtn && camPopup) {
            camPopup.style.display = 'none';

            if (html5QrCode && html5QrCode.getState() === Html5QrcodeScannerState.SCANNING) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                }).catch(err => {
                    console.error("Stop failed", err);
                });
            }
        }
    });
});



