/* ------------------------------------------------------------------
   action label with input
   ------------------------------------------------------------------ */
(() => {
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('.form-control');
        if (inputs.length === 0) return; // Exit early if no matching inputs

        inputs.forEach(input => {
            input.addEventListener('input', () => {
                const row = input.closest('.form-row');
                if (!row) return;

                if (input.value.trim() !== "") {
                    row.classList.add('filled');
                } else {
                    row.classList.remove('filled');
                }
            });
        });
    });
})();

/* ------------------------------------------------------------------
   login form
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
   show/close password input
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

