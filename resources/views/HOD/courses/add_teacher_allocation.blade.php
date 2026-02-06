<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Offered Courses</title>
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

        /* Upload container styles */
        .upload-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        /* File upload styles */
        .file-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
            border: 2px dashed #e5e7eb;
            border-radius: 0.5rem;
            margin-top: 1.5rem;
            transition: all 0.3s;
        }

        .file-upload:hover {
            border-color: #3b82f6;
        }

        .file-upload.active {
            border-color: #10b981;
            background-color: #f0fdf4;
        }

        .file-input-label {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #3b82f6;
            color: white;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .file-input-label:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
        }

        .file-name {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        /* Sample file link */
        .sample-file-link {
            display: inline-flex;
            align-items: center;
            color: #3b82f6;
            margin-top: 1rem;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .sample-file-link:hover {
            text-decoration: underline;
        }

        .sample-file-link svg {
            margin-right: 0.5rem;
        }

        /* Result table styles */
        .result-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }

        .result-table th,
        .result-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .result-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-error {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .status-skipped {
            background-color: #fef3c7;
            color: #92400e;
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

        /* Responsive styles */
        @media (max-width: 768px) {
            .upload-container {
                padding: 1rem;
            }
            
            .file-upload {
                padding: 1rem;
            }
        }

        /* Panel toggle */
        .panel-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            background-color: #f9fafb;
            border-radius: 0.375rem;
            cursor: pointer;
            margin-top: 1.5rem;
        }

        .panel-toggle:hover {
            background-color: #f3f4f6;
        }

        .panel-content {
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .panel-collapsed {
            max-height: 0;
        }

        .panel-expanded {
            max-height: 5000px;
        }
    </style>
</head>

<body class="bg-blue-50">
   
        @include('HOD.partials.profile_panel')
   
    <div class="flex flex-1 overflow-hidden">
        
        <div class="flex-1 overflow-auto">
            <div class="container mx-auto px-4 py-6">
                <!-- Screen Title -->
                <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Upload Offered Courses with Teacher Allocation</h2>

                <!-- Current Session Banner -->
                <div class="w-full bg-blue-600 text-white text-center py-2 text-lg font-semibold shadow-md rounded-t-lg">
                    Current Session: {{ session('currentSession', 'No Session Found') }}
                </div>

                <!-- Toast Notifications Container -->
                <div id="toast-container" class="fixed top-4 right-4 space-y-2 z-50 w-full max-w-xs"></div>

                <!-- Loading Overlay -->
                <div id="loading-overlay"
                    class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-lg p-6 shadow-lg flex items-center space-x-4">
                        <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-gray-700 font-medium">Processing...</span>
                    </div>
                </div>

                <!-- Main Upload Container -->
                <div class="upload-container animate-fade-in">
                    <!-- Session Selection -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Session</label>
                            <select id="session-select" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select a session</option>
                            </select>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Upload Excel File</h3>
                        <p class="text-sm text-gray-500 mb-4">Please ensure the Excel format is accurate for proper upload.</p>
                        
                        <div class="file-upload" id="file-upload-area">
                            <label for="excel-file" class="file-input-label">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Choose File
                            </label>
                            <input type="file" id="excel-file" class="hidden" accept=".xlsx,.xls">
                            <p class="file-name" id="file-name-display">No file chosen</p>
                            
                            <a href="/teacher_allocation.xlsx" class="sample-file-link" download>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download Sample File
                            </a>
                        </div>
                    </div>

                    <!-- Upload Button -->
                    <div class="flex justify-center mt-6">
                        <button id="upload-btn" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition flex items-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                            Upload Offered Courses
                        </button>
                    </div>
                </div>

                <!-- Results Section -->
                <div id="results-section" class="mt-8 hidden">
                    <div id="success-panel-toggle" class="panel-toggle">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="font-medium">Successfully Added Records (<span id="success-count">0</span>)</span>
                        </div>
                        <svg id="success-panel-arrow" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    
                    <div id="success-panel-content" class="panel-content panel-collapsed">
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <table class="result-table">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody id="success-table-body">
                                    <!-- Success results will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="error-panel-toggle" class="panel-toggle">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="font-medium">Faulty Records (<span id="error-count">0</span>)</span>
                        </div>
                        <svg id="error-panel-arrow" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    
                    <div id="error-panel-content" class="panel-content panel-collapsed">
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <table class="result-table">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Issue</th>
                                    </tr>
                                </thead>
                                <tbody id="error-table-body">
                                    <!-- Error results will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // API Configuration
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";

        // DOM Elements
        const loadingOverlay = document.getElementById('loading-overlay');
        const toastContainer = document.getElementById('toast-container');
        const sessionSelect = document.getElementById('session-select');
        const fileInput = document.getElementById('excel-file');
        const fileNameDisplay = document.getElementById('file-name-display');
        const uploadBtn = document.getElementById('upload-btn');
        const fileUploadArea = document.getElementById('file-upload-area');
        const resultsSection = document.getElementById('results-section');
        const successTableBody = document.getElementById('success-table-body');
        const errorTableBody = document.getElementById('error-table-body');
        const successCount = document.getElementById('success-count');
        const errorCount = document.getElementById('error-count');

        // Panel toggle elements
        const successPanelToggle = document.getElementById('success-panel-toggle');
        const successPanelContent = document.getElementById('success-panel-content');
        const successPanelArrow = document.getElementById('success-panel-arrow');
        const errorPanelToggle = document.getElementById('error-panel-toggle');
        const errorPanelContent = document.getElementById('error-panel-content');
        const errorPanelArrow = document.getElementById('error-panel-arrow');

        // Initialize the page
        document.addEventListener('DOMContentLoaded', async () => {
            await initializeApiBaseUrl();
            await fetchSessions();
            setupEventListeners();
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

        async function initializeApiBaseUrl() {
            API_BASE_URL = await getApiBaseUrl();
        }

        // Fetch sessions from API
        async function fetchSessions() {
            showLoading();
            try {
                const response = await fetch(`${API_BASE_URL}api/Dropdown/AllSessions`);
                
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                if (!Array.isArray(data)) throw new Error('Invalid session data format');

                populateSessionSelect(data);
                
                showToast('Sessions loaded successfully', 'success');
            } catch (error) {
                console.error('Error fetching sessions:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
            }
        }

        // Populate session dropdown
        function populateSessionSelect(sessions) {
            sessionSelect.innerHTML = '<option value="">Select a session</option>';
            
            sessions.forEach(session => {
                const option = document.createElement('option');
                option.value = session;
                option.textContent = session;
                sessionSelect.appendChild(option);
            });
        }

        // Setup event listeners
        function setupEventListeners() {
            // Session select change
            sessionSelect.addEventListener('change', () => {
                updateUploadButtonState();
            });

            // File input change
            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    fileNameDisplay.textContent = file.name;
                    fileUploadArea.classList.add('active');
                    
                    // Validate file extension
                    const validExtensions = ['.xlsx', '.xls'];
                    const fileExt = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();
                    
                    if (!validExtensions.includes(fileExt)) {
                        showToast('Please upload a valid Excel file (.xlsx or .xls)', 'warning');
                        uploadBtn.disabled = true;
                        return;
                    }
                } else {
                    fileNameDisplay.textContent = 'No file chosen';
                    fileUploadArea.classList.remove('active');
                }
                
                updateUploadButtonState();
            });

            // Upload button click
            uploadBtn.addEventListener('click', handleFileUpload);

            // Drag and drop events
            fileUploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadArea.classList.add('active');
            });

            fileUploadArea.addEventListener('dragleave', () => {
                fileUploadArea.classList.remove('active');
            });

            fileUploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUploadArea.classList.remove('active');
                
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);
                }
            });

            // Panel toggle events
            successPanelToggle.addEventListener('click', () => {
                successPanelContent.classList.toggle('panel-collapsed');
                successPanelContent.classList.toggle('panel-expanded');
                successPanelArrow.classList.toggle('rotate-180');
            });

            errorPanelToggle.addEventListener('click', () => {
                errorPanelContent.classList.toggle('panel-collapsed');
                errorPanelContent.classList.toggle('panel-expanded');
                errorPanelArrow.classList.toggle('rotate-180');
            });
        }

        // Update upload button state based on selections
        function updateUploadButtonState() {
            const session = sessionSelect.value;
            const file = fileInput.files[0];

            uploadBtn.disabled = !(session && file);
        }

        // Handle file upload
        async function handleFileUpload() {
            const session = sessionSelect.value;
            const file = fileInput.files[0];

            if (!session || !file) {
                showToast('Please select a session and file', 'warning');
                return;
            }

            showLoading();
            
            const formData = new FormData();
            formData.append('excel_file', file);
            formData.append('session', session);

            uploadBtn.disabled = true;
            uploadBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Uploading...
            `;

            try {
                const response = await fetch(`${API_BASE_URL}api/Uploading/excel-upload/offeredcourse_teacherallocation`, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    displayUploadResults(data);
                    showToast('File uploaded successfully', 'success');
                } else {
                    throw new Error(data.message || 'Failed to upload file');
                }
            } catch (error) {
                console.error('Error uploading file:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
                uploadBtn.disabled = false;
                uploadBtn.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                    Upload Offered Courses
                `;
            }
        }

        // Display upload results
        function displayUploadResults(data) {
            // Clear previous results
            successTableBody.innerHTML = '';
            errorTableBody.innerHTML = '';
            
            // Show success results
            if (data.data && data.data.Sucessfull && data.data.Sucessfull.length > 0) {
                data.data.Sucessfull.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><span class="status-badge status-success">success</span></td>
                        <td>${item.data || 'No data available'}</td>
                    `;
                    successTableBody.appendChild(row);
                });
                successCount.textContent = data.data.Sucessfull.length;
            } else {
                successCount.textContent = '0';
            }
            
            // Show error results
            if (data.data && data.data.FaultyData && data.data.FaultyData.length > 0) {
                data.data.FaultyData.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><span class="status-badge status-error">error</span></td>
                        <td>${item.Issue || item.Record || 'Unknown error'}</td>
                    `;
                    errorTableBody.appendChild(row);
                });
                errorCount.textContent = data.data.FaultyData.length;
            } else {
                errorCount.textContent = '0';
            }
            
            // Show the results section
            resultsSection.classList.remove('hidden');
            
            // Expand the panels if they have content
            if (data.data && data.data.Sucessfull && data.data.Sucessfull.length > 0) {
                successPanelContent.classList.add('panel-expanded');
                successPanelContent.classList.remove('panel-collapsed');
                successPanelArrow.classList.add('rotate-180');
            }
            
            if (data.data && data.data.FaultyData && data.data.FaultyData.length > 0) {
                errorPanelContent.classList.add('panel-expanded');
                errorPanelContent.classList.remove('panel-collapsed');
                errorPanelArrow.classList.add('rotate-180');
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
            toast.className =
                `toast rounded-md p-4 shadow-lg transform transition-all duration-300 ease-in-out ${getToastClasses(type)}`;
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

        // Get toast classes based on type
        function getToastClasses(type) {
            const classes = {
                'info': 'bg-blue-50 text-blue-800',
                'success': 'bg-green-50 text-green-800',
                'warning': 'bg-yellow-50 text-yellow-800',
                'error': 'bg-red-50 text-red-800'
            };
            return classes[type] || classes['info'];
        }

        // Get toast icon based on type
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
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                `,
            };
            return icons[type] || icons['info'];
        }
    </script>
</body>
</html>