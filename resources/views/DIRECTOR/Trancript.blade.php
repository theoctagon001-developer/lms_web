<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Dashboard - Student Profile</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        .sticky-top-container {
            position: sticky;
            top: 0;
            z-index: 50;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .sticky-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: white;
        }
        .profile-card {
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .profile-image {
            border: 4px solid #3b82f6;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3), 0 2px 4px -1px rgba(59, 130, 246, 0.1);
        }
        .tab-button {
            transition: all 0.3s ease;
            position: relative;
        }
        .tab-button:after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 3px;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }
        .tab-button.active {
            color: #3b82f6;
        }
        .tab-button.active:after {
            width: 100%;
        }
        .footer {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 1.5rem 0;
            margin-top: 2rem;
        }
        .footer-copyright {
            text-align: center;
            font-size: 0.875rem;
            opacity: 0.9;
        }
        .session-header {
            background: linear-gradient(to right,rgb(233, 238, 245),rgb(212, 215, 221));
            color: white;
            transition: all 0.3s ease;
        }
        .session-header:hover {
            background: linear-gradient(to right,rgb(205, 210, 219),rgb(217, 218, 223));
        }
        .sticky-top-container {
            position: sticky;
            top: 0;
            z-index: 40;
            background: white;
        }
        .sticky-top-bar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .course-table th {
            background-color: #f1f5f9;
            color: #1e3a8a;
            font-weight: 600;
        }
        .course-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .result-table {
            background-color: #f1f5f9;
            border-radius: 6px;
            overflow: hidden;
        }
        .result-table th {
            background-color: #e2e8f0;
            color: #1e3a8a;
            font-weight: 500;
        }
        .loading-spinner {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            border: 3px solid rgba(59, 130, 246, 0.3);
            border-radius: 50%;
            border-top-color: #3b82f6;
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Header -->
    <div class="sticky-top-container">
        <div class="sticky-top-bar">
            <div class="flex items-center">
                <a href="{{ route('director.dashboard') }}" class="text-xl font-bold text-blue-600">
                    Director <span class="hidden sm:inline"></span>
                </a>
            </div>
            @include('DIRECTOR.Profile')
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow p-4 md:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Profile Card -->
            <div class="profile-card p-6 mb-8">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="flex flex-col items-center">
                        <img src="{{ !empty($student['image']) ? $student['image'] : asset('images/male.png') }}" 
                             alt="Profile Image" 
                             class="w-32 h-32 md:w-40 md:h-40 rounded-full profile-image">
                        <div class="flex gap-3 mt-4">
                            <a href="{{ route('Director.transcript.view', ['student_id' => $student['id']]) }}" 
                               class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                View Transcript
                            </a>
                            <button onclick="downloadTranscript({{ $student['id'] }})" 
                                    class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                                Download
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 md:mt-0">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ $student['name'] }}</h2>
                            <p class="text-gray-600 mb-4">{{ $student['RegNo'] }}</p>
                            
                            <div class="space-y-2">
                                <div class="flex">
                                    <span class="text-gray-700 font-medium w-32">Father's Name:</span>
                                    <span class="text-gray-800">{{ $student['guardian'] }}</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-700 font-medium w-32">CGPA:</span>
                                    <span class="text-gray-800">{{ $student['cgpa'] }}</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-700 font-medium w-32">Gender:</span>
                                    <span class="text-gray-800">{{ $student['gender'] }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex">
                                <span class="text-gray-700 font-medium w-32">Date of Birth:</span>
                                <span class="text-gray-800">{{ $student['date_of_birth'] }}</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-700 font-medium w-32">Program:</span>
                                <span class="text-gray-800">{{ $student['program']['name'] }}</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-700 font-medium w-32">Section:</span>
                                <span class="text-gray-800">{{ $student['section']['semester'] }}{{ $student['section']['group'] }}</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-700 font-medium w-32">Session:</span>
                                <span class="text-gray-800">{{ $student['session']['name'] }} - {{ $student['session']['year'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="flex space-x-8">
                    <button onclick="showTab('current')" 
                            class="tab-button py-4 px-1 text-sm font-medium active">
                        Current Enrollments
                    </button>
                    <button onclick="showTab('previous')" 
                            class="tab-button py-4 px-1 text-sm font-medium">
                        Previous Enrollments
                    </button>
                </nav>
            </div>

            <!-- Current Enrollments Tab -->
            <div id="current" class="tab-content">
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="p-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Registration Form</h3>
                    </div>
                    
                    <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4 bg-blue-50">
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <p class="text-sm text-gray-500">Total Credit Hours</p>
                            <p id="total-credit-hours" class="text-xl font-semibold text-gray-800">0</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <p class="text-sm text-gray-500">Session</p>
                            <p id="current-session" class="text-xl font-semibold text-gray-800">{{ $student['session']['name'] }} - {{ $student['session']['year'] }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <p class="text-sm text-gray-500">Current Section</p>
                            <p id="current-section" class="text-xl font-semibold text-gray-800">N/A</p>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 course-table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course No.</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credits</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Short</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lab</th>
                                </tr>
                            </thead>
                            <tbody id="current-enrollments" class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        <div class="flex justify-center items-center">
                                            <div class="loading-spinner"></div>
                                            <span class="ml-2">Loading current enrollments...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Previous Enrollments Tab -->
            <div id="previous" class="tab-content hidden">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Previous Enrollments</h3>
                        <input type="text" id="searchSessions" 
                               class="px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="Search by Session...">
                    </div>
                    
                    <div id="previousEnrollmentsContainer" class="p-4 space-y-4">
                        <div class="flex justify-center items-center py-8">
                            <div class="loading-spinner"></div>
                            <span class="ml-2">Loading previous enrollments...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container mx-auto px-4">
            <div class="footer-content">
                <div class="footer-copyright">
                    © Sharjeel | Ali | Sameer Learning Management System
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Global variables
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/"; // Default fallback
        let currentStudentId = {{ $student['id'] }};

        // Initialize the page
        document.addEventListener("DOMContentLoaded", function() {
            initializePage();
        });

        async function initializePage() {
            try {
                // First get the API base URL
                API_BASE_URL = await getApiBaseUrl();
                console.log("Using API base URL:", API_BASE_URL);
                
                // Then load the student data
                await fetchAllEnrollments(currentStudentId);
                
                // Set the first tab as active initially
                document.querySelector('.tab-button').classList.add('active', 'text-blue-600');
                document.querySelector('.tab-button').classList.remove('text-gray-500');
            } catch (error) {
                console.error("Initialization error:", error);
                showErrorStates("Failed to initialize page");
            }
        }

        // Get the API base URL from server configuration
        async function getApiBaseUrl() {
            try {
                const response = await fetch('/get-api-url');
                if (!response.ok) {
                    throw new Error('Failed to fetch API URL');
                }
                const data = await response.json();
                return data.api_base_url;
            } catch (error) {
                console.warn("Using default API URL due to error:", error);
                return API_BASE_URL; // Return the default URL
            }
        }

        async function fetchAllEnrollments(studentId) {
            try {
                showLoadingStates();
                
                const response = await fetch(`${API_BASE_URL}api/Students/getAllEnrollments?student_id=${studentId}`);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log("API Response:", data);

                if (data.success) {
                    processResponseData(data);
                } else {
                    throw new Error(data.message || "API returned unsuccessful response");
                }
            } catch (error) {
                console.error("Fetch error:", error);
                showErrorStates(error.message);
            }
        }

        function showLoadingStates() {
            document.getElementById("current-enrollments").innerHTML = 
                `<tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">
                    <div class="flex justify-center items-center">
                        <div class="loading-spinner"></div>
                        <span class="ml-2">Loading data...</span>
                    </div>
                </td></tr>`;
            document.getElementById("previousEnrollmentsContainer").innerHTML = 
                `<div class="flex justify-center items-center py-8">
                    <div class="loading-spinner"></div>
                    <span class="ml-2">Loading data...</span>
                </div>`;
        }

        function processResponseData(data) {
            // Process current enrollments
            if (data.CurrentCourses && data.CurrentCourses.length > 0) {
                displayCurrentEnrollments(data.CurrentCourses);
            } else {
                document.getElementById("current-enrollments").innerHTML = 
                    `<tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">No current enrollments found.</td></tr>`;
            }

            // Process previous enrollments
            if (data.PreviousCourses && Object.keys(data.PreviousCourses).length > 0) {
                renderPreviousEnrollments(data.PreviousCourses);
            } else {
                document.getElementById("previousEnrollmentsContainer").innerHTML = 
                    `<div class="text-center p-8 text-gray-500">No previous enrollments found.</div>`;
            }
        }

        function showErrorStates(errorMessage) {
            document.getElementById("current-enrollments").innerHTML = 
                `<tr><td colspan="8" class="px-6 py-4 text-center text-red-500">Error: ${errorMessage}</td></tr>`;
            document.getElementById("previousEnrollmentsContainer").innerHTML = 
                `<div class="text-center p-8 text-red-500">Error: ${errorMessage}</div>`;
        }

        function displayCurrentEnrollments(courses) {
            let totalCreditHours = 0;
            let sectionCounts = {};

            const tableBody = document.getElementById("current-enrollments");
            tableBody.innerHTML = "";

            courses.forEach(course => {
                totalCreditHours += course.credit_hours;

                if (sectionCounts[course.section]) {
                    sectionCounts[course.section]++;
                } else {
                    sectionCounts[course.section] = 1;
                }

                tableBody.innerHTML += `
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${course.course_code}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${course.credit_hours}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">${course.course_name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${course.section}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${course["Short Form"]}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${course["Type"]}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">${course.teacher_name}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">${course.junior_lecturer_name}</td>
                    </tr>
                `;
            });

            let mostFrequentSection = Object.keys(sectionCounts).reduce((a, b) => 
                sectionCounts[a] > sectionCounts[b] ? a : b, "");

            document.getElementById("total-credit-hours").textContent = totalCreditHours;
            document.getElementById("current-section").textContent = mostFrequentSection || "N/A";
        }

        function renderPreviousEnrollments(enrollments) {
            const container = document.getElementById("previousEnrollmentsContainer");
            container.innerHTML = "";

            if (Object.keys(enrollments).length === 0) {
                container.innerHTML = `<div class="text-center p-8 text-gray-500">No previous enrollment records available.</div>`;
                return;
            }

            Object.keys(enrollments).forEach(session => {
                const courses = enrollments[session];
                const totalCreditHours = courses.reduce((sum, course) => sum + course.credit_hours, 0);
                const sessionId = session.replace(/\s+/g, '');

                let sessionHTML = `
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <button class="w-full text-left px-4 py-3 session-header flex justify-between items-center" 
                                onclick="toggleSession('${sessionId}')">
                            <div>
                                <span class="font-semibold">${session}</span>
                                <span class="text-sm opacity-90 ml-2">(Total Credits: ${totalCreditHours})</span>
                            </div>
                            <svg class="w-5 h-5 transform transition-transform" id="${sessionId}-icon" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div id="${sessionId}" class="hidden p-4 bg-gray-50">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credits</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Result</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                `;

                courses.forEach(course => {
                    let resultInfo = course["result Info"];
                    let resultBadge = `<span class="inline-block px-2 py-1 text-xs rounded bg-gray-200 text-gray-800">N/A</span>`;

                    if (typeof resultInfo === "object" && resultInfo.grade) {
                        const grade = resultInfo.grade.toUpperCase();
                        let bgColor = 'bg-gray-200';
                        let textColor = 'text-gray-800';
                        
                        if (['A', 'A+', 'A-'].includes(grade)) bgColor = 'bg-green-100 text-green-800';
                        else if (['B', 'B+', 'B-'].includes(grade)) bgColor = 'bg-blue-100 text-blue-800';
                        else if (['C', 'C+', 'C-'].includes(grade)) bgColor = 'bg-yellow-100 text-yellow-800';
                        else if (['D', 'F'].includes(grade)) bgColor = 'bg-red-100 text-red-800';
                        
                        resultBadge = `
                            <div class="flex items-center space-x-2">
                                <span class="inline-block px-2 py-1 text-xs rounded ${bgColor}">${grade}</span>
                                <button onclick="showResultDetails(this)" 
                                        class="text-xs text-blue-600 hover:text-blue-800 focus:outline-none"
                                        data-mid="${resultInfo.mid || 'N/A'}"
                                        data-final="${resultInfo.final || 'N/A'}"
                                        data-internal="${resultInfo.internal || 'N/A'}"
                                        data-lab="${resultInfo.lab || 'N/A'}"
                                        data-grade="${resultInfo.grade || 'N/A'}"
                                        data-qp="${resultInfo.quality_points || 'N/A'}">
                                    Details
                                </button>
                            </div>
                        `;
                    }

                    sessionHTML += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">${course.course_name}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${course.course_code}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${course.credit_hours}</td>
                            <td class="px-4 py-3 text-sm">${resultBadge}</td>
                        </tr>
                    `;
                });

                sessionHTML += `</tbody></table></div></div></div>`;
                container.innerHTML += sessionHTML;
            });
        }

        function toggleSession(sessionId) {
            const sessionDiv = document.getElementById(sessionId);
            const icon = document.getElementById(`${sessionId}-icon`);
            
            sessionDiv.classList.toggle("hidden");
            icon.classList.toggle("rotate-180");
        }

        function showTab(tab) {
            document.getElementById('current').classList.add('hidden');
            document.getElementById('previous').classList.add('hidden');
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active', 'text-blue-600');
                btn.classList.add('text-gray-500');
            });

            document.getElementById(tab).classList.remove('hidden');
            event.currentTarget.classList.add('active', 'text-blue-600');
            event.currentTarget.classList.remove('text-gray-500');
        }

        function showResultDetails(button) {
            const mid = button.getAttribute('data-mid');
            const final = button.getAttribute('data-final');
            const internal = button.getAttribute('data-internal');
            const lab = button.getAttribute('data-lab');
            const grade = button.getAttribute('data-grade');
            const qp = button.getAttribute('data-qp');
            
            const detailsHtml = `
                <div class="absolute z-10 mt-2 w-64 bg-white rounded-md shadow-lg p-4 border border-gray-200">
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <span class="font-medium">Mid:</span><span>${mid}</span>
                        <span class="font-medium">Final:</span><span>${final}</span>
                        <span class="font-medium">Internal:</span><span>${internal}</span>
                        <span class="font-medium">Lab:</span><span>${lab}</span>
                        <span class="font-medium">Grade:</span><span>${grade}</span>
                        <span class="font-medium">QP:</span><span>${qp}</span>
                    </div>
                </div>
            `;
            
            // Remove any existing details popup
            document.querySelectorAll('.result-details-popup').forEach(el => el.remove());
            
            // Create and append new popup
            const popup = document.createElement('div');
            popup.className = 'result-details-popup';
            popup.innerHTML = detailsHtml;
            button.parentNode.appendChild(popup);
            
            // Close popup when clicking elsewhere
            setTimeout(() => {
                document.addEventListener('click', function closePopup(e) {
                    if (!button.parentNode.contains(e.target)) {
                        popup.remove();
                        document.removeEventListener('click', closePopup);
                    }
                });
            }, 0);
        }

        async function downloadTranscript(studentId) {
            try {
                const API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Students/TranscriptPDF?student_id=${studentId}`);

                if (!response.ok) {
                    throw new Error("Failed to fetch transcript.");
                }

                const blob = await response.blob();
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = `Transcript_${studentId}.pdf`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                URL.revokeObjectURL(link.href);
            } catch (error) {
                console.error("Error downloading transcript:", error);
                alert("Failed to download transcript. Please try again later.");
            }
        }

        // Search Functionality
        document.getElementById("searchSessions").addEventListener("input", function() {
            let filter = this.value.toLowerCase();
            document.querySelectorAll(".bg-white.rounded-lg").forEach(session => {
                let sessionName = session.querySelector("button").innerText.toLowerCase();
                session.style.display = sessionName.includes(filter) ? "" : "none";
            });
        });
    </script>
</body>
</html>