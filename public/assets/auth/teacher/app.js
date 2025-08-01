/* ------------------------------------------------------------------
   switch page
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
               initQRFormHandler();
               initQrCountdown();
               initQREndHandler()
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
   teacher download qr code fuction
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
   teacher qr form handler
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

/* ------------------------------------------------------------------
   teacher qr count down
   ------------------------------------------------------------------ */
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




