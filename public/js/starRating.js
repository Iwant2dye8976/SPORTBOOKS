document.querySelectorAll('.rating-stars label').forEach((label, index) => {
    label.addEventListener('click', () => {
        document.querySelectorAll('.rating-stars i').forEach((star, i) => {
            star.classList.toggle('fa-solid', i <= index);
            star.classList.toggle('fa-regular', i > index);
        });
    });
});
