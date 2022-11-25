var menuBtn = document.querySelector('.menu-btn');
var navMenu = document.querySelector('.main-nav');

menuBtn.addEventListener('click', function(event){
    navMenu.classList.toggle('show');
});

var closeMenu = document.querySelector('.nav-close');
closeMenu.addEventListener('click', function(event){
    navMenu.classList.remove('show');
});