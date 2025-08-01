/* ------------------------------------------------------------------
   teacher qr code attendance
   ------------------------------------------------------------------ */
(() => {
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('#btn-gen');
        if (!btn) return;

        const panelBtn = document.getElementById('aqr-btn-p');
        const panelGen = document.getElementById('aqr-generate-p');
        if (!panelBtn || !panelGen) return;

        panelBtn.style.display = 'none';
        panelGen.style.display = 'flex';
    });
})();

/* ------------------------------------------------------------------
   download qr code fuction
   ------------------------------------------------------------------ */
function downloadQrCode() {
    const qrCode = document.querySelector('.qr-card svg');
    if (!qrCode) return alert("QR code not found!");

    const svgData = new XMLSerializer().serializeToString(qrCode);
    const blob = new Blob([svgData], { type: "image/svg+xml;charset=utf-8" });
    const url = URL.createObjectURL(blob);

    const link = document.createElement("a");
    link.href = url;
    link.download = "attendance-qr.svg";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

/* ------------------------------------------------------------------
   qr form handler
   ------------------------------------------------------------------ */
function initQRFormHandler() {
    const form = document.getElementById('qr-form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: formData
        })
        .then(res => res.text())
        .then(html => {
            const contentArea = document.getElementById('main-content');
            if (contentArea) {
                contentArea.innerHTML = html;
                initQrCountdown();
                initQREndHandler();
            }
        })
        .catch(() => {
            alert('QR Generation Failed.');
        });
    });
}

function initQrCountdown() {
    const countdownEl = document.querySelector('.duration-fe');
    if (!countdownEl) return;

    const expiredAt = countdownEl.dataset.expired;
    const endTime = new Date(expiredAt).getTime();
    const now = new Date().getTime();
    let remaining = Math.floor((endTime - now) / 1000);

    function format(sec) {
        const h = String(Math.floor(sec / 3600)).padStart(2, '0');
        const m = String(Math.floor((sec % 3600) / 60)).padStart(2, '0');
        const s = String(sec % 60).padStart(2, '0');
        return `${h}:${m}:${s}`;
    }

    if (remaining <= 0) {
        setTimeout(() => location.reload(), 1000);
        return;
    }

    countdownEl.textContent = format(remaining);

    const timer = setInterval(() => {
        remaining--;
        if (remaining <= 0) {
            clearInterval(timer);
            location.reload();
        } else {
            countdownEl.textContent = format(remaining);
        }
    }, 1000);
}

function initQREndHandler() {
    const form = document.getElementById('qr-end');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: formData
        })
        .then(res => res.text())
        .then(html => {
            const contentArea = document.getElementById('main-content');
            if (contentArea) {
                contentArea.innerHTML = html;
                location.reload();
            }
        })
        .catch(() => {
            alert('QR Code failed to end!');
        });
    });
}




