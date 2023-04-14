const chevronButton = document.querySelector('#chevronButton');

function chevronHidden (  ) {
    if (scrollY <= 359) {
        chevronButton.classList.add('chevron--hidden');
    } else {
        chevronButton.classList.remove('chevron--hidden');
    }
}

window.addEventListener('scroll', chevronHidden, false);
