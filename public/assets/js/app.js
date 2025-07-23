document.addEventListener('DOMContentLoaded', function() {
    fetch('../backend/csrf.php')
        .then(response => response.text())
        .then(token => {
            document.querySelectorAll('form').forEach(form => {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'csrf_token';
                input.value = token;
                form.appendChild(input);
            });
        });
});
