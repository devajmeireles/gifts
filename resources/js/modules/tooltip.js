import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

document.addEventListener('alpine:init', () => {
    Alpine.directive('tooltip', (el, { expression }) => {
        tippy(el, {
            content: expression,
            animation: 'shift-away',
            duration: 0,
            allowHTML: true,
        })
    })
});
