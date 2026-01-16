function decreaseQuantity(bookId) {
    const input = document.getElementById("quantity-" + bookId);
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
        updateCart(bookId);
        updateBookItemTotalPrice(bookId);
    }
}

function increaseQuantity(bookId) {
    const input = document.getElementById("quantity-" + bookId);
    const currentValue = parseInt(input.value);
    if (currentValue < 50) {
        input.value = currentValue + 1;
        updateCart(bookId);
        updateBookItemTotalPrice(bookId);
    }
}

function updateTotalPrice() {
    let shippingSelect = document.getElementById("shipping");
    let selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
    let fee = parseFloat(selectedOption.getAttribute("data-fee"));

    document.getElementById('shipping-fee').textContent = Math.ceil(fee * 25000).toLocaleString('vi-VN') + "đ";

    let totalBookPrice = 0;

    document.querySelectorAll('.book-item').forEach(element => {
        let quantity = parseInt(element.querySelector('.book-quantity').value);
        let price = parseFloat(element.querySelector('.book-price').value);
        totalBookPrice += quantity * price;
    });

    document.getElementById('book-price-detail').textContent = Math.ceil(totalBookPrice * 25000)
        .toLocaleString('vi-VN') + "đ";

    document.getElementById('book-price-detail-i').value = totalBookPrice.toFixed(2);

    let totalPrice = (totalBookPrice + fee).toFixed(2);

    document.querySelectorAll('.total-price').forEach(element => {
        if (element.tagName === "INPUT") {
            element.value = totalPrice;
        } else {
            element.textContent = Math.ceil(totalPrice * 25000).toLocaleString('vi-VN') + "đ";
        }
    });
}

function updateBookItemTotalPrice(bookId) {
    let quantityInput = document.getElementById("quantity-" + bookId);
    let quantity = parseInt(quantityInput.value);
    let priceInput = document.getElementById("price-" + bookId);
    let price = parseFloat(priceInput.value);

    let totalPrice = quantity * price;
    let totalPriceElement = document.getElementById("items-total-price-" + bookId);
    totalPriceElement.textContent = Math.ceil(totalPrice * 25000).toLocaleString('vi-VN') + "đ";
}

function updateCart(bookId) {
    let quantityInput = document.getElementById("quantity-" + bookId);
    let quantity = parseInt(quantityInput.value);

    if (!quantity || quantity < 1 || quantity > 50) {
        quantityInput.value = 1;
        quantity = 1;
    }

    updateTotalPrice();

    fetch(`/cart/update`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify({
            book_id: bookId,
            quantity: quantity
        })
    }).then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Cập nhật giỏ hàng thành công");
            }
        }).catch(error => console.error("Lỗi cập nhật giỏ hàng:", error));
}

function clearCart() {
    if (confirm('Bạn có chắc muốn xóa tất cả sản phẩm trong giỏ hàng?')) {
        window.location.href = '/cart/clear';
    }
}

window.onload = function () {
    updateTotalPrice();
    setTimeout(function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
};
