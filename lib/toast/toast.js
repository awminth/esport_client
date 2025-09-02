// Toast function
function showToast(options) {
    const {
        type = 'info',
            title = '',
            message = '',
            duration = 3000,
            closable = true
    } = options;

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;

    // Set icons for different types
    const icons = {
        success: 'fa-circle-check',
        error: 'fa-circle-xmark',
        warning: 'fa-triangle-exclamation',
        info: 'fa-circle-info'
    };

    // Toast content
    toast.innerHTML = `
            <i class="toast-icon fas ${icons[type]}"></i>
            <div class="toast-content">
                ${title ? `<div class="toast-title">${title}</div>` : ''}
                <div class="toast-message">${message}</div>
            </div>
            ${closable ? '<button class="toast-close">&times;</button>' : ''}
            <div class="toast-progress">
                <div class="toast-progress-bar"></div>
            </div>
        `;

    // Add to container
    const container = document.getElementById('toastContainer');
    container.appendChild(toast);

    // Trigger animation
    setTimeout(() => {
        toast.classList.add('show');

        // Animate progress bar
        const progressBar = toast.querySelector('.toast-progress-bar');
        progressBar.style.transition = `transform ${duration}ms linear`;
        progressBar.style.transform = 'scaleX(1)';
    }, 10);

    // Close button event
    if (closable) {
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => {
            hideToast(toast);
        });
    }

    // Auto dismiss if duration is set
    if (duration > 0) {
        setTimeout(() => {
            hideToast(toast);
        }, duration);
    }

    return toast;
}

function hideToast(toast) {
    toast.classList.remove('show');
    toast.classList.add('hide');

    // Remove after animation
    setTimeout(() => {
        toast.remove();
    }, 400);
}