document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function() {
        let success_alert = document.getElementById('success-alert');
        let error_alert = document.getElementById('error-alert');
        let status_alert = document.getElementById('status');
        if (success_alert) {
            success_alert.style.transition = "opacity 0.5s ease";
            success_alert.style.opacity = "0";
            setTimeout(() => success_alert.remove(), 500);
        }
        if (error_alert) {
            error_alert.style.transition = "opacity 0.5s ease";
            error_alert.style.opacity = "0";
            setTimeout(() => error_alert.remove(), 500);
        }
        if (status_alert) {
            status_alert.style.transition = "opacity 0.5s ease";
            status_alert.style.opacity = "0";
            setTimeout(() => status_alert.remove(), 500);
        }
    }, 3000);
});