const chevronUp = document.querySelector('#chevronUp');

function chevronScrollUp() {

    document.documentElement.scrollTop;

    if (document.documentElement.scrollTop > 0) {

        window.requestAnimationFrame(chevronScrollUp);

        window.scrollTo(0, document.documentElement.scrollTop - (document.documentElement.scrollTop / 5) );

    }

}

chevronUp.addEventListener('click', chevronScrollUp);
