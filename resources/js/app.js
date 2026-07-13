
import './echo';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';
import '@lottiefiles/dotlottie-wc';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
window.Swal = Swal;
window.Chart = Chart;
window.lucide = { createIcons, icons };

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});
