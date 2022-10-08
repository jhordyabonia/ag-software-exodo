//let input = document.getElementById('cart-35-qty');
let input = document.querySelector('input[data-role="cart-item-qty"]');
let decreaseBtn = document.getElementById('decreaseBtn');
let increaseBtn = document.getElementById('increaseBtn');

decreaseBtn.addEventListener('click', decreaseNumber, true);
increaseBtn.addEventListener('click', increaseNumber, true);


function increaseNumber(valuePar) {

    let startValue = input.value;

    startValue++;

    input.value = startValue;
    
}

function decreaseNumber(valuePar) {

    let startValue = input.value;

    startValue--;

    input.value = startValue;
    
}