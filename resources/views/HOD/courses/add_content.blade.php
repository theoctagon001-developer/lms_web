<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course Content</title>
    @vite('resources/css/app.css')
    <style>
        /* Base styles */
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

        /* Form styles */
        .form-container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            border-bottom: 1px solid #e5e7eb;
            padding: 1.25rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .mcq-question {
            background-color: #f9fafb;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
        }

        .option-container {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .add-mcq-btn {
            display: flex;
            align-items: center;
            color: #3b82f6;
            cursor: pointer;
            margin-top: 0.5rem;
        }

        .remove-mcq-btn {
            color: #ef4444;
            cursor: pointer;
            display: flex;
            align-items: center;
            margin-top: 0.5rem;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .form-actions button {
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-blue-50">
   
        @include('HOD.partials.profile_panel')
   
    <div class="flex flex-1 overflow-hidden">
        <div class="flex-1 overflow-auto">
            <div class="container mx-auto px-4 py-6">
                <!-- Screen Title -->
                <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-6">Add Course Content</h2>
                
                <!-- Toast Notifications Container -->
                <div id="toast-container" class="fixed top-4 right-4 space-y-2 z-50 w-full max-w-xs"></div>

                <!-- Loading Overlay -->
                <div id="loading-overlay" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-lg p-6 shadow-lg flex items-center space-x-4">
                        <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-gray-700 font-medium">Processing...</span>
                    </div>
                </div>

                <!-- Main Form Container -->
                <div class="form-container animate-fade-in">
                    <div class="form-header">
                        <h3 class="text-lg font-medium text-gray-900">Course Content Information</h3>
                    </div>
                    
                    <div class="form-body">
                        <form id="add-content-form">
                            <!-- Session, Course, Week Selection -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 form-grid">
                                <div>
                                    <label for="session-select" class="block text-sm font-medium text-gray-700 mb-1">Session</label>
                                    <select id="session-select" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Session</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="course-select" class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                                    <select id="course-select" required name="offered_course_id"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" disabled>
                                        <option value="">Select Course</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="week-select" class="block text-sm font-medium text-gray-700 mb-1">Week</label>
                                    <select id="week-select" required name="week"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Week</option>
                                        ${Array.from({length: 16}, (_, i) => i + 1).map(week => 
                                            `<option value="${week}">Week ${week}</option>`
                                        ).join('')}
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Content Type Selection -->
                            <div class="mb-6">
                                <label for="content-type" class="block text-sm font-medium text-gray-700 mb-1">Content Type</label>
                                <select id="content-type" required name="type"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Content Type</option>
                                    <option value="Notes">Notes</option>
                                    <option value="MCQS">MCQS</option>
                                    <option value="Quiz">Quiz</option>
                                    <option value="Assignment">Assignment</option>
                                    <option value="LabTask" id="lab-task-option" class="hidden">Lab Task</option>
                                </select>
                            </div>
                            
                            <!-- File Upload Section (for non-MCQS types) -->
                            <div id="file-upload-section" class="mb-6 hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">File (PDF, DOC, DOCX)</label>
                                <div class="mt-1 flex items-center">
                                    <input type="file" id="content-file" name="file" accept=".pdf,.doc,.docx"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                            </div>
                            
                            <!-- MCQS Section (only for MCQS type) -->
                            <div id="mcqs-section" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-3">MCQS Questions</label>
                                
                                <div id="mcqs-container">
                                    <!-- MCQS will be added here dynamically -->
                                </div>
                                
                                <button type="button" id="add-mcq-btn" class="add-mcq-btn">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Question
                                </button>
                            </div>
                            
                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-3 mt-8 form-actions">
                                <button type="button" id="cancel-btn" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                                <button type="submit" id="submit-btn" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Save Content
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
// API Configuration
let API_BASE_URL = "http://192.168.0.107:8000/";
async function getApiBaseUrl() {
    try {
        let response = await fetch('/get-api-url');
        let data = await response.json();
        return data.api_base_url;
    } catch (error) {
        return API_BASE_URL;
    }
}

// DOM Elements
const loadingOverlay = document.getElementById('loading-overlay');
const toastContainer = document.getElementById('toast-container');
const addContentForm = document.getElementById('add-content-form');
const sessionSelect = document.getElementById('session-select');
const courseSelect = document.getElementById('course-select');
const weekSelect = document.getElementById('week-select');
const contentTypeSelect = document.getElementById('content-type');
const fileUploadSection = document.getElementById('file-upload-section');
const mcqsSection = document.getElementById('mcqs-section');
const mcqsContainer = document.getElementById('mcqs-container');
const addMcqBtn = document.getElementById('add-mcq-btn');
const cancelBtn = document.getElementById('cancel-btn');
const submitBtn = document.getElementById('submit-btn');
const labTaskOption = document.getElementById('lab-task-option');

// Global State
let offeredCourses = [];

// Initialize the page
document.addEventListener('DOMContentLoaded', async () => {
    API_BASE_URL = await getApiBaseUrl();
    await fetchOfferedCourses();
    setupEventListeners();
    
    // Populate week dropdown
    const weekOptions = Array.from({length: 16}, (_, i) => i + 1)
        .map(week => `<option value="${week}">Week ${week}</option>`)
        .join('');
    weekSelect.innerHTML = '<option value="">Select Week</option>' + weekOptions;
});

// Fetch offered courses from API
async function fetchOfferedCourses() {
    showLoading();
    try {
        const response = await fetch(`${API_BASE_URL}api/Hod/offered-courses/grouped`);
        
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        if (!data.status) throw new Error(data.message);
        
        offeredCourses = data.data;
        populateSessionSelect();
        
        showToast('Courses loaded successfully', 'success');
    } catch (error) {
        console.error('Error fetching offered courses:', error);
        showToast(`Error: ${error.message}`, 'error');
    } finally {
        hideLoading();
    }
}

// Populate session dropdown
function populateSessionSelect() {
    sessionSelect.innerHTML = '<option value="">Select Session</option>' + 
        offeredCourses.map(session => 
            `<option value="${session.session}">${session.session}</option>`
        ).join('');
}

// Setup event listeners
function setupEventListeners() {
    // Session select change
    sessionSelect.addEventListener('change', (e) => {
        const selectedSession = e.target.value;
        populateCourseSelect(selectedSession);
        courseSelect.disabled = !selectedSession;
    });
    
    // Course select change
    courseSelect.addEventListener('change', (e) => {
        const selectedCourseId = e.target.value;
        const selectedCourse = offeredCourses
            .flatMap(s => s.courses)
            .find(c => c.offered_course_id == selectedCourseId);
        
        // Show/hide LabTask option based on isLab
        if (selectedCourse && selectedCourse.isLab === 'Yes') {
            labTaskOption.classList.remove('hidden');
        } else {
            labTaskOption.classList.add('hidden');
            // If LabTask was selected but now not available, reset to default
            if (contentTypeSelect.value === 'LabTask') {
                contentTypeSelect.value = '';
            }
        }
    });
    
    // Content type select change
    contentTypeSelect.addEventListener('change', (e) => {
        const selectedType = e.target.value;
        
        // Show/hide sections based on type
        if (selectedType === 'MCQS') {
            fileUploadSection.classList.add('hidden');
            mcqsSection.classList.remove('hidden');
            // Add first question by default
            if (mcqsContainer.children.length === 0) {
                addMcqQuestion();
            }
        } else {
            mcqsSection.classList.add('hidden');
            if (selectedType) {
                fileUploadSection.classList.remove('hidden');
            } else {
                fileUploadSection.classList.add('hidden');
            }
        }
    });
    
    // Add MCQ button
    addMcqBtn.addEventListener('click', addMcqQuestion);
    
    // Cancel button
    cancelBtn.addEventListener('click', () => {
        if (confirm('Are you sure you want to cancel? All unsaved changes will be lost.')) {
            window.location.href = "{{ route('hod.courses.content') }}";
        }
    });
    
    // Form submission
    addContentForm.addEventListener('submit', handleFormSubmit);
}

// Populate course dropdown based on selected session
function populateCourseSelect(session) {
    const sessionData = offeredCourses.find(s => s.session === session);
    if (!sessionData) return;
    
    courseSelect.innerHTML = '<option value="">Select Course</option>' + 
        sessionData.courses.map(course => 
            `<option value="${course.offered_course_id}" data-is-lab="${course.isLab}">${course.course}</option>`
        ).join('');
}

// Add a new MCQ question
function addMcqQuestion() {
    const questionId = Date.now(); // Unique ID for the question
    const questionDiv = document.createElement('div');
    questionDiv.className = 'mcq-question';
    questionDiv.dataset.questionId = questionId;
    
    questionDiv.innerHTML = `
        <div class="flex justify-between items-center mb-3">
            <h4 class="font-medium">Question ${mcqsContainer.children.length + 1}</h4>
            <button type="button" class="remove-mcq-btn" data-question-id="${questionId}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Remove
            </button>
        </div>
        
        <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Question Text</label>
            <input type="text" name="MCQS[${mcqsContainer.children.length}][question_text]" required
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Enter question text">
        </div>
        
        <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Points</label>
            <input type="number" name="MCQS[${mcqsContainer.children.length}][points]" required min="1"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Enter points" value="1">
        </div>
        
        <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-2">Options (Mark the correct answer)</label>
            
            <div class="space-y-2">
                ${['option1', 'option2', 'option3', 'option4'].map((opt, idx) => `
                    <div class="option-container">
                        <input type="radio" name="MCQS[${mcqsContainer.children.length}][Answer]" value="${opt}" ${idx === 0 ? 'checked' : ''}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 mr-2">
                        <input type="text" name="MCQS[${mcqsContainer.children.length}][${opt}]" required
                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Option ${idx + 1}">
                    </div>
                `).join('')}
            </div>
        </div>
        
        <input type="hidden" name="MCQS[${mcqsContainer.children.length}][qNO]" value="${mcqsContainer.children.length + 1}">
    `;
    
    mcqsContainer.appendChild(questionDiv);
    
    // Add event listener to remove button
    questionDiv.querySelector('.remove-mcq-btn').addEventListener('click', (e) => {
        e.preventDefault();
        if (mcqsContainer.children.length > 1 || confirm('This is the last question. Remove it?')) {
            mcqsContainer.removeChild(questionDiv);
            // Renumber remaining questions
            Array.from(mcqsContainer.children).forEach((child, index) => {
                child.querySelector('h4').textContent = `Question ${index + 1}`;
                // Update all input names to maintain sequential numbering
                updateQuestionInputNames(child, index);
            });
        }
    });
}

// Update input names when questions are reordered
function updateQuestionInputNames(questionDiv, newIndex) {
    // Update question number
    questionDiv.querySelector('input[name$="[qNO]"]').value = newIndex + 1;
    
    // Update all input names
    const inputs = questionDiv.querySelectorAll('input');
    inputs.forEach(input => {
        const name = input.name;
        if (name.startsWith('MCQS[')) {
            input.name = name.replace(/MCQS\[\d+\]/, `MCQS[${newIndex}]`);
        }
    });
}

// Handle form submission
async function handleFormSubmit(e) {
    e.preventDefault();
    showLoading();
    
    try {
        const formData = new FormData();
        const contentType = contentTypeSelect.value;
        
        // Add common fields
        formData.append('offered_course_id', courseSelect.value);
        formData.append('week', weekSelect.value);
        formData.append('type', contentType);
        
        if (contentType === 'MCQS') {
            // Add MCQS questions using Flutter-style field names
            const questionDivs = mcqsContainer.querySelectorAll('.mcq-question');
            questionDivs.forEach((div, index) => {
                formData.append(`MCQS[${index}][qNO]`, div.querySelector('input[name$="[qNO]"]').value);
                formData.append(`MCQS[${index}][question_text]`, div.querySelector('input[name$="[question_text]"]').value);
                formData.append(`MCQS[${index}][points]`, div.querySelector('input[name$="[points]"]').value);
                formData.append(`MCQS[${index}][option1]`, div.querySelector('input[name$="[option1]"]').value);
                formData.append(`MCQS[${index}][option2]`, div.querySelector('input[name$="[option2]"]').value);
                formData.append(`MCQS[${index}][option3]`, div.querySelector('input[name$="[option3]"]').value);
                formData.append(`MCQS[${index}][option4]`, div.querySelector('input[name$="[option4]"]').value);
                
                // Get the selected answer
                const selectedAnswer = div.querySelector('input[name$="[Answer]"]:checked').value;
                formData.append(`MCQS[${index}][Answer]`, div.querySelector(`input[name$="[${selectedAnswer}]"]`).value);
            });
        } else {
            // For other types, add the file
            const fileInput = document.getElementById('content-file');
            if (fileInput.files.length > 0) {
                formData.append('file', fileInput.files[0]);
            } else {
                throw new Error('Please upload a file for this content type');
            }
        }
        
        // Submit to API
        const response = await fetch(`${API_BASE_URL}api/Hod/content`, {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            // Handle validation errors
            if (response.status === 422 && data.error) {
                throw new Error(data.error);
            }
            throw new Error(data.message || 'Failed to save content');
        }
        
        showToast(data.message || 'Content added successfully', 'success');
        setTimeout(() => {
            window.location.href = "{{ route('hod.courses.content') }}";
        }, 1500);
    } catch (error) {
        console.error('Error submitting form:', error);
        showToast(`Error: ${error.message}`, 'error');
    } finally {
        hideLoading();
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