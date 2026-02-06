<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Student Data</title>
    @vite('resources/css/app.css')
    <style>
        /* Base styles */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
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
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            border: 1px solid #e2e8f0;
        }

        /* File upload styles */
        .file-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
            border: 2px dashed #cbd5e0;
            border-radius: 0.75rem;
            margin-top: 1.5rem;
            transition: all 0.3s;
            background-color: #f7fafc;
        }

        .file-upload:hover {
            border-color: #4299e1;
            background-color: #ebf8ff;
        }

        .file-upload.active {
            border-color: #48bb78;
            background-color: #f0fff4;
        }

        .file-input-label {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background-color: #4299e1;
            color: white;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .file-input-label:hover {
            background-color: #3182ce;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .file-name {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #4a5568;
        }

        /* Sample file link */
        .sample-file-link {
            display: inline-flex;
            align-items: center;
            color: #4299e1;
            margin-top: 1rem;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .sample-file-link:hover {
            color: #3182ce;
            text-decoration: underline;
        }

        /* Result table styles */
        .result-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
            font-size: 0.875rem;
        }

        .result-table th,
        .result-table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .result-table th {
            background-color: #f7fafc;
            font-weight: 600;
            color: #2d3748;
        }

        .result-table tr:hover {
            background-color: #f8fafc;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-success {
            background-color: #f0fff4;
            color: #276749;
        }

        .status-error {
            background-color: #fff5f5;
            color: #c53030;
        }

        /* Screen title */
        .screen-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #2d3748;
            text-align: center;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .upload-container {
                padding: 1.5rem;
            }
            
            .file-upload {
                padding: 1.5rem;
            }
            
            .result-table {
                font-size: 0.8125rem;
            }
            
            .result-table th,
            .result-table td {
                padding: 0.5rem;
            }
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            display: none; /* Initially hidden */
        }

        .loading-content {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Toast notifications */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 50;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-width: 24rem;
        }

        .toast {
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .toast-success {
            background-color: #f0fff4;
            color: #276749;
            border: 1px solid #c6f6d5;
        }

        .toast-error {
            background-color: #fff5f5;
            color: #c53030;
            border: 1px solid #fed7d7;
        }

        .toast-warning {
            background-color: #fffaf0;
            color: #975a16;
            border: 1px solid #feebc8;
        }

        .toast-info {
            background-color: #ebf8ff;
            color: #2b6cb0;
            border: 1px solid #bee3f8;
        }

        .emoji-icon {
            font-size: 1.25rem;
            width: 1.5rem;
            text-align: center;
        }

        /* Panel styles */
        .results-panel {
            margin-top: 2rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .panel-header {
            padding: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .success-header {
            background-color: #f0fff4;
            color: #276749;
        }

        .error-header {
            background-color: #fff5f5;
            color: #c53030;
        }

        .panel-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .panel-expanded {
            max-height: 5000px;
        }
    </style>
</head>

<body class="bg-gray-50">
    @include('DATACELL.partials.nav')


    <div class="container mx-auto px-4 py-8">
        <!-- Screen Title -->
        <h1 class="text-2xl sm:text-3xl font-bold text-blue-800 text-center mb-6">Upload Student Data</h1>

        <!-- Toast Notifications Container -->
        <div id="toast-container" class="toast-container"></div>

        <!-- Loading Overlay -->
        <div id="loading-overlay" class="loading-overlay">
            <div class="loading-content">
                <span class="emoji-icon animate-spin">🔄</span>
                <span class="ml-3 font-medium text-gray-700">Processing...</span>
            </div>
        </div>

        <!-- Main Upload Container -->
        <div class="upload-container animate-fade-in">
            <!-- File Upload Section -->
            <div class="mt-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Upload Excel File</h2>
                <p class="text-sm text-gray-600 mb-4">Please ensure the Excel format is accurate for proper upload.</p>
                
                <div class="file-upload" id="file-upload-area">
                    <label for="excel-file" class="file-input-label">
                        <span class="emoji-icon mr-2">📁</span>
                        Choose File
                    </label>
                    <input type="file" id="excel-file" class="hidden" accept=".xlsx,.xls">
                    <p class="file-name" id="file-name-display">No file chosen</p>
                    
                    <a href="/STUDENTDATA.xlsx" class="sample-file-link" download>
                        <span class="emoji-icon mr-1">⬇️</span>
                        Download Sample File
                    </a>
                </div>
            </div>

            <!-- Upload Button -->
            <div class="flex justify-center mt-6">
                <button id="upload-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition flex items-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    <span class="emoji-icon mr-2">📤</span>
                    Upload Students
                </button>
            </div>
        </div>

        <!-- Results Section -->
        <div id="results-section" class="hidden">
            <!-- Success Panel -->
            <div class="results-panel mt-8">
                <div class="panel-header success-header">
                    <span class="emoji-icon">✅</span>
                    <span>Successfully Added Records (<span id="success-count">0</span>)</span>
                </div>
                <div id="success-panel-content" class="panel-content">
                    <table class="result-table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Logs</th>
                                <th>Username</th>
                                <th>Password</th>
                            </tr>
                        </thead>
                        <tbody id="success-table-body">
                            <!-- Success results will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Error Panel -->
            <div class="results-panel mt-4">
                <div class="panel-header error-header">
                    <span class="emoji-icon">❌</span>
                    <span>Faulty Records (<span id="error-count">0</span>)</span>
                </div>
                <div id="error-panel-content" class="panel-content">
                    <table class="result-table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Reason</th>
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

    <footer class="bg-blue-600 p-4 mt-12 shadow-md text-center">
        <h4 class="font-bold text-2xl mb-4 text-white">Learning Management System</h4>
        <p class="text-white text-sm">&copy; 2025 LMS. All Rights Reserved.</p>
        <p class="text-white text-sm">Sameer | Ali | Sharjeel</p>
    </footer>

    <script>
        // API Configuration
        let API_BASE_URL = "http://127.0.0.1:8000/";

        // DOM Elements
        const loadingOverlay = document.getElementById('loading-overlay');
        const toastContainer = document.getElementById('toast-container');
        const fileInput = document.getElementById('excel-file');
        const fileNameDisplay = document.getElementById('file-name-display');
        const uploadBtn = document.getElementById('upload-btn');
        const fileUploadArea = document.getElementById('file-upload-area');
        const resultsSection = document.getElementById('results-section');
        const successTableBody = document.getElementById('success-table-body');
        const errorTableBody = document.getElementById('error-table-body');
        const successCount = document.getElementById('success-count');
        const errorCount = document.getElementById('error-count');
        const successPanelContent = document.getElementById('success-panel-content');
        const errorPanelContent = document.getElementById('error-panel-content');

        // Initialize the page
        document.addEventListener('DOMContentLoaded', async () => {
            await initializeApiBaseUrl();
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

        // Setup event listeners
        function setupEventListeners() {
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
        }

        // Update upload button state
        function updateUploadButtonState() {
            const file = fileInput.files[0];
            uploadBtn.disabled = !file;
        }

        // Handle file upload
        async function handleFileUpload() {
            const file = fileInput.files[0];

            if (!file) {
                showToast('Please select a file', 'warning');
                return;
            }

            showLoading();
            
            const formData = new FormData();
            formData.append('excel_file', file);

            uploadBtn.disabled = true;
            uploadBtn.innerHTML = `
                <span class="emoji-icon animate-spin mr-2">🔄</span>
                Uploading...
            `;

            try {
                const response = await fetch(`${API_BASE_URL}api/Uploading/excel-uplaod/add-or-update-student`, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    displayUploadResults(result);
                    showToast(result.Message || 'Students processed successfully', 'success');
                } else {
                    throw new Error(result.message || 'Failed to upload file');
                }
            } catch (error) {
                console.error('Error uploading file:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
                uploadBtn.disabled = false;
                uploadBtn.innerHTML = `
                    <span class="emoji-icon mr-2">📤</span>
                    Upload Students
                `;
            }
        }

        // Display upload results
        function displayUploadResults(data) {
            // Clear previous results
            successTableBody.innerHTML = '';
            errorTableBody.innerHTML = '';
            
            // Show success results
            if (data.success && data.success.length > 0) {
                data.success.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><span class="status-badge status-success">✅ ${item.status || 'success'}</span></td>
                        <td>${item.Logs || 'No logs available'}</td>
                        <td>${item.Username || 'N/A'}</td>
                        <td>${item.Password || 'N/A'}</td>
                    `;
                    successTableBody.appendChild(row);
                });
                successCount.textContent = data.success.length;
                successPanelContent.classList.add('panel-expanded');
            } else {
                successCount.textContent = '0';
            }
            
            // Show error results
            if (data.failed && data.failed.length > 0) {
                data.failed.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><span class="status-badge status-error">❌ ${item.status || 'error'}</span></td>
                        <td>${item.issue || item.Record || 'Unknown error'}</td>
                    `;
                    errorTableBody.appendChild(row);
                });
                errorCount.textContent = data.failed.length;
                errorPanelContent.classList.add('panel-expanded');
            } else {
                errorCount.textContent = '0';
            }
            
            // Show the results section
            resultsSection.classList.remove('hidden');
        }

        // Show loading overlay
        function showLoading() {
            loadingOverlay.style.display = 'flex';
        }

        // Hide loading overlay
        function hideLoading() {
            loadingOverlay.style.display = 'none';
        }

        // Show toast notification
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            let toastClass = 'toast-info';
            let emoji = 'ℹ️';
            
            switch(type) {
                case 'success':
                    toastClass = 'toast-success';
                    emoji = '✅';
                    break;
                case 'error':
                    toastClass = 'toast-error';
                    emoji = '❌';
                    break;
                case 'warning':
                    toastClass = 'toast-warning';
                    emoji = '⚠️';
                    break;
                default:
                    toastClass = 'toast-info';
                    emoji = 'ℹ️';
            }
            
            toast.className = `toast ${toastClass}`;
            toast.innerHTML = `
                <span class="emoji-icon">${emoji}</span>
                <div class="flex-1">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <button class="toast-close-button">
                    <span class="emoji-icon">✖️</span>
                </button>
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
    </script>
</body>
</html>