document.addEventListener('DOMContentLoaded', function() {
    const showPasswordCheckboxes = document.querySelectorAll('.show-password-checkbox');

    showPasswordCheckboxes.forEach(function(checkbox) {
        const targetInputId = checkbox.getAttribute('data-target');
        const targetInput = document.getElementById(targetInputId);

        checkbox.addEventListener('click', function() {
            targetInput.type = this.checked ? 'text' : 'password';
        });
    });
});
