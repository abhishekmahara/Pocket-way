// Admin Panel JavaScript Functions

// DataTable Initialization with custom settings
function initializeDataTable(tableId, options = {}) {
    const defaultOptions = {
        pageLength: 25,
        responsive: true,
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print'],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries per page",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)"
        }
    };

    return $(tableId).DataTable({...defaultOptions, ...options});
}

// Form Validation Helper
function validateForm(formId, rules = {}) {
    return $(formId).validate({
        errorElement: 'span',
        errorClass: 'text-danger',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
        rules: rules
    });
}

// Toast Notification System
const Toast = {
    show(message, type = 'success') {
        const toast = $(`
            <div class="toast-notification ${type}">
                <div class="toast-content">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    <span>${message}</span>
                </div>
            </div>
        `);
        
        $('body').append(toast);
        setTimeout(() => toast.remove(), 3000);
    }
};

// AJAX Request Handler
function makeAjaxRequest(url, method, data) {
    return $.ajax({
        url: url,
        type: method,
        data: data,
        dataType: 'json'
    }).fail(function(jqXHR) {
        Toast.show('An error occurred. Please try again.', 'error');
        console.error('Ajax Error:', jqXHR);
    });
}

// Delete Confirmation Dialog
function confirmDelete(entityName, deleteFunction) {
    if (confirm(`Are you sure you want to delete this ${entityName}? This action cannot be undone.`)) {
        deleteFunction();
    }
}

// Image Preview Handler
function handleImagePreview(inputId, previewId) {
    $(inputId).change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $(previewId).attr('src', e.target.result).removeClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
}

// Form Data Serializer
function serializeFormToJSON(formId) {
    const formData = {};
    $(formId).serializeArray().forEach(item => {
        formData[item.name] = item.value;
    });
    return formData;
}

// Initialize all tooltips
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Auto hide alerts after 5 seconds
    $('.alert').delay(5000).fadeOut(500);
});