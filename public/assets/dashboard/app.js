/* ------------------------------------------------------------------
   duration qr count down 
   ------------------------------------------------------------------ */
(() => {
    window.startCountdown = (selector = '.duration-fe') => {
        const timerEl = document.querySelector(selector);
        if (!timerEl) return;

        const minutes = Number(timerEl.dataset.duration);
        if (isNaN(minutes) || minutes <= 0) return;

        let totalSeconds = minutes * 60;

        const formatTime = (sec) => {
            const h = String(Math.floor(sec / 3600)).padStart(2, '0');
            const m = String(Math.floor((sec % 3600) / 60)).padStart(2, '0');
            const s = String(sec % 60).padStart(2, '0');
            return `${h}:${m}:${s}`;
        };

        const update = () => {
            if (totalSeconds < 0) return;
            timerEl.textContent = formatTime(totalSeconds);
            totalSeconds--;
            if (totalSeconds >= 0) {
                setTimeout(update, 1000);
            }
        };

        update();
    };
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
   submit generate qr function
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
                initQRFormHandler();
                startCountdown();
            }
        })
        .catch(() => {
            alert('QR Generation Failed.');
        });
    });
}

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