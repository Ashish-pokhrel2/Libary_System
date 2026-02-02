// Ajax Autocomplete for Book Search
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const autocompleteResults = document.getElementById('autocomplete-results');
    
    if (titleInput && autocompleteResults) {
        let debounceTimer;
        
        titleInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            
            const query = this.value.trim();
            
            if (query.length < 2) {
                autocompleteResults.innerHTML = '';
                autocompleteResults.classList.remove('show');
                return;
            }
            
            // Debounce the search to avoid too many requests
            debounceTimer = setTimeout(() => {
                fetchAutocomplete(query);
            }, 300);
        });
        
        // Close autocomplete when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target !== titleInput) {
                autocompleteResults.classList.remove('show');
            }
        });
    }
    
    function fetchAutocomplete(query) {
        // Using Fetch API for Ajax request with base URL support
        const baseUrl = window.baseUrl || '';
        fetch(`${baseUrl}/books/autocomplete?query=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                displayAutocompleteResults(data);
            })
            .catch(error => {
                console.error('Autocomplete error:', error);
                autocompleteResults.innerHTML = '<div class="autocomplete-item">Error loading suggestions</div>';
                autocompleteResults.classList.add('show');
            });
    }
    
    function displayAutocompleteResults(books) {
        autocompleteResults.innerHTML = '';
        
        if (books.length === 0) {
            autocompleteResults.innerHTML = '<div class="autocomplete-item">No books found</div>';
            autocompleteResults.classList.add('show');
            return;
        }
        
        books.forEach(book => {
            const item = document.createElement('div');
            item.className = 'autocomplete-item';
            item.innerHTML = `
                <strong>${escapeHtml(book.title)}</strong>
                <small>ISBN: ${escapeHtml(book.isbn)}</small>
            `;
            
            item.addEventListener('click', function() {
                titleInput.value = book.title;
                autocompleteResults.classList.remove('show');
            });
            
            autocompleteResults.appendChild(item);
        });
        
        autocompleteResults.classList.add('show');
    }
    
    // Helper function to escape HTML and prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});

// Flash message with SweetAlert
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.querySelector('.alert-success');
    const errorAlert = document.querySelector('.alert-error');
    
    if (successAlert) {
        const message = successAlert.textContent.trim();
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timerProgressBar: true
        });
        successAlert.remove();
    }
    
    if (errorAlert) {
        const message = errorAlert.textContent.trim();
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545'
        });
        errorAlert.remove();
    }
});

// Form validation enhancement with SweetAlert
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            let emptyFields = [];
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                    
                    // Get field label or name
                    const label = form.querySelector(`label[for="${field.id}"]`)?.textContent || field.name || 'Field';
                    emptyFields.push(label);
                    
                    // Remove error class on input
                    field.addEventListener('input', function() {
                        this.classList.remove('error');
                    }, { once: true });
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Validation Error',
                    html: `Please fill in all required fields:<br><strong>${emptyFields.join(', ')}</strong>`,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffc107'
                });
            }
        });
    });
});

// Delete confirmation with SweetAlert - Simple onclick function
function confirmDelete(url, itemType = 'item') {
    Swal.fire({
        title: 'Are you sure?',
        html: `Do you want to delete this <strong>${itemType}</strong>?<br>This action cannot be undone!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Redirect to delete URL
            window.location.href = url;
        }
    });
    return false; // Prevent default link behavior
}

// General purpose SweetAlert helper functions
window.showSuccess = function(message, title = 'Success!') {
    Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
        timerProgressBar: true
    });
};

window.showError = function(message, title = 'Error!') {
    Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        confirmButtonText: 'OK',
        confirmButtonColor: '#dc3545'
    });
};

window.showWarning = function(message, title = 'Warning!') {
    Swal.fire({
        icon: 'warning',
        title: title,
        text: message,
        confirmButtonText: 'OK',
        confirmButtonColor: '#ffc107'
    });
};

window.showInfo = function(message, title = 'Info') {
    Swal.fire({
        icon: 'info',
        title: title,
        text: message,
        confirmButtonText: 'OK',
        confirmButtonColor: '#0dcaf0'
    });
};
