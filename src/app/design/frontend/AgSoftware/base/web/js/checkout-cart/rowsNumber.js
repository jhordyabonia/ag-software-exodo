//let input = document.getElementById(`cart-35-qty`);

function increase() {
    
    let input = document.querySelector('.input-text.qty');

    input.value++;
    
}

function decrease() {    

    let input = document.querySelector('.input-text.qty');

    if (input.value == 1) {
        input.value = 1;
    } else {
        input.value--;
    }
    
}