const header = document.querySelector('header');
function fixedNavbar() {
    header.classList.toggle('scrolled', window.pageYOffset > 0)
}
fixedNavbar();
window.addEventListener('scroll', fixedNavbar);

let menu = document.querySelector('#menu-btn');
let userBtn = document.querySelector('#user-btn');

menu.addEventListener('click', function () {
    let nav = document.querySelector('.navbar');
    nav.classList.toggle('active');
})
userBtn.addEventListener('click', function () {
    let userBox = document.querySelector('.user-box');
    userBox.classList.toggle('active')
})
/*--------home page slider-------------*/
"use strict"
const leftArrow = document.querySelector('.left-arrow .bxs-left-arrow'),
    rightArrow = document.querySelector('.right-arrow .bxs-right-arrow'),
    slider = document.querySelector('.slider');
/*--------scroll to right------------*/
function scrollRight() {
    if (slider.scrollWidth - slider.clientWidth === slider.scrollLeft) {
        slider.scrollTo({
            left: 0,
            behavior: "smooth"
        });
    } else {
        slider.scrollBy({
            left: window.innerWidth,
            behavior: "smooth"
        })
    }
}
/*--------scroll to left------------*/
function scrollLeft() {
    slider.scrollBy({
        left: -window.innerWidth,
        behavior: "smooth"
    })
}
let timerId = setInterval(scrollRight, 7000);

/*--------reset timer to scroll right------------*/
function resetTimer() {
    clearInterval(timerId);
    timerId = setInterval(scrollRight, 7000);
}
/*--------scroll event------------*/
slider.addEventListener("click", function (ev) {
    if (ev.target === leftArrow) {
        scrollLeft();
        resetTimer();
    }
});

slider.addEventListener("click", function (ev) {
    if (ev.target === rightArrow) {
        scrollRight();
        resetTimer();
    }
});


document.querySelectorAll('.color-button').forEach(function (button) {
    button.addEventListener('click', function () {
        var color = this.getAttribute('data-color');
        var carImage = document.getElementById('car-image');

        // Ici vous changerez la source de l'image de la voiture selon la couleur.
        // Par exemple, vous aurez différentes images de voitures de différentes couleurs préparées.
        // carImage.src = 'path-to-your-car-image-' + color + '.png';

        // Ou si vous voulez changer une propriété CSS comme la couleur de fond (pour une div par exemple):
        // carImage.style.backgroundColor = color;
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    let currentSlide = 0;
    const slides = document.querySelectorAll(".slides img");

    function showSlide(index) {
        // Mettre à jour l'index currentSlide avant de vérifier s'il est hors des limites
        currentSlide = index;

        // Ajustement de currentSlide s'il est hors des limites
        if (currentSlide >= slides.length) currentSlide = 0;
        if (currentSlide < 0) currentSlide = slides.length - 1;

        // Cacher toutes les slides et montrer seulement la slide active
        slides.forEach(slide => {
            slide.classList.remove("active");
        });
        slides[currentSlide].classList.add("active");
    }

    function changeSlide(step) {
        // Appeler showSlide avec le nouvel index
        showSlide(currentSlide + step);
    }

    // Initialiser le slider avec la première slide
    showSlide(currentSlide);
    document.querySelector('.prev').addEventListener('click', () => changeSlide(-1));
    document.querySelector('.next').addEventListener('click', () => changeSlide(1));
});


