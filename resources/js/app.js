import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
document.addEventListener('DOMContentLoaded', function() {
    const closeButton = document.querySelector('.close-button');
    const flashMessage = document.getElementById('flash-message');

    if (closeButton && flashMessage) {
        closeButton.addEventListener('click', function() {
            flashMessage.style.display = 'none';
        });
    }
});
