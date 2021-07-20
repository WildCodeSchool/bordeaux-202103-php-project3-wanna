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
        const titleDiv = document.getElementById('project-list-title');
        const titleValue = e.target.getAttribute('title');
        const filterValue = e.target.getAttribute('data-filter');
        iso.arrange({ filter: filterValue });
        titleDiv.innerHTML = 'PROJECTS FOCUSING ON ' + titleValue;

    })};

window.onload = function () {
    iso.arrange({filter: '*'})};
