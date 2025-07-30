window.startCountdown = function(selector = '.duration-fe') {
    const countdownEl = document.querySelector(selector);
    if (!countdownEl) return;

    let remaining = parseInt(countdownEl.dataset.remaining);
    if (isNaN(remaining) || remaining <= 0) {
        countdownEl.textContent = 'Expired';
        handleQrExpired();
        return;
    }

    const update = () => {
        if (remaining <= 0) {
            countdownEl.textContent = 'Expired';
            handleQrExpired();
            return;
        }

        const hrs = Math.floor(remaining / 3600);
        const mins = Math.floor((remaining % 3600) / 60);
        const secs = remaining % 60;

        countdownEl.textContent = `${hrs}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        remaining--;
    };

    update();
    setInterval(update, 1000);
};

function handleQrExpired() {
    fetch('/qr/clear-session', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    }).then(() => {
        location.reload();
    });
}

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