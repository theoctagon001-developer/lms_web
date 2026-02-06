<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Audit Report</title>
    @vite('resources/css/app.css')
    <style>
        :root {
            --primary-color: #4361EE;
            --active-color: #4CC9F0;
            --previous-color: #6C757D;
            --light-background: #F8F9FA;
            --text-primary: #212529;
            --text-secondary: #6C757D;
            --success-color: #28A745;
            --warning-color: #FFC107;
            --danger-color: #DC3545;
            --card-background: #FFFFFF;
            --info-color: #17A2B8;
        }

        /* Common Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
            display: none;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Button Styles */
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #3A56D4;
        }
        
        .btn-refresh {
            background-color: var(--info-color);
            color: white;
        }
        
        .btn-refresh:hover {
            background-color: #148A9C;
        }
        
        /* Card Styles */
        .info-card {
            background-color: var(--card-background);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 16px;
            margin-bottom: 16px;
        }
        
        /* Table Styles */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .report-table th {
            background-color: var(--primary-color);
            color: white;
            padding: 12px;
            text-align: left;
            position: sticky;
            top: 0;
        }
        
        .report-table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .report-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .report-table tr:hover {
            background-color: #f1f5f9;
        }
        
        /* Status Indicators */
        .status-covered {
            color: var(--success-color);
        }
        
        .status-not-covered {
            color: var(--danger-color);
        }
        
        .status-warning {
            color: var(--warning-color);
        }
        
        /* Week Header */
        .week-header {
            background-color: #E7F5FF;
            font-weight: bold;
        }
        
        /* Coverage Percentage */
        .coverage-cell {
            font-weight: bold;
        }
        
        .coverage-high {
            color: var(--success-color);
        }
        
        .coverage-medium {
            color: var(--warning-color);
        }
        
        .coverage-low {
            color: var(--danger-color);
        }
        
        /* Task Count Styles */
        .task-count {
            font-weight: bold;
        }
        
        .task-below-limit {
            background-color: rgba(255, 193, 7, 0.2);
        }
        
        .task-no-limit {
            background-color: rgba(23, 162, 184, 0.1);
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .report-table {
                display: block;
                overflow-x: auto;
            }
            
            .filter-container .grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Section Header */
        .section-header {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
            margin: 20px 0 10px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--primary-color);
        }
        
        /* Dropdown Styles */
        .dropdown-select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ced4da;
            background-color: white;
        }
        
        /* Alert Styles */
        .alert-error {
            padding: 15px;
            background-color: #F8D7DA;
            color: #721C24;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #F5C6CB;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-secondary);
        }
        
        /* Fixed column widths */
        .topic-column {
            min-width: 250px;
        }
        
        /* Filter checkbox */
        .common-covered-filter {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .common-covered-filter input {
            margin-right: 8px;
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('DATACELL.partials.nav')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-6">HOD Audit Report</h2>
        <div class="filter-container bg-white p-4 rounded-lg shadow-md mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Session</label>
                    <select id="session-select" class="dropdown-select" onchange="loadCoursesBySession()">
                        <option value="">Select Session</option>
                        <!-- Will be populated by API -->
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Course</label>
                    <select id="course-select" class="dropdown-select" disabled>
                        <option value="">Select Session First</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button id="fetch-report-btn" class="btn-primary px-4 py-2 rounded-lg w-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                        </svg>
                        Fetch Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Report Type Selector -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            <label class="block text-sm font-medium text-gray-600 mb-2">Report Type</label>
            <div class="flex space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" class="form-radio text-blue-600" name="report-type" value="full" checked>
                    <span class="ml-2">Full Report</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" class="form-radio text-blue-600" name="report-type" value="content">
                    <span class="ml-2">Course Content</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" class="form-radio text-blue-600" name="report-type" value="task">
                    <span class="ml-2">Task Conducted</span>
                </label>
            </div>
        </div>

        <!-- Week Filter (shown only for content report) -->
        <div id="week-filter-container" class="bg-white p-4 rounded-lg shadow-md mb-6 hidden">
            <label class="block text-sm font-medium text-gray-600 mb-2">Week Filter</label>
            <select id="week-select" class="dropdown-select">
                <option value="all">All Weeks</option>
                <!-- Will be populated dynamically -->
            </select>
        </div>

        <!-- Main Content Area -->
        <div id="content-area">
            <!-- Course Info Card -->
            <div id="course-info-card" class="info-card hidden">
                <h3 class="text-lg font-semibold text-blue-700 mb-4">Course Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Session</p>
                        <p id="session-name" class="font-medium"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Course</p>
                        <p id="course-name" class="font-medium"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Has Lab</p>
                        <p id="course-has-lab" class="font-medium"></p>
                    </div>
                </div>
            </div>

            <!-- Error Message -->
            <div id="error-message" class="alert-error hidden"></div>

            <!-- Loader -->
            <div id="loader" class="loader"></div>

            <!-- Empty State -->
            <div id="empty-state" class="empty-state hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No report data</h3>
                <p class="mt-1 text-gray-500">Select a session and course to view the audit report.</p>
            </div>

            <!-- Content Report Section -->
            <div id="content-report-section" class="hidden">
                <div class="common-covered-filter">
                    <input type="checkbox" id="common-covered-checkbox" onchange="renderContentReport()">
                    <label for="common-covered-checkbox">Include Only Common Covered Topics</label>
                </div>
                <h3 class="section-header">Course Content Report</h3>
                <div class="overflow-x-auto">
                    <table id="content-report-table" class="report-table">
                        <!-- Content will be loaded dynamically -->
                    </table>
                </div>
            </div>

            <!-- Task Report Section -->
            <div id="task-report-section" class="hidden">
                <h3 class="section-header">Task Conducted Report</h3>
                <div class="overflow-x-auto">
                    <table id="task-report-table" class="report-table">
                        <!-- Content will be loaded dynamically -->
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Breakdown Modal -->
    <div id="task-breakdown-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Task Breakdown</h3>
                <button onclick="closeModal('task-breakdown-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <p id="breakdown-teacher" class="text-sm text-gray-600"></p>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                    <span class="font-medium">By Teacher</span>
                    <span id="by-teacher-count" class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">0</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                    <span class="font-medium">By Junior Lecturer</span>
                    <span id="by-junior-count" class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">0</span>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeModal('task-breakdown-modal')" class="px-4 py-2 bg-gray-500 text-white rounded-md">Close</button>
            </div>
        </div>
    </div>

    <script>
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
          const programId = "{{ session('program_id') }}";
        let allOfferedCourses = [];
        let currentReportData = null;
        let currentCourseHasLab = false;

        // Initialize the page
        document.addEventListener("DOMContentLoaded", function() {
            loadSessions();
            
            // Set up event listeners
            document.getElementById('fetch-report-btn').addEventListener('click', fetchAuditReport);
            
            // Report type radio buttons
            document.querySelectorAll('input[name="report-type"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    updateReportVisibility();
                });
            });
            
            // Week filter change
            document.getElementById('week-select').addEventListener('change', function() {
                renderContentReport();
            });
        });

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }
        async function loadSessions() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Dropdown/Program/AllOfferedCourse/${programId}`);
                const data = await response.json();
                
                if (data && data.length > 0) {
                    allOfferedCourses = data;
                    
                    // Extract unique sessions
                    const sessionsMap = new Map();
                    data.forEach(course => {
                        const sessionKey = course.session;
                        if (!sessionsMap.has(sessionKey)) {
                            sessionsMap.set(sessionKey, {
                                name: course.session,
                                id: course.session
                            });
                        }
                    });
                    
                    // Populate session dropdown
                    const sessionSelect = document.getElementById('session-select');
                    sessionsMap.forEach(session => {
                        const option = document.createElement('option');
                        option.value = session.name;
                        option.textContent = session.name;
                        sessionSelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error("Error loading sessions:", error);
                showError("Failed to load sessions. Please try again.");
            }
        }

        // Load courses based on selected session
        function loadCoursesBySession() {
            const sessionSelect = document.getElementById('session-select');
            const courseSelect = document.getElementById('course-select');
            
            courseSelect.innerHTML = '<option value="">Select Course</option>';
            courseSelect.disabled = true;
            
            const selectedSession = sessionSelect.value;
            if (!selectedSession) return;
            
            // Filter courses for selected session
            const sessionCourses = allOfferedCourses.filter(course => course.session === selectedSession);
            
            if (sessionCourses.length > 0) {
                sessionCourses.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course.id;
                    option.textContent = course.course;
                    courseSelect.appendChild(option);
                });
                courseSelect.disabled = false;
            }
        }

        // Fetch audit report data
        async function fetchAuditReport() {
            const courseSelect = document.getElementById('course-select');
            const courseId = courseSelect.value;
            
            if (!courseId) {
                showError("Please select a course first");
                return;
            }
            
            try {
                showLoader();
                hideError();
                document.getElementById('empty-state').classList.add('hidden');
                
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Hod/course/audit?offered_course_id=${courseId}`);
                const data = await response.json();
                
                if (data.status === true) {
                    currentReportData = data;
                    currentCourseHasLab = data.Course_Info.Course_Has_Lab === 'Yes';
                    
                    // Show course info
                    displayCourseInfo(data.Course_Info);
                    
                    // Prepare week filter if content exists
                    if (data.Course_Content_Report && Object.keys(data.Course_Content_Report).length > 0) {
                        prepareWeekFilter(data.Course_Content_Report);
                    }
                    
                    // Render reports
                    updateReportVisibility();
                    
                    // Show content area
                    document.getElementById('course-info-card').classList.remove('hidden');
                } else {
                    showError(data.message || "Failed to load audit report");
                }
            } catch (error) {
                console.error("Error fetching audit report:", error);
                showError("An error occurred while fetching the audit report");
            } finally {
                hideLoader();
            }
        }

        // Display course information
        function displayCourseInfo(courseInfo) {
            document.getElementById('session-name').textContent = courseInfo['Session Name'] || 'N/A';
            document.getElementById('course-name').textContent = courseInfo['Course Name'] || 'N/A';
            document.getElementById('course-has-lab').textContent = courseInfo['Course_Has_Lab'] || 'No';
        }

        // Prepare week filter dropdown
        function prepareWeekFilter(contentReport) {
            const weekSelect = document.getElementById('week-select');
            
            // Clear existing options except "All Weeks"
            while (weekSelect.options.length > 1) {
                weekSelect.remove(1);
            }
            
            // Get all weeks from the first section's content
            const firstSection = Object.values(contentReport)[0];
            if (firstSection && firstSection.content) {
                const weeks = Object.keys(firstSection.content).sort((a, b) => parseInt(a) - parseInt(b));
                
                weeks.forEach(week => {
                    const option = document.createElement('option');
                    option.value = week;
                    option.textContent = `Week ${week}`;
                    weekSelect.appendChild(option);
                });
            }
            
            // Show week filter container
            document.getElementById('week-filter-container').classList.remove('hidden');
        }

        // Update which reports are visible based on selected report type
        function updateReportVisibility() {
            const reportType = document.querySelector('input[name="report-type"]:checked').value;
            
            // Hide both sections first
            document.getElementById('content-report-section').classList.add('hidden');
            document.getElementById('task-report-section').classList.add('hidden');
            
            // Show selected sections
            if (reportType === 'full' || reportType === 'content') {
                renderContentReport();
                document.getElementById('content-report-section').classList.remove('hidden');
                document.getElementById('week-filter-container').classList.remove('hidden');
            }
            
            if (reportType === 'full' || reportType === 'task') {
                renderTaskReport();
                document.getElementById('task-report-section').classList.remove('hidden');
            }
            
            // Hide week filter for task-only reports
            if (reportType === 'task') {
                document.getElementById('week-filter-container').classList.add('hidden');
            }
        }

        // Render content report table
        function renderContentReport() {
            if (!currentReportData || !currentReportData.Course_Content_Report) return;
            
            const contentReport = currentReportData.Course_Content_Report;
            const selectedWeek = document.getElementById('week-select').value;
            const showOnlyCommonCovered = document.getElementById('common-covered-checkbox').checked;
            const table = document.getElementById('content-report-table');
            
            // Clear existing content
            table.innerHTML = '';
            
            // Get all sections
            const sections = Object.keys(contentReport);
            if (sections.length === 0) return;
            
            // Create table header
            const thead = document.createElement('thead');
            let headerRow = '<tr><th class="topic-column">Topics</th>';
            
            sections.forEach(section => {
                headerRow += `<th>${section}<br><span class="text-xs">${contentReport[section].teacher_name}</span></th>`;
            });
            
            headerRow += '</tr>';
            thead.innerHTML = headerRow;
            table.appendChild(thead);
            
            // Create table body
            const tbody = document.createElement('tbody');
            
            if (selectedWeek === 'all') {
                // Show all weeks with week headers
                const firstSection = contentReport[sections[0]];
                const weeks = Object.keys(firstSection.content).sort((a, b) => parseInt(a) - parseInt(b));
                
                weeks.forEach(week => {
                    // Add week header row
                    const weekHeaderRow = document.createElement('tr');
                    weekHeaderRow.className = 'week-header';
                    let weekHeader = `<td colspan="${sections.length + 1}">Week ${week}</td>`;
                    weekHeaderRow.innerHTML = weekHeader;
                    tbody.appendChild(weekHeaderRow);
                    
                    // Get all topics for this week across all sections
                    const weekTopics = new Set();
                    sections.forEach(section => {
                        const weekContents = contentReport[section].content[week] || [];
                        weekContents.forEach(content => {
                            (content.topics || []).forEach(topic => {
                                weekTopics.add(topic.topic_name);
                            });
                        });
                    });
                    
                    // Add rows for each topic
                    weekTopics.forEach(topicName => {
                        // Check if topic is covered in all sections
                        let isCommonCovered = true;
                        const topicCoverage = {};
                        
                        sections.forEach(section => {
                            const sectionData = contentReport[section];
                            const weekContents = sectionData.content[week] || [];
                            let isCovered = false;
                            
                            // Check if topic is covered in this section
                            for (const content of weekContents) {
                                const topic = (content.topics || []).find(t => t.topic_name === topicName);
                                if (topic) {
                                    isCovered = topic.status === 'Covered';
                                    break;
                                }
                            }
                            
                            topicCoverage[section] = isCovered;
                            if (!isCovered) {
                                isCommonCovered = false;
                            }
                        });
                        
                        // Skip this topic if we're only showing common covered and it's not common covered
                        if (showOnlyCommonCovered && !isCommonCovered) {
                            return;
                        }
                        
                        const topicRow = document.createElement('tr');
                        let topicCells = `<td class="topic-column">${topicName}</td>`;
                        
                        sections.forEach(section => {
                            const isCovered = topicCoverage[section];
                            topicCells += `<td class="text-center ${isCovered ? 'status-covered' : 'status-not-covered'}">
                                ${isCovered ? '✓' : '✗'}
                            </td>`;
                        });
                        
                        topicRow.innerHTML = topicCells;
                        tbody.appendChild(topicRow);
                    });
                });
            } else {
                // Show only selected week
                const weekTopics = new Set();
                sections.forEach(section => {
                    const weekContents = contentReport[section].content[selectedWeek] || [];
                    weekContents.forEach(content => {
                        (content.topics || []).forEach(topic => {
                            weekTopics.add(topic.topic_name);
                        });
                    });
                });
                
                // Add rows for each topic
                weekTopics.forEach(topicName => {
                    // Check if topic is covered in all sections
                    let isCommonCovered = true;
                    const topicCoverage = {};
                    
                    sections.forEach(section => {
                        const sectionData = contentReport[section];
                        const weekContents = sectionData.content[selectedWeek] || [];
                        let isCovered = false;
                        
                        // Check if topic is covered in this section
                        for (const content of weekContents) {
                            const topic = (content.topics || []).find(t => t.topic_name === topicName);
                            if (topic) {
                                isCovered = topic.status === 'Covered';
                                break;
                            }
                        }
                        
                        topicCoverage[section] = isCovered;
                        if (!isCovered) {
                            isCommonCovered = false;
                        }
                    });
                    
                    // Skip this topic if we're only showing common covered and it's not common covered
                    if (showOnlyCommonCovered && !isCommonCovered) {
                        return;
                    }
                    
                    const topicRow = document.createElement('tr');
                    let topicCells = `<td class="topic-column">${topicName}</td>`;
                    
                    sections.forEach(section => {
                        const isCovered = topicCoverage[section];
                        topicCells += `<td class="text-center ${isCovered ? 'status-covered' : 'status-not-covered'}">
                            ${isCovered ? '✓' : '✗'}
                        </td>`;
                    });
                    
                    topicRow.innerHTML = topicCells;
                    tbody.appendChild(topicRow);
                });
            }
            
            // Add coverage percentage row
            const percentageRow = document.createElement('tr');
            let percentageCells = '<td class="font-bold">Coverage %</td>';
            
            sections.forEach(section => {
                const sectionData = contentReport[section];
                let totalTopics = 0;
                let coveredTopics = 0;
                
                // Calculate coverage based on selected week
                if (selectedWeek === 'all') {
                    // Calculate for all weeks
                    Object.values(sectionData.content).forEach(weekContents => {
                        weekContents.forEach(content => {
                            (content.topics || []).forEach(topic => {
                                totalTopics++;
                                if (topic.status === 'Covered') coveredTopics++;
                            });
                        });
                    });
                } else {
                    // Calculate for selected week only
                    const weekContents = sectionData.content[selectedWeek] || [];
                    weekContents.forEach(content => {
                        (content.topics || []).forEach(topic => {
                            totalTopics++;
                            if (topic.status === 'Covered') coveredTopics++;
                        });
                    });
                }
                
                const percentage = totalTopics > 0 ? Math.round((coveredTopics / totalTopics) * 100) : 0;
                let percentageClass = 'coverage-low';
                if (percentage >= 80) percentageClass = 'coverage-high';
                else if (percentage >= 50) percentageClass = 'coverage-medium';
                
                percentageCells += `<td class="coverage-cell ${percentageClass}">${percentage}%</td>`;
            });
            
            percentageRow.innerHTML = percentageCells;
            tbody.appendChild(percentageRow);
            
            table.appendChild(tbody);
        }

        // Render task report table
        function renderTaskReport() {
            if (!currentReportData || !currentReportData.Task_Report) return;
            
            const taskReport = currentReportData.Task_Report;
            const table = document.getElementById('task-report-table');
            
            // Clear existing content
            table.innerHTML = '';
            
            // Get all sections
            const sections = Object.keys(taskReport);
            if (sections.length === 0) return;
            
            // Define task types (add LabTask if course has lab)
            const taskTypes = ['Quiz', 'Assignment'];
            if (currentCourseHasLab) taskTypes.push('LabTask');
            
            // Create table header
            const thead = document.createElement('thead');
            let headerRow = '<tr><th>Section</th>';
            
            taskTypes.forEach(type => {
                headerRow += `<th>${type}</th>`;
            });
            
            headerRow += '</tr>';
            thead.innerHTML = headerRow;
            table.appendChild(thead);
            
            // Create table body
            const tbody = document.createElement('tbody');
            
            sections.forEach(section => {
                const sectionData = taskReport[section];
                const sectionRow = document.createElement('tr');
                let sectionCells = `<td>${section}<br><span class="text-xs">${sectionData.name}</span></td>`;
                taskTypes.forEach(type => {
                    const taskData = sectionData.tasks[type] || {};
                    const totalCount = taskData.total_count || 0;
                    const limit = taskData.limit;
                    const isBelowLimit = limit !== null && totalCount < limit;
                    const isLimitless = limit === null;
                    
                    // Determine cell class based on limit status
                    let cellClass = '';
                    if (isBelowLimit) cellClass = 'task-below-limit';
                    if (isLimitless) cellClass = 'task-no-limit';
                    
                    // Create cell content
                    let cellContent = `${totalCount}`;
                    if (limit !== null) cellContent += ` / ${limit}`;
                    
                    
                    if (currentCourseHasLab ) {
                        cellContent += ` <span class="cursor-pointer text-blue-500" 
                            onclick="showTaskBreakdown('${sectionData.name}', ${taskData.ByTeacher || 0}, ${taskData.ByJunior || 0})">
                            ⓘ</span>`;
                    }
                    
                    sectionCells += `<td class="${cellClass}">${cellContent}</td>`;
                });
                
                sectionRow.innerHTML = sectionCells;
                tbody.appendChild(sectionRow);
            });
            
            table.appendChild(tbody);
        }

        // Show task breakdown modal
        function showTaskBreakdown(teacherName, byTeacher, byJunior) {
            document.getElementById('breakdown-teacher').textContent = teacherName;
            document.getElementById('by-teacher-count').textContent = byTeacher;
            document.getElementById('by-junior-count').textContent = byJunior;
            document.getElementById('task-breakdown-modal').style.display = 'flex';
        }

        // Close modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Show loader
        function showLoader() {
            document.getElementById('loader').style.display = 'block';
        }

        // Hide loader
        function hideLoader() {
            document.getElementById('loader').style.display = 'none';
        }

        // Show error message
        function showError(message) {
            const errorElement = document.getElementById('error-message');
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }

        // Hide error message
        function hideError() {
            document.getElementById('error-message').classList.add('hidden');
        }
    </script>

    @include('components.footer')
</body>

</html>