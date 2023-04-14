const chevronTops = document.querySelectorAll('.chevron-top');

function chevronScrollTop() {

    document.documentElement.scrollTop;

    if (document.documentElement.scrollTop > 0) {

        window.requestAnimationFrame(chevronScrollTop);

        window.scrollTo(0, document.documentElement.scrollTop - (document.documentElement.scrollTop / 5) );

    }

}

chevronTops.forEach( chevronTop => {
    chevronTop.addEventListener('click', chevronScrollTop);
} );
