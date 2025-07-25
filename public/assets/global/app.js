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

   items.forEach(item => {
      item.addEventListener('click', function () {
         // 1. Set active item class
         items.forEach(i => i.classList.remove('active-item-menu'));
         this.classList.add('active-item-menu');

         // 2. Update lander text
         const input = this.querySelector('input[type="hidden"]');
         if (input) {
            landerText.textContent = input.value;
         }

         // 3. Load content via AJAX
         const url = this.getAttribute('data-url');
         if (url) {
            fetch(url)
               .then(res => res.text())
               .then(html => {
                  contentArea.innerHTML = html;
                  initDateTimeInfo();
               })
               .catch(err => {
                  contentArea.innerHTML = '<p>Error loading content.</p>';
               });
         }
      });
   });

   // Default selection (first item)
   const firstItem = items[0];
   firstItem.classList.add('active-item-menu');

   const defaultInput = firstItem.querySelector('input[type="hidden"]');
   if (defaultInput) {
      landerText.textContent = defaultInput.value;
   }

   const defaultUrl = firstItem.getAttribute('data-url');
   if (defaultUrl) {
      fetch(defaultUrl)
         .then(res => res.text())
         .then(html => {
            contentArea.innerHTML = html;
            initDateTimeInfo();
         })
         .catch(err => {
            contentArea.innerHTML = '<p>Error loading default content.</p>';
         });
   }
})();

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
      if (dtEl) dtEl.textContent = fmt.format(new Date());
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
