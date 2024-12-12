import "./bootstrap";

// resources/js/app.js (veya ilgili JS dosyanız)
document.addEventListener("DOMContentLoaded", function () {
    const registrationForm = document.getElementById("registration-form"); // Form ID'si

    if (registrationForm) {
        registrationForm.addEventListener("submit", function (event) {
            let isValid = true;
            const nameInput = document.getElementById("name");
            const emailInput = document.getElementById("email");
            const passwordInput = document.getElementById("password");
            const passwordConfirmInput = document.getElementById(
                "password_confirmation"
            );
            const nameError = document.getElementById("name-error");
            const emailError = document.getElementById("email-error");
            const passwordError = document.getElementById("password-error");
            const passwordConfirmError = document.getElementById(
                "password_confirmation-error"
            );

            // Ad validasyonu
            if (nameInput.value.trim() === "") {
                nameError.textContent = "Ad alanı zorunludur.";
                isValid = false;
            } else {
                nameError.textContent = "";
            }

            // E-posta validasyonu
            if (emailInput.value.trim() === "") {
                emailError.textContent = "E-posta alanı zorunludur.";
                isValid = false;
            } else if (!isValidEmail(emailInput.value)) {
                emailError.textContent = "Geçersiz e-posta biçimi.";
                isValid = false;
            } else {
                emailError.textContent = "";
            }

            // Şifre validasyonu
            if (passwordInput.value.trim() === "") {
                passwordError.textContent = "Şifre alanı zorunludur.";
                isValid = false;
            } else if (passwordInput.value.length < 8) {
                passwordError.textContent = "Şifre en az 8 karakter olmalıdır.";
                isValid = false;
            } else {
                passwordError.textContent = "";
            }

            if (passwordConfirmInput.value.trim() === "") {
                passwordConfirmError.textContent =
                    "Şifre Tekrar alanı zorunludur.";
                isValid = false;
            } else if (passwordInput.value != passwordConfirmInput.value) {
                passwordConfirmError.textContent = "Şifreler uyuşmuyor.";
                isValid = false;
            } else {
                passwordConfirmError.textContent = "";
            }

            if (!isValid) {
                event.preventDefault(); // Formun gönderilmesini engelle
            }

            document.getElementById("submit-button").style.display = "none";
            document.getElementById("loading-indicator").style.display =
                "block";
        });
    }
});

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
