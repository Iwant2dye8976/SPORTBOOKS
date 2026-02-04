function updateImage() {
    let image_url = document.getElementById('image_url').value;
    document.getElementById('preview').setAttribute('src', image_url);
}

window.onload = updateImage;

function updateFinalPrice() {
    let originPrice = parseFloat(document.getElementById('origin_price').value) || 0;
    let discount = parseFloat(document.getElementById('discount').value) || 0;

    if (discount < 0) discount = 0;
    if (discount > 100) discount = 100;

    let finalPrice = originPrice * (1 - discount / 100);
    document.getElementById('final_price').value = finalPrice.toFixed(2);
}
