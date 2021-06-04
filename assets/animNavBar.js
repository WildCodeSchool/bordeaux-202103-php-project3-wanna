const navigation = document.getElementById('home-nav');

window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        navigation.classList.add('anim-color-navbar');
    } else {
        navigation.classList.remove('anim-color-navbar');
    }
});
