function decreaseAmount() {
    const input = document.getElementById('amount');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function increaseAmount() {
    const input = document.getElementById('amount');
    const currentValue = parseInt(input.value);
    if (currentValue < 999) {
        input.value = currentValue + 1;
    }
}
