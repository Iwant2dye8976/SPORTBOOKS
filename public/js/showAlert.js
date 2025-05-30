function showBootstrapAlert(message, type = 'success', duration = 5000) {
    const alertContainer = document.getElementById('alert-container');
    const alertId = 'alert-' + Date.now();

    alertContainer.innerHTML = `
        <div id="${alertId}" class="alert alert-${type} fade show text-center" role="alert">
            ${message}
        </div>
    `;

    // Tự động ẩn sau `duration` ms
    setTimeout(() => {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
            // alert.classList.remove('show');
            // alert.classList.add('fade');
            // setTimeout(() => alert.remove(), 300);
        }
    }, duration);
}