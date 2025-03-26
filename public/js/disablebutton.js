function disableButton() {
    let button = document.getElementById('submit-button');
    // button.submit;
    button.disabled = true;
    button.innerText = 'Đang xử lý...';
}