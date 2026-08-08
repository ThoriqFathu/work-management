import './bootstrap';

import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;

Alpine.start();

const sidebar = document.getElementById('mobile-sidebar');

document
    .getElementById('btn-sidebar')
    ?.addEventListener('click', () => {
        sidebar?.classList.remove('hidden');
    });

document
    .getElementById('btn-close-sidebar')
    ?.addEventListener('click', () => {
        sidebar?.classList.add('hidden');
    });

sidebar?.addEventListener('click', (e) => {
    if (e.target === sidebar) {
        sidebar.classList.add('hidden');
    }
});