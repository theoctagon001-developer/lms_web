<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course</title>
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
                <h1 class="screen-title">Add New Course</h1>
                
                <!-- Toast Notifications Container -->
                <div id="toast-container" class="fixed top-4 right-4 space-y-2 z-50 w-full max-w-xs"></div>

                <!-- Loading Overlay -->
                <div id="loading-overlay" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-lg p-6 shadow-lg flex items-center space-x-4">
                        <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-gray-700 font-medium">Saving course...</span>
                    </div>
                </div>

                <!-- Main Form Container -->
                <div class="bg-white rounded-lg shadow-md p-6 animate-fade-in">
                    <form id="add-course-form" class="space-y-6">
                        <!-- Grid layout for form fields -->
                        <div class="form-grid grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Course Code -->
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Course Code <span class="text-red-500">*</span></label>
                                <input type="text" id="code" name="code" required maxlength="20"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p id="code-error" class="form-error-text hidden"></p>
                            </div>
                            
                            <!-- Course Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Course Name <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" required maxlength="100"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p id="name-error" class="form-error-text hidden"></p>
                            </div>
                            
                            <!-- Credit Hours -->
                            <div>
                                <label for="credit_hours" class="block text-sm font-medium text-gray-700 mb-1">Credit Hours <span class="text-red-500">*</span></label>
                                <select id="credit_hours" name="credit_hours" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Credit Hours</option>
                                    <option value="1">1 Credit Hour</option>
                                    <option value="2">2 Credit Hours</option>
                                    <option value="3">3 Credit Hours</option>
                                    <option value="4">4 Credit Hours</option>
                                </select>
                                <p id="credit_hours-error" class="form-error-text hidden"></p>
                            </div>
                            
                            <!-- Program Name -->
                            <div>
                                <label for="program_name" class="block text-sm font-medium text-gray-700 mb-1">Program <span class="text-red-500">*</span></label>
                                <select id="program_name" name="program_name" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Program</option>
                                    <option value="BCS">BCS</option>
                                    <option value="BAI">BAI</option>
                                    <option value="BSE">BSE</option>
                                    <option value="BIT">BIT</option>
                                </select>
                                <p id="program_name-error" class="form-error-text hidden"></p>
                            </div>
                            
                            <!-- Course Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Course Type</label>
                                <select id="type" name="type"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="Core">Core</option>
                                    <option value="Elective">Elective</option>
                                </select>
                                <p id="type-error" class="form-error-text hidden"></p>
                            </div>
                            
                            <!-- Lab Requirement -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lab Required <span class="text-red-500">*</span></label>
                                <div class="mt-1 space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="lab" value="1" required checked
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-2 text-gray-700">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="lab" value="0"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-2 text-gray-700">No</span>
                                    </label>
                                </div>
                                <p id="lab-error" class="form-error-text hidden"></p>
                            </div>
                            
                            <!-- Prerequisite Course Code -->
                            <div class="md:col-span-2">
                                <label for="pre_req_code" class="block text-sm font-medium text-gray-700 mb-1">Prerequisite Course Code</label>
                                <input type="text" id="pre_req_code" name="pre_req_code" maxlength="20"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Leave blank if no prerequisite</p>
                                <p id="pre_req_code-error" class="form-error-text hidden"></p>
                            </div>
                            
                            <!-- Short Form (previously called Description) -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Short Form</label>
                                <input type="text" id="description" name="description" maxlength="10"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Short abbreviation for the course (e.g., TBW, CC, etc.) - max 10 characters</p>
                                <p id="description-error" class="form-error-text hidden"></p>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="form-actions flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="window.history.back()" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Save Course
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
const ADD_COURSE_API_URL = `${API_BASE_URL}api/Hod/add-course`;

// DOM Elements
const loadingOverlay = document.getElementById('loading-overlay');
const addCourseForm = document.getElementById('add-course-form');
const toastContainer = document.getElementById('toast-container');

// Initialize the page
document.addEventListener('DOMContentLoaded', async () => {
    API_BASE_URL = await getApiBaseUrl();
    
    // Form submission handler
    addCourseForm.addEventListener('submit', handleFormSubmit);
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

// Handle form submission
async function handleFormSubmit(e) {
    e.preventDefault();
    
    // Reset error states
    resetFormErrors();
    
    // Get form data
    const formData = new FormData(addCourseForm);
    const formObject = Object.fromEntries(formData.entries());
    
    // Convert lab value to boolean
    formObject.lab = formObject.lab === '1';
    
    // Validate form
    if (!validateForm(formObject)) {
        return;
    }
    
    // Submit form
    showLoading();
    
    try {
        const response = await fetch(ADD_COURSE_API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(formObject)
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            if (response.status === 422) {
                // Validation errors
                handleValidationErrors(data.errors);
                showToast('Please fix the form errors', 'error');
            } else if (response.status === 409) {
                // Duplicate course
                showToast(data.message, 'error');
                markFieldAsError('code');
                markFieldAsError('name');
            } else if (response.status === 404) {
                // Program not found
                showToast(data.message, 'error');
                markFieldAsError('program_name');
            } else {
                // Other errors
                showToast(data.message || 'Failed to add course', 'error');
            }
            return;
        }
        
        // Success
        showToast('Course added successfully!', 'success');
        addCourseForm.reset();
        
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
    const requiredFields = ['code', 'name', 'credit_hours', 'program_name'];
    requiredFields.forEach(field => {
        if (!formData[field]) {
            markFieldAsError(field, 'This field is required');
            isValid = false;
        }
    });
    
    // Additional validations
    if (formData.code && formData.code.length > 20) {
        markFieldAsError('code', 'Code must be less than 20 characters');
        isValid = false;
    }
    
    if (formData.name && formData.name.length > 100) {
        markFieldAsError('name', 'Name must be less than 100 characters');
        isValid = false;
    }
    
    if (formData.description && formData.description.length > 10) {
        markFieldAsError('description', 'Short form must be less than 10 characters');
        isValid = false;
    }
    
    if (formData.pre_req_code && formData.pre_req_code.length > 20) {
        markFieldAsError('pre_req_code', 'Prerequisite code must be less than 20 characters');
        isValid = false;
    }
    
    return isValid;
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