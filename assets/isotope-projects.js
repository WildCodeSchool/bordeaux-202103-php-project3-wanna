import Isotope from 'isotope-layout';

const elem = document.querySelector('.grid');
const iso = new Isotope(elem, {
    itemSelector: '.element-item',
    layoutMode: 'fitRows',
});

// filter projects
const projectFilters = document.getElementsByClassName('project-filters');
for (let i = 0; i < projectFilters.length; i++) {
    projectFilters[i].addEventListener('click', (e) => {
        const filterValue = e.target.getAttribute('data-filter');
        iso.arrange({ filter: filterValue });
    })};

window.onload = function () {
    iso.arrange({filter: '*'})};
