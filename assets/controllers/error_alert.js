class ErrorAlert {
    constructor(errors) {
        // Assurons-nous que errors est toujours un tableau
        this.errors = Array.isArray(errors) ? errors : [errors];
    }

    render() {
        if (!this.errors || this.errors.length === 0) return '';

        const errorList = this.errors.map(error => {
            // Si l'erreur est un objet ou un tableau, on le convertit en chaîne
            if (typeof error === 'object' || Array.isArray(error)) {
                error = JSON.stringify(error);
            }
            return `<span class="block">${error}</span>`;
        }).join('');

        return `
            <div role="alert" class="alert alert-error">
                <svg
                    id = "close-error"
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0 stroke-current pointer-cursor"
                    fill="none"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>${errorList}</div>
            </div>
        `;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const errorAlertElement = document.getElementById('error-alert');
    const closeError = document.getElementById('close-error');
    if (errorAlertElement) {
        let errors;
        try {
            errors = JSON.parse(errorAlertElement.dataset.errors);
        } catch (e) {
            // Si le parsing échoue, on utilise la chaîne brute
            errors = errorAlertElement.dataset.errors;
        }
        const errorAlert = new ErrorAlert(errors);
        errorAlertElement.innerHTML = errorAlert.render();
    }
    if (closeError) {
        closeError.addEventListener('click', () => {
            errorAlertElement.remove();
        });
    }
});