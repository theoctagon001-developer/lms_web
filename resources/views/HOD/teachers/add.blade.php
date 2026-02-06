<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Teacher</title>
    @vite('resources/css/app.css')
    <style>
        /* Reusing your existing styles */
        body {
            font-family: 'Inter', sans-serif;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .toast {
            animation: slide-in 0.3s ease-out;
        }

        .toast.fade-out {
            opacity: 0;
            transform: translateX(1rem);
            transition: opacity 0.3s ease-in, transform 0.3s ease-in;
        }

        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateX(1rem);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form specific styles */
        .form-input-error {
            border-color: #f87171;
        }

        .form-error-text {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Custom radio button styles */
        .custom-radio {
            position: relative;
            padding-left: 1.75rem;
            cursor: pointer;
        }
        
        .custom-radio input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }
        
        .radio-checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 1.25rem;
            width: 1.25rem;
            background-color: #fff;
            border: 2px solid #6b7280;
            border-radius: 50%;
        }
        
        .custom-radio:hover input ~ .radio-checkmark {
            border-color: #3b82f6;
        }
        
        .custom-radio input:checked ~ .radio-checkmark {
            background-color: #fff;
            border-color: #3b82f6;
        }
        
        .radio-checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }
        
        .custom-radio input:checked ~ .radio-checkmark:after {
            display: block;
        }
        
        .custom-radio .radio-checkmark:after {
            top: 3px;
            left: 3px;
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            background: #3b82f6;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .form-actions button {
                width: 100%;
            }
        }

        /* Screen title */
        .screen-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #1f2937;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 0.5rem;
        }
    </style>
</head>
<body class="bg-blue-50">
    
        @include('HOD.partials.profile_panel')
    <div class="flex flex-1 overflow-hidden">
        <div class="flex-1 overflow-auto">
            <div class="container mx-auto px-4 py-6">
                <!-- Screen Title -->
                <h1 class="screen-title">Add New Teacher</h1>
                
                <!-- Toast Notifications Container -->
                <div id="toast-container" class="fixed top-4 right-4 space-y-2 z-50 w-full max-w-xs"></div>

                <!-- Loading Overlay -->
                <div id="loading-overlay" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-lg p-6 shadow-lg flex items-center space-x-4">
                        <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-gray-700 font-medium">Saving teacher...</span>
                    </div>
                </div>

                <!-- Main Form Container -->
                <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in">
                    <form id="add-teacher-form" class="space-y-6">
                        <!-- Grid layout for form fields -->
                        <div class="form-grid grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Teacher Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Teacher Name <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p id="name-error" class="form-error-text hidden"></p>
                            </div>
                            
                            <!-- Date of Birth -->
                            <div>
                                <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth <span class="text-red-500">*</span></label>
                                <input type="date" id="dob" name="date_of_birth" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p id="dob-error" class="form-error-text hidden"></p>
                            </div>
                            
                            <!-- Gender -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gender <span class="text-red-500">*</span></label>
                                <div class="flex space-x-4 mt-1">
                                    <label class="custom-radio flex items-center">
                                        <input type="radio" name="gender" value="Male" required>
                                        <span class="radio-checkmark"></span>
                                        <span class="ml-2 text-gray-700">Male</span>
                                    </label>
                                    <label class="custom-radio flex items-center">
                                        <input type="radio" name="gender" value="Female">
                                        <span class="radio-checkmark"></span>
                                        <span class="ml-2 text-gray-700">Female</span>
                                    </label>
                                </div>
                                <p id="gender-error" class="form-error-text hidden"></p>
                            </div>
                            
                            <!-- Employee ID (CNIC) -->
                            <div>
                                <label for="cnic" class="block text-sm font-medium text-gray-700 mb-1">Employee ID <span class="text-red-500">*</span></label>
                                <input type="text" id="cnic" name="cnic" required placeholder="Enter employee ID"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p id="cnic-error" class="form-error-text hidden"></p>
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p id="email-error" class="form-error-text hidden"></p>
                            </div>
                            
                            <!-- Profile Picture -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                                <div class="flex items-center space-x-3">
                                    <img id="imagePreview" class="w-12 h-12 object-cover rounded-full border hidden">
                                    <input type="file" id="image" name="image" accept="image/*"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">JPEG, PNG only (max 2MB)</p>
                                <p id="image-error" class="form-error-text hidden"></p>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="form-actions flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="window.history.back()" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Add Teacher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
// API Configuration
let API_BASE_URL = "http://192.168.0.107:8000/";
const ADD_TEACHER_API_URL = `${API_BASE_URL}api/Hod/add-teacher`;

// DOM Elements
const loadingOverlay = document.getElementById('loading-overlay');
const addTeacherForm = document.getElementById('add-teacher-form');
const toastContainer = document.getElementById('toast-container');
const imageInput = document.getElementById('image');
const imagePreview = document.getElementById('imagePreview');

// Initialize the page
document.addEventListener('DOMContentLoaded', async () => {
    API_BASE_URL = await getApiBaseUrl();
    
    // Form submission handler
    addTeacherForm.addEventListener('submit', handleFormSubmit);
    
    // Image preview handler
    imageInput.addEventListener('change', previewImage);
});

// Get API base URL
async function getApiBaseUrl() {
    try {
        let response = await fetch('/get-api-url');
        let data = await response.json();
        return data.api_base_url;
    } catch (error) {
        return API_BASE_URL;
    }
}

// Preview selected image
function previewImage(event) {
    const file = event.target.files[0];
    
    if (file) {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            showToast('Only JPEG and PNG images are allowed', 'error');
            imageInput.value = '';
            return;
        }
        
        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            showToast('Image must be less than 2MB', 'error');
            imageInput.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Handle form submission
async function handleFormSubmit(e) {
    e.preventDefault();
    
    // Reset error states
    resetFormErrors();
    
    // Get form data
    const formData = new FormData(addTeacherForm);
    
    // Validate form
    if (!validateForm(formData)) {
        return;
    }
    
    // Submit form
    showLoading();
    
    try {
        const response = await fetch(ADD_TEACHER_API_URL, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            if (response.status === 422) {
                // Validation errors
                handleValidationErrors(data.errors);
                showToast('Please fix the form errors', 'error');
            } else if (response.status === 409) {
                // Duplicate teacher
                showToast(data.message, 'error');
                if (data.message.includes('cnic')) {
                    markFieldAsError('cnic', 'Employee ID already exists');
                } else {
                    markFieldAsError('name', 'Teacher with this name already exists');
                }
            } else {
                // Other errors
                showToast(data.message || 'Failed to add teacher', 'error');
            }
            return;
        }
        
        // Success
        showToast('Teacher added successfully!', 'success');
        
        // Show success message with credentials
        const successMessage = `Teacher added successfully!<br>
                              Username: ${data.username}<br>
                              Password: ${data.password}`;
        
        showAlert(successMessage, 'success');
        addTeacherForm.reset();
        imagePreview.classList.add('hidden');
        
    } catch (error) {
        console.error('Error submitting form:', error);
        showToast('An unexpected error occurred. Please try again.', 'error');
    } finally {
        hideLoading();
    }
}

// Validate form fields
function validateForm(formData) {
    let isValid = true;
    
    // Required fields validation
    const requiredFields = ['name', 'date_of_birth', 'gender', 'cnic'];
    requiredFields.forEach(field => {
        if (!formData.get(field)) {
            markFieldAsError(field, 'This field is required');
            isValid = false;
        }
    });
    
    // Additional validations
    if (formData.get('email') && !validateEmail(formData.get('email'))) {
        markFieldAsError('email', 'Please enter a valid email');
        isValid = false;
    }
    
    return isValid;
}

// Simple email validation
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Reset all form error states
function resetFormErrors() {
    document.querySelectorAll('[id$="-error"]').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });
    
    document.querySelectorAll('.form-input-error').forEach(el => {
        el.classList.remove('form-input-error');
    });
}

// Mark a field as having an error
function markFieldAsError(fieldName, message = '') {
    const inputElement = document.getElementById(fieldName);
    const errorElement = document.getElementById(`${fieldName}-error`);
    
    if (inputElement) {
        inputElement.classList.add('form-input-error');
    }
    
    if (errorElement) {
        errorElement.textContent = message || 'This field has an error';
        errorElement.classList.remove('hidden');
    }
}

// Handle validation errors from server
function handleValidationErrors(errors) {
    for (const [field, messages] of Object.entries(errors)) {
        markFieldAsError(field, messages[0]);
    }
}

// Show loading overlay
function showLoading() {
    loadingOverlay.classList.remove('hidden');
}

// Hide loading overlay
function hideLoading() {
    loadingOverlay.classList.add('hidden');
}

// Show toast notification
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast rounded-md p-4 shadow-lg transform transition-all duration-300 ease-in-out ${getToastClasses(type)}`;
    toast.style.animation = 'slide-in 0.3s ease-out';
    toast.innerHTML = `
        <div class="flex items-center">
            <div class="flex-shrink-0">
                ${getToastIcon(type)}
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">${message}</p>
            </div>
            <div class="ml-auto pl-3">
                <button type="button" class="toast-close-button">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('fade-out');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
    
    toast.querySelector('.toast-close-button').addEventListener('click', () => {
        toast.remove();
    });
}

// Show alert with credentials
function showAlert(message, type = "error") {
    // Remove existing alert if present
    const existingAlert = document.getElementById("custom-alert");
    if (existingAlert) existingAlert.remove();

    // Define alert colors based on type
    const colors = {
        success: "bg-green-600",
        error: "bg-red-600",
        warning: "bg-yellow-600",
        info: "bg-blue-600"
    };

    // Create alert div
    const alertDiv = document.createElement("div");
    alertDiv.id = "custom-alert";
    alertDiv.className = `${colors[type]} text-white fixed top-24 right-5 px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-slide-in transition-all duration-300 z-50`;

    // Alert icon (SVG)
    const icon = document.createElement("div");
    icon.innerHTML = `
    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M10.29 3.86L1.82 18.14A2 2 0 003.73 21h16.54a2 2 0 001.91-2.86L13.71 3.86a2 2 0 00-3.42 0zM12 9v4m0 4h.01">
        </path>
    </svg>`;

    // Alert message
    const messageText = document.createElement("span");
    messageText.className = "font-semibold";
    messageText.innerHTML = message;

    // Close button
    const closeButton = document.createElement("button");
    closeButton.innerHTML = "✖";
    closeButton.className = "text-white hover:text-gray-300 focus:outline-none";
    closeButton.onclick = () => alertDiv.remove();

    // Append elements to alert
    alertDiv.appendChild(icon);
    alertDiv.appendChild(messageText);
    alertDiv.appendChild(closeButton);

    // Append alert to body
    document.body.appendChild(alertDiv);

    // Auto-remove alert after 10 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 10000);
}

function getToastClasses(type) {
    const classes = {
        'info': 'bg-blue-50 text-blue-800',
        'success': 'bg-green-50 text-green-800',
        'warning': 'bg-yellow-50 text-yellow-800',
        'error': 'bg-red-50 text-red-800'
    };
    return classes[type] || classes['info'];
}

function getToastIcon(type) {
    const icons = {
        'info': `
            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
            </svg>
        `,
        'success': `
            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        `,
        'warning': `
            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
        `,
        'error': `
            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
        `
    };
    return icons[type] || icons['info'];
}
</script>
</body>
</html>