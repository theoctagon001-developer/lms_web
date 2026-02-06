<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #1e293b;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background-color: #f1f5f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* New Top Bar Styles */
        .top-bar {
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: white;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            padding: 0.75rem 0;
        }

        .top-bar-container {
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #4f46e5;
        }

        .profile-panel {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .profile-img {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 9999px;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        .profile-info {
            display: none;
        }

        @media (min-width: 768px) {
            .profile-info {
                display: block;
            }
            .top-bar-container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        /* Footer Styles */
        .footer {
            background-color: white;
            padding: 1rem 0;
            margin-top: auto;
            border-top: 1px solid #e5e7eb;
        }

        .footer-content {
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
            text-align: center;
        }

        .footer-copyright {
            font-size: 0.875rem;
            color: #6b7280;
        }

        /* Card Styles */
        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Tab Styles */
        .tab-btn {
            position: relative;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            color: var(--secondary);
            transition: all 0.2s ease;
        }

        .tab-btn:hover {
            color: var(--primary);
        }

        .tab-btn.active {
            color: var(--primary);
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--primary);
        }

        /* Avatar Styles */
        .avatar {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .avatar-initials {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e2e8f0;
            color: #475569;
            font-weight: 600;
        }

        /* Badge Styles */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Progress Bar Styles */
        .progress-bar {
            height: 0.5rem;
            border-radius: 0.25rem;
            background-color: #e2e8f0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 0.25rem;
        }

        /* Input Styles */
        .search-input {
            transition: all 0.2s ease;
            border: 1px solid #e2e8f0;
        }

        .search-input:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 0.75rem 1rem;
            text-align: left;
        }

        .table td {
            vertical-align: middle;
            border-top: 1px solid #f1f5f9;
            padding: 0.75rem 1rem;
        }

        .table tr:hover td {
            background-color: #f8fafc;
        }

        .highlight-row {
            background-color: #f0fdf4;
        }

        .low-percentage {
            background-color: #fef2f2;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .card {
                border-radius: 0;
                box-shadow: none;
                border: 1px solid #e2e8f0;
            }

            .tab-btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }

            .avatar {
                width: 2.5rem;
                height: 2.5rem;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table th, .table td {
                padding: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- New Top Navigation Bar -->
    <header class="top-bar">
        <div class="top-bar-container">
            <div class="flex items-center">
                <h1 class="top-bar-title">
                    Teacher <span class="hidden sm:inline">Dashboard</span>
                </h1>
            </div>
            <div class="profile-panel">
                <img src="{{ session('profileImage', asset('images/male.png')) }}" 
                     alt="Profile" class="profile-img">
                <div class="profile-info">
                    <p class="text-sm font-medium text-gray-700">{{ session('username', 'Guest') }}</p>
                    <p class="text-xs text-gray-500">{{ session('designation', 'Teacher') }}</p>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Course Header Card -->
            <div class="card p-6 mb-6">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- Teacher Info -->
                    <div class="flex flex-col items-center text-center">
                        <img src="{{ $course['TeacherPhoto'] ?? asset('images/male.png') }}" 
                             alt="Teacher" class="avatar">
                        <h3 class="mt-2 font-semibold text-gray-900">{{ $course['Teacher'] ?? 'N/A' }}</h3>
                        <p class="text-sm text-gray-500">Teacher</p>
                    </div>

                    <!-- Course Info -->
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $course['CourseName'] ?? 'N/A' }}</h1>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Course Code</p>
                                <p class="font-medium">{{ $course['CourseCode'] ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Session</p>
                                <p class="font-medium">{{ $course['SessionName'] ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Section</p>
                                <p class="font-medium">{{ $course['Section_name'] ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Enrollments</p>
                                <p class="font-medium">{{ $course['total_enrollments'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Junior Lecturer (if applicable) -->
                    @if ($course['JuniorLecturer'] !== 'Non-Lab')
                    <div class="flex flex-col items-center text-center">
                        <img src="{{ $course['JuniorPhoto'] ?? asset('images/male.png') }}" 
                             alt="Junior Lecturer" class="avatar">
                        <h3 class="mt-2 font-semibold text-gray-900">{{ $course['JuniorLecturer'] }}</h3>
                        <p class="text-sm text-gray-500">Junior Lecturer</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="flex overflow-x-auto border-b border-gray-200 mb-6">
                <button class="tab-btn active" onclick="showTab('attendance')">Attendance</button>
                <button class="tab-btn" onclick="showTab('task')">Task Results</button>
                <button class="tab-btn" onclick="showTab('exam')">Exam Results</button>
            </div>

            <!-- Tab Contents -->
            <div>
                <!-- Attendance Tab -->
                <div id="attendance" class="tab-content">
                    <div class="card p-6 mb-4">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                            <div class="flex flex-wrap gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Lectures</p>
                                    <p class="font-medium"><span id="totalLectures">0</span></p>
                                </div>
                                <div id="totalLabsContainer" class="hidden">
                                    <p class="text-sm text-gray-500">Labs</p>
                                    <p class="font-medium"><span id="totalLabs">0</span></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Classes</p>
                                    <p class="font-medium"><span id="totalClasses">0</span></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <input type="text" id="searchInput" placeholder="Search by name or RegNo" 
                                       class="search-input flex-grow sm:w-64 px-4 py-2 rounded-lg">
                                <button id="sortButton" class="bg-white border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50">
                                    Sort by %
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left"></th>
                                        <th class="px-4 py-3 text-left">Student</th>
                                        <th class="px-4 py-3 text-center">RegNo</th>
                                        <th class="px-4 py-3 text-center">Attended</th>
                                        <th class="px-4 py-3 text-center">%</th>
                                        <th id="labAttendedHeader" class="px-4 py-3 text-center hidden">Labs</th>
                                        <th id="labPercentageHeader" class="px-4 py-3 text-center hidden">Lab %</th>
                                        <th class="px-4 py-3 text-center">Total</th>
                                        <th class="px-4 py-3 text-center">Total %</th>
                                        <th class="px-4 py-3 text-center">Absent</th>
                                    </tr>
                                </thead>
                                <tbody id="attendanceTableBody" class="divide-y divide-gray-200">
                                    <!-- Data will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Task Results Tab -->
                <div id="task" class="tab-content hidden">
                    <div class="card p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                            <h2 class="text-xl font-semibold text-gray-900">Task Results</h2>
                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <input type="text" id="taskSearch" placeholder="Search by name or RegNo" 
                                       class="search-input flex-grow sm:w-64 px-4 py-2 rounded-lg">
                                <button id="sortTaskButton" class="bg-white border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50">
                                    Sort by %
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left"></th>
                                        <th class="px-4 py-3 text-left">Student</th>
                                        <th class="px-4 py-3 text-center">RegNo</th>
                                        <th class="px-4 py-3 text-center">Assignment</th>
                                        <th class="px-4 py-3 text-center">Quiz</th>
                                        <th id="labTaskHeader" class="px-4 py-3 text-center hidden">Lab Task</th>
                                        <th class="px-4 py-3 text-center">Overall</th>
                                    </tr>
                                </thead>
                                <tbody id="taskResultsBody" class="divide-y divide-gray-200">
                                    <!-- Data will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Exam Results Tab -->
                <div id="exam" class="tab-content hidden">
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Exam Results</h2>
                        
                        <div class="flex flex-col sm:flex-row gap-4 mb-6">
                            <input type="text" id="examSearchInput" placeholder="Search by name or RegNo" 
                                   class="search-input flex-grow px-4 py-2 rounded-lg">
                            <select id="examFilter" class="search-input px-4 py-2 rounded-lg">
                                <option value="Mid">Mid Exam</option>
                                <option value="Final">Final Exam</option>
                            </select>
                        </div>
                        
                        <div id="examResults" class="space-y-4">
                            <p class="text-center text-gray-500">Loading exam results...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- New Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-copyright">
                © Sharjeel | Ali | Sameer - Learning Management System
            </div>
        </div>
    </footer>

    <script>
        // API Configuration
        let API_BASE_URL = "http://127.0.0.1:8000/";

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        // Tab Management
        function showTab(tabId) {
            // Update active tab styling
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`.tab-btn[onclick="showTab('${tabId}')"]`).classList.add('active');

            // Show selected tab content
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            document.getElementById(tabId).classList.remove('hidden');

            // Load data if needed
            if (tabId === 'attendance') {
                fetchAttendanceData();
            } else if (tabId === 'task') {
                fetchTaskResults();
            } else if (tabId === 'exam') {
                fetchExamResults();
            }
        }

        // Attendance Data
        async function fetchAttendanceData() {
            const teacherOfferedCourseId = `{{ $course['t_offered_course_id'] }}`;
            const isNonLab = `{{ $course['JuniorLecturer'] }}` === "Non-Lab";
            API_BASE_URL = await getApiBaseUrl();
            
            try {
                const response = await fetch(
                    `${API_BASE_URL}api/Teachers/section-attendance-list?teacher_offered_course_id=${teacherOfferedCourseId}`
                );
                const data = await response.json();

                // Update summary
                document.getElementById("totalLectures").textContent = data.total_conducted;
                document.getElementById("totalClasses").textContent = data.classes_conducted;
                
                if (!isNonLab) {
                    document.getElementById("totalLabsContainer").classList.remove("hidden");
                    document.getElementById("totalLabs").textContent = data.lab_conducted;
                    document.getElementById("labAttendedHeader").classList.remove("hidden");
                    document.getElementById("labPercentageHeader").classList.remove("hidden");
                }

                // Populate table
                const tableBody = document.getElementById("attendanceTableBody");
                tableBody.innerHTML = "";

                data.students.forEach(student => {
                    const absent = data.total_conducted - student.Lecture_Attended;
                    const percentageClass = student.Total_Percentage < 75 ? 'text-red-600' : 'text-green-600';
                    
                    const row = document.createElement('tr');
                    row.className = student.Total_Percentage < 75 ? 'low-percentage' : 'hover:bg-gray-50';
                    row.innerHTML = `
                        <td class="px-4 py-3">
                            ${student.Student_Image 
                                ? `<img src="${student.Student_Image}" class="avatar">`
                                : `<div class="avatar avatar-initials">${student.Student_Name.split(' ').map(n => n[0]).join('').toUpperCase()}</div>`}
                        </td>
                        <td class="px-4 py-3 font-medium">${student.Student_Name}</td>
                        <td class="px-4 py-3 text-center text-gray-500">${student.RegNo}</td>
                        <td class="px-4 py-3 text-center">${student.Lecture_Attended}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <span>${student.Lecture_Percentage}%</span>
                                <div class="progress-bar w-16">
                                    <div class="progress-fill bg-blue-500" style="width: ${student.Lecture_Percentage}%"></div>
                                </div>
                            </div>
                        </td>
                        ${!isNonLab ? `<td class="px-4 py-3 text-center">${student.Lab_Attended}</td>` : ''}
                        ${!isNonLab ? `<td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <span>${student.Lab_Percentage}%</span>
                                <div class="progress-bar w-16">
                                    <div class="progress-fill bg-purple-500" style="width: ${student.Lab_Percentage}%"></div>
                                </div>
                            </div>
                        </td>` : ''}
                        <td class="px-4 py-3 text-center">${student.Total_Attended_Lectures}</td>
                        <td class="px-4 py-3 text-center font-semibold ${percentageClass}">
                            <div class="flex items-center justify-center gap-2">
                                <span>${student.Total_Percentage}%</span>
                                <div class="progress-bar w-16">
                                    <div class="progress-fill ${student.Total_Percentage < 75 ? 'bg-red-500' : 'bg-green-500'}" 
                                         style="width: ${student.Total_Percentage}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">${absent}</td>
                    `;
                    tableBody.appendChild(row);
                });

                // Setup search functionality
                document.getElementById("searchInput").addEventListener("input", function() {
                    const searchValue = this.value.toLowerCase();
                    document.querySelectorAll("#attendanceTableBody tr").forEach(row => {
                        const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                        const regNo = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                        row.style.display = name.includes(searchValue) || regNo.includes(searchValue) ? '' : 'none';
                    });
                });

                // Setup sorting
                let sortAsc = true;
                document.getElementById("sortButton").addEventListener("click", function() {
                    const rows = Array.from(document.querySelectorAll("#attendanceTableBody tr"));
                    rows.sort((a, b) => {
                        const aPercentage = parseFloat(a.querySelector('td:nth-child(8)').textContent);
                        const bPercentage = parseFloat(b.querySelector('td:nth-child(8)').textContent);
                        return sortAsc ? aPercentage - bPercentage : bPercentage - aPercentage;
                    });
                    sortAsc = !sortAsc;
                    
                    // Re-append sorted rows
                    tableBody.innerHTML = '';
                    rows.forEach(row => tableBody.appendChild(row));
                });

            } catch (error) {
                console.error("Error fetching attendance data:", error);
                tableBody.innerHTML = `<tr><td colspan="10" class="text-center py-4 text-gray-500">Failed to load attendance data</td></tr>`;
            }
        }

        // Task Results Data
        let taskResultsData = [];
        let filteredtaskResultData = [];

        async function fetchTaskResults() {
            const courseId = `{{ $course['t_offered_course_id'] }}`;
            const isNonLab = `{{ $course['JuniorLecturer'] }}` === "Non-Lab";
            
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(
                    `${API_BASE_URL}api/Teachers/section-task-result?teacher_offered_course_id=${courseId}`
                );

                if (!response.ok) throw new Error("Failed to fetch task results");

                const result = await response.json();
                taskResultsData = result.Results || [];
                filteredtaskResultData = [...taskResultsData];
                renderTaskResults();

            } catch (error) {
                console.error("Error fetching task results:", error);
                document.getElementById("taskResultsBody").innerHTML = `
                    <tr>
                        <td colspan="${isNonLab ? 6 : 7}" class="text-center py-4 text-gray-500">
                            Failed to load task results
                        </td>
                    </tr>`;
            }
        }

        function renderTaskResults() {
            const tbody = document.getElementById("taskResultsBody");
            const isNonLab = `{{ $course['JuniorLecturer'] }}` === "Non-Lab";
            const labTaskHeader = document.getElementById("labTaskHeader");
            
            labTaskHeader.classList.toggle("hidden", isNonLab);
            tbody.innerHTML = "";

            filteredtaskResultData.forEach(student => {
                const overallPercentage = parseFloat(student["Overall_Percentage"]) || 0;
                const percentageClass = overallPercentage < 50 ? 'text-red-600' : 'text-green-600';
                
                const row = document.createElement('tr');
                row.className = overallPercentage < 50 ? 'low-percentage' : 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-4 py-3">
                        <img src="${student.image || `https://ui-avatars.com/api/?name=${student.Student_name}&background=random`}" 
                             class="avatar">
                    </td>
                    <td class="px-4 py-3 font-medium">${student.Student_name}</td>
                    <td class="px-4 py-3 text-center text-gray-500">${student.RegNo}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex flex-col items-center">
                            <span>${student["Assignment_Task_Obtained Marks"]}/${student["Assignment_Task_Total Marks"]}</span>
                            <span class="text-sm ${student["Assignment_Task_Percentage"] < 50 ? 'text-red-500' : 'text-blue-500'}">
                                ${student["Assignment_Task_Percentage"]}%
                            </span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex flex-col items-center">
                            <span>${student["Quiz_Task_Obtained Marks"]}/${student["Quiz_Task_Total Marks"]}</span>
                            <span class="text-sm ${student["Quiz_Task_Percentage"] < 50 ? 'text-red-500' : 'text-blue-500'}">
                                ${student["Quiz_Task_Percentage"]}%
                            </span>
                        </div>
                    </td>
                    ${!isNonLab ? `
                    <td class="px-4 py-3 text-center">
                        <div class="flex flex-col items-center">
                            <span>${student["Lab_Task_Obtained Marks"]}/${student["Lab_Task_Total Marks"]}</span>
                            <span class="text-sm ${student["Lab_Task_Percentage"] < 50 ? 'text-red-500' : 'text-blue-500'}">
                                ${student["Lab_Task_Percentage"]}%
                            </span>
                        </div>
                    </td>` : ''}
                    <td class="px-4 py-3 text-center font-semibold ${percentageClass}">
                        <div class="flex flex-col items-center">
                            <span>${student["Overall_Obtained_Marks"]}/${student["Overall_Total_Marks"]}</span>
                            <span>${overallPercentage}%</span>
                            <div class="progress-bar w-20 mt-1">
                                <div class="progress-fill ${overallPercentage < 50 ? 'bg-red-500' : 'bg-green-500'}" 
                                     style="width: ${overallPercentage}%"></div>
                            </div>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });

            // Setup search
            document.getElementById("taskSearch").addEventListener("input", function() {
                const searchValue = this.value.toLowerCase();
                filteredtaskResultData = taskResultsData.filter(student =>
                    student.Student_name.toLowerCase().includes(searchValue) || 
                    student.RegNo.toLowerCase().includes(searchValue)
                );
                renderTaskResults();
            });

            // Setup sorting
            let isSortedDescending = false;
            document.getElementById("sortTaskButton").addEventListener("click", () => {
                filteredtaskResultData.sort((a, b) => {
                    const aPercentage = parseFloat(a["Overall_Percentage"]) || 0;
                    const bPercentage = parseFloat(b["Overall_Percentage"]) || 0;
                    return isSortedDescending ? aPercentage - bPercentage : bPercentage - aPercentage;
                });
                isSortedDescending = !isSortedDescending;
                renderTaskResults();
            });
        }

        // Exam Results Data
        let examData = [];
        let filteredExamData = [];

        async function fetchExamResults() {
            const teacherOfferedCourseId = `{{ $course['t_offered_course_id'] }}`;
            
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(
                    `${API_BASE_URL}api/Teachers/get-exam-result?teacher_offered_course_id=${teacherOfferedCourseId}`
                );

                if (!response.ok) throw new Error("Failed to fetch exam results");

                const result = await response.json();
                examData = result.students || [];
                filteredExamData = [...examData];
                renderExamResults();

            } catch (error) {
                console.error("Error fetching exam results:", error);
                document.getElementById("examResults").innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        Failed to load exam results
                    </div>`;
            }
        }

        function renderExamResults() {
            const examType = document.getElementById("examFilter").value;
            const resultsDiv = document.getElementById("examResults");
            
            if (filteredExamData.length === 0) {
                resultsDiv.innerHTML = `<div class="text-center py-8 text-gray-500">No exam results found</div>`;
                return;
            }

            resultsDiv.innerHTML = "";
            
            filteredExamData.forEach(student => {
                if (student["Exam Results"] && student["Exam Results"][examType]) {
                    const exam = student["Exam Results"][examType];
                    const percentage = parseFloat(exam.Percentage) || 0;
                    const percentageClass = percentage < 50 ? 'text-red-600' : 'text-green-600';
                    
                    const questionRows = exam.Questions.map(q => `
                        <tr class="text-center">
                            <td class="border border-gray-200 px-4 py-2">${q["Question No"]}</td>
                            <td class="border border-gray-200 px-4 py-2">${q["Total Marks"]}</td>
                            <td class="border border-gray-200 px-4 py-2">${q["Obtained Marks"]}</td>
                        </tr>
                    `).join('');

                    const examCard = document.createElement('div');
                    examCard.className = 'card p-6 mb-4';
                    examCard.innerHTML = `
                        <div class="flex flex-col md:flex-row gap-6 mb-6">
                            <div class="flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name=${student.name}&background=random" 
                                     alt="Student" class="avatar">
                            </div>
                            <div class="flex-grow">
                                <h3 class="text-lg font-semibold text-gray-900">${student.name}</h3>
                                <p class="text-gray-500 mb-4">${student.RegNo}</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="text-sm text-gray-500">Total Marks</p>
                                        <p class="font-medium">${exam["Total Obtained Marks"]}/${exam["Total Marks"]}</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="text-sm text-gray-500">Solid Marks</p>
                                        <p class="font-medium">${exam["Total Solid Obtained Marks"]}/${exam["Solid Marks"]}</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="text-sm text-gray-500">Percentage</p>
                                        <p class="font-medium ${percentageClass}">${exam.Percentage}%</p>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Question-wise Breakdown</h4>
                                    <div class="overflow-x-auto">
                                        <table class="w-full border-collapse border border-gray-200">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="border border-gray-200 px-4 py-2">Q No</th>
                                                    <th class="border border-gray-200 px-4 py-2">Total Marks</th>
                                                    <th class="border border-gray-200 px-4 py-2">Obtained Marks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${questionRows}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    resultsDiv.appendChild(examCard);
                }
            });

            // Setup search
            document.getElementById("examSearchInput").addEventListener("input", function() {
                const query = this.value.toLowerCase();
                filteredExamData = examData.filter(student =>
                    student.name.toLowerCase().includes(query) ||
                    student.RegNo.toLowerCase().includes(query)
                );
                renderExamResults();
            });

            // Setup exam type filter
            document.getElementById("examFilter").addEventListener("change", renderExamResults);
        }

        // Initialize the page
        document.addEventListener("DOMContentLoaded", function() {
            // Show attendance tab by default
            showTab('attendance');
        });
    </script>
</body>

</html>