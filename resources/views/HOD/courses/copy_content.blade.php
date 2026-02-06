<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copy Course Content</title>
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

        /* Copy content specific styles */
        .copy-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            position: relative;
        }

        .copy-container::before {
            content: "";
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 1px;
            background-color: #e5e7eb;
        }

        .copy-side {
            padding: 1rem;
        }

        .copy-side-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .copy-side-title svg {
            margin-right: 0.5rem;
        }

        .course-info-card {
            background-color: #f9fafb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
            border: 1px solid #e5e7eb;
        }

        .course-info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .course-info-label {
            color: #6b7280;
        }

        .course-info-value {
            font-weight: 500;
        }

        .mode-toggle {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .toggle-btn {
            padding: 0.5rem 1rem;
            background-color: #f3f4f6;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .toggle-btn:first-child {
            border-radius: 0.375rem 0 0 0.375rem;
        }

        .toggle-btn:last-child {
            border-radius: 0 0.375rem 0.375rem 0;
        }

        .toggle-btn.active {
            background-color: #3b82f6;
            color: white;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .copy-container {
                grid-template-columns: 1fr;
            }

            .copy-container::before {
                display: none;
            }
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
    </style>
</head>

<body class="bg-blue-50">
   
        @include('HOD.partials.profile_panel')
   
    <div class="flex flex-1 overflow-hidden">
       
        <div class="flex-1 overflow-auto">
            <div class="container mx-auto px-4 py-6">
                <!-- Screen Title -->
                <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Copy Course Content</h2>

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
                                d="M4 12a8.001 8.001 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-gray-700 font-medium">Processing...</span>
                    </div>
                </div>

                <!-- Mode Toggle -->
                <div class="mode-toggle">
                    <button id="auto-mode-btn" class="toggle-btn active">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Auto Mode
                    </button>
                    <button id="manual-mode-btn" class="toggle-btn">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Manual Mode
                    </button>
                </div>

                <!-- Main Copy Container -->
                <div class="copy-container animate-fade-in">
                    <!-- Source Side -->
                    <div class="copy-side">
                        <h3 class="copy-side-title">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Source (From)
                        </h3>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Session</label>
                                <select id="source-session-select" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select a session</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                                <select id="source-course-select" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" disabled>
                                    <option value="">Select a course</option>
                                </select>
                            </div>
                        </div>

                        <div id="source-course-info" class="course-info-card hidden">
                            <div class="course-info-item">
                                <span class="course-info-label">Course Type:</span>
                                <span id="source-course-type" class="course-info-value"></span>
                            </div>
                            <div class="course-info-item">
                                <span class="course-info-label">Notes Count:</span>
                                <span id="source-notes-count" class="course-info-value"></span>
                            </div>
                            <div class="course-info-item">
                                <span class="course-info-label">Tasks Count:</span>
                                <span id="source-tasks-count" class="course-info-value"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Destination Side -->
                    <div class="copy-side">
                        <h3 class="copy-side-title">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Destination (To)
                        </h3>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Session</label>
                                <select id="destination-session-select" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" disabled>
                                    <option value="">Select a session</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                                <select id="destination-course-select" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" disabled>
                                    <option value="">Select a course</option>
                                </select>
                            </div>
                        </div>

                        <div id="destination-course-info" class="course-info-card hidden">
                            <div class="course-info-item">
                                <span class="course-info-label">Course Type:</span>
                                <span id="destination-course-type" class="course-info-value"></span>
                            </div>
                            <div class="course-info-item">
                                <span class="course-info-label">Notes Count:</span>
                                <span id="destination-notes-count" class="course-info-value"></span>
                            </div>
                            <div class="course-info-item">
                                <span class="course-info-label">Tasks Count:</span>
                                <span id="destination-tasks-count" class="course-info-value"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="flex justify-center mt-8">
                    <button id="copy-content-btn" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition flex items-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                        </svg>
                        Copy Content
                    </button>
                </div>

                <!-- Results Section -->
                <div id="results-section" class="mt-8 hidden">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Copy Results</h3>
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <table class="result-table">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody id="results-table-body">
                                <!-- Results will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // API Configuration
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let offeredCoursesData = [];
        let isAutoMode = true;
        let sourceCourseId = null;

        // DOM Elements
        const loadingOverlay = document.getElementById('loading-overlay');
        const toastContainer = document.getElementById('toast-container');
        const autoModeBtn = document.getElementById('auto-mode-btn');
        const manualModeBtn = document.getElementById('manual-mode-btn');
        const sourceSessionSelect = document.getElementById('source-session-select');
        const sourceCourseSelect = document.getElementById('source-course-select');
        const destinationSessionSelect = document.getElementById('destination-session-select');
        const destinationCourseSelect = document.getElementById('destination-course-select');
        const copyContentBtn = document.getElementById('copy-content-btn');
        const resultsSection = document.getElementById('results-section');
        const resultsTableBody = document.getElementById('results-table-body');

        // Source course info elements
        const sourceCourseInfo = document.getElementById('source-course-info');
        const sourceCourseType = document.getElementById('source-course-type');
        const sourceNotesCount = document.getElementById('source-notes-count');
        const sourceTasksCount = document.getElementById('source-tasks-count');

        // Destination course info elements
        const destinationCourseInfo = document.getElementById('destination-course-info');
        const destinationCourseType = document.getElementById('destination-course-type');
        const destinationNotesCount = document.getElementById('destination-notes-count');
        const destinationTasksCount = document.getElementById('destination-tasks-count');

        // Initialize the page
        document.addEventListener('DOMContentLoaded', async () => {
            await fetchOfferedCourses();
            setupEventListeners();
        });

        // Fetch offered courses data
        async function fetchOfferedCourses() {
            showLoading();
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Hod/offered-courses/grouped`);
                
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                if (!data.status) throw new Error(data.message);

                offeredCoursesData = data.data;
                populateSourceSessionSelect();
                populateDestinationSessionSelect();
                
                showToast('Courses data loaded successfully', 'success');
            } catch (error) {
                console.error('Error fetching offered courses:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
            }
        }

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

        // Setup event listeners
        function setupEventListeners() {
            // Mode toggle buttons
            autoModeBtn.addEventListener('click', () => {
                isAutoMode = true;
                autoModeBtn.classList.add('active');
                manualModeBtn.classList.remove('active');
                updateDestinationDropdowns();
            });

            manualModeBtn.addEventListener('click', () => {
                isAutoMode = false;
                manualModeBtn.classList.add('active');
                autoModeBtn.classList.remove('active');
                updateDestinationDropdowns();
            });

            // Source session change
            sourceSessionSelect.addEventListener('change', (e) => {
                const sessionId = e.target.value;
                populateSourceCourseSelect(sessionId);
                sourceCourseSelect.value = '';
                sourceCourseInfo.classList.add('hidden');
                updateCopyButtonState();
            });

            // Source course change
            sourceCourseSelect.addEventListener('change', (e) => {
                const sessionId = sourceSessionSelect.value;
                const courseId = e.target.value;
                updateSourceCourseInfo(sessionId, courseId);
                updateDestinationDropdowns();
                updateCopyButtonState();
            });

            // Destination session change
            destinationSessionSelect.addEventListener('change', (e) => {
                const sessionId = e.target.value;
                populateDestinationCourseSelect(sessionId);
                destinationCourseSelect.value = '';
                destinationCourseInfo.classList.add('hidden');
                updateCopyButtonState();
            });

            // Destination course change
            destinationCourseSelect.addEventListener('change', (e) => {
                const sessionId = destinationSessionSelect.value;
                const courseId = e.target.value;
                updateDestinationCourseInfo(sessionId, courseId);
                updateCopyButtonState();
            });

            // Copy content button
            copyContentBtn.addEventListener('click', handleCopyContent);
        }

        // Populate source session dropdown
        function populateSourceSessionSelect() {
            sourceSessionSelect.innerHTML = '<option value="">Select a session</option>';
            
            offeredCoursesData.forEach(session => {
                const option = document.createElement('option');
                option.value = session.session_id;
                option.textContent = session.session;
                sourceSessionSelect.appendChild(option);
            });
        }

        // Populate source course dropdown based on selected session
        function populateSourceCourseSelect(sessionId) {
            sourceCourseSelect.innerHTML = '<option value="">Select a course</option>';
            
            if (!sessionId) {
                sourceCourseSelect.disabled = true;
                return;
            }

            const session = offeredCoursesData.find(s => s.session_id == sessionId);
            if (!session) return;

            session.courses.forEach(course => {
                const option = document.createElement('option');
                option.value = course.course_id;
                option.textContent = course.course;
                option.dataset.offeredCourseId = course.offered_course_id;
                sourceCourseSelect.appendChild(option);
            });

            sourceCourseSelect.disabled = false;
        }

        // Populate destination session dropdown (excluding the source session)
        function populateDestinationSessionSelect() {
            destinationSessionSelect.innerHTML = '<option value="">Select a session</option>';
            
            offeredCoursesData.forEach(session => {
                if (session.session_id != sourceSessionSelect.value) {
                    const option = document.createElement('option');
                    option.value = session.session_id;
                    option.textContent = session.session;
                    destinationSessionSelect.appendChild(option);
                }
            });

            destinationSessionSelect.disabled = sourceSessionSelect.value === '';
        }

        // Populate destination course dropdown based on selected session
        function populateDestinationCourseSelect(sessionId) {
            destinationCourseSelect.innerHTML = '<option value="">Select a course</option>';
            
            if (!sessionId) {
                destinationCourseSelect.disabled = true;
                return;
            }

            const session = offeredCoursesData.find(s => s.session_id == sessionId);
            if (!session) return;

            if (isAutoMode && sourceCourseId) {
                // In auto mode, only show courses with the same course_id as the source
                const matchingCourse = session.courses.find(c => c.course_id == sourceCourseId);
                if (matchingCourse) {
                    const option = document.createElement('option');
                    option.value = matchingCourse.course_id;
                    option.textContent = matchingCourse.course;
                    option.dataset.offeredCourseId = matchingCourse.offered_course_id;
                    destinationCourseSelect.appendChild(option);
                }
            } else {
                // In manual mode, show all courses except the one selected in source
                session.courses.forEach(course => {
                    if (course.course_id != sourceCourseId) {
                        const option = document.createElement('option');
                        option.value = course.course_id;
                        option.textContent = course.course;
                        option.dataset.offeredCourseId = course.offered_course_id;
                        destinationCourseSelect.appendChild(option);
                    }
                });
            }

            destinationCourseSelect.disabled = false;
        }

        // Update source course info display
        function updateSourceCourseInfo(sessionId, courseId) {
            if (!sessionId || !courseId) {
                sourceCourseInfo.classList.add('hidden');
                sourceCourseId = null;
                return;
            }

            const session = offeredCoursesData.find(s => s.session_id == sessionId);
            if (!session) return;

            const course = session.courses.find(c => c.course_id == courseId);
            if (!course) return;

            sourceCourseType.textContent = course.isLab === 'Yes' ? 'Lab Course' : 'Theory Course';
            sourceNotesCount.textContent = course.Notes_Count;
            sourceTasksCount.textContent = course.Task_Count;
            sourceCourseInfo.classList.remove('hidden');

            // Store the source course ID for filtering destination courses
            sourceCourseId = courseId;
        }

        // Update destination course info display
        function updateDestinationCourseInfo(sessionId, courseId) {
            if (!sessionId || !courseId) {
                destinationCourseInfo.classList.add('hidden');
                return;
            }

            const session = offeredCoursesData.find(s => s.session_id == sessionId);
            if (!session) return;

            const course = session.courses.find(c => c.course_id == courseId);
            if (!course) return;

            destinationCourseType.textContent = course.isLab === 'Yes' ? 'Lab Course' : 'Theory Course';
            destinationNotesCount.textContent = course.Notes_Count;
            destinationTasksCount.textContent = course.Task_Count;
            destinationCourseInfo.classList.remove('hidden');
        }

        // Update destination dropdowns based on source selection
        function updateDestinationDropdowns() {
            if (!sourceSessionSelect.value || !sourceCourseSelect.value) {
                destinationSessionSelect.disabled = true;
                destinationCourseSelect.disabled = true;
                destinationSessionSelect.value = '';
                destinationCourseSelect.value = '';
                destinationCourseInfo.classList.add('hidden');
                return;
            }

            // Enable destination session select and repopulate
            destinationSessionSelect.disabled = false;
            populateDestinationSessionSelect();
            destinationSessionSelect.value = '';
            destinationCourseSelect.value = '';
            destinationCourseInfo.classList.add('hidden');
        }

        // Update copy button state based on selections
        function updateCopyButtonState() {
            const sourceSession = sourceSessionSelect.value;
            const sourceCourse = sourceCourseSelect.value;
            const destSession = destinationSessionSelect.value;
            const destCourse = destinationCourseSelect.value;

            // Check if source has content to copy
            let hasContent = false;
            if (sourceSession && sourceCourse) {
                const session = offeredCoursesData.find(s => s.session_id == sourceSession);
                if (session) {
                    const course = session.courses.find(c => c.course_id == sourceCourse);
                    if (course && (course.Notes_Count > 0 || course.Task_Count > 0)) {
                        hasContent = true;
                    }
                }
            }

            copyContentBtn.disabled = !(sourceSession && sourceCourse && destSession && destCourse && hasContent);
        }

        // Handle copy content action
        async function handleCopyContent() {
            const sourceSessionId = sourceSessionSelect.value;
            const sourceCourseId = sourceCourseSelect.value;
            const destinationSessionId = destinationSessionSelect.value;
            const destinationCourseId = destinationCourseSelect.value;

            if (!sourceSessionId || !sourceCourseId || !destinationSessionId || !destinationCourseId) {
                showToast('Please select both source and destination sessions and courses', 'warning');
                return;
            }

            showLoading();
            try {
                const response = await fetch(`${API_BASE_URL}api/Hod/content/copy`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        course_id: sourceCourseId,
                        source_session_id: sourceSessionId,
                        destination_session_id: destinationSessionId
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || data.message || 'Failed to copy content');
                }

                // Display results
                displayCopyResults(data);
                showToast('Content copied successfully', 'success');
                
                // Update the destination course info (counts may have changed)
                const destSession = offeredCoursesData.find(s => s.session_id == destinationSessionId);
                if (destSession) {
                    const destCourse = destSession.courses.find(c => c.course_id == destinationCourseId);
                    if (destCourse) {
                        // Increment counts based on source
                        const srcSession = offeredCoursesData.find(s => s.session_id == sourceSessionId);
                        if (srcSession) {
                            const srcCourse = srcSession.courses.find(c => c.course_id == sourceCourseId);
                            if (srcCourse) {
                                destCourse.Notes_Count += srcCourse.Notes_Count;
                                destCourse.Task_Count += srcCourse.Task_Count;
                                updateDestinationCourseInfo(destinationSessionId, destinationCourseId);
                            }
                        }
                    }
                }
            } catch (error) {
                console.error('Error copying content:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
            }
        }

        // Display copy results in the table
        function displayCopyResults(data) {
            resultsTableBody.innerHTML = '';
            
            if (data.success && data.success.length > 0) {
                data.success.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><span class="status-badge ${item.status === 'success' ? 'status-success' : 'status-skipped'}">${item.status}</span></td>
                        <td>${item.message}</td>
                    `;
                    resultsTableBody.appendChild(row);
                });
            }
            
            if (data.errors && data.errors.length > 0) {
                data.errors.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><span class="status-badge status-error">error</span></td>
                        <td>${item.message}</td>
                    `;
                    resultsTableBody.appendChild(row);
                });
            }
            
            resultsSection.classList.remove('hidden');
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
            }
        }
    </script>
</body>
</html>