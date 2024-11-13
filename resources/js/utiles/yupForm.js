const createYupForm = ({ formEl }) => {

    const init = () => {
        initFields();
    }

    const initFields = () => {
        const inputs = formEl.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            const errorMessageEl = document.createElement('div');
            errorMessageEl.className = 'error-message py-2 font-normal text-red-500 text-xs hidden';
            const errorTargetSelector = input.getAttribute('data-error-target');
            const errorTarget = errorTargetSelector ? formEl.querySelector(errorTargetSelector) : null;
            if (errorTarget) {
                errorTarget.appendChild(errorMessageEl);
            } else {
                input.parentNode.insertBefore(errorMessageEl, input.nextSibling);
            }
        });
    }

    const clearErrorMessages = () => {
        const errorMessages = formEl.querySelectorAll('.error-message');
        errorMessages.forEach(errorMessage => {
            errorMessage.classList.add('hidden');
            errorMessage.textContent = '';
        });
    }

    const displayErrors = (err) => {
        if (err.inner) {
            err.inner.forEach(error => {
                const inputName = error.path;
                const input = formEl.querySelector(`[name="${inputName}"]`);
                if (input) {
                    const errorTargetSelector = input.getAttribute('data-error-target');
                    const errorMessageEl = errorTargetSelector ? formEl.querySelector(`${errorTargetSelector} .error-message`) : input.nextElementSibling;
                    if (errorMessageEl) {
                        errorMessageEl.textContent = error.message;
                        errorMessageEl.classList.remove('hidden');
                    }
                }
            });
        }
    }

    init();
    return {
        displayErrors: displayErrors,
        clearErrorMessages: clearErrorMessages,
    }
};

export default createYupForm;
