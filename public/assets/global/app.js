/* ------------------------------------------------------------------
   global action label with input
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

/* ------------------------------------------------------------------
   global login form
   ------------------------------------------------------------------ */
(() => {
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('login-form');
        if (!form) return;

        const errorIcon = document.getElementById('error-icon');
        const errorText = document.getElementById('error-text');
        const errorRowEP = document.getElementById('rowEP');
        const errorRowPW = document.getElementById('rowPW');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(form);

            fetch(window.routes.loginPost, {
                method: "POST",
                headers: { "Accept": "application/json" },
                body: formData
            })
            .then(async res => {
                const data = await res.json();

                if (data.error) {
                    errorIcon.style.display = 'flex';
                    errorText.innerText = data.message || 'Login failed.';

                    if (errorRowEP) {
                        errorRowEP.style.border = data.epRow ? '1px solid #ff0000' : '';
                        const epSpan = errorRowEP.querySelector('span');
                        if (epSpan) epSpan.style.color = data.epRow ? '#ff0000' : '';
                    }

                    if (errorRowPW) {
                        errorRowPW.style.border = data.pRow ? '1px solid #ff0000' : '';
                        const pwSpan = errorRowPW.querySelector('span');
                        if (pwSpan) pwSpan.style.color = data.pRow ? '#ff0000' : '';
                    }

                    return;
                }

                if (data.redirect) {
                    window.location.replace(data.redirect);
                }
            })
            .catch(() => {
                if (errorIcon) errorIcon.style.display = 'flex';
                if (errorText) errorText.innerText = "Something went wrong.";
            });
        });
    });
})();

/* ------------------------------------------------------------------
   global show/close password input
   ------------------------------------------------------------------ */
(() => {
    document.addEventListener("DOMContentLoaded", () => {
        const passwordInput = document.querySelector("#rowPW input[name='password']");
        const showBtn = document.getElementById("show-password");
        const closeBtn = document.getElementById("close-password");

        if (!passwordInput || !showBtn || !closeBtn) return;

        const toggleVisibility = (visible) => {
            passwordInput.type = visible ? "text" : "password";
            showBtn.style.display = visible ? "none" : "flex";
            closeBtn.style.display = visible ? "flex" : "none";
        };

        passwordInput.addEventListener("input", () => {
            const hasValue = passwordInput.value.trim() !== "";
            showBtn.style.display = hasValue ? "flex" : "none";
            if (!hasValue) {
                closeBtn.style.display = "none";
                passwordInput.type = "password";
            }
        });

        showBtn.addEventListener("click", () => toggleVisibility(true));
        closeBtn.addEventListener("click", () => toggleVisibility(false));
    });
})();

/* ------------------------------------------------------------------
   global date time
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
   global data‑profile line‑wrapping (80 chars)
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
   global profile popup helpers
   ------------------------------------------------------------------ */
(() => {
   const popup = document.getElementById('profilePopup');
   if (!popup) return;                      

   window.openProfile  = () => { popup.style.display = 'flex'; };
   window.closeProfile = () => { popup.style.display = 'none';  };
})();




