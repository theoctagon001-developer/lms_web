<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exam</title>
    @vite('resources/css/app.css')
    <style>
        /* Base styles from your initial structure */
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

        /* Exam specific styles */
        .exam-card {
            transition: all 0.3s ease;
            border-left: 4px solid;
        }

        .exam-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .question-table {
            width: 100%;
            border-collapse: collapse;
        }

        .question-table th,
        .question-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .question-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
        }

        .question-table tr:last-child td {
            border-bottom: none;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .exam-form-container {
                padding: 0 1rem;
            }

            .question-table {
                display: block;
                overflow-x: auto;
            }
        }

        /* File upload styles */
        .file-upload-container {
            border: 2px dashed #e5e7eb;
            border-radius: 0.375rem;
            padding: 1.5rem;
            text-align: center;
            background-color: #f9fafb;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-container:hover {
            border-color: #3b82f6;
            background-color: #f0f7ff;
        }
    </style>
</head>

<body class="bg-blue-50">
  
        @include('HOD.partials.profile_panel')
    <div class="flex flex-1 overflow-hidden">
        <div class="flex-1 overflow-auto">
            <div class="container mx-auto px-4 py-6">
                <!-- Screen Title -->
                <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-6">Create New Exam</h2>

                <!-- Toast Notifications Container -->
                <div id="toast-container" class="fixed top-4 right-4 space-y-2 z-50 w-full max-w-xs"></div>

                <!-- Loading Overlay -->
                <div id="loading-overlay"
                    class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-lg p-6 shadow-lg flex items-center space-x-4">
                        <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 001 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-gray-700 font-medium">Processing...</span>
                    </div>
                </div>

                <!-- Main Form Container -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <!-- Course Info -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-md">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Course Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Course Name</p>
                                <p class="font-medium text-gray-900">{{ $course_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Exam Type</p>
                                <p class="font-medium text-gray-900">{{ ucfirst($type ?? 'N/A') }}</p>
                            </div>
                        </div>
                        <input type="hidden" id="offered-course-id" value="{{ $offered_course_id }}">
                        <input type="hidden" id="exam-type" value="{{ $type }}">
                    </div>

                    <!-- Solid Marks -->
                    <div class="mb-6">
                        <label for="solidMarks" class="block text-sm font-medium text-gray-700 mb-1">Solid Marks</label>
                        <input type="number" id="solidMarks" min="12" max="30"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Enter marks (12-30)">
                    </div>

                    <!-- File Upload -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Question Paper (PDF only)</label>
                        <div id="dropArea" class="file-upload-container">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                <p class="text-sm text-gray-600">Drag & drop your file here or</p>
                                <span class="text-blue-600 font-medium">Browse files</span>
                                <p class="text-xs text-gray-500">PDF files only (max. 10MB)</p>
                            </div>
                        </div>
                        <input type="file" id="fileInput" class="hidden" accept=".pdf">
                        <div id="fileList" class="mt-2"></div>
                    </div>

                    <!-- Questions Section -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Questions</h3>
                            <button id="addQuestionBtn"
                                class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Question
                            </button>
                        </div>

                        <!-- Question Form (hidden by default) -->
                        <div id="questionForm" class="hidden mb-4 p-4 bg-gray-50 border rounded-md">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="questionNo"
                                        class="block text-sm font-medium text-gray-700 mb-1">Question No</label>
                                    <input type="number" id="questionNo"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="questionMarks"
                                        class="block text-sm font-medium text-gray-700 mb-1">Marks</label>
                                    <input type="number" id="questionMarks"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button id="cancelQuestion"
                                    class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                                    Cancel
                                </button>
                                <button id="saveQuestion"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-medium">
                                    Save Question
                                </button>
                            </div>
                        </div>

                        <!-- Questions Table -->
                        <div class="overflow-x-auto">
                            <table class="question-table">
                                <thead>
                                    <tr>
                                        <th>Question No</th>
                                        <th>Marks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="questionsTable">
                                    <!-- Questions will be added here dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button id="uploadButton"
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-medium">
                            Create Exam
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // API Configuration
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        document.addEventListener("DOMContentLoaded", async function() {
            // DOM Elements
            const loadingOverlay = document.getElementById("loading-overlay");
            const toastContainer = document.getElementById("toast-container");
            const uploadButton = document.getElementById("uploadButton");
            const questionsTable = document.getElementById("questionsTable");
            const addQuestionBtn = document.getElementById("addQuestionBtn");
            const questionForm = document.getElementById("questionForm");
            const cancelQuestion = document.getElementById("cancelQuestion");
            const saveQuestion = document.getElementById("saveQuestion");

            // File Upload Handling
            const dropArea = document.getElementById("dropArea");
            const fileInput = document.getElementById("fileInput");
            let uploadedFile = null;

            // Track existing question numbers to prevent duplicates
            let existingQuestionNumbers = new Set();

            // Initialize file upload functionality
            function initFileUpload() {
                dropArea.addEventListener("click", () => fileInput.click());
                fileInput.addEventListener("change", handleFileSelect);

                // Drag and drop events
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, preventDefaults, false);
                });

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropArea.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, unhighlight, false);
                });

                dropArea.addEventListener('drop', handleDrop, false);
            }

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight() {
                dropArea.classList.add('border-blue-500', 'bg-blue-50');
            }

            function unhighlight() {
                dropArea.classList.remove('border-blue-500', 'bg-blue-50');
            }

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    handleFileSelect({
                        target: {
                            files: files
                        }
                    });
                }
            }

            function handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    if (file.type === 'application/pdf') {
                        uploadedFile = file;
                        displayUploadedFile(file);
                    } else {
                        showToast('Only PDF files are allowed', 'error');
                    }
                }
            }

            function displayUploadedFile(file) {
                const fileList = document.getElementById("fileList");
                fileList.innerHTML = `
                    <div class="flex items-center justify-between p-3 bg-gray-100 rounded-md">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium">${file.name}</span>
                        </div>
                        <button onclick="removeFile()" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                `;
            }

            window.removeFile = function() {
                uploadedFile = null;
                fileInput.value = "";
                document.getElementById("fileList").innerHTML = "";
            };

            // Question Management
            function initQuestionHandling() {
                addQuestionBtn.addEventListener("click", () => {
                    questionForm.classList.remove("hidden");
                    document.getElementById("questionNo").value = "";
                    document.getElementById("questionMarks").value = "";
                });

                cancelQuestion.addEventListener("click", () => {
                    questionForm.classList.add("hidden");
                });

                saveQuestion.addEventListener("click", () => {
                    const qNo = document.getElementById("questionNo").value.trim();
                    const qMarks = document.getElementById("questionMarks").value.trim();

                    if (!qNo || !qMarks || isNaN(qNo) || isNaN(qMarks)) {
                        showToast("Please enter valid question number and marks!", "error");
                        return;
                    }

                    if (existingQuestionNumbers.has(parseInt(qNo))) {
                        showToast("Question number already exists!", "error");
                        return;
                    }

                    addQuestionToTable(qNo, qMarks);
                    questionForm.classList.add("hidden");
                });
            }

            function addQuestionToTable(qNo, qMarks) {
                existingQuestionNumbers.add(parseInt(qNo));

                const newRow = document.createElement("tr");
                newRow.className = "hover:bg-gray-50";
                newRow.innerHTML = `
                    <td class="px-4 py-3">${qNo}</td>
                    <td class="px-4 py-3">${qMarks}</td>
                    <td class="px-4 py-3">
                        <button onclick="removeQuestion(this, ${qNo})" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </td>
                `;
                questionsTable.appendChild(newRow);
            }

            window.removeQuestion = function(button, qNo) {
                existingQuestionNumbers.delete(qNo);
                button.closest("tr").remove();
            };

            // Form Submission
            uploadButton.addEventListener("click", async function() {
                const offered_course_id = document.getElementById("offered-course-id").value;
                const type = document.getElementById("exam-type").value;
                const solidMarks = document.getElementById("solidMarks").value;

                if (!offered_course_id || !type || !solidMarks) {
                    showToast("Please fill all required fields!", "error");
                    return;
                }

                if (!uploadedFile) {
                    showToast("Please upload a valid question paper!", "error");
                    return;
                }

                let questions = [];
                questionsTable.querySelectorAll("tr").forEach(row => {
                    const cells = row.querySelectorAll("td");
                    if (cells.length > 1) {
                        questions.push({
                            q_no: parseInt(cells[0].innerText),
                            marks: parseInt(cells[1].innerText)
                        });
                    }
                });

                if (questions.length === 0) {
                    showToast("Please add at least one question!", "error");
                    return;
                }

                try {
                    showLoading();
                    API_BASE_URL = await getApiBaseUrl();

                    let formData = new FormData();
                    formData.append("offered_course_id", offered_course_id);
                    formData.append("type", type);
                    formData.append("Solid_marks", solidMarks);
                    formData.append("QuestionPaper", uploadedFile);

                    questions.forEach((q, index) => {
                        formData.append(`questions[${index}][q_no]`, q.q_no);
                        formData.append(`questions[${index}][marks]`, q.marks);
                    });

                    const response = await fetch(`${API_BASE_URL}api/Uploading/uplaod/Exam`, {
                        method: "POST",
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        // Check for both possible success indicators from your API
                        if (result.status === 'Successfully Created !' || result.message === 'Exam created successfully!') {
                            alert('Exam created successfully!', 'success');
                            // Redirect after success
                            setTimeout(() => {
                                window.location.href = "{{ route('hod.exams.create') }}";
                            }, 1500);
                        } else {
                            // Handle case where API returns success but with different message structure
                            const successMessage = result.message || result.status || 'Exam created successfully!';
                            alert(successMessage, 'success');
                            setTimeout(() => {
                                window.location.href = "{{ route('hod.exams.create') }}";
                            }, 1500);
                        }
                    } else {
                        // Handle error response
                        let errorMessage = "Failed to create exam";
                        if (result.message) {
                            errorMessage = result.message;
                        } else if (result.error) {
                            errorMessage = result.error;
                        } else if (result.errors) {
                            errorMessage = Object.values(result.errors).flat().join(", ");
                        }
                        showToast(errorMessage, "error");
                    }
                } catch (error) {
                    console.error("Error:", error);
                    showToast("An error occurred while creating the exam", "error");
                } finally {
                    hideLoading();
                }
            });

            // Initialize components
            initFileUpload();
            initQuestionHandling();
        });

        function showLoading() {
            document.getElementById("loading-overlay").classList.remove("hidden");
        }

        function hideLoading() {
            document.getElementById("loading-overlay").classList.add("hidden");
        }

        function showToast(message, type = "error") {
            const colors = {
                success: "bg-green-600",
                error: "bg-red-600",
                warning: "bg-yellow-600",
                info: "bg-blue-600"
            };

            const toast = document.createElement("div");
            toast.className = `toast rounded-md p-4 shadow-lg ${colors[type]} text-white flex items-center justify-between`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>${message}</span>
                </div>
                <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            // Clear any existing toasts
            toastContainer.innerHTML = '';
            
            // Add to container
            toastContainer.appendChild(toast);

            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add("fade-out");
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }
    </script>
</body>
</html>