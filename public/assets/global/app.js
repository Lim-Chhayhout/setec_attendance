/* ------------------------------------------------------------------
   date time
   ------------------------------------------------------------------ */
function initDateTimeInfo() {
   const dtEl       = document.getElementById('show-datetime');
   const lastAttEl  = document.getElementById('last-attday');
   const todayAttEl = document.getElementById('today-attday');

   if (!dtEl && !lastAttEl && !todayAttEl) return;

   const fmt = new Intl.DateTimeFormat('en-US', {
      weekday: 'long',
      year:    'numeric',
      month:   'long',
      day:     'numeric',
      hour:    'numeric',
      minute:  '2-digit',
      second:  '2-digit',
      hour12:  true,
   });

   function updateNow() {
      const now = new Date();

      if (dtEl) dtEl.textContent = fmt.format(now);

      const iso = now.toISOString();
      const input = document.getElementById('generated-at');
      if (input) input.value = iso;
   }


   function setYesterday() {
      if (!lastAttEl) return;
      const y = new Date();
      y.setDate(y.getDate() - 1);             
      const dateOnly = new Intl.DateTimeFormat('en-US', {
         weekday: 'long',
         year:    'numeric',
         month:   'long',
         day:     'numeric',
      });
      lastAttEl.textContent = `– ${dateOnly.format(y)}`;
   }

   function settoday() {
      if (!todayAttEl) return;
      const y = new Date();
      const dateOnly = new Intl.DateTimeFormat('en-US', {
         weekday: 'long',
         year:    'numeric',
         month:   'long',
         day:     'numeric',
      });
      todayAttEl.textContent = `– ${dateOnly.format(y)}`;
   }

   updateNow();
   setYesterday();
   settoday();

   if (dtEl) setInterval(updateNow, 1000);
}

/* ------------------------------------------------------------------
   data‑profile line‑wrapping (80 chars)
   ------------------------------------------------------------------ */
(() => {
   const target = document.getElementById('data-profile');
   if (!target) return;                

   const text = (target.textContent || '').trim();
   if (!text) return;               

   const chunks = text.match(/.{1,80}/g);
   if (!chunks) return;

   target.textContent = chunks.join('\n');
})();

/* ------------------------------------------------------------------
   profile popup helpers
   ------------------------------------------------------------------ */
(() => {
   const popup = document.getElementById('profilePopup');
   if (!popup) return;                      

   window.openProfile  = () => { popup.style.display = 'flex'; };
   window.closeProfile = () => { popup.style.display = 'none';  };
})();

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
               startCountdown();
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
   });

   window.startQrCountdown = function(selector = '.duration-fe') {
   const timerEl = document.querySelector(selector);
   if (!timerEl) return;

   let totalSeconds = Number(timerEl.dataset.remaining);
   if (isNaN(totalSeconds) || totalSeconds <= 0) {
      window.location.reload();
      return;
   }

   const formatTime = (sec) => {
      const h = String(Math.floor(sec / 3600)).padStart(2, '0');
      const m = String(Math.floor((sec % 3600) / 60)).padStart(2, '0');
      const s = String(sec % 60).padStart(2, '0');
      return `${h}:${m}:${s}`;
   };

   const update = () => {
      if (totalSeconds <= 0) {
            window.location.reload();
            return;
      }
      timerEl.textContent = formatTime(totalSeconds);
      totalSeconds--;
      setTimeout(update, 1000);
   };

   update();
};
   
})();

/* ------------------------------------------------------------------
   action label with input
   ------------------------------------------------------------------ */
(() => {
    document.addEventListener('input', (e) => {
        const input = e.target.closest('.form-control');
        if (!input) return;

        const row = input.closest('.form-row');
        if (!row) return;

        if (input.value.trim() !== "") {
            row.classList.add('filled');
        } else {
            row.classList.remove('filled');
        }
    });
})();


