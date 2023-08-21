import './bootstrap';
import './modules/tooltip';
import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';
import mask from '@alpinejs/mask'

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;

Alpine.plugin(mask);

Alpine.start();
