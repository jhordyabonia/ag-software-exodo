//let input = document.getElementById('cart-35-qty');
let input = document.querySelector('input[data-role="cart-item-qty"]');
let disableBtn = document.getElementById('decreaseBtn');

function counterNumber(valuePar) {

    let startValue = input.value;

    if(valuePar.value == 'increase') {
        startValue++;
    } else {
        startValue--;
    }

    if(startValue == 0) {
        disableBtn.disabled = true;
    } else {
        disableBtn.disabled = false;
    }

    input.value = startValue;
    
}