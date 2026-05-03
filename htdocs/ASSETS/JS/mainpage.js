/*=============== SHOW MENU ===============*/
const navMenu = document.getElementById('nav-menu'),
      navToggle = document.getElementById('nav-toggle'),
      navClose = document.getElementById('nav-close');

/*Menu show */
if(navToggle){
    navToggle.addEventListener('click',()=>{
        navMenu.classList.add('show-menu')
    })
}

/*Menu hidden */
if(navClose){
    navClose.addEventListener('click',()=>{
        navMenu.classList.remove('show-menu')
    })
}

/*=============== REMOVE MENU MOBILE ===============*/
const navLink = document.querySelectorAll('.nav__link')

const LinkAction = ()=>{
    const navMenu = document.getElementById('nav-menu')
    navMenu.classList.remove('show-menu')
}
navLink.forEach(n=>n.addEventListener('click', LinkAction))

/*=============== HOME TYPED JS - DYNAMIC FROM DATABASE ===============*/
let typedHome = null;

function initTypedFromDB(designations) {
    const typedElement = document.getElementById('home-typed');
    if (typedElement && designations && designations.length > 0) {
        if (typedHome) {
            typedHome.destroy();
        }
        typedElement.innerHTML = '';
        typedHome = new Typed('#home-typed', {
            strings: designations,
            typeSpeed: 80,
            backSpeed: 40,
            backDelay: 2000,
            loop: true,
            cursorChar: '_',
            startDelay: 300
        });
    }
}

/*=============== ADD SHADOW HEADER ===============*/
const shadowHeader = () =>{
    const header = document.getElementById('header')
    this.scrollY >= 50 ? header.classList.add('shadow-header')
                       : header.classList.remove('shadow-header')
}
window.addEventListener('scroll', shadowHeader)

/*=============== CONTACT EMAIL JS ===============*/ 

/*=============== SHOW SCROLL UP ===============*/ 
const scrollUp = ()=>{
    const scrollUp = document.getElementById('scroll-up')
    this.scrollY >= 350 ? scrollUp.classList.add('show-scroll')
                        : scrollUp.classList.remove('show-scroll')
}
window.addEventListener('scroll',scrollUp)

/*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
const sections = document.querySelectorAll('.section[id]')

const scrollAction = () =>{
    const scrollDown = window.scrollY

    sections.forEach(current =>{
        const sectionHeight = current.offsetHeight
        const sectionTop = current.offsetTop - 50
        const sectionId = current.getAttribute('id')

        const sectionClass = document.querySelector(
          '.nav__menu a[href="#' + sectionId + '"]'
        )

        if(sectionClass) {
            if(scrollDown > sectionTop && scrollDown <= sectionTop + sectionHeight){
                sectionClass.classList.add('active-link')
            } else {
                sectionClass.classList.remove('active-link')
            }
        }
    })
}
window.addEventListener('scroll', scrollAction)

/*=============== SCROLL REVEAL ANIMATION ===============*/
if(typeof ScrollReveal !== 'undefined') {
    const sr = ScrollReveal({
        origin: 'top',
        distance: '60px',
        duration: 2000,
        reset: true,
    })

    sr.reveal('.home__content, .resume__content:nth-child(1),.footer__container')
    sr.reveal('.home__data,.resume__content:nth-child(2)', {delay:300, origin:'bottom'})   
    sr.reveal('.about__content, .contact__content',{origin:'bottom'})
    sr.reveal('.about__image,.contact__form',{delay:300})
    sr.reveal('.projects__card', { interval: 100 })
}

// Export function for use in home.php
window.initTypedFromDB = initTypedFromDB;


document.addEventListener('DOMContentLoaded', function() {
    const scheduleBtn = document.querySelector('.schedule-btn');
    const dropdown = document.querySelector('.schedule-dropdown');
    
    if (scheduleBtn && dropdown) {
        scheduleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('show');
        });
        
        document.addEventListener('click', function(e) {
            if (!scheduleBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    }
});



