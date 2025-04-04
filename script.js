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


document.addEventListener('DOMContentLoaded', (event) => {
    var skillItems = document.querySelectorAll('.skill-list-item');
    skillItems.forEach(function (skillItem, index) {
        // Ici, tu définirais la largeur en fonction de la valeur de la compétence
        // par exemple, une compétence de valeur 70/100 donnerait une largeur de 70%
        skillItem.style.setProperty('--skill-level', '70%');
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const userBtn = document.querySelector('#user-btn');
    const userBox = document.querySelector('.profile-detail');
    console.log(userBtn, userBox); // Doit afficher les deux éléments, pas null

    if (userBtn && userBox) {
        userBtn.addEventListener('click', function () {
            userBox.classList.toggle('active');
        });
    } else {
        console.log('Elements not found');
    }
});

document.addEventListener('DOMContentLoaded', function () {
    if (sessionStorage.getItem('welcome_login') === 'true') {
        Swal.fire({
            title: 'Bienvenue!',
            text: 'Votre connexion/enregistrement a réussi.',
            icon: 'success',
            confirmButtonText: 'Ok'
        });
        sessionStorage.removeItem('welcome_login'); // Nettoyez après affichage
    }
});