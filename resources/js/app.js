import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

if (csrfToken) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
}

document.addEventListener('click', (event) => {
    const trigger = event.target.closest('[data-menu-toggle]');
    if (!trigger) return;

    const menu = document.querySelector(trigger.dataset.menuToggle);
    menu?.classList.toggle('hidden');
    trigger.setAttribute('aria-expanded', String(!menu?.classList.contains('hidden')));
});
