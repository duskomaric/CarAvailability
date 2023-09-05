// JavaScript to toggle password visibility
document.addEventListener('DOMContentLoaded', function() {
    const showPasswordIcons = document.querySelectorAll('.show-password-icon');
    showPasswordIcons.forEach(function(icon) {
        icon.addEventListener('click', function() {
            const passwordInput = document.getElementById(icon.dataset.target);
            if (passwordInput) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('dashicons-visibility');
                    icon.classList.add('dashicons-hidden');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('dashicons-hidden');
                    icon.classList.add('dashicons-visibility');
                }
            }
        });
    });
});
