// function disableButton() {
//     let submitButton = document.getElementById('submit-button');
//     submitButton.disabled = true;
//     submitButton.innerText = 'Đang xử lý...';
// }
function disableButton() {
    const submitButtons = document.querySelectorAll('button[type="submit"]');

    submitButtons.forEach(button => {
        button.disabled = true;
        button.innerText = 'Đang xử lý...';
    });
}

function disableSubmitButton2(event) {
    const submitButton = event.target.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerText = 'Đang xử lý...';
    }
}
