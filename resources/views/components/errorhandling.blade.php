<script>
    function handleErrors(error) {
        let errorMessage = '';

        if (typeof error === 'string') {
            errorMessage = error;
        } else if (typeof error === 'object') {
            if (error.errors) {
                for (const key in error.errors) {
                    if (error.errors.hasOwnProperty(key)) {
                        errorMessage += `${error.errors[key].join(' ')} `;
                    }
                }
            } else if (error.message) {
                errorMessage = error.message;
            } else {
                errorMessage = 'An unexpected error occurred';
            }
        } else {
            errorMessage = 'An unexpected error occurred';
        }

        return errorMessage.trim();
    }
</script>